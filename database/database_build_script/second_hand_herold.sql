-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 26, 2024 at 09:30 AM
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
-- Last update: Nov 26, 2024 at 08:29 AM
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `item_name` varchar(25) NOT NULL,
  `price` double NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` char(2) NOT NULL,
  `condition` varchar(10) NOT NULL,
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
(1, 'jeep wrangler', 1234, 'Millsboro', 'de', 'new', 'test', '../media/20210813_134934.jpg', 1),
(2, 'test', 1234, 'test', 'de', 'new', 'test item', '../media/20180422_161522.jpg', 1),
(3, 'Walking Tank', 11111111, 'shadow moses', 'ak', 'used', 'used to build a new outer heaven', '../media/download.jpeg', 2),
(4, 'test', 1223344, 'test', 'te', 'test', 'test', '../media/20180423_185550.jpg', 2),
(5, 'babe with the power', 12345, 'who do', 'ut', 'remind me ', 'power of voodo', '../media/download (1).jpeg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Nov 22, 2024 at 06:14 PM
-- Last update: Nov 26, 2024 at 08:18 AM
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(15) NOT NULL,
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
(1, 'Kyle', 'Stranick', 'kstranic@dtcc.edu', 'kstranic', '$2y$10$P4TXMcDveXqNirp.ppgNxeMFNVk/HTL1YHXO/TqsAiNRzKgfI39lK', 0, NULL),
(2, 'David', 'Hayter', 'justabox@shadow.net', 'LesEnfantsTerribles', '$2y$10$lBEV8WM4122WjLSZp/7y3.dGjru6mvZFy845.MxUYX2jxAvwAjZsS', 0, NULL),
(3, 'Ziggy', 'Stardust', 'thegoblinking@yahoo.com', 'Bowie', '$2y$10$FALNDYasrhe8pDETarjO7umajaAWSaOck89jndg8FOJZUeuWgnkJW', 0, NULL),
(4, 'test', 'test', 'test@test.test', 'test', '$2y$10$Al8RuArOQYaCV3m853pSyeh8Z8kqX2uBK46s1t/48xPDz9WL3N1Ja', 0, NULL);

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
