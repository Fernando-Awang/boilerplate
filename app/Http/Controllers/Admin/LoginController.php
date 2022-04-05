<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            $user = auth()->user();
            return redirect('/admin/dashboard')->with('success', 'Selamat datang ' . $user->name);
        } else {
            return redirect('/admin/login')->with('error', 'User tidak ditemukan')->withInput();
        }
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
