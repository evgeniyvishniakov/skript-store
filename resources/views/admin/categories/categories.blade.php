@extends('admin.layouts.app')

@section('title', 'Управление категориями')
@section('header', 'Категории товаров')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Форма создания -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Добавить категорию</h3>
                    <form id="createCategoryForm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Название *</label>
                                <input type="text" name="name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Тип *</label>
                                <select name="type" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                                Создать
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Список категорий -->
            <div class="lg:col-span-2">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Список категорий</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Тип</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Товаров</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="categoriesTableBody">
                        @foreach($categories as $category)
                            @include('admin.categories.row', ['category' => $category])
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования -->
    <div class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="editModal">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Редактировать категорию</h3>
                <form id="editCategoryForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editCategoryId">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Название *</label>
                        <input type="text" name="name" id="editCategoryName" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Тип *</label>
                        <select name="type" id="editCategoryType" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                            Отмена
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Обработчик создания категории
        document.getElementById('createCategoryForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const button = form.querySelector('button');
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = 'Создание...';

            try {
                const response = await fetch("{{ route('categories.store') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    },
                    body: new FormData(form)
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Ошибка сервера');

                document.getElementById('categoriesTableBody').insertAdjacentHTML('afterbegin', data.html);
                form.reset();
                showToast('Категория создана!', 'success');
            } catch (error) {
                showToast(error.message, 'error');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Обработчик редактирования
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-category')) {
                const btn = e.target.closest('.edit-category');
                document.getElementById('editCategoryId').value = btn.dataset.id;
                document.getElementById('editCategoryName').value = btn.dataset.name;
                document.getElementById('editCategoryType').value = btn.dataset.type;
                document.getElementById('editModal').classList.remove('hidden');
            }
        });

        // Сохранение изменений
        document.getElementById('editCategoryForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = 'Сохранение...';

            try {
                const response = await fetch(`/admin-panel/categories/${form.id.value}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: new FormData(form)
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Ошибка сервера');

                const row = document.querySelector(`tr[data-id="${data.category.id}"]`);
                if (row) {
                    row.querySelector('.category-name').textContent = data.category.name;
                    row.querySelector('.category-type').textContent = data.category.type;
                    // Обновляем data-атрибуты кнопки редактирования
                    row.querySelector('.edit-category').dataset.name = data.category.name;
                    row.querySelector('.edit-category').dataset.type = data.category.type;
                }

                closeModal();
                showToast('Изменения сохранены!', 'success');
            } catch (error) {
                showToast(error.message, 'error');
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });

        // Удаление категории
        document.addEventListener('submit', async function(e) {
            if (e.target.classList.contains('delete-form')) {
                e.preventDefault();
                if (!confirm('Удалить категорию?')) return;

                const form = e.target;
                const row = form.closest('tr');
                const button = form.querySelector('button');
                const originalText = button.innerHTML;

                button.disabled = true;
                button.innerHTML = 'Удаление...';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            'X-HTTP-Method-Override': 'DELETE'
                        }
                    });

                    if (!response.ok) throw new Error('Ошибка сервера');

                    // Анимация удаления
                    row.style.opacity = '0';
                    row.style.transition = 'opacity 0.3s';
                    setTimeout(() => row.remove(), 300);

                    showToast('Категория удалена', 'success');
                } catch (error) {
                    showToast(error.message, 'error');
                } finally {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }
        });

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
@endpush
