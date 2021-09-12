-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2021 at 01:17 AM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sin` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hire_date` date NOT NULL,
  `termination_date` date DEFAULT NULL,
  `pay_rate` decimal(8,2) UNSIGNED NOT NULL,
  `ei_exempt` tinyint(1) NOT NULL,
  `cpp_exempt` tinyint(1) NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `pay_frequency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `sin`, `name`, `address`, `hire_date`, `termination_date`, `pay_rate`, `ei_exempt`, `cpp_exempt`, `employer_id`, `pay_frequency`, `created_at`, `updated_at`) VALUES
(4, 11111113, 'full name test', 'test addrs', '2021-05-30', '3001-12-31', 10.00, 0, 0, 1, 'MONTHLY_12PP', '2021-05-27 21:49:53', '2021-06-11 12:03:39'),
(5, 777666222, 'test1 employee', '18958-74 street nw Edmonton, Ab t6u1b1', '2021-05-01', '3001-12-31', 18.00, 0, 0, 3, 'SEMI_MONTHLY', '2021-06-10 23:04:20', '2021-06-10 23:04:20'),
(6, 111111111, 'Jason James', '1288 Central Street Edmonton, AB T5C2K1', '2021-01-01', '3001-12-31', 25.00, 0, 0, 4, 'MONTHLY_12PP', '2021-06-11 11:40:25', '2021-06-11 11:40:25'),
(7, 570876953, 'Muhammad Saud Yousuf', '16747 111 Street NW, Edmonton, AB, T5X 2R3', '2021-01-01', '3001-12-31', 18.00, 0, 0, 5, 'BI_WEEKLY', '2021-06-22 04:58:35', '2021-06-22 04:58:35'),
(8, 99999999, 'Saud', '12720-148 AVE NW', '2020-01-01', '3001-12-31', 18.00, 0, 0, 2, 'SEMI_MONTHLY', '2021-06-24 01:33:22', '2021-06-24 01:33:22'),
(9, 651579732, 'mohammed tarbine', '10710 173A AVE NW', '2021-06-01', '3001-12-31', 18.00, 1, 0, 6, 'BI_WEEKLY', '2021-06-24 06:37:47', '2021-06-24 06:37:47'),
(11, 688002120, 'My Tin Nguyen', '8515 83 Street', '2021-06-11', '3001-12-31', 16.00, 0, 0, 7, 'MONTHLY_12PP', '2021-07-01 13:07:57', '2021-07-02 22:15:08'),
(12, 948885751, 'Ai Lan Vy Pham', '15828 69 Street', '2021-06-09', '3001-12-31', 15.00, 0, 0, 7, 'MONTHLY_12PP', '2021-07-01 13:14:15', '2021-07-01 13:14:15'),
(13, 663557221, 'thang nguyen', '2236 71 street sw', '2021-06-01', '3001-12-31', 15.00, 0, 0, 7, 'MONTHLY_12PP', '2021-07-01 13:46:33', '2021-07-01 13:46:33'),
(14, 99999998, 'TEST EMPLOYEE', '15641', '2021-06-01', '2021-06-07', 15.00, 0, 0, 2, 'WEEKLY_52PP', '2021-07-02 02:51:07', '2021-07-02 03:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frequency`
--

CREATE TABLE `frequency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `frequency`
--

INSERT INTO `frequency` (`id`, `name`, `option_value`, `created_at`, `updated_at`) VALUES
(1, 'Daily (240 pay periods a year)', 'DAILY', NULL, NULL),
(2, 'Weekly (52 pay periods a year)', 'WEEKLY_52PP', NULL, NULL),
(3, 'Biweekly (26 pay periods a year)', 'BI_WEEKLY', NULL, NULL),
(4, 'Semi-monthly (24 pay periods a year)', 'SEMI_MONTHLY', NULL, NULL),
(5, 'Monthly (12 pay periods a year)', 'MONTHLY_12PP', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE `hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `work_date` date NOT NULL,
  `work_hours` decimal(13,5) NOT NULL,
  `is_state_holiday` tinyint(1) NOT NULL,
  `is_over_time` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id`, `employee_id`, `employer_id`, `work_date`, `work_hours`, `is_state_holiday`, `is_over_time`, `created_at`, `updated_at`) VALUES
(7, 5, 3, '2021-05-15', 80.00000, 0, 0, '2021-06-10 23:04:50', '2021-06-10 23:04:50'),
(8, 5, 3, '2021-05-14', 8.00000, 0, 0, '2021-06-10 23:05:58', '2021-06-10 23:05:58'),
(9, 5, 3, '2021-06-10', 80.00000, 0, 0, '2021-06-10 23:18:28', '2021-06-10 23:18:28'),
(10, 6, 4, '2021-01-31', 80.00000, 0, 0, '2021-06-11 11:41:55', '2021-06-11 11:41:55'),
(12, 6, 4, '2021-02-28', 80.00000, 0, 0, '2021-06-11 11:47:46', '2021-06-11 11:47:46'),
(14, 4, 1, '2021-05-31', 160.00000, 0, 0, '2021-06-12 00:47:49', '2021-06-12 00:47:49'),
(15, 7, 5, '2021-06-16', 55.00000, 0, 0, '2021-06-22 04:59:25', '2021-06-22 04:59:25'),
(16, 8, 2, '2021-01-15', 80.00000, 0, 0, '2021-06-24 01:34:06', '2021-06-24 01:34:06'),
(19, 11, 7, '2021-06-30', 28.00000, 0, 0, '2021-07-01 13:11:26', '2021-07-01 13:11:26'),
(20, 12, 7, '2021-06-30', 37.00000, 0, 0, '2021-07-01 13:14:42', '2021-07-01 13:14:42'),
(21, 14, 2, '2021-06-16', 35.00000, 0, 0, '2021-07-02 02:51:50', '2021-07-02 02:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(45, '2014_10_12_000000_create_users_table', 1),
(46, '2014_10_12_100000_create_password_resets_table', 1),
(47, '2019_08_19_000000_create_failed_jobs_table', 1),
(48, '2021_05_10_105822_create_employee_table', 1),
(49, '2021_05_11_105614_create_provinces_table', 1),
(50, '2021_05_12_095429_create_hours_table', 1),
(51, '2021_05_13_133433_create_paystubs_table', 1),
(52, '2021_05_14_110228_create_frequency_table', 1),
(53, '2021_05_18_130004_create_settings_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paystubs`
--

