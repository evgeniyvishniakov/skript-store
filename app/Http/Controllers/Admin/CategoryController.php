<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('type')->get();
        $types = Type::where('scope', 'category')->get();

        return view('admin.categories.categories', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $types = Type::where('scope', 'category')->get();

        $validated = $request->validate([
            'name' => 'required|max:255',
            'type_id' => 'required|exists:types,id'
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'type_id' => $validated['type_id'],
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
            'html' => view('admin.categories.row', compact('category', 'types'))->render()
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id'
        ]);

        $category->update([
            'name' => $validated['name'],
            'type_id' => $validated['type_id'],
            'slug' => Str::slug($validated['name'])
        ]);

        // Перезагружаем связь с type
        $category->load('type');

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'type_id' => $category->type_id,
                'type_label' => $category->type->label, // Явно передаём только label
                'slug' => $category->slug
            ],
            'html' => view('admin.categories.row', [
                'category' => $category
            ])->render()
        ]);
    }

    public function destroy(Category $category)
    {
        $category->forceDelete(); // Полное удаление
        return response()->json(['success' => true]);
    }
}
