-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2024 at 08:56 AM
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
  `modified_at_ip` varchar(100) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_details`
--

INSERT INTO `message_details` (`id`, `message_list_id`, `message_content`, `sender_user_id`, `created_at`, `created_at_ip`, `modified_at`, `modified_at_ip`, `deleted`) VALUES
(1, 1, 'Hi. How Are you?', 1, '2024-02-02 07:52:35', '::1', NULL, NULL, 0),
(2, 1, 'Im good. How about you?', 2, '2024-02-02 07:52:56', '::1', NULL, NULL, 0),
(3, 1, 'Im good too.', 1, '2024-02-02 07:53:10', '::1', NULL, NULL, 0),
(4, 2, 'Hi.', 1, '2024-02-02 07:55:02', '::1', NULL, NULL, 1),
(5, 2, 'Hello', 3, '2024-02-02 07:55:15', '::1', NULL, NULL, 1),
(6, 2, 'Musta?\r\n', 1, '2024-02-02 07:55:23', '::1', NULL, NULL, 1),
(7, 2, 'Okay ra ikaw?', 3, '2024-02-02 07:55:46', '::1', NULL, NULL, 1),
(8, 2, 'Hi', 1, '2024-02-02 07:56:33', '::1', NULL, NULL, 0);

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
(1, 1, 2, '2024-02-02 07:52:35', '::1', NULL, NULL),
(2, 1, 3, '2024-02-02 07:55:02', '::1', NULL, NULL);

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
(1, 'Francis Jude', 'profile_pic_1706860316.png', '2000-10-04', 'Male', 'Qwerty Qwerty Qwerty Qwerty\r\nQwerty Qwerty Qwerty Qwerty\r\nQwerty Qwerty Qwerty Qwerty\r\nQwerty Qwerty Qwerty Qwerty', 1, '2024-02-02 07:50:16', '::1', NULL, NULL),
(2, 'Francis Jude 2', 'profile_pic_1706860268.png', '2003-10-22', 'Male', 'Sample Sample Sample Sample\r\nSample Sample Sample Sample\r\nSample Sample Sample Sample\r\nSample Sample Sample Sample', 2, '2024-02-02 07:50:32', '::1', NULL, NULL),
(3, 'Francis Jude 3', 'profile_pic_1706860489.png', '2006-04-13', 'Male', 'Asdfgh Asdfgh Asdfgh Asdfgh\r\nAsdfgh Asdfgh Asdfgh Asdfgh\r\nAsdfgh Asdfgh Asdfgh Asdfgh\r\nAsdfgh Asdfgh Asdfgh Asdfgh', 3, '2024-02-02 07:54:18', '::1', NULL, NULL);

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
(1, 'Francis Jude', 'fdc.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-02 07:50:16', '2024-02-02 07:50:16', '::1', NULL, NULL),
(2, 'Francis Jude 2', 'fdc2.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-02 07:50:32', '2024-02-02 07:50:32', '::1', NULL, NULL),
(3, 'Francis Jude 3', 'fdc3.francisjude@gmail.com', '23b9bb7fb45af8adf45c25bef88af7f69e75d7f8', '2024-02-02 07:54:18', '2024-02-02 07:54:18', '::1', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
