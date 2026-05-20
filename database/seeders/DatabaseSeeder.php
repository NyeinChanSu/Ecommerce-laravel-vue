<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        // Seed categories first so products can be assigned to them.
        $this->call(CategorySeeder::class);

        // Seed example products
        $this->call(\Database\Seeders\ProductSeeder::class);
    }
}
