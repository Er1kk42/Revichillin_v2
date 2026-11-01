<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            FlavorSeeder::class,
            ProductTypeSeeder::class,
            CategorySeeder::class,
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

        $this->call(OrderSeeder::class);
    }
}
