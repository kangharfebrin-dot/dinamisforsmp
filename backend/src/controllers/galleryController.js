const pool = require('../db');

// List Albums dengan thumbnail & jumlah foto
exports.listAlbums = async (req, res, next) => {
  try {
    const [rows] = await pool.query(
      `SELECT a.*, COUNT(g.id) AS photos_count,
              (SELECT image FROM galleries WHERE album_id = a.id ORDER BY id DESC LIMIT 1) AS cover_photo
       FROM albums a
       LEFT JOIN galleries g ON g.album_id = a.id
       GROUP BY a.id
       ORDER BY a.id DESC`
    );
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.showAlbum = async (req, res, next) => {
  try {
    const [albums] = await pool.query('SELECT * FROM albums WHERE id = ? LIMIT 1', [req.params.id]);
    if (!albums.length) {
      return res.status(404).json({ success: false, message: 'Album tidak ditemukan.' });
    }

    const [photos] = await pool.query('SELECT * FROM galleries WHERE album_id = ? ORDER BY id DESC', [req.params.id]);

    res.json({
      success: true,
      data: {
        ...albums[0],
        photos,
      },
    });
  } catch (err) {
    next(err);
  }
};

exports.storeAlbum = async (req, res, next) => {
  try {
    const { name, description } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama album wajib diisi.' });
    }

    const [result] = await pool.query(
      'INSERT INTO albums (name, description) VALUES (?, ?)',
      [name.trim(), description || null]
    );

    res.status(201).json({
      success: true,
      message: 'Album berhasil dibuat.',
      data: { id: result.insertId },
    });
  } catch (err) {
    next(err);
  }
};

exports.updateAlbum = async (req, res, next) => {
  try {
    const { id } = req.params;
    const { name, description } = req.body;
    if (!name || !name.trim()) {
      return res.status(422).json({ success: false, message: 'Nama album wajib diisi.' });
    }

    await pool.query('UPDATE albums SET name = ?, description = ? WHERE id = ?', [name.trim(), description || null, id]);
    res.json({ success: true, message: 'Album berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.destroyAlbum = async (req, res, next) => {
  try {
    const { id } = req.params;
    // Set album_id null pada foto atau hapus foto
    await pool.query('DELETE FROM galleries WHERE album_id = ?', [id]);
    await pool.query('DELETE FROM albums WHERE id = ?', [id]);
    res.json({ success: true, message: 'Album dan foto di dalamnya berhasil dihapus.' });
  } catch (err) {
    next(err);
  }
};

// Foto Galeri
exports.listPhotos = async (req, res, next) => {
  try {
    const { album_id } = req.query;
    let query = 'SELECT g.*, a.name AS album_name FROM galleries g LEFT JOIN albums a ON a.id = g.album_id';
    const params = [];
    if (album_id) {
      query += ' WHERE g.album_id = ?';
      params.push(album_id);
    }
    query += ' ORDER BY g.id DESC';

    const [rows] = await pool.query(query, params);
    res.json({ success: true, data: rows });
  } catch (err) {
    next(err);
  }
};

exports.storePhoto = async (req, res, next) => {
  try {
    const { album_id, title, alt_text } = req.body;
    if (!req.file) {
      return res.status(422).json({ success: false, message: 'Berkas gambar wajib diunggah.' });
    }

    const image = `/uploads/${req.file.filename}`;

    const [result] = await pool.query(
      'INSERT INTO galleries (album_id, title, image, alt_text) VALUES (?, ?, ?, ?)',
      [album_id || null, title || null, image, alt_text || null]
    );

    res.status(201).json({
      success: true,
      message: 'Foto berhasil ditambahkan ke galeri.',
      data: { id: result.insertId, image },
    });
  } catch (err) {
    next(err);
  }
};

exports.destroyPhoto = async (req, res, next) => {
  try {
    const { id } = req.params;
    await pool.query('DELETE FROM galleries WHERE id = ?', [id]);
    res.json({ success: true, message: 'Foto berhasil dihapus dari galeri.' });
  } catch (err) {
    next(err);
  }
};
