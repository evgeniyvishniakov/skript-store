<?php

namespace App\Http\Controllers\Shop\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function index()
    {
        return view('shop.auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Zа-яА-ЯёЁ\s\'-]+$/u',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    //->uncompromised()

            ],
        ]);
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // HTTP 422 - Unprocessable Entity
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return response()->json([
                'redirect' => route('shop.account')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка регистрации: ' . $e->getMessage()
            ], 500); // HTTP 500 - Server Error
        }
    }
}
