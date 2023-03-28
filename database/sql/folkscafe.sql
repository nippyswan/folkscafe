-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2019 at 01:25 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `folkscafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cin_list`
--

DROP TABLE IF EXISTS `cin_list`;
CREATE TABLE IF NOT EXISTS `cin_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cin_others`
--

DROP TABLE IF EXISTS `cin_others`;
CREATE TABLE IF NOT EXISTS `cin_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cin_others` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cout_list`
--

DROP TABLE IF EXISTS `cout_list`;
CREATE TABLE IF NOT EXISTS `cout_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cout_others`
--

DROP TABLE IF EXISTS `cout_others`;
CREATE TABLE IF NOT EXISTS `cout_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cout_others` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cu_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

DROP TABLE IF EXISTS `investments`;
CREATE TABLE IF NOT EXISTS `investments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `investments` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investor`
--

DROP TABLE IF EXISTS `investor`;
CREATE TABLE IF NOT EXISTS `investor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_id` int(11) DEFAULT NULL,
  `f_cat` int(11) NOT NULL,
  `sp` int(11) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imgurl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `f_id` (`f_id`),
  KEY `menu_ibfk_2` (`f_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders_cancellation`
--

DROP TABLE IF EXISTS `orders_cancellation`;
CREATE TABLE IF NOT EXISTS `orders_cancellation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `o_qty` int(11) DEFAULT NULL,
  `n_qty` int(11) DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_no` (`table_no`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_changed`
--

DROP TABLE IF EXISTS `orders_changed`;
CREATE TABLE IF NOT EXISTS `orders_changed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_no` (`table_no`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_confirmed`
--

DROP TABLE IF EXISTS `orders_confirmed`;
CREATE TABLE IF NOT EXISTS `orders_confirmed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_no` (`table_no`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

DROP TABLE IF EXISTS `orders_pending`;
CREATE TABLE IF NOT EXISTS `orders_pending` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`),
  KEY `orders_pending_ibfk_3` (`table_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_prepared`
--

DROP TABLE IF EXISTS `orders_prepared`;
CREATE TABLE IF NOT EXISTS `orders_prepared` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_no` (`table_no`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_served`
--

DROP TABLE IF EXISTS `orders_served`;
CREATE TABLE IF NOT EXISTS `orders_served` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_no` (`table_no`),
  KEY `f_id` (`f_id`),
  KEY `by_user` (`by_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nippyanoj@gmail.com', '$2y$10$awiwYxvOzM2.IQPeUyQbDutBfTXkY/VtJZ4NHR1DaQA7hesfVF8Cq', '2019-10-04 09:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `payoff`
--

DROP TABLE IF EXISTS `payoff`;
CREATE TABLE IF NOT EXISTS `payoff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cu_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_cin_others`
--

DROP TABLE IF EXISTS `r_cin_others`;
CREATE TABLE IF NOT EXISTS `r_cin_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_cout_others`
--

DROP TABLE IF EXISTS `r_cout_others`;
CREATE TABLE IF NOT EXISTS `r_cout_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_ingredients`
--

DROP TABLE IF EXISTS `r_ingredients`;
CREATE TABLE IF NOT EXISTS `r_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cu_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_investments`
--

DROP TABLE IF EXISTS `r_investments`;
CREATE TABLE IF NOT EXISTS `r_investments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_payoff`
--

DROP TABLE IF EXISTS `r_payoff`;
CREATE TABLE IF NOT EXISTS `r_payoff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_products`
--

DROP TABLE IF EXISTS `r_products`;
CREATE TABLE IF NOT EXISTS `r_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cu_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_salary`
--

DROP TABLE IF EXISTS `r_salary`;
CREATE TABLE IF NOT EXISTS `r_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salary` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `r_sales`
--

DROP TABLE IF EXISTS `r_sales`;
CREATE TABLE IF NOT EXISTS `r_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `table_no` int(11) DEFAULT NULL,
  `billno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`),
  KEY `r_sales_tb` (`table_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
CREATE TABLE IF NOT EXISTS `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `amt` int(11) DEFAULT NULL,
  `cu_amt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salary` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `table_no` int(11) DEFAULT NULL,
  `billno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`),
  KEY `sales_tb` (`table_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tablelist`
--

DROP TABLE IF EXISTS `tablelist`;
CREATE TABLE IF NOT EXISTS `tablelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_no` (`table_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unit_name` (`unit_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `type`, `password`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'anoj', 'nippyanoj@gmail.com', NULL, 'Manager', '$2y$10$S6IHLO8Lt13zsnxBmREdf.i8Eb9iXq1ZJiX8CE86oh53GP6pHXKfK', NULL, '2019-10-02 11:53:20', '2019-10-02 11:53:20', 1),
(2, 'ramesh', 'ramesh@gmail.com', NULL, 'Waiter', '$2y$10$pbHpOhhi6zZvFFbolsnYjeiEnv4onk5KbUXETyBpiFsN3ctzTBS16', NULL, '2019-10-02 12:35:23', '2019-10-02 12:35:23', 1),
(3, 'shyamey', 'shyamey@gmail.com', NULL, 'Chef', '$2y$10$2Ey7l.1XfIcJj0JWCL/KSePdwanrpdQvDkKgXQNm11l1hziTLg53.', NULL, '2019-10-02 12:39:16', '2019-10-02 12:39:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wastage`
--

DROP TABLE IF EXISTS `wastage`;
CREATE TABLE IF NOT EXISTS `wastage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `avg_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `f_id` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cin_others`
--
ALTER TABLE `cin_others`
  ADD CONSTRAINT `cin_others` FOREIGN KEY (`f_id`) REFERENCES `cin_list` (`id`);

--
-- Constraints for table `cout_others`
--
ALTER TABLE `cout_others`
  ADD CONSTRAINT `cout_others` FOREIGN KEY (`f_id`) REFERENCES `cout_list` (`id`);

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments` FOREIGN KEY (`f_id`) REFERENCES `investor` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`f_cat`) REFERENCES `category` (`id`);

