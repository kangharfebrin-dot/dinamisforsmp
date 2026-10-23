const express = require('express');
const router = express.Router();
const { authenticate, authorizeAdmin } = require('../middleware/auth');
const upload = require('../middleware/upload');

const newsController = require('../controllers/newsController');
const categoryController = require('../controllers/categoryController');
const announcementController = require('../controllers/announcementController');
const agendaController = require('../controllers/agendaController');
const profileController = require('../controllers/profileController');
const teacherController = require('../controllers/teacherController');
const achievementController = require('../controllers/achievementController');
const extracurricularController = require('../controllers/extracurricularController');
const facilityController = require('../controllers/facilityController');
const galleryController = require('../controllers/galleryController');
const documentController = require('../controllers/documentController');
const pageController = require('../controllers/pageController');
const pool = require('../db');

// PRD FR-01 & FR-02: Seluruh endpoint admin terlindungi dan HANYA untuk peran Admin tunggal
router.use(authenticate);
router.use(authorizeAdmin);

// 1. Dashboard Summary Komprehensif
router.get('/dashboard-summary', async (req, res, next) => {
  try {
    const [[{ posts }]] = await pool.query('SELECT COUNT(*) AS posts FROM posts');
    const [[{ drafts }]] = await pool.query("SELECT COUNT(*) AS drafts FROM posts WHERE status = 'draft'");
    const [[{ announcements }]] = await pool.query('SELECT COUNT(*) AS announcements FROM announcements');
    const [[{ agendas }]] = await pool.query('SELECT COUNT(*) AS agendas FROM agendas');
    const [[{ teachers }]] = await pool.query('SELECT COUNT(*) AS teachers FROM teachers');
    const [[{ achievements }]] = await pool.query('SELECT COUNT(*) AS achievements FROM achievements');
    const [[{ extracurriculars }]] = await pool.query('SELECT COUNT(*) AS extracurriculars FROM extracurriculars');
    const [[{ facilities }]] = await pool.query('SELECT COUNT(*) AS facilities FROM facilities');
    const [[{ albums }]] = await pool.query('SELECT COUNT(*) AS albums FROM albums');
    const [[{ galleries }]] = await pool.query('SELECT COUNT(*) AS galleries FROM galleries');
    const [[{ documents }]] = await pool.query('SELECT COUNT(*) AS documents FROM documents');
    const [[{ pages }]] = await pool.query('SELECT COUNT(*) AS pages FROM pages');

    const [recentPosts] = await pool.query(
      `SELECT p.id, p.title, p.status, p.created_at, c.name AS category_name
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       ORDER BY p.id DESC LIMIT 5`
    );

    const [recentAnnouncements] = await pool.query(
      `SELECT id, title, status, priority, created_at
       FROM announcements
       ORDER BY id DESC LIMIT 5`
    );

    const [upcomingAgendas] = await pool.query(
      `SELECT id, title, start_at, location, status
       FROM agendas
       ORDER BY start_at ASC LIMIT 5`
    );

    res.json({
      success: true,
      data: {
        counts: {
          posts,
          drafts,
          announcements,
          agendas,
          teachers,
          achievements,
          extracurriculars,
          facilities,
          albums,
          galleries,
          documents,
          pages,
        },
        recentPosts,
        recentAnnouncements,
        upcomingAgendas,
      },
    });
  } catch (err) {
    next(err);
  }
});

// 2. Berita & Artikel
router.get('/news', newsController.list);
router.get('/news/:slug', newsController.show);
router.post('/news', upload.single('cover_image'), newsController.store);
router.put('/news/:id', upload.single('cover_image'), newsController.update);
router.delete('/news/:id', newsController.destroy);

// 3. Kategori Berita
router.get('/categories', categoryController.list);
router.post('/categories', categoryController.store);
router.put('/categories/:id', categoryController.update);
router.delete('/categories/:id', categoryController.destroy);

// 4. Pengumuman
router.get('/announcements', announcementController.list);
router.get('/announcements/:id', announcementController.show);
router.post('/announcements', upload.single('attachment'), announcementController.store);
router.put('/announcements/:id', upload.single('attachment'), announcementController.update);
router.delete('/announcements/:id', announcementController.destroy);

// 5. Agenda
router.get('/agendas', agendaController.list);
router.get('/agendas/:id', agendaController.show);
router.post('/agendas', agendaController.store);
router.put('/agendas/:id', agendaController.update);
router.delete('/agendas/:id', agendaController.destroy);

// 6. Profil Sekolah
router.get('/profile', profileController.getProfile);
router.put(
  '/profile',
  upload.fields([
    { name: 'logo', maxCount: 1 },
    { name: 'hero_banner', maxCount: 1 },
    { name: 'principal_photo', maxCount: 1 },
  ]),
  profileController.updateProfile
);

// 7. Guru & Staf
router.get('/teachers', teacherController.list);
router.get('/teachers/:id', teacherController.show);
router.post('/teachers', upload.single('photo'), teacherController.store);
router.put('/teachers/:id', upload.single('photo'), teacherController.update);
router.delete('/teachers/:id', teacherController.destroy);

// 8. Prestasi
router.get('/achievements', achievementController.list);
router.get('/achievements/:id', achievementController.show);
router.post('/achievements', upload.single('image'), achievementController.store);
router.put('/achievements/:id', upload.single('image'), achievementController.update);
router.delete('/achievements/:id', achievementController.destroy);

// 9. Ekstrakurikuler
router.get('/extracurriculars', extracurricularController.list);
router.get('/extracurriculars/:id', extracurricularController.show);
router.post('/extracurriculars', upload.single('image'), extracurricularController.store);
router.put('/extracurriculars/:id', upload.single('image'), extracurricularController.update);
router.delete('/extracurriculars/:id', extracurricularController.destroy);

// 10. Fasilitas
router.get('/facilities', facilityController.list);
router.get('/facilities/:id', facilityController.show);
router.post('/facilities', upload.single('image'), facilityController.store);
router.put('/facilities/:id', upload.single('image'), facilityController.update);
router.delete('/facilities/:id', facilityController.destroy);

// 11. Album & Galeri Foto
router.get('/albums', galleryController.listAlbums);
router.get('/albums/:id', galleryController.showAlbum);
router.post('/albums', galleryController.storeAlbum);
router.put('/albums/:id', galleryController.updateAlbum);
router.delete('/albums/:id', galleryController.destroyAlbum);

router.get('/galleries', galleryController.listPhotos);
router.post('/galleries', upload.single('image'), galleryController.storePhoto);
router.delete('/galleries/:id', galleryController.destroyPhoto);

// 12. Dokumen / Unduhan
router.get('/documents', documentController.list);
router.post('/documents', upload.single('file'), documentController.store);
router.delete('/documents/:id', documentController.destroy);

// 13. Halaman Dinamis / Informasi
router.get('/pages', pageController.list);
router.get('/pages/:slug', pageController.show);
router.post('/pages', pageController.store);
router.put('/pages/:id', pageController.update);
router.delete('/pages/:id', pageController.destroy);

module.exports = router;
