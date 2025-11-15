<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        // Jika sudah login sebagai admin, redirect ke dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika sudah login tapi bukan admin, logout dulu
        if (Auth::check() && Auth::user()->role !== 'admin') {
            Auth::logout();
        }

        return view('auth.admin-login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba login dengan username (kita akan gunakan email field di database)
        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Cek apakah user adalah admin
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();

                // Flash message untuk success
                $request->session()->flash('admin_login_success', [
                    'name' => Auth::user()->nama_lengkap ?? 'Admin',
                ]);

                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika bukan admin, logout dan error
            Auth::logout();
            throw ValidationException::withMessages([
                'username' => 'Akses ditolak. Anda bukan administrator.',
            ]);
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('admin_logout_success', true);

        return redirect()->route('admin.login');
    }
}
