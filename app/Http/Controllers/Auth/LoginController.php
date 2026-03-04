<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //  ЛОГИРОВАНИЕ ВХОДА
            ActivityLogger::log('auth.login', [
                'user_id' => Auth::id(),
                'email'   => Auth::user()->email,
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Неверные данные.',
        ]);
    }

    public function logout(Request $request)
    {
        //  ЛОГИРОВАНИЕ ВЫХОДА
        ActivityLogger::log('auth.logout', [
            'user_id' => auth()->id(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
