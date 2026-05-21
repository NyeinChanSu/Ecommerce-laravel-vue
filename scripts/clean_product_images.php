<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::all();

$updated = 0;
$removedCount = 0;

foreach ($products as $product) {
    $images = $product->images ?? [];
    if (!is_array($images)) continue;

    $originalCount = count($images);
    // remove external URLs (http/https) and empty values
    $filtered = array_values(array_filter(array_map('trim', $images), function ($v) {
        if ($v === null || $v === '') return false;
        return !preg_match('#^https?://#i', $v);
    }));

    // dedupe
    $filtered = array_values(array_unique($filtered));

    $newCount = count($filtered);
    if ($newCount !== $originalCount) {
        $product->images = $newCount ? $filtered : null;
        $product->save();
        $updated++;
        $removedCount += ($originalCount - $newCount);
        echo "Updated product {$product->id}: removed " . ($originalCount - $newCount) . " external image(s)\n";
    }
}

echo "Done. Products updated: {$updated}. Total external images removed: {$removedCount}\n";
