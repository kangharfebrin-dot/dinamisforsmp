-- Skema Database SMP Negeri 2 Juwangi
CREATE DATABASE IF NOT EXISTS `smpn2_juwangi_web` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smpn2_juwangi_web`;

-- 1. Roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_id` TINYINT UNSIGNED NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(255) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(130) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Posts / Berita
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `author_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `excerpt` TEXT NULL,
  `content` LONGTEXT NOT NULL,
  `cover_image` VARCHAR(255) NULL,
  `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `published_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_posts_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Announcements / Pengumuman
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `author_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `attachment` VARCHAR(255) NULL,
  `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
  `priority` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `published_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_announcements_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Agendas
CREATE TABLE IF NOT EXISTS `agendas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT NULL,
  `location` VARCHAR(200) NULL,
  `start_at` DATETIME NOT NULL,
  `end_at` DATETIME NULL,
  `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Achievements / Prestasi
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `student_name` VARCHAR(150) NULL,
  `event_name` VARCHAR(150) NULL,
  `level` ENUM('kecamatan','kabupaten','provinsi','nasional','internasional') NOT NULL DEFAULT 'kabupaten',
  `year` YEAR NOT NULL,
  `medal` ENUM('emas','perak','perunggu','juara_umum','juara_1','juara_2','juara_3') NULL,
  `image` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Extracurriculars / Ekstrakurikuler
CREATE TABLE IF NOT EXISTS `extracurriculars` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `schedule` VARCHAR(150) NULL,
  `coach` VARCHAR(100) NULL,
  `image` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Facilities / Fasilitas
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(120) NOT NULL,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Albums & Galleries
CREATE TABLE IF NOT EXISTS `albums` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `album_id` INT UNSIGNED NULL,
  `title` VARCHAR(180) NULL,
  `image` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(180) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_galleries_album` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Documents / Unduhan
CREATE TABLE IF NOT EXISTS `documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `category` VARCHAR(100) NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` INT UNSIGNED NULL,
  `uploaded_by` INT UNSIGNED NOT NULL,
  `download_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_documents_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Pages (Profil Statis / Informasi Tambahan)
CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `content` LONGTEXT NOT NULL,
  `meta_title` VARCHAR(200) NULL,
  `meta_description` VARCHAR(255) NULL,
  `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `parent_id` INT UNSIGNED NULL,
  `title` VARCHAR(100) NOT NULL,
  `url` VARCHAR(180) NOT NULL,
  `icon` VARCHAR(60) NULL,
  `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT `fk_menus_parent` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Profiles / Identitas Sekolah
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL DEFAULT 'SMP Negeri 2 Juwangi',
  `npsn` VARCHAR(20) NULL DEFAULT '20308253',
  `tagline` VARCHAR(200) NULL DEFAULT 'Cerdas, Berkarakter, Berakhlak Mulia',
  `logo` VARCHAR(255) NULL,
  `hero_banner` VARCHAR(255) NULL,
  `address` VARCHAR(255) NULL,
  `phone` VARCHAR(40) NULL,
  `email` VARCHAR(120) NULL,
  `principal_name` VARCHAR(120) NULL,
  `principal_nip` VARCHAR(40) NULL,
  `principal_photo` VARCHAR(255) NULL,
  `principal_message` LONGTEXT NULL,
  `vision` LONGTEXT NULL,
  `mission` LONGTEXT NULL,
  `history` LONGTEXT NULL,
  `maps_url` TEXT NULL,
  `facebook` VARCHAR(180) NULL,
  `instagram` VARCHAR(180) NULL,
  `youtube` VARCHAR(180) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Teachers & Staff / Guru & Tenaga Kependidikan
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(120) NOT NULL,
  `nip` VARCHAR(40) NULL,
  `type` ENUM('guru','tendik') NOT NULL DEFAULT 'guru',
  `position` VARCHAR(120) NULL,
  `subject` VARCHAR(100) NULL,
  `photo` VARCHAR(255) NULL,
  `email` VARCHAR(120) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
