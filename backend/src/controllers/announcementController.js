const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const limit = Math.min(50, Math.max(1, Number(req.query.limit) || 10));
    const [rows] = await pool.query(
      `SELECT a.*, u.name AS author_name
       FROM announcements a
       JOIN users u ON u.id = a.author_id
       WHERE a.status = 'published'
       ORDER BY a.priority DESC, a.published_at DESC
       LIMIT ?`,
      [limit]
    );
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [rows] = await pool.query(
      `SELECT a.*, u.name AS author_name
       FROM announcements a
       JOIN users u ON u.id = a.author_id
       WHERE a.id = ? LIMIT 1`,
      [id]
    );
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Pengumuman tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, content, status, priority } = req.body;
    if (!title || !content) {
      return res.status(422).json({ success: false, message: 'Judul dan isi pengumuman wajib diisi.' });
    }
    const attachment = req.file ? `/uploads/${req.file.filename}` : null;
    const postStatus = status === 'published' ? 'published' : 'draft';

    const [result] = await pool.query(
      `INSERT INTO announcements (author_id, title, content, attachment, status, priority, published_at)
       VALUES (?, ?, ?, ?, ?, ?, NOW())`,
      [req.user.id, title, content, attachment, postStatus, Number(priority) || 0]
    );

    res.status(201).json({ success: true, id: result.insertId, message: 'Pengumuman berhasil dibuat.' });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { title, content, status, priority } = req.body;
    const [rows] = await pool.query('SELECT * FROM announcements WHERE id = ?', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Pengumuman tidak ditemukan.' });
    }
    const current = rows[0];
    const attachment = req.file ? `/uploads/${req.file.filename}` : current.attachment;

    await pool.query(
      `UPDATE announcements SET title = ?, content = ?, attachment = ?, status = ?, priority = ?
       WHERE id = ?`,
      [title || current.title, content || current.content, attachment, status || current.status,
       priority !== undefined ? Number(priority) : current.priority, id]
    );

    res.json({ success: true, message: 'Pengumuman berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM announcements WHERE id = ?', [id]);
    if (!result.affectedRows) {
      return res.status(404).json({ success: false, message: 'Pengumuman tidak ditemukan.' });
    }
    res.json({ success: true, message: 'Pengumuman berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
