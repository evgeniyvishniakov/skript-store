<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Просто получаем все категории без пагинации

        $types = ['framework', 'language', 'topic', 'tool'];
        return view('admin.categories.categories', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:framework,language,topic,tool'
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'type' => $validated['type'],
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
            'html' => view('admin.categories.row', compact('category'))->render()
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:framework,language,topic,tool'
        ]);

        $category->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }
}
