<?php
// app/Http/Controllers/Auth/AuthenticatedSessionController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi custom untuk NIK
        $request->validate([
            'nik' => 'required|string|size:16',
            'password' => 'required|string',
        ]);

        // Attempt login dengan NIK
        if (Auth::attempt(['nik' => $request->nik, 'password' => $request->password])) {
            $request->session()->regenerate();

            $userName = Auth::user()->nama_lengkap;
            $dashboardUrl = Auth::user()->role === 'admin'
                ? '/admin/dashboard'
                : '/warga/dashboard';

            // Simpan data untuk SweetAlert dengan redirect
            $request->session()->flash('login_success', [
                'name' => $userName,
                'redirect' => $dashboardUrl
            ]);

            return redirect()->route('login');
        }

        return back()->withErrors([
            'nik' => 'NIK atau password salah.',
        ])->onlyInput('nik');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message untuk logout berhasil
        session()->flash('logout_success', true);

        return redirect('/login');
    }
}
