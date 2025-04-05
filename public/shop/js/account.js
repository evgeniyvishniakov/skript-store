const getCsrfToken = () => {
    return document.querySelector('meta[name="csrf-token"]').content;
};

// Универсальная функция для AJAX-запросов
const sendRequest = async (url, method, data, successCallback, errorElementId = null) => {
    try {
        const headers = {
            'X-CSRF-TOKEN': getCsrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        };

        // Если FormData, не устанавливаем Content-Type (браузер сделает это сам)
        if (!(data instanceof FormData)) {
            headers['Content-Type'] = 'application/json';
            data = JSON.stringify(data);
        }

        const response = await fetch(url, {
            method: method,
            body: data,
            headers: headers,
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.error || 'Произошла ошибка');
        }

        if (successCallback) successCallback(result);
        return result;

    } catch (error) {
        console.error('Ошибка запроса:', error);
        if (errorElementId) {
            showError(errorElementId, error.message);
        } else {
            showAlert(error.message, 'danger');
        }
        return null;
    }
};

// Обработчики событий
document.addEventListener('DOMContentLoaded', function() {
    // Обновление аватара
    document.getElementById('save-avatar-btn')?.addEventListener('click', async function() {
        const fileInput = document.getElementById('avatar-input');
        if (!fileInput.files.length) {
            showError('avatar-error', 'Выберите файл для загрузки');
            return;
        }

        const formData = new FormData();
        formData.append('avatar', fileInput.files[0]);
        formData.append('_method', 'PUT');

        try {
            const response = await fetch('/account/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Обновляем изображение
                const avatarImage = document.getElementById('avatar-image');
                if (avatarImage) {
                    avatarImage.src = data.newValue;
                }

                // Показываем блок с аватаркой
                const avatarDisplay = document.getElementById('avatar-display');
                if (avatarDisplay) {
                    avatarDisplay.style.display = 'block';
                }

                // Скрываем форму редактирования
                const avatarEdit = document.getElementById('avatar-edit');
                if (avatarEdit) {
                    avatarEdit.style.display = 'none';
                }

                // Очищаем поле выбора файла
                fileInput.value = '';

                // Показываем уведомление
                showAlert('Аватар успешно обновлен!', 'success');
            } else {
                showError('avatar-error', data.error || 'Произошла ошибка при обновлении аватара');
            }
        } catch (error) {
            showError('avatar-error', 'Произошла ошибка при обновлении аватара');
            console.error('Error:', error);
        }
    });

    // Удаление аватара
    document.getElementById('delete-avatar-btn')?.addEventListener('click', async function() {
        try {
            const response = await fetch('/account/delete-avatar', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _method: 'DELETE' })
            });

            const data = await response.json();

            if (data.success) {
                // Скрываем блок с аватаркой
                const avatarDisplay = document.getElementById('avatar-display');
                if (avatarDisplay) {
                    avatarDisplay.style.display = 'none';
                }

                // Показываем форму редактирования
                const avatarEdit = document.getElementById('avatar-edit');
                if (avatarEdit) {
                    avatarEdit.style.display = 'block';
                }

                // Показываем уведомление
                showAlert('Avatar successfully deleted!', 'success');
            } else {
                showAlert(data.error || 'There was an error deleting your avatar', 'danger');
            }
        } catch (error) {
            showAlert('There was an error deleting your avatar', 'danger');
            console.error('Error:', error);
        }
    });

    // Обновление имени
    document.getElementById('save-name-btn')?.addEventListener('click', async function() {
        const nameInput = document.getElementById('name-input');
        if (!nameInput.value.trim()) {
            showError('name-error', 'The name field cannot be empty');
            return;
        }

        await sendRequest(
            '/account/update',
            'POST',
            { name: nameInput.value, _method: 'PUT' },
            (data) => {
                document.getElementById('name-value').textContent = data.newValue;
                showAlert('Name updated successfully!', 'success');
                hideNameEdit();
            },
            'name-error'
        );
    });

    // Обновление email
    document.getElementById('save-email-btn')?.addEventListener('click', async function() {
        const emailInput = document.getElementById('email-input');
        if (!emailInput.value.trim()) {
            showError('email-error', 'The email field cannot be empty');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            showError('email-error', 'Enter a correct email');
            return;
        }

        await sendRequest(
            '/account/update',
            'POST',
            { email: emailInput.value, _method: 'PUT' },
            (data) => {
                document.getElementById('email-value').textContent = data.newValue;
                document.getElementById('email-verification-badge').textContent = 'Not confirmed';
                document.getElementById('email-verification-badge').className = 'badge bg-danger ms-2';
                showAlert('Email successfully updated! Confirmation required.', 'success');
                hideEmailEdit();
            },
            'email-error'
        );
    });

    // Подписка на новости
    document.getElementById('newsletter_subscription')?.addEventListener('change', async function() {
        await sendRequest(
            '/account/update',
            'POST',
            { newsletter_subscription: this.checked ? 1 : 0, _method: 'PUT' },
            () => {
                showAlert('Subscription settings have been updated!', 'success');
            },
            null
        );
    });
});

