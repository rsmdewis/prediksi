-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table prediksi.data
CREATE TABLE IF NOT EXISTS `data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_provinsi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_panen` decimal(10,2) NOT NULL,
  `produktivitas` decimal(10,2) NOT NULL,
  `produksi` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.data: ~6 rows (approximately)
INSERT INTO `data` (`id`, `kd_provinsi`, `tahun`, `luas_panen`, `produktivitas`, `produksi`, `created_at`, `updated_at`) VALUES
	(1, 'K01', '2018', 329515.78, 56.49, 1861567.10, '2024-05-13 17:57:07', '2024-05-13 18:04:43'),
	(2, 'K01', '2019', 310012.46, 55.30, 1714437.60, '2024-05-13 17:58:07', '2024-05-13 18:05:37'),
	(3, 'K01', '2023', 317869.41, 55.28, 1757313.07, '2024-05-13 17:59:09', '2024-05-13 18:06:25'),
	(4, 'K01', '2021', 297058.38, 55.03, 1634639.60, '2024-05-13 18:02:09', '2024-05-13 18:02:09'),
	(5, 'K01', '2022', 271750.20, 55.55, 1509456.00, '2024-05-13 18:03:01', '2024-05-13 18:03:01'),
	(6, 'K01', '2023', 254287.38, 55.22, 1404234.82, '2024-05-13 18:03:48', '2024-05-13 18:03:48');

-- Dumping structure for table prediksi.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table prediksi.kecamatans
CREATE TABLE IF NOT EXISTS `kecamatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_provinsi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_provinsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alpha` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kecamatans_kd_provinsi_unique` (`kd_provinsi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.kecamatans: ~0 rows (approximately)

-- Dumping structure for table prediksi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.migrations: ~9 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(5, '2024_03_17_205735_create_posts_table', 1),
	(6, '2024_03_18_052818_create_comments_table', 1),
	(19, '2014_10_12_000000_create_users_table', 2),
	(20, '2014_10_12_100000_create_password_reset_tokens_table', 2),
	(21, '2019_08_19_000000_create_failed_jobs_table', 2),
	(22, '2019_12_14_000001_create_personal_access_tokens_table', 2),
	(26, '2024_05_04_034919_create_kecamatans_table', 3),
	(28, '2024_05_10_045457_create_provinsis_table', 4),
	(29, '2024_05_04_034952_create_data_table', 5),
	(33, '2024_05_14_053411_create_smoothings_table', 6);

-- Dumping structure for table prediksi.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table prediksi.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table prediksi.provinsis
CREATE TABLE IF NOT EXISTS `provinsis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_provinsi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_provinsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alpha` decimal(3,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provinsis_kd_provinsi_unique` (`kd_provinsi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.provinsis: ~0 rows (approximately)
INSERT INTO `provinsis` (`id`, `kd_provinsi`, `nm_provinsi`, `alpha`, `created_at`, `updated_at`) VALUES
	(1, 'K01', 'Aceh', 0.64, '2024-05-13 17:11:18', '2024-05-13 17:11:18');

-- Dumping structure for table prediksi.smoothings
CREATE TABLE IF NOT EXISTS `smoothings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kd_provinsi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produksi` decimal(10,2) DEFAULT NULL,
  `prediksi` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.smoothings: ~15 rows (approximately)

-- Dumping structure for table prediksi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table prediksi.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$wql6RRJC.Syp1FPsSgmFQOsmrWNLmLJBep8tjQp.QLHbtz8RMIt3y', NULL, '2024-05-09 22:37:15', '2024-05-09 22:37:15');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
