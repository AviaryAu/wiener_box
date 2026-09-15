<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Database\Seeders\RecipeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config(['inertia.ssr.enabled' => false, 'app.url' => 'https://wiener.example']);
    }

    public function test_collection_shows_published_recipes_in_editorial_order(): void
    {
        $later = Recipe::factory()->create(['position' => 20]);
        $first = Recipe::factory()->create(['position' => 1, 'featured' => true]);
        Recipe::factory()->unpublished()->create(['position' => 0]);

        $this->get('/recipes')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Recipes')->has('recipes', 2)
            ->where('recipes.0.id', $first->id)->where('recipes.0.featured', true)
            ->where('recipes.0.url', '/recipes/'.$first->slug)
            ->where('recipes.1.id', $later->id));
    }

    public function test_collection_can_render_before_recipes_are_published(): void
    {
        $this->get('/recipes')->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Recipes')->has('recipes', 0));
    }

    public function test_recipe_detail_provides_the_full_method_ingredients_and_timings(): void
    {
        $recipe = Recipe::factory()->create(['prep_minutes' => 10, 'cook_minutes' => 25, 'servings' => 4]);

        $this->get('/recipes/'.$recipe->slug)->assertOk()->assertInertia(fn (Assert $page) => $page
            ->component('Recipe')->where('recipe.title', $recipe->title)
            ->where('recipe.ingredients', $recipe->ingredients)->where('recipe.method', $recipe->method)
            ->where('recipe.tip', $recipe->tip)->where('recipe.servings', 4)
            ->where('recipe.prepMinutes', 10)->where('recipe.cookMinutes', 25)
            ->where('recipe.totalMinutes', 35));
    }

    public function test_missing_and_unpublished_recipes_are_not_public(): void
    {
        $recipe = Recipe::factory()->unpublished()->create();

        $this->get('/recipes/'.$recipe->slug)->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('/recipes/missing-recipe')->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_seeding_provides_seven_complete_recipes_and_preserves_owner_edits(): void
    {
        $this->seed(RecipeSeeder::class);

        $this->assertDatabaseCount('recipes', 7);
        $this->assertSame(['Sauces' => 2, 'Sausages' => 3, 'Sides' => 2], Recipe::all()->countBy('category')->sortKeys()->all());
        $featured = Recipe::where('featured', true)->sole();
        $this->assertSame('lemon-mustard-chicken-sausages', $featured->slug);
        $this->assertStringContainsString('chicken sausages', $featured->ingredients[0]);
        foreach (Recipe::all() as $recipe) {
            $this->assertNotEmpty($recipe->ingredients);
            $this->assertNotEmpty($recipe->method);
            $this->assertNotEmpty($recipe->tip);
            $this->assertTrue($recipe->published);
        }
        $featured->update(['title' => 'My edited tray bake', 'published' => false]);

        $this->seed(RecipeSeeder::class);

        $this->assertDatabaseCount('recipes', 7);
        $this->assertSame('My edited tray bake', $featured->fresh()->title);
        $this->assertFalse($featured->fresh()->published);
    }

    public function test_recipe_metadata_and_sitemap_match_the_published_content(): void
    {
        $this->app->instance('env', 'production');
        config(['seo.indexing_enabled' => true]);
        $recipe = Recipe::factory()->create(['prep_minutes' => 5, 'cook_minutes' => 0]);
        $hidden = Recipe::factory()->unpublished()->create();
        $url = 'https://wiener.example/recipes/'.$recipe->slug;

        $response = $this->get($url.'?utm_source=test');

        $response->assertOk()->assertHeader('X-Robots-Tag', 'index, follow, max-image-preview:large');
        $seo = $response->viewData('page')['props']['seo'];
        $this->assertSame($url, $seo['canonical']);
        $this->assertSame($recipe->title.' | Recipes | Wiener Box', $seo['title']);
        $graph = collect(json_decode($seo['structuredData'], true, flags: JSON_THROW_ON_ERROR)['@graph'])->keyBy('@type');
        $this->assertSame($recipe->ingredients, $graph['Recipe']['recipeIngredient']);
        $this->assertSame($recipe->method, array_column($graph['Recipe']['recipeInstructions'], 'text'));
        $this->assertSame('PT5M', $graph['Recipe']['totalTime']);
        $this->assertSame('PT0M', $graph['Recipe']['cookTime']);
        $this->assertSame(['Home', 'Recipes', $recipe->title], array_column($graph['BreadcrumbList']['itemListElement'], 'name'));
        $this->get('https://wiener.example/sitemap.xml')->assertOk()
            ->assertSee('<loc>'.$url.'</loc>', false)
            ->assertDontSee('/recipes/'.$hidden->slug, false);
    }
}
