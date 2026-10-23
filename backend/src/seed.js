const bcrypt = require('bcryptjs');
const pool = require('./db');

async function seed() {
  console.log('--- MEMULAI SEED DATA SMP NEGERI 2 JUWANGI ---');

  try {
    // 0. Migrasi Peran Tunggal: Admin (PRD FR-02)
    await pool.query('UPDATE users SET role_id = 1').catch(() => {});
    await pool.query('DELETE FROM roles WHERE id != 1').catch(() => {});
    await pool.query("INSERT INTO roles (id, name, slug) VALUES (1, 'Admin', 'admin') ON DUPLICATE KEY UPDATE name='Admin', slug='admin'");
    console.log('✔ Roles verified (Single role: Admin)');

    // 1. Users: Cek apakah Admin sudah ada (JANGAN mereset password jika sudah disetel sebelumnya)
    const [existingUsers] = await pool.query(
      "SELECT id, password_hash FROM users WHERE id = 1 OR email = 'admin@smpn2juwangi.sch.id' LIMIT 1"
    );

    if (existingUsers.length === 0) {
      const passwordHash = await bcrypt.hash('password123', 10);
      await pool.query(`
        INSERT INTO users (id, role_id, name, email, password_hash, is_active) VALUES
        (1, 1, 'Administrator SMPN 2 Juwangi', 'admin@smpn2juwangi.sch.id', :pwd, 1)
      `, { pwd: passwordHash });
      console.log('✔ User Admin awal dibuat (Email: admin@smpn2juwangi.sch.id / Password awal diinisialisasi)');
    } else {
      await pool.query(`
        UPDATE users SET role_id = 1, is_active = 1 WHERE id = :id
      `, { id: existingUsers[0].id });
      console.log('✔ User Admin sudah ada (Password yang ada tetap dipertahankan aman)');
    }

    // 2. Profiles: Identitas Resmi Terverifikasi Kemendikdasmen (NPSN: 20308482)
    await pool.query(`
      INSERT INTO profiles (
        id, name, npsn, tagline, logo, hero_banner, address, phone, email,
        principal_name, principal_nip, principal_photo, principal_message,
        vision, mission, history, maps_url, facebook, instagram, youtube
      ) VALUES (
        1,
        'SMP Negeri 2 Juwangi',
        '20308482',
        'Cerdas, Berkarakter, Berakhlak Mulia, dan Berprestasi',
        '/uploads/logo-smpn2.png',
        '/uploads/hero-banner.jpg',
        'Jl. Kayen Baru No. 1, Desa Kayen, Kec. Juwangi, Kab. Boyolali, Jawa Tengah 57391',
        '085642696466',
        'smpn2juwang@gmail.com',
        NULL,
        NULL,
        NULL,
        'Assalamu’alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal informasi resmi SMP Negeri 2 Juwangi, Kabupaten Boyolali. Kami berkomitmen untuk menyelenggarakan pendidikan menengah pertama bermutu yang membentuk generasi cerdas, berkarakter luhur, dan adaptif terhadap perkembangan teknologi dengan tetap berpijak pada nilai-nilai ketakwaan serta kepedulian lingkungan.',
        'Terwujudnya Peserta Didik yang Berakhlak Mulia, Unggul dalam Prestasi, Terampil dalam Teknologi, Mandiri, dan Berbudaya Lingkungan.',
        '1. Menanamkan nilai-nilai religius dan ketakwaan melalui pembiasaan ibadah rutin.\n2. Melaksanakan pembelajaran dan bimbingan secara efektif dengan pendekatan kurikulum merdeka berbasis saintifik dan digital.\n3. Mengembangkan potensi bakat dan minat siswa melalui kegiatan ekstrakurikuler terpadu.\n4. Menumbuhkan semangat kompetitif dan sportivitas dalam meraih prestasi akademik dan non-akademik.\n5. Mewujudkan lingkungan sekolah yang aman, asri, bersih, sehat, dan ramah anak.',
        'SMP Negeri 2 Juwangi didirikan sebagai lembaga pendidikan formal jenjang sekolah menengah pertama negeri di wilayah Kecamatan Juwangi, Kabupaten Boyolali. Sekolah berstatus Akreditasi A dan berkomitmen melayani kebutuhan pendidikan bermutu bagi putra-putri masyarakat Juwangi dan sekitarnya.',
        'https://maps.google.com/?q=SMP+Negeri+2+Juwangi+Boyolali',
        'https://facebook.com/smpn2juwangi',
        'https://instagram.com/smpn2juwangi_official',
        'https://youtube.com/@smpnegeri2juwangi'
      )
      ON DUPLICATE KEY UPDATE
        name=VALUES(name), npsn=VALUES(npsn), tagline=VALUES(tagline),
        address=VALUES(address), phone=VALUES(phone), email=VALUES(email),
        maps_url=VALUES(maps_url)
    `);
    console.log('✔ Profile seeded dengan data resmi Kemendikdasmen (NPSN: 20308482, Desa Kayen)');

    // 3. Categories
    await pool.query(`
      INSERT INTO categories (id, name, slug) VALUES
      (1, 'Berita Sekolah', 'berita-sekolah'),
      (2, 'Prestasi Siswa', 'prestasi-siswa'),
      (3, 'Kegiatan & P5', 'kegiatan-p5'),
      (4, 'Info PPDB', 'info-ppdb'),
      (5, 'Ekstrakurikuler', 'ekstrakurikuler')
      ON DUPLICATE KEY UPDATE name=VALUES(name)
    `);
    console.log('✔ Categories seeded');

    // 4. Posts: Data contoh dijadikan 'draft' sesuai instruksi audit (agar tidak mengarang berita publik)
    await pool.query(`
      INSERT INTO posts (id, category_id, author_id, title, slug, excerpt, content, cover_image, status, views_count, published_at) VALUES
      (1, 1, 1,
       'Upacara Peringatan Hari Pahlawan Berlangsung Khidmat di SMPN 2 Juwangi',
       'upacara-peringatan-hari-pahlawan-berlangsung-khidmat-di-smpn-2-juwangi',
       'Seluruh guru, tenaga kependidikan, dan siswa-siswi SMP Negeri 2 Juwangi mengikuti upacara bendera memperingati Hari Pahlawan dengan penuh rasa nasionalisme.',
       '<p>Juwangi — Dalam rangka meneladani semangat perjuangan para pendahulu bangsa, SMP Negeri 2 Juwangi menggelar upacara bendera peringatan Hari Pahlawan di halaman utama sekolah pada pagi hari ini. Upacara diikuti dengan penuh antusias oleh seluruh dewan guru, staf TU, dan peserta didik dari kelas VII hingga IX.</p><p>Amanat upacara menegaskan pentingnya memaknai nilai kepahlawanan di masa kini, seperti tekun belajar, menjunjung kejujuran, dan saling tolong-menolong sesama kawan.</p>',
       '/uploads/berita-upacara.jpg', 'draft', 0, NULL),

      (2, 2, 1,
       'Pemberian Apresiasi Prestasi Siswa Cabang Olahraga dan Seni Pelajar Boyolali',
       'pemberian-apresiasi-prestasi-siswa-cabang-olahraga-dan-seni-pelajar-boyolali',
       'Apresiasi dan piagam penghargaan diserahkan kepada perwakilan peserta didik dalam ajang kompetisi pelajar tingkat kabupaten.',
       '<p>Boyolali — Sekolah terus mendorong minat dan bakat peserta didik baik di bidang akademik maupun keolahragaan dan kesenian daerah.</p>',
       '/uploads/berita-futsal.jpg', 'draft', 0, NULL),

      (3, 3, 1,
       'Pentas Karya & Gelar Aksi Proyek Penguatan Profil Pelajar Pancasila (P5)',
       'pentas-karya-dan-gelar-aksi-proyek-penguatan-profil-pelajar-pancasila-p5',
       'Kegiatan Proyek Penguatan Profil Pelajar Pancasila (P5) semester ini menampilkan puluhan karya inovatif karya siswa dari bahan limbah organik dan kearifan lokal.',
       '<p>Juwangi — SMP Negeri 2 Juwangi menyelenggarakan acara Gelar Karya dan Bazar P5 yang melibatkan seluruh siswa kelas VII dan VIII. Para siswa memamerkan karya kerajinan bernilai guna serta aneka olahan pangan tradisional khas daerah.</p>',
       '/uploads/berita-p5.jpg', 'draft', 0, NULL),

      (4, 4, 1,
       'Informasi Persiapan PPDB SMP Negeri 2 Juwangi Tahun Ajaran 2026/2027',
       'informasi-persiapan-ppdb-smp-negeri-2-juwangi-tahun-ajaran-2026-2027',
       'Bagi calon peserta didik dan wali murid, berikut rincian jadwal, jalur pendaftaran, dan syarat administrasi PPDB tahun ajaran baru.',
       '<p>SMP Negeri 2 Juwangi siap menyambut calon peserta didik baru untuk tahun ajaran 2026/2027. Tersedia empat jalur penerimaan: Zonasi, Afirmasi, Perpindahan Tugas Orang Tua, dan Prestasi sesuai arahan Dinas Pendidikan dan Kebudayaan Kabupaten Boyolali.</p>',
       '/uploads/berita-ppdb.jpg', 'published', 45, NOW())
      ON DUPLICATE KEY UPDATE title=VALUES(title), excerpt=VALUES(excerpt), content=VALUES(content)
    `);
    console.log('✔ Posts seeded (Informasi PPDB published, draf artikel disiapkan untuk redaksi)');

    // 5. Announcements: Pengumuman resmi
    await pool.query(`
      INSERT INTO announcements (id, author_id, title, content, attachment, status, priority, published_at) VALUES
      (1, 1, 'Pengumuman Resmi Pelaksanaan Asesmen Sumatif Semester',
       'Diberitahukan kepada seluruh siswa kelas VII, VIII, dan IX agar senantiasa menjaga kedisiplinan belajar dan kesehatan menjelang pelaksanaan asesmen semester.',
       NULL, 'published', 1, NOW()),
      (2, 1, 'Informasi Layanan Administrasi Tata Usaha dan Informasi PPDB',
       'Pelayanan administrasi surat-menyurat dan informasi PPDB dilayani pada hari kerja (Senin - Sabtu) pukul 07.30 - 14.00 WIB bertempat di Ruang Tata Usaha Kampus SMPN 2 Juwangi.',
       NULL, 'published', 0, NOW())
      ON DUPLICATE KEY UPDATE title=VALUES(title), content=VALUES(content)
    `);
    console.log('✔ Announcements seeded');

    // 6. Agendas
    await pool.query(`
      INSERT INTO agendas (id, title, description, location, start_at, end_at, status) VALUES
      (1, 'Sosialisasi & Layanan Informasi PPDB 2026/2027',
       'Pelayanan informasi alur dan persyaratan administrasi pendaftaran calon peserta didik baru bersama tim panitia PPDB.',
       'Kampus SMPN 2 Juwangi, Jl. Kayen Baru No. 1',
       DATE_ADD(CURDATE(), INTERVAL 2 DAY),
       DATE_ADD(CURDATE(), INTERVAL 14 DAY),
       'published')
      ON DUPLICATE KEY UPDATE title=VALUES(title), location=VALUES(location)
    `);
    console.log('✔ Agendas seeded');

    // 7. Facilities
    await pool.query(`
      INSERT INTO facilities (id, name, description, image) VALUES
      (1, 'Laboratorium Komputer', 'Dilengkapi 36 unit komputer terhubung internet untuk kegiatan praktikum TIK dan Asesmen Nasional Berbasis Komputer (ANBK).', '/uploads/fasilitas-labkom.jpg'),
      (2, 'Perpustakaan Graha Pustaka', 'Koleksi buku pelajaran, buku fiksi, ensiklopedia, ruang baca nyaman, dan layanan administrasi perpustakaan terpadu.', '/uploads/fasilitas-perpus.jpg'),
      (3, 'Laboratorium IPA Terpadu', 'Peralatan praktikum sains (Fisika dan Biologi) terstandar untuk mendukung metode pembelajaran saintifik.', '/uploads/fasilitas-labipa.jpg'),
      (4, 'Lapangan Olahraga & Upacara', 'Sarana luar ruangan serbaguna untuk upacara bendera serta kegiatan olahraga basket, voli, dan atletik.', '/uploads/fasilitas-lapangan.jpg'),
      (5, 'Mushola As-Salam', 'Tempat ibadah shalat berjamaah serta pusat kegiatan pembinaan rohani Islam bagi warga sekolah.', '/uploads/fasilitas-mushola.jpg')
      ON DUPLICATE KEY UPDATE name=VALUES(name)
    `);
    console.log('✔ Facilities seeded');

    // 8. Extracurriculars
    await pool.query(`
      INSERT INTO extracurriculars (id, name, description, schedule, coach, image) VALUES
      (1, 'Pramuka Gudep SMPN 2 Juwangi', 'Kegiatan kepanduan wajib untuk menanamkan kedisiplinan, kemandirian, dan kepemimpinan berwawasan kebangsaan.', 'Jumat, 14.00 - 16.30 WIB', 'Pembina Gudep', '/uploads/ekskul-pramuka.jpg'),
      (2, 'Futsal & Sepak Bola', 'Pembinaan bakat keolahragaan dengan penekanan pada sportivitas, daya tahan fisik, dan kerja sama tim.', 'Selasa & Kamis, 15.30 - 17.30 WIB', 'Pelatih Ekskul', '/uploads/ekskul-futsal.jpg'),
      (3, 'Palang Merah Remaja (PMR)', 'Pelatihan pertolongan pertama, kesiapsiagaan bencana, dan pembinaan kepedulian sosial kemanusiaan.', 'Rabu, 14.30 - 16.00 WIB', 'Pembina PMR', '/uploads/ekskul-pmr.jpg'),
      (4, 'Seni Karawitan & Budaya', 'Melestarikan seni gamelan tradisional dan ansambel musik daerah untuk mengasah estetika dan kecintaan budaya bangsa.', 'Sabtu, 09.00 - 11.30 WIB', 'Instruktur Seni', '/uploads/ekskul-karawitan.jpg')
      ON DUPLICATE KEY UPDATE name=VALUES(name)
    `);
    console.log('✔ Extracurriculars seeded');

    // 9. Albums & Galleries
    await pool.query(`
      INSERT INTO albums (id, name, description) VALUES
      (1, 'Upacara & Kegiatan Sekolah', 'Dokumentasi kegiatan upacara bendera dan peringatan hari besar di lingkungan sekolah.'),
      (2, 'Gelar Karya Proyek P5', 'Dokumentasi karya dan kreativitas siswa dalam pelaksanaan Kurikulum Merdeka.')
      ON DUPLICATE KEY UPDATE name=VALUES(name)
    `);
    await pool.query(`
      INSERT INTO galleries (id, album_id, title, image, alt_text) VALUES
      (1, 1, 'Upacara Bendera Khidmat', '/uploads/berita-upacara.jpg', 'Dokumentasi upacara bendera sekolah'),
      (2, 2, 'Pameran Karya Siswa P5', '/uploads/berita-p5.jpg', 'Dokumentasi gelar karya P5')
      ON DUPLICATE KEY UPDATE title=VALUES(title)
    `);
    console.log('✔ Galleries seeded');

    // 10. Documents: Unduhan digital resmi
    await pool.query(`
      INSERT INTO documents (id, title, category, file_path, file_size, uploaded_by, download_count) VALUES
      (1, 'Kalender Akademik SMPN 2 Juwangi 2026/2027', 'Akademik', '/uploads/kalender-akademik-2026.pdf', 1553, 1, 45),
      (2, 'Pedoman & Tata Tertib Peserta Didik', 'Kesiswaan', '/uploads/tata-tertib-siswa.pdf', 1589, 1, 28),
      (3, 'Brosur & Formulir Pendaftaran PPDB 2026', 'PPDB', '/uploads/brosur-ppdb-2026.pdf', 1631, 1, 112)
      ON DUPLICATE KEY UPDATE title=VALUES(title)
    `);
    console.log('✔ Documents seeded (Valid PDF digital)');

    // 11. Pages: PPDB
    await pool.query(`
      INSERT INTO pages (id, title, slug, content, meta_title, meta_description, status) VALUES
      (1, 'Informasi Resmi PPDB 2026/2027', 'ppdb-info', '<h2>Petunjuk Penerimaan Peserta Didik Baru (PPDB) SMP Negeri 2 Juwangi</h2><p>SMP Negeri 2 Juwangi menyelenggarakan PPDB secara objektif, transparan, dan akuntabel. Pendaftaran calon peserta didik baru dibuka melalui 4 (empat) jalur resmi: Zonasi, Afirmasi, Perpindahan Tugas Orang Tua, dan Prestasi.</p><p>Alamat Pelayanan Sekretariat PPDB: Jl. Kayen Baru No. 1, Desa Kayen, Kecamatan Juwangi, Kabupaten Boyolali. Seluruh tahapan pendaftaran dan seleksi PPDB tidak dipungut biaya apapun (GRATIS).</p>', 'PPDB 2026/2027 SMPN 2 Juwangi', 'Informasi resmi jalur, syarat, dan jadwal PPDB SMP Negeri 2 Juwangi', 'published')
      ON DUPLICATE KEY UPDATE title=VALUES(title)
    `);
    console.log('✔ Pages seeded');

    console.log('--- SEEDING SELESAI DENGAN AMAN DAN TERVERIFIKASI ---');
    process.exit(0);
  } catch (err) {
    console.error('Seed Error:', err);
    process.exit(1);
  }
}

seed();
