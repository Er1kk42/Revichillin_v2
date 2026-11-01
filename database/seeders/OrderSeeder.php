<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Ukážkové objednávky (tabuľky "orders" + "order_items").
 *
 * Spúšťa sa z DatabaseSeeder AŽ PO vytvorení používateľov a produktov,
 * pretože objednávka na ne odkazuje (cudzie kľúče user_id a product_id).
 * Ručne: php artisan db:seed --class=OrderSeeder
 *
 * Bezpečné spustiť opakovane: objednávka sa hľadá podľa čísla objednávky
 * (order_number je v DB unikátne), existujúca sa druhýkrát nevytvorí.
 */
class OrderSeeder extends Seeder
{
    private array $orders = [
        [
           'order_number' => 1,
           'user' => 'test@example.com',
           'date' => '2026-10-15 14:30',
           'items' => [
               ['product' => 'Blu Bar Banana Ice', 'quantity' => 2],
               ['product' => 'Kurwa Grape', 'quantity' => 1,],
           ],
        ],
        [
            'order_number' => 2,
            'user' => 'test@example.com',
            'date' => '2026-10-15 15:30',
            'items' => [
                ['product' => 'Pablo Mini Ice Cold', 'quantity' => 5],
                ['product' => 'Kurwa Grape', 'quantity' => 7,],
                ['product' => 'Velo Citrus', 'quantity' => 3,],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->orders as $data) {
            // Objednávka s týmto číslom už existuje -> preskočíme ju.
            if (Order::where('order_number', $data['order_number'])->exists()) {
                continue;
            }

            // Používateľa a produkty NEVYTVÁRAME automaticky (na rozdiel od príchutí
            // v ProductSeeder) – preklep v e-maile alebo názve produktu by inak
            // potichu vytvoril nezmyselné dáta. Radšej skončíme so zrozumiteľnou chybou.
            $user = User::where('email', $data['user'])->first()
                ?? throw new RuntimeException("OrderSeeder: používateľ '{$data['user']}' neexistuje.");

            // Pripravíme položky: ku každej nájdeme produkt a určíme cenu za kus.
            $items = collect($data['items'])->map(function (array $item) {
                $product = Product::where('name', $item['product'])->first()
                    ?? throw new RuntimeException("OrderSeeder: produkt '{$item['product']}' neexistuje (skontroluj názov v ProductSeeder).");

                return [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    // Cena sa ukladá ku položke, aby neskoršia zmena ceny produktu
                    // nezmenila sumu už vytvorenej objednávky.
                    'price' => $item['price'] ?? $product->price,
                ];
            });

            // Transakcia = objednávka a jej položky sa uložia buď všetky, alebo žiadne.
            DB::transaction(function () use ($data, $user, $items) {
                $order = Order::create([
                    'order_number' => $data['order_number'],
                    'user_id' => $user->id,
                    // Celková cena = súčet (cena za kus × počet kusov) všetkých položiek.
                    'total_price' => $items->sum(fn (array $item) => $item['price'] * $item['quantity']),
                ]);

                // Vlastný dátum objednávky (created_at nie je vo $fillable, preto forceFill).
                if (isset($data['date'])) {
                    $order->forceFill(['created_at' => $data['date'], 'updated_at' => $data['date']])->save();
                }

                // Položky vytvoríme cez vzťah Order::items() (1:N) – order_id sa doplní sám.
                $order->items()->createMany($items->all());
            });

            // Pozn.: sklad produktov (stock) tu NEZNIŽUJEME – sú to historické ukážkové
            // objednávky a stock v ProductSeeder už predstavuje aktuálny stav skladu.
        }
    }
}
