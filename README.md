# Website Dinamis SMP Negeri 2 Juwangi

Aplikasi web portal dinamis untuk SMP Negeri 2 Juwangi yang dibangun dengan arsitektur modern terpisah (Decoupled Architecture):
- **Backend**: Express.js REST API (`port 5000`)
- **Frontend**: Laravel 11 Blade + Tailwind CSS (`port 8000`)
- **Database**: MySQL (`smpn2_juwangi_web`)

---

## 📁 Struktur Direktori

```text
├── backend/          # Node.js Express REST API server
│   ├── src/          # Controllers, routes, models, middleware
│   ├── public/       # Public static files & uploads
│   └── server.js     # Entry point server Express
├── frontend/         # Laravel 11 Blade web interface
│   ├── app/          # Controllers, services, HTTP client API
│   ├── resources/    # Blade templates & Tailwind CSS assets
│   └── routes/       # Web routes
├── database/         # Skema MySQL & script import
│   ├── schema.sql    # DDL & initial records
│   └── import.php    # Script import database otomatis
└── docs/             # Dokumentasi API & instalasi lengkap
    ├── API.md        # Spesifikasi REST API
    └── INSTALL.md    # Panduan instalasi dan deployment
```

---

## 🚀 Panduan Cepat Menjalankan

### 1. Database MySQL
Pastikan MySQL (WampServer/XAMPP) aktif di port 3306, lalu import database:
```powershell
php database/import.php
```

### 2. Backend (Express.js)
```powershell
cd backend
npm install
npm run seed     # Inisialisasi akun & data awal
npm run dev      # Berjalan di http://localhost:5000
```

### 3. Frontend (Laravel Blade)
```powershell
cd frontend
composer install
npm install
npm run build
php artisan serve --port=8000    # Berjalan di http://localhost:8000
```

---

## 🔑 Kredensial Default Pengujian

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `superadmin@smpn2juwangi.sch.id` | `password123` |
| **Admin** | `admin@smpn2juwangi.sch.id` | `password123` |
| **Editor** | `editor@smpn2juwangi.sch.id` | `password123` |

Portal admin dapat diakses di: `http://localhost:8000/admin/login`

---

## 📖 Dokumentasi Lengkap
- [Panduan Instalasi & Menjalankan](docs/INSTALL.md)
- [Dokumentasi API & Endpoint](docs/API.md)
