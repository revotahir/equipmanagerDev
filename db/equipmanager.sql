-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2025 at 01:13 AM
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
-- Database: `equipmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `companydetail`
--

CREATE TABLE `companydetail` (
  `companyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `companyName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companydetail`
--

INSERT INTO `companydetail` (`companyID`, `userID`, `companyName`) VALUES
(2, 2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `userauth`
--

CREATE TABLE `userauth` (
  `authID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `authCode` varchar(20) NOT NULL,
  `authTocken` varchar(500) NOT NULL,
  `authStatus` tinyint(1) NOT NULL COMMENT '1=approved\r\n0=No Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`authID`, `userID`, `authCode`, `authTocken`, `authStatus`) VALUES
(2, 2, '3530', 'CtOGU2go', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userPhone` varchar(20) DEFAULT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPass` varchar(500) NOT NULL,
  `userType` tinyint(1) NOT NULL COMMENT '1=SuperAdmin\r\n2=Company admin\r\n3=Company manager\r\n4=General User',
  `userStatus` tinyint(1) NOT NULL COMMENT '1=active\r\n2=pending Auth\r\n0=blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userPhone`, `userEmail`, `userPass`, `userType`, `userStatus`) VALUES
(2, 'testUser11', '03186205466', 'revotahir@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companydetail`
--
ALTER TABLE `companydetail`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
  ADD PRIMARY KEY (`authID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companydetail`
--
ALTER TABLE `companydetail`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `authID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
