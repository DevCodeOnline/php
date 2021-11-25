<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginForm()
    {
        return view('user.create');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if (Auth::attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ])) {
            session()->flash('success', 'Вы успешно авторизованы');
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('error', 'Неверные данные');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.create');
    }
}
