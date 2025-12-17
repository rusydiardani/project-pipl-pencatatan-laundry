-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2025 at 05:49 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_phone_unique` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Kasim Marpaung S.E.', '0509 3228 6423', NULL, 'Jln. Hasanuddin No. 204, Bontang 71984, Sumut', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(2, 'Wardaya Cawisadi Jailani', '0644 9630 883', NULL, 'Ki. Basmol Raya No. 500, Lhokseumawe 21116, Bali', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(3, 'Uchita Yuliarti', '0528 1105 161', NULL, 'Jr. Abdul. Muis No. 585, Administrasi Jakarta Utara 51887, Sultra', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(4, 'Ani Winda Utami S.IP', '0874 1873 9059', NULL, 'Ds. Panjaitan No. 146, Kendari 72209, Sulteng', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(5, 'Kiandra Purnawati', '0928 2947 394', NULL, 'Kpg. Cut Nyak Dien No. 103, Samarinda 34951, Kepri', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(6, 'Galang Thamrin M.M.', '0519 5066 6625', NULL, 'Jln. B.Agam Dlm No. 709, Lhokseumawe 76829, Sumut', NULL, '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(7, 'Irwan Hartana Damanik S.Sos', '0611 8382 8767', NULL, 'Kpg. Kartini No. 951, Sawahlunto 94605, Lampung', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(8, 'Jelita Malika Uyainah', '0379 0932 1428', NULL, 'Jr. Merdeka No. 686, Banjarbaru 43274, Gorontalo', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(9, 'Ulya Winda Sudiati S.Pd', '0442 3763 2162', NULL, 'Jln. Wora Wari No. 743, Lubuklinggau 14692, Kaltim', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(10, 'Wasis Latupono S.H.', '(+62) 734 4049 7540', NULL, 'Jr. Baranangsiang No. 883, Palu 68767, Sulut', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(11, 'Saadat Hakim', '(+62) 706 4014 2179', NULL, 'Gg. Bagonwoto  No. 872, Kendari 10488, Kepri', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(12, 'Maida Hasanah', '0467 8069 109', NULL, 'Ds. Gambang No. 428, Tanjungbalai 76167, Banten', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(13, 'Galak Ramadan S.E.I', '(+62) 907 0196 133', NULL, 'Kpg. Yohanes No. 675, Tangerang 39548, Gorontalo', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(14, 'Prasetya Pradipta', '(+62) 882 307 822', NULL, 'Psr. Yohanes No. 468, Balikpapan 91634, Lampung', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(15, 'Kardi Tarihoran S.IP', '0562 6216 006', NULL, 'Ki. Banceng Pondok No. 757, Bau-Bau 52330, Jambi', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(16, 'Ade Nuraini', '(+62) 520 5647 1132', NULL, 'Dk. Sudiarto No. 223, Jambi 22660, Riau', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(17, 'Uli Mandasari', '0764 0163 6917', NULL, 'Dk. Halim No. 36, Banjarbaru 37987, Sumsel', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(18, 'Kurnia Pradipta', '(+62) 333 1108 008', NULL, 'Dk. Bambon No. 59, Pariaman 81539, Maluku', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(19, 'Kayla Sadina Padmasari', '0888 414 545', NULL, 'Ki. Otista No. 45, Administrasi Jakarta Timur 85562, Kepri', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(20, 'Siska Zulaika', '0820 6967 1828', NULL, 'Dk. Bass No. 785, Binjai 61552, Jateng', NULL, '2025-12-16 22:48:45', '2025-12-16 22:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_10_10_065153_create_users_table', 1),
(4, '2025_10_10_070257_create_sessions_table', 1),
(5, '2025_10_14_153912_create_services_table', 1),
(6, '2025_10_14_153912_create_staff_table', 1),
(7, '2025_10_14_153913_create_meds_table', 1),
(8, '2025_10_14_153913_create_transactions_table', 1),
(9, '2025_11_27_000001_add_weight_dec_to_transactions_table', 1),
(10, '2025_11_28_180543_create_customers_table', 1),
(11, '2025_11_28_180555_add_customer_id_to_transactions_table', 1),
(12, '2025_11_28_180600_create_stock_movements_table', 1),
(13, '2025_11_29_000001_sync_database_schema', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `stock`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Detergen Cair (Liter)', 50, 15000.00, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(2, 'Parfum Laundry (Liter)', 30, 25000.00, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(3, 'Plastik Packing (Pack)', 100, 10000.00, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(4, 'Hanger Kawat (Lusin)', 40, 12000.00, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(5, 'Pemutih Pakaian (Botol)', 60, 8000.00, '2025-12-16 22:48:45', '2025-12-16 22:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `available`, `created_at`, `updated_at`) VALUES
(1, 'Cuci Komplit (Reguler)', 6000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(2, 'Cuci Komplit (Express)', 10000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(3, 'Cuci Kering Saja', 4000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(4, 'Setrika Saja', 4000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(5, 'Cuci Bedcover (Kecil)', 15000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(6, 'Cuci Bedcover (Besar)', 25000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(7, 'Cuci Selimut', 12000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(8, 'Cuci Sprei', 8000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(9, 'Cuci Karpet (per m²)', 15000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(10, 'Cuci Gordyn (per m²)', 12000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(11, 'Cuci Jas / Blazer', 20000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(12, 'Cuci Gaun / Dress', 25000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(13, 'Cuci Kebaya', 30000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(14, 'Cuci Jaket Kulit', 35000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(15, 'Cuci Sepatu', 25000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(16, 'Cuci Tas', 30000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(17, 'Cuci Boneka (Kecil)', 15000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45'),
(18, 'Cuci Boneka (Besar)', 30000.00, 1, '2025-12-16 22:48:45', '2025-12-16 22:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE IF NOT EXISTS `staffs` (
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE IF NOT EXISTS `stock_movements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('in','out','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'out',
  `quantity` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_id_foreign` (`product_id`),
  KEY `stock_movements_transaction_id_foreign` (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at_manual` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `age` int DEFAULT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int NOT NULL DEFAULT '1',
  `weight_dec` decimal(8,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('PAID','UNPAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `scheduled_date` date DEFAULT NULL,
  `scheduled_time` time DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'NEW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_ref_no_index` (`ref_no`),
  KEY `transactions_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `ref_no`, `channel`, `created_at_manual`, `created_by`, `client_name`, `customer_id`, `age`, `occupation`, `sex`, `product_type`, `product_id`, `product_name`, `weight`, `weight_dec`, `price`, `payment_status`, `scheduled_date`, `scheduled_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TX-NN3IUNOV', 'web', '2025-11-26 21:36:52', 'admin', 'Siska Zulaika', 20, NULL, NULL, NULL, 'service', 18, 'Cuci Boneka (Besar)', 2, 1.60, 30000.00, 'UNPAID', '2025-11-27', '04:36:00', 'PROCESS', '2025-11-26 21:36:52', '2025-11-26 21:36:52'),
(2, 'TX-NN3IUNOV', 'web', '2025-11-26 21:36:52', 'admin', 'Siska Zulaika', 20, NULL, NULL, NULL, 'service', 15, 'Cuci Sepatu', 7, 7.30, 25000.00, 'UNPAID', '2025-11-27', '04:36:00', 'PROCESS', '2025-11-26 21:36:52', '2025-11-26 21:36:52'),
(3, 'TX-RBJEJTOL', 'web', '2025-11-23 04:40:26', 'admin', 'Wardaya Cawisadi Jailani', 2, NULL, NULL, NULL, 'service', 11, 'Cuci Jas / Blazer', 9, 8.50, 20000.00, 'PAID', '2025-11-23', '11:40:00', 'CANCELLED', '2025-11-23 04:40:26', '2025-11-23 04:40:26'),
(4, 'TX-JS9IEWO3', 'web', '2025-12-11 13:38:50', 'admin', 'Ade Nuraini', 16, NULL, NULL, NULL, 'service', 9, 'Cuci Karpet (per m²)', 6, 5.50, 15000.00, 'UNPAID', '2025-12-11', '20:38:00', 'COMPLETED', '2025-12-11 13:38:50', '2025-12-11 13:38:50'),
(5, 'TX-GR58VULR', 'web', '2025-12-04 14:50:07', 'admin', 'Siska Zulaika', 20, NULL, NULL, NULL, 'service', 16, 'Cuci Tas', 8, 7.60, 30000.00, 'PAID', '2025-12-04', '21:50:00', 'COMPLETED', '2025-12-04 14:50:07', '2025-12-04 14:50:07'),
(6, 'TX-QVOCIPWA', 'web', '2025-12-14 05:43:22', 'admin', 'Maida Hasanah', 12, NULL, NULL, NULL, 'service', 4, 'Setrika Saja', 5, 4.60, 4000.00, 'UNPAID', '2025-12-14', '12:43:00', 'CANCELLED', '2025-12-14 05:43:22', '2025-12-14 05:43:22'),
(7, 'TX-XZSTFHHL', 'web', '2025-11-24 12:11:08', 'admin', 'Saadat Hakim', 11, NULL, NULL, NULL, 'service', 9, 'Cuci Karpet (per m²)', 10, 9.50, 15000.00, 'UNPAID', '2025-11-24', '19:11:00', 'CANCELLED', '2025-11-24 12:11:08', '2025-11-24 12:11:08'),
(8, 'TX-XZSTFHHL', 'web', '2025-11-24 12:11:08', 'admin', 'Saadat Hakim', 11, NULL, NULL, NULL, 'service', 17, 'Cuci Boneka (Kecil)', 8, 8.30, 15000.00, 'UNPAID', '2025-11-24', '19:11:00', 'CANCELLED', '2025-11-24 12:11:08', '2025-11-24 12:11:08'),
(9, 'TX-DDEJAMAS', 'web', '2025-12-05 16:05:04', 'admin', 'Kiandra Purnawati', 5, NULL, NULL, NULL, 'service', 18, 'Cuci Boneka (Besar)', 9, 9.40, 30000.00, 'PAID', '2025-12-05', '23:05:00', 'PROCESS', '2025-12-05 16:05:04', '2025-12-05 16:05:04'),
(10, 'TX-3WM0TC6Y', 'web', '2025-11-19 02:25:28', 'admin', 'Kiandra Purnawati', 5, NULL, NULL, NULL, 'service', 1, 'Cuci Komplit (Reguler)', 3, 2.90, 6000.00, 'UNPAID', '2025-11-19', '09:25:00', 'PROCESS', '2025-11-19 02:25:28', '2025-11-19 02:25:28'),
(11, 'TX-3WM0TC6Y', 'web', '2025-11-19 02:25:28', 'admin', 'Kiandra Purnawati', 5, NULL, NULL, NULL, 'service', 4, 'Setrika Saja', 5, 5.10, 4000.00, 'UNPAID', '2025-11-19', '09:25:00', 'PROCESS', '2025-11-19 02:25:28', '2025-11-19 02:25:28'),
(12, 'TX-MVG1OONO', 'web', '2025-11-20 18:40:41', 'admin', 'Kasim Marpaung S.E.', 1, NULL, NULL, NULL, 'service', 14, 'Cuci Jaket Kulit', 4, 4.30, 35000.00, 'PAID', '2025-11-21', '01:40:00', 'CANCELLED', '2025-11-20 18:40:41', '2025-11-20 18:40:41'),
(13, 'TX-3SG0BA9T', 'web', '2025-11-23 02:18:34', 'admin', 'Irwan Hartana Damanik S.Sos', 7, NULL, NULL, NULL, 'service', 17, 'Cuci Boneka (Kecil)', 6, 5.50, 15000.00, 'PAID', '2025-11-23', '09:18:00', 'COMPLETED', '2025-11-23 02:18:34', '2025-11-23 02:18:34'),
(14, 'TX-UL6J1GDP', 'web', '2025-11-29 19:46:18', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 18, 'Cuci Boneka (Besar)', 7, 6.90, 30000.00, 'UNPAID', '2025-11-30', '02:46:00', 'COMPLETED', '2025-11-29 19:46:18', '2025-11-29 19:46:18'),
(15, 'TX-UL6J1GDP', 'web', '2025-11-29 19:46:18', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 12, 'Cuci Gaun / Dress', 2, 2.20, 25000.00, 'UNPAID', '2025-11-30', '02:46:00', 'COMPLETED', '2025-11-29 19:46:18', '2025-11-29 19:46:18'),
(16, 'TX-8J69C4CJ', 'web', '2025-12-03 18:14:29', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 16, 'Cuci Tas', 2, 1.60, 30000.00, 'PAID', '2025-12-04', '01:14:00', 'PROCESS', '2025-12-03 18:14:29', '2025-12-03 18:14:29'),
(17, 'TX-8J69C4CJ', 'web', '2025-12-03 18:14:29', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 12, 'Cuci Gaun / Dress', 6, 6.40, 25000.00, 'PAID', '2025-12-04', '01:14:00', 'PROCESS', '2025-12-03 18:14:29', '2025-12-03 18:14:29'),
(18, 'TX-8J69C4CJ', 'web', '2025-12-03 18:14:29', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 12, 'Cuci Gaun / Dress', 9, 9.10, 25000.00, 'PAID', '2025-12-04', '01:14:00', 'PROCESS', '2025-12-03 18:14:29', '2025-12-03 18:14:29'),
(19, 'TX-5T7J35M7', 'web', '2025-12-15 16:00:06', 'admin', 'Kasim Marpaung S.E.', 1, NULL, NULL, NULL, 'service', 13, 'Cuci Kebaya', 3, 2.80, 30000.00, 'UNPAID', '2025-12-15', '23:00:00', 'COMPLETED', '2025-12-15 16:00:06', '2025-12-15 16:00:06'),
(20, 'TX-U2MVTVOS', 'web', '2025-12-11 13:22:07', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 11, 'Cuci Jas / Blazer', 6, 6.40, 20000.00, 'UNPAID', '2025-12-11', '20:22:00', 'PROCESS', '2025-12-11 13:22:07', '2025-12-11 13:22:07'),
(21, 'TX-U2MVTVOS', 'web', '2025-12-11 13:22:07', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 6, 'Cuci Bedcover (Besar)', 6, 6.10, 25000.00, 'UNPAID', '2025-12-11', '20:22:00', 'PROCESS', '2025-12-11 13:22:07', '2025-12-11 13:22:07'),
(22, 'TX-U2MVTVOS', 'web', '2025-12-11 13:22:07', 'admin', 'Galang Thamrin M.M.', 6, NULL, NULL, NULL, 'service', 5, 'Cuci Bedcover (Kecil)', 2, 2.20, 15000.00, 'UNPAID', '2025-12-11', '20:22:00', 'PROCESS', '2025-12-11 13:22:07', '2025-12-11 13:22:07'),
(23, 'TX-TNR9UPWX', 'web', '2025-12-05 18:12:43', 'admin', 'Ulya Winda Sudiati S.Pd', 9, NULL, NULL, NULL, 'service', 1, 'Cuci Komplit (Reguler)', 5, 4.90, 6000.00, 'PAID', '2025-12-06', '01:12:00', 'CANCELLED', '2025-12-05 18:12:43', '2025-12-05 18:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin', '$2y$12$EU1huLtMPyg8u5xufbovluMfuznecgD6EmQVe0IRq29vqEqrzDrKG', 'admin', '2025-12-16 22:48:44', '2025-12-16 22:48:44'),
(2, 'Staff Kasir', 'staff', '$2y$12$HFxwYYzd7v3cmYqv7lymoOHErdl1WvLh/XlUGS4VUoYB8bSrM/zMi', 'user', '2025-12-16 22:48:44', '2025-12-16 22:48:44');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
