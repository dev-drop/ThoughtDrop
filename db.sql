-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 18, 2019 at 01:04 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `thoughtdrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `author_Id` varchar(6) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  `body` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_Id` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Id`, `author_Id`, `timestamp`, `body`, `post_Id`, `likes`) VALUES
(31, 'A12345', '2019-03-17 09:04:24', 'Marketing Test', 321, 0),
(32, 'A12345', '2019-03-17 09:07:50', 'Marketing Test', 321, 0),
(33, 'A12345', '2019-03-17 09:07:53', 'Marketing Test', 321, 0),
(34, 'A12345', '2019-03-17 09:09:25', 'Marketing Test', 321, 0),
(35, 'A12345', '2019-03-17 09:10:53', 'Marketing Test', 321, 0),
(36, 'A12345', '2019-03-17 09:12:40', 'Marketing Test', 321, 0),
(37, 'A12345', '2019-03-17 09:15:56', 'Marketing Test', 321, 0),
(38, 'A12345', '2019-03-17 09:16:51', 'Marketing Test', 321, 0),
(39, 'A12345', '2019-03-17 09:17:07', 'Marketing Test', 321, 0),
(40, 'A12345', '2019-03-17 09:18:50', 'Marketing Test', 321, 0),
(41, 'A12345', '2019-03-17 09:19:00', 'Marketing Test', 321, 0),
(42, 'A12345', '2019-03-17 09:19:13', 'Marketing Test', 321, 0),
(43, 'A12345', '2019-03-17 09:21:39', 'Marketing Test', 321, 0),
(44, 'A12345', '2019-03-17 09:22:16', 'Marketing Test', 321, 0),
(45, 'A12345', '2019-03-17 09:22:30', 'Marketing Test', 321, 0),
(46, 'A12345', '2019-03-17 09:22:33', 'Marketing Test', 321, 0),
(47, 'A12345', '2019-03-17 09:22:40', 'New comment\r\n', 320, 0),
(48, 'A12345', '2019-03-17 09:23:15', 'New comment\r\n', 320, 0),
(51, 'A12345', '2019-03-17 15:12:06', 'This is a comment on this post\r\n', 378, 0),
(52, 'A12345', '2019-03-17 15:30:12', 'This is another comment', 378, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Id` int(11) NOT NULL,
  `employee_Id` varchar(6) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `display_name` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` tinyint(255) NOT NULL,
  `thumbnail` blob NOT NULL COMMENT 'Could be Text URL',
  `secret` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Id`, `employee_Id`, `display_name`, `password`, `role`, `thumbnail`, `secret`, `url`) VALUES
(51, 'R12345', 'BillyBob', '$2y$12$aRvzDiBTSiNK5uypG1PwFOQt1KkziMN0oCyodnvMOS2IBXg5uRTB.', 0, '', '', ''),
(52, 'A12345', 'Admin', '$2y$12$mFFE/guXv9Fa4Wb1h.wFoOtvcYl/YTaPiniFn.Bd7K9ScUApb.Q8C', 127, '', '', ''),
(53, 'M12345', 'MARKETING', '$2y$12$sSaNJSoYDob3KfJX0vR2DOS0.BX5EsRfk/aa4qhp.vy7/AkRAK7ii', 0, '', '', ''),
(54, 'M54321', 'Cameron', '$2y$12$A1ecD5kFfP4vRF6H0Tx7L.W0e9p2xuPOndRc/7rb9iolonSLcabqe', 0, '', '', ''),
(55, 'M11111', 'MarketingAgain', '$2y$12$MYJlbCfYEYPhqIkwPU6Wy.pskrzVOSbiPXgxE.VpYBMty9jJ0O6Mi', 10, '', '', ''),
(56, 'A66666', '', '$2y$12$JQT9HUyc5k.rA9OIdvDD/euGOa3kI3imqgZNAixLRwBmvOH6G2jp2', 10, '', '', ''),
(57, 'R33333', 'TheLady', '$2y$12$dtbqJiA2bH5LMYUOP3LyseH5JIOGi9q6BUrsAhJKMGPa9xHc.K9Um', 10, '', '', ''),
(64, 'R22222', 'Cameron', '$2y$12$cbXa92SnlDFTewIGxfiWA..6J46chxwT9b2LAuK7uErp399evGnn6', 10, '', '', ''),
(65, 'M33333', 'CameronM', '$2y$12$mzbUvwbLQLmCBHMyPubYqeonKJ1RkMV8JguRRf.fJxZZwpTGHVTSC', 10, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `Id` int(11) NOT NULL,
  `post_Id` int(11) NOT NULL,
  `employee_Id` varchar(6) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`Id`, `post_Id`, `employee_Id`) VALUES
