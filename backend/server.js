require('dotenv').config();

// Enforce JWT_SECRET security requirement
if (!process.env.JWT_SECRET || process.env.JWT_SECRET.trim().length < 32) {
  console.error('FATAL ERROR: JWT_SECRET wajib dikonfigurasi di environment (.env) dengan panjang minimal 32 karakter.');
  process.exit(1);
}

const express = require('express');
const helmet = require('helmet');
const cors = require('cors');
const path = require('path');

const publicRoutes = require('./src/routes/public');
const authRoutes = require('./src/routes/auth');
const adminRoutes = require('./src/routes/admin');
const errorHandler = require('./src/middleware/errorHandler');
const { apiLimiter } = require('./src/middleware/rateLimit');

const app = express();

// Security & Headers
app.use(helmet({
  crossOriginResourcePolicy: { policy: 'cross-origin' },
}));

// CORS Configuration
const allowedOrigins = (process.env.CORS_ORIGIN || 'http://localhost:8000,http://127.0.0.1:8000').split(',');
app.use(cors({
  origin: (origin, callback) => {
    if (!origin || allowedOrigins.includes(origin) || allowedOrigins.includes('*')) {
      return callback(null, true);
    }
    return callback(null, true); // Allow during local development
  },
  credentials: true,
}));

// Body parsers
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Static uploads directory
const uploadPath = path.join(__dirname, process.env.UPLOAD_DIR || 'public/uploads');
app.use('/uploads', express.static(uploadPath));

// Global API rate limiter
app.use('/api', apiLimiter);

// API routes
app.use('/api', publicRoutes);
app.use('/api/auth', authRoutes);
app.use('/api/admin', adminRoutes);

// Health check endpoint
app.get('/health', (req, res) => {
  res.json({
    status: 'ok',
    app: 'SMP Negeri 2 Juwangi REST API',
    time: new Date().toISOString(),
  });
});

// Error handling middleware
app.use(errorHandler);

const PORT = Number(process.env.PORT) || 5000;
const server = app.listen(PORT, () => {
  console.log(`=================================================`);
  console.log(`🚀 SMPN 2 Juwangi API running on http://localhost:${PORT}`);
  console.log(`📁 Uploads served at http://localhost:${PORT}/uploads`);
  console.log(`=================================================`);
});

module.exports = { app, server };
