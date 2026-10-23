const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const limit = Math.min(50, Math.max(1, Number(req.query.limit) || 12));
    const [rows] = await pool.query(
      `SELECT * FROM achievements ORDER BY year DESC, id DESC LIMIT ?`,
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
    const [rows] = await pool.query('SELECT * FROM achievements WHERE id = ? LIMIT 1', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Data prestasi tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, student_name, event_name, level, year, medal, description } = req.body;
    if (!title || !year) {
      return res.status(422).json({ success: false, message: 'Judul prestasi dan tahun wajib diisi.' });
    }
    const image = req.file ? `/uploads/${req.file.filename}` : null;

    const [result] = await pool.query(
      `INSERT INTO achievements (title, student_name, event_name, level, year, medal, image, description)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
      [title, student_name || null, event_name || null, level || 'kabupaten', year, medal || 'emas', image, description || null]
    );

    res.status(201).json({ success: true, id: result.insertId, message: 'Prestasi berhasil ditambahkan.' });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { title, student_name, event_name, level, year, medal, description } = req.body;
    const [rows] = await pool.query('SELECT * FROM achievements WHERE id = ?', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Data prestasi tidak ditemukan.' });
    }
    const current = rows[0];
    const image = req.file ? `/uploads/${req.file.filename}` : current.image;

    await pool.query(
      `UPDATE achievements SET title = ?, student_name = ?, event_name = ?, level = ?, year = ?, medal = ?, image = ?, description = ?
       WHERE id = ?`,
      [title || current.title, student_name !== undefined ? student_name : current.student_name,
       event_name !== undefined ? event_name : current.event_name, level || current.level,
       year || current.year, medal || current.medal, image, description !== undefined ? description : current.description, id]
    );

    res.json({ success: true, message: 'Data prestasi berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM achievements WHERE id = ?', [id]);
    if (!result.affectedRows) {
      return res.status(404).json({ success: false, message: 'Data prestasi tidak ditemukan.' });
    }
    res.json({ success: true, message: 'Data prestasi berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
