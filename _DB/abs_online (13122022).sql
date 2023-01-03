-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 11:36 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abs_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_check` datetime DEFAULT NULL,
  `hadir` tinyint(1) NOT NULL DEFAULT 0,
  `ijin` tinyint(1) NOT NULL DEFAULT 0,
  `sakit` tinyint(1) NOT NULL DEFAULT 0,
  `cuti` tinyint(1) NOT NULL DEFAULT 0,
  `check_in` tinyint(1) NOT NULL DEFAULT 0,
  `check_out` tinyint(1) NOT NULL DEFAULT 0,
  `visit` tinyint(1) NOT NULL DEFAULT 0,
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_absen` enum('online','offline','ijin','sakit','cuti') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_karyawan`, `tanggal`, `waktu_check`, `hadir`, `ijin`, `sakit`, `cuti`, `check_in`, `check_out`, `visit`, `lang_code`, `lat_code`, `gambar`, `status_absen`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, '2022-12-13', '2022-12-13 10:37:16', 1, 0, 0, 0, 1, 0, 0, '106.8284434', '-6.1363378', 'images/absen_online/2_2022-12-13.png', 'online', NULL, '2022-12-13 03:37:16', '2022-12-13 03:37:16'),
(2, 2, '2022-12-13', '2022-12-13 10:37:29', 1, 0, 0, 0, 0, 1, 0, '106.8284434', '-6.1363378', 'images/absen_online/2_2022-12-13.png', 'online', NULL, '2022-12-13 03:37:29', '2022-12-13 03:37:29'),
(3, 3, '2022-12-13', '2022-12-13 15:06:23', 1, 0, 0, 0, 1, 0, 0, '106.8284389', '-6.136329', 'images/absen_online/3_2022-12-13.png', 'offline', NULL, '2022-12-13 08:06:23', '2022-12-13 08:06:23'),
(4, 3, '2022-12-13', '2022-12-13 15:07:19', 1, 0, 0, 0, 0, 1, 0, '106.8284389', '-6.136329', 'images/absen_online/3_2022-12-13.png', 'offline', NULL, '2022-12-13 08:07:19', '2022-12-13 08:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `nama_area`, `lang_area`, `lat_area`, `map_link`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'jagakarsa', '106.82563433730178', '-6.335874968019052', 'https://goo.gl/maps/TvBVJmvtJtFumart5', NULL, '2022-12-11 08:31:37', '2022-12-11 08:31:37'),
(2, 'Mangga Dua', '106.82432387562956', '-6.133273042147454', 'https://goo.gl/maps/LAmNHKf4BwwCLtTt7', NULL, '2022-12-11 08:32:33', '2022-12-11 08:32:33'),
(3, 'Kalideres', '106.70521250915573', '-6.151123992335719', 'https://goo.gl/maps/pQw127R2NdtyfYWy8', NULL, '2022-12-11 08:33:27', '2022-12-11 08:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(82, '2014_10_12_000000_create_users_table', 1),
(83, '2014_10_12_100000_create_password_resets_table', 1),
(84, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(85, '2019_08_19_000000_create_failed_jobs_table', 1),
(86, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(87, '2021_03_05_200904_buat_setting_table', 1),
(88, '2021_03_11_225128_create_sessions_table', 1),
(89, '2022_11_16_104757_create_areas_table', 1),
(90, '2022_11_16_104939_create_absensis_table', 1),
(91, '2022_11_16_105117_create_invoices_table', 1),
(92, '2022_11_18_133255_create_tb_jadwal_areas_table', 1),
(93, '2022_12_11_150807_create_sik__karyawans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4CP0uLvGb2wUHlFRnc9qU2jGPFIpSXK5pg2LYjpx', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEZrbzlIdVVtTDVvVE80NU9hWVYyajAzdWRsZzQ2V1VuTmtlZ0I4MSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvYWJzX29ubGluZS9sb2dpbiI7fX0=', 1670927720);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radius_area` int(11) DEFAULT NULL,
  `path_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_api_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `nama_perusahaan`, `alamat`, `telepon`, `radius_area`, `path_logo`, `map_api_key`, `created_at`, `updated_at`) VALUES
(1, 'PT. Coba', 'Jl. Raya Senen', '081234779987', 500, '/img/logo.svg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sik_karyawan`
--

CREATE TABLE `sik_karyawan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_start` date NOT NULL,
  `tanggal_end` date NOT NULL,
  `sik` enum('ijin','cuti','sakit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal_area`
--

CREATE TABLE `tb_jadwal_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_area` int(10) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jadwal_area`
--

INSERT INTO `tb_jadwal_area` (`id`, `id_user`, `id_area`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 3, NULL, '2022-12-13 03:30:18', '2022-12-13 03:30:18'),
(2, 2, 2, NULL, '2022-12-13 03:30:18', '2022-12-13 03:30:18'),
(3, 3, 3, NULL, '2022-12-13 08:05:55', '2022-12-13 08:05:55'),
(4, 3, 1, NULL, '2022-12-13 08:05:55', '2022-12-13 08:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('admin','karyawan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `nip` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `mobile`, `profile_photo_path`, `foto`, `level`, `nip`, `api_token`, `deleted`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$.lKXd7O44epxWzCB.dXrp.vOsIQzm.LZ4E4.MzR2JTChMnoUM2zKi', NULL, NULL, NULL, NULL, '/img/user.jpg', 'admin', NULL, NULL, 0, NULL, NULL, '2022-12-12 07:34:06', '2022-12-12 07:34:06'),
(2, 'Karyawan 01', 'karyawan@gmail.com', '$2y$10$KqDPlDn0S1XHSomDp5.81eBtByuJxO0wk2BH4tO3Km5Ka29alsf.e', NULL, NULL, NULL, NULL, '/img/user.jpg', 'karyawan', 'KRY01', NULL, 0, NULL, NULL, '2022-12-12 07:34:06', '2022-12-12 07:34:06'),
(3, 'Karyawan 02', 'karyawan2@gmail.com', '$2y$10$Ysll9cDLVA/b4ab1BwynDu5iDv5NhM.9gPDNE/h3AKQ2l/rqicF3m', NULL, NULL, NULL, NULL, '/img/user.jpg', 'karyawan', 'KRY02', NULL, 0, NULL, NULL, '2022-12-13 08:05:37', '2022-12-13 08:05:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sik_karyawan`
--
ALTER TABLE `sik_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jadwal_area`
--
ALTER TABLE `tb_jadwal_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_jadwal_area_id_user_foreign` (`id_user`),
  ADD KEY `tb_jadwal_area_id_area_foreign` (`id_area`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sik_karyawan`
--
ALTER TABLE `sik_karyawan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jadwal_area`
--
ALTER TABLE `tb_jadwal_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_jadwal_area`
--
ALTER TABLE `tb_jadwal_area`
  ADD CONSTRAINT `tb_jadwal_area_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_jadwal_area_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
