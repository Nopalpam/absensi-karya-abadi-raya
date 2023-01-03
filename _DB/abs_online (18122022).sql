-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_check` datetime DEFAULT NULL,
  `hadir` tinyint(1) NOT NULL DEFAULT 0,
  `telat` tinyint(1) NOT NULL,
  `ijin` tinyint(1) NOT NULL DEFAULT 0,
  `sakit` tinyint(1) NOT NULL DEFAULT 0,
  `cuti` tinyint(1) NOT NULL DEFAULT 0,
  `check_in` tinyint(1) NOT NULL DEFAULT 0,
  `check_out` tinyint(1) NOT NULL DEFAULT 0,
  `visit` tinyint(1) NOT NULL DEFAULT 0,
  `lang_code` varchar(191) DEFAULT NULL,
  `lat_code` varchar(191) DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `status_absen` enum('online','offline','ijin','sakit','cuti') NOT NULL DEFAULT 'offline',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `absensi` (`id`, `id_karyawan`, `tanggal`, `waktu_check`, `hadir`, `telat`, `ijin`, `sakit`, `cuti`, `check_in`, `check_out`, `visit`, `lang_code`, `lat_code`, `gambar`, `status_absen`, `keterangan`, `created_at`, `updated_at`) VALUES
(1,	2,	'2022-12-13',	'2022-12-13 10:37:16',	1,	0,	0,	0,	0,	1,	0,	0,	'106.8284434',	'-6.1363378',	'images/absen_online/2_2022-12-13.png',	'online',	NULL,	'2022-12-13 03:37:16',	'2022-12-13 03:37:16'),
(2,	2,	'2022-12-13',	'2022-12-13 10:37:29',	1,	0,	0,	0,	0,	0,	1,	0,	'106.8284434',	'-6.1363378',	'images/absen_online/2_2022-12-13.png',	'online',	NULL,	'2022-12-13 03:37:29',	'2022-12-13 03:37:29'),
(3,	3,	'2022-12-13',	'2022-12-13 15:06:23',	1,	0,	0,	0,	0,	1,	0,	0,	'106.8284389',	'-6.136329',	'images/absen_online/3_2022-12-13.png',	'offline',	NULL,	'2022-12-13 08:06:23',	'2022-12-13 08:06:23'),
(4,	3,	'2022-12-13',	'2022-12-13 15:07:19',	1,	0,	0,	0,	0,	0,	1,	0,	'106.8284389',	'-6.136329',	'images/absen_online/3_2022-12-13.png',	'offline',	NULL,	'2022-12-13 08:07:19',	'2022-12-13 08:07:19'),
(5,	2,	'2022-12-17',	'2022-12-17 22:59:00',	1,	1,	0,	0,	0,	1,	0,	0,	'106.7483136',	'-6.2783488',	'images/absen_online/2_2022-12-17.png',	'offline',	NULL,	'2022-12-17 15:59:00',	'2022-12-17 15:59:00'),
(6,	2,	'2022-12-17',	'2022-12-17 23:04:59',	1,	1,	0,	0,	0,	0,	1,	0,	'106.8199028',	'-6.3300357',	'images/absen_online/2_2022-12-17.png',	'offline',	NULL,	'2022-12-17 16:04:59',	'2022-12-17 16:04:59');

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_area` varchar(191) NOT NULL,
  `lang_area` varchar(191) DEFAULT NULL,
  `lat_area` varchar(191) DEFAULT NULL,
  `map_link` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `area` (`id`, `nama_area`, `lang_area`, `lat_area`, `map_link`, `keterangan`, `created_at`, `updated_at`) VALUES
