<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Shop\AccountController;
use App\Http\Controllers\Shop\Auth\LoginController;
use App\Http\Controllers\Shop\Auth\RegisterController;
use App\Http\Controllers\Shop\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [HomeController::class, 'index'])->name('shop.home');


// Группа для гостей (неавторизованных пользователей)
Route::middleware('guest')->group(function () {
    // Регистрация
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/account/signup', 'index')->name('shop.signup');
        Route::post('/account/signup', 'create')->name('shop.signup.create');
        Route::post('/check-email', 'checkEmail')->name('shop.check-email');
    });

    // Авторизация
    Route::controller(LoginController::class)->group(function () {
        Route::get('/account/login', 'index')->name('shop.login');
        Route::post('/account/login', 'login')->name('shop.login.post');
    });
});

// Группа для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Управление аккаунтом
    Route::controller(AccountController::class)->group(function () {
        Route::get('/account', 'index')->name('shop.account');
        Route::put('/account/update', 'update')->name('account.update');
        Route::delete('/account/delete-avatar', 'deleteAvatar')->name('account.delete-avatar');
        Route::post('/account/change-password', 'changePassword')->name('account.change-password');
        Route::get('/products/{product}/download', [ProductController::class, 'download'])
            ->name('products.download');
    });

    // Выход из системы
    Route::get('/logout', [LoginController::class, 'logout'])->name('shop.logout');


});


// Админ-панель
Route::redirect('/admin', '/admin-panel', 301);
Route::prefix('admin-panel')->group(function () {
    // Авторизация в админке
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('admin.login');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->name('admin.logout');
    });

    // Защищенные админ-роуты
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Управление категориями
        Route::resource('categories', CategoryController::class)->except(['show']);;

        // Управление товарами
        Route::resource('products', ProductController::class)->except(['show']);
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'adminIndex'])->name('admin.products.index');
            Route::post('{product}/toggle-feature', [ProductController::class, 'toggleFeatured'])
                ->name('admin.products.toggle-feature');
            Route::post('{product}/toggle-active', [ProductController::class, 'toggleActive'])
                ->name('admin.products.toggle-active');
            Route::get('stats', [ProductController::class, 'stats'])->name('admin.products.stats');
            Route::get('products/{product}/download', [ProductController::class, 'download'])
                ->name('admin.products.download');

        });
    });
});