CREATE TABLE `paystubs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `paid_date` date NOT NULL,
  `hourly_qty` decimal(13,5) NOT NULL,
  `hourly_rate` decimal(13,5) NOT NULL,
  `stat_qty` decimal(13,5) NOT NULL,
  `stat_rate` decimal(13,5) NOT NULL,
  `vac_pay` decimal(13,5) NOT NULL,
  `overtime_qty` decimal(13,5) NOT NULL,
  `overtime_rate` decimal(13,5) NOT NULL,
  `cpp` decimal(13,5) NOT NULL,
  `ei` decimal(13,5) NOT NULL,
  `federal_tax` decimal(13,5) NOT NULL,
  `net_pay` decimal(13,5) NOT NULL,
  `pay_frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `employer_cpp` decimal(13,5) NOT NULL,
  `employer_ei` decimal(13,5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paystubs`
--

INSERT INTO `paystubs` (`id`, `employee_id`, `employer_id`, `paid_date`, `hourly_qty`, `hourly_rate`, `stat_qty`, `stat_rate`, `vac_pay`, `overtime_qty`, `overtime_rate`, `cpp`, `ei`, `federal_tax`, `net_pay`, `pay_frequency`, `employer_cpp`, `employer_ei`, `created_at`, `updated_at`) VALUES
(8, 5, 3, '2021-05-15', 88.00000, 18.00000, 0.00000, 27.00000, 63.36000, 0.00000, 36.00000, 81.83000, 26.03000, 136.77000, 1428.76000, 'SEMI_MONTHLY', 81.83000, 36.44000, '2021-06-10 23:06:48', '2021-06-10 23:06:48'),
(9, 5, 3, '2021-06-10', 80.00000, 18.00000, 0.00000, 27.00000, 57.60000, 0.00000, 36.00000, 18.17000, 23.75000, 116.69000, 1357.16000, 'SEMI_MONTHLY', 73.99000, 33.25000, '2021-06-10 23:18:54', '2021-06-10 23:18:54'),
(11, 6, 4, '2021-01-31', 80.00000, 25.00000, 0.00000, 37.50000, 100.00000, 0.00000, 50.00000, 98.55000, 33.18000, 106.93000, 1894.52000, 'MONTHLY_12PP', 98.55000, 46.45000, '2021-06-11 11:42:49', '2021-06-11 11:42:49'),
(12, 6, 4, '2021-02-28', 160.00000, 25.00000, 0.00000, 37.50000, 200.00000, 0.00000, 50.00000, 1.45000, 66.36000, 406.12000, 3727.52000, 'MONTHLY_12PP', 213.00000, 92.90000, '2021-06-11 11:48:10', '2021-06-11 11:48:10'),
(13, 7, 5, '2021-06-16', 55.00000, 18.00000, 0.00000, 27.00000, 49.50000, 0.00000, 36.00000, 46.62000, 15.64000, 70.53000, 922.35000, 'BI_WEEKLY', 46.62000, 21.90000, '2021-06-22 04:59:59', '2021-06-22 04:59:59'),
(15, 11, 7, '2021-06-30', 28.00000, 16.00000, 0.00000, 24.00000, 22.40000, 0.00000, 32.00000, 8.52000, 7.08000, 0.00000, 461.88000, 'MONTHLY_12PP', 8.52000, 9.91000, '2021-07-01 13:21:52', '2021-07-01 13:21:52'),
(16, 12, 7, '2021-06-30', 37.00000, 15.00000, 0.00000, 22.50000, 27.75000, 0.00000, 30.00000, 15.86000, 9.21000, 0.00000, 566.89000, 'MONTHLY_12PP', 15.86000, 12.89000, '2021-07-01 13:22:25', '2021-07-01 13:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Alberta', NULL, NULL),
(2, 'British Columbia', NULL, NULL),
(3, 'Manitoba', NULL, NULL),
(4, 'New Brunswick', NULL, NULL),
(5, 'Newfoundland and Labrador', NULL, NULL),
(6, 'Northwest Territories', NULL, NULL),
(7, 'Nova Scotia', NULL, NULL),
(8, 'Nunavut', NULL, NULL),
(9, 'Ontario', NULL, NULL),
(10, 'Prince Edward Island', NULL, NULL),
(11, 'Quebec', NULL, NULL),
(12, 'Saskatchewan', NULL, NULL),
(13, 'Yukon', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stat_amount` decimal(8,2) NOT NULL,
  `overtime_amount` decimal(8,2) NOT NULL,
  `max_cpp` decimal(8,2) NOT NULL,
  `max_ei` decimal(8,2) NOT NULL,
  `vacation_pay_percentage` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `stat_amount`, `overtime_amount`, `max_cpp`, `max_ei`, `vacation_pay_percentage`, `created_at`, `updated_at`) VALUES
