<?php

namespace App\Http\Controllers\Shop\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('shop.auth.login');
    }

    public function login(Request $request)
    {
        // Валидация
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255'
        ]);

        // Дополнительная проверка существования пользователя
        $user = User::where('email', $credentials['email'])->first();

        $throttleKey = 'login|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'errors' => [
                    'email' => "Попробуйте через $seconds секунд"
                ]
            ], 429);
        }

        RateLimiter::hit($throttleKey);

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => ['Аккаунт с таким email не найден']
                ]
            ], 422);
        }

        // Попытка аутентификации
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return response()->json([
                'errors' => [
                    'password' => ['Неправильный пароль']
                ]
            ], 422);
        }

        // Регенерация сессии
        $request->session()->regenerate();

        return response()->json([
            'redirect' => route('shop.account'),
            'message' => 'Вы успешно вошли в систему'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.login')
            ->with('status', 'Вы вышли из системы');
    }
}
