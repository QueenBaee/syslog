<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === 'nmc' && $request->password === 'nocer2010') {
            session(['authenticated' => true]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['credentials' => 'Invalid username or password']);
    }

    public function logout()
    {
        session()->forget('authenticated');
        return redirect()->route('login');
    }
}