<?php

namespace Database\Seeders;

use App\Models\Flavor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Naplní tabuľku "flavors" ukážkovými príchuťami na testovanie.
 */
class FlavorSeeder extends Seeder
{
    public function run(): void
    {
        $flavors = [
            'Mint',
            'Mango',
            'Cola',
            'Watermelon',
            'Tobacco',
        ];

        foreach ($flavors as $name) {
            Flavor::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }
}
