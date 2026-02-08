<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products to avoid unique constraint collisions during seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Product::factory()->count(25)->create();
    }
}