(143, 315, 'A12345'),
(144, 315, 'A12345'),
(145, 315, 'A12345'),
(146, 315, 'A12345'),
(147, 315, 'A12345'),
(148, 315, 'A12345'),
(149, 315, 'A12345'),
(150, 315, 'A12345'),
(151, 316, 'A12345'),
(152, 316, 'A12345'),
(153, 316, 'A12345'),
(154, 316, 'A12345'),
(155, 345, 'A12345'),
(156, 321, 'A12345'),
(157, 321, 'A12345'),
(158, 321, 'A12345'),
(159, 320, 'A12345'),
(160, 320, 'A12345'),
(161, 320, 'A12345'),
(162, 320, 'A12345'),
(163, 320, 'A12345'),
(164, 320, 'A12345'),
(165, 320, 'A12345'),
(317, 321, 'A12345'),
(318, 321, 'A12345'),
(319, 321, 'A12345'),
(320, 321, 'A12345'),
(321, 321, 'A12345'),
(322, 321, 'A12345'),
(340, 378, 'A12345'),
(341, 378, 'A12345'),
(342, 378, 'A12345'),
(343, 378, 'A12345');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `author_Id` varchar(6) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Id`, `timestamp`, `author_Id`, `body`, `likes`, `comments`) VALUES
(315, '2019-02-28 20:09:09', 'A12345', 'Hey ALL, I\'m an Admin. Your Posts are `Basically` MY posts :P ', 0, 0),
(316, '2019-02-28 20:20:02', 'A12345', 'Check out all the things an admin can do...  i can A) Edit &quot;YOUR&quot; posts ... B) Delete &quot;YOUR&quot; posts....    Man, what a good life it is as an Admin :) \r\n', 0, 0),
(319, '2019-03-01 07:59:04', 'R12345', 'Hey guys, My names Billy Bob and I\'m from research and development. Nice to meet ya\'ll', 0, 0),
(320, '2019-03-01 08:51:27', 'M12345', 'Hi all, My name is &quot;Marketing&quot;... I think my parents could see the future :P ', 0, 0),
(321, '2019-03-01 08:51:50', 'M12345', 'Just checking in.... anyone else in this marketing department want to talk ????', 0, 0),
(322, '2019-03-01 08:53:45', 'R12345', 'Huge barn-party at my place tonight after work. BYOB YA\'LL !! ', 0, 0),
(326, '2019-03-01 09:00:13', 'A66666', 'I\'m an admin without a Display_Name.... What was a i thinking ????', 0, 0),
(330, '2019-03-02 10:50:09', 'R12345', 'Hey all  !!!', 0, 0),
(345, '2019-03-12 08:49:43', 'R22222', 'Good morning !!!!!!!!', 0, 0),
(346, '2019-03-15 09:48:02', 'A12345', 'Im the boss...', 0, 0),
(366, '2019-03-16 17:37:06', 'A12345', 'Hellllooooo', 0, 0),
(375, '2019-03-17 10:02:00', 'A12345', 'This is a test', 0, 0),
(378, '2019-03-17 10:05:07', 'A12345', 'adaddaad', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `author_Id` (`author_Id`),
  ADD KEY `post_id` (`post_Id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `employee_Id` (`employee_Id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `employee_Id` (`employee_Id`),
  ADD KEY `post_Id` (`post_Id`) USING BTREE,
  ADD KEY `post_Id_2` (`post_Id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `author_Id` (`author_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `authID` FOREIGN KEY (`author_Id`) REFERENCES `employee` (`employee_Id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_Id`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `EmpKey` FOREIGN KEY (`employee_Id`) REFERENCES `employee` (`employee_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postKey` FOREIGN KEY (`post_Id`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `authors` FOREIGN KEY (`author_Id`) REFERENCES `employee` (`employee_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
