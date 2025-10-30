<?php
// app/Http/Controllers/Admin/DataWargaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataWargaController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'warga')->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $warga = $query->get();
        $totalWarga = $warga->count();

        return view('admin.data.warga', compact('warga', 'totalWarga'));
    }

    public function show($id): View
    {
        $warga = User::where('role', 'warga')->findOrFail($id);
        return view('admin.data.warga-show', compact('warga'));
    }
}
