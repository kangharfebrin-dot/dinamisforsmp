const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM extracurriculars ORDER BY id ASC');
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM extracurriculars WHERE id = ? LIMIT 1', [req.params.id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Ekstrakurikuler tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { name, description, schedule, coach } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama ekstrakurikuler wajib diisi.' });
    }

    const image = req.file ? `/uploads/${req.file.filename}` : null;

    const [result] = await pool.query(
      'INSERT INTO extracurriculars (name, description, schedule, coach, image) VALUES (?, ?, ?, ?, ?)',
      [name.trim(), description || null, schedule || null, coach || null, image]
    );

    res.status(201).json({
      success: true,
      message: 'Ekstrakurikuler berhasil ditambahkan.',
      data: { id: result.insertId },
    });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { name, description, schedule, coach } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama ekstrakurikuler wajib diisi.' });
    }

    const [existing] = await pool.query('SELECT * FROM extracurriculars WHERE id = ?', [id]);
    if (!existing.length) {
      return res.status(404).json({ success: false, message: 'Ekstrakurikuler tidak ditemukan.' });
    }

    let image = existing[0].image;
    if (req.file) {
      image = `/uploads/${req.file.filename}`;
    }

    await pool.query(
      'UPDATE extracurriculars SET name = ?, description = ?, schedule = ?, coach = ?, image = ? WHERE id = ?',
      [name.trim(), description || null, schedule || null, coach || null, image, id]
    );

    res.json({ success: true, message: 'Ekstrakurikuler berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    await pool.query('DELETE FROM extracurriculars WHERE id = ?', [id]);
    res.json({ success: true, message: 'Ekstrakurikuler berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
