module.exports = (err, req, res, next) => {
  console.error('[API Error]:', err);
  const status = err.status || err.statusCode || 500;
  res.status(status).json({
    success: false,
    message: status === 500 ? (process.env.NODE_ENV === 'production' ? 'Terjadi kesalahan pada server.' : err.message) : err.message,
    ...(process.env.NODE_ENV !== 'production' && { stack: err.stack }),
  });
};
