<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderSeeder extends Seeder
{
    private array $orders = [
        [
            'order_number' => 1,
            'user' => 'test@example.com',
            'date' => '2026-10-15 14:30',
            'items' => [
                ['product' => 'Blu Bar Banana Ice', 'quantity' => 2],
                ['product' => 'Kurwa Grape', 'quantity' => 1],
            ],
        ],
        [
            'order_number' => 2,
            'user' => 'test@example.com',
            'date' => '2026-10-15 15:30',
            'items' => [
                ['product' => 'Pablo Mini Ice Cold', 'quantity' => 5],
                ['product' => 'Kurwa Grape', 'quantity' => 7],
                ['product' => 'Velo Citrus', 'quantity' => 3],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->orders as $data) {
            if (Order::where('order_number', $data['order_number'])->exists()) {
                continue;
            }

            $user = User::where('email', $data['user'])->first()
                ?? throw new RuntimeException("OrderSeeder: používateľ '{$data['user']}' neexistuje.");

            $items = collect($data['items'])->map(function (array $item) {
                $product = Product::where('name', $item['product'])->first()
                    ?? throw new RuntimeException("OrderSeeder: produkt '{$item['product']}' neexistuje (skontroluj názov v ProductSeeder).");

                return [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] ?? $product->price,
                ];
            });

            DB::transaction(function () use ($data, $user, $items) {
                $order = Order::create([
                    'order_number' => $data['order_number'],
                    'user_id' => $user->id,
                    'total_price' => $items->sum(fn (array $item) => $item['price'] * $item['quantity']),
                ]);

                if (isset($data['date'])) {
                    $order->forceFill(['created_at' => $data['date'], 'updated_at' => $data['date']])->save();
                }

                $order->items()->createMany($items->all());
            });

        }
    }
}
