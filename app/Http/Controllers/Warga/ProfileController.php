<?php
// app/Http/Controllers/Warga/ProfileController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        return view('warga.profile.show', compact('user'));
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('warga.profile.edit', compact('user'));
    }

    // Method harusnya store untuk update profile
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:500',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:50',
            'no_telepon' => 'required|string|max:15',
        ]);

        $user->update($request->all());

        return redirect()->route('warga.profile.show')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('warga.profile.show')
            ->with('success', 'Password berhasil diubah!');
    }
}
