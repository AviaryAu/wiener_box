<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lunar\Models\Product;

class ProductListing extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['highlights' => 'array', 'contents' => 'array', 'featured' => 'boolean', 'published' => 'boolean'];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true)->whereHas('product', fn (Builder $product) => $product->where('status', 'published'));
    }

    public function storefrontData(): array
    {
        $variant = $this->product->variants->first();
        $price = $variant?->prices->first(fn ($price) => $price->currency->code === 'AUD' && $price->min_quantity === 1 && $price->customer_group_id === null);

        return [
            'id' => $this->id, 'slug' => $this->slug,
            'name' => $this->product->translateAttribute('name'),
            'description' => strip_tags($this->product->translateAttribute('description') ?? ''),
            'price' => $price?->price->value,
            'category' => $this->category, 'eyebrow' => $this->eyebrow,
            'colour' => $this->colour, 'cadence' => $this->cadence,
            'story' => $this->story, 'contents' => $this->contents,
            'highlights' => $this->highlights, 'featured' => $this->featured,
        ];
    }
}
