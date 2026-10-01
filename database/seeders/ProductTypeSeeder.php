<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Naplní tabuľku "product_types" štyrmi základnými typmi produktov.
 */
class ProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Nikotínové vrecká',
            'Elektronické cigarety',
            'Tabak',
            'Cigarety',
        ];

        foreach ($types as $name) {
            ProductType::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
