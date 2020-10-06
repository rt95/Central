-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2016 at 06:24 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centraldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `commentsinfo`
--

CREATE TABLE `commentsinfo` (
  `commentId` int(11) NOT NULL,
  `articleId` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commentsinfo`
--

INSERT INTO `commentsinfo` (`commentId`, `articleId`, `user`, `comment`, `likes`) VALUES
(8, 111, 'Caranellus', 'AWWW!', 0),
(40, 111, 'rasd', ':)', 0),
(41, 112, 'rasd', 'Comment', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contentinfo`
--

CREATE TABLE `contentinfo` (
  `id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL,
  `user` varchar(30) NOT NULL,
  `likes` int(11) NOT NULL,
  `filePath` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contentinfo`
--

INSERT INTO `contentinfo` (`id`, `title`, `user`, `likes`, `filePath`) VALUES
(111, 'Cats are super cute!', 'Caranellus', 0, '../localStorage/Cats are super cute!'),
(112, 'Another one!', 'Caranellus', 0, '../localStorage/Another one!'),
(113, 'Test', 'rasd', 0, '../localStorage/Test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `firstName` varchar(35) NOT NULL,
  `lastName` varchar(35) NOT NULL,
  `bornDate` date NOT NULL,
  `joinDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userEmail`, `userPass`, `firstName`, `lastName`, `bornDate`, `joinDate`) VALUES
(1, 'Robert', 'roberttopalovic@hotmail.com', '4007d46292298e83da10d0763d95d5139fe0c157148d0587aa912170414ccba6', 'Robert', 'Topalovic', '1995-07-13', ''),
(2, 'rasd', 'roberttopalovic95@gmai.com', '4007d46292298e83da10d0763d95d5139fe0c157148d0587aa912170414ccba6', '', '', '0000-00-00', ''),
(4, 'Caranellus', 'robert@hotmail.com', '4007d46292298e83da10d0763d95d5139fe0c157148d0587aa912170414ccba6', 'Robert', 'Topalovic', '1995-07-13', '2016-11-05 00:42:38'),
(5, 'Robert Topalovic', 'robertttt@hotmail.com', '4007d46292298e83da10d0763d95d5139fe0c157148d0587aa912170414ccba6', '', '', '0000-00-00', '2016-11-22 03:18:41'),
(6, 'dada', 'asd@hotmail.com', '4007d46292298e83da10d0763d95d5139fe0c157148d0587aa912170414ccba6', '', '', '0000-00-00', '2016-11-22 03:23:08'),
(9, 'asdasdasd', 'sada@hotmail.com', 'd8a928b2043db77e340b523547bf16cb4aa483f0645fe0a290ed1f20aab76257', '', '', '0000-00-00', '2016-11-22 03:26:56'),
(10, 'adxasxd', 'asx@gmail.com', '425b643516348c41f4bd3280c2a9630c65700f2c8848274a16e75b393bace4d6', '', '', '0000-00-00', '2016-11-22 03:27:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commentsinfo`
--
ALTER TABLE `commentsinfo`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `contentinfo`
--
ALTER TABLE `contentinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentsinfo`
--
ALTER TABLE `commentsinfo`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `contentinfo`
--
ALTER TABLE `contentinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
