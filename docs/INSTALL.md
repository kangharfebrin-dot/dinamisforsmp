# Panduan Instalasi & Menjalankan Proyek — SMP Negeri 2 Juwangi

Proyek ini menggunakan arsitektur modular:
1. **Backend**: Express.js REST API (`port 5000`)
2. **Frontend**: Laravel Blade + Tailwind CSS (`port 8000`)
3. **Database**: MySQL (WampServer `port 3306`, Database: `smpn2_juwangi_web`)

---

## 1. Prasyarat Sistem
- **WampServer** (MySQL aktif di port 3306)
- **Node.js** (v18+) dan **npm**
- **PHP** (v8.2+) dengan ekstensi `pdo_mysql`, `curl`, `mbstring`
- **Composer** (v2+)

---

## 2. Langkah Setup Database
1. Buka WampServer / phpMyAdmin (`http://localhost/phpmyadmin`).
2. Buat database atau jalankan skema otomatis:
   ```powershell
   php database/import.php
   ```
   *Skema database akan diimpor dari `database/schema.sql` ke database `smpn2_juwangi_web`.*

---

## 3. Langkah Menjalankan Backend (Express.js)
```powershell
cd e:\Project\Website\UJICOBA\backend

# Install dependensi (jika belum)
npm install

# Jalankan seeder akun & data awal
npm run seed

# Jalankan server API
npm run dev    # atau node server.js
```
Server API akan aktif di: `http://localhost:5000`  
Endpoint health check: `http://localhost:5000/health`  
Upload file disimpan di: `backend/public/uploads`

---

## 4. Langkah Menjalankan Frontend (Laravel Blade)
Buka terminal baru:
```powershell
cd e:\Project\Website\UJICOBA\frontend

# Install dependensi PHP (jika belum)
composer install

# Install dependensi frontend & build CSS
npm install
npm run build

# Jalankan Laravel Development Server
php artisan serve --port=8000
```
Website publik dapat diakses di: `http://localhost:8000`

---

## 5. Kredensial Pengujian (Default Seed)

| Role | Email | Password |
|---|---|---|
| **Super Admin** | `superadmin@smpn2juwangi.sch.id` | `password123` |
| **Admin** | `admin@smpn2juwangi.sch.id` | `password123` |
| **Editor** | `editor@smpn2juwangi.sch.id` | `password123` |

Halaman login pengelola admin: `http://localhost:8000/admin/login`

---

## 6. Verifikasi Pengujian Integrasi
1. Buka `http://localhost:8000` di peramban. Halaman **Fase 1: Beranda Sekolah** akan tampil dengan:
   - Identitas & Foto Utama
   - Pengumuman Berjalan (Ticker)
   - Sambutan Resmi Kepala Sekolah
   - Berita & Artikel Terbaru (terhubung dinamis dari Express API)
   - Agenda & Pengumuman Penting
   - Prestasi Siswa Terkini
   - Jalur & Informasi PPDB 2026/2027
   - Footer & Informasi Kontak
2. Buka menu navigasi **Berita & Artikel** (`/berita`) dan klik salah satu artikel untuk membaca isi lengkap.
3. Buka **Portal Admin** (`/admin/login`), masukkan kredensial di atas, dan verifikasi dasbor pengelola.
