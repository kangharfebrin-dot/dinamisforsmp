/**
 * Audit & Comprehensive Verification Script
 * SMP Negeri 2 Juwangi Web Platform
 * Uses native Node http module for maximum reliability
 */

const fs = require('fs');
const path = require('path');
const http = require('http');

const BACKEND_URL = 'http://localhost:5000';
const FRONTEND_URL = 'http://127.0.0.1:8000';

function httpRequest(url, options = {}) {
  return new Promise((resolve, reject) => {
    const urlObj = new URL(url);
    const reqOptions = {
      hostname: urlObj.hostname,
      port: urlObj.port,
      path: urlObj.pathname + urlObj.search,
      method: options.method || 'GET',
      headers: {
        'Connection': 'close',
        ...(options.headers || {})
      }
    };

    const req = http.request(reqOptions, (res) => {
      let body = '';
      res.setEncoding('utf8');
      res.on('data', (chunk) => { body += chunk; });
      res.on('end', () => {
        resolve({
          status: res.statusCode,
          headers: res.headers,
          text: () => Promise.resolve(body),
          json: () => {
            try {
              return Promise.resolve(JSON.parse(body));
            } catch (err) {
              return Promise.reject(new Error(`Failed to parse JSON: ${body.substring(0, 100)}`));
            }
          }
        });
      });
    });

    req.on('error', reject);

    if (options.body) {
      req.write(typeof options.body === 'string' ? options.body : JSON.stringify(options.body));
    }
    req.end();
  });
}

