-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 22, 2024 at 07:50 AM
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
-- Table structure for table `users`
--
-- Creation: Nov 21, 2024 at 07:50 PM
-- Last update: Nov 22, 2024 at 06:38 AM
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password_hash`, `failed_attempts`, `last_failed_attempt`) VALUES
(31, 'Kyle', 'Stranick', 'kstranic@dtcc.edu', 'kstranic', '$2y$10$5b2AVATFLhyS8tfdk2cRVu2wvJND8swBKGPnfE3AZFvXOvgcJWgFW', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_hash` (`password_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `price` double NOT NULL,
  `city` text NOT NULL,
  `state` char(2) NOT NULL,
  `condition` text NOT NULL,
  `description` text NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `item_name`, `price`, `city`, `state`, `condition`, `description`, `image_path`) VALUES
(15, 'TEST', 7.897897897897897e20, 'test', 'te', 'NEW', 'another one ', '../media/20180422_164644.jpg'),
(11, 'testing again', 12345, 'testtown', 'TE', 'old', 'this is a test', '../media/FB_IMG_1710849899679.jpg,../media/keiko-and-I-lake.jpg,../media/Screenshot 2024-04-08 201917.png'),
(6, 'test', 3, 'test', 'te', 'test', 'test', '../media/keiko-and-I-lake.jpg'),
(7, 'test2', 7, 'trte', 'tr', 'test', 'teest2', '../media/keiko-maine-trip.jpg'),
(8, 'test2', 7, 'trte', 'tr', 'test', 'teest2', '../media/keiko-maine-trip.jpg'),
(12, 'adding a test', 23, 'test', 'DE', 'test', 'yupp its a test , update', '../media/20180527_192639.jpg'),
(16, 'trfds', 1, 'ggfds', 'de', 'test', 'fsdfgds', '../media/20180422_161524.jpg'),
(14, 'TEST', 11192024, 'today', 'de', 'toldsfdaf', 'uiouiop', '../media/20180830_203647.jpg'),
(10, 'TEST', 432, 'tre', 'TR', 'trewdfsg', 'rew', '../media/Screenshot 2024-04-08 201917.png'),
(9, 'TEST', 3, 'trewtrew', 'tr', 'trewtrew', 'trewtre', '../media/keiko-and-i.jpg,../media/keiko-and-I-lake.jpg,../media/keiko-maine-trip.jpg'),
(13, 'ttretrewgfd', 5435432, 'fgdsgfds', 'de', 'trftrewtre', 'gfdsgfds', '../media/20180423_185550.jpg'),
(2, 'Kitchen Triple Sink', 3433243, 'Gumboro', 'DE', 'used', 'CHANGE PLEASE', '../media/triple_sink.jpg'),
(3, '97 Jeep Wrangler\r\n', 5000, 'Millsboro', 'de', 'used', 'Used but garage kept. Price is FIRM!', '../media/jeep.jpg,../media/jeep_2.jpg,../media/jeep_3.jpg'),
(1, 'PS4', 1234, 'Selbyville', 'DE', 'usedp', 'Lightly used, in great shape.  test THE CAHNGE 11-19', '../media/ps4.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
