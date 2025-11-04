# 🏢 Layanan Administratif Desa - Laravel

Sebuah aplikasi web modern berbasis Laravel untuk mengelola layanan administratif desa seperti pembuatan surat keterangan, surat pengantar, dan surat izin.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

## ✨ Fitur Utama

- 🎨 **Dashboard Admin** - Management layanan dan surat
- 👥 **Authentication System** - Login untuk admin dan warga
- 📝 **Pengajuan Surat Online** - Warga bisa mengajukan surat secara online
- 📊 **Tracking Status** - Melacak status pengajuan surat
- 📱 **Responsive Design** - Tampilan optimal di semua perangkat

## 🛠️ Teknologi Stack

- **Laravel 10/11** - PHP Framework
- **MySQL** - Database
- **Bootstrap 5** - Frontend Framework
- **JavaScript** - Interaktivitas
- **Composer** - Dependency Management

## 🚀 Instalasi dan Setup

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL
- Node.js & NPM

### 📥 Clone dan Install

```bash
# Clone repository
git clone https://github.com/username/layanan-desa-laravel.git

# Masuk ke direktori project
cd layanan-desa-laravel

# Install dependencies PHP
composer install

# Install dependencies JavaScript
npm install

# Build assets
npm run build

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 🗄️ Setup Database

```bash
# Buat database MySQL
mysql -u root -p
CREATE DATABASE layanan_desa;

# Konfigurasi .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=layanan_desa
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 🔧 Migration dan Seeding

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder (data dummy)
php artisan db:seed

# atau jalankan migrasi + seeding sekaligus
php artisan migrate --seed
```

### 👤 Setup User Default

```bash
# Buat user admin
php artisan make:filament-user

# atau melalui tinker
php artisan tinker
>>> User::create([
    'name' => 'Admin',
    'email' => 'admin@desa.id',
    'password' => Hash::make('password123')
]);
```

### 🎯 Menjalankan Aplikasi

```bash
# Jalankan development server
php artisan serve

# Jalankan queue worker (jika menggunakan queue)
php artisan queue:work

# Jalankan scheduler (untuk task otomatis)
php artisan schedule:work
```

Akses aplikasi di: `http://localhost:8000`

## 📁 Struktur Project

```
layanan-desa-laravel/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── SuratKeterangan.php
│   │   ├── SuratPengantar.php
│   │   └── SuratIzin.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── assets/
├── routes/
│   ├── web.php
│   └── api.php
├── config/
└── public/
```

## 👥 Default Login

**Admin:**
- Email: admin@desa.id
- Password: password123

**Warga:**
- Email: warga@desa.id  
- Password: password123

## 🗃️ Fitur Database

### Tabel Utama:
- `users` - Data pengguna (admin & warga)
- `surat_keterangan` - Data pengajuan surat keterangan
- `surat_pengantar` - Data pengajuan surat pengantar
- `surat_izin` - Data pengajuan surat izin
- `layanan` - Data master layanan
- `status_pengajuan` - Tracking status

## 🔧 Development

```bash
# Clear cache
php artisan optimize:clear

# Generate ide helper
php artisan ide-helper:generate

# Run tests
php artisan test

# Check routes
php artisan route:list
```

## 🌐 Production Deployment

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migration in production
php artisan migrate --force
```

## 🤝 Kontribusi

1. Fork project
2. Create feature branch (`git checkout -b feature/NewFeature`)
3. Commit changes (`git commit -m 'Add NewFeature'`)
4. Push branch (`git push origin feature/NewFeature`)
5. Open Pull Request

## 📝 Todo List

- [ ] Integrasi payment gateway
- [ ] API untuk mobile app
- [ ] Export laporan PDF/Excel
- [ ] Sistem notifikasi email/SMS
- [ ] Integrasi dengan sistem eksternal

## 🐛 Troubleshooting

**Common Issues:**

```bash
# Permission error
chmod -R 775 storage bootstrap/cache

# Composer error
composer dump-autoload

# Node modules error
rm -rf node_modules package-lock.json
npm install
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

Jika mengalami masalah:
1. Check [Issues](../../issues)
2. Buat issue baru dengan detail error
3. Contact: dev@desa.id

---

<div align="center">

### 🚀 Built with Laravel & ❤️

**Jangan lupa untuk ⭐ repository ini!**

</div>
