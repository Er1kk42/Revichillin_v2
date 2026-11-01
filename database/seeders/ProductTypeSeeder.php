<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
