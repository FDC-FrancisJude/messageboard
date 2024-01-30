-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 30, 2024 at 03:10 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messageboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `hubby` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at_ip` varchar(100) NOT NULL,
  `modified_at` int(11) DEFAULT NULL,
  `modified_at_ip` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `name`, `profile_pic`, `birthday`, `gender`, `hubby`, `user_id`, `created_at`, `created_at_ip`, `modified_at`, `modified_at_ip`) VALUES
(1, 'Francis Jude', NULL, NULL, 'Male', NULL, 1, '2024-01-29 03:24:26', '::1', NULL, NULL),
(2, 'Francis Jude2', NULL, NULL, NULL, NULL, 2, '2024-01-29 05:15:00', '::1', NULL, NULL),
(3, 'Francis Jude 3', NULL, NULL, NULL, NULL, 3, '2024-01-29 05:15:59', '::1', NULL, NULL),
(4, 'fdc.francisjude@gmai', NULL, NULL, NULL, NULL, 4, '2024-01-30 01:30:52', '::1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at_ip` varchar(100) NOT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `modified_at_ip` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `last_login_time`, `created_at`, `created_at_ip`, `modified_at`, `modified_at_ip`) VALUES
(1, 'Francis Jude', 'fdc.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-01-30 02:04:25', '2024-01-29 03:24:26', '::1', NULL, NULL),
(2, 'Francis Jude2', 'fdc2.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-01-29 05:15:00', '2024-01-29 05:15:00', '::1', NULL, NULL),
(3, 'Francis Jude 3', 'fdc3.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-01-29 05:15:59', '2024-01-29 05:15:59', '::1', NULL, NULL),
(4, 'fdc.francisjude@gmai', 'dsdsd@dasd.com', '129e96f42b8426680ba4c0b0401f12edf1889091', '2024-01-30 01:31:19', '2024-01-30 01:30:52', '::1', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
