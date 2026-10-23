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
      return res.status(403).json({ success: false, message: 'Akun Anda dinonaktifkan. Hubungi Super Admin.' });
    }

    const isMatch = await bcrypt.compare(password, user.password_hash);
    if (!isMatch) {
      return res.status(401).json({ success: false, message: 'Email atau password tidak sesuai.' });
    }

    const token = jwt.sign(
      {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role,
      },
      process.env.JWT_SECRET || 'smpn2_juwangi_super_secret_jwt_key_2026_xyz987',
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
