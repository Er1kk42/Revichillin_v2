<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Číselníky pre e-shop – bezpečné spustiť opakovane (updateOrCreate podľa slug).
        $this->call([
            BrandSeeder::class,
            FlavorSeeder::class,
            ProductTypeSeeder::class,
            CategorySeeder::class,
            // Produkty až po číselníkoch – odkazujú na typy, značky, príchute a kategórie.
            ProductSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
            ],
        );

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Objednávky až na konci – odkazujú na používateľov aj produkty,
        // ktoré musia v tomto momente už existovať.
        $this->call(OrderSeeder::class);
    }
}
