<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $user->is_active && Hash::check($request->password, $user->password)) {
        // Login berhasil
        Auth::login($user);
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah, atau akun tidak aktif.',
    ]);
}

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        return redirect('login');
    }
}
