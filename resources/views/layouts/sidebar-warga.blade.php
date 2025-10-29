{{-- resources/views/layouts/sidebar-warga.blade.php --}}
<li class="nav-item">
    <a href="{{ route('warga.dashboard') }}" class="nav-link @yield('active-dashboard')">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item @yield('menu-open-pengajuan')">
    <a href="#" class="nav-link @yield('active-pengajuan')">
        <i class="nav-icon fas fa-envelope"></i>
        <p>
            Pengajuan Surat
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('warga.pengajuan.index') }}" class="nav-link @yield('active-pengajuan-list')">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Pengajuan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('warga.pengajuan.create') }}" class="nav-link @yield('active-pengajuan-buat')">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajukan Surat Baru</p>
            </a>
        </li>
    </ul>
</li>

<!-- Divider -->
<li class="nav-header">AKUN</li>

<li class="nav-item">
    <a href="{{ route('warga.profile.show') }}" class="nav-link @yield('active-profile')">
        <i class="nav-icon fas fa-user"></i>
        <p>Profile Saya</p>
    </a>
</li>

<!-- Logout -->
<li class="nav-item">
    <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
        @csrf
        <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
        </a>
    </form>
</li>
