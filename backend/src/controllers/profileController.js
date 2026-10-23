const pool = require('../db');

exports.getProfile = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM profiles WHERE id = 1 LIMIT 1');
    if (!rows.length) {
      return res.status(404).json({ success: false, message: 'Profil sekolah belum diatur.' });
    }
    res.json({ success: true, data: rows[0] });
  } catch (err) {
    next(err);
  }
};

exports.updateProfile = async (req, res, next) => {
  try {
    const {
      name, npsn, tagline, address, phone, email,
      principal_name, principal_nip, principal_message,
      vision, mission, history, maps_url, facebook, instagram, youtube
    } = req.body;

    const [existing] = await pool.query('SELECT * FROM profiles WHERE id = 1 LIMIT 1');
    const current = existing[0] || {};

    const logo = req.files && req.files.logo ? `/uploads/${req.files.logo[0].filename}` : current.logo;
    const hero_banner = req.files && req.files.hero_banner ? `/uploads/${req.files.hero_banner[0].filename}` : current.hero_banner;
    const principal_photo = req.files && req.files.principal_photo ? `/uploads/${req.files.principal_photo[0].filename}` : current.principal_photo;

    await pool.query(
      `UPDATE profiles SET
        name = ?, npsn = ?, tagline = ?, logo = ?, hero_banner = ?,
        address = ?, phone = ?, email = ?, principal_name = ?, principal_nip = ?,
        principal_photo = ?, principal_message = ?, vision = ?, mission = ?,
        history = ?, maps_url = ?, facebook = ?, instagram = ?, youtube = ?
       WHERE id = 1`,
      [
        name || current.name,
        npsn || current.npsn,
        tagline || current.tagline,
        logo,
        hero_banner,
        address || current.address,
        phone || current.phone,
        email || current.email,
        principal_name || current.principal_name,
        principal_nip || current.principal_nip,
        principal_photo,
        principal_message || current.principal_message,
        vision || current.vision,
        mission || current.mission,
        history || current.history,
        maps_url || current.maps_url,
        facebook || current.facebook,
        instagram || current.instagram,
        youtube || current.youtube,
      ]
    );

    res.json({ success: true, message: 'Profil sekolah berhasil diperbarui.' });
  } catch (err) {
    next(err);
  }
};
