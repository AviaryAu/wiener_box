<?php

namespace App\Models;

use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /** @use HasFactory<RecipeFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['ingredients' => 'array', 'method' => 'array', 'published' => 'boolean', 'featured' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    /**
     * @return array{id: int, slug: string, url: string, title: string, category: string, description: string, image: string, imageAlt: string, prepMinutes: int, cookMinutes: int, totalMinutes: int, servings: int, ingredients: list<string>, method: list<string>, tip: string, featured: bool}
     */
    public function storefrontData(): array
    {
        return [
            'id' => $this->id, 'slug' => $this->slug,
            'url' => route('recipes.show', $this, absolute: false),
            'title' => $this->title, 'category' => $this->category,
            'description' => $this->description, 'image' => $this->image, 'imageAlt' => $this->image_alt,
            'prepMinutes' => $this->prep_minutes, 'cookMinutes' => $this->cook_minutes,
            'totalMinutes' => $this->prep_minutes + $this->cook_minutes,
            'servings' => $this->servings, 'ingredients' => $this->ingredients,
            'method' => $this->method, 'tip' => $this->tip, 'featured' => $this->featured,
        ];
    }
}
