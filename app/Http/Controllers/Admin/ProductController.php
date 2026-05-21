<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display a listing of products
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|string',
            'images_files.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // handle uploaded files
        $uploaded = [];
        if ($request->hasFile('images_files')) {
            foreach ($request->file('images_files') as $file) {
                $uploaded[] = $file->store('products', 'public');
            }
        }

        $textImages = $request->input('images') ? array_values(array_filter(array_map('trim', explode(',', $request->input('images'))))) : [];

        $images = array_values(array_filter(array_merge($textImages, $uploaded)));
        // remove duplicate paths, preserve order
        $images = array_values(array_unique($images));

        $validated['images'] = count($images) ? $images : null;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|string',
            'images_files.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // handle uploaded files
        $uploaded = [];
        if ($request->hasFile('images_files')) {
            foreach ($request->file('images_files') as $file) {
                $uploaded[] = $file->store('products', 'public');
            }
        }

        $textImages = $request->input('images') ? array_values(array_filter(array_map('trim', explode(',', $request->input('images'))))) : [];

        // existing images on product
        $existing = $product->images ?? [];

        // images marked for removal
        $toRemove = $request->input('remove_images', []);
        if (!empty($toRemove)) {
            foreach ($toRemove as $path) {
                // delete file from storage if exists
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            // filter out removed images from existing
            $existing = array_values(array_diff($existing, $toRemove));
        }

        $images = array_values(array_filter(array_merge($existing, $textImages, $uploaded)));
        // remove duplicate paths, preserve order
        $images = array_values(array_unique($images));

        $validated['images'] = count($images) ? $images : null;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}

