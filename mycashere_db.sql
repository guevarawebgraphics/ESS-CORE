-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2019 at 11:00 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mycashere_db`
--

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_02_092101_create_user_type', 1),
(4, '2019_04_02_092456_create_user_module_access', 1),
(5, '2019_04_02_092614_create_user_modules', 1);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type_id`, `name`, `username`, `email_verified_at`, `password`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin', NULL, '$2y$10$DufzSmIMNGGX1DpgKvJ/qu6Fmma.xlpxr05QZpe9d3uuXHHeeqcGK', NULL, NULL, NULL, '2019-04-03 23:40:00', '2019-04-03 23:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`id`, `module_code`, `module_name`, `module_type`, `deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'my_profile', 'My Profile', 'module', 0, NULL, NULL, NULL, NULL),
(2, 'create_profile', 'Create Profile', 'module', 0, NULL, NULL, NULL, NULL),
(3, 'manage_users', 'Manage Users', 'module', 0, NULL, NULL, NULL, NULL),
(4, 'ess_content', 'ESS Content', 'module', 0, NULL, NULL, NULL, NULL),
(5, 'send_announcement', 'Send Announcement', 'module', 0, NULL, NULL, NULL, NULL),
(6, 'manage_docs', 'Manage Documents', 'module', 0, NULL, NULL, NULL, NULL),
(7, 'employee_enrollment', 'Employee Enrollment', 'module', 0, NULL, NULL, NULL, NULL),
(8, 'payroll_management', 'Payroll Management', 'module', 0, NULL, NULL, NULL, NULL),
(9, 'employer_content', 'Employer Content', 'module', 0, NULL, NULL, NULL, NULL),
(10, 'payslips', 'Payslips', 'module', 0, NULL, NULL, NULL, NULL),
(11, 't_a', 'Time and Attendance', 'module', 0, NULL, NULL, NULL, NULL),
(12, 'icredit', 'iCredit', 'module', 0, NULL, NULL, NULL, NULL),
(13, 'cash_advance', 'Cash Advance', 'module', 0, NULL, NULL, NULL, NULL),
(14, 'e_wallet', 'Prepaid E-Wallet', 'module', 0, NULL, NULL, NULL, NULL),
(15, 'financial_calendar', 'Financial Calendar', 'module', 0, NULL, NULL, NULL, NULL),
(16, 'financial_tips', 'Financial Tips', 'module', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_module_access`
--

CREATE TABLE `user_module_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `my_profile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `create_profile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `manage_users` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `ess_content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `send_announcement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `manage_docs` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `employee_enrollment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `payroll_management` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `employer_content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `payslips` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `t_a` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `icredit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `cash_advance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `e_wallet` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `financial_calendar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `financial_tips` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `deleted` int(11) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_module_access`
--

INSERT INTO `user_module_access` (`id`, `user_type_id`, `my_profile`, `create_profile`, `manage_users`, `ess_content`, `send_announcement`, `manage_docs`, `employee_enrollment`, `payroll_management`, `employer_content`, `payslips`, `t_a`, `icredit`, `cash_advance`, `e_wallet`, `financial_calendar`, `financial_tips`, `deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'all', 'all', 'all', 'all', 'all', 'all', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 0, 'pol', 'pol', NULL, NULL),
(2, 3, 'all', 'none', 'all', 'none', 'all', 'none', 'all', 'all', 'all', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 0, 'pol', 'pol', NULL, NULL),
(3, 4, 'all', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'all', 'all', 'all', 'all', 'all', 'all', 'all', 0, 'pol', 'pol', NULL, NULL),
(4, 2, 'none', 'none', 'edit', 'delete', 'view', 'add', 'all', 'none', 'edit', 'delete', 'view', 'add', 'all', 'none', 'edit', 'delete', 0, 'pol', 'pol', NULL, NULL),
(5, 5, 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 0, 'Admin', 'Admin', '2019-04-03 23:41:50', '2019-04-03 23:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type_name`, `type_description`, `deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Admin', 0, NULL, NULL, NULL, NULL),
(2, 'CMS Default', 'CMS Default', 0, NULL, NULL, NULL, NULL),
(3, 'Employer Default', 'Employer', 0, NULL, NULL, NULL, NULL),
(4, 'Employee Default', 'Employee', 0, NULL, NULL, NULL, NULL),
(5, 'Admin 2', 'Sample admin 2', 0, 'Admin', 'Admin', '2019-04-03 23:41:50', '2019-04-03 23:41:50');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`username`);

--
-- Indexes for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_module_access`
--
ALTER TABLE `user_module_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_modules`
--
ALTER TABLE `user_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_module_access`
--
ALTER TABLE `user_module_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
