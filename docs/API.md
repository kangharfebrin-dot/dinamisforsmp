# Dokumentasi REST API — Website SMP Negeri 2 Juwangi

**Base URL**: `http://localhost:5000/api`  
**Autentikasi**: JSON Web Token (Bearer `<token>`) dikirimkan pada header `Authorization`.

---

## 1. Endpoint Publik (Tanpa Autentikasi)

### 1.1 Profil Sekolah
- **URL**: `GET /profile`
- **Deskripsi**: Mengambil data profil resmi sekolah, kontak, visi, misi, dan pimpinan.
- **Respons (200 OK)**:
```json
{
  "success": true,
  "data": {
    "name": "SMP Negeri 2 Juwangi",
    "npsn": "20308253",
    "tagline": "Cerdas, Berkarakter, Berakhlak Mulia, dan Berprestasi",
    "principal_name": "Drs. H. Mulyono, M.Pd.",
    "principal_nip": "19680512 199403 1 005",
    "vision": "...",
    "mission": "...",
    "address": "Jl. Raya Juwangi - Kedungombo Km. 2, Juwangi, Boyolali...",
    "phone": "(0298) 610023",
    "email": "info@smpn2juwangi.sch.id"
  }
}
```

### 1.2 Berita & Artikel
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
      "title": "Upacara Peringatan Hari Pahlawan...",
      "slug": "upacara-peringatan-hari-pahlawan...",
      "excerpt": "...",
      "cover_image": "/uploads/berita-upacara.jpg",
      "category_name": "Berita Sekolah",
      "author_name": "Super Administrator",
      "views_count": 245,
      "published_at": "2026-10-22 10:00:00"
    }
  ],
  "meta": {
    "page": 1,
    "limit": 10,
    "total": 4,
    "total_pages": 1
  }
}
```

- **URL**: `GET /news/:slug`
- **Deskripsi**: Mengambil detail lengkap artikel berita beserta 3 artikel terkait.

- **URL**: `GET /news/categories`
- **Deskripsi**: Daftar seluruh kategori berita dan jumlah artikel terbit.

### 1.3 Pengumuman
- **URL**: `GET /announcements?limit=5`
- **Deskripsi**: Daftar pengumuman resmi terbit yang diurutkan berdasarkan prioritas dan tanggal terbit.

### 1.4 Agenda Kegiatan
- **URL**: `GET /agendas?limit=5`
- **Deskripsi**: Jadwal dan agenda kegiatan sekolah mendatang.

### 1.5 Dewan Guru & Staf
- **URL**: `GET /teachers?type=guru` (atau `type=tendik`)
- **Deskripsi**: Daftar guru pengampu dan tenaga kependidikan sekolah.

### 1.6 Prestasi Siswa
- **URL**: `GET /achievements?limit=10`
- **Deskripsi**: Rekapitulasi prestasi akademik & non-akademik siswa.

### 1.7 Statistik Ringkas Beranda
- **URL**: `GET /stats`
- **Deskripsi**: Total agregasi berita, guru, staf, prestasi, dan agenda untuk widget counter beranda.

---

## 2. Autentikasi Pengelola

### 2.1 Login
- **URL**: `POST /auth/login`
- **Body (JSON)**:
```json
{
  "email": "admin@smpn2juwangi.sch.id",
  "password": "password123"
}
```
- **Respons (200 OK)**:
```json
{
  "success": true,
  "message": "Login berhasil.",
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI...",
  "user": {
    "id": 2,
    "name": "Admin Humas SMPN 2 Juwangi",
    "email": "admin@smpn2juwangi.sch.id",
    "role": "admin",
    "avatar": null
  }
}
```

### 2.2 Profil Pengguna Login
- **URL**: `GET /auth/me`
- **Header**: `Authorization: Bearer <token>`

---

## 3. Endpoint Admin (CRUD)

Header wajib: `Authorization: Bearer <token>`

| Method | Endpoint | Akses Role | Keterangan |
|---|---|---|---|
| `GET` | `/admin/dashboard-summary` | `super_admin`, `admin`, `editor` | Ringkasan kartu counter & postingan terkini |
| `GET` | `/admin/news` | `super_admin`, `admin`, `editor` | Daftar berita (termasuk draft) |
| `POST` | `/admin/news` | `super_admin`, `admin`, `editor` | Tambah berita baru (multipart/form-data) |
| `PUT` | `/admin/news/:id` | `super_admin`, `admin`, `editor` | Perbarui berita |
| `DELETE` | `/admin/news/:id` | `super_admin`, `admin` | Hapus berita |
| `GET/POST/PUT/DELETE` | `/admin/announcements` | `super_admin`, `admin`, `editor` | Kelola pengumuman |
| `GET/POST/PUT/DELETE` | `/admin/agendas` | `super_admin`, `admin`, `editor` | Kelola agenda sekolah |
| `GET/PUT` | `/admin/profile` | `super_admin`, `admin` | Kelola identitas, kontak, dan logo sekolah |
| `GET/POST/PUT/DELETE` | `/admin/teachers` | `super_admin`, `admin` | Kelola guru & staf |
| `GET/POST/PUT/DELETE` | `/admin/achievements` | `super_admin`, `admin` | Kelola catatan prestasi |
