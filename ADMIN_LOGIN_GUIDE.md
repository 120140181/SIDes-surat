# Admin Login Terpisah - Setup Guide

## 🎯 Overview

Sistem login admin telah dipisahkan dari login warga dengan URL tersendiri yang harus diketik manual.

## 🔐 Akses Admin

### URL Login Admin:
```
http://127.0.0.1:8000/admin/login
```

### Credentials Default:
- **Username**: `admin`
- **Password**: `password` (atau sesuai yang di database)

## 📋 Fitur

✅ **Halaman login terpisah** - Admin login di `/admin/login`, warga di `/login`
✅ **Tidak ada link/button** - Admin harus ketik URL manual
✅ **Username + Password** - Admin login dengan username sederhana, bukan NIK
✅ **Role validation** - Hanya user dengan role `admin` yang bisa login
✅ **Session terpisah** - Admin logout menggunakan route terpisah

## 🗂️ File yang Dibuat/Diubah

### 1. **Controller Baru**
- `app/Http/Controllers/Auth/AdminLoginController.php`
  - `showLoginForm()` - Tampilkan form login admin
  - `login()` - Handle login admin dengan username + password
  - `logout()` - Logout admin

### 2. **View Baru**
- `resources/views/auth/admin-login.blade.php`
  - Design modern dengan gradient purple
  - Form username + password (bukan NIK)
  - Alert warning area khusus admin
  - Link kembali ke login warga

### 3. **Routes Update**
- `routes/auth.php`
  - `GET /admin/login` → Form login admin
  - `POST /admin/login` → Submit login
  - `POST /admin/logout` → Logout admin

### 4. **Migration**
- `2025_11_16_023053_add_email_to_users_table_for_admin.php`
  - Tambah kolom `email` ke tabel `users`
  - Set default email admin = 'admin'

### 5. **Layout Update**
- `resources/views/layouts/app.blade.php`
  - Logout form menggunakan route berbeda untuk admin

## 🔧 Cara Mengubah Username/Password Admin

### Via Database:

```sql
UPDATE users 
SET email = 'admin_baru', 
    password = '$2y$12$...' -- hash dari password baru
WHERE role = 'admin';
```

### Via Tinker:

```bash
php artisan tinker

$admin = User::where('role', 'admin')->first();
$admin->email = 'admin_baru';
$admin->password = Hash::make('password_baru');
$admin->save();
```

## 🚀 Testing

1. **Login sebagai Admin:**
   - Buka browser: `http://127.0.0.1:8000/admin/login`
   - Username: `admin`
   - Password: `password`
   - Klik "Login ke Admin Panel"
   - ✅ Redirect ke `/admin/dashboard`

2. **Login sebagai Warga (tidak berubah):**
   - Buka browser: `http://127.0.0.1:8000/login`
   - NIK: 16 digit
   - Password: password warga
   - ✅ Redirect ke `/warga/dashboard`

3. **Coba login warga ke admin login:**
   - Buka: `/admin/login`
   - Masukkan username warga
   - ❌ Error: "Username atau password salah"

4. **Logout Admin:**
   - Klik dropdown profile
   - Klik "Logout"
   - ✅ Redirect ke `/admin/login`

## 🔒 Keamanan

- ✅ Admin URL tidak ada link di mana pun (harus hafal/bookmark)
- ✅ Validasi role di controller
- ✅ Session terpisah untuk admin dan warga
- ✅ Password di-hash dengan bcrypt
- ✅ CSRF protection aktif
- ✅ Throttling untuk prevent brute force

## 📝 Catatan

### Username Admin di Database
Username admin disimpan di kolom `email` di tabel `users`. Ini karena:
1. Laravel default auth menggunakan `email` field
2. Lebih mudah daripada mengubah semua auth logic
3. Warga tidak perlu email (tetap pakai NIK)

### Backward Compatibility
- Login warga **TIDAK BERUBAH** sama sekali
- Register warga tetap pakai NIK
- Kolom `email` nullable untuk warga yang sudah ada

### Menambah Admin Baru

```php
// Via Seeder atau Tinker
User::create([
    'nik' => '0000000000000000', // dummy NIK untuk admin
    'email' => 'superadmin',      // username login
    'password' => Hash::make('password123'),
    'nama_lengkap' => 'Super Admin',
    'role' => 'admin',
    'tempat_lahir' => 'Jakarta',
    'tanggal_lahir' => '1990-01-01',
    'jenis_kelamin' => 'L',
]);
```

## 🎨 Customization

### Mengubah Design Login Admin
Edit file: `resources/views/auth/admin-login.blade.php`

### Mengubah URL Admin Login
Edit file: `routes/auth.php`
```php
Route::get('rahasia/admin', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');
```

### Menambahkan Captcha
Tambahkan Google reCAPTCHA di form login admin untuk keamanan extra.

## 🆘 Troubleshooting

**Q: Lupa username admin?**
A: Cek database:
```sql
SELECT email, nama_lengkap FROM users WHERE role = 'admin';
```

**Q: Lupa password admin?**
A: Reset via tinker:
```bash
php artisan tinker
User::where('email', 'admin')->update(['password' => Hash::make('newpassword')]);
```

**Q: Admin redirect ke /warga/dashboard?**
A: Cek role user di database, pastikan `role = 'admin'`

**Q: Error "email must be unique" saat register warga?**
A: Kolom email nullable dan tidak ada constraint unique untuk warga.

---

**Status**: ✅ Production Ready
**Last Updated**: 2025-11-16
