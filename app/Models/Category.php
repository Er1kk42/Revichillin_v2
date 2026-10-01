<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Marketingová / prierezová kategória (napr. "Akcia", "Novinky", "Výpredaj").
 *
 * Produkt môže patriť do viacerých kategórií naraz – na rozdiel od ProductType,
 * ktorý má produkt práve jeden.
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 */
#[Fillable(['name', 'slug'])]
class Category extends Model
{
    /**
     * Produkty zaradené v tejto kategórii (M:N cez pivot "product_category").
     *
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category')->withTimestamps();
    }
}
