<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:student,employer',
        ], [
            'name.required'      => 'Введите имя',
            'email.required'     => 'Введите email',
            'email.unique'       => 'Этот email уже зарегистрирован',
            'password.required'  => 'Введите пароль',
            'password.min'       => 'Пароль минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        return redirect('/vacancies')->with('success', 'Добро пожаловать, ' . $user->name . '!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/vacancies')->with('success', 'Авторизация прошла успешно!');
            }

        return back()->withErrors(['email' => 'Неверный email или пароль'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}