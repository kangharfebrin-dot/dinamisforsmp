const express = require('express');
const router = express.Router();
const pool = require('../db');

const profileController = require('../controllers/profileController');
const newsController = require('../controllers/newsController');
const announcementController = require('../controllers/announcementController');
const agendaController = require('../controllers/agendaController');
const teacherController = require('../controllers/teacherController');
const achievementController = require('../controllers/achievementController');

// Profil sekolah
router.get('/profile', profileController.getProfile);

// Berita & Kategori
router.get('/news', newsController.list);
router.get('/news/categories', newsController.categories);
router.get('/news/:slug', newsController.show);

// Pengumuman
router.get('/announcements', announcementController.list);
router.get('/announcements/:id', announcementController.show);

// Agenda Kegiatan
router.get('/agendas', agendaController.list);
router.get('/agendas/:id', agendaController.show);

// Guru & Tenaga Kependidikan
router.get('/teachers', teacherController.list);
router.get('/teachers/:id', teacherController.show);

// Prestasi
router.get('/achievements', achievementController.list);
router.get('/achievements/:id', achievementController.show);

// Statistik Singkat untuk Beranda
router.get('/stats', async (req, res, next) => {
  try {
    const [[{ total_posts }]] = await pool.query("SELECT COUNT(*) AS total_posts FROM posts WHERE status = 'published'");
    const [[{ total_teachers }]] = await pool.query("SELECT COUNT(*) AS total_teachers FROM teachers WHERE type = 'guru'");
    const [[{ total_staff }]] = await pool.query("SELECT COUNT(*) AS total_staff FROM teachers WHERE type = 'tendik'");
    const [[{ total_achievements }]] = await pool.query("SELECT COUNT(*) AS total_achievements FROM achievements");
    const [[{ total_agendas }]] = await pool.query("SELECT COUNT(*) AS total_agendas FROM agendas WHERE status = 'published'");

    res.json({
      success: true,
      data: {
        total_posts,
        total_teachers,
        total_staff,
        total_achievements,
        total_agendas,
        active_students: 480, // Target estimasi sekolah
      },
    });
  } catch (err) {
    next(err);
  }
});

module.exports = router;
