const bcrypt = require('bcryptjs');
const pool = require('./db');

async function seed() {
  console.log('--- MEMULAI SEED DATA SMP NEGERI 2 JUWANGI ---');

  try {
    // 1. Roles
    await pool.query(`
      INSERT INTO roles (id, name, slug) VALUES
      (1, 'Super Admin', 'super_admin'),
      (2, 'Admin', 'admin'),
      (3, 'Editor', 'editor')
      ON DUPLICATE KEY UPDATE name=VALUES(name)
    `);
    console.log('✔ Roles seeded');

    // 2. Users
    const passwordHash = await bcrypt.hash('password123', 10);
    await pool.query(`
      INSERT INTO users (id, role_id, name, email, password_hash) VALUES
      (1, 1, 'Super Administrator', 'superadmin@smpn2juwangi.sch.id', :pwd),
      (2, 2, 'Admin Humas SMPN 2 Juwangi', 'admin@smpn2juwangi.sch.id', :pwd),
      (3, 3, 'Editor Redaksi Berita', 'editor@smpn2juwangi.sch.id', :pwd)
      ON DUPLICATE KEY UPDATE name=VALUES(name), password_hash=VALUES(password_hash)
    `, { pwd: passwordHash });
    console.log('✔ Users seeded (Password default: password123)');

    // 3. Profiles
    await pool.query(`
      INSERT INTO profiles (
        id, name, npsn, tagline, logo, hero_banner, address, phone, email,
        principal_name, principal_nip, principal_photo, principal_message,
        vision, mission, history, maps_url, facebook, instagram, youtube
      ) VALUES (
        1,
        'SMP Negeri 2 Juwangi',
        '20308253',
        'Cerdas, Berkarakter, Berakhlak Mulia, dan Berprestasi',
        '/uploads/logo-smpn2.png',
        '/uploads/hero-banner.jpg',
        'Jl. Raya Juwangi - Kedungombo Km. 2, Juwangi, Boyolali, Jawa Tengah 57391',
        '(0298) 610023',
        'info@smpn2juwangi.sch.id',
        'Drs. H. Mulyono, M.Pd.',
        '19680512 199403 1 005',
        '/uploads/kepala-sekolah.jpg',
        'Assalamu’alaikum Warahmatullahi Wabarakatuh. Puji syukur kita panjatkan ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya. Selamat datang di portal resmi SMP Negeri 2 Juwangi. Di era transformasi digital ini, kami berkomitmen untuk mewujudkan ekosistem pendidikan yang berkarakter, inovatif, dan adaptif terhadap perkembangan zaman. Kami terus mendorong seluruh peserta didik untuk mengukir prestasi akademik maupun non-akademik dengan tetap berlandaskan akhlak mulia dan kecintaan terhadap lingkungan. Semoga website ini menjadi media informasi, komunikasi, dan akuntabilitas bagi seluruh masyarakat, orang tua, dan alumni. Wassalamu’alaikum Warahmatullahi Wabarakatuh.',
        'Terwujudnya Peserta Didik yang Berakhlak Mulia, Unggul dalam Prestasi, Terampil dalam Teknologi, Mandiri, dan Berbudaya Lingkungan.',
        '1. Menanamkan nilai-nilai religius dan ketakwaan melalui pembiasaan ibadah rutin.\n2. Melaksanakan pembelajaran dan bimbingan secara efektif dengan pendekatan kurikulum merdeka berbasis saintifik dan digital.\n3. Mengembangkan potensi bakat dan minat siswa melalui kegiatan ekstrakurikuler terpadu.\n4. Menumbuhkan semangat kompetitif dan sportivitas dalam meraih prestasi akademik dan non-akademik.\n5. Mewujudkan lingkungan sekolah yang aman, asri, bersih, sehat, dan ramah anak.',
        'SMP Negeri 2 Juwangi didirikan untuk memenuhi kebutuhan akses pendidikan menengah pertama bermutu bagi masyarakat di wilayah Juwangi dan sekitarnya. Sejak berdiri, sekolah terus bertransformasi meningkatkan fasilitas sarana-prasarana, mutu pendidik, serta konsisten melahirkan lulusan-lulusan yang berprestasi dan berdaya saing.',
        'https://maps.google.com/?q=SMP+Negeri+2+Juwangi+Boyolali',
        'https://facebook.com/smpn2juwangi',
        'https://instagram.com/smpn2juwangi_official',
        'https://youtube.com/@smpnegeri2juwangi'
      )
      ON DUPLICATE KEY UPDATE
        name=VALUES(name), tagline=VALUES(tagline), address=VALUES(address),
        phone=VALUES(phone), email=VALUES(email), principal_name=VALUES(principal_name),
        principal_message=VALUES(principal_message), vision=VALUES(vision), mission=VALUES(mission)
    `);
    console.log('✔ Profile seeded');

    // 4. Categories
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

    // 5. Posts
    await pool.query(`
      INSERT INTO posts (id, category_id, author_id, title, slug, excerpt, content, cover_image, status, views_count, published_at) VALUES
      (1, 1, 1,
       'Upacara Peringatan Hari Pahlawan Berlangsung Khidmat di SMPN 2 Juwangi',
       'upacara-peringatan-hari-pahlawan-berlangsung-khidmat-di-smpn-2-juwangi',
       'Seluruh guru, tenaga kependidikan, dan siswa-siswi SMP Negeri 2 Juwangi mengikuti upacara bendera memperingati Hari Pahlawan dengan penuh rasa nasionalisme.',
       '<p>Juwangi — Dalam rangka meneladani semangat perjuangan para pendahulu bangsa, SMP Negeri 2 Juwangi menggelar upacara bendera peringatan Hari Pahlawan di halaman utama sekolah pada pagi hari ini. Upacara diikuti dengan penuh antusias oleh seluruh dewan guru, staf TU, dan peserta didik dari kelas VII hingga IX.</p><p>Kepala Sekolah dalam amanatnya menegaskan pentingnya memaknai nilai kepahlawanan di masa kini, seperti tekun belajar, menjunjung kejujuran, dan saling tolong-menolong sesama kawan.</p>',
       '/uploads/berita-upacara.jpg', 'published', 245, NOW() - INTERVAL 1 DAY),

      (2, 2, 2,
       'Membanggakan! Tim Futsal SMPN 2 Juwangi Raih Juara 1 Turnamen Pelajar Kabupaten Boyolali',
       'tim-futsal-smpn-2-juwangi-raih-juara-1-turnamen-pelajar-kabupaten-boyolali',
       'Tim Futsal kebanggaan sekolah sukses menyabet gelar Juara Pertama setelah melewati pertandingan final dramatis dengan skor 3-2.',
       '<p>Boyolali — Prestasi membanggakan kembali dipersembahkan oleh peserta didik SMP Negeri 2 Juwangi. Kali ini datang dari cabang olahraga futsal dalam ajang Turnamen Futsal Pelajar Antar-SMP se-Kabupaten Boyolali.</p><p>Pelatih ekstrakurikuler futsal mengapresiasi kedisiplinan dan kerja keras para pemain selama masa latihan intensif.</p>',
       '/uploads/berita-futsal.jpg', 'published', 412, NOW() - INTERVAL 3 DAY),

      (3, 3, 2,
       'Pentas Karya & Bazar Proyek P5: Siswa Tampilkan Kreativitas Daur Ulang dan Kuliner Lokal',
       'pentas-karya-dan-bazar-proyek-p5-siswa-tampilkan-kreativitas',
       'Kegiatan Proyek Penguatan Profil Pelajar Pancasila (P5) semester ini menampilkan puluhan karya inovatif karya siswa dari bahan limbah organik dan kearifan lokal.',
       '<p>Juwangi — SMP Negeri 2 Juwangi sukses menggelar acara Gelar Karya dan Bazar P5 yang melibatkan seluruh siswa kelas VII dan VIII. Para siswa memamerkan karya kerajinan bernilai guna serta aneka olahan pangan tradisional khas daerah.</p>',
       '/uploads/berita-p5.jpg', 'published', 320, NOW() - INTERVAL 5 DAY),

      (4, 4, 1,
       'Informasi Persiapan PPDB SMP Negeri 2 Juwangi Tahun Ajaran 2026/2027',
       'informasi-persiapan-ppdb-smp-negeri-2-juwangi-tahun-ajaran-2026-2027',
       'Bagi calon peserta didik dan wali murid, berikut rincian jadwal, jalur pendaftaran, dan syarat administrasi PPDB tahun ajaran baru.',
       '<p>SMP Negeri 2 Juwangi siap menyambut calon peserta didik baru untuk tahun ajaran 2026/2027. Tersedia empat jalur penerimaan: Zonasi, Afirmasi, Perpindahan Tugas Orang Tua, dan Prestasi.</p>',
       '/uploads/berita-ppdb.jpg', 'published', 580, NOW() - INTERVAL 7 DAY)
      ON DUPLICATE KEY UPDATE title=VALUES(title), excerpt=VALUES(excerpt), content=VALUES(content)
    `);
    console.log('✔ Posts seeded');

    // 6. Announcements
    await pool.query(`
      INSERT INTO announcements (id, author_id, title, content, attachment, status, priority, published_at) VALUES
      (1, 1, 'Jadwal Pelaksanaan Asesmen Sumatif Akhir Semester (ASAS) Genap',
       'Diberitahukan kepada seluruh siswa kelas VII, VIII, dan IX bahwa Asesmen Sumatif Akhir Semester Genap akan dilaksanakan mulai hari Senin pekan depan. Harap mempersiapkan diri dengan baik dan menjaga kesehatan.',
       null, 'published', 1, NOW() - INTERVAL 1 DAY),
      (2, 2, 'Pengambilan Laporan Hasil Belajar (Rapor) & Pertemuan Wali Murid',
       'Undangan pengambilan rapor semester ganjil akan dilaksanakan secara tatap muka dengan tetap mematuhi protokol dan jadwal pembagian sesi per kelas.',
       null, 'published', 1, NOW() - INTERVAL 2 DAY),
      (3, 2, 'Pendaftaran Ekstrakurikuler Pilihan Semester Genap Telah Dibuka',
       'Siswa dipersilakan memilih 1-2 kegiatan ekstrakurikuler minat bakat melalui wali kelas masing-masing hingga akhir pekan ini.',
       null, 'published', 0, NOW() - INTERVAL 4 DAY)
      ON DUPLICATE KEY UPDATE title=VALUES(title), content=VALUES(content)
    `);
    console.log('✔ Announcements seeded');

    // 7. Agendas
    await pool.query(`
      INSERT INTO agendas (id, title, description, location, start_at, end_at, status) VALUES
      (1, 'Pelaksanaan Asesmen Bakat Minat (ABM) Kelas IX',
       'Simulasi dan tes ABM terstandar untuk pemetaan minat studi lanjutan SMA/SMK.',
       'Laboratorium Komputer SMPN 2 Juwangi',
       DATE_ADD(CURDATE(), INTERVAL 3 DAY),
       DATE_ADD(CURDATE(), INTERVAL 5 DAY),
       'published'),
      (2, 'Gelar Seni Budaya & Peringatan Hari Kartini',
       'Lomba busana adat, baca puisi nusantara, dan pameran lukisan siswa.',
       'Aula Utama Sekolah',
       DATE_ADD(CURDATE(), INTERVAL 10 DAY),
       DATE_ADD(CURDATE(), INTERVAL 10 DAY),
       'published'),
      (3, 'Sosialisasi PPDB bersama SD/MI se-Kecamatan Juwangi',
       'Pertemuan koordinasi dan sosialisasi mekanisme pendaftaran peserta didik baru bersama kepala sekolah SD/MI mitra.',
       'Ruang Rapat Guru',
       DATE_ADD(CURDATE(), INTERVAL 14 DAY),
       DATE_ADD(CURDATE(), INTERVAL 14 DAY),
       'published')
      ON DUPLICATE KEY UPDATE title=VALUES(title), location=VALUES(location)
    `);
    console.log('✔ Agendas seeded');

    // 8. Teachers
    await pool.query(`
      INSERT INTO teachers (id, name, nip, type, position, subject, photo, email) VALUES
      (1, 'Drs. H. Mulyono, M.Pd.', '19680512 199403 1 005', 'guru', 'Kepala Sekolah', 'Manajemen Pendidikan', '/uploads/guru-1.jpg', 'mulyono@smpn2juwangi.sch.id'),
      (2, 'Siti Nurjanah, S.Pd., M.Pd.', '19750821 200003 2 003', 'guru', 'Waka Kurikulum', 'Bahasa Indonesia', '/uploads/guru-2.jpg', 'siti.nurjanah@smpn2juwangi.sch.id'),
      (3, 'Bambang Tri Atmojo, S.Pd.', '19820315 200902 1 004', 'guru', 'Waka Kesiswaan', 'Matematika', '/uploads/guru-3.jpg', 'bambang.tri@smpn2juwangi.sch.id'),
      (4, 'Rina Wahyuni, S.Kom.', '19891104 201503 2 006', 'guru', 'Pembina OSIS & TIK', 'Informatika', '/uploads/guru-4.jpg', 'rina.wahyuni@smpn2juwangi.sch.id'),
      (5, 'Ahmad Fauzi, S.Pd.I.', '19850619 201101 1 012', 'guru', 'Guru PAI', 'Pendidikan Agama Islam', '/uploads/guru-5.jpg', 'ahmad.fauzi@smpn2juwangi.sch.id'),
      (6, 'Dewi Astuti, A.Md.', '19920408 201903 2 018', 'tendik', 'Kepala Tata Usaha', 'Administrasi Sekolah', '/uploads/staff-1.jpg', 'dewi.astuti@smpn2juwangi.sch.id')
      ON DUPLICATE KEY UPDATE name=VALUES(name), position=VALUES(position)
    `);
    console.log('✔ Teachers & Staff seeded');

    // 9. Achievements
    await pool.query(`
      INSERT INTO achievements (id, title, student_name, event_name, level, year, medal, description) VALUES
      (1, 'Juara 1 OSN Matematika Kabupaten Boyolali', 'Alya Zahra Kirana', 'Olimpiade Sains Nasional (OSN) Jenjang SMP', 'kabupaten', 2026, 'emas', 'Berhasil menyisihkan 120 peserta dari seluruh SMP di Boyolali dan melaju ke tingkat provinsi.'),
      (2, 'Juara 2 Lomba Pidato Bahasa Inggris FLS2N', 'Dimas Arya Pratama', 'Festival dan Lomba Seni Siswa Nasional', 'kabupaten', 2026, 'perak', 'Penampilan memukau dengan tema Digital Literacy for Youth.'),
      (3, 'Juara 1 Kejuaraan Pencak Silat Pelajar Tingkat Karanganyar-Boyolali', 'Rizky Kurniawan', 'Kejurda Pencak Silat Antar-Perguruan Pelajar', 'provinsi', 2025, 'emas', 'Meraih medali emas kelas tanding E Putra.')
      ON DUPLICATE KEY UPDATE title=VALUES(title)
    `);
    console.log('✔ Achievements seeded');

    console.log('--- SEMUA DATA AWAL SEEDING SELESAI DENGAN SUKSES! ---');
    process.exit(0);
  } catch (err) {
    console.error('Seed Error:', err);
    process.exit(1);
  }
}

seed();
