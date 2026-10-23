const jwt = require('jsonwebtoken');

function authenticate(req, res, next) {
  const header = req.headers.authorization || '';
  const token = header.startsWith('Bearer ') ? header.slice(7).trim() : null;
  if (!token) {
    return res.status(401).json({ success: false, message: 'Autentikasi gagal: Token tidak ditemukan.' });
  }

  if (!process.env.JWT_SECRET || process.env.JWT_SECRET.trim().length < 32) {
    return res.status(500).json({ success: false, message: 'Kesalahan Konfigurasi Server: JWT_SECRET wajib disetel di environment dengan minimal 32 karakter.' });
  }

  try {
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    req.user = decoded;
    return next();
  } catch (err) {
    return res.status(401).json({ success: false, message: 'Token tidak valid atau telah kedaluwarsa.' });
  }
}

// PRD FR-02: Satu peran tunggal yaitu Admin
function authorizeAdmin(req, res, next) {
  if (!req.user || req.user.role !== 'admin') {
    return res.status(403).json({ success: false, message: 'Akses ditolak: Hanya peran Admin yang berwenang untuk tindakan ini.' });
  }
  return next();
}

function authorize(...roles) {
  // Kompatibilitas mundur jika dipanggil authorize('admin')
  return authorizeAdmin;
}

module.exports = { authenticate, authorize, authorizeAdmin };
