@extends('admin.components.layout')

@section('content')
    <div class="row">
        <!-- Левая колонка: форма создания -->
        <div class="col-md-3 offset-md-1 col-sm-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Добавить категорию</h3>
                </div>
                <div class="card-body">
                    <form id="createCategoryForm"
                          action="{{ route('categories.store') }}"
                          method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Тип</label>
                            <select name="type" class="form-control" required>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Правая колонка: таблица категорий -->
        <div class="col-md-7 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список категорий</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                        @foreach($categories as $category)
                            @include('admin.categories.row', ['category' => $category])
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать категорию</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCategoryForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editCategoryId">
                        <div class="mb-3">
                            <label>Название</label>
                            <input type="text" name="name" id="editCategoryName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Тип</label>
                            <select name="type" id="editCategoryType" class="form-control" required>
                                @foreach(['framework', 'language', 'topic', 'tool'] as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Цвет</label>
                            <input type="color" name="color" id="editCategoryColor" class="form-control form-control-color">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
        <script>
            document.getElementById('createCategoryForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = this;
                const tbody = document.getElementById('categoriesTableBody');
                const submitBtn = form.querySelector('button[type="submit"]');

                // Блокируем кнопку
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: form.querySelector('input[name="name"]').value,
                            type: form.querySelector('select[name="type"]').value
                        })
                    });

                    if (!response.ok) throw new Error('Ошибка сервера');

                    const data = await response.json();
                    console.log('Полученные данные:', data);

                    if (data.success) {
                        // Создаем временный контейнер
                        const temp = document.createElement('tbody');
                        temp.innerHTML = data.html;

                        // Добавляем новую строку
                        tbody.appendChild(temp.firstChild);

                        // Очищаем форму
                        form.reset();

                        // Уведомление
                        alert('Категория успешно добавлена!');
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                    alert('Ошибка при добавлении: ' + error.message);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
            document.addEventListener('submit', async function(e) {
                if (e.target.classList.contains('delete-form')) {
                    e.preventDefault();

                    const form = e.target;
                    const row = form.closest('tr');
                    const button = form.querySelector('button');
                    const originalHtml = button.innerHTML;

                    // Подтверждение
                    if (!confirm('Удалить категорию?')) return;

                    // Блокируем кнопку
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    try {
                        // Добавляем анимацию
                        row.classList.add('deleting');

                        // Отправка запроса
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                                'X-HTTP-Method-Override': 'DELETE',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) throw new Error(data.message || 'Ошибка сервера');

                        // Анимация удаления
                        row.style.transition = 'all 0.5s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(100%)';

                        // Удаляем строку после анимации
                        setTimeout(() => {
                            row.remove();
                            showToast('Категория удалена', 'success');
                        }, 500);

                    } catch (error) {
                        console.error('Error:', error);
                        row.classList.remove('deleting');
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                        showToast(error.message, 'error');
                    }
                }
            });

            // Функция для уведомлений (если ещё нет)
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                toast.textContent = message;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-category')) {
                    const button = e.target.closest('.edit-category');
                    const modal = new bootstrap.Modal('#editCategoryModal');

                    // Заполняем форму данными
                    document.getElementById('editCategoryId').value = button.dataset.id;
                    document.getElementById('editCategoryName').value = button.dataset.name;
                    document.getElementById('editCategoryType').value = button.dataset.type;
                    document.getElementById('editCategoryColor').value = button.dataset.color || '#6e3aff';

                    modal.show();
                }
            });

            document.getElementById('editCategoryForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = this;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                try {
                    const response = await fetch(`/admin-panel/categories/${form.id.value}`, {
                        method: 'PUT', // Используем PUT напрямую
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: form.name.value,
                            type: form.type.value,
                            color: form.color.value
                        })
                    });

                    const data = await response.json();
                    console.log('Ответ сервера:', data); // Для отладки

                    if (!response.ok) throw new Error(data.message || 'Ошибка сервера');

                    // 1. Находим строку в таблице
                    const row = document.querySelector(`tr[data-id="${data.category.id}"]`);
                    if (!row) throw new Error('Строка не найдена');

                    // 2. Обновляем данные в таблице
                    const badge = row.querySelector('.badge');
                    if (badge) {
                        badge.textContent = data.category.name;
                        badge.style.backgroundColor = data.category.color;
                    }

                    const typeCell = row.querySelector('.category-type');
                    if (typeCell) {
                        typeCell.textContent = data.category.type;
                    }

                    // 3. Обновляем кнопку редактирования
                    const editBtn = row.querySelector('.edit-category');
                    if (editBtn) {
                        editBtn.dataset.name = data.category.name;
                        editBtn.dataset.type = data.category.type;
                        editBtn.dataset.color = data.category.color;
                    }

                    // 4. Закрываем модальное окно
                    bootstrap.Modal.getInstance('#editCategoryModal').hide();

                    // 5. Показываем уведомление
                    showToast('✅ Изменения сохранены!');

                } catch (error) {
                    console.error('Ошибка:', error);
                    showToast(`❌ ${error.message}`, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });

            // Функция для уведомлений
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        </script>
@endpush
