<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order')->get();
        $types = ['framework', 'language', 'topic', 'tool']; // Ваши типы
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
            'color' => '#6e3aff',
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
            'html' => view('admin.categories.row', ['category' => $category])->render()
        ]);
    }
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:framework,language,topic,tool',
            'color' => 'sometimes|string'
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id, // <- Это обязательно!
                'name' => $category->name,
                'type' => $category->type,
                'color' => $category->color
            ]
        ]);
    }
}
