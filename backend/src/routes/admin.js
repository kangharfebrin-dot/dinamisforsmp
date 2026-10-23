const express = require('express');
const router = express.Router();
const { authenticate, authorize } = require('../middleware/auth');
const upload = require('../middleware/upload');

const newsController = require('../controllers/newsController');
const announcementController = require('../controllers/announcementController');
const agendaController = require('../controllers/agendaController');
const profileController = require('../controllers/profileController');
const teacherController = require('../controllers/teacherController');
const achievementController = require('../controllers/achievementController');
const pool = require('../db');

// All admin routes require valid JWT
router.use(authenticate);

// 1. Dashboard summary
router.get('/dashboard-summary', async (req, res, next) => {
  try {
    const [[{ posts }]] = await pool.query('SELECT COUNT(*) AS posts FROM posts');
    const [[{ drafts }]] = await pool.query("SELECT COUNT(*) AS drafts FROM posts WHERE status = 'draft'");
    const [[{ announcements }]] = await pool.query('SELECT COUNT(*) AS announcements FROM announcements');
    const [[{ agendas }]] = await pool.query('SELECT COUNT(*) AS agendas FROM agendas');
    const [[{ teachers }]] = await pool.query('SELECT COUNT(*) AS teachers FROM teachers');
    const [[{ achievements }]] = await pool.query('SELECT COUNT(*) AS achievements FROM achievements');

    const [recentPosts] = await pool.query(
      `SELECT p.id, p.title, p.status, p.created_at, c.name AS category_name
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       ORDER BY p.id DESC LIMIT 5`
    );

    res.json({
      success: true,
      data: {
        counts: { posts, drafts, announcements, agendas, teachers, achievements },
        recentPosts,
      },
    });
  } catch (err) {
    next(err);
  }
});

// 2. Berita (Super Admin, Admin, Editor)
router.get('/news', authorize('super_admin', 'admin', 'editor'), newsController.list);
router.post('/news', authorize('super_admin', 'admin', 'editor'), upload.single('cover_image'), newsController.store);
router.put('/news/:id', authorize('super_admin', 'admin', 'editor'), upload.single('cover_image'), newsController.update);
router.delete('/news/:id', authorize('super_admin', 'admin'), newsController.destroy);

// 3. Pengumuman
router.get('/announcements', authorize('super_admin', 'admin', 'editor'), announcementController.list);
router.post('/announcements', authorize('super_admin', 'admin', 'editor'), upload.single('attachment'), announcementController.store);
router.put('/announcements/:id', authorize('super_admin', 'admin', 'editor'), upload.single('attachment'), announcementController.update);
router.delete('/announcements/:id', authorize('super_admin', 'admin'), announcementController.destroy);

// 4. Agenda
router.get('/agendas', authorize('super_admin', 'admin', 'editor'), agendaController.list);
router.post('/agendas', authorize('super_admin', 'admin', 'editor'), agendaController.store);
router.put('/agendas/:id', authorize('super_admin', 'admin', 'editor'), agendaController.update);
router.delete('/agendas/:id', authorize('super_admin', 'admin'), agendaController.destroy);

// 5. Profil Sekolah
router.get('/profile', authorize('super_admin', 'admin'), profileController.getProfile);
router.put(
  '/profile',
  authorize('super_admin', 'admin'),
  upload.fields([
    { name: 'logo', maxCount: 1 },
    { name: 'hero_banner', maxCount: 1 },
    { name: 'principal_photo', maxCount: 1 },
  ]),
  profileController.updateProfile
);

// 6. Guru & Staf
router.get('/teachers', authorize('super_admin', 'admin'), teacherController.list);
router.post('/teachers', authorize('super_admin', 'admin'), upload.single('photo'), teacherController.store);
router.put('/teachers/:id', authorize('super_admin', 'admin'), upload.single('photo'), teacherController.update);
router.delete('/teachers/:id', authorize('super_admin', 'admin'), teacherController.destroy);

// 7. Prestasi
router.get('/achievements', authorize('super_admin', 'admin'), achievementController.list);
router.post('/achievements', authorize('super_admin', 'admin'), upload.single('image'), achievementController.store);
router.put('/achievements/:id', authorize('super_admin', 'admin'), upload.single('image'), achievementController.update);
router.delete('/achievements/:id', authorize('super_admin', 'admin'), achievementController.destroy);

module.exports = router;
