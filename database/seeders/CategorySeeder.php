<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Naplní tabuľku "categories" ukážkovými marketingovými kategóriami.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Akcia',
            'Novinky',
            'Výpredaj',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
