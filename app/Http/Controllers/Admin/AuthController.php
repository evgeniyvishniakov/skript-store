<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {

        return view('admin.auth.login'); // Убедитесь в правильности пути
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/admin-panel'); // Редирект после успешного входа
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin-panel/login');
    }
}