--
-- Constraints for table `orders_cancellation`
--
ALTER TABLE `orders_cancellation`
  ADD CONSTRAINT `orders_cancellation_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`),
  ADD CONSTRAINT `orders_cancellation_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_cancellation_ibfk_3` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_changed`
--
ALTER TABLE `orders_changed`
  ADD CONSTRAINT `orders_changed_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`),
  ADD CONSTRAINT `orders_changed_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_changed_ibfk_3` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_confirmed`
--
ALTER TABLE `orders_confirmed`
  ADD CONSTRAINT `orders_confirmed_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`),
  ADD CONSTRAINT `orders_confirmed_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_confirmed_ibfk_3` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD CONSTRAINT `orders_pending_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_pending_ibfk_2` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_pending_ibfk_3` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`);

--
-- Constraints for table `orders_prepared`
--
ALTER TABLE `orders_prepared`
  ADD CONSTRAINT `orders_prepared_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`),
  ADD CONSTRAINT `orders_prepared_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_prepared_ibfk_3` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_served`
--
ALTER TABLE `orders_served`
  ADD CONSTRAINT `orders_served_ibfk_1` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`),
  ADD CONSTRAINT `orders_served_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `orders_served_ibfk_3` FOREIGN KEY (`by_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `payoff`
--
ALTER TABLE `payoff`
  ADD CONSTRAINT `payoff` FOREIGN KEY (`f_id`) REFERENCES `investor` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `r_cin_others`
--
ALTER TABLE `r_cin_others`
  ADD CONSTRAINT `r_cin_others` FOREIGN KEY (`f_id`) REFERENCES `cin_list` (`id`);

--
-- Constraints for table `r_cout_others`
--
ALTER TABLE `r_cout_others`
  ADD CONSTRAINT `r_cout_others` FOREIGN KEY (`f_id`) REFERENCES `cout_list` (`id`);

--
-- Constraints for table `r_ingredients`
--
ALTER TABLE `r_ingredients`
  ADD CONSTRAINT `r_ingredients` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `r_investments`
--
ALTER TABLE `r_investments`
  ADD CONSTRAINT `r_investments` FOREIGN KEY (`f_id`) REFERENCES `investor` (`id`);

--
-- Constraints for table `r_payoff`
--
ALTER TABLE `r_payoff`
  ADD CONSTRAINT `r_payoff` FOREIGN KEY (`f_id`) REFERENCES `investor` (`id`);

--
-- Constraints for table `r_products`
--
ALTER TABLE `r_products`
  ADD CONSTRAINT `r_products` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`);

--
-- Constraints for table `r_salary`
--
ALTER TABLE `r_salary`
  ADD CONSTRAINT `r_salary` FOREIGN KEY (`f_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `r_sales`
--
ALTER TABLE `r_sales`
  ADD CONSTRAINT `r_sales` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `r_sales_tb` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary` FOREIGN KEY (`f_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `sales_tb` FOREIGN KEY (`table_no`) REFERENCES `tablelist` (`table_no`);

--
-- Constraints for table `wastage`
--
ALTER TABLE `wastage`
  ADD CONSTRAINT `wastage_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
