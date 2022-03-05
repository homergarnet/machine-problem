-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2022 at 08:22 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `entrance-exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` bigint(11) NOT NULL,
  `notification_type` enum('Notification') NOT NULL,
  `notification_sender_type` text NOT NULL,
  `notification_receiver_type` text NOT NULL,
  `notification_sender_id` text NOT NULL,
  `notification_receiver_id` bigint(11) NOT NULL,
  `user_post_id` bigint(11) NOT NULL,
  `message` text NOT NULL,
  `seen` enum('1','0') NOT NULL DEFAULT '0',
  `notify` enum('1','0') NOT NULL DEFAULT '0',
  `date` text NOT NULL,
  `time` text NOT NULL,
  `notification_is_active` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_type`, `notification_sender_type`, `notification_receiver_type`, `notification_sender_id`, `notification_receiver_id`, `user_post_id`, `message`, `seen`, `notify`, `date`, `time`, `notification_is_active`) VALUES
(1, 'Notification', 'User', 'User', '0', 1, 1, 'Commented on your post', '1', '1', 'March 5, 2022', '3:10 pm', '1'),
(2, 'Notification', 'User', 'User', '0', 1, 1, 'Commented on your post', '1', '1', 'March 5, 2022', '3:11 pm', '1'),
(3, 'Notification', 'User', 'User', '2', 1, 1, 'Commented on your post', '1', '1', 'March 5, 2022', '3:12 pm', '1'),
(4, 'Notification', 'User', 'User', '1', 2, 2, 'Commented on your post', '1', '1', 'March 5, 2022', '3:18 pm', '1'),
(5, 'Notification', 'User', 'User', '1', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:19 pm', '1'),
(6, 'Notification', 'User', 'User', '2', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:20 pm', '1'),
(7, 'Notification', 'User', 'User', '0', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:20 pm', '1'),
(8, 'Notification', 'User', 'User', '2', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:20 pm', '1'),
(9, 'Notification', 'User', 'User', '0', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:21 pm', '1'),
(10, 'Notification', 'User', 'User', '2', 3, 4, 'Commented on your post', '0', '0', 'March 5, 2022', '3:21 pm', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(11) NOT NULL,
  `user_email` text NOT NULL,
  `user_password` text NOT NULL,
  `user_image` text NOT NULL,
  `user_display_name` text NOT NULL,
  `user_birth_date` text NOT NULL,
  `user_age` int(11) NOT NULL,
  `user_phone` text NOT NULL,
  `user_token` text NOT NULL,
  `user_is_active` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_image`, `user_display_name`, `user_birth_date`, `user_age`, `user_phone`, `user_token`, `user_is_active`) VALUES
(1, 'homergarnetcabilla@gmail.com', '$2y$10$JBgsFfXzgO2Y8xKoSPk9xufkMEzqiNoeEtKIbMRAlHzZHGck6oQ0m', '1.jpg', 'homer cabilla', '03/01/2004', 18, '09123456789', 'TPEawUN/dz', '1'),
(2, 'kenneth@yahoo.com', '$2y$10$obYsDFirjQVw6dI5wtKdkuQndlDElFl1HAthvhDSjsc1U4xZUpj.W', '2.png', 'Kenneth John', '03/01/2004', 18, '09213456123', 'TqeorWRla0', '1'),
(3, 'john@yahoo.com', '$2y$10$iFxp/qlam1MHHeH0D.5De.uwBGzRfWOT8zAk1uS6uJwlW68Pd0V3e', '3.png', 'John John', '03/02/2004', 18, '09123123123', 'chRvFyqPl2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_comment`
--

CREATE TABLE `user_comment` (
  `user_comment_id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `user_post_id` bigint(11) NOT NULL,
  `user_comment` text NOT NULL,
  `user_comment_date` text NOT NULL,
  `user_comment_time` text NOT NULL,
  `user_comment_is_active` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_comment`
--

INSERT INTO `user_comment` (`user_comment_id`, `user_id`, `user_post_id`, `user_comment`, `user_comment_date`, `user_comment_time`, `user_comment_is_active`) VALUES
(1, 0, 1, 'nice eyeglasses bro :)\n', 'March 5, 2022', '3:10 pm', '1'),
(2, 1, 1, 'thank you!\n', 'March 5, 2022', '3:10 pm', '1'),
(3, 1, 1, 'I think its better for you to had an account\n', 'March 5, 2022', '3:11 pm', '1'),
(4, 0, 1, 'later, i will create an account\n', 'March 5, 2022', '3:11 pm', '1'),
(5, 1, 1, 'that would be nice\n', 'March 5, 2022', '3:11 pm', '1'),
(6, 2, 1, 'nice post!\n', 'March 5, 2022', '3:12 pm', '1'),
(7, 1, 2, 'good looking hair cut bro!\n', 'March 5, 2022', '3:18 pm', '1'),
(8, 2, 2, 'awesome! thank you\n', 'March 5, 2022', '3:19 pm', '1'),
(9, 1, 4, 'nice food john john bro\n', 'March 5, 2022', '3:19 pm', '1'),
(10, 2, 4, 'looks delicious food\n', 'March 5, 2022', '3:20 pm', '1'),
(11, 0, 4, 'exactly.\n', 'March 5, 2022', '3:20 pm', '1'),
(12, 2, 4, 'I think that was a japanese food ?\n', 'March 5, 2022', '3:20 pm', '1'),
(13, 0, 4, 'yes it was good food\n', 'March 5, 2022', '3:21 pm', '1'),
(14, 2, 4, 'you can create an account now :)\n', 'March 5, 2022', '3:21 pm', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE `user_post` (
  `user_post_id` bigint(11) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `user_post_image` text NOT NULL,
  `user_post_content` text NOT NULL,
  `user_post_date` text NOT NULL,
  `user_post_time` text NOT NULL,
  `user_post_is_active` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_post`
--

INSERT INTO `user_post` (`user_post_id`, `user_id`, `user_post_image`, `user_post_content`, `user_post_date`, `user_post_time`, `user_post_is_active`) VALUES
(1, 1, '1.png', 'my first story upload', 'March 3, 2022', '2:15 pm', '1'),
(2, 2, '2.jpg', 'Look my new hair cut for 2022 <3', 'March 3, 2022', '7:53 pm', '1'),
(3, 1, '3.jpg', 'Drinking coffee after work is so good.', 'March 3, 2022', '8:41 pm', '1'),
(4, 3, '4.jpg', 'Food was awesome', 'March 4, 2022', '11:43 pm', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_comment`
--
ALTER TABLE `user_comment`
  ADD PRIMARY KEY (`user_comment_id`);

--
-- Indexes for table `user_post`
--
ALTER TABLE `user_post`
  ADD PRIMARY KEY (`user_post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_comment`
--
ALTER TABLE `user_comment`
  MODIFY `user_comment_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_post`
--
ALTER TABLE `user_post`
  MODIFY `user_post_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