// Вспомогательные функции
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        if (errorElement.previousElementSibling) {
            errorElement.previousElementSibling.classList.add('is-invalid');
        }
    }
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    if (!alertContainer) return;

    const alertElement = document.createElement('div');
    alertElement.className = `alert alert-${type} alert-dismissible fade show`;
    alertElement.role = 'alert';
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertElement);

    setTimeout(() => {
        alertElement.classList.remove('show');
        setTimeout(() => alertContainer.removeChild(alertElement), 150);
    }, 5000);
}

// Функции для скрытия/показа форм
function showAvatarEdit() {
    document.getElementById('avatar-display').style.display = 'none';
    document.getElementById('avatar-edit').style.display = 'block';
}

function hideAvatarEdit() {
    document.getElementById('avatar-display').style.display = 'block';
    document.getElementById('avatar-edit').style.display = 'none';
}

function showNameEdit() {
    document.getElementById('name-display').style.display = 'none';
    document.getElementById('name-edit').style.display = 'block';
}

function hideNameEdit() {
    document.getElementById('name-display').style.display = 'block';
    document.getElementById('name-edit').style.display = 'none';
}

function showEmailEdit() {
    document.getElementById('email-display').style.display = 'none';
    document.getElementById('email-edit').style.display = 'block';
}

function hideEmailEdit() {
    document.getElementById('email-display').style.display = 'block';
    document.getElementById('email-edit').style.display = 'none';
}




// Смена пароля
document.getElementById('change-password-btn')?.addEventListener('click', async function() {
    // Получаем значения полей
    const currentPassword = document.getElementById('current-password').value.trim();
    const newPassword = document.getElementById('new-password').value.trim();
    const newPasswordConfirmation = document.getElementById('new-password-confirmation').value.trim();

    // Сбрасываем предыдущие ошибки
    hideError('current-password-error');
    hideError('new-password-error');
    hideError('new-password-confirmation-error');

    // Валидация
    let isValid = true;

    if (!currentPassword) {
        showError('current-password-error', 'Enter your current password');
        isValid = false;
    }

    if (!newPassword) {
        showError('new-password-error', 'Enter new password');
        isValid = false;
    } else if (newPassword.length < 8) {
        showError('new-password-error', 'Password must be at least 8 characters long');
        isValid = false;
    }

    if (newPassword !== newPasswordConfirmation) {
        showError('new-password-confirmation-error', 'The passwords do not match');
        isValid = false;
    }

    if (!isValid) return;

    // Отправка запроса
    try {
        const response = await fetch('/account/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: newPasswordConfirmation
            })
        });

        const data = await response.json();

        if (data.success) {
            // Очищаем поля
            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('new-password-confirmation').value = '';

            showAlert('Password changed successfully!', 'success');
        } else {
            if (data.errors) {
                // Обработка ошибок валидации
                if (data.errors.current_password) {
                    showError('current-password-error', data.errors.current_password[0]);
                }
                if (data.errors.new_password) {
                    showError('new-password-error', data.errors.new_password[0]);
                }
            } else {
                showAlert(data.message || 'An error occurred while changing your password', 'danger');
            }
        }
    } catch (error) {
        showAlert('An error occurred while changing your password', 'danger');
        console.error('Error:', error);
    }
});

function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        if (errorElement.previousElementSibling) {
            errorElement.previousElementSibling.classList.add('is-invalid');
        }
    }
}

function hideError(elementId) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.style.display = 'none';
        if (errorElement.previousElementSibling) {
            errorElement.previousElementSibling.classList.remove('is-invalid');
        }
    }
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    if (!alertContainer) return;

    const alertElement = document.createElement('div');
    alertElement.className = `alert alert-${type} alert-dismissible fade show`;
    alertElement.role = 'alert';
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertElement);

    setTimeout(() => {
        alertElement.classList.remove('show');
        setTimeout(() => alertContainer.removeChild(alertElement), 150);
    }, 5000);
}


document.getElementById('avatar-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'No file chosen';
    const label = document.querySelector('label[for="avatar-input"]');
    label.textContent = fileName;

    // Валидация размера файла
    if (e.target.files[0]?.size > 1024 * 1024) { // 1MB
        document.getElementById('avatar-error').textContent = 'File is too large!';
        document.getElementById('avatar-error').style.display = 'block';
    } else {
        document.getElementById('avatar-error').style.display = 'none';
    }
});