(1,	'jagakarsa',	'106.82563433730178',	'-6.335874968019052',	'https://goo.gl/maps/TvBVJmvtJtFumart5',	NULL,	'2022-12-11 08:31:37',	'2022-12-11 08:31:37'),
(2,	'Mangga Dua',	'106.82432387562956',	'-6.133273042147454',	'https://goo.gl/maps/LAmNHKf4BwwCLtTt7',	NULL,	'2022-12-11 08:32:33',	'2022-12-11 08:32:33'),
(3,	'Kalideres',	'106.70521250915573',	'-6.151123992335719',	'https://goo.gl/maps/pQw127R2NdtyfYWy8',	NULL,	'2022-12-11 08:33:27',	'2022-12-11 08:33:27');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(82,	'2014_10_12_000000_create_users_table',	1),
(83,	'2014_10_12_100000_create_password_resets_table',	1),
(84,	'2014_10_12_200000_add_two_factor_columns_to_users_table',	1),
(85,	'2019_08_19_000000_create_failed_jobs_table',	1),
(86,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(87,	'2021_03_05_200904_buat_setting_table',	1),
(88,	'2021_03_11_225128_create_sessions_table',	1),
(89,	'2022_11_16_104757_create_areas_table',	1),
(90,	'2022_11_16_104939_create_absensis_table',	1),
(91,	'2022_11_16_105117_create_invoices_table',	1),
(92,	'2022_11_18_133255_create_tb_jadwal_areas_table',	1),
(93,	'2022_12_11_150807_create_sik__karyawans_table',	1);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gBf3DLhRPweKaboWGh1uLl11hj3qBL8AzVoJeSEh',	NULL,	'::1',	'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',	'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGVvcnVuSWdtdFplazgzb3hZZnpmZmpSbU1xdG85cXo3V3BQT1pZWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvYWJzX29ubGluZS9sb2dpbiI7fX0=',	1671297773);

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(191) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(191) DEFAULT NULL,
  `radius_area` int(11) DEFAULT NULL,
  `path_logo` varchar(191) DEFAULT NULL,
  `map_api_key` text DEFAULT NULL,
  `jam_masuk_kerja` time DEFAULT NULL,
  `jam_pulang_kerja` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `setting` (`id`, `nama_perusahaan`, `alamat`, `telepon`, `radius_area`, `path_logo`, `map_api_key`, `jam_masuk_kerja`, `jam_pulang_kerja`, `created_at`, `updated_at`) VALUES
(1,	'PT. Coba',	'Jl. Raya Senen',	'081234779987',	500,	'/img/logo.svg',	NULL,	'08:30:00',	'17:00:00',	NULL,	NULL);

DROP TABLE IF EXISTS `sik_karyawan`;
CREATE TABLE `sik_karyawan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_start` date NOT NULL,
  `tanggal_end` date NOT NULL,
  `sik` enum('ijin','cuti','sakit') NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_by` varchar(191) DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tb_jadwal_area`;
CREATE TABLE `tb_jadwal_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_area` int(10) unsigned NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_jadwal_area_id_user_foreign` (`id_user`),
  KEY `tb_jadwal_area_id_area_foreign` (`id_area`),
  CONSTRAINT `tb_jadwal_area_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tb_jadwal_area_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_jadwal_area` (`id`, `id_user`, `id_area`, `keterangan`, `created_at`, `updated_at`) VALUES
(1,	2,	3,	NULL,	'2022-12-13 03:30:18',	'2022-12-13 03:30:18'),
(2,	2,	2,	NULL,	'2022-12-13 03:30:18',	'2022-12-13 03:30:18'),
(3,	3,	3,	NULL,	'2022-12-13 08:05:55',	'2022-12-13 08:05:55'),
(4,	3,	1,	NULL,	'2022-12-13 08:05:55',	'2022-12-13 08:05:55');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `profile_photo_path` text DEFAULT NULL,
  `foto` varchar(191) DEFAULT NULL,
  `level` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `nip` text DEFAULT NULL,
  `api_token` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `mobile`, `profile_photo_path`, `foto`, `level`, `nip`, `api_token`, `deleted`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	'Administrator',	'admin@gmail.com',	'$2y$10$.lKXd7O44epxWzCB.dXrp.vOsIQzm.LZ4E4.MzR2JTChMnoUM2zKi',	NULL,	NULL,	NULL,	NULL,	'/img/user.jpg',	'admin',	NULL,	NULL,	0,	NULL,	NULL,	'2022-12-12 07:34:06',	'2022-12-12 07:34:06'),
(2,	'Karyawan 01',	'karyawan@gmail.com',	'$2y$10$KqDPlDn0S1XHSomDp5.81eBtByuJxO0wk2BH4tO3Km5Ka29alsf.e',	NULL,	NULL,	NULL,	NULL,	'/img/user.jpg',	'karyawan',	'KRY01',	NULL,	0,	NULL,	NULL,	'2022-12-12 07:34:06',	'2022-12-12 07:34:06'),
(3,	'Karyawan 02',	'karyawan2@gmail.com',	'$2y$10$Ysll9cDLVA/b4ab1BwynDu5iDv5NhM.9gPDNE/h3AKQ2l/rqicF3m',	NULL,	NULL,	NULL,	NULL,	'/img/user.jpg',	'karyawan',	'KRY02',	NULL,	0,	NULL,	NULL,	'2022-12-13 08:05:37',	'2022-12-13 08:05:37');

-- 2022-12-17 17:23:31
