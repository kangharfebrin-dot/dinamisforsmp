const pool = require('../db');

exports.list = async (req, res, next) => {
  try {
    const { category } = req.query;
    let query = `
      SELECT d.*, u.name AS uploader_name
      FROM documents d
      JOIN users u ON u.id = d.uploaded_by
    `;
    const params = [];
    if (category) {
      query += ' WHERE d.category = ?';
      params.push(category);
    }
    query += ' ORDER BY d.id DESC';

    const [rows] = await pool.query(query, params);
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.store = async (req, res, next) => {
  try {
    const { title, category } = req.body;
    if (!title || !title.trim()) {
      return res.status(422).json({ success: false, message: 'Judul dokumen wajib diisi.' });
    }

    if (!req.file) {
      return res.status(422).json({ success: false, message: 'Berkas dokumen wajib diunggah.' });
    }

    const file_path = `/uploads/${req.file.filename}`;
    const file_size = req.file.size;
    const uploaded_by = req.user?.id || 1;

    const [result] = await pool.query(
      'INSERT INTO documents (title, category, file_path, file_size, uploaded_by) VALUES (?, ?, ?, ?, ?)',
      [title.trim(), category || 'Umum', file_path, file_size, uploaded_by]
    );

    res.status(201).json({
      success: true,
      message: 'Dokumen berhasil diunggah.',
      data: { id: result.insertId, file_path },
    });
  } catch (err) {
    next(err);
  }
};

exports.destroy = async (req, res, next) => {
  try {
    const { id } = req.params;
    await pool.query('DELETE FROM documents WHERE id = ?', [id]);
    res.json({ success: true, message: 'Dokumen berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};

exports.download = async (req, res, next) => {
  try {
    const { id } = req.params;
    const [rows] = await pool.query('SELECT * FROM documents WHERE id = ? LIMIT 1', [id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Dokumen tidak ditemukan.' });
    }

    await pool.query('UPDATE documents SET download_count = download_count + 1 WHERE id = ?', [id]);
    res.json({ success: true, file_path: rows[0].file_path });
  } catch (err) {
    next(err);
  }
};
