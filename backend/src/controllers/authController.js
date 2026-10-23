const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const pool = require('../db');

exports.login = async (req, res, next) => {
  try {
    const { email, password } = req.body;
    if (!email || !password) {
      return res.status(400).json({ success: false, message: 'Email dan password wajib diisi.' });
    }

    const [rows] = await pool.query(
      `SELECT u.id, u.name, u.email, u.password_hash, u.avatar, u.is_active, r.slug AS role
       FROM users u
       JOIN roles r ON r.id = u.role_id
       WHERE u.email = ? LIMIT 1`,
      [email.trim().toLowerCase()]
    );

    if (!rows.length) {
      return res.status(401).json({ success: false, message: 'Email atau password tidak sesuai.' });
    }

    const user = rows[0];
    if (!user.is_active) {
      return res.status(403).json({ success: false, message: 'Akun Anda dinonaktifkan. Hubungi administrator.' });
    }

    const isMatch = await bcrypt.compare(password, user.password_hash);
    if (!isMatch) {
      return res.status(401).json({ success: false, message: 'Email atau password tidak sesuai.' });
    }

    if (!process.env.JWT_SECRET || process.env.JWT_SECRET.trim().length < 32) {
      return res.status(500).json({ success: false, message: 'Kesalahan Konfigurasi Server: JWT_SECRET wajib disetel di environment dengan minimal 32 karakter.' });
    }

    const token = jwt.sign(
      {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role,
      },
      process.env.JWT_SECRET,
      { expiresIn: process.env.JWT_EXPIRES_IN || '8h' }
    );

    res.json({
      success: true,
      message: 'Login berhasil.',
      token,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role,
        avatar: user.avatar,
      },
    });
  } catch (err) {
    next(err);
  }
};

exports.me = async (req, res, next) => {
  try {
    const [rows] = await pool.query(
      `SELECT u.id, u.name, u.email, u.avatar, r.name AS role_name, r.slug AS role
       FROM users u
       JOIN roles r ON r.id = u.role_id
       WHERE u.id = ? LIMIT 1`,
      [req.user.id]
    );

    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Pengguna tidak ditemukan.' });
    }

    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.updateProfile = async (req, res, next) => {
  try {
    const { name, email } = req.body;
    if (!name || !email) {
      return res.status(400).json({ success: false, message: 'Nama dan email wajib diisi.' });
    }

    // Cek duplikasi email pada user lain
    const [existing] = await pool.query('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1', [email.trim().toLowerCase(), req.user.id]);
    if (existing.length) {
      return res.status(400).json({ success: false, message: 'Email sudah digunakan oleh akun lain.' });
    }

    await pool.query('UPDATE users SET name = ?, email = ? WHERE id = ?', [name.trim(), email.trim().toLowerCase(), req.user.id]);

    res.json({ success: true, message: 'Profil admin berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};

exports.changePassword = async (req, res, next) => {
  try {
    const { current_password, new_password, new_password_confirmation } = req.body;
    if (!current_password || !new_password) {
      return res.status(400).json({ success: false, message: 'Kata sandi saat ini dan kata sandi baru wajib diisi.' });
    }

    if (new_password.length < 8) {
      return res.status(400).json({ success: false, message: 'Kata sandi baru minimal 8 karakter.' });
    }

    if (new_password_confirmation && new_password !== new_password_confirmation) {
      return res.status(400).json({ success: false, message: 'Konfirmasi kata sandi baru tidak cocok.' });
    }

    const [rows] = await pool.query('SELECT password_hash FROM users WHERE id = ? LIMIT 1', [req.user.id]);
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Akun tidak ditemukan.' });
    }

    const isMatch = await bcrypt.compare(current_password, rows[0].password_hash);
    if (!isMatch) {
      return res.status(400).json({ success: false, message: 'Kata sandi saat ini tidak sesuai.' });
    }

    const newHash = await bcrypt.hash(new_password, 10);
    await pool.query('UPDATE users SET password_hash = ? WHERE id = ?', [newHash, req.user.id]);

    res.json({ success: true, message: 'Kata sandi berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};
