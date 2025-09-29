-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2025 at 07:53 PM
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
-- Database: `flat_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flat_id` bigint(20) UNSIGNED NOT NULL,
  `house_owner_id` bigint(20) UNSIGNED NOT NULL,
  `bill_category_id` bigint(20) UNSIGNED NOT NULL,
  `month` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `flat_id`, `house_owner_id`, `bill_category_id`, `month`, `amount`, `due_amount`, `status`, `notes`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, '2025-09-01', 600.00, 0.00, 'unpaid', 'tst', NULL, '2025-09-29 11:21:50', '2025-09-29 11:21:50'),
(2, 1, 1, 4, '2025-10-01', 130.00, 600.00, 'unpaid', 'rrrr', NULL, '2025-09-29 11:29:38', '2025-09-29 11:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `bill_categories`
--

CREATE TABLE `bill_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_owner_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_categories`
--

INSERT INTO `bill_categories` (`id`, `house_owner_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Utilities', '2025-09-29 11:05:08', '2025-09-29 11:05:08'),
(2, 1, 'Maintenance & Repairs', '2025-09-29 11:05:33', '2025-09-29 11:05:33'),
(3, 1, 'Security Services', '2025-09-29 11:05:46', '2025-09-29 11:05:46'),
(4, 1, 'Insurance & Property Tax', '2025-09-29 11:05:58', '2025-09-29 11:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE `bill_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` bigint(20) UNSIGNED NOT NULL,
  `bill_category_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_details`
--

INSERT INTO `bill_details` (`id`, `bill_id`, `bill_category_id`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 100.00, NULL, '2025-09-29 11:21:50', '2025-09-29 11:21:50'),
(2, 1, 2, 200.00, NULL, '2025-09-29 11:21:50', '2025-09-29 11:21:50'),
(3, 1, 3, 300.00, NULL, '2025-09-29 11:21:50', '2025-09-29 11:21:50'),
(4, 2, 4, 50.00, NULL, '2025-09-29 11:29:38', '2025-09-29 11:29:38'),
(5, 2, 2, 60.00, NULL, '2025-09-29 11:29:38', '2025-09-29 11:29:38'),
(6, 2, 3, 20.00, NULL, '2025-09-29 11:29:38', '2025-09-29 11:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_owner_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `house_owner_id`, `name`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test House Owner Building', 'Dhaka Bangladesh', '2025-09-29 02:39:16', '2025-09-29 02:39:16'),
(2, 2, 'Test House Owner 1 Building', 'Dhaka Bangladesh', '2025-09-29 02:39:16', '2025-09-29 02:39:16');

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
-- Table structure for table `flats`
--

CREATE TABLE `flats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `house_owner_id` bigint(20) UNSIGNED NOT NULL,
  `flat_number` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_contact` varchar(255) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `available` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`id`, `building_id`, `house_owner_id`, `flat_number`, `owner_name`, `owner_contact`, `owner_email`, `available`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Test Flat 1', 'test', '01714491616', 'testflat@gmail.com', 'no', '2025-09-29 10:05:20', '2025-09-29 10:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `house_owners`
--

CREATE TABLE `house_owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `house_owners`
--

INSERT INTO `house_owners` (`id`, `name`, `email`, `email_verified_at`, `password`, `contact`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test House Owner', 'testhouseowner@gmail.com', NULL, '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', '01714491616', NULL, '2025-09-29 02:39:16', '2025-09-29 02:39:16'),
(2, 'Test House Owner 1', 'testhouseowner11@gmail.com', NULL, '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', '01714491616', NULL, '2025-09-29 02:39:16', '2025-09-29 02:39:16');

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
(52, '0001_01_01_000000_create_users_table', 1),
(53, '0001_01_01_000001_create_cache_table', 1),
(54, '0001_01_01_000002_create_jobs_table', 1),
(55, '2025_09_28_172836_create_house_owners_table', 1),
(56, '2025_09_28_173512_create_buildings_table', 1),
(57, '2025_09_28_173638_create_flats_table', 1),
(58, '2025_09_28_173844_create_tenants_table', 1),
(59, '2025_09_28_175941_create_bill_categories_table', 1),
(60, '2025_09_28_180244_create_bills_table', 1),
(61, '2025_09_29_000001_create_bill_details_table', 1);

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
('31qgG5i9WURffCyhFQrmNqxsGjhKEDu0xOgykWmz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaEVWc1MwekcyY1Zlb1NyTkhuSm5yRmQwUkJocWlXTHBtNnpoM2tNSSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaG91c2Utb3duZXIvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1ODoibG9naW5faG91c2Vfb3duZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1759168256),
('Kl5QypNzRw8591vx2Qij2bVI9mLTf9Fc3rxtKM4H', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmNzamZuZ2kyVjdxdm9ERUVTVFZ5UHdLT3JBQ0tzbUsyc05LalJFOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759168257),
('mOhoJEoZkz4JM8GMiPguaHSdc37amrfyniou5JVS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMFQ0WFRUNnA4MEIxb2dZQTJ0dldid0lWZEZYTlR6ZkdJSnhHN28yaCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdGVuYW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1759168256);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `building_id` bigint(20) UNSIGNED NOT NULL,
  `flat_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by_admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `email`, `contact`, `building_id`, `flat_id`, `assigned_by_admin_id`, `created_at`, `updated_at`) VALUES
(2, 'test tenant', 'test@gmail.com', '017144916166', 1, 1, 1, '2025-09-29 10:33:20', '2025-09-29 10:33:20');

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test Admin', 'admin@gmail.com', NULL, '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', NULL, '2025-09-28 12:04:37', '2025-09-28 12:04:37'),
(2, 'Test Admin 2', 'admin2@gmail.com', NULL, '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', NULL, '2025-09-28 23:23:05', '2025-09-28 23:23:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_flat_id_foreign` (`flat_id`),
  ADD KEY `bills_house_owner_id_foreign` (`house_owner_id`),
  ADD KEY `bills_bill_category_id_foreign` (`bill_category_id`);

--
-- Indexes for table `bill_categories`
--
ALTER TABLE `bill_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_categories_house_owner_id_foreign` (`house_owner_id`);

--
-- Indexes for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_details_bill_id_bill_category_id_unique` (`bill_id`,`bill_category_id`),
  ADD KEY `bill_details_bill_category_id_foreign` (`bill_category_id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buildings_house_owner_id_foreign` (`house_owner_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flats`
--
ALTER TABLE `flats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flats_building_id_foreign` (`building_id`),
  ADD KEY `flats_house_owner_id_foreign` (`house_owner_id`);

--
-- Indexes for table `house_owners`
--
ALTER TABLE `house_owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `house_owners_email_unique` (`email`);

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
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`),
  ADD KEY `tenants_building_id_foreign` (`building_id`),
  ADD KEY `tenants_flat_id_foreign` (`flat_id`);

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
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bill_categories`
--
ALTER TABLE `bill_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `house_owners`
--
ALTER TABLE `house_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_bill_category_id_foreign` FOREIGN KEY (`bill_category_id`) REFERENCES `bill_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bills_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `house_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill_categories`
--
ALTER TABLE `bill_categories`
  ADD CONSTRAINT `bill_categories_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `house_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD CONSTRAINT `bill_details_bill_category_id_foreign` FOREIGN KEY (`bill_category_id`) REFERENCES `bill_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bill_details_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `house_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `flats`
--
ALTER TABLE `flats`
  ADD CONSTRAINT `flats_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flats_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `house_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tenants_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
