-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-01-18 07:36:09
-- 服务器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ecommerce`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `admin`, `password`) VALUES
(2, 'admin', '$2y$10$ohHBF8arDK5J9Iw1VS5iD.WIw7pgp2pTsCoz4Ukf7Iq6x6icAEny6');

-- --------------------------------------------------------

--
-- 表的结构 `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `contact_number` text NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `buyer`
--

INSERT INTO `buyer` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `contact_number`, `address`) VALUES
(1, 'ShaoXi1125', '$2y$10$PEmjLQ6mVPj8qJgiNUfvFesCHVuWCyMnPZ/JGnAwMH9NCiwFgZGDC', 'ShaoXi', 'Chen', 'shaoxi97@outlook.com', '0164237177', NULL),
(2, '', '$2y$10$4t5Ukoy4PePkr.UtigbbQOrwHqBdpWae6PYQYJ7N.xxWATfylXmwC', '', '', '', '', NULL),
(3, 'Shoppie', '$2y$10$CAxFpFg2/OuDn0q2rg.Usewv8qQFtA8jc5F7jBaKm8l4YOu1tnOnO', 'Shop', 'shop', 'shoppie123@gmail.com', '01234567890', NULL),
(4, 'Mocha', '$2y$10$w.wuNVCpHuOa13sFdG.Jier/lu.NbqYGfgiEgU32Jk2bZ9bPGapgK', 'Mo', 'Cha', 'mocha@gmail.com', '01234567879', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Mobile'),
(2, 'Accessories'),
(3, 'Cable & Charger'),
(4, 'Case');

-- --------------------------------------------------------

--
-- 表的结构 `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `id_card_front` varchar(522) NOT NULL,
  `id_card_back` varchar(522) NOT NULL,
  `SSM` varchar(522) NOT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `document`
--

INSERT INTO `document` (`id`, `id_card_front`, `id_card_back`, `SSM`, `seller_id`) VALUES
(4, 'documents/Screenshot 2023-01-19 093143.png', 'documents/Screenshot 2023-01-19 093224.png', 'documents/Business_Certificate_Main_CTC_www.ReprintSSM.Com_.jpg', 2),
(6, 'documents/fb73417afb1d1ff1a01ab1cec0d03507.png', 'documents/Screenshot 2021-03-09 160729.png', 'documents/data in the database.png', 4);

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`id`, `image`, `item_name`, `price`, `quantity`, `seller_id`, `category_id`) VALUES
(1, 'finish_midnight__eq10v7pn1oom_large.png', 'iPhone SE', 1999, 3, 1, 1),
(2, 'Screenshot 2023-01-19 093143.png', 'Testing', 12, 12, 4, 1);

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `category` text NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `order_time` datetime NOT NULL,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ordered_item`
--

CREATE TABLE `ordered_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ordered_list`
--

CREATE TABLE `ordered_list` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` varchar(522) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `order_list`
--

CREATE TABLE `order_list` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` varchar(522) NOT NULL,
  `c_id` int(11) NOT NULL,
  `status` varchar(522) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `order_list`
--

INSERT INTO `order_list` (`id`, `item_id`, `amount`, `quantity`, `date`, `c_id`, `status`) VALUES
(1, 1, 1999, 1, '2023-01-18', 1, 'PENDING'),
(2, 1, 5997, 3, '2024-01-18', 3, 'PENDING'),
(3, 1, 5997, 3, '2024-01-18', 4, 'PENDING');

-- --------------------------------------------------------

--
-- 表的结构 `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `shop_name` text NOT NULL,
  `password` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `contact_number` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `ban_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `seller`
--

INSERT INTO `seller` (`id`, `shop_name`, `password`, `first_name`, `last_name`, `email`, `contact_number`, `status`, `ban_count`) VALUES
(1, 'ABC shop', '$2y$10$3kkU22N/vxGJED.N3z.HqeFkIMMdsSLU9Up.rZ/RuKkQwKaakv3SC', 'Ben', 'Berlic', 'ben@mail.com', '0123456789', 'ACTIVE', 0),
(2, 'Appple', '$2y$10$LMe9FQV5hGYKuQ2Xz42ole86SyhduKCUAXWwI55vkb7kmVDiOhfpW', 'Ben', 'Ben', 'mail@mail.com', '0123456789', 'BAN', 1),
(4, 'Testing', '$2y$10$MS714ONTdIcZUMje31VlaugVMmQGrhiNtFXGrfE.dQZ.X7LHrteXK', 'Test', 'Test', 'test@mail.com', '0123456789', 'BAN_PERMANENT', 3);

-- --------------------------------------------------------

--
-- 表的结构 `suspend`
--

CREATE TABLE `suspend` (
  `id` int(11) NOT NULL,
  `reason` varchar(522) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `ban_expire_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `suspend`
--

INSERT INTO `suspend` (`id`, `reason`, `seller_id`, `ban_expire_time`) VALUES
(10, 'T1', 4, 1674458201),
(11, 'T2', 4, 1674803894),
(12, 'T3', 4, 1674199176),
(13, 'T4\r\n', 4, 1674200081),
(14, 'T1', 2, 1674460921);

-- --------------------------------------------------------

--
-- 表的结构 `table`
--

CREATE TABLE `table` (
  `id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `ordered_item`
--
ALTER TABLE `ordered_item`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `ordered_list`
--
ALTER TABLE `ordered_list`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `suspend`
--
ALTER TABLE `suspend`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ordered_item`
--
ALTER TABLE `ordered_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `ordered_list`
--
ALTER TABLE `ordered_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `suspend`
--
ALTER TABLE `suspend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `table`
--
ALTER TABLE `table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
