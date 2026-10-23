# Dokumentasi REST API — Website SMP Negeri 2 Juwangi

**Base URL**: `http://localhost:5000/api`  
**Autentikasi**: JSON Web Token (Bearer `<token>`) dikirimkan pada header `Authorization`.  
**Keamanan**: `JWT_SECRET` wajib didefinisikan di environment file (`.env`) dengan panjang minimal 32 karakter demi keamanan sesi.  
**Role Pengguna**: Hanya ada 1 role sistem yang aktif: `Admin`.

---

## 1. Identitas Resmi Sekolah (Kemendikdasmen Dapodik)

- **Nama Sekolah**: SMP Negeri 2 Juwangi
- **NPSN**: `20308482`
- **Alamat**: Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391
- **Telepon / Kontak**: `085642696466`
- **Email Resmi**: `smpn2juwang@gmail.com`
- **Akreditasi**: `A` (BAN-S/M)

---

## 2. Endpoint Publik (Tanpa Autentikasi)

### 2.1 Profil Sekolah
- **URL**: `GET /profile`
- **Deskripsi**: Mengambil data profil resmi sekolah, kontak, visi, misi, dan pimpinan.
- **Respons (200 OK)**:
```json
{
  "success": true,
  "data": {
    "name": "SMP Negeri 2 Juwangi",
    "npsn": "20308482",
    "tagline": "Cerdas, Berkarakter, Berakhlak Mulia, dan Berprestasi",
    "accreditation": "A",
    "principal_name": "Kepala SMP Negeri 2 Juwangi",
    "principal_nip": "-",
    "vision": "Terwujudnya Peserta Didik yang Berakhlak Mulia, Cerdas, Terampil, Mandiri, dan Berbudaya Lingkungan.",
    "mission": "1. Menumbuhkan penghayatan dan pengamalan ajaran agama...\n2. Mengembangkan proses pembelajaran yang kreatif...\n3. Menumbuhkan semangat keunggulan...\n4. Mendorong pelestarian lingkungan hidup...",
    "address": "Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391",
    "phone": "085642696466",
    "email": "smpn2juwang@gmail.com",
    "logo": "/uploads/logo-smpn2.png",
    "hero_banner": "/uploads/hero-banner.jpg"
  }
}
```

### 2.2 Berita & Artikel
- **URL**: `GET /news`
- **Query Params**:
  - `page`: nomor halaman (default: `1`)
  - `limit`: jumlah per halaman (default: `10`, max: `50`)
  - `q`: kata kunci pencarian judul/ringkasan
  - `category`: slug kategori (contoh: `prestasi-siswa`)
  - `status`: status berita (`published` atau `draft`)
