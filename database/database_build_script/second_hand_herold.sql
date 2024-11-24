-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 24, 2024 at 05:17 AM
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
-- Database: `second_hand_herold`
--
CREATE DATABASE IF NOT EXISTS `second_hand_herold` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `second_hand_herold`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
-- Creation: Nov 22, 2024 at 10:29 PM
-- Last update: Nov 24, 2024 at 04:15 AM
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `price` double NOT NULL,
  `city` text NOT NULL,
  `state` char(2) NOT NULL,
  `condition` text NOT NULL,
  `description` text NOT NULL,
  `image_path` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `products`:
--   `user_id`
--       `users` -> `user_id`
--   `user_id`
--       `users` -> `user_id`
--

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `item_name`, `price`, `city`, `state`, `condition`, `description`, `image_path`, `user_id`) VALUES
(1, 'TEST', 1, 'FDSAFDSA', 'DE', 'FEW', 'DSADSA', '../media/20180422_162542.jpg', 1),
(2, 'TEST', 12, 'ew', 're', 'fdsafds', 'ewq', '../media/keiko-and-I-lake.jpg', 1),
(3, 'TEST', 12, 'ew', 're', 'fdsafds', 'ewq', '../media/keiko-and-I-lake.jpg', 1),
(4, 'TEST', 456, 'fghfjqde', 'de', 'gfhjkf', 'fdgk', '../media/keiko-and-i.jpg', 1),
(5, 'TEST', 123, 'test', 'de', 'new', 'test', '../media/keiko-and-i.jpg', 1),
(6, 'TEST', 122, 'test', 'te', 'old', 'test', '../media/20180517_141354.jpg', 2),
(7, 'test', 152, 'fix', 'fe', 'test', 'test', '../media/20180527_191624.jpg', 2),
(8, 'TEST', 1e16, 'Shadow Moses island', 'AK', 'used', 'for david', '../media/20190119_145154.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Nov 22, 2024 at 06:14 PM
-- Last update: Nov 24, 2024 at 04:12 AM
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_failed_attempt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `username`, `password_hash`, `failed_attempts`, `last_failed_attempt`) VALUES
(1, 'kyle', 'stranick', 'kstranic@dtcc.edu', 'kstranic', '$2y$10$EUw/cbZrhvfSKLCIdQqXgOaYOKvUPP.l11IIYQtp46MT..kqQEuMW', 0, NULL),
(2, 'bill', 'withers', 'appointedDuty@friends.co', 'UseMe', '$2y$10$j4QaofEkVu.P8YdbXDGns.0H3QUAQrrzVJINfWGijzjX.jNkAntti', 0, NULL),
(3, 'David', 'Hayter', 'canlovebloomonabattlefield@sha', 'lalelulilo', '$2y$10$Li49F8eArlQsQ/aVAqvZxe82f9sRLwLs7ycE3rs8RLPspD3a2ZgFK', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_hash` (`password_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
