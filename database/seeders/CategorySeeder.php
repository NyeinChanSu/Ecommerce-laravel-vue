<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronics and gadgets.',
            'parent_id' => null,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'description' => 'Smartphones, cases, and accessories.',
            'parent_id' => $electronics->id,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Computers & Tablets',
            'slug' => 'computers-tablets',
            'description' => 'Laptops, tablets, and computer accessories.',
            'parent_id' => $electronics->id,
            'position' => null,
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Clothing, shoes, and accessories.',
            'parent_id' => null,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Men\'s Fashion',
            'slug' => 'mens-fashion',
            'description' => 'Men\'s clothing and accessories.',
            'parent_id' => $fashion->id,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Women\'s Fashion',
            'slug' => 'womens-fashion',
            'description' => 'Women\'s clothing and accessories.',
            'parent_id' => $fashion->id,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home goods, furniture, and garden supplies.',
            'parent_id' => null,
            'position' => null,
        ]);

        Category::create([
            'name' => 'Sports',
            'slug' => 'sports',
            'description' => 'Sporting goods and outdoor gear.',
            'parent_id' => null,
            'position' => null,
        ]);
    }
}
