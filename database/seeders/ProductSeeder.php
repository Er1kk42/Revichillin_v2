<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Killa Mint',
            'slug' => 'killa-mint',
            'price' => 4.99,
            'description' => 'Osviežujúca mätová príchuť',
            'image' => 'KillaColdMint.png',
            'stock' => 50,
            'nicotine_strength' => 12,
            'brand_id' => 5,
            'product_type_id' => 1,
        ]);

        Product::create([
            'name' => 'VELO Citrus',
            'slug' => 'velo-citrus',
            'price' => 4.50,
            'description' => 'Sviežia citrusová chuť',
            'stock' => 30,
            'nicotine_strength' => 6,
            'brand_id' => 1,
            'product_type_id' => 1,
        ]);
    }
}
