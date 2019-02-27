-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 26, 2019 at 11:27 PM
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
  `author_Id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `body` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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
  `thumbnail` blob NOT NULL COMMENT 'Could be Text URL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Id`, `employee_Id`, `display_name`, `password`, `role`, `thumbnail`) VALUES
(46, 'C12345', 'Cameron Bowler', '$2y$12$RNMVDLkpwcPKdVkNfl1K.eb0QwGT2mVvEhlPHqvUubPOO/jjK2VDu', 0, ''),
(47, 'P54321', 'CamTest', '$2y$12$WwUc.rAViQZxNICdTUqYguQFyHOBo2KGGOSnWOaLq8Tm2rayiZlf6', 0, ''),
(48, 'C54321', 'Cameron', '$2y$12$w5G8pBuaRSdFC2Ri9QlATu9nlnQQtvh4MVh9vxsbkRn.qhI.N/m.e', 0, ''),
(49, 'A54321', 'Cameroni', '$2y$12$qRqZKqvr1G1u3zjsxrya8.tbvOMMCC4JAUO9dyHayV5g7uFL8/EYG', 0, ''),
(50, 'F54321', 'Cameron', '$2y$12$hNikutjf3ap7yl7YfSEOmuSGSCLEufs1JAFVR92a0wtdmlDzIYUXW', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `Id` int(11) NOT NULL,
  `post_Id` int(11) NOT NULL,
  `employee_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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
(200, '2019-02-25 19:00:46', 'P54321', 'Test', 0, 0),
(205, '2019-02-25 19:06:16', 'P54321', 'Test2', 0, 0),
(212, '2019-02-25 19:18:20', 'C54321', 'test', 0, 0),
(213, '2019-02-25 19:18:26', 'C54321', 'test', 0, 0),
(217, '2019-02-25 19:36:02', 'C54321', 'asdada', 0, 0),
(219, '2019-02-26 07:54:38', 'C12345', 'Test', 0, 0),
(220, '2019-02-26 08:09:47', 'C12345', 'Test', 0, 0),
(222, '2019-02-26 14:16:41', 'C12345', 'dadadadad', 0, 0),
(223, '2019-02-26 14:17:29', 'C12345', 'dadadadad', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `author_Id` (`author_Id`),
  ADD KEY `post_id` (`post_id`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author_Id`) REFERENCES `employee` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`employee_Id`) REFERENCES `employee` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_Id`) REFERENCES `posts` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `authors` FOREIGN KEY (`author_Id`) REFERENCES `employee` (`employee_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
