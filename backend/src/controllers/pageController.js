const pool = require('../db');
const slugify = require('slugify');

exports.list = async (req, res, next) => {
  try {
    const { status } = req.query;
    let query = 'SELECT * FROM pages';
    const params = [];
    if (status) {
      query += ' WHERE status = ?';
      params.push(status);
    }
    query += ' ORDER BY id DESC';

    const [rows] = await pool.query(query, params);
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const { slug } = req.params;
    const [rows] = await pool.query('SELECT * FROM pages WHERE slug = ? OR id = ? LIMIT 1', [slug, isNaN(slug) ? 0 : Number(slug)]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Halaman tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, content, meta_title, meta_description, status } = req.body;
    if (!title || !content) {
      return res.status(422).json({ success: false, message: 'Judul dan isi halaman wajib diisi.' });
    }

    const baseSlug = slugify(title, { lower: true, strict: true }) || 'halaman';
    const slug = `${baseSlug}-${Date.now().toString().slice(-4)}`;
    const pageStatus = status === 'published' ? 'published' : 'draft';

    const [result] = await pool.query(
      'INSERT INTO pages (title, slug, content, meta_title, meta_description, status) VALUES (?, ?, ?, ?, ?, ?)',
      [title.trim(), slug, content, meta_title || null, meta_description || null, pageStatus]
    );

    res.status(201).json({
      success: true,
      message: 'Halaman berhasil dibuat.',
      data: { id: result.insertId, slug },
    });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { title, content, meta_title, meta_description, status } = req.body;
    if (!title || !content) {
      return res.status(422).json({ success: false, message: 'Judul dan isi halaman wajib diisi.' });
    }

    const [existing] = await pool.query('SELECT * FROM pages WHERE id = ?', [id]);
    if (!existing.length) {
      return res.status(404).json({ success: false, message: 'Halaman tidak ditemukan.' });
    }

    const pageStatus = status === 'published' ? 'published' : 'draft';

    await pool.query(
      'UPDATE pages SET title = ?, content = ?, meta_title = ?, meta_description = ?, status = ? WHERE id = ?',
      [title.trim(), content, meta_title || null, meta_description || null, pageStatus, id]
    );

    res.json({ success: true, message: 'Halaman berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    await pool.query('DELETE FROM pages WHERE id = ?', [id]);
    res.json({ success: true, message: 'Halaman berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