(1, 1.50, 2.00, 100.00, 100.00, 5.00, '2021-05-18 12:00:24', '2021-06-11 02:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pbn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `address`, `pbn`, `province_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'employer test', 'kassab3m@gmail.com', NULL, '$2y$10$WDqWjA4jpZOr81ewpSl5Puzem.appnWwjWzmy1W4RADturUKNL22K', 'test addrs', '121212', 1, 'njAWa3kflLjPwZH9Fi8BqoNTJVit6TeFxQw9SFu2mGWRWp9rRdvSEW9BCOAb', '2021-05-21 17:04:39', '2021-06-12 02:35:32'),
(2, 'Imran', 'incometax786@gmail.com', NULL, '$2y$10$3KHfYiOwg/nDs2/93E4IY.mwf5LTW7Czjs8H70jhGySFurjmAFCzi', 'incometax786@gmail.com', '123456789', 1, NULL, '2021-05-25 03:45:40', '2021-05-25 03:45:40'),
(3, 'test account', 'rahan7799@yahoo.com', NULL, '$2y$10$RC16dlcoLK68GBkRcIOXquIaRYYFV9SRZFsS9p5cRJqjzaadJhuFa', '16519-55 street edmonton ab t55c1j7', '987654321', 1, NULL, '2021-06-10 23:03:02', '2021-06-10 23:03:02'),
(4, 'Ray', 'jasonjames@hotmail.com', NULL, '$2y$10$L38ygCHExPWHWDWDAwuwVe3aDwRWLGWbKDvBgzUA1osN37PzTx4iW', '12345 Main Street Edmonton, AB T5X 5L2', '123456789', 1, NULL, '2021-06-11 11:39:23', '2021-06-11 11:39:23'),
(5, 'Global Tax Corporation', 'globaltaxassociate@gmail.com', NULL, '$2y$10$Q/wHlxd3zWmm36H03RTYmO5Z/wNSiQm.IQs/2TgfyUJWO7fUAWxTK', '205 - 12906 54 Street NW, Edmonton, AB, T5A 5A8', '815121975RP0001', 1, NULL, '2021-06-22 04:57:46', '2021-06-22 04:57:46'),
(6, 'mohammed tarbine', 'tarrabain@gmail.com', NULL, '$2y$10$x9Eb7MdIQbH8s3LEqKvDMuBwg0BIKslyRhigbskMTk6SnazctxfhO', '10710 173A AVE NW', '820350006', 1, NULL, '2021-06-24 06:36:17', '2021-06-24 06:36:17'),
(7, 'Banh Mi Zon Ltd.', 'info@banhmizon.ca', NULL, '$2y$10$AO2q89n9t8f5.Yp4kppJ0eWlx2/ru58YJwqfqQHHBG4njmF1vI34G', '#4 140 Athabascan avenue, sherwood park, Alberta', '3', 1, NULL, '2021-07-01 12:59:41', '2021-07-01 13:20:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_sin_unique` (`sin`),
  ADD KEY `employees_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frequency`
--
ALTER TABLE `frequency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hours_employee_id_foreign` (`employee_id`),
  ADD KEY `hours_employer_id_foreign` (`employer_id`);

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
-- Indexes for table `paystubs`
--
ALTER TABLE `paystubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paystubs_employee_id_foreign` (`employee_id`),
  ADD KEY `paystubs_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provinces_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frequency`
--
ALTER TABLE `frequency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `paystubs`
--
ALTER TABLE `paystubs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hours`
--
ALTER TABLE `hours`
  ADD CONSTRAINT `hours_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `hours_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `paystubs`
--
ALTER TABLE `paystubs`
  ADD CONSTRAINT `paystubs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `paystubs_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
