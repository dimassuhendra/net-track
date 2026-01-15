-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 10:08 AM
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
-- Database: `net_track`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `model_type`, `model_id`, `payload`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mengubah Customer', 'App\\Models\\Customer', 10, '{\"kontak\":\"081900112234\",\"updated_at\":\"2026-01-15 08:09:19\"}', '127.0.0.1', '2026-01-15 01:09:20', '2026-01-15 01:09:20'),
(2, 1, 'Membuat User', 'App\\Models\\User', 5, '[]', '127.0.0.1', '2026-01-15 01:16:18', '2026-01-15 01:16:18'),
(3, 1, 'Menghapus User', 'App\\Models\\User', 5, '[]', '127.0.0.1', '2026-01-15 01:16:37', '2026-01-15 01:16:37'),
(4, 1, 'Membuat Ticket', 'App\\Models\\Ticket', 32, '[]', '127.0.0.1', '2026-01-15 01:34:10', '2026-01-15 01:34:10'),
(5, 1, 'Membuat Ticket', 'App\\Models\\Ticket', 33, '[]', '127.0.0.1', '2026-01-15 01:39:14', '2026-01-15 01:39:14'),
(6, 1, 'Menghapus Ticket', 'App\\Models\\Ticket', 33, '[]', '127.0.0.1', '2026-01-15 01:40:12', '2026-01-15 01:40:12'),
(7, 1, 'Menghapus Ticket', 'App\\Models\\Ticket', 32, '[]', '127.0.0.1', '2026-01-15 01:40:17', '2026-01-15 01:40:17'),
(8, 2, 'Membuat Ticket', 'App\\Models\\Ticket', 34, '[]', '127.0.0.1', '2026-01-15 01:40:50', '2026-01-15 01:40:50'),
(9, 2, 'Membuat Ticket', 'App\\Models\\Ticket', 35, '[]', '127.0.0.1', '2026-01-15 01:41:14', '2026-01-15 01:41:14'),
(10, 2, 'Membuat Ticket', 'App\\Models\\Ticket', 36, '[]', '127.0.0.1', '2026-01-15 01:42:15', '2026-01-15 01:42:15'),
(11, 1, 'Membuat Ticket', 'App\\Models\\Ticket', 37, '[]', '127.0.0.1', '2026-01-15 08:55:50', '2026-01-15 08:55:50');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Bandwidth', 'Masalah kecepatan lambat atau latency tinggi', NULL, NULL),
(2, 'Transmisi Putus', 'Gangguan pada kabel FO (Cut) atau link radio', NULL, NULL),
(3, 'Perangkat', 'Kerusakan pada Router, ONT, atau Switch', NULL, NULL),
(4, 'Human Error', 'Kesalahan konfigurasi atau teknis lapangan', NULL, NULL),
(5, 'Mati Lampu', 'Gangguan power di sisi pelanggan atau POP', NULL, NULL),
(6, 'Upstream/Pihak Ketiga', 'Gangguan dari provider pusat', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `layanan` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kontak` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `nama_pelanggan`, `layanan`, `alamat`, `kontak`, `created_at`, `updated_at`) VALUES
(1, 'SID-00101', 'PT. Teknologi Maju', 'Dedicated 100Mbps', 'Jl. Sudirman No. 10, Jakarta', '081234567890', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(2, 'SID-00102', 'Bpk. Budi Santoso', 'Broadband Home 50Mbps', 'Perumahan Elok Blok A1, Bekasi', '081399887766', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(3, 'SID-00103', 'Cafe Kopi Senja', 'Broadband Business 30Mbps', 'Jl. Melati No. 5, Bandung', '085522334455', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(4, 'SID-00104', 'Dinas Pendidikan Kota', 'Dedicated 1Gbps', 'Jl. Balai Kota No. 1, Semarang', '02477889900', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(5, 'SID-00105', 'Ibu Siti Aminah', 'Broadband Home 20Mbps', 'Jl. Merdeka Gg. 4, Surabaya', '081211223344', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(6, 'SID-00106', 'Hotel Grand Star', 'Dedicated 200Mbps', 'Jl. Pariwisata No. 88, Bali', '0361223344', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(7, 'SID-00107', 'Resto Ayam Bakar', 'Broadband Business 20Mbps', 'Kios Pasar Baru No. 12', '087755667788', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(8, 'SID-00108', 'PT. Logistik Cepat', 'Dedicated 50Mbps', 'Kawasan Industri Jababeka', '02188991122', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(9, 'SID-00109', 'Apartemen Sky View', 'Metronet 1Gbps', 'Unit 12B Tower Utara', '02144556677', '2026-01-15 06:45:18', '2026-01-15 06:45:18'),
(10, 'SID-00110', 'Warnet Gaming Lite', 'Broadband Business 100Mbps', 'Jl. Pemuda No. 45', '081900112234', '2026-01-15 06:45:18', '2026-01-15 01:09:19');

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
(4, '2026_01_15_034737_create_categories_table', 1),
(5, '2026_01_15_034743_create_customers_table', 1),
(6, '2026_01_15_034751_create_tickets_table', 1),
(7, '2026_01_15_035036_create_activity_logs_table', 1);

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
('TOlSCaDLe7w2jRwvkP5MFK044vbqy3cjObNbG2Dz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUkxRZGFRUHBqSlo0aEdXeURlWjB2cG5TOE12bnlvSGZVWTRLOThGZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90aWNrZXRzP2VuZF9kYXRlPSZwZXJfcGFnZT01MCZzZWFyY2g9JnN0YXJ0X2RhdGU9JnN0YXR1cz0iO3M6NToicm91dGUiO3M6MTM6InRpY2tldHMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768467368);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `rincian_masalah` text NOT NULL,
  `action_taken` text DEFAULT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open',
  `priority` enum('Low','Medium','High','Critical') NOT NULL DEFAULT 'Medium',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_number`, `customer_id`, `category_id`, `user_id`, `waktu_mulai`, `waktu_selesai`, `rincian_masalah`, `action_taken`, `status`, `priority`, `created_at`, `updated_at`) VALUES
(1, 'TIC-20260115-001', 6, 5, 1, '2026-01-14 11:33:28', '2026-01-14 15:33:28', 'Router sering restart sendiri', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'Medium', '2026-01-14 04:33:28', '2026-01-14 05:33:28'),
(2, 'TIC-20260115-011', 5, 2, 1, '2026-01-12 11:15:05', '2026-01-12 15:15:05', 'Lampu indikator LOS berkedip merah', 'Splicing ulang kabel dropcore di FO closure', 'Resolved', 'Medium', '2026-01-12 04:15:05', '2026-01-12 06:15:05'),
(3, 'TIC-20260115-021', 5, 3, 1, '2026-01-15 12:35:17', '2026-01-15 16:35:17', 'Kabel dropcore terjepit pintu', 'Melakukan konfigurasi ulang pada sisi OLT', 'Resolved', 'Medium', '2026-01-15 05:35:17', '2026-01-15 08:35:17'),
(4, 'TIC-20260115-002', 7, 4, 1, '2026-01-09 13:46:47', '2026-01-09 17:46:47', 'Kabel dropcore terjepit pintu', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'Medium', '2026-01-09 06:46:47', '2026-01-09 10:46:47'),
(5, 'TIC-20260115-012', 2, 3, 1, '2026-01-11 08:33:30', '2026-01-11 13:33:30', 'Koneksi internet lambat pada jam sibuk', 'Reset factory dan setting ulang SSID', 'Resolved', 'High', '2026-01-11 01:33:30', '2026-01-11 06:33:30'),
(6, 'TIC-20260115-022', 3, 5, 1, '2026-01-09 08:28:09', '2026-01-09 10:28:09', 'Koneksi internet lambat pada jam sibuk', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'High', '2026-01-09 01:28:09', '2026-01-09 03:28:09'),
(7, 'TIC-20260115-003', 2, 1, 1, '2026-01-14 10:10:46', '2026-01-14 12:10:46', 'Lampu indikator LOS berkedip merah', 'Splicing ulang kabel dropcore di FO closure', 'Resolved', 'Medium', '2026-01-14 03:10:46', '2026-01-14 05:10:46'),
(8, 'TIC-20260115-013', 2, 4, 1, '2026-01-13 14:09:19', '2026-01-13 15:09:19', 'Router sering restart sendiri', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'Medium', '2026-01-13 07:09:19', '2026-01-13 12:09:19'),
(9, 'TIC-20260115-023', 6, 2, 1, '2026-01-15 11:15:50', '2026-01-15 14:15:50', 'Sinyal wifi tidak sampai ke lantai 2', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'Low', '2026-01-15 04:15:50', '2026-01-15 08:15:50'),
(10, 'TIC-20260115-004', 9, 2, 1, '2026-01-10 09:29:55', '2026-01-10 10:29:55', 'Router sering restart sendiri', 'Splicing ulang kabel dropcore di FO closure', 'Resolved', 'Low', '2026-01-10 02:29:55', '2026-01-10 07:29:55'),
(11, 'TIC-20260115-014', 3, 1, 1, '2026-01-14 09:14:44', '2026-01-14 14:14:44', 'Lampu indikator LOS berkedip merah', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'High', '2026-01-14 02:14:44', '2026-01-14 06:14:44'),
(12, 'TIC-20260115-024', 10, 3, 1, '2026-01-14 09:18:58', '2026-01-14 14:18:58', 'Koneksi internet lambat pada jam sibuk', 'Melakukan konfigurasi ulang pada sisi OLT', 'Resolved', 'High', '2026-01-14 02:18:58', '2026-01-14 06:18:58'),
(13, 'TIC-20260115-005', 6, 4, 1, '2026-01-11 09:05:51', '2026-01-11 10:05:51', 'Sinyal wifi tidak sampai ke lantai 2', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'Medium', '2026-01-11 02:05:51', '2026-01-11 05:05:51'),
(14, 'TIC-20260115-015', 8, 3, 1, '2026-01-14 08:11:56', '2026-01-14 09:11:56', 'Sinyal wifi tidak sampai ke lantai 2', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'Low', '2026-01-14 01:11:56', '2026-01-14 06:11:56'),
(15, 'TIC-20260115-025', 1, 4, 1, '2026-01-13 14:46:36', '2026-01-13 18:46:36', 'Sinyal wifi tidak sampai ke lantai 2', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'Low', '2026-01-13 07:46:36', '2026-01-13 12:46:36'),
(16, 'TIC-20260115-006', 4, 4, 1, '2026-01-15 14:00:27', '2026-01-15 16:00:27', 'Koneksi internet lambat pada jam sibuk', 'Melakukan konfigurasi ulang pada sisi OLT', 'Resolved', 'Medium', '2026-01-15 07:00:27', '2026-01-15 12:00:27'),
(17, 'TIC-20260115-016', 3, 5, 1, '2026-01-15 12:27:37', '2026-01-15 16:27:37', 'Koneksi internet lambat pada jam sibuk', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'Medium', '2026-01-15 05:27:37', '2026-01-15 10:27:37'),
(18, 'TIC-20260115-026', 6, 2, 1, '2026-01-11 08:38:53', '2026-01-11 11:38:53', 'Tidak bisa akses website tertentu', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'Low', '2026-01-11 01:38:53', '2026-01-11 03:38:53'),
(19, 'TIC-20260115-007', 2, 3, 1, '2026-01-13 15:41:40', '2026-01-13 17:41:40', 'Router sering restart sendiri', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'High', '2026-01-13 08:41:40', '2026-01-13 11:41:40'),
(20, 'TIC-20260115-017', 7, 5, 1, '2026-01-13 09:05:51', '2026-01-13 10:05:51', 'Lampu indikator LOS berkedip merah', 'Reset factory dan setting ulang SSID', 'Resolved', 'Low', '2026-01-13 02:05:51', '2026-01-13 05:05:51'),
(21, 'TIC-20260115-027', 7, 3, 1, '2026-01-11 11:32:14', '2026-01-11 15:32:14', 'Koneksi internet lambat pada jam sibuk', 'Mengganti patchcord dan membersihkan adapter', 'Resolved', 'Medium', '2026-01-11 04:32:14', '2026-01-11 06:32:14'),
(22, 'TIC-20260115-008', 9, 2, 1, '2026-01-11 10:34:58', '2026-01-11 11:34:58', 'Router sering restart sendiri', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'High', '2026-01-11 03:34:58', '2026-01-11 04:34:58'),
(23, 'TIC-20260115-018', 3, 3, 1, '2026-01-11 14:31:03', '2026-01-11 18:31:03', 'Kabel dropcore terjepit pintu', 'Edukasi pelanggan terkait interferensi frekuensi wifi', 'Resolved', 'Medium', '2026-01-11 07:31:03', '2026-01-11 09:31:03'),
(24, 'TIC-20260115-028', 7, 3, 1, '2026-01-12 11:56:16', '2026-01-12 14:56:16', 'Tidak bisa akses website tertentu', 'Splicing ulang kabel dropcore di FO closure', 'Resolved', 'Medium', '2026-01-12 04:56:16', '2026-01-12 09:56:16'),
(25, 'TIC-20260115-009', 2, 2, 1, '2026-01-14 10:45:52', '2026-01-14 11:45:52', 'Kabel dropcore terjepit pintu', 'Reset factory dan setting ulang SSID', 'Resolved', 'Low', '2026-01-14 03:45:52', '2026-01-14 04:45:52'),
(26, 'TIC-20260115-019', 10, 2, 1, '2026-01-10 12:49:17', '2026-01-10 17:49:17', 'Tidak bisa akses website tertentu', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'High', '2026-01-10 05:49:17', '2026-01-10 10:49:17'),
(27, 'TIC-20260115-029', 10, 5, 1, '2026-01-10 14:03:46', '2026-01-10 18:03:46', 'Router sering restart sendiri', 'Melakukan konfigurasi ulang pada sisi OLT', 'Resolved', 'Medium', '2026-01-10 07:03:46', '2026-01-10 09:03:46'),
(28, 'TIC-20260115-010', 4, 2, 1, '2026-01-15 13:20:31', '2026-01-15 17:20:31', 'Koneksi internet lambat pada jam sibuk', 'Reset factory dan setting ulang SSID', 'Resolved', 'Medium', '2026-01-15 06:20:31', '2026-01-15 09:20:31'),
(29, 'TIC-20260115-020', 1, 3, 1, '2026-01-11 12:05:44', '2026-01-11 14:05:44', 'Kabel dropcore terjepit pintu', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'High', '2026-01-11 05:05:44', '2026-01-11 09:05:44'),
(30, 'TIC-20260115-030', 5, 2, 1, '2026-01-14 08:33:42', '2026-01-14 13:33:42', 'Tidak bisa akses website tertentu', 'Melakukan penarikan ulang kabel sejauh 50 meter', 'Resolved', 'High', '2026-01-14 01:33:42', '2026-01-14 06:33:42'),
(34, 'TIC-20260115-997', 4, 4, 2, '2026-01-15 08:40:50', NULL, 'eror', 'eror', 'Open', 'Medium', '2026-01-15 01:40:50', '2026-01-15 01:40:50'),
(35, 'TIC-20260115-313', 7, 5, 2, '2026-01-15 08:41:14', NULL, 'mati lampu', 'mati lampu', 'Resolved', 'Medium', '2026-01-15 01:41:14', '2026-01-15 01:41:14'),
(36, 'TIC-20260115-919', 5, 3, 2, '2026-01-15 08:42:15', NULL, 'eror', 'EROR', 'Resolved', 'Medium', '2026-01-15 01:42:15', '2026-01-15 01:42:15'),
(37, 'TIC-20260115-275', 8, 4, 1, '2026-01-15 15:55:50', NULL, 'eror', 'eror', 'Resolved', 'Medium', '2026-01-15 08:55:50', '2026-01-15 08:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('staff','manager_it','gm','admin') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@arindama.com', '$2y$12$pmCPktlNXJ.cxbQ6HSgyxO/jvTZoGrrEMYFVCYQ9SqIjIh6KCs4pa', 'admin', NULL, '2026-01-14 21:16:21', '2026-01-14 21:16:21'),
(2, 'Main Staff', 'staff@arindama.com', '$2y$12$KzQ511N9xWglDz5Tq0TTXeNJ3f.U8qn0AdUYdPvQat4RqRxGLdbh2', 'staff', NULL, '2026-01-14 21:16:21', '2026-01-14 21:16:21'),
(3, 'Pak Jay', 'jay@arindama.com', '$2y$12$X/TPdG5BXMsD8kLGzUKUy.q//vOqjmeKLIA.c9VWq/WQxZ0S8ykSG', 'manager_it', NULL, '2026-01-14 21:16:22', '2026-01-14 21:16:22'),
(4, 'Mei Yung', 'mei@arindama.com', '$2y$12$bN7bb8OLQq35m0uPx86IO.AdiqPGq5tU/CgC5Q868zAZJbDUNgshy', 'gm', NULL, '2026-01-14 21:16:22', '2026-01-14 21:16:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_customer_id_unique` (`customer_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  ADD KEY `tickets_customer_id_foreign` (`customer_id`),
  ADD KEY `tickets_category_id_foreign` (`category_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
