<?php

namespace App\Http\Controllers;


use App\Models\admin\Category;
use App\Models\admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Отображение списка всех товаров
     */
    public function adminindex(Request $request)
    {
        $query = Product::query()->with(['category', 'author']);

        // Фильтрация
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Сортировка
        $sortField = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortField, $sortOrder);

        $products = $query->paginate(15);

        $categories = Category::all();

        return view('admin.products.products', compact('products', 'categories'));
    }

    /**
     * Отображение формы для создания нового товара
     */
    public function create()
    {
        $categories = Category::all();
        $platforms = ['Laravel', 'WordPress', 'React', 'Vue', 'Angular', 'Bootstrap', 'Tailwind', 'Другое'];
        $types = ['script', 'plugin', 'theme', 'library', 'template'];

        return view('admin.products.create', compact('categories', 'platforms', 'types'));
    }

    /**
     * Сохранение нового товара в базе данных
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Product();
        $this->saveProductData($product, $request);

        return redirect()->route('products.show', $product)
            ->with('success', 'Товар успешно создан!');
    }

    /**
     * Отображение информации о конкретном товаре
     */
    public function show(Product $product)
    {
        $product->load(['category', 'author']);
        return view('products.show', compact('product'));
    }

    /**
     * Отображение формы для редактирования товара
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $platforms = ['Laravel', 'WordPress', 'React', 'Vue', 'Angular', 'Bootstrap', 'Tailwind', 'Другое'];
        $types = ['script', 'plugin', 'theme', 'library', 'template'];

        return view('products.edit', compact('product', 'categories', 'platforms', 'types'));
    }

    /**
     * Обновление информации о товаре в базе данных
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), $this->validationRules($product->id));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->saveProductData($product, $request);

        return redirect()->route('products.show', $product)
            ->with('success', 'Товар успешно обновлен!');
    }

    /**
     * Удаление товара из базы данных
     */
    public function destroy(Product $product)
    {
        // Удаление связанных файлов
        if ($product->cover_image) {
            Storage::delete('public/' . $product->cover_image);
        }

        if ($product->gallery) {
            foreach (json_decode($product->gallery) as $image) {
                Storage::delete('public/' . $image);
            }
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Товар успешно удален!');
    }

    /**
     * Правила валидации для создания и обновления товара
     */
    private function validationRules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($id)],
            'type' => 'required|in:script,plugin,theme,library,template',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'features' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'pricing_tiers' => 'nullable|array',
            'license' => 'required|string|max:255',
            'platform' => 'nullable|string|max:255',
            'compatibility' => 'nullable|array',
            'dependencies' => 'nullable|array',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'demo_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'product_file' => 'required|file|mimes:zip,rar|max:51200',
        ];
    }

    /**
     * Сохранение данных товара
     */
    private function saveProductData(Product $product, Request $request)
    {
        $product->name = $request->name;
        $product->slug = $request->slug ?? Str::slug($request->name);
        $product->type = $request->type;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->features = $request->features ? json_encode($request->features) : null;
        $product->price = $request->price;
        $product->pricing_tiers = $request->pricing_tiers ? json_encode($request->pricing_tiers) : null;
        $product->license = $request->license;
        $product->platform = $request->platform;
        $product->compatibility = $request->compatibility ? json_encode($request->compatibility) : null;
        $product->dependencies = $request->dependencies ? json_encode($request->dependencies) : null;

        // Загрузка обложки
        if ($request->hasFile('cover_image')) {
            // Удаляем старое изображение, если оно есть
            if ($product->cover_image) {
                Storage::delete('public/' . $product->cover_image);
            }

            $path = $request->file('cover_image')->store('products/covers', 'public');
            $product->cover_image = $path;
        }

        // Загрузка галереи
        if ($request->hasFile('gallery')) {
            $gallery = [];
            $existingGallery = $product->gallery ? json_decode($product->gallery, true) : [];

            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $gallery[] = $path;
            }

            $product->gallery = json_encode(array_merge($existingGallery, $gallery));
        }

        // Загрузка файла товара
        if ($request->hasFile('product_file')) {
            $file = $request->file('product_file');

            // Удаляем старый файл, если он есть
            if ($product->file_path) {
                Storage::delete($product->file_path);
            }

            $path = $file->store('products/files');

            $product->update([
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'original_filename' => $file->getClientOriginalName()
            ]);
        }

        $product->demo_url = $request->demo_url;
        $product->video_url = $request->video_url;
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');
        $product->published_at = $request->published_at;
        $product->category_id = $request->category_id;
        $product->author_id = auth()->id(); // Текущий пользователь как автор

        $product->save();

        return $product;
    }

    /**
     * Удаление изображения из галереи
     */
    public function removeGalleryImage(Request $request, Product $product)
    {
        $imagePath = $request->image_path;
        $gallery = json_decode($product->gallery, true) ?? [];

        if (($key = array_search($imagePath, $gallery)) !== false) {
            Storage::delete('public/' . $imagePath);
            unset($gallery[$key]);
            $product->gallery = json_encode(array_values($gallery));
            $product->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function download(Product $product)
    {
        if (!Storage::exists($product->file_path)) {
            abort(404);
        }

        return Storage::download($product->file_path, $product->original_filename);
    }
}
