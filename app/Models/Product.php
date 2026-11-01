<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * Produkt e-shopu s nikotínovými produktmi.
 *
 * @property int $id
 * @property string $name
 * @property string $price decimal(8,2)
 * @property string|null $description
 * @property string|null $image názov súboru v public/img/products
 * @property-read string|null $image_url celá URL obrázka (null, ak produkt obrázok nemá)
 * @property int $stock
 * @property int|null $nicotine_strength obsah nikotínu v mg (null = bez nikotínu)
 * @property int|null $brand_id
 * @property int $product_type_id
 */
#[Fillable([
    'name',
    'price',
    'description',
    'image',
    'stock',
    'nicotine_strength',
    'brand_id',
    'product_type_id',
])]
class Product extends Model
{
    /**
     * Pretypovanie stĺpcov na natívne PHP typy.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'nicotine_strength' => 'integer',
        ];
    }

    /**
     * Značka produktu (voliteľná).
     *
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Typ produktu (povinný – "Nikotínové vrecká", "Tabak", ...).
     *
     * @return BelongsTo<ProductType, $this>
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Príchute, v ktorých je produkt dostupný (M:N cez pivot "product_flavor").
     *
     * @return BelongsToMany<Flavor, $this>
     */
    public function flavors(): BelongsToMany
    {
        return $this->belongsToMany(Flavor::class, 'product_flavor')->withTimestamps();
    }

    /**
     * Marketingové kategórie produktu (M:N cez pivot "product_category").
     *
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category')->withTimestamps();
    }

    /**
     * @return HasMany<Review, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * URL obrázka produktu. Cestu berieme z disku "products" (config/filesystems.php),
     * na ktorý obrázky ukladá aj admin (Filament) – adresa je tak na jednom mieste.
     * Vo view: $product->image_url
     *
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? Storage::disk('products')->url($this->image) : null);
    }
}
