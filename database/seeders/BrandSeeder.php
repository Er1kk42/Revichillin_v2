<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Naplní tabuľku "brands" ukážkovými značkami na testovanie.
 */
class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'VELO',
            'IQOS',
            'Marlboro',
            'ELF BAR',
            'Killa'
        ];

        foreach ($brands as $name) {
            // updateOrCreate podľa slug => seeder sa dá spustiť opakovane bez duplikátov
            Brand::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
