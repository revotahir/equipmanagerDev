-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 09:34 PM
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
(1, 1, 'admin'),
(2, 2, 'Company 2'),
(3, 9, 'test'),
(4, 10, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `equipcat`
--

CREATE TABLE `equipcat` (
  `equipCatID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `catName` varchar(200) NOT NULL,
  `catDesc` varchar(1000) NOT NULL,
  `catStatus` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipcat`
--

INSERT INTO `equipcat` (`equipCatID`, `companyID`, `catName`, `catDesc`, `catStatus`) VALUES
(11, 1, 'category1', 'aaaaaaa', 1),
(12, 1, 'cat 2sad', 'sdsd', 1),
(13, 1, 'test cat', 'aaaaa', 1),
(14, 1, 'Fainall test cat', 'test desc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipmentID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `equipName` varchar(200) NOT NULL,
  `equipCatID` int(11) NOT NULL,
  `equipImg` varchar(500) NOT NULL,
  `equipTotalQuantity` int(11) NOT NULL,
  `equipInUseQuantity` int(11) NOT NULL DEFAULT 0,
  `equipDesc` varchar(1000) NOT NULL,
  `equipStatus` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=inuse\r\n2=free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipmentID`, `companyID`, `equipName`, `equipCatID`, `equipImg`, `equipTotalQuantity`, `equipInUseQuantity`, `equipDesc`, `equipStatus`) VALUES
(4, 1, 'equip q', 12, 'bfe3d3b08e1ba3b51e1151299ccfb512.png', 13, 0, 'dd', 2),
(5, 1, 'equip q', 11, '3696c2e21a947e5fddd118cfc6b2bcd5.png', 12, 0, 'asda', 2),
(6, 1, 'Test Equipmr', 13, 'be70a14ffb476ada12462f6313759584.png', 12, 2, 'asfsdf', 2),
(7, 1, 'test qq', 12, 'f770faf201ed5e660ffc9245cef81022.png', 12, 2, 'ass', 2),
(8, 1, 'Fainal TEst eqiputment', 14, '06fbe67318b5019e1821348167a4fdb7.png', 23, 8, 'asadasdas', 2),
(9, 1, 'tes ff', 13, 'e5eb7a815f812b07c5af10a7b9100f32.png', 123, 12, 'asf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `projectcategory`
--

CREATE TABLE `projectcategory` (
  `pCatID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `pCatName` varchar(200) NOT NULL,
  `pCatDesc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectcategory`
--

INSERT INTO `projectcategory` (`pCatID`, `companyID`, `pCatName`, `pCatDesc`) VALUES
(3, 1, 'Manufacturing Building', 'manufactureing'),
(4, 1, 'Plubing', 'fixing pips');

-- --------------------------------------------------------

--
-- Table structure for table `projectequipmentassign`
--

CREATE TABLE `projectequipmentassign` (
  `assignID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `workforceID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `assignedQty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectequipmentassign`
--

INSERT INTO `projectequipmentassign` (`assignID`, `ProjectID`, `workforceID`, `equipmentID`, `assignedQty`) VALUES
(13, 1, 5, 9, 10),
(14, 1, 5, 8, 8),
(15, 5, 4, 9, 3),
(16, 5, 3, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `projectequipmentlink`
--

CREATE TABLE `projectequipmentlink` (
  `projectequipmentLinkID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `equipmentQTY` int(11) NOT NULL COMMENT 'totall quantity of equipment assigned to that project',
  `TotalAssignQTY` int(11) NOT NULL DEFAULT 0 COMMENT 'totall quantity assigned to workforce\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectequipmentlink`
--

INSERT INTO `projectequipmentlink` (`projectequipmentLinkID`, `equipmentID`, `ProjectID`, `equipmentQTY`, `TotalAssignQTY`) VALUES
(3, 8, 1, 8, 8),
(4, 7, 1, 2, 0),
(6, 9, 1, 3, 0),
(7, 9, 5, 9, 9),
(8, 6, 5, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `pCatID` int(11) NOT NULL,
  `pName` varchar(200) NOT NULL,
  `pLocation` varchar(500) NOT NULL,
  `pStartDate` date DEFAULT NULL,
  `pEndDate` date DEFAULT NULL,
  `pDesc` varchar(500) NOT NULL,
  `pImg1` varchar(200) DEFAULT NULL,
  `pImg2` varchar(200) DEFAULT NULL,
  `pImg3` varchar(200) DEFAULT NULL,
  `pImg4` varchar(200) DEFAULT NULL,
  `pImg5` varchar(200) DEFAULT NULL,
  `pImg6` varchar(200) DEFAULT NULL,
  `pImg7` varchar(200) DEFAULT NULL,
  `pImg8` varchar(200) DEFAULT NULL,
  `pImg9` varchar(200) DEFAULT NULL,
  `pImg10` varchar(200) DEFAULT NULL,
  `pStatus` tinyint(1) NOT NULL COMMENT '1=draft\r\n2=in process\r\n3=Delyed\r\n4=Completed',
  `pDraftStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '2=step 2\r\n3= step 3',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectID`, `companyID`, `pCatID`, `pName`, `pLocation`, `pStartDate`, `pEndDate`, `pDesc`, `pImg1`, `pImg2`, `pImg3`, `pImg4`, `pImg5`, `pImg6`, `pImg7`, `pImg8`, `pImg9`, `pImg10`, `pStatus`, `pDraftStatus`, `createdAt`) VALUES
(1, 1, 4, 'Plubbing is sahiwal', 'sahiwa;', '2025-09-27', '2025-09-30', 'fix tap', '68d66cd2cd7ef_1758883026.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, '2025-09-26 10:37:06'),
(2, 1, 4, 'Plubing in CCW', 'CCW', '2025-10-02', '2025-10-16', 'aaaa', '68d66d739c3ef_1758883187.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-09-26 10:39:47'),
(4, 1, 4, 'lahore plubbing', 'lh', '2025-10-30', '2025-11-07', 'fgh', '68d6b20ce38fc_1758900748.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-09-26 15:32:28'),
(5, 1, 3, 'Wood work', 'asfasf', '2025-09-30', '2025-10-01', 'aaa', '68ecad48f3f33_1760341320.png', '68ecad48f3f33_1760341320.jpg', '68ecad48f3f33_17603413201.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, '2025-10-13 07:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `projectworkforcelink`
--

CREATE TABLE `projectworkforcelink` (
  `projectWorkforceLinkID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `workforceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectworkforcelink`
--

INSERT INTO `projectworkforcelink` (`projectWorkforceLinkID`, `ProjectID`, `workforceID`) VALUES
(1, 1, 5),
(2, 5, 4),
(3, 5, 3),
(4, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skillID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `skillName` varchar(200) NOT NULL,
  `skillDesc` varchar(1200) NOT NULL,
  `skillStatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skillID`, `companyID`, `skillName`, `skillDesc`, `skillStatus`) VALUES
(2, 1, 'Plumber', 'Intermediate Plumberr', 1),
(6, 1, 'Genral Workerr', '5 year of experiecne', 1),
(11, 1, 'Test skill 2', 'tst descriptionssss', 1),
(17, 1, 'Genral Worker', 'asdasd', 1),
(18, 1, 'testtttttttttt', 'asdfas', 1),
(19, 1, 'Genral Workerrrrrrrrrrrr', 'asfdad', 1);

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
(1, 1, '4538', 'fRq59I2k', 1),
(2, 2, '3546', 'QljYHLTE', 1),
(4, 4, '9679', 'TkpN8fVj', 0),
(5, 5, '2637', 'DKdqycs5', 0),
(6, 6, '3167', 'e0np3Zds', 0),
(7, 7, '9373', 'LeBAoft5', 0),
(8, 8, '1993', 'cSvTpojm', 0),
(9, 9, '7211', 'ce2TEAtI', 1),
(10, 10, '6205', 'comWG3f5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usercompanyworkforcelink`
--

CREATE TABLE `usercompanyworkforcelink` (
  `userCompanyWorkforceLinkID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `workforceID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usercompanyworkforcelink`
--

INSERT INTO `usercompanyworkforcelink` (`userCompanyWorkforceLinkID`, `companyID`, `workforceID`, `userID`) VALUES
(1, 1, 1, 4),
(2, 1, 2, 5),
(3, 1, 3, 6),
(4, 1, 4, 7),
(5, 1, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userPhone` varchar(20) DEFAULT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPass` varchar(500) DEFAULT NULL,
  `userType` tinyint(1) NOT NULL COMMENT '1=SuperAdmin\r\n2=Company admin\r\n3=Company manager\r\n4=company employee\r\n5=General User',
  `userStatus` tinyint(1) NOT NULL COMMENT '1=active\r\n2=pending Auth\r\n0=blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userPhone`, `userEmail`, `userPass`, `userType`, `userStatus`) VALUES
(1, 'Company Admin', '03186205466', 'revotahir@gmail.com', '9f0a4484b933134d03e1c35ae9fb90b6', 2, 1),
(2, 'Company Admin', '030000022', '6xperts@gmail.com', '9f0a4484b933134d03e1c35ae9fb90b6', 2, 1),
(4, 'Person 1', '1232', 'creative.sol8264@gmail.com', NULL, 4, 2),
(5, 'person 3', '3423', 'revotahir@gmail.com', NULL, 4, 2),
(6, 'person 99', '2342', 'revotahir@gmail.com', NULL, 4, 2),
(7, 'person 994', '3443', 'creative.sol8264@gmail.c', NULL, 4, 2),
(8, 'per 5', '32323', 'per@gmail.com', NULL, 4, 2),
(9, 'tahir', '0300222112', 'fastimigration01@gmail.com', '86e916352d024f292f6ff0ae210acdfe', 2, 1),
(10, 'test', '03000000000', 'test@gmail.com', 'c93ccd78b2076528346216b3b2f701e6', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_blogs`
--

CREATE TABLE `web_blogs` (
  `web_blogID` int(11) NOT NULL,
  `web_blogImg` varchar(300) NOT NULL,
  `web_blogCat` varchar(50) NOT NULL,
  `web_blogDate` varchar(30) NOT NULL,
  `web_blogTitle` varchar(300) NOT NULL,
  `web_blogDesp` varchar(5000) NOT NULL,
  `web_blogDespSec` varchar(5000) NOT NULL,
  `web_blogStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active and 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_cat`
--

CREATE TABLE `web_cat` (
  `web_catID` int(11) NOT NULL,
  `web_catIcon` varchar(300) NOT NULL,
  `web_catName` varchar(30) NOT NULL,
  `web_catDesp` varchar(2000) NOT NULL,
  `web_catStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active and 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_company`
--

CREATE TABLE `web_company` (
  `web_companyID` int(11) NOT NULL,
  `web_companyIcon` varchar(300) NOT NULL,
  `web_companyStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 1=Active and 0=Deactive '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_success`
--

CREATE TABLE `web_success` (
  `web_successID` int(11) NOT NULL,
  `web_successIcon` varchar(300) NOT NULL,
  `web_successName` varchar(30) NOT NULL,
  `web_successDes` varchar(2000) NOT NULL,
  `web_successStatus` tinyint(1) NOT NULL COMMENT '1=Active and 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_testimonial`
--

CREATE TABLE `web_testimonial` (
  `web_testimonialID` int(11) NOT NULL,
  `web_testimonialRating` varchar(10) NOT NULL,
  `web_testimonialDesp` varchar(500) NOT NULL,
  `web_testimonialImg` varchar(300) NOT NULL,
  `web_testimonialName` varchar(30) NOT NULL,
  `web_testimonialLocation` varchar(30) NOT NULL,
  `web_testimonialStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active and 0=Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workforce`
--

CREATE TABLE `workforce` (
  `workforceID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `personName` varchar(150) NOT NULL,
  `personPhone` varchar(20) NOT NULL,
  `personEmail` varchar(150) NOT NULL,
  `personImg` varchar(500) DEFAULT NULL,
  `personAddInfo` varchar(1200) NOT NULL,
  `personStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Free 2= inuse '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workforce`
--

INSERT INTO `workforce` (`workforceID`, `companyID`, `personName`, `personPhone`, `personEmail`, `personImg`, `personAddInfo`, `personStatus`) VALUES
(1, 1, 'Asad', '1232', 'creative.sol8264@gmail.com', '2774e66d6df7a50c7d8f40938c6d8ae7.png', 'sdfsdfsd', 1),
(2, 1, 'Atif', '3423', 'revotahir@gmail.com', 'images.png', 'sdfsd', 2),
(3, 1, 'Tayyab', '2342', 'revotahir@gmail.c', 'images.png', 'sfdh', 2),
(4, 1, 'JB', '3443', 'creative.sol8264@gmail.c', '3625e21ed7b48855b4c5a9d4b1768401.png', 'gjg', 2),
(5, 1, 'Faisal', '32323', 'per@gmail.com', 'images.png', 'sdfsd', 2);

-- --------------------------------------------------------

--
-- Table structure for table `workforceskilllink`
--

CREATE TABLE `workforceskilllink` (
  `workforceSkillLinkID` int(11) NOT NULL,
  `skillID` int(11) NOT NULL,
  `workforceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workforceskilllink`
--

INSERT INTO `workforceskilllink` (`workforceSkillLinkID`, `skillID`, `workforceID`) VALUES
(4, 6, 2),
(5, 2, 2),
(20, 11, 3),
(21, 17, 4),
(22, 19, 1),
(23, 18, 1),
(24, 17, 1),
(25, 11, 1),
(26, 6, 1),
(27, 19, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companydetail`
--
ALTER TABLE `companydetail`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `equipcat`
--
ALTER TABLE `equipcat`
  ADD PRIMARY KEY (`equipCatID`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipmentID`);

--
-- Indexes for table `projectcategory`
--
ALTER TABLE `projectcategory`
  ADD PRIMARY KEY (`pCatID`);

--
-- Indexes for table `projectequipmentassign`
--
ALTER TABLE `projectequipmentassign`
  ADD PRIMARY KEY (`assignID`);

--
-- Indexes for table `projectequipmentlink`
--
ALTER TABLE `projectequipmentlink`
  ADD PRIMARY KEY (`projectequipmentLinkID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `projectworkforcelink`
--
ALTER TABLE `projectworkforcelink`
  ADD PRIMARY KEY (`projectWorkforceLinkID`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skillID`);

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
  ADD PRIMARY KEY (`authID`);

--
-- Indexes for table `usercompanyworkforcelink`
--
ALTER TABLE `usercompanyworkforcelink`
  ADD PRIMARY KEY (`userCompanyWorkforceLinkID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `web_blogs`
--
ALTER TABLE `web_blogs`
  ADD PRIMARY KEY (`web_blogID`);

--
-- Indexes for table `web_cat`
--
ALTER TABLE `web_cat`
  ADD PRIMARY KEY (`web_catID`);

--
-- Indexes for table `web_company`
--
ALTER TABLE `web_company`
  ADD PRIMARY KEY (`web_companyID`);

--
-- Indexes for table `web_success`
--
ALTER TABLE `web_success`
  ADD PRIMARY KEY (`web_successID`);

--
-- Indexes for table `web_testimonial`
--
ALTER TABLE `web_testimonial`
  ADD PRIMARY KEY (`web_testimonialID`);

--
-- Indexes for table `workforce`
--
ALTER TABLE `workforce`
  ADD PRIMARY KEY (`workforceID`);

--
-- Indexes for table `workforceskilllink`
--
ALTER TABLE `workforceskilllink`
  ADD PRIMARY KEY (`workforceSkillLinkID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companydetail`
--
ALTER TABLE `companydetail`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `equipcat`
--
ALTER TABLE `equipcat`
  MODIFY `equipCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projectcategory`
--
ALTER TABLE `projectcategory`
  MODIFY `pCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projectequipmentassign`
--
ALTER TABLE `projectequipmentassign`
  MODIFY `assignID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `projectequipmentlink`
--
ALTER TABLE `projectequipmentlink`
  MODIFY `projectequipmentLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projectworkforcelink`
--
ALTER TABLE `projectworkforcelink`
  MODIFY `projectWorkforceLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skillID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `authID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usercompanyworkforcelink`
--
ALTER TABLE `usercompanyworkforcelink`
  MODIFY `userCompanyWorkforceLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `web_blogs`
--
ALTER TABLE `web_blogs`
  MODIFY `web_blogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_cat`
--
ALTER TABLE `web_cat`
  MODIFY `web_catID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_company`
--
ALTER TABLE `web_company`
  MODIFY `web_companyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_success`
--
ALTER TABLE `web_success`
  MODIFY `web_successID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_testimonial`
--
ALTER TABLE `web_testimonial`
  MODIFY `web_testimonialID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workforce`
--
ALTER TABLE `workforce`
  MODIFY `workforceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workforceskilllink`
--
ALTER TABLE `workforceskilllink`
  MODIFY `workforceSkillLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
