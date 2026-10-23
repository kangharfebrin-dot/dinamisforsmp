const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const { type } = req.query;
    const where = type ? 'WHERE type = ?' : '';
    const params = type ? [type] : [];

    const [rows] = await pool.query(
      `SELECT * FROM teachers ${where} ORDER BY type ASC, id ASC`,
      params
    );
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.show = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [rows] = await pool.query('SELECT * FROM teachers WHERE id = ? LIMIT 1', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Data guru/staf tidak ditemukan.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { name, nip, type, position, subject, email } = req.body;
    if (!name) {
      return res.status(422).json({ success: false, message: 'Nama lengkap wajib diisi.' });
    }
    const photo = req.file ? `/uploads/${req.file.filename}` : null;

    const [result] = await pool.query(
      `INSERT INTO teachers (name, nip, type, position, subject, photo, email)
       VALUES (?, ?, ?, ?, ?, ?, ?)`,
      [name, nip || null, type || 'guru', position || null, subject || null, photo, email || null]
    );

    res.status(201).json({ success: true, id: result.insertId, message: 'Data guru/staf berhasil ditambahkan.' });
  } catch (err) {
    next(err);
  }
};

exports.update = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { name, nip, type, position, subject, email } = req.body;
    const [rows] = await pool.query('SELECT * FROM teachers WHERE id = ?', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Data guru/staf tidak ditemukan.' });
    }
    const current = rows[0];
    const photo = req.file ? `/uploads/${req.file.filename}` : current.photo;

    await pool.query(
      `UPDATE teachers SET name = ?, nip = ?, type = ?, position = ?, subject = ?, photo = ?, email = ?
       WHERE id = ?`,
      [name || current.name, nip !== undefined ? nip : current.nip, type || current.type,
       position !== undefined ? position : current.position, subject !== undefined ? subject : current.subject,
       photo, email !== undefined ? email : current.email, id]
    );

    res.json({ success: true, message: 'Data guru/staf berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [result] = await pool.query('DELETE FROM teachers WHERE id = ?', [id]);
    if (!result.affectedRows) {
      return res.status(404).json({ success: false, message: 'Data guru/staf tidak ditemukan.' });
    }
    res.json({ success: true, message: 'Data guru/staf berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};
