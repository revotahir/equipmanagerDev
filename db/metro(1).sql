-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 02:38 PM
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
-- Database: `metro`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignproduct`
--

CREATE TABLE `assignproduct` (
  `assignID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL COMMENT '(UserID)',
  `productID` int(11) NOT NULL,
  `newPrice` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `assignproduct`
--

INSERT INTO `assignproduct` (`assignID`, `customerID`, `productID`, `newPrice`) VALUES
(3, 8, 1, '234'),
(4, 8, 2, '1000'),
(0, 17, 2, '1000'),
(0, 17, 3, '739'),
(0, 17, 1, '49'),
(0, 15, 1, '58'),
(0, 15, 2, '1000'),
(0, 15, 3, '800');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `vendorID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `checkoutID` int(11) DEFAULT NULL,
  `cartStatus` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending Checkout\r\n1=Checkout'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `customerID`, `vendorID`, `productID`, `quantity`, `price`, `checkoutID`, `cartStatus`) VALUES
(42, 17, 2, 2, '5', '1000', 4, 1),
(43, 17, 7, 1, '4', '49', 4, 1),
(45, 17, 13, 3, '2', '739', 4, 1),
(46, 17, 7, 1, '7', '49', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkoutID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `address2` varchar(1000) DEFAULT NULL,
  `country` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `addType` tinyint(1) NOT NULL COMMENT '1=delivery 2=pickup',
  `totalBill` varchar(100) NOT NULL,
  `addQuestions` varchar(1200) DEFAULT NULL,
  `checkoutDate` date NOT NULL DEFAULT current_timestamp(),
  `orderStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= In Process\r\n2=In Route\r\n3=Delivered\r\n4= Rescheduled\r\n5=Cancelled'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkoutID`, `customerID`, `address`, `address2`, `country`, `state`, `zip`, `addType`, `totalBill`, `addQuestions`, `checkoutDate`, `orderStatus`) VALUES
(4, 17, 'as', 'sd', 'United States', 'ds', 'd', 2, '6674', 'xs', '2025-03-30', 3),
(5, 17, 'test', 'tshjb', 'United States', 'bhjb', '877', 1, '343', ',n', '2025-03-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `catID` int(11) NOT NULL,
  `catName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`catID`, `catName`) VALUES
(1, 'Ivory Knapp'),
(2, 'Brian Taylor');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productName` varchar(200) NOT NULL,
  `productPrice` varchar(20) NOT NULL,
  `productCuisineItem` varchar(200) NOT NULL,
  `productCuisineUpc` varchar(200) NOT NULL,
  `productLength` varchar(200) NOT NULL,
  `productHeight` varchar(200) NOT NULL,
  `productWidth` varchar(200) NOT NULL,
  `productWeight` varchar(200) NOT NULL,
  `productDesp` varchar(2000) NOT NULL,
  `productImage` varchar(2000) NOT NULL,
  `productStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `catID`, `userID`, `productName`, `productPrice`, `productCuisineItem`, `productCuisineUpc`, `productLength`, `productHeight`, `productWidth`, `productWeight`, `productDesp`, `productImage`, `productStatus`) VALUES
(1, 2, 7, 'cake', '43.3', '', '', '', '', '', '', 'k', '', 1),
(2, 1, 2, 'Jillian Copeland', '932', 'Incidunt modi quia ', 'Accusamus ut in illu', '', '', '', '', 'Beatae sit optio ve', '', 1),
(3, 1, 13, 'Adrienne Guerra', '737', 'Qui aut laboris a ar', 'Distinctio Inventor', 'Delectus incididunt', 'Quia qui voluptatem ', 'Veniam aspernatur v', 'Proident ut laborum', 'Quia dolore consecte', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `userEmail` varchar(200) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userPass` varchar(200) NOT NULL,
  `userType` tinyint(1) NOT NULL COMMENT '1=admin 2=customer 3=vendor',
  `userStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `userPhone`, `userPass`, `userType`, `userStatus`) VALUES
(1, 'Admin', 'admin@admin.com', '03001234567', 'admin', 1, 1),
(2, 'Vendor', 'Vendor@Vendor.com', '03121122334', 'vendor', 3, 1),
(7, 'lina', 'xihuc@mailinator.com', '+1 (663) 641-2813', '(_jhIjuma#4Nc%D', 3, 1),
(8, 'Customerr', 'Customer@Customer.com', '03333333333', 'customer', 2, 1),
(13, 'wulejydyf', 'sowedykupy@mailinator.com', '+1 (722) 868-3239', 'zv5j+KUnCSbawL0', 3, 1),
(14, 'ziryd', 'rynocyf@mailinator.com', '+1 (716) 726-5622', '7ONj5kO1Kdrvjq&', 3, 1),
(15, 'lytyzaxo', 'kygesice@mailinator.com', '+1 (974) 664-4666', 'k0tfNv9i@77qbBC', 2, 1),
(17, 'Customer', 'customer@gmail.com', '030000000', 'customer', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkoutID`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkoutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