- **Respons (200 OK)**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Sosialisasi Penerimaan Peserta Didik Baru (PPDB) 2026/2027",
      "slug": "sosialisasi-ppdb-2026-2027",
      "excerpt": "Informasi resmi jadwal, persyaratan zonasi, afirmasi, dan prestasi.",
      "cover_image": "/uploads/berita-ppdb.jpg",
      "category_name": "Pengumuman",
      "author_name": "Admin Humas SMPN 2 Juwangi",
      "views_count": 120,
      "published_at": "2026-10-23 08:00:00"
    }
  ],
  "meta": {
    "page": 1,
    "limit": 10,
    "total": 1,
    "total_pages": 1
  }
}
```

- **URL**: `GET /news/:slug`
- **Deskripsi**: Mengambil detail lengkap artikel berita berdasarkan slug beserta artikel terkait.

- **URL**: `GET /news/categories`
- **Deskripsi**: Daftar seluruh kategori berita dan jumlah artikel terbit.

### 2.3 Pengumuman
- **URL**: `GET /announcements?limit=5`
- **Deskripsi**: Daftar pengumuman resmi terbit yang diurutkan berdasarkan prioritas dan tanggal terbit.

### 2.4 Agenda Kegiatan
- **URL**: `GET /agendas?limit=5`
- **Deskripsi**: Jadwal dan agenda kegiatan sekolah mendatang.

### 2.5 Dewan Guru & Staf
- **URL**: `GET /teachers?type=guru` (atau `type=tendik`)
- **Deskripsi**: Daftar guru pengampu dan tenaga kependidikan sekolah.

### 2.6 Prestasi Siswa
- **URL**: `GET /achievements?limit=10`
- **Deskripsi**: Rekapitulasi prestasi akademik & non-akademik siswa yang telah diverifikasi.

### 2.7 Fasilitas Sekolah
- **URL**: `GET /facilities`
- **Deskripsi**: Daftar sarana dan prasarana pendukung pembelajaran di SMPN 2 Juwangi.

### 2.8 Ekstrakurikuler
- **URL**: `GET /extracurriculars`
- **Deskripsi**: Daftar kegiatan ekstrakurikuler siswa (Pramuka, Futsal, PMR, Karawitan).

### 2.9 Galeri Foto
- **URL**: `GET /galleries`
- **Deskripsi**: Dokumentasi kegiatan dan fasilitas sekolah.

### 2.10 Dokumen Unduhan
- **URL**: `GET /documents`
- **Deskripsi**: Daftar berkas resmi sekolah yang dapat diunduh (PDF).
- **URL**: `GET /documents/:id/download`
- **Deskripsi**: Mengambil URL unduh dan menambahkan counter `download_count`.

### 2.11 Statistik Ringkas
- **URL**: `GET /stats`
- **Deskripsi**: Total agregasi berita, guru, staf, prestasi, fasilitas, dan ekskul untuk counter beranda.

---

## 3. Autentikasi Pengelola

Sistem hanya memiliki 1 role tunggal: `Admin`.

### 3.1 Login
- **URL**: `POST /auth/login`
- **Body (JSON)**:
```json
{
  "email": "admin@smpn2juwangi.sch.id",
  "password": "<password-anda>"
}
```
- **Respons (200 OK)**:
```json
{
  "success": true,
  "message": "Login berhasil.",
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI...",
  "user": {
    "id": 1,
    "name": "Admin Humas SMPN 2 Juwangi",
    "email": "admin@smpn2juwangi.sch.id",
    "role": "admin",
    "avatar": null
  }
}
```

### 3.2 Profil Pengguna Login
- **URL**: `GET /auth/me`
- **Header**: `Authorization: Bearer <token>`

---

## 4. Endpoint Panel Admin (CRUD)

Header wajib: `Authorization: Bearer <token>`  
Akses: Role `Admin`

| Method | Endpoint | Keterangan |
|---|---|---|
| `GET` | `/admin/dashboard-summary` | Ringkasan kartu counter statistik & aktivitas terbaru |
| `GET` | `/admin/news` | Daftar berita (termasuk draft & pagination) |
| `POST` | `/admin/news` | Tambah berita baru (multipart/form-data cover_image) |
| `PUT` | `/admin/news/:id` | Perbarui berita |
| `DELETE` | `/admin/news/:id` | Hapus berita |
| `GET/POST/PUT/DELETE` | `/admin/categories` | Kelola kategori berita |
| `GET/POST/PUT/DELETE` | `/admin/announcements` | Kelola pengumuman sekolah |
| `GET/POST/PUT/DELETE` | `/admin/agendas` | Kelola agenda kegiatan |
| `GET/PUT` | `/admin/profile` | Kelola data profil, kontak, visi misi, logo & banner |
| `GET/POST/PUT/DELETE` | `/admin/teachers` | Kelola pendidik & tenaga kependidikan |
| `GET/POST/PUT/DELETE` | `/admin/achievements` | Kelola prestasi siswa |
| `GET/POST/PUT/DELETE` | `/admin/facilities` | Kelola fasilitas sekolah |
| `GET/POST/PUT/DELETE` | `/admin/extracurriculars` | Kelola kegiatan ekstrakurikuler |
| `GET/POST/PUT/DELETE` | `/admin/galleries` | Kelola galeri dokumentasi foto |
| `GET/POST/DELETE` | `/admin/documents` | Unggah & kelola dokumen publik (PDF) |
| `GET/POST/PUT/DELETE` | `/admin/users` | Kelola akun Admin |
