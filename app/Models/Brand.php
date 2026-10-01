<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Značka / výrobca produktu (napr. VELO, IQOS, Marlboro).
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 */
#[Fillable(['name', 'slug'])]
class Brand extends Model
{
    /**
     * Produkty patriace pod túto značku.
     *
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
