<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title' => fake()->sentence(4),
            'category' => 'Sides',
            'description' => fake()->paragraph(),
            'image' => '/images/food/potato-salad.webp',
            'image_alt' => 'Warm German potato salad with chives',
            'prep_minutes' => 10,
            'cook_minutes' => 20,
            'servings' => 4,
            'ingredients' => ['500 g waxy potatoes', '1 tbsp mustard'],
            'method' => ['Boil the potatoes until tender.', 'Slice and toss with mustard.'],
            'tip' => 'Serve warm with your favourite sausages.',
            'published' => true,
            'featured' => false,
            'position' => 0,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => ['published' => false]);
    }
}
