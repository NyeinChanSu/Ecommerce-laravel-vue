<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $validated['parent_id'] = $request->input('parent_id') ?: null;
        $validated['position'] = null; // will be set in model boot
        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '<>', $category->id)->orderBy('name')->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $validated['parent_id'] = $request->input('parent_id') ?: null;
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function moveUp(Category $category)
    {
        $sibling = Category::where('parent_id', $category->parent_id)
            ->where('position', '<', $category->position)
            ->orderByDesc('position')
            ->first();

        if ($sibling) {
            $tmp = $sibling->position;
            $sibling->position = $category->position;
            $category->position = $tmp;
            $sibling->save();
            $category->save();
        }

        return redirect()->route('admin.categories.index');
    }

    public function moveDown(Category $category)
    {
        $sibling = Category::where('parent_id', $category->parent_id)
            ->where('position', '>', $category->position)
            ->orderBy('position')
            ->first();

        if ($sibling) {
            $tmp = $sibling->position;
            $sibling->position = $category->position;
            $category->position = $tmp;
            $sibling->save();
            $category->save();
        }

        return redirect()->route('admin.categories.index');
    }
}
