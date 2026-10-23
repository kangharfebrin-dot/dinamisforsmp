const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const { loginLimiter } = require('../middleware/rateLimit');
const { authenticate } = require('../middleware/auth');

router.post('/login', loginLimiter, authController.login);
router.get('/me', authenticate, authController.me);

module.exports = router;
