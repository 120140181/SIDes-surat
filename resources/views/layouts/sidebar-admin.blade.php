{{-- resources/views/layouts/sidebar-admin.blade.php --}}
<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('active-dashboard')">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.pengajuan.index') }}" class="nav-link @yield('active-pengajuan')">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Kelola Pengajuan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.data.warga') }}" class="nav-link @yield('active-data-warga')">
        <i class="nav-icon fas fa-users"></i>
        <p>Data Warga</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.data.jenis-surat') }}" class="nav-link @yield('active-jenis-surat')">
        <i class="nav-icon fas fa-list"></i>
        <p>Jenis Surat</p>
    </a>
</li>

<!-- Divider -->
<li class="nav-header">AKUN</li>

<!-- Logout -->
<li class="nav-item">
    <a href="#" class="nav-link text-danger" onclick="confirmLogout(); return false;">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>
