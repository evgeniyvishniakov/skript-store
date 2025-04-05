@extends('admin.layouts.app')

@section('title', 'Управление товарами')
@section('header', 'Список товаров')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Заголовок и кнопка добавления -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <h2 class="text-2xl font-bold text-gray-800">Все товары</h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i> Добавить товар
            </a>
        </div>

        <!-- Фильтры -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Фильтр по типу -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Тип товара</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Все типы</option>
                        @foreach(['script' => 'Скрипт', 'plugin' => 'Плагин', 'theme' => 'Тема', 'template' => 'Шаблон'] as $value => $label)
                            <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Фильтр по категории -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Категория</label>
                    <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Фильтр по статусу -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                    <select name="is_active" id="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Все</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Активные</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Неактивные</option>
                    </select>
                </div>

                <!-- Кнопки фильтрации -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i> Фильтровать
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        <i class="fas fa-sync-alt mr-2"></i> Сбросить
                    </a>
                </div>
            </div>
        </form>

        <!-- Таблица товаров -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Название
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Тип
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Категория
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Цена
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Статус
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действия
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($product->cover_image)
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($product->short_description, 30) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $product->type == 'script' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $product->type == 'plugin' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $product->type == 'theme' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $product->type == 'template' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ $product->type_name }}
                        </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->category->name ?? 'Без категории' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($product->price, 2) }} ₴
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-gray-600 hover:text-gray-900" title="Просмотр">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Товары не найдены
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($products->hasPages())
            <div class="mt-6">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }
        .page-item {
            margin: 0 2px;
        }
        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            color: #4a5568;
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
        }
        .page-item.active .page-link {
            color: #fff;
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .page-item.disabled .page-link {
            color: #a0aec0;
            pointer-events: none;
            background-color: #fff;
            border-color: #e2e8f0;
        }
    </style>
@endpush
