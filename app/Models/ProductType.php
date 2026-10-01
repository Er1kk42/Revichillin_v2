<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Presný typ produktu – "Nikotínové vrecká", "Elektronické cigarety", "Tabak", "Cigarety".
 *
 * Každý produkt patrí práve do jedného typu (povinný vzťah).
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 */
#[Fillable(['name', 'slug'])]
class ProductType extends Model
{
    /**
     * Produkty tohto typu.
     *
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
