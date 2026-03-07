-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2026 at 03:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_garden_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_27_164932_create_plant_readings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plant_readings`
--

CREATE TABLE `plant_readings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `temp` double NOT NULL,
  `humidity` double NOT NULL,
  `soil_raw` int(11) NOT NULL,
  `soil_percent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plant_readings`
--

INSERT INTO `plant_readings` (`id`, `temp`, `humidity`, `soil_raw`, `soil_percent`, `created_at`, `updated_at`) VALUES
(1, 28.9, 89, 626, 35, '2026-03-01 11:39:20', '2026-03-01 11:39:20'),
(2, 28.9, 89, 619, 36, '2026-03-01 11:39:59', '2026-03-01 11:39:59'),
(3, 29.8, 95, 626, 35, '2026-03-01 11:40:12', '2026-03-01 11:40:12'),
(4, 30.2, 95, 626, 35, '2026-03-01 11:40:26', '2026-03-01 11:40:26'),
(5, 31.3, 98, 643, 31, '2026-03-01 11:40:52', '2026-03-01 11:40:52'),
(6, 32.3, 98, 595, 41, '2026-03-01 11:41:05', '2026-03-01 11:41:05'),
(7, 31.8, 94, 595, 41, '2026-03-01 11:41:18', '2026-03-01 11:41:18'),
(8, 31.8, 91, 596, 41, '2026-03-01 11:41:32', '2026-03-01 11:41:32'),
(9, 31.3, 88, 661, 28, '2026-03-01 11:41:58', '2026-03-01 11:41:58'),
(10, 30.9, 87, 662, 28, '2026-03-01 11:42:24', '2026-03-01 11:42:24'),
(11, 30.8, 85, 618, 36, '2026-03-01 11:42:38', '2026-03-01 11:42:38'),
(12, 30.2, 84, 617, 37, '2026-03-01 11:42:51', '2026-03-01 11:42:51'),
(13, 30.1, 84, 614, 37, '2026-03-01 11:43:04', '2026-03-01 11:43:04'),
(14, 29.8, 85, 617, 37, '2026-03-01 11:43:18', '2026-03-01 11:43:18'),
(15, 29.8, 86, 617, 37, '2026-03-01 11:43:31', '2026-03-01 11:43:31'),
(16, 28.9, 70, 643, 31, '2026-03-03 08:07:23', '2026-03-03 08:07:23'),
(17, 28.9, 69, 647, 31, '2026-03-03 08:07:49', '2026-03-03 08:07:49'),
(18, 28.9, 71, 648, 30, '2026-03-03 08:08:15', '2026-03-03 08:08:15'),
(19, 28.9, 71, 644, 31, '2026-03-03 08:08:41', '2026-03-03 08:08:41'),
(20, 28.9, 69, 647, 31, '2026-03-03 08:09:08', '2026-03-03 08:09:08'),
(21, 28.9, 70, 648, 30, '2026-03-03 08:09:34', '2026-03-03 08:09:34'),
(22, 28.5, 71, 619, 36, '2026-03-03 08:09:47', '2026-03-03 08:09:47'),
(23, 28.5, 69, 661, 28, '2026-03-03 08:10:13', '2026-03-03 08:10:13'),
(24, 28.5, 70, 326, 95, '2026-03-03 08:10:26', '2026-03-03 08:10:26'),
(25, 28.5, 72, 326, 95, '2026-03-03 08:10:39', '2026-03-03 08:10:39'),
(26, 28.5, 71, 322, 96, '2026-03-03 08:10:53', '2026-03-03 08:10:53'),
(27, 28.5, 70, 320, 96, '2026-03-03 08:11:06', '2026-03-03 08:11:06'),
(28, 28.5, 69, 326, 95, '2026-03-03 08:11:19', '2026-03-03 08:11:19'),
(29, 28.5, 68, 325, 95, '2026-03-03 08:11:32', '2026-03-03 08:11:32'),
(30, 28.5, 68, 326, 95, '2026-03-03 08:11:45', '2026-03-03 08:11:45'),
(31, 28.5, 69, 326, 95, '2026-03-03 08:11:58', '2026-03-03 08:11:58'),
(32, 28.5, 69, 325, 95, '2026-03-03 08:12:12', '2026-03-03 08:12:12'),
(33, 28.5, 69, 326, 95, '2026-03-03 08:12:25', '2026-03-03 08:12:25'),
(34, 28.5, 70, 326, 95, '2026-03-03 08:12:38', '2026-03-03 08:12:38'),
(35, 28.5, 69, 326, 95, '2026-03-03 08:12:51', '2026-03-03 08:12:51'),
(36, 28.5, 69, 326, 95, '2026-03-03 08:13:04', '2026-03-03 08:13:04'),
(37, 28.5, 71, 326, 95, '2026-03-03 08:13:17', '2026-03-03 08:13:17'),
(38, 28.9, 89, 325, 95, '2026-03-03 08:13:31', '2026-03-03 08:13:31'),
(39, 29.8, 95, 327, 95, '2026-03-03 08:13:44', '2026-03-03 08:13:44'),
(40, 30.8, 98, 327, 95, '2026-03-03 08:13:57', '2026-03-03 08:13:57'),
(41, 31.3, 98, 327, 95, '2026-03-03 08:14:10', '2026-03-03 08:14:10'),
(42, 31.8, 98, 327, 95, '2026-03-03 08:14:23', '2026-03-03 08:14:23'),
(43, 31.3, 98, 327, 95, '2026-03-03 08:14:36', '2026-03-03 08:14:36'),
(44, 30.8, 92, 323, 95, '2026-03-03 08:14:50', '2026-03-03 08:14:50'),
(45, 30.2, 83, 327, 95, '2026-03-03 08:15:03', '2026-03-03 08:15:03'),
(46, 30.2, 74, 327, 95, '2026-03-03 08:15:16', '2026-03-03 08:15:16'),
(47, 29.8, 70, 326, 95, '2026-03-03 08:15:29', '2026-03-03 08:15:29'),
(48, 29.8, 68, 326, 95, '2026-03-03 08:15:42', '2026-03-03 08:15:42'),
(49, 29.8, 66, 327, 95, '2026-03-03 08:15:55', '2026-03-03 08:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9nlSRXwCdkTl5AnboV4HGWtawWMimLh00545UrHU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVBOWERUbTdpTU5EZWVnVGhjaHBlTk1sNGhqd2o2anJYOUZZVFZXVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdml0YWxzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1772525772),
('QT3fiibGum0mIpJ0yfil3XopaXNc6eQJSdefRYQ9', NULL, '192.168.132.83', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDR5VWkxanpHN29jQ1JlemprVktTRmdrTTRJOTl0UjdicUxvNlVLaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjEzMi42Nzo4MDAwL2FwaS92aXRhbHMiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1772525783);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `plant_readings`
--
ALTER TABLE `plant_readings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plant_readings`
--
ALTER TABLE `plant_readings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
