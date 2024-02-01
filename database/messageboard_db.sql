-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 01, 2024 at 10:37 AM
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
-- Table structure for table `message_details`
--

CREATE TABLE `message_details` (
  `id` int(11) NOT NULL,
  `message_list_id` int(11) NOT NULL,
  `message_content` longtext NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at_ip` varchar(100) DEFAULT NULL,
  `modified_at` varchar(100) DEFAULT NULL,
  `modified_at_ip` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_details`
--

INSERT INTO `message_details` (`id`, `message_list_id`, `message_content`, `sender_user_id`, `created_at`, `created_at_ip`, `modified_at`, `modified_at_ip`) VALUES
(91, 52, 'sadasd', 6, '2024-02-01 08:09:32', '::1', NULL, NULL),
(102, 57, 'asdasd,asdsajgdjasbgasuygdugu\r\nasdjhasdhakhjkkj\r\naskjdhjkdhklasdh\r\njahsdjkashkdhdsakajdklasdhlasd\r\nkajdliasdlaskahjdlahd\r\nahdlkashklsad', 6, '2024-02-01 08:29:58', '::1', NULL, NULL),
(103, 57, 'sdsadsd', 7, '2024-02-01 08:38:42', '::1', NULL, NULL),
(104, 57, 'jyagdsydgasdjadasjdasdasdASdaskdhaskdhad\r\naksdasdasdasaidyaisdahdashdad\r\nahdjkashdkasdksad', 7, '2024-02-01 08:38:53', '::1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at_ip` varchar(100) DEFAULT NULL,
  `modified_at` varchar(100) DEFAULT NULL,
  `modified_at_ip` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `user_id`, `to_user_id`, `created_at`, `created_at_ip`, `modified_at`, `modified_at_ip`) VALUES
(52, 6, 8, '2024-02-01 08:09:32', '::1', NULL, NULL),
(57, 6, 7, '2024-02-01 08:29:58', '::1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'no_image.jpg',
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
(6, 'Francis Jude', 'profile_pic_1706759951.png', '2024-01-01', 'Female', 'asdasddsad\r\nas\r\ndsa\r\nd\r\nad\r\nasdasd', 6, '2024-01-30 06:23:15', '::1', NULL, NULL),
(7, 'Francis Jude 2', 'profile_pic_1706678299.png', '2024-01-01', 'Male', 'sadasddasdsa\r\nasdasd\r\ndasd\r\nasd\r\nasd\r\nasd\r\nadasdsada', 7, '2024-01-30 06:40:58', '::1', NULL, NULL),
(8, 'Francis Jude 3', 'profile_pic_1706598106.png', '2000-10-04', 'Male', 'HAHAHHA\r\nHAHAHA\r\nashdhddhd\r\nshdsahd\r\nsdsahd\r\nsda\r\n', 8, '2024-01-30 07:01:05', '::1', NULL, NULL),
(9, 'HAHAHAHA', 'profile_pic_1706685976.png', '2014-01-01', 'Male', 'ashasddhasdsad', 9, '2024-01-31 07:25:40', '::1', NULL, NULL);

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
(6, 'Francis Jude', 'fdc.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-01 08:39:17', '2024-01-30 06:23:15', '::1', NULL, NULL),
(7, 'Francis Jude 2', 'fdc2.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-01 08:38:39', '2024-01-30 06:40:58', '::1', NULL, NULL),
(8, 'Francis Jude 3', 'fdc3.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-01 06:59:16', '2024-01-30 07:01:05', '::1', NULL, NULL),
(9, 'HAHAHAHA', 'hahaha@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-01-31 07:25:40', '2024-01-31 07:25:40', '::1', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message_details`
--
ALTER TABLE `message_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `message_details`
--
ALTER TABLE `message_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
