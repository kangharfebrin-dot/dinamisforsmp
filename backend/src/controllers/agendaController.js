const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const limit = Math.min(50, Math.max(1, Number(req.query.limit) || 10));
    const [rows] = await pool.query(
      `SELECT * FROM agendas
       WHERE status = 'published'
       ORDER BY start_at ASC
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
    const [rows] = await pool.query('SELECT * FROM agendas WHERE id = ? LIMIT 1', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Agenda tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, description, location, start_at, end_at, status } = req.body;
    if (!title || !start_at) {
      return res.status(422).json({ success: false, message: 'Judul dan tanggal mulai agenda wajib diisi.' });
    }

    const [result] = await pool.query(
      `INSERT INTO agendas (title, description, location, start_at, end_at, status)
       VALUES (?, ?, ?, ?, ?, ?)`,
      [title, description || null, location || null, start_at, end_at || null, status || 'published']
    );

    res.status(201).json({ success: true, id: result.insertId, message: 'Agenda berhasil ditambahkan.' });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { title, description, location, start_at, end_at, status } = req.body;
    const [rows] = await pool.query('SELECT * FROM agendas WHERE id = ?', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Agenda tidak ditemukan.' });
    }
    const current = rows[0];

    await pool.query(
      `UPDATE agendas SET title = ?, description = ?, location = ?, start_at = ?, end_at = ?, status = ?
       WHERE id = ?`,
      [title || current.title, description !== undefined ? description : current.description,
       location !== undefined ? location : current.location, start_at || current.start_at,
       end_at !== undefined ? end_at : current.end_at, status || current.status, id]
    );

    res.json({ success: true, message: 'Agenda berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM agendas WHERE id = ?', [id]);
    if (!result.affectedRows) {
      return res.status(404).json({ success: false, message: 'Agenda tidak ditemukan.' });
    }
    res.json({ success: true, message: 'Agenda berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
