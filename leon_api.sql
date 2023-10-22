-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2023 at 09:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leon_api`
--
CREATE DATABASE IF NOT EXISTS `leon_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `leon_api`;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `is_used`) VALUES
(1, 'beccf567798ae4a87d58eec7a3d22bcc', 0),
(2, '9d907d6f5739551828a8da712c0edc63', 0),
(3, '5f3b9a77737046d2616ae3b7640282d2', 0),
(4, '1b3c583701d4911fcc71f29c17729044', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_number` varchar(255) NOT NULL,
  `voucher_provider` enum('foo','bar') NOT NULL,
  `voucher_amount` decimal(10,2) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_number`, `voucher_provider`, `voucher_amount`, `expires_at`, `is_used`) VALUES
(1, '12345', 'foo', 10.00, '2023-12-31 23:59:59', 0),
(2, '67890', 'foo', 20.00, '2023-12-31 23:59:59', 0),
(3, '54321', 'bar', 10.00, '2023-12-31 23:59:59', 0),
(4, '09876', 'bar', 20.00, '2022-01-01 00:00:00', 0),
(5, '123123', 'bar', 20.00, '2022-01-02 00:00:00', 0),
(6, '321321', 'foo', 10.00, '2023-12-10 23:59:59', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
