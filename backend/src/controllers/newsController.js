const pool = require('../db');
const slugify = require('slugify');

exports.list = async (req, res, next) => {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const limit = Math.min(50, Math.max(1, Number(req.query.limit) || 10));
    const offset = (page - 1) * limit;
    const { q, category, status } = req.query;

    const where = [];
    const params = { limit, offset };

    if (status) {
      where.push('p.status = :status');
      params.status = status;
    } else {
      where.push("p.status = 'published'");
    }

    if (category) {
      where.push('(c.slug = :category OR c.id = :catId)');
      params.category = category;
      params.catId = isNaN(category) ? 0 : Number(category);
    }

    if (q) {
      where.push('(p.title LIKE :q OR p.excerpt LIKE :q)');
      params.q = `%${q}%`;
    }

    const whereSql = where.length ? `WHERE ${where.join(' AND ')}` : '';

    const [rows] = await pool.query(
      `SELECT p.id, p.title, p.slug, p.excerpt, p.cover_image, p.status, p.views_count,
              p.published_at, p.created_at, c.id AS category_id, c.name AS category_name, c.slug AS category_slug,
              u.name AS author_name
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       JOIN users u ON u.id = p.author_id
       ${whereSql}
       ORDER BY p.published_at DESC, p.id DESC
       LIMIT :limit OFFSET :offset`,
      params
    );

    const [[{ total }]] = await pool.query(
      `SELECT COUNT(*) AS total
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       ${whereSql}`,
      params
    );

    res.json({
      success: true,
      data: rows,
      meta: {
        page,
        limit,
        total,
        total_pages: Math.ceil(total / limit),
      },
    });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const { slug } = req.params;
    const [rows] = await pool.query(
      `SELECT p.*, c.id AS category_id, c.name AS category_name, c.slug AS category_slug,
              u.name AS author_name, u.avatar AS author_avatar
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       JOIN users u ON u.id = p.author_id
       WHERE p.slug = ? OR p.id = ?
       LIMIT 1`,
      [slug, isNaN(slug) ? 0 : Number(slug)]
    );

    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Berita tidak ditemukan.' });
    }

    // Increment views asynchronously
    pool.query('UPDATE posts SET views_count = views_count + 1 WHERE id = ?', [rows[0].id]).catch(() => {});

    // Get related posts in same category
    const [related] = await pool.query(
      `SELECT p.id, p.title, p.slug, p.cover_image, p.published_at, c.name AS category_name
       FROM posts p
       JOIN categories c ON c.id = p.category_id
       WHERE p.category_id = ? AND p.id != ? AND p.status = 'published'
       ORDER BY p.published_at DESC LIMIT 3`,
      [rows[0].category_id, rows[0].id]
    );

    res.json({
      success: true,
      data: rows[0],
      related,
    });
  } catch (err) {
    next(err);
  }
};

exports.categories = async (req, res, next) => {
  try {
    const [rows] = await pool.query(
      `SELECT c.id, c.name, c.slug, COUNT(p.id) AS posts_count
       FROM categories c
       LEFT JOIN posts p ON p.category_id = c.id AND p.status = 'published'
       GROUP BY c.id, c.name, c.slug
       ORDER BY c.name ASC`
    );
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, category_id, excerpt, content, status } = req.body;
    if (!title || !category_id || !content) {
      return res.status(422).json({ success: false, message: 'Judul, kategori, dan isi berita wajib diisi.' });
    }

    const baseSlug = slugify(title, { lower: true, strict: true }) || 'berita';
    const slug = `${baseSlug}-${Date.now().toString().slice(-6)}`;
    const cover_image = req.file ? `/uploads/${req.file.filename}` : null;
    const postStatus = status === 'published' ? 'published' : 'draft';
    const published_at = postStatus === 'published' ? new Date() : null;

    const [result] = await pool.query(
      `INSERT INTO posts (category_id, author_id, title, slug, excerpt, content, cover_image, status, published_at)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [category_id, req.user.id, title, slug, excerpt || null, content, cover_image, postStatus, published_at]
    );

    res.status(201).json({
      success: true,
      id: result.insertId,
      slug,
      message: 'Berita berhasil disimpan.',
    });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { title, category_id, excerpt, content, status } = req.body;

    const [rows] = await pool.query('SELECT * FROM posts WHERE id = ?', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Berita tidak ditemukan.' });
    }

    const current = rows[0];
    const cover_image = req.file ? `/uploads/${req.file.filename}` : current.cover_image;
    const postStatus = status || current.status;
    const published_at = postStatus === 'published' ? (current.published_at || new Date()) : null;

    await pool.query(
      `UPDATE posts SET category_id = ?, title = ?, excerpt = ?, content = ?, cover_image = ?, status = ?, published_at = ?
       WHERE id = ?`,
      [category_id || current.category_id, title || current.title, excerpt !== undefined ? excerpt : current.excerpt,
       content || current.content, cover_image, postStatus, published_at, id]
    );

    res.json({ success: true, message: 'Berita berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM posts WHERE id = ?', [id]);
    if (!result.affectedRows) {
      return res.status(404).json({ success: false, message: 'Berita tidak ditemukan.' });
    }
    res.json({ success: true, message: 'Berita berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
