<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'VELO',
            'IQOS',
            'Marlboro',
            'ELF BAR',
            'Killa',
        ];

        foreach ($brands as $name) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
