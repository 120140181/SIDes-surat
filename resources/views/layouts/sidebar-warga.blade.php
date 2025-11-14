{{-- resources/views/layouts/sidebar-warga.blade.php --}}
<li class="nav-item">
    <a href="{{ route('warga.dashboard') }}" class="nav-link @yield('active-dashboard')">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-header">PENGAJUAN SURAT</li>

<li class="nav-item">
    <a href="{{ route('warga.pengajuan.index') }}" class="nav-link @yield('active-pengajuan-list')">
        <i class="nav-icon fas fa-list"></i>
        <p>Daftar Pengajuan</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('warga.pengajuan.create') }}" class="nav-link @yield('active-pengajuan-buat')">
        <i class="nav-icon fas fa-plus-circle"></i>
        <p>Ajukan Surat Baru</p>
    </a>
</li>

<!-- Divider -->
<li class="nav-header">AKUN</li>

<li class="nav-item">
    <a href="{{ route('warga.profile.show') }}" class="nav-link @yield('active-profile')">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Profile Saya</p>
    </a>
</li>

<!-- Logout -->
<li class="nav-item">
    <a href="#" class="nav-link text-danger" onclick="confirmLogout(); return false;">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
