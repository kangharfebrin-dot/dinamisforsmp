# Website Dinamis SMP Negeri 2 Juwangi

Portal informasi dan sistem manajemen konten (CMS) resmi untuk **SMP Negeri 2 Juwangi**, Kabupaten Boyolali, Jawa Tengah. Dibangun dengan arsitektur terpisah (*Decoupled Architecture*) yang modern, aman, dan berkinerja tinggi:
- **Backend API**: Node.js Express.js REST API (`port 5000`)
- **Frontend Web**: Laravel 11 Blade + Tailwind CSS (`port 8000`)
- **Database**: MySQL (`smpn2_juwangi_web`)

---

## 🏛️ Identitas Resmi Satuan Pendidikan

Berdasarkan data resmi Dapodik Kementerian Pendidikan Dasar dan Menengah (Kemendikdasmen):
- **Nama Sekolah**: SMP Negeri 2 Juwangi
- **NPSN**: `20308482`
- **Alamat**: Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391
- **Telepon / Kontak**: `085642696466`
- **Email Resmi**: `smpn2juwang@gmail.com`
- **Akreditasi**: `A` (BAN-S/M)
- **Bentuk Pendidikan**: SMP Negeri / Pemerintah Daerah

---

## 📁 Struktur Direktori Repositori

```text
├── backend/                  # Node.js Express.js REST API Server
│   ├── src/                  # Controllers, routes, middleware, db pool, seeder
│   │   ├── controllers/      # Logika bisnis API & validasi
│   │   ├── middleware/       # Autentikasi JWT & upload multer
│   │   ├── routes/           # Endpoint publik & proteksi admin
│   │   └── seed.js           # Seeder aman (idempoten & non-destruktif)
│   ├── public/uploads/       # Aset lokal (foto fasilitas, berita, logo, PDF)
│   └── server.js             # Entrypoint server & validasi environment
├── frontend/                 # Laravel 11 Web Application
│   ├── app/                  # Controller web, ApiClient service, middleware
│   ├── resources/views/      # Template Blade publik & panel admin
│   └── public/               # Favicon (.svg, .ico), CSS, JS terkompilasi
├── database/                 # Skema MySQL & utilitas import
│   ├── schema.sql            # DDL tabel & foreign key constraints
│   └── import.php            # Skrip import database otomatis
└── docs/                     # Dokumentasi teknis & kepatuhan lisensi
    ├── API.md                # Spesifikasi lengkap REST API
    ├── INSTALL.md            # Panduan instalasi dan deployment
    └── ASSET_SOURCES.md      # Asal-usul, dimensi, lisensi seluruh berkas media
```

---

## 🚀 Panduan Menjalankan Aplikasi

### 1. Prasyarat Sistem
- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `curl`, `mbstring`)
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL >= 8.0 atau MariaDB >= 10.4

### 2. Konfigurasi Basis Data
Import skema basis data ke MySQL:
```powershell
php database/import.php
```

### 3. Menjalankan Backend (Express.js)
```powershell
cd backend
npm install

# Jalankan seeder aman (tidak mereset password Admin yang sudah ada)
npm run seed

# Jalankan backend REST API (berjalan di http://localhost:5000)
npm run dev
```

> **Catatan Keamanan JWT**: File `backend/.env` wajib memiliki variabel `JWT_SECRET` dengan panjang minimal 32 karakter. Server tidak akan berjalan jika rahasia ini belum dikonfigurasi.

### 4. Menjalankan Frontend (Laravel 11)
```powershell
cd frontend
composer install
npm install
npm run build

# Jalankan server frontend Laravel (berjalan di http://127.0.0.1:8000)
php artisan serve --port=8000
```

---

## 🔐 Hak Akses & Panel Admin

Sistem menerapkan prinsip *single responsibility* dan membatasi otorisasi hanya pada **1 role tunggal: `Admin`** (tidak ada peran `Super Admin` atau `Editor` yang terpisah).

- **URL Login Admin**: `http://127.0.0.1:8000/admin/login`
- **Email Akun Admin**: `admin@smpn2juwangi.sch.id`
- **Password Default Awal**: `password123` *(Segera ubah password setelah instalasi pertama kali)*
- **Fitur Keamanan Form Login**: Field password tidak memuat nilai bawaan secara otomatis dan tidak menampilkan bocoran kredensial di antarmuka publik demi menjaga integritas keamanan sistem.

---

## 🖼️ Kebijakan Aset & Privasi Media

Seluruh aset gambar (hero banner, logo sekolah, fasilitas, ekstrakurikuler, berita) dan dokumen PDF (Kalender Akademik, Tata Tertib, Brosur PPDB) disimpan secara lokal di `backend/public/uploads/` dan disajikan tanpa tautan eksternal yang rentan 404.

Sesuai etika dan kepatuhan privasi:
1. **Tidak ada rekayasa foto wajah**: Foto kepala sekolah, guru, maupun peserta didik tidak dikarang dengan foto orang lain. Foto yang belum diverifikasi ditampilkan dengan monogram/crest resmi yang bermartabat.
2. Seluruh dokumentasi lisensi, dimensi berkas, dan sumber daya tercatat secara transparan pada [`docs/ASSET_SOURCES.md`](docs/ASSET_SOURCES.md).

---

## 🧪 Pengujian Otomatis

Untuk memastikan seluruh endpoint publik, admin, autentikasi, unduhan PDF, dan gambar berfungsi normal:
```powershell
# Uji API dan Frontend
node tests/full_audit_test.js
```

---

## 📖 Dokumentasi Terkait
- [Dokumentasi REST API](docs/API.md)
- [Panduan Instalasi & Deployment](docs/INSTALL.md)
- [Sumber dan Lisensi Aset](docs/ASSET_SOURCES.md)
