<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Príchuť produktu (napr. Mint, Mango, Cola).
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 */
#[Fillable(['name', 'slug'])]
class Flavor extends Model
{
    /**
     * Produkty dostupné v tejto príchuti (M:N cez pivot "product_flavor").
     *
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_flavor')->withTimestamps();
    }
}
