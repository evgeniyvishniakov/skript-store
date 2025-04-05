@extends('admin.layouts.app')

@section('title', 'Добавить товар')
@section('header', 'Добавление нового товара')

@section('content')
    <div class="space-y-6">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Ошибки валидации:</p>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Основная информация -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Основная информация</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Название и Slug -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Название товара *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">URL-адрес</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Оставьте пустым для автоматической генерации</p>
                    </div>

                    <!-- Тип, Категория, Платформа -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Тип товара *</label>
                        <select id="type" name="type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach(['script'=>'Скрипт', 'plugin'=>'Плагин', 'theme'=>'Тема', 'template'=>'Шаблон'] as $value => $label)
                                <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Категория *</label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">Платформа</label>
                        <select id="platform" name="platform"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Не выбрана</option>
                            @foreach(['Laravel', 'WordPress', 'React', 'Vue', 'Angular'] as $platform)
                                <option value="{{ $platform }}" {{ old('platform') == $platform ? 'selected' : '' }}>{{ $platform }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Описание и характеристики -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Описание</h2>
                <div class="space-y-4">
                    <div>
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Краткое описание</label>
                        <textarea id="short_description" name="short_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('short_description') }}</textarea>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Полное описание</label>
                        <textarea id="description" name="description" rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    <!-- Особенности -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Особенности</label>
                        <div id="features-container" class="space-y-2">
                            @if(old('features'))
                                @foreach(old('features') as $feature)
                                    <div class="flex space-x-2">
                                        <input type="text" name="features[]" value="{{ $feature }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-feature">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex space-x-2">
                                    <input type="text" name="features[]" placeholder="Например: Адаптивный дизайн"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-feature">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-feature" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            <i class="fas fa-plus mr-1"></i> Добавить особенность
                        </button>
                    </div>
                </div>
            </div>

            <!-- Цены и лицензия -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Цены и лицензия</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Базовая цена ($) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="license" class="block text-sm font-medium text-gray-700 mb-1">Лицензия *</label>
                        <input type="text" id="license" name="license" value="{{ old('license', 'MIT') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Ценовые планы -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ценовые планы</label>
                        <div id="pricing-tiers-container" class="space-y-2">
                            @if(old('pricing_tiers_name') && old('pricing_tiers_price'))
                                @foreach(old('pricing_tiers_name') as $index => $name)
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 pricing-tier-input">
                                        <div class="md:col-span-5">
                                            <input type="text" name="pricing_tiers_name[]" placeholder="Название плана" value="{{ $name }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div class="md:col-span-5">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" name="pricing_tiers_price[]" placeholder="Цена" value="{{ old('pricing_tiers_price')[$index] ?? '' }}" min="0" step="0.01"
                                                       class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                        </div>
                                        <div class="md:col-span-2">
                                            <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-pricing-tier">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 pricing-tier-input">
                                    <div class="md:col-span-5">
                                        <input type="text" name="pricing_tiers_name[]" placeholder="Название плана"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="md:col-span-5">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">$</span>
                                            </div>
                                            <input type="number" name="pricing_tiers_price[]" placeholder="Цена" min="0" step="0.01"
                                                   class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-pricing-tier">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-pricing-tier" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            <i class="fas fa-plus mr-1"></i> Добавить ценовой план
                        </button>
                    </div>
                </div>
            </div>

            <!-- Технические данные -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Технические данные</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Совместимость -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Совместимость</label>
                        <div id="compatibility-container" class="space-y-2">
                            @if(old('compatibility_name') && old('compatibility_version'))
                                @foreach(old('compatibility_name') as $index => $name)
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-2 compatibility-input">
                                        <div class="md:col-span-5">
                                            <input type="text" name="compatibility_name[]" placeholder="Технология" value="{{ $name }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div class="md:col-span-5">
                                            <input type="text" name="compatibility_version[]" placeholder="Версия" value="{{ old('compatibility_version')[$index] ?? '' }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-compatibility">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 compatibility-input">
                                    <div class="md:col-span-5">
                                        <input type="text" name="compatibility_name[]" placeholder="Технология"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="md:col-span-5">
                                        <input type="text" name="compatibility_version[]" placeholder="Версия"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-compatibility">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-compatibility" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            <i class="fas fa-plus mr-1"></i> Добавить совместимость
                        </button>
                    </div>

                    <!-- Зависимости -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Зависимости</label>
                        <div id="dependencies-container" class="space-y-2">
                            @if(old('dependencies'))
                                @foreach(old('dependencies') as $dependency)
                                    <div class="flex space-x-2">
                                        <input type="text" name="dependencies[]" value="{{ $dependency }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-dependency">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex space-x-2">
                                    <input type="text" name="dependencies[]" placeholder="Например: jQuery"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-dependency">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-dependency" class="mt-2 px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                            <i class="fas fa-plus mr-1"></i> Добавить зависимость
                        </button>
                    </div>
                </div>
            </div>

            <!-- Медиа и ссылки -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Медиа и ссылки</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Основной файл -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Файл товара *</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-archive mx-auto text-gray-400 text-3xl"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Загрузите архив</span>
                                        <input id="product_file" name="product_file" type="file" class="sr-only" required accept=".zip,.rar">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">ZIP, RAR до 50MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Обложка -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Обложка</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-image mx-auto text-gray-400 text-3xl"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Загрузите изображение</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG до 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Галерея -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Галерея изображений</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-images mx-auto text-gray-400 text-3xl"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Загрузите изображения</span>
                                        <input id="gallery" name="gallery[]" type="file" class="sr-only" multiple accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">До 10 изображений</p>
                            </div>
                        </div>
                    </div>

                    <!-- Демо и видео -->
                    <div>
                        <label for="demo_url" class="block text-sm font-medium text-gray-700 mb-1">URL демо</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                            <i class="fas fa-external-link-alt"></i>
                        </span>
                            <input type="url" id="demo_url" name="demo_url" value="{{ old('demo_url') }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://example.com/demo">
                        </div>
                    </div>
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">URL видео</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                            <i class="fab fa-youtube"></i>
                        </span>
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://youtube.com/watch?v=...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Статус и публикация -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Статус публикации</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">Активный товар</label>
                    </div>
                    <div class="flex items-center">
                        <input id="is_featured" name="is_featured" type="checkbox" {{ old('is_featured') ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-700">Рекомендуемый товар</label>
                    </div>
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Дата публикации</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Кнопки отправки -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Отмена
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Сохранить товар
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Генерация slug
                document.getElementById('name').addEventListener('input', function() {
                    if (!document.getElementById('slug').value) {
                        const slug = this.value.toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/[\s_-]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                        document.getElementById('slug').value = slug;
                    }
                });

                // Добавление особенностей
                document.getElementById('add-feature').addEventListener('click', function() {
                    const container = document.getElementById('features-container');
                    const div = document.createElement('div');
                    div.className = 'flex space-x-2';
                    div.innerHTML = `
            <input type="text" name="features[]" placeholder="Новая особенность"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-feature">
                <i class="fas fa-trash"></i>
            </button>
        `;
                    container.appendChild(div);
                });

                // Удаление особенностей
                document.getElementById('features-container').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-feature') || e.target.closest('.remove-feature')) {
                        const features = document.querySelectorAll('#features-container > div');
                        if (features.length > 1) {
                            e.target.closest('div').remove();
                        } else {
                            e.target.closest('div').querySelector('input').value = '';
                        }
                    }
                });

                // Добавление ценовых планов
                document.getElementById('add-pricing-tier').addEventListener('click', function() {
                    const container = document.getElementById('pricing-tiers-container');
                    const div = document.createElement('div');
                    div.className = 'grid grid-cols-1 md:grid-cols-12 gap-2 pricing-tier-input';
                    div.innerHTML = `
            <div class="md:col-span-5">
                <input type="text" name="pricing_tiers_name[]" placeholder="Название плана"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="md:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">$</span>
                    </div>
                    <input type="number" name="pricing_tiers_price[]" placeholder="Цена" min="0" step="0.01"
                        class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <div class="md:col-span-2">
                <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-pricing-tier">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                    container.appendChild(div);
                });

                // Удаление ценовых планов
                document.getElementById('pricing-tiers-container').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-pricing-tier') || e.target.closest('.remove-pricing-tier')) {
                        const tiers = document.querySelectorAll('.pricing-tier-input');
                        if (tiers.length > 1) {
                            e.target.closest('.pricing-tier-input').remove();
                        } else {
                            const inputs = e.target.closest('.pricing-tier-input').querySelectorAll('input');
                            inputs.forEach(input => input.value = '');
                        }
                    }
                });

                // Добавление совместимости
                document.getElementById('add-compatibility').addEventListener('click', function() {
                    const container = document.getElementById('compatibility-container');
                    const div = document.createElement('div');
                    div.className = 'grid grid-cols-1 md:grid-cols-12 gap-2 compatibility-input';
                    div.innerHTML = `
            <div class="md:col-span-5">
                <input type="text" name="compatibility_name[]" placeholder="Технология"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="md:col-span-5">
                <input type="text" name="compatibility_version[]" placeholder="Версия"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
                <button type="button" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-compatibility">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                    container.appendChild(div);
                });

                // Удаление совместимости
                document.getElementById('compatibility-container').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-compatibility') || e.target.closest('.remove-compatibility')) {
                        const items = document.querySelectorAll('.compatibility-input');
                        if (items.length > 1) {
                            e.target.closest('.compatibility-input').remove();
                        } else {
                            const inputs = e.target.closest('.compatibility-input').querySelectorAll('input');
                            inputs.forEach(input => input.value = '');
                        }
                    }
                });

                // Добавление зависимостей
                document.getElementById('add-dependency').addEventListener('click', function() {
                    const container = document.getElementById('dependencies-container');
                    const div = document.createElement('div');
                    div.className = 'flex space-x-2';
                    div.innerHTML = `
            <input type="text" name="dependencies[]" placeholder="Новая зависимость"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 remove-dependency">
                <i class="fas fa-trash"></i>
            </button>
        `;
                    container.appendChild(div);
                });

                // Удаление зависимостей
                document.getElementById('dependencies-container').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-dependency') || e.target.closest('.remove-dependency')) {
                        const deps = document.querySelectorAll('#dependencies-container > div');
                        if (deps.length > 1) {
                            e.target.closest('div').remove();
                        } else {
                            e.target.closest('div').querySelector('input').value = '';
                        }
                    }
                });

                // Drag and drop для файлов
                ['product_file', 'cover_image', 'gallery'].forEach(id => {
                    const dropZone = document.querySelector(`input#${id}`).parentNode.parentNode.parentNode;

                    dropZone.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
                    });

                    dropZone.addEventListener('dragleave', () => {
                        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                    });

                    dropZone.addEventListener('drop', (e) => {
                        e.preventDefault();
                        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                        document.querySelector(`input#${id}`).files = e.dataTransfer.files;

                        // Показываем имя файла
                        if (e.dataTransfer.files.length > 0) {
                            const fileName = id === 'gallery'
                                ? `${e.dataTransfer.files.length} файлов выбрано`
                                : e.dataTransfer.files[0].name;

                            const fileInfo = document.createElement('p');
                            fileInfo.className = 'text-xs text-gray-500 mt-1';
                            fileInfo.textContent = fileName;

                            // Удаляем предыдущую информацию о файле
                            const oldInfo = dropZone.querySelector('.file-info');
                            if (oldInfo) oldInfo.remove();

                            dropZone.appendChild(fileInfo).classList.add('file-info');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
