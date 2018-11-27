<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'password' => 'required'
        ]);
        if(Auth::attempt([
            'email' => 'admin@admin.ch',
            'password' => $request->password
        ])) {
            return redirect()->intended('/admin');
        }
        throw ValidationException::withMessages([
            'password' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}
