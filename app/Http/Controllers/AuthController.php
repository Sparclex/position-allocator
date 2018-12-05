<?php

namespace App\Http\Controllers;

use App\Sample;
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
            $sample = Sample::orderBy('position', 'desc')->first();
            return redirect()->intended('/admin/table/' . ($sample ? $sample->plate : 1));
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
