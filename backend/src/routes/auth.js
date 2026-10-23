const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const { loginLimiter } = require('../middleware/rateLimit');
const { authenticate } = require('../middleware/auth');

router.post('/login', loginLimiter, authController.login);
router.get('/me', authenticate, authController.me);
router.put('/profile', authenticate, authController.updateProfile);
router.put('/change-password', authenticate, authController.changePassword);

module.exports = router;
