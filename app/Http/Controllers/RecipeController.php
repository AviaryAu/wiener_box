<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Inertia\Inertia;
use Inertia\Response;

class RecipeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Recipes', [
            'recipes' => Recipe::query()->published()->orderBy('position')->orderBy('id')->get()->map->storefrontData(),
        ]);
    }

    public function show(Recipe $recipe): Response
    {
        abort_unless($recipe->published, 404);

        return Inertia::render('Recipe', ['recipe' => $recipe->storefrontData()]);
    }
}
