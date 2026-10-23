const express = require('express');
const router = express.Router();
const pool = require('../db');

const profileController = require('../controllers/profileController');
const newsController = require('../controllers/newsController');
const announcementController = require('../controllers/announcementController');
const agendaController = require('../controllers/agendaController');
const teacherController = require('../controllers/teacherController');
const achievementController = require('../controllers/achievementController');
const extracurricularController = require('../controllers/extracurricularController');
const facilityController = require('../controllers/facilityController');
const galleryController = require('../controllers/galleryController');
const documentController = require('../controllers/documentController');
const pageController = require('../controllers/pageController');

// 1. Profil sekolah
router.get('/profile', profileController.getProfile);

// 2. Berita & Kategori
router.get('/news', newsController.list);
router.get('/news/categories', newsController.categories);
router.get('/news/:slug', newsController.show);

// 3. Pengumuman
router.get('/announcements', announcementController.list);
router.get('/announcements/:id', announcementController.show);

// 4. Agenda Kegiatan
router.get('/agendas', agendaController.list);
router.get('/agendas/:id', agendaController.show);

// 5. Guru & Tenaga Kependidikan
router.get('/teachers', teacherController.list);
router.get('/teachers/:id', teacherController.show);

// 6. Prestasi
router.get('/achievements', achievementController.list);
router.get('/achievements/:id', achievementController.show);

// 7. Ekstrakurikuler
router.get('/extracurriculars', extracurricularController.list);
router.get('/extracurriculars/:id', extracurricularController.show);

// 8. Fasilitas
router.get('/facilities', facilityController.list);
router.get('/facilities/:id', facilityController.show);

// 9. Album & Galeri Foto
router.get('/albums', galleryController.listAlbums);
router.get('/albums/:id', galleryController.showAlbum);
router.get('/galleries', galleryController.listPhotos);

// 10. Dokumen / Unduhan
router.get('/documents', documentController.list);
router.get('/documents/:id/download', documentController.download);

// 11. Halaman Dinamis / PPDB
router.get('/pages/:slug', pageController.show);

// 12. Statistik Singkat Real-time untuk Beranda
router.get('/stats', async (req, res, next) => {
  try {
    const [[{ total_posts }]] = await pool.query("SELECT COUNT(*) AS total_posts FROM posts WHERE status = 'published'");
    const [[{ total_teachers }]] = await pool.query("SELECT COUNT(*) AS total_teachers FROM teachers WHERE type = 'guru'");
    const [[{ total_staff }]] = await pool.query("SELECT COUNT(*) AS total_staff FROM teachers WHERE type = 'tendik'");
    const [[{ total_achievements }]] = await pool.query("SELECT COUNT(*) AS total_achievements FROM achievements");
    const [[{ total_agendas }]] = await pool.query("SELECT COUNT(*) AS total_agendas FROM agendas WHERE status = 'published'");
    const [[{ total_ekskul }]] = await pool.query("SELECT COUNT(*) AS total_ekskul FROM extracurriculars");
    const [[{ total_fasilitas }]] = await pool.query("SELECT COUNT(*) AS total_fasilitas FROM facilities");

    res.json({
      success: true,
      data: {
        total_posts,
        total_teachers,
        total_staff,
        total_achievements,
        total_agendas,
        total_ekskul,
        total_fasilitas,
      },
    });
  } catch (err) {
    next(err);
  }
});

module.exports = router;
