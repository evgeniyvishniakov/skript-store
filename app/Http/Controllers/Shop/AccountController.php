<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function index()
    {
        return view('shop.account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $response = ['success' => false];

        try {
            $data = [];

            // Обновление имени
            if ($request->filled('name')) {
                $request->validate(['name' => 'required|string|max:255']);
                $data['name'] = $request->name;
                $response['fieldName'] = 'name';
                $response['newValue'] = $request->name;
            }

            // Обновление email
            if ($request->filled('email')) {
                $request->validate([
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users')->ignore($user->id),
                    ],
                ]);
                $data['email'] = $request->email;
                $data['email_verified_at'] = null;
                $response['fieldName'] = 'email';
                $response['newValue'] = $request->email;
                $response['verified'] = false;
            }

            // Обновление аватара
            if ($request->hasFile('avatar')) {
                $request->validate([
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
                ]);

                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                if ($request->hasFile('avatar')) {
                    $path = $request->file('avatar')->store('avatars', 'public');
                    $data['avatar'] = $path;
                }

                $user->update($data);

                return response()->json([
                    'success' => true,
                    'newValue' => asset('storage/' . $path),
                ]);
            }

            // Обновление подписки
            if ($request->has('newsletter_subscription')) {
                $data['newsletter_subscription'] = (bool)$request->newsletter_subscription;
                $response['fieldName'] = 'newsletter';
                $response['newValue'] = (bool)$request->newsletter_subscription;
            }

            // Если есть данные для обновления
            if (!empty($data)) {
                $user->update($data);
                $response['success'] = true;
                $response['message'] = 'Данные успешно обновлены!';
            } else {
                $response['error'] = 'Нет данных для обновления';
            }

            return response()->json($response);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Update error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteAvatar(Request $request)
    {
        $user = Auth::user();

        try {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                $user->avatar = null;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Аватар успешно удален!',
            ]);

        } catch (\Exception $e) {
            Log::error('Delete avatar error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'string'],
                'new_password' => [
                    'required',
                    'string',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ]);

            $user = Auth::user();

            // Проверка текущего пароля
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'current_password' => ['Неверный текущий пароль']
                    ]
                ], 422);
            }

            // Обновление пароля
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Пароль успешно изменен'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка: ' . $e->getMessage()
            ], 500);
        }
    }

}
