const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM facilities ORDER BY id ASC');
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM facilities WHERE id = ? LIMIT 1', [req.params.id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Fasilitas tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { name, description } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama fasilitas wajib diisi.' });
    }

    const image = req.file ? `/uploads/${req.file.filename}` : null;

    const [result] = await pool.query(
      'INSERT INTO facilities (name, description, image) VALUES (?, ?, ?)',
      [name.trim(), description || null, image]
    );

    res.status(201).json({
      success: true,
      message: 'Fasilitas berhasil ditambahkan.',
      data: { id: result.insertId },
    });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { name, description } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama fasilitas wajib diisi.' });
    }

    const [existing] = await pool.query('SELECT * FROM facilities WHERE id = ?', [id]);
    if (!existing.length) {
      return res.status(404).json({ success: false, message: 'Fasilitas tidak ditemukan.' });
    }

    let image = existing[0].image;
    if (req.file) {
      image = `/uploads/${req.file.filename}`;
    }

    await pool.query(
      'UPDATE facilities SET name = ?, description = ?, image = ? WHERE id = ?',
      [name.trim(), description || null, image, id]
    );

    res.json({ success: true, message: 'Fasilitas berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    await pool.query('DELETE FROM facilities WHERE id = ?', [id]);
    res.json({ success: true, message: 'Fasilitas berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
