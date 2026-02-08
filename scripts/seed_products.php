<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Product;

// Clear products (disable FK checks for safety)
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Product::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// Create test products
Product::factory()->count(25)->create();

echo "Product seeding completed.\n";