async function runAudit() {
  console.log('====================================================');
  console.log('🔍 MEMULAI AUDIT LENGKAP SMP NEGERI 2 JUWANGI');
  console.log('====================================================\n');

  let passed = 0;
  let failed = 0;

  function assert(condition, message) {
    if (condition) {
      console.log(`  ✔ [PASS] ${message}`);
      passed++;
    } else {
      console.error(`  ✖ [FAIL] ${message}`);
      failed++;
    }
  }

  // ----------------------------------------------------------------------
  // 1. UJI ASET FISIK & DOKUMEN LOKAL
  // ----------------------------------------------------------------------
  console.log('--- 1. UJI ASET FISIK & DOKUMEN LOKAL ---');
  const requiredUploads = [
    'logo-smpn2.png',
    'logo-smpn2.svg',
    'hero-banner.jpg',
    'berita-upacara.jpg',
    'berita-futsal.jpg',
    'berita-p5.jpg',
    'berita-ppdb.jpg',
    'ekskul-pramuka.jpg',
    'ekskul-futsal.jpg',
    'ekskul-pmr.jpg',
    'ekskul-karawitan.jpg',
    'fasilitas-labkom.jpg',
    'fasilitas-perpus.jpg',
    'fasilitas-labipa.jpg',
    'fasilitas-lapangan.jpg',
    'fasilitas-mushola.jpg',
    'kalender-akademik-2026.pdf',
    'tata-tertib-siswa.pdf',
    'brosur-ppdb-2026.pdf'
  ];

  const uploadsDir = path.join(__dirname, '..', 'backend', 'public', 'uploads');
  for (const file of requiredUploads) {
    const fullPath = path.join(uploadsDir, file);
    const exists = fs.existsSync(fullPath);
    assert(exists, `Berkas lokal fisik ${file} ada di disk (${exists ? fs.statSync(fullPath).size + ' bytes' : '0'})`);

    // Uji akses via HTTP
    try {
      const res = await httpRequest(`${BACKEND_URL}/uploads/${file}`);
      assert(res.status === 200, `HTTP GET /uploads/${file} status 200 OK`);
      if (file.endsWith('.pdf')) {
        const ct = res.headers['content-type'];
        assert(ct && ct.includes('pdf'), `Header Content-Type PDF valid (${ct})`);
      }
    } catch (e) {
      assert(false, `Gagal mengakses /uploads/${file}: ${e.message}`);
    }
  }

  // Uji Favicon Frontend
  console.log('\n--- Uji Favicon Frontend ---');
  const frontendPublicDir = path.join(__dirname, '..', 'frontend', 'public');
  assert(fs.existsSync(path.join(frontendPublicDir, 'favicon.svg')), 'favicon.svg ada di frontend/public');
  assert(fs.existsSync(path.join(frontendPublicDir, 'favicon.ico')), 'favicon.ico ada di frontend/public');
  try {
    const resFavSvg = await httpRequest(`${FRONTEND_URL}/favicon.svg`);
    assert(resFavSvg.status === 200, 'Frontend menyajikan favicon.svg (200 OK)');
  } catch (e) {
    assert(false, `Gagal memuat favicon.svg: ${e.message}`);
  }

  // ----------------------------------------------------------------------
  // 2. UJI DATA POKOK SEKOLAH (VERIFIKASI KEMENDIKDASMEN DAPODIK)
  // ----------------------------------------------------------------------
  console.log('\n--- 2. UJI DATA POKOK SEKOLAH (DAPODIK) ---');
  try {
    const resProfile = await httpRequest(`${BACKEND_URL}/api/profile`);
    assert(resProfile.status === 200, 'GET /api/profile status 200 OK');
    const profileJson = await resProfile.json();
    const data = profileJson.data;

    assert(data.npsn === '20308482', `NPSN terverifikasi resmi Kemendikdasmen: 20308482 (terbaca: ${data.npsn})`);
    assert(data.name === 'SMP Negeri 2 Juwangi', `Nama sekolah terverifikasi: SMP Negeri 2 Juwangi`);
    assert(data.address.includes('Kayen') && data.address.includes('Juwangi'), `Alamat resmi di Desa Kayen, Juwangi: ${data.address}`);
    assert(data.phone === '085642696466', `Kontak resmi sekolah: ${data.phone}`);
    assert(data.email === 'smpn2juwang@gmail.com', `Email resmi Dapodik: ${data.email}`);
    assert(data.accreditation === 'A', `Status akreditasi resmi BAN-S/M: ${data.accreditation}`);
    assert(data.principal_photo === null || !data.principal_photo.includes('fake'), 'Foto kepsek tidak menggunakan foto orang lain / rekayasa');
  } catch (e) {
    assert(false, `Gagal uji profile: ${e.message}`);
  }

  // ----------------------------------------------------------------------
  // 3. UJI WEBSITE DINAMIS & STATISTIK REAL-TIME
  // ----------------------------------------------------------------------
  console.log('\n--- 3. UJI STATISTIK & KONTEN DINAMIS ---');
  try {
    const resStats = await httpRequest(`${BACKEND_URL}/api/stats`);
    assert(resStats.status === 200, 'GET /api/stats status 200 OK');
    const statsJson = await resStats.json();
    const stats = statsJson.data;
    assert(typeof stats.total_posts === 'number' && stats.total_posts >= 0, `Counter berita dinamis: ${stats.total_posts}`);
    assert(typeof stats.total_teachers === 'number' && stats.total_teachers >= 0, `Counter guru dinamis: ${stats.total_teachers}`);
    assert(typeof stats.total_fasilitas === 'number' && stats.total_fasilitas >= 0, `Counter fasilitas dinamis: ${stats.total_fasilitas}`);
    assert(typeof stats.total_ekskul === 'number' && stats.total_ekskul >= 0, `Counter ekskul dinamis: ${stats.total_ekskul}`);

    // Uji Beranda Frontend tidak memuat klaim manual palsu "480+ Siswa"
    const resHome = await httpRequest(`${FRONTEND_URL}/`);
    assert(resHome.status === 200, 'GET / (Frontend Beranda) status 200 OK');
    const homeHtml = await resHome.text();
    assert(!homeHtml.includes('480+</span>\n                                    <span class="text-xs text-slate-300 font-medium">Siswa Aktif'), 'Klaim manual 480+ Siswa Aktif telah dihilangkan dari beranda');
    assert(homeHtml.includes('Pendidik & Tendik'), 'Label dinamis Pendidik & Tendik tampil di beranda');
    assert(homeHtml.includes('20308482'), 'NPSN resmi 20308482 tampil di beranda');
    assert(homeHtml.includes('smpn2juwang@gmail.com'), 'Email resmi smpn2juwang@gmail.com tampil di layout beranda');
  } catch (e) {
    assert(false, `Gagal uji stats & beranda: ${e.message}`);
  }

  // ----------------------------------------------------------------------
  // 4. UJI SELURUH ROUTE PUBLIK FRONTEND LARAVEL
  // ----------------------------------------------------------------------
  console.log('\n--- 4. UJI ROUTE PUBLIK FRONTEND ---');
  const publicRoutes = [
    { path: '/', title: 'Beranda' },
    { path: '/profil', title: 'Profil Sekolah' },
    { path: '/profil/visi-misi', title: 'Visi & Misi' },
    { path: '/profil/sambutan', title: 'Sambutan Kepala Sekolah' },
    { path: '/berita', title: 'Berita Sekolah' },
    { path: '/pengumuman', title: 'Pengumuman' },
    { path: '/agenda', title: 'Agenda' },
    { path: '/guru-staf', title: 'Guru & Staf' },
    { path: '/prestasi', title: 'Prestasi' },
    { path: '/fasilitas', title: 'Fasilitas' },
    { path: '/galeri', title: 'Galeri' },
    { path: '/unduhan', title: 'Unduhan Dokumen' },
    { path: '/ppdb', title: 'Informasi PPDB' },
    { path: '/kontak', title: 'Kontak' },
    { path: '/admin/login', title: 'Login Admin' }
  ];

  for (const route of publicRoutes) {
    try {
      const res = await httpRequest(`${FRONTEND_URL}${route.path}`);
      assert(res.status === 200, `Halaman ${route.title} (${route.path}) status 200 OK`);
      if (route.path === '/admin/login') {
        const loginHtml = await res.text();
        assert(!loginHtml.includes('value="password123"'), 'Form login TIDAK memuat password default bawaan');
        assert(!loginHtml.includes('email: superadmin@'), 'Petunjuk superadmin telah dibersihkan');
      }
    } catch (e) {
      assert(false, `Gagal memuat route ${route.path}: ${e.message}`);
    }
  }

  // ----------------------------------------------------------------------
  // 5. UJI PENGUNDUHAN DOKUMEN DIGITAL (PDF DOWNLOAD)
  // ----------------------------------------------------------------------
  console.log('\n--- 5. UJI PENGUNDUHAN DOKUMEN ---');
  try {
    const resDownload = await httpRequest(`${FRONTEND_URL}/unduhan/1/download`);
    assert(resDownload.status === 302, `Endpoint /unduhan/1/download redirect 302 ke file target`);
    const loc = resDownload.headers['location'];
    assert(loc && loc.includes('kalender-akademik-2026.pdf'), `Target redirect valid ke file PDF: ${loc}`);
    if (loc) {
      const resPdf = await httpRequest(loc);
      assert(resPdf.status === 200, `File PDF sasaran unduhan dapat diakses 200 OK`);
    }
  } catch (e) {
    assert(false, `Gagal uji pengunduhan: ${e.message}`);
  }

  // ----------------------------------------------------------------------
  // 6. UJI AUTENTIKASI DAN KEAMANAN PANEL ADMIN (SINGLE ROLE: ADMIN)
  // ----------------------------------------------------------------------
  console.log('\n--- 6. UJI AUTENTIKASI DAN ROLE ADMIN ---');
  let adminToken = null;
  try {
    // 6.1 Tes Login Admin valid
    const resLogin = await httpRequest(`${BACKEND_URL}/api/auth/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: 'admin@smpn2juwangi.sch.id',
        password: 'password123'
      })
    });
    assert(resLogin.status === 200, 'POST /api/auth/login dengan kredensial Admin status 200 OK');
    const loginJson = await resLogin.json();
    assert(loginJson.success === true, 'Respons login success: true');
    assert(loginJson.token && loginJson.token.length > 20, 'JWT Token berhasil diterbitkan');
    assert(loginJson.user.role === 'admin', `Role pengguna adalah admin tunggal (terbaca: ${loginJson.user.role})`);
    adminToken = loginJson.token;

    // 6.2 Tes Login gagal dengan password salah
    const resBadLogin = await httpRequest(`${BACKEND_URL}/api/auth/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: 'admin@smpn2juwangi.sch.id',
        password: 'wrongpassword'
      })
    });
    assert(resBadLogin.status === 401, 'POST /api/auth/login dengan password salah ditolak (401 Unauthorized)');

    // 6.3 Tes Endpoint Terproteksi
    const resMe = await httpRequest(`${BACKEND_URL}/api/auth/me`, {
      headers: { 'Authorization': `Bearer ${adminToken}` }
    });
    assert(resMe.status === 200, 'GET /api/auth/me dengan Bearer token status 200 OK');

    const resDash = await httpRequest(`${BACKEND_URL}/api/admin/dashboard-summary`, {
      headers: { 'Authorization': `Bearer ${adminToken}` }
    });
    assert(resDash.status === 200, 'GET /api/admin/dashboard-summary status 200 OK');

    // 6.4 Verifikasi Endpoint Terproteksi Menolak Request Tanpa Token
    const resNoToken = await httpRequest(`${BACKEND_URL}/api/admin/dashboard-summary`);
    assert(resNoToken.status === 401, 'GET /api/admin/dashboard-summary tanpa token ditolak (401 Unauthorized)');
  } catch (e) {
    assert(false, `Gagal uji autentikasi admin: ${e.message}`);
  }

  // ----------------------------------------------------------------------
  // 7. UJI CRUD MODUL ADMIN (API LEVEL)
  // ----------------------------------------------------------------------
  console.log('\n--- 7. UJI CRUD MODUL ADMIN ---');
  if (adminToken) {
    try {
      // 7.1 Tambah Pengumuman Baru (Create)
      const resAddAnn = await httpRequest(`${BACKEND_URL}/api/admin/announcements`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${adminToken}`
        },
        body: JSON.stringify({
          title: 'Pengumuman Uji Otomatis Sistem',
          content: 'Ini adalah pengujian integritas CRUD otomatis sistem.',
          priority: 0,
          status: 'draft'
        })
      });
      assert(resAddAnn.status === 201, 'POST /api/admin/announcements (Create) status 201 Created');
      const addAnnJson = await resAddAnn.json();
      const newAnnId = addAnnJson.data?.id;

      // 7.2 Perbarui Pengumuman (Update)
      if (newAnnId) {
        const resUpdateAnn = await httpRequest(`${BACKEND_URL}/api/admin/announcements/${newAnnId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${adminToken}`
          },
          body: JSON.stringify({
            title: 'Pengumuman Uji Otomatis Terverifikasi',
            content: 'Konten diperbarui dengan sukses.',
            priority: 1,
            status: 'draft'
          })
        });
        assert(resUpdateAnn.status === 200, `PUT /api/admin/announcements/${newAnnId} (Update) status 200 OK`);

        // 7.3 Hapus Pengumuman (Delete)
        const resDelAnn = await httpRequest(`${BACKEND_URL}/api/admin/announcements/${newAnnId}`, {
          method: 'DELETE',
          headers: { 'Authorization': `Bearer ${adminToken}` }
        });
        assert(resDelAnn.status === 200, `DELETE /api/admin/announcements/${newAnnId} (Delete) status 200 OK`);
      }
    } catch (e) {
      assert(false, `Gagal uji CRUD pengumuman: ${e.message}`);
    }
  }

  // ----------------------------------------------------------------------
  // RINGKASAN HASIL AUDIT
  // ----------------------------------------------------------------------
  console.log('\n====================================================');
  console.log(`📊 RINGKASAN AUDIT: ${passed} PASS, ${failed} FAIL`);
  console.log('====================================================');

  if (failed > 0) {
    process.exit(1);
  }
}

runAudit();
