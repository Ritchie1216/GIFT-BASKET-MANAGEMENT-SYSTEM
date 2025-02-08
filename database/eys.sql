-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 10:58 PM
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
-- Database: `eys`
--

-- --------------------------------------------------------

--
-- Table structure for table `gift_baskets`
--

CREATE TABLE `gift_baskets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_in` text NOT NULL,
  `reserve` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gift_baskets`
--

INSERT INTO `gift_baskets` (`id`, `name`, `price`, `quantity`, `image_path`, `created_at`, `stock_in`, `reserve`) VALUES
(12, 'cbha', 4999.00, 45, 'uploads/eysmy_955616000438_600x600.jpg', '2024-10-24 08:15:19', 'CSGN', 8),
(14, 'i', 7777.00, 57, 'uploads/eysmy_955616000386_300x300.jpg', '2024-10-24 14:41:50', 'dfevf', 0),
(15, 'cdccc', 8888.00, 55470, 'uploads/eysmy_955616000389_300x300.jpg', '2024-10-24 14:47:29', 'csca', 80),
(16, 'v', 44.00, 4532, 'uploads/eysmy_955616002312_300x300.jpg', '2024-10-24 14:47:59', 'fefewf', 2),
(17, '发v封测得分', 1234.00, 1234, 'uploads/eysmy_955616000515_300x300.jpg', '2024-10-24 14:49:03', 'dff', 444);

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `basket_id` int(11) DEFAULT NULL,
  `stock_in_time` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `basket_id`, `stock_in_time`, `quantity`) VALUES
(7, 12, '2024-10-24 16:15:00', 56),
(8, 12, '2024-10-25 16:18:00', 66),
(9, 12, '2024-10-26 19:46:00', 2123),
(11, 14, '2024-10-24 22:44:00', 55),
(12, 12, '2024-10-26 16:24:00', 4),
(13, 12, '2024-10-27 11:05:00', 500),
(14, 12, '2024-12-17 08:41:00', 88),
(15, 12, '2024-12-26 11:38:00', 33),
(16, 12, '2025-01-22 11:30:00', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gift_baskets`
--
ALTER TABLE `gift_baskets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_in_ibfk_1` (`basket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gift_baskets`
--
ALTER TABLE `gift_baskets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD CONSTRAINT `stock_in_ibfk_1` FOREIGN KEY (`basket_id`) REFERENCES `gift_baskets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
