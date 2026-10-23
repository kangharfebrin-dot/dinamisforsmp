const jwt = require('jsonwebtoken');

function authenticate(req, res, next) {
  const header = req.headers.authorization || '';
  const token = header.startsWith('Bearer ') ? header.slice(7).trim() : null;
  if (!token) {
    return res.status(401).json({ success: false, message: 'Autentikasi gagal: Token tidak ditemukan.' });
  }

  try {
    const decoded = jwt.verify(token, process.env.JWT_SECRET || 'smpn2_juwangi_super_secret_jwt_key_2026_xyz987');
    req.user = decoded;
    return next();
  } catch (err) {
    return res.status(401).json({ success: false, message: 'Token tidak valid atau telah kedaluwarsa.' });
  }
}

function authorize(...roles) {
  return (req, res, next) => {
    if (!req.user || !roles.includes(req.user.role)) {
      return res.status(403).json({ success: false, message: 'Akses ditolak: Anda tidak memiliki wewenang untuk tindakan ini.' });
    }
    return next();
  };
}

module.exports = { authenticate, authorize };
