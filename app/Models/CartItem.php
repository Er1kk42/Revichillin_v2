<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property-read float $total cena položky = cena produktu × množstvo
 */
#[Fillable(['user_id', 'product_id', 'quantity'])]
class CartItem extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Cena položky v košíku (cena produktu × množstvo).
     * Používa sa ako $cartItem->total alebo $cartItems->sum('total'),
     * takže výpočet je na jednom mieste (košík aj objednávka).
     *
     * @return Attribute<float, never>
     */
    protected function total(): Attribute
    {
        return Attribute::get(fn () => $this->product->price * $this->quantity);
    }
}
