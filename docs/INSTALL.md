# Panduan Instalasi & Menjalankan Proyek — SMP Negeri 2 Juwangi

Proyek ini menggunakan arsitektur modular yang terpisah (*Decoupled*):
1. **Backend**: Express.js REST API (`port 5000`)
2. **Frontend**: Laravel 11 Blade + Tailwind CSS (`port 8000`)
3. **Database**: MySQL (WampServer `port 3306`, Database: `smpn2_juwangi_web`)

---

## 1. Prasyarat Sistem
- **WampServer / MySQL** (MySQL aktif di port 3306)
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

# Konfigurasi backend/.env
# Pastikan JWT_SECRET terisi string aman minimal 32 karakter:
# JWT_SECRET=smpn2_juwangi_secure_token_jwt_super_secret_key_2026

# Jalankan seeder aman (idempoten, tidak menghapus data atau mereset password admin)
npm run seed

# Jalankan server API
npm run dev    # atau node server.js
```
Server API akan aktif di: `http://localhost:5000`  
Endpoint health check: `http://localhost:5000/health`  
Upload file disimpan lokal di: `backend/public/uploads`

---

## 4. Langkah Menjalankan Frontend (Laravel Blade)
Buka terminal baru:
```powershell
cd e:\Project\Website\UJICOBA\frontend

# Install dependensi PHP (jika belum)
composer install

# Install dependensi frontend & build CSS/JS
npm install
npm run build

# Jalankan Laravel Development Server
php artisan serve --port=8000
```
Website publik dapat diakses di: `http://127.0.0.1:8000`

---

## 5. Kredensial Pengujian (Panel Admin)

Sistem menggunakan **1 role tunggal: `Admin`**.

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@smpn2juwangi.sch.id` | `password123` |

Halaman login pengelola admin: `http://127.0.0.1:8000/admin/login`

> **Peringatan Keamanan**: Form login tidak lagi menyertakan isian password bawaan secara default demi keamanan sistem. Masukkan kredensial secara manual saat pengujian.

---

## 6. Verifikasi Pengujian Integrasi
1. Buka `http://127.0.0.1:8000` di peramban. Halaman beranda sekolah akan tampil dengan:
   - Identitas & Foto Utama
   - Pengumuman Berjalan (Ticker)
   - Sambutan Pimpinan Sekolah
   - Berita & Informasi Terkini (terhubung dinamis dari Express API)
   - Counter Statistik Dinamis (terhubung langsung dari database MySQL)
   - Agenda & Pengumuman Penting
   - Jalur & Informasi PPDB 2026/2027
   - Footer & Informasi Kontak Terverifikasi Dapodik
2. Buka menu navigasi **Berita** (`/berita`) dan **Unduhan** (`/unduhan`) untuk menguji pembacaan data dan pengunduhan PDF digital.
3. Buka **Portal Admin** (`/admin/login`), masukkan kredensial Admin, dan verifikasi dasbor pengelola beserta seluruh modul CRUD.
