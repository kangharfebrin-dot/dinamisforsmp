const pool = require('../db');
const slugify = require('slugify');

exports.list = async (req, res, next) => {
  try {
    const [rows] = await pool.query(
      `SELECT c.id, c.name, c.slug, COUNT(p.id) AS posts_count
       FROM categories c
       LEFT JOIN posts p ON p.category_id = c.id
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
    const { name } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama kategori wajib diisi.' });
    }

    const baseSlug = slugify(name, { lower: true, strict: true }) || 'kategori';
    const slug = `${baseSlug}-${Date.now().toString().slice(-4)}`;

    const [result] = await pool.query(
      'INSERT INTO categories (name, slug) VALUES (?, ?)',
      [name.trim(), slug]
    );

    res.status(201).json({
      success: true,
      message: 'Kategori berhasil ditambahkan.',
      data: { id: result.insertId, name: name.trim(), slug },
    });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { name } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama kategori wajib diisi.' });
    }

    const [existing] = await pool.query('SELECT id FROM categories WHERE id = ?', [id]);
    if (!existing.length) {
      return res.status(404).json({ success: false, message: 'Kategori tidak ditemukan.' });
    }

    await pool.query('UPDATE categories SET name = ? WHERE id = ?', [name.trim(), id]);
    res.json({ success: true, message: 'Kategori berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [[{ postsCount }]] = await pool.query('SELECT COUNT(*) AS postsCount FROM posts WHERE category_id = ?', [id]);
    if (postsCount > 0) {
      return res.status(400).json({
        success: false,
        message: `Kategori tidak dapat dihapus karena masih digunakan oleh ${postsCount} berita. Pindahkan berita terlebih dahulu.`,
      });
    }

    await pool.query('DELETE FROM categories WHERE id = ?', [id]);
    res.json({ success: true, message: 'Kategori berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
