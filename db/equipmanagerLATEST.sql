-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 09, 2026 at 07:39 AM
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
(4, 10, 'test'),
(5, 13, 'Test Company ');

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
  `equipRentalTotalQuantity` int(11) DEFAULT 0 COMMENT 'Total units available for rental',
  `equipRentalLockedQuantity` int(11) DEFAULT 0 COMMENT 'Units currently locked for approved rentals',
  `equipInUseQuantity` int(11) NOT NULL DEFAULT 0,
  `equipDesc` varchar(1000) NOT NULL,
  `equipStatus` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=inuse\r\n2=free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipmentID`, `companyID`, `equipName`, `equipCatID`, `equipImg`, `equipTotalQuantity`, `equipRentalTotalQuantity`, `equipRentalLockedQuantity`, `equipInUseQuantity`, `equipDesc`, `equipStatus`) VALUES
(4, 1, 'equip q', 12, 'bfe3d3b08e1ba3b51e1151299ccfb512.png', 13, 0, 0, 1, 'dd', 2),
(5, 1, 'equip q', 11, '3696c2e21a947e5fddd118cfc6b2bcd5.png', 102, 0, 0, 3, 'asda', 2),
(6, 1, 'Test Equipmr', 13, 'be70a14ffb476ada12462f6313759584.png', 4, 10, 9, 12, 'asfsdf', 2),
(7, 1, 'test qq', 12, 'f770faf201ed5e660ffc9245cef81022.png', 12, 0, 0, 0, 'ass', 2),
(8, 1, 'Fainal TEst eqiputment', 14, '06fbe67318b5019e1821348167a4fdb7.png', 23, 0, 0, 0, 'asadasdas', 2),
(9, 1, 'tes ff', 13, 'e5eb7a815f812b07c5af10a7b9100f32.png', 123, 0, 0, 0, 'asf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_payments`
--

CREATE TABLE `equipment_payments` (
  `equipmentPaymentID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL COMMENT 'FK to shopitem',
  `equipmentID` int(11) NOT NULL COMMENT 'FK to equipment',
  `buyerUserID` int(11) NOT NULL COMMENT 'FK to users',
  `sellerCompanyID` int(11) NOT NULL COMMENT 'FK to companydetail',
  `stripeSessionID` varchar(255) DEFAULT NULL,
  `stripePaymentIntentID` varchar(255) DEFAULT NULL,
  `grossAmount` decimal(10,2) NOT NULL COMMENT 'Total amount paid by customer',
  `commissionPercent` decimal(5,2) NOT NULL COMMENT 'Commission % at time of payment',
  `commissionAmount` decimal(10,2) NOT NULL COMMENT 'Calculated commission',
  `netAmount` decimal(10,2) NOT NULL COMMENT 'Amount to company after commission',
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `quantity` int(11) NOT NULL DEFAULT 1,
  `saleType` enum('rental','purchase') NOT NULL,
  `rentalStartDate` date DEFAULT NULL,
  `rentalEndDate` date DEFAULT NULL,
  `rentalType` enum('daily','weekly','monthly','yearly') DEFAULT NULL,
  `paymentStatus` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `orderStatus` enum('requested','approved','rejected','payment_pending','payment_secured','payment_approved','shipped','pickup_ready','delivered','completed','cancelled','refunded') DEFAULT 'requested',
  `rentalRequestStatus` enum('request_pending','request_approved','request_rejected','awaiting_handover','rental_active','rental_overdue','return_requested','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled') DEFAULT 'request_pending',
  `quantityLocked` int(11) DEFAULT 0 COMMENT 'Quantity locked for this rental when approved',
  `requestApprovedAt` timestamp NULL DEFAULT NULL,
  `requestApprovedBy` int(11) DEFAULT NULL COMMENT 'Company admin user ID who approved',
  `approvedBy` int(11) DEFAULT NULL COMMENT 'Admin userID who approved/rejected request',
  `approvedAt` timestamp NULL DEFAULT NULL COMMENT 'When seller approved/rejected',
  `rejectionReason` text DEFAULT NULL COMMENT 'Why seller rejected the request',
  `shippedBy` int(11) DEFAULT NULL COMMENT 'Admin userID who marked as shipped',
  `shippedAt` timestamp NULL DEFAULT NULL COMMENT 'When marked as shipped',
  `trackingNumber` varchar(255) DEFAULT NULL COMMENT 'Shipping tracking number',
  `shippingNotes` text DEFAULT NULL COMMENT 'Seller shipping notes',
  `deliveredBy` int(11) DEFAULT NULL COMMENT 'Buyer userID who confirmed receipt',
  `deliveredAt` timestamp NULL DEFAULT NULL COMMENT 'When buyer confirmed receipt',
  `fundsReleasedAt` timestamp NULL DEFAULT NULL COMMENT 'When funds transferred to seller',
  `cancelledBy` int(11) DEFAULT NULL COMMENT 'UserID who initiated cancellation',
  `cancelledAt` timestamp NULL DEFAULT NULL,
  `cancellationReason` text DEFAULT NULL,
  `refundAmount` decimal(10,2) DEFAULT NULL COMMENT 'Amount refunded (may differ from grossAmount)',
  `refundProcessedAt` timestamp NULL DEFAULT NULL,
  `stripeRefundID` varchar(255) DEFAULT NULL COMMENT 'Stripe refund transaction ID',
  `renterConfirmedReturn` tinyint(1) NOT NULL DEFAULT 0,
  `renterConfirmedAt` timestamp NULL DEFAULT NULL,
  `renterReturnNotes` text DEFAULT NULL,
  `ownerConfirmedReturn` tinyint(1) NOT NULL DEFAULT 0,
  `ownerConfirmedAt` timestamp NULL DEFAULT NULL,
  `ownerReturnNotes` text DEFAULT NULL COMMENT 'Condition notes, damages, etc.',
  `hasActiveIssue` tinyint(1) NOT NULL DEFAULT 0,
  `currentIssueID` int(11) DEFAULT NULL,
  `completedAt` timestamp NULL DEFAULT NULL COMMENT 'When transaction fully completed',
  `checkoutToken` varchar(64) DEFAULT NULL COMMENT 'Unique token for checkout link',
  `checkoutTokenExpiry` timestamp NULL DEFAULT NULL COMMENT 'When checkout link expires',
  `paymentMetadata` text DEFAULT NULL COMMENT 'JSON metadata',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_payments`
--

INSERT INTO `equipment_payments` (`equipmentPaymentID`, `itemID`, `equipmentID`, `buyerUserID`, `sellerCompanyID`, `stripeSessionID`, `stripePaymentIntentID`, `grossAmount`, `commissionPercent`, `commissionAmount`, `netAmount`, `currency`, `quantity`, `saleType`, `rentalStartDate`, `rentalEndDate`, `rentalType`, `paymentStatus`, `orderStatus`, `rentalRequestStatus`, `quantityLocked`, `requestApprovedAt`, `requestApprovedBy`, `approvedBy`, `approvedAt`, `rejectionReason`, `shippedBy`, `shippedAt`, `trackingNumber`, `shippingNotes`, `deliveredBy`, `deliveredAt`, `fundsReleasedAt`, `cancelledBy`, `cancelledAt`, `cancellationReason`, `refundAmount`, `refundProcessedAt`, `stripeRefundID`, `renterConfirmedReturn`, `renterConfirmedAt`, `renterReturnNotes`, `ownerConfirmedReturn`, `ownerConfirmedAt`, `ownerReturnNotes`, `hasActiveIssue`, `currentIssueID`, `completedAt`, `checkoutToken`, `checkoutTokenExpiry`, `paymentMetadata`, `createdAt`, `updatedAt`) VALUES
(28, 4, 5, 14, 1, NULL, NULL, 60.00, 4.50, 2.70, 57.30, 'USD', 3, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-02-14 05:16:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '349b0fa05db3a4749c9da14ddc6850791695b86c4c7a7d34ec17510aeb05bd43', '2026-02-21 05:16:27', '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-14 05:14:09', '2026-02-14 05:16:27'),
(29, 4, 5, 14, 1, NULL, 'pi_3T0f0cRvTgzTht4w06lkGF4L', 60.00, 4.50, 2.70, 57.30, 'USD', 3, 'purchase', NULL, NULL, NULL, 'pending', 'rejected', 'request_pending', 0, NULL, NULL, 1, '2026-02-20 12:45:01', 'Not interested', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid01@gmail.com\",\"customer_phone\":\"123123123\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-14 09:19:27', '2026-02-20 12:45:01'),
(30, 4, 5, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-14 06:21:21', '2026-02-14 06:21:21'),
(31, 4, 5, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-14 14:10:08', '2026-02-14 14:10:08'),
(32, 4, 5, 14, 1, NULL, 'pi_3T0z2pRvTgzTht4w0UzQnA4V', 40.00, 4.50, 1.80, 38.20, 'USD', 2, 'purchase', NULL, NULL, NULL, '', 'delivered', 'rental_active', 0, NULL, NULL, 1, '2026-02-15 02:41:30', NULL, 1, '2026-02-20 10:28:10', '1223', 'jb', 14, '2026-04-09 10:40:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '0bc83fe219d5f37d6046bfd3ed8dfee5a3e6328a5b0284b4564e6a25f99f3faa', '2026-02-22 02:41:30', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid01@gmail.com\",\"customer_phone\":\"123123123\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-15 02:35:01', '2026-04-09 10:40:33'),
(33, 4, 5, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 4, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-02-16 13:09:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '3e87b8ea90bf164229dddecb489bf0b4ce4b56a0e366664bc406c18ded92d74c', '2026-02-23 13:09:32', '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-15 09:12:02', '2026-02-16 13:09:32'),
(34, 4, 5, 10, 1, NULL, NULL, 240.00, 4.50, 10.80, 229.20, 'USD', 12, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:55:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'a58a64e5f82c390e03a2dc2302a5932ce15cecafe9c83ceb52b71d9c79fd174a', '2026-03-29 07:55:47', '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-16 13:15:38', '2026-03-22 07:55:47'),
(35, 4, 5, 14, 1, NULL, 'pi_3T1VVhRvTgzTht4w1gFPumsO', 100.00, 4.50, 4.50, 95.50, 'USD', 5, 'purchase', NULL, NULL, NULL, '', 'completed', 'request_pending', 0, NULL, NULL, 1, '2026-02-16 13:20:40', NULL, 1, '2026-02-20 08:43:38', '123', 'TEST', 14, '2026-02-20 11:59:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '2026-02-20 11:59:55', '7e9beddade7d8356caae0940710ec188bf9533c6196ae624c214ad16d91496ef', '2026-02-23 13:20:40', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-16 13:19:04', '2026-02-20 11:59:55'),
(36, 4, 5, 14, 1, NULL, 'pi_3T2xNdRvTgzTht4w0DLeVAh5', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, '', 'completed', 'request_pending', 0, NULL, NULL, 1, '2026-02-20 13:17:16', NULL, 1, '2026-02-20 13:21:28', '1234', 'shipped', 14, '2026-02-20 13:21:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '2026-02-20 13:21:49', 'f02ac241e4541ebdef7f25b7c4ad33cbc90031aa26e1130205f488c387b7b427', '2026-02-27 13:17:16', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-20 13:14:06', '2026-02-20 13:21:49'),
(37, 4, 5, 14, 1, NULL, 'pi_3T3bz4RvTgzTht4w1M0TZhTt', 100.00, 4.50, 4.50, 95.50, 'USD', 5, 'purchase', NULL, NULL, NULL, '', 'completed', 'request_pending', 0, NULL, NULL, 1, '2026-02-22 08:37:56', NULL, 1, '2026-02-22 08:42:24', '12345', 'shipped', 14, '2026-02-22 08:48:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '2026-02-22 08:48:44', '3bb84b53407e4fdce4979966edcfe51ad9f35211ff2b9be79b7e6e20ae483426', '2026-03-01 08:37:56', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-22 08:36:56', '2026-02-22 08:48:44'),
(38, 4, 5, 14, 1, NULL, 'pi_3T3mxaRvTgzTht4w0RgDh8Ug', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, '', 'pickup_ready', 'request_pending', 0, NULL, NULL, 1, '2026-02-22 11:56:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '8d266169040d361e15f32f38dd2c90c69e2a92372f8ff8b741c26b2bad317337', '2026-03-01 11:56:58', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"12345\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-22 10:45:16', '2026-02-23 14:15:18'),
(39, 4, 5, 14, 1, NULL, 'pi_3T3eDfRvTgzTht4w1BpHSr3h', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, '', 'payment_secured', 'request_pending', 0, NULL, NULL, 1, '2026-02-22 11:01:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '9d59a8749c7da9507b716d3c346c5f708dfb2543856944285e57a761dce3dc83', '2026-03-01 11:01:01', '{\"delivery_method\":2,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"Muhammad Ali Zahid\",\"delivery_street\":\"Village Gopal Pura, Manawan, G.T Road, Lahore.\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"alright\"}', '2026-02-22 10:56:17', '2026-02-22 15:05:20'),
(40, 4, 5, 14, 1, NULL, 'pi_3T40BARvTgzTht4w01QQ6NOE', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, '', 'completed', 'request_pending', 0, NULL, NULL, 1, '2026-02-23 10:23:51', NULL, 1, '2026-02-23 10:32:29', NULL, NULL, 14, '2026-02-23 10:48:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '2026-02-23 10:48:22', '8547481d6ab14068da8e744afa29833923c0f00b43c80e0b640824e22a0e844e', '2026-03-02 10:23:51', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-22 20:09:20', '2026-02-23 10:48:22'),
(41, 4, 5, 14, 1, NULL, 'pi_3T42LuRvTgzTht4w1LuhFyo9', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, '', 'completed', 'request_pending', 0, NULL, NULL, 1, '2026-02-23 12:50:44', NULL, 1, '2026-02-23 12:52:56', NULL, NULL, 14, '2026-02-23 12:53:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, '2026-02-23 12:53:06', '98c67fce44d2ee581a95f35c631c0b029a0fe3d70049bcdc74f4a2443226f124', '2026-03-02 12:50:44', '{\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-02-23 12:49:29', '2026-02-23 12:53:06'),
(42, 4, 5, 14, 1, NULL, NULL, 300.00, 4.50, 13.50, 286.50, 'USD', 3, 'rental', '2026-01-10', '2026-01-15', NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-15 22:29:57', '2026-03-15 22:29:57'),
(43, 4, 5, 14, 1, NULL, NULL, 40.00, 4.50, 1.80, 38.20, 'USD', 1, 'rental', '2026-01-08', '2026-01-10', NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-15 22:45:26', '2026-03-15 22:45:26'),
(44, 4, 5, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 2, 'rental', '2026-01-08', '2026-01-10', NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 13:36:57', '2026-03-17 13:36:57'),
(45, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 13:49:10', '2026-03-17 13:49:10'),
(46, 4, 5, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:30:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '625f92ea4bbbf1bfd5aca8c6f8a53d89f1f7ef5486e66effd62ffbc081413054', '2026-03-29 07:30:31', '{\"delivery_method\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 14:04:20', '2026-03-22 07:30:31'),
(47, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 14:14:20', '2026-03-17 14:14:20'),
(48, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 14:14:42', '2026-03-17 14:14:42'),
(49, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 14:17:08', '2026-03-17 14:17:08'),
(50, 4, 5, 14, 1, NULL, NULL, 120.00, 4.50, 5.40, 114.60, 'USD', 1, 'rental', '2026-01-09', '2026-01-15', NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 14:18:16', '2026-03-17 14:18:16'),
(54, 8, 6, 14, 1, NULL, NULL, 1090.00, 4.50, 44.55, 1045.45, 'USD', 9, 'rental', '2026-03-19', '2026-03-31', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-18 16:37:16', '2026-03-18 16:37:16'),
(55, 8, 6, 14, 1, NULL, NULL, 370.00, 4.50, 12.15, 357.85, 'USD', 9, 'rental', '2026-03-24', '2026-03-27', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-20 06:54:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '1c9b9892e3986625dce7cab1879ba46f84e394f35d53bdee877d1a8fdfdea1cf', '2026-03-27 06:54:02', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-18 16:37:41', '2026-03-20 06:54:02'),
(56, 8, 6, 14, 1, NULL, NULL, 740.00, 4.50, 28.80, 711.20, 'USD', 8, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-20 06:53:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'c82b44877e60662c47fddcfa67d612e458cdc020be2625bba805ac8157ce921d', '2026-03-27 06:53:41', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 08:16:24', '2026-03-20 06:53:41'),
(57, 8, 6, 14, 1, NULL, NULL, 160.00, 4.50, 2.70, 157.30, 'USD', 3, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-19 21:41:30', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '53ea5ca6dfcd5666c247ce5b2fba4171a5f063b670b2616cc30f6fa870293784', '2026-03-26 21:41:30', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 08:32:25', '2026-03-19 21:41:30'),
(58, 8, 6, 14, 1, NULL, NULL, 340.00, 4.50, 10.80, 329.20, 'USD', 3, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:41:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'ae343269ff7daeae2b3807bb99e31147bd5a32bb00d70f9523cae942a9959bc5', '2026-03-29 07:41:49', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 08:34:06', '2026-03-22 07:41:49'),
(59, 8, 6, 14, 1, NULL, NULL, 180.00, 4.50, 3.60, 176.40, 'USD', 4, 'rental', '2026-03-26', '2026-03-28', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:41:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'c03c877beca492731d2a9efbc0a78e72eb9797fcf9a2dba8d903a757dfd53395', '2026-03-29 07:41:43', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 11:45:33', '2026-03-22 07:41:43'),
(60, 8, 6, 14, 1, NULL, NULL, 380.00, 4.50, 12.60, 367.40, 'USD', 4, 'rental', '2026-03-19', '2026-03-26', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:45:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'c1b8525d5f3e35a974e7ba040b42579f30ed5e4238ebd0495efb9b4798f7da16', '2026-03-29 07:45:23', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 20:41:43', '2026-03-22 07:45:23'),
(61, 8, 6, 14, 1, NULL, NULL, 120.00, 4.50, 0.90, 119.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 20:50:50', '2026-03-19 20:50:50'),
(62, 8, 6, 14, 1, NULL, NULL, 120.00, 4.50, 0.90, 119.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 20:51:52', '2026-03-19 20:51:52'),
(63, 8, 6, 14, 1, NULL, NULL, 170.00, 4.50, 3.15, 166.85, 'USD', 1, 'rental', '2026-03-21', '2026-03-28', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 20:57:56', '2026-03-19 20:57:56'),
(64, 8, 6, 14, 1, NULL, NULL, 900.00, 4.50, 36.00, 864.00, 'USD', 10, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 20:59:49', '2026-03-19 20:59:49'),
(65, 8, 6, 14, 1, NULL, NULL, 190.00, 4.50, 4.05, 185.95, 'USD', 1, 'rental', '2026-03-19', '2026-03-28', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:03:09', '2026-03-19 21:03:09'),
(66, 8, 6, 14, 1, NULL, NULL, 130.00, 4.50, 1.35, 128.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:03:32', '2026-03-19 21:03:32'),
(67, 8, 6, 14, 1, NULL, NULL, 180.00, 4.50, 3.60, 176.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:04:21', '2026-03-19 21:04:21'),
(68, 8, 6, 14, 1, NULL, NULL, 120.00, 4.50, 0.90, 119.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:04:55', '2026-03-19 21:04:55'),
(69, 8, 6, 14, 1, NULL, NULL, 130.00, 4.50, 1.35, 128.65, 'USD', 1, 'rental', '2026-03-26', '2026-03-29', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:06:47', '2026-03-19 21:06:47'),
(70, 8, 6, 14, 1, NULL, NULL, 180.00, 4.50, 3.60, 176.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:08:34', '2026-03-19 21:08:34'),
(71, 8, 6, 14, 1, NULL, NULL, 130.00, 4.50, 1.35, 128.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-19 21:19:26', '2026-03-19 21:19:26'),
(72, 8, 6, 14, 1, NULL, NULL, 340.00, 4.50, 10.80, 329.20, 'USD', 8, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:56:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'b87d05580fbeced4a222ebc432f3dd3621fb849bea3bfe97ab1adeaadb428ace', '2026-03-29 07:56:57', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 02:38:59', '2026-03-22 07:56:57'),
(73, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 02:44:28', '2026-03-22 02:44:28'),
(74, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:56:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '16968984a45fa947d2b15e46cf820477da2314825d97bdd697cb3c6313040cd6', '2026-03-29 07:56:44', '{\"delivery_method\":1,\"delivery_charge\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 07:45:10', '2026-03-22 07:56:44'),
(75, 4, 5, 14, 1, NULL, NULL, 0.00, 4.50, 0.00, 0.00, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 07:56:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'f51d6a1881f675f5cd07d67bb8228457dc9a902b6120e58010ebf4971cd81753', '2026-03-29 07:56:49', '{\"delivery_method\":1,\"delivery_charge\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 07:56:26', '2026-03-22 07:56:49'),
(76, 4, 5, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 07:59:49', '2026-03-22 07:59:49'),
(77, 8, 6, 14, 1, NULL, 'pi_3TE4uhRvTgzTht4w1De73cta', 190.00, 4.50, 4.05, 185.95, 'USD', 3, 'rental', '2026-03-19', '2026-03-22', 'daily', '', 'payment_secured', 'request_pending', 0, NULL, NULL, 1, '2026-03-22 14:28:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'dfe8f7a825f5e18d744216787af215c6e64181ad713c78de2fc1208aa8bc0e99', '2026-03-29 14:28:49', '{\"delivery_method\":2,\"delivery_charge\":100,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"Muhammad Ali Zahid\",\"delivery_street\":\"Village Gopal Pura, Manawan, G.T Road, Lahore.\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"\"}', '2026-03-22 14:28:18', '2026-03-23 09:37:07'),
(78, 8, 6, 14, 1, NULL, NULL, 180.00, 4.50, 3.60, 176.40, 'USD', 4, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:35:13', '2026-03-22 14:35:13'),
(79, 8, 6, 14, 1, NULL, NULL, 220.00, 4.50, 5.40, 214.60, 'USD', 4, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:35:37', '2026-03-22 14:35:37'),
(80, 8, 6, 14, 1, NULL, NULL, 220.00, 4.50, 5.40, 214.60, 'USD', 4, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:36:13', '2026-03-22 14:36:13'),
(81, 8, 6, 14, 1, NULL, NULL, 120.00, 4.50, 0.90, 119.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:51:01', '2026-03-22 14:51:01'),
(82, 8, 6, 14, 1, NULL, NULL, 140.00, 4.50, 1.80, 138.20, 'USD', 2, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-23 05:48:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '17901e86c4cd89d6d2917fb6ed7b6e4e95babd79b4ac947d82b81378698e5b46', '2026-03-30 05:48:52', '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:51:35', '2026-03-23 05:48:52'),
(83, 8, 6, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-23 05:48:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '600daa8b22ef7a72049cf491a5352b2e3deee7f40784a608f0c846233728a688', '2026-03-30 05:48:57', '{\"delivery_method\":1,\"delivery_charge\":0,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-22 14:52:29', '2026-03-23 05:48:57'),
(84, 8, 6, 14, 1, NULL, NULL, 100.00, 4.50, 0.00, 100.00, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 06:55:28', '2026-03-23 06:55:28'),
(85, 8, 6, 14, 1, NULL, NULL, 100.00, 4.50, 0.00, 100.00, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"delivery_method\":1,\"delivery_charge\":100,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 06:55:42', '2026-03-23 06:55:42'),
(86, 8, 6, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"20.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:13:16', '2026-03-23 07:13:16'),
(87, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:15:13', '2026-03-23 07:15:13'),
(88, 8, 6, 14, 1, NULL, NULL, 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'rental', '2026-03-19', '2026-03-21', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"20.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:21:24', '2026-03-23 07:21:24'),
(89, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:21:45', '2026-03-23 07:21:45'),
(90, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'payment_pending', 'request_pending', 0, NULL, NULL, 1, '2026-03-23 07:26:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '5e922ea15ab470e647b4508102d1d859e111bc33ecc8b47e0008269f763b6295', '2026-03-30 07:26:49', '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:24:47', '2026-03-23 07:26:49'),
(91, 8, 6, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:27:36', '2026-03-23 07:27:36'),
(92, 8, 6, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-27', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:32:55', '2026-03-23 07:32:55'),
(93, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', 'pending', 'rejected', 'request_pending', 0, NULL, NULL, 1, '2026-04-07 13:08:11', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-23 07:33:05', '2026-04-07 13:08:11'),
(94, 8, 6, 14, 1, NULL, 'pi_3TE7mMRvTgzTht4w1ZBITL6p', 40.00, 4.50, 1.80, 38.20, 'USD', 1, 'rental', '2026-03-19', '2026-03-22', 'daily', '', 'completed', 'under_review', 0, NULL, NULL, 1, '2026-03-23 07:37:41', NULL, 1, '2026-03-23 08:54:45', NULL, NULL, 14, '2026-03-23 08:59:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 1, 2, '2026-03-23 08:59:06', '419e08a8ac3b4f5addfb171083d3005779d7dd964a3dc34df866241bb7d26b67', '2026-03-30 07:37:41', '{\"equipment_amount\":\"40.00\",\"delivery_amount\":\"100.00\",\"delivery_method\":2,\"customer_email\":\"muhammadalizahid01@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"Muhammad Ali Zahid\",\"delivery_street\":\"Garrison Garden Housing Scheme\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"\"}', '2026-03-23 07:35:37', '2026-03-23 10:59:45'),
(95, 8, 6, 14, 1, NULL, 'pi_3TEB3hRvTgzTht4w0X2k4i3q', 50.00, 4.50, 2.25, 47.75, 'USD', 1, 'rental', '2026-03-19', '2026-03-23', 'daily', '', 'delivered', 'under_review', 0, NULL, NULL, 1, '2026-03-23 12:09:20', NULL, 1, '2026-03-23 12:11:51', NULL, NULL, 14, '2026-03-23 12:12:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-23 12:17:03', '', 0, NULL, NULL, 1, 3, NULL, '1d7267b5f1a2b41d426e10c37f593f055266d33b4fd3f763ee89d66e0b0b3f3d', '2026-03-30 12:09:20', '{\"equipment_amount\":\"50.00\",\"delivery_amount\":\"100.00\",\"delivery_method\":2,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"Muhammad Ali Zahid\",\"delivery_street\":\"Village Gopal Pura, Manawan, G.T Road, Lahore.\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"\"}', '2026-03-23 12:09:01', '2026-03-23 12:17:52'),
(96, 8, 6, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-26', 'daily', 'pending', 'rejected', 'request_pending', 0, NULL, NULL, 1, '2026-04-04 15:16:27', 'adfsadf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-04 15:14:11', '2026-04-04 15:16:27'),
(97, 8, 6, 14, 1, NULL, 'pi_3TIYokRvTgzTht4w0Nfa8345', 180.00, 4.50, 3.60, 176.40, 'USD', 1, 'rental', '2026-03-19', '2026-03-26', 'daily', 'paid', 'completed', 'rental_completed', 0, '2026-04-04 15:19:00', 1, 1, '2026-04-04 15:19:00', NULL, 1, '2026-04-04 15:31:14', NULL, NULL, 14, '2026-04-04 15:31:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-04 15:32:08', '', 1, '2026-04-04 15:32:31', '', 1, 4, '2026-04-04 15:32:31', '84fa07aba65425a8d98a5a83790de120cf8528c89e9cff377c3dd8371f042c70', NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"100.00\",\"total_amount\":\"180.00\",\"delivery_method\":2,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"204-Muhammad Ali Zahid\",\"delivery_street\":\"Garrison Garden Housing Scheme\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"\"}', '2026-04-04 15:18:06', '2026-04-04 15:32:31'),
(98, 8, 6, 14, 1, NULL, NULL, 100.00, 4.50, 4.50, 95.50, 'USD', 1, 'rental', '2026-04-17', '2026-04-26', 'daily', 'pending', 'rejected', 'request_pending', 0, NULL, NULL, 1, '2026-04-04 15:33:49', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"100.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-04 15:33:04', '2026-04-04 15:33:49'),
(99, 8, 6, 14, 1, NULL, NULL, 150.00, 4.50, 6.75, 143.25, 'USD', 1, 'rental', '2026-04-12', '2026-04-26', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, '2026-04-04 15:42:27', 1, 1, '2026-04-04 15:42:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-04 15:42:43', 'asd', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '5768836661b70254419d7892041b59c17051d3dd95ad99e1a1c3eaa2d7d156e8', NULL, '{\"equipment_amount\":\"150.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-04 15:41:53', '2026-04-04 15:42:43'),
(100, 8, 6, 14, 1, NULL, NULL, 40.00, 4.50, 1.80, 38.20, 'USD', 1, 'rental', '2026-04-09', '2026-04-12', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 05:56:04', 'jn', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"40.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 05:55:44', '2026-04-09 05:56:04'),
(101, 8, 6, 14, 1, NULL, NULL, 40.00, 4.50, 1.80, 38.20, 'USD', 1, 'rental', '2026-04-09', '2026-04-12', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 05:57:10', 'dsfa', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"40.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 05:56:57', '2026-04-09 05:57:10'),
(102, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-04-17', '2026-04-19', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 05:58:32', 'asfd', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 05:58:10', '2026-04-09 05:58:32');
INSERT INTO `equipment_payments` (`equipmentPaymentID`, `itemID`, `equipmentID`, `buyerUserID`, `sellerCompanyID`, `stripeSessionID`, `stripePaymentIntentID`, `grossAmount`, `commissionPercent`, `commissionAmount`, `netAmount`, `currency`, `quantity`, `saleType`, `rentalStartDate`, `rentalEndDate`, `rentalType`, `paymentStatus`, `orderStatus`, `rentalRequestStatus`, `quantityLocked`, `requestApprovedAt`, `requestApprovedBy`, `approvedBy`, `approvedAt`, `rejectionReason`, `shippedBy`, `shippedAt`, `trackingNumber`, `shippingNotes`, `deliveredBy`, `deliveredAt`, `fundsReleasedAt`, `cancelledBy`, `cancelledAt`, `cancellationReason`, `refundAmount`, `refundProcessedAt`, `stripeRefundID`, `renterConfirmedReturn`, `renterConfirmedAt`, `renterReturnNotes`, `ownerConfirmedReturn`, `ownerConfirmedAt`, `ownerReturnNotes`, `hasActiveIssue`, `currentIssueID`, `completedAt`, `checkoutToken`, `checkoutTokenExpiry`, `paymentMetadata`, `createdAt`, `updatedAt`) VALUES
(103, 8, 6, 14, 1, NULL, NULL, 90.00, 4.50, 4.05, 85.95, 'USD', 1, 'rental', '2026-04-09', '2026-04-17', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 06:04:01', 'asdf', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"90.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 06:03:43', '2026-04-09 06:04:01'),
(104, 8, 6, 14, 1, NULL, NULL, 90.00, 4.50, 4.05, 85.95, 'USD', 1, 'rental', '2026-04-09', '2026-04-17', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 06:41:06', 'sadf', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"90.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 06:40:39', '2026-04-09 06:41:06'),
(105, 8, 6, 14, 1, NULL, 'pi_3TKFDIRvTgzTht4w1LHMR6fa', 50.00, 4.50, 2.25, 47.75, 'USD', 1, 'rental', '2026-04-14', '2026-04-18', 'daily', 'refunded', 'cancelled', 'rental_cancelled', 0, '2026-04-09 06:48:22', 1, 1, '2026-04-09 06:48:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-09 06:50:56', 'sdd', 50.00, '2026-04-09 06:50:56', 're_3TKFDIRvTgzTht4w1P1wEqZv', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'f7d69b68aa44f2bf9eeb55759e7db7ccf03b10316cb64edf68f0a9505fd5005c', NULL, '{\"equipment_amount\":\"50.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"50.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 06:41:49', '2026-04-09 06:50:56'),
(106, 8, 6, 14, 1, NULL, 'pi_3TKFbpRvTgzTht4w1Wi510Xf', 90.00, 4.50, 4.05, 85.95, 'USD', 1, 'rental', '2026-04-18', '2026-04-26', 'daily', 'paid', 'completed', 'rental_completed', 0, '2026-04-09 07:14:10', 1, 1, '2026-04-09 07:14:10', NULL, 1, '2026-04-09 07:15:37', NULL, NULL, 14, '2026-04-09 07:15:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-09 07:18:42', '', 1, '2026-04-09 07:18:55', 'Confirmed from orders list', 1, 5, '2026-04-09 07:18:55', '38f3bde274d55544a2fb688ab44e6c9348eef006fefc8d25e25c6ca922d20934', NULL, '{\"equipment_amount\":\"90.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"90.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 07:13:49', '2026-04-09 07:18:55'),
(107, 8, 6, 14, 1, NULL, NULL, 90.00, 4.50, 4.05, 85.95, 'USD', 1, 'rental', '2026-04-09', '2026-04-17', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, '2026-04-09 07:29:04', 1, 1, '2026-04-09 07:29:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 07:30:02', 'fds', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, '73ab47d4d2e76c229ce4d2d57866158c22a4aa08fa4894727d50fc6cd9018fc8', NULL, '{\"equipment_amount\":\"90.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 07:28:52', '2026-04-09 07:30:02'),
(108, 8, 6, 14, 1, NULL, 'pi_3TKL8URvTgzTht4w0NVDmRfh', 190.00, 4.50, 4.05, 185.95, 'USD', 1, 'rental', '2026-04-09', '2026-04-17', 'daily', 'paid', 'completed', 'rental_completed', 0, '2026-04-09 13:06:03', 1, 1, '2026-04-09 13:06:03', NULL, 1, '2026-04-09 13:18:17', NULL, NULL, 14, '2026-04-09 13:18:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-09 13:19:36', '', 1, '2026-04-09 13:20:03', 'Confirmed from orders list', 0, NULL, '2026-04-09 13:20:03', '509c0871b2cb61101d06194fe9ad35f0f781411b88b71f3a800368c9701a6541', NULL, '{\"equipment_amount\":\"90.00\",\"delivery_amount\":\"100.00\",\"total_amount\":\"190.00\",\"delivery_method\":2,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"204-Muhammad Ali Zahid\",\"delivery_street\":\"Garrison Garden Housing Scheme\",\"delivery_city\":\"Lahore\",\"delivery_postal\":\"53480\",\"delivery_country\":\"Pakistan\",\"delivery_notes\":\"\"}', '2026-04-09 13:04:34', '2026-04-09 13:20:03'),
(109, 8, 6, 14, 1, NULL, NULL, 80.00, 4.50, 3.60, 76.40, 'USD', 1, 'rental', '2026-04-12', '2026-04-19', 'daily', 'pending', 'cancelled', 'rental_cancelled', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2026-04-09 13:27:22', 'ASD', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 13:23:42', '2026-04-09 13:27:22'),
(110, 8, 6, 14, 1, NULL, 'pi_3TKLRvRvTgzTht4w0lH4PQND', 50.00, 4.50, 2.25, 47.75, 'USD', 1, 'rental', '2026-04-14', '2026-04-18', 'daily', 'refunded', 'cancelled', 'rental_cancelled', 0, '2026-04-09 13:28:05', 1, 1, '2026-04-09 13:28:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-09 13:29:38', 'TEST', 50.00, '2026-04-09 13:29:38', 're_3TKLRvRvTgzTht4w0Y4G1BQd', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'c00bdb66562cbea72b472c3b5ec7f8026437ded202426a32d43312f5353a8287', NULL, '{\"equipment_amount\":\"50.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"50.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 13:27:53', '2026-04-09 13:29:38'),
(111, 8, 6, 14, 1, NULL, 'pi_3TKLVgRvTgzTht4w0iQ13zVw', 80.00, 4.50, 3.60, 76.40, 'USD', 1, 'rental', '2026-04-17', '2026-04-24', 'daily', 'paid', 'delivered', 'rental_overdue', 0, '2026-04-09 13:32:12', 1, 1, '2026-04-09 13:32:12', NULL, 1, '2026-04-09 13:33:07', NULL, NULL, 14, '2026-04-09 13:33:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 1, 6, NULL, 'ed3a1998b581cb82a2892d550d7e4e6beab2b3571ec1bda4eb5c0b2159b0447b', NULL, '{\"equipment_amount\":\"80.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"80.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-09 13:31:34', '2026-04-29 07:39:47'),
(112, 4, 5, 14, 1, NULL, 'pi_3TP1FaRvTgzTht4w0hj4g1Yt', 20.00, 4.50, 0.90, 19.10, 'USD', 1, 'purchase', NULL, NULL, NULL, 'paid', 'payment_secured', 'request_pending', 0, NULL, NULL, 1, '2026-04-22 10:54:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 'eae948423f197715265486be599355f2f082cd145a0ccf4488dc1d7cc70318ce', '2026-04-29 10:54:25', '{\"equipment_amount\":\"20.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"20.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-22 10:53:54', '2026-04-22 13:55:38'),
(113, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-04-24', '2026-04-26', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-24 10:59:38', '2026-04-24 10:59:38'),
(114, 8, 6, 14, 1, NULL, NULL, 30.00, 4.50, 1.35, 28.65, 'USD', 1, 'rental', '2026-04-24', '2026-04-26', 'daily', 'pending', 'requested', 'request_pending', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '{\"equipment_amount\":\"30.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-24 10:59:38', '2026-04-24 10:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_payouts`
--

CREATE TABLE `equipment_payouts` (
  `equipmentPayoutID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) NOT NULL COMMENT 'FK to equipment_payments',
  `companyID` int(11) NOT NULL COMMENT 'FK to companydetail',
  `payoutAmount` decimal(10,2) NOT NULL COMMENT 'Net amount to be paid out',
  `payoutStatus` enum('pending','approved','released','rejected') NOT NULL DEFAULT 'pending',
  `approvedBy` int(11) DEFAULT NULL COMMENT 'SuperAdmin userID',
  `approvedAt` timestamp NULL DEFAULT NULL,
  `payoutNotes` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_payouts`
--

INSERT INTO `equipment_payouts` (`equipmentPayoutID`, `equipmentPaymentID`, `companyID`, `payoutAmount`, `payoutStatus`, `approvedBy`, `approvedAt`, `payoutNotes`, `createdAt`, `updatedAt`) VALUES
(4, 97, 1, 176.40, 'pending', NULL, NULL, NULL, '2026-04-04 18:32:31', '2026-04-04 18:32:31'),
(5, 106, 1, 85.95, 'pending', NULL, NULL, NULL, '2026-04-09 10:18:55', '2026-04-09 10:18:55'),
(6, 108, 1, 185.95, 'pending', NULL, NULL, NULL, '2026-04-09 16:20:03', '2026-04-09 16:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `notificationType` enum('rental_request_created','rental_approved','rental_rejected','rental_cancelled','rental_started','rental_overdue','rental_completed','payment_received','payment_released','issue_reported','issue_resolved','return_requested','return_confirmed','checkout_link_expiring','checkout_link_expired','review_requested','review_received') NOT NULL,
  `notificationTitle` varchar(255) NOT NULL,
  `notificationBody` text NOT NULL,
  `relatedOrderID` int(11) DEFAULT NULL,
  `relatedIssueID` int(11) DEFAULT NULL,
  `actionUrl` varchar(500) DEFAULT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `readAt` timestamp NULL DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationID`, `userID`, `notificationType`, `notificationTitle`, `notificationBody`, `relatedOrderID`, `relatedIssueID`, `actionUrl`, `isRead`, `readAt`, `createdAt`) VALUES
(1, 14, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 78, 1, 'http://localhost/equipmanager/orders/view/78', 1, '2026-04-04 15:40:42', '2026-03-23 10:52:52'),
(2, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 78, 1, 'http://localhost/equipmanager/orders/view/78', 0, NULL, '2026-03-23 10:52:52'),
(3, 1, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 78, 2, 'http://localhost/equipmanager/orders/view/78', 0, NULL, '2026-03-23 10:59:45'),
(4, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 78, 2, 'http://localhost/equipmanager/orders/view/78', 0, NULL, '2026-03-23 10:59:45'),
(5, 1, 'return_requested', 'Return Confirmed by Renter', 'The renter has confirmed the return. Please inspect the equipment and confirm receipt to complete the rental.', 79, NULL, 'http://localhost/equipmanager/company-orders', 0, NULL, '2026-03-23 12:17:03'),
(6, 14, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 79, 3, 'http://localhost/equipmanager/orders/view/79', 1, '2026-04-04 15:40:42', '2026-03-23 12:17:52'),
(7, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 79, 3, 'http://localhost/equipmanager/orders/view/79', 0, NULL, '2026-03-23 12:17:52'),
(8, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 80, NULL, 'http://localhost/equipmanager/company-orders/view/80', 0, NULL, '2026-04-04 15:14:11'),
(9, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 80, NULL, 'http://localhost/equipmanager/orders/80', 1, '2026-04-04 15:40:42', '2026-04-04 15:14:11'),
(10, 14, 'rental_rejected', '❌ Rental Request Rejected', 'Your rental request has been declined. Check the order chat for details.', 80, NULL, 'http://localhost/equipmanager/orders/80', 1, '2026-04-04 15:40:42', '2026-04-04 15:16:27'),
(11, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:18:06'),
(12, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:18:06'),
(13, 14, 'rental_approved', '✅ Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:19:00'),
(14, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:21:27'),
(15, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:21:27'),
(16, 14, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: late return). SuperAdmin will review.', 81, 4, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:27:58'),
(17, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: late return). SuperAdmin will review.', 81, 4, 'http://localhost/equipmanager/superadmin/issue_detail/4', 0, NULL, '2026-04-04 15:27:58'),
(18, 14, 'issue_resolved', '✅ Issue Resolved', 'The reported issue for your rental has been resolved by the platform administrator.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:30:03'),
(19, 1, 'issue_resolved', '✅ Issue Resolved', 'The reported issue for your rental has been resolved by the platform administrator.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:30:03'),
(20, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:31:29'),
(21, 14, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:31:29'),
(22, 1, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:32:08'),
(23, 14, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:32:08'),
(24, 14, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 81, NULL, 'http://localhost/equipmanager/orders/81', 1, '2026-04-04 15:40:42', '2026-04-04 15:32:31'),
(25, 1, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 81, NULL, 'http://localhost/equipmanager/company-orders/view/81', 0, NULL, '2026-04-04 15:32:31'),
(26, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 82, NULL, 'http://localhost/equipmanager/company-orders/view/82', 0, NULL, '2026-04-04 15:33:04'),
(27, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 82, NULL, 'http://localhost/equipmanager/orders/82', 1, '2026-04-04 15:40:42', '2026-04-04 15:33:04'),
(28, 14, 'rental_rejected', '❌ Rental Request Rejected', 'Your rental request has been declined. Check the order chat for details.', 82, NULL, 'http://localhost/equipmanager/orders/82', 1, '2026-04-04 15:40:42', '2026-04-04 15:33:49'),
(29, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 83, NULL, 'http://localhost/equipmanager/company-orders/view/83', 0, NULL, '2026-04-04 15:34:27'),
(30, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 83, NULL, 'http://localhost/equipmanager/orders/83', 1, '2026-04-04 15:40:42', '2026-04-04 15:34:27'),
(31, 14, 'rental_approved', '✅ Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 83, NULL, 'http://localhost/equipmanager/orders/83', 1, '2026-04-04 15:40:42', '2026-04-04 15:34:43'),
(32, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 83, NULL, 'http://localhost/equipmanager/orders/83', 1, '2026-04-04 15:40:42', '2026-04-04 15:38:41'),
(33, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 83, NULL, 'http://localhost/equipmanager/company-orders/view/83', 0, NULL, '2026-04-04 15:38:41'),
(34, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 83, NULL, 'http://localhost/equipmanager/company-orders/view/83', 0, NULL, '2026-04-04 15:39:20'),
(36, 1, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 83, NULL, 'http://localhost/equipmanager/company-orders/view/83', 0, NULL, '2026-04-04 15:39:28'),
(39, 1, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 83, NULL, 'http://localhost/equipmanager/company-orders/view/83', 0, NULL, '2026-04-04 15:39:37'),
(40, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 84, NULL, 'http://localhost/equipmanager/company-orders/view/84', 0, NULL, '2026-04-04 15:41:53'),
(41, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 84, NULL, 'http://localhost/equipmanager/orders/84', 0, NULL, '2026-04-04 15:41:53'),
(42, 14, 'rental_approved', '✅ Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 84, NULL, 'http://localhost/equipmanager/orders/84', 0, NULL, '2026-04-04 15:42:27'),
(43, 14, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 84, NULL, 'http://localhost/equipmanager/orders/84', 0, NULL, '2026-04-04 15:42:43'),
(44, 14, 'rental_rejected', 'Rental Request Rejected', 'Your rental request has been declined. Check the order chat for details.', 77, NULL, 'http://localhost/equipmanager/orders/77', 0, NULL, '2026-04-07 13:08:11'),
(45, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 85, NULL, 'http://localhost/equipmanager/company-orders/view/85', 0, NULL, '2026-04-09 05:55:44'),
(46, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 85, NULL, 'http://localhost/equipmanager/orders/85', 0, NULL, '2026-04-09 05:55:44'),
(47, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 85, NULL, 'http://localhost/equipmanager/company-orders/view/85', 0, NULL, '2026-04-09 05:56:07'),
(48, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 86, NULL, 'http://localhost/equipmanager/company-orders/view/86', 0, NULL, '2026-04-09 05:56:57'),
(49, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 86, NULL, 'http://localhost/equipmanager/orders/86', 0, NULL, '2026-04-09 05:56:57'),
(50, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 86, NULL, 'http://localhost/equipmanager/company-orders/view/86', 0, NULL, '2026-04-09 05:57:12'),
(51, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 87, NULL, 'http://localhost/equipmanager/company-orders/view/87', 0, NULL, '2026-04-09 05:58:10'),
(52, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 87, NULL, 'http://localhost/equipmanager/orders/87', 0, NULL, '2026-04-09 05:58:10'),
(53, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 87, NULL, 'http://localhost/equipmanager/company-orders/view/87', 0, NULL, '2026-04-09 05:58:34'),
(54, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 88, NULL, 'http://localhost/equipmanager/company-orders/view/88', 0, NULL, '2026-04-09 06:03:43'),
(55, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 88, NULL, 'http://localhost/equipmanager/orders/88', 0, NULL, '2026-04-09 06:03:43'),
(56, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 88, NULL, 'http://localhost/equipmanager/company-orders/view/88', 0, NULL, '2026-04-09 06:04:03'),
(57, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 89, NULL, 'http://localhost/equipmanager/company-orders/view/89', 0, NULL, '2026-04-09 06:40:39'),
(58, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 89, NULL, 'http://localhost/equipmanager/orders/89', 0, NULL, '2026-04-09 06:40:39'),
(59, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 89, NULL, 'http://localhost/equipmanager/company-orders/view/89', 0, NULL, '2026-04-09 06:41:08'),
(60, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 90, NULL, 'http://localhost/equipmanager/company-orders/view/90', 0, NULL, '2026-04-09 06:41:49'),
(61, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 90, NULL, 'http://localhost/equipmanager/orders/90', 0, NULL, '2026-04-09 06:41:49'),
(62, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 90, NULL, 'http://localhost/equipmanager/orders/90', 0, NULL, '2026-04-09 06:48:22'),
(63, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 90, NULL, 'http://localhost/equipmanager/orders/90', 0, NULL, '2026-04-09 06:49:34'),
(64, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 90, NULL, 'http://localhost/equipmanager/company-orders/view/90', 0, NULL, '2026-04-09 06:49:34'),
(65, 14, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 90, NULL, 'http://localhost/equipmanager/orders/90', 0, NULL, '2026-04-09 06:50:57'),
(66, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:13:49'),
(67, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:13:49'),
(68, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:14:10'),
(69, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:14:53'),
(70, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:14:53'),
(71, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:15:58'),
(72, 14, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:15:58'),
(73, 1, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 91, 5, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:16:27'),
(74, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 91, 5, 'http://localhost/equipmanager/superadmin/issue_detail/5', 0, NULL, '2026-04-09 07:16:27'),
(75, 14, 'issue_resolved', 'Issue Resolved', 'The reported issue for your rental has been resolved by the platform administrator.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:18:08'),
(76, 1, 'issue_resolved', 'Issue Resolved', 'The reported issue for your rental has been resolved by the platform administrator.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:18:08'),
(77, 1, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:18:42'),
(78, 14, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:18:42'),
(79, 14, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 91, NULL, 'http://localhost/equipmanager/orders/91', 0, NULL, '2026-04-09 07:18:56'),
(80, 1, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 91, NULL, 'http://localhost/equipmanager/company-orders/view/91', 0, NULL, '2026-04-09 07:18:56'),
(81, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 92, NULL, 'http://localhost/equipmanager/company-orders/view/92', 0, NULL, '2026-04-09 07:28:52'),
(82, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 92, NULL, 'http://localhost/equipmanager/orders/92', 0, NULL, '2026-04-09 07:28:52'),
(83, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 92, NULL, 'http://localhost/equipmanager/orders/92', 0, NULL, '2026-04-09 07:29:04'),
(84, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 92, NULL, 'http://localhost/equipmanager/company-orders/view/92', 0, NULL, '2026-04-09 07:30:04'),
(85, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 1, NULL, 'http://localhost/equipmanager/company-orders/view/1', 0, NULL, '2026-04-09 10:40:33'),
(86, 14, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 1, NULL, 'http://localhost/equipmanager/orders/1', 0, NULL, '2026-04-09 10:40:33'),
(87, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 93, NULL, 'http://localhost/equipmanager/company-orders/view/93', 0, NULL, '2026-04-09 13:04:34'),
(88, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:04:34'),
(89, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:06:03'),
(90, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:09:00'),
(91, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 93, NULL, 'http://localhost/equipmanager/company-orders/view/93', 0, NULL, '2026-04-09 13:09:00'),
(92, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 93, NULL, 'http://localhost/equipmanager/company-orders/view/93', 0, NULL, '2026-04-09 13:18:45'),
(93, 14, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:18:45'),
(94, 1, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 93, NULL, 'http://localhost/equipmanager/company-orders/view/93', 0, NULL, '2026-04-09 13:19:36'),
(95, 14, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:19:36'),
(96, 14, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 93, NULL, 'http://localhost/equipmanager/orders/93', 0, NULL, '2026-04-09 13:20:03'),
(97, 1, 'rental_completed', 'Rental Completed', 'The rental has been completed successfully. Both parties have confirmed the return.', 93, NULL, 'http://localhost/equipmanager/company-orders/view/93', 0, NULL, '2026-04-09 13:20:03'),
(98, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 94, NULL, 'http://localhost/equipmanager/company-orders/view/94', 0, NULL, '2026-04-09 13:23:42'),
(99, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 94, NULL, 'http://localhost/equipmanager/orders/94', 0, NULL, '2026-04-09 13:23:42'),
(100, 1, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 94, NULL, 'http://localhost/equipmanager/company-orders/view/94', 0, NULL, '2026-04-09 13:27:22'),
(101, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 95, NULL, 'http://localhost/equipmanager/company-orders/view/95', 0, NULL, '2026-04-09 13:27:53'),
(102, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 95, NULL, 'http://localhost/equipmanager/orders/95', 0, NULL, '2026-04-09 13:27:53'),
(103, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 95, NULL, 'http://localhost/equipmanager/orders/95', 0, NULL, '2026-04-09 13:28:05'),
(104, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 95, NULL, 'http://localhost/equipmanager/orders/95', 0, NULL, '2026-04-09 13:29:05'),
(105, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 95, NULL, 'http://localhost/equipmanager/company-orders/view/95', 0, NULL, '2026-04-09 13:29:05'),
(106, 14, 'rental_cancelled', 'Rental Cancelled', 'A rental has been cancelled.', 95, NULL, 'http://localhost/equipmanager/orders/95', 0, NULL, '2026-04-09 13:29:38'),
(107, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 96, NULL, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-09 13:31:34'),
(108, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-09 13:31:34'),
(109, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-09 13:32:12'),
(110, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-09 13:32:58'),
(111, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 96, NULL, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-09 13:32:58'),
(112, 1, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 96, NULL, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-09 13:33:20'),
(113, 14, 'payment_released', 'Escrow Funds Released', 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-09 13:33:20'),
(114, 1, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 96, 6, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-09 13:33:55'),
(115, 10, 'issue_reported', 'Issue Reported', 'An issue has been reported for this rental (Type: damaged). SuperAdmin will review.', 96, 6, 'http://localhost/equipmanager/superadmin/issue_detail/6', 0, NULL, '2026-04-09 13:33:55'),
(116, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 97, NULL, 'http://localhost/equipmanager/company-orders/view/97', 0, NULL, '2026-04-22 10:53:54'),
(117, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 97, NULL, 'http://localhost/equipmanager/orders/97', 0, NULL, '2026-04-22 10:53:54'),
(118, 14, 'rental_approved', 'Rental Approved', 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.', 97, NULL, 'http://localhost/equipmanager/orders/97', 0, NULL, '2026-04-22 10:54:25'),
(119, 14, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 97, NULL, 'http://localhost/equipmanager/orders/97', 0, NULL, '2026-04-22 10:55:38'),
(120, 1, 'payment_received', 'Payment Secured in Escrow', 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.', 97, NULL, 'http://localhost/equipmanager/company-orders/view/97', 0, NULL, '2026-04-22 10:55:38'),
(121, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 98, NULL, 'http://localhost/equipmanager/company-orders/view/98', 0, NULL, '2026-04-24 10:59:38'),
(122, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 98, NULL, 'http://localhost/equipmanager/orders/98', 0, NULL, '2026-04-24 10:59:38'),
(123, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 99, NULL, 'http://localhost/equipmanager/company-orders/view/99', 0, NULL, '2026-04-24 10:59:38'),
(124, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 99, NULL, 'http://localhost/equipmanager/orders/99', 0, NULL, '2026-04-24 10:59:38'),
(125, 1, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 100, NULL, 'http://localhost/equipmanager/company-orders/view/100', 0, NULL, '2026-04-24 11:00:51'),
(126, 14, 'rental_request_created', 'New Rental Request', 'You have received a new rental request. Review and approve or reject it from your orders dashboard.', 100, NULL, 'http://localhost/equipmanager/orders/100', 0, NULL, '2026-04-24 11:00:51'),
(127, 14, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-25 11:14:22'),
(128, 1, 'return_requested', 'Return Requested', 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.', 96, NULL, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-25 11:14:22'),
(129, 14, 'rental_overdue', 'Rental Overdue', 'This rental is past its end date. Please confirm the return immediately to avoid further issues.', 96, NULL, 'http://localhost/equipmanager/orders/96', 0, NULL, '2026-04-29 07:39:47'),
(130, 1, 'rental_overdue', 'Rental Overdue', 'This rental is past its end date. Please confirm the return immediately to avoid further issues.', 96, NULL, 'http://localhost/equipmanager/company-orders/view/96', 0, NULL, '2026-04-29 07:39:47'),
(131, 1, 'review_received', 'New Review Received', 'You received a new review on a completed transaction.', 8, NULL, 'http://localhost/equipmanager/company-orders/view/8', 0, NULL, '2026-04-30 03:55:10'),
(132, 1, 'review_received', 'New Review Received', 'You received a new review on a completed transaction.', 3, NULL, 'http://localhost/equipmanager/company-orders/view/3', 0, NULL, '2026-05-05 12:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) DEFAULT NULL,
  `workforcePaymentID` int(11) DEFAULT NULL,
  `invoiceVerifyToken` varchar(96) DEFAULT NULL COMMENT 'Opaque token for public invoice verification',
  `invoiceVerifyIssuedAt` timestamp NULL DEFAULT NULL COMMENT 'When invoice verification token was first generated',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `equipmentPaymentID`, `workforcePaymentID`, `invoiceVerifyToken`, `invoiceVerifyIssuedAt`, `createdAt`) VALUES
(1, 32, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(2, 35, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(3, 36, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(4, 37, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(5, 38, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(6, 39, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(7, 40, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(8, 41, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(9, 28, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(10, 29, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(11, 30, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(12, 31, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(13, 33, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(14, 34, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(15, 42, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(16, 43, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(17, 44, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(18, 45, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(19, 46, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(20, 47, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(21, 48, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(22, 49, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(23, 50, NULL, NULL, NULL, '2026-03-18 07:31:39'),
(32, NULL, 4, NULL, NULL, '2026-03-18 07:31:40'),
(33, NULL, 5, NULL, NULL, '2026-03-18 07:31:40'),
(34, NULL, 6, NULL, NULL, '2026-03-18 07:31:40'),
(35, NULL, 7, NULL, NULL, '2026-03-18 07:31:40'),
(36, NULL, 8, NULL, NULL, '2026-03-18 07:31:40'),
(40, 54, NULL, NULL, NULL, '2026-03-18 16:37:16'),
(41, 55, NULL, NULL, NULL, '2026-03-18 16:37:41'),
(42, 56, NULL, NULL, NULL, '2026-03-19 08:16:24'),
(43, 57, NULL, NULL, NULL, '2026-03-19 08:32:25'),
(44, 58, NULL, NULL, NULL, '2026-03-19 08:34:06'),
(45, 59, NULL, NULL, NULL, '2026-03-19 11:45:33'),
(46, 60, NULL, NULL, NULL, '2026-03-19 20:41:43'),
(47, 61, NULL, NULL, NULL, '2026-03-19 20:50:50'),
(48, 62, NULL, NULL, NULL, '2026-03-19 20:51:52'),
(49, 63, NULL, NULL, NULL, '2026-03-19 20:57:56'),
(50, 64, NULL, NULL, NULL, '2026-03-19 20:59:49'),
(51, 65, NULL, NULL, NULL, '2026-03-19 21:03:09'),
(52, 66, NULL, NULL, NULL, '2026-03-19 21:03:32'),
(53, 67, NULL, NULL, NULL, '2026-03-19 21:04:21'),
(54, 68, NULL, NULL, NULL, '2026-03-19 21:04:55'),
(55, 69, NULL, NULL, NULL, '2026-03-19 21:06:47'),
(56, 70, NULL, NULL, NULL, '2026-03-19 21:08:34'),
(57, 71, NULL, NULL, NULL, '2026-03-19 21:19:26'),
(58, 72, NULL, NULL, NULL, '2026-03-22 02:38:59'),
(59, 73, NULL, NULL, NULL, '2026-03-22 02:44:28'),
(60, 74, NULL, NULL, NULL, '2026-03-22 07:45:10'),
(61, 75, NULL, NULL, NULL, '2026-03-22 07:56:26'),
(62, 76, NULL, NULL, NULL, '2026-03-22 07:59:49'),
(63, 77, NULL, NULL, NULL, '2026-03-22 14:28:18'),
(64, 78, NULL, NULL, NULL, '2026-03-22 14:35:13'),
(65, 79, NULL, NULL, NULL, '2026-03-22 14:35:37'),
(66, 80, NULL, NULL, NULL, '2026-03-22 14:36:13'),
(67, 81, NULL, NULL, NULL, '2026-03-22 14:51:01'),
(68, 82, NULL, NULL, NULL, '2026-03-22 14:51:35'),
(69, 83, NULL, NULL, NULL, '2026-03-22 14:52:29'),
(70, 84, NULL, NULL, NULL, '2026-03-23 06:55:28'),
(71, 85, NULL, NULL, NULL, '2026-03-23 06:55:42'),
(72, 88, NULL, NULL, NULL, '2026-03-23 07:21:24'),
(73, 89, NULL, NULL, NULL, '2026-03-23 07:21:45'),
(74, 90, NULL, NULL, NULL, '2026-03-23 07:24:47'),
(75, 91, NULL, NULL, NULL, '2026-03-23 07:27:36'),
(76, 92, NULL, NULL, NULL, '2026-03-23 07:32:55'),
(77, 93, NULL, NULL, NULL, '2026-03-23 07:33:05'),
(78, 94, NULL, NULL, NULL, '2026-03-23 07:35:37'),
(79, 95, NULL, NULL, NULL, '2026-03-23 12:09:01'),
(80, 96, NULL, NULL, NULL, '2026-04-04 15:14:11'),
(81, 97, NULL, NULL, NULL, '2026-04-04 15:18:06'),
(82, 98, NULL, NULL, NULL, '2026-04-04 15:33:04'),
(83, NULL, 9, NULL, NULL, '2026-04-04 15:34:26'),
(84, 99, NULL, NULL, NULL, '2026-04-04 15:41:53'),
(85, 100, NULL, NULL, NULL, '2026-04-09 05:55:44'),
(86, 101, NULL, NULL, NULL, '2026-04-09 05:56:57'),
(87, 102, NULL, NULL, NULL, '2026-04-09 05:58:10'),
(88, 103, NULL, NULL, NULL, '2026-04-09 06:03:43'),
(89, 104, NULL, NULL, NULL, '2026-04-09 06:40:39'),
(90, 105, NULL, NULL, NULL, '2026-04-09 06:41:49'),
(91, 106, NULL, NULL, NULL, '2026-04-09 07:13:49'),
(92, 107, NULL, NULL, NULL, '2026-04-09 07:28:52'),
(93, 108, NULL, NULL, NULL, '2026-04-09 13:04:34'),
(94, 109, NULL, NULL, NULL, '2026-04-09 13:23:42'),
(95, 110, NULL, NULL, NULL, '2026-04-09 13:27:53'),
(96, 111, NULL, '69e79e7976f29848fdf10720395895ce78f98ca1340ddd20', '2026-04-25 11:16:18', '2026-04-09 13:31:34'),
(97, 112, NULL, 'f9ae76add98b6b4d025d0ac6a84e9cd573c67dad6088ebe4', '2026-04-22 10:56:13', '2026-04-22 10:53:54'),
(98, 113, NULL, NULL, NULL, '2026-04-24 10:59:38'),
(99, 114, NULL, NULL, NULL, '2026-04-24 10:59:38'),
(100, NULL, 10, NULL, NULL, '2026-04-24 11:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_chats`
--

CREATE TABLE `order_chats` (
  `chatID` int(11) NOT NULL,
  `orderID` int(11) DEFAULT NULL,
  `buyerUserID` int(11) NOT NULL COMMENT 'FK to users',
  `sellerCompanyID` int(11) NOT NULL COMMENT 'FK to companydetail',
  `chatStatus` enum('open','locked') NOT NULL DEFAULT 'open',
  `chatType` enum('standard','dispute') NOT NULL DEFAULT 'standard',
  `disputeIssueID` int(11) DEFAULT NULL,
  `superAdminJoinedAt` timestamp NULL DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lockedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_chats`
--

INSERT INTO `order_chats` (`chatID`, `orderID`, `buyerUserID`, `sellerCompanyID`, `chatStatus`, `chatType`, `disputeIssueID`, `superAdminJoinedAt`, `createdAt`, `lockedAt`) VALUES
(7, 9, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-14 05:14:09', NULL),
(8, 11, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-14 06:21:21', NULL),
(9, 12, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-14 14:10:08', NULL),
(10, 1, 14, 1, 'locked', 'standard', NULL, NULL, '2026-02-15 02:35:01', '2026-04-09 10:40:33'),
(11, 13, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-15 09:12:02', NULL),
(12, 14, 10, 1, 'open', 'standard', NULL, NULL, '2026-02-16 13:15:38', NULL),
(13, 2, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-16 13:19:04', NULL),
(14, 3, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-20 13:14:06', NULL),
(15, 4, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-22 08:36:56', NULL),
(16, 5, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-22 10:45:16', NULL),
(17, 6, 14, 1, 'open', 'standard', NULL, NULL, '2026-02-22 10:56:17', NULL),
(18, 7, 14, 1, 'locked', 'standard', NULL, NULL, '2026-02-22 20:09:21', '2026-02-23 10:48:22'),
(19, 8, 14, 1, 'locked', 'standard', NULL, NULL, '2026-02-23 12:49:29', '2026-02-23 12:53:06'),
(20, 15, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-15 22:29:57', NULL),
(21, 16, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-15 22:45:26', NULL),
(22, 17, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 13:36:57', NULL),
(23, 18, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 13:49:10', NULL),
(24, 19, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:04:20', NULL),
(25, 20, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:14:20', NULL),
(26, 21, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:14:42', NULL),
(27, 22, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:17:08', NULL),
(28, 23, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:18:16', NULL),
(29, NULL, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:42:50', NULL),
(30, NULL, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:43:39', NULL),
(31, NULL, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:49:32', NULL),
(32, NULL, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 14:51:31', NULL),
(33, 36, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-17 16:14:17', NULL),
(34, 51, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-18 16:21:58', NULL),
(35, 39, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-18 16:31:43', NULL),
(36, 40, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-18 16:37:16', NULL),
(37, 41, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-18 16:37:41', NULL),
(38, 42, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 08:16:24', NULL),
(39, 43, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 08:32:25', NULL),
(40, 44, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 08:34:06', NULL),
(41, 45, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 11:45:33', NULL),
(42, 46, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 20:41:43', NULL),
(43, 47, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 20:50:50', NULL),
(44, 48, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 20:51:52', NULL),
(45, 49, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 20:57:56', NULL),
(46, 50, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 20:59:49', NULL),
(47, 52, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:03:32', NULL),
(48, 53, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:04:21', NULL),
(49, 54, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:04:55', NULL),
(50, 55, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:06:47', NULL),
(51, 56, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:08:34', NULL),
(52, 57, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-19 21:19:26', NULL),
(53, 58, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 02:38:59', NULL),
(54, 59, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 02:44:29', NULL),
(55, 60, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 07:45:10', NULL),
(56, 61, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 07:56:26', NULL),
(57, 62, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 07:59:49', NULL),
(58, 63, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:28:18', NULL),
(59, 64, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:35:13', NULL),
(60, 65, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:35:37', NULL),
(61, 66, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:36:13', NULL),
(62, 67, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:51:01', NULL),
(63, 68, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:51:35', NULL),
(64, 69, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-22 14:52:29', NULL),
(65, 70, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 06:55:28', NULL),
(66, 71, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 06:55:42', NULL),
(67, 86, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 07:13:16', '2026-04-09 05:57:10'),
(68, 87, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 07:15:13', '2026-04-09 05:58:32'),
(69, 88, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 07:21:24', '2026-04-09 06:04:01'),
(70, 89, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 07:21:45', '2026-04-09 06:41:06'),
(71, 74, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 07:24:47', NULL),
(72, 75, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 07:27:36', NULL),
(73, 76, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 07:32:55', NULL),
(74, 77, 14, 1, 'open', 'standard', NULL, NULL, '2026-03-23 07:33:05', NULL),
(75, 78, 14, 1, 'locked', 'dispute', 2, '2026-03-23 10:59:45', '2026-03-23 07:35:37', '2026-03-23 08:59:06'),
(76, 94, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 08:40:26', '2026-04-09 13:27:22'),
(77, 79, 14, 1, 'locked', 'dispute', 3, '2026-03-23 12:17:52', '2026-03-23 12:09:01', '2026-03-23 12:12:03'),
(78, 95, 14, 1, 'locked', 'standard', NULL, NULL, '2026-03-23 12:10:34', '2026-04-09 13:29:38'),
(79, 80, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-04 15:14:11', NULL),
(80, 81, 14, 1, 'locked', 'dispute', 4, '2026-04-04 15:27:58', '2026-04-04 15:18:06', '2026-04-04 15:31:29'),
(81, 82, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-04 15:33:04', NULL),
(82, 83, 14, 1, 'locked', 'standard', NULL, NULL, '2026-04-04 15:34:26', '2026-04-04 15:39:20'),
(83, 84, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-04 15:41:53', NULL),
(84, 85, 14, 1, 'locked', 'standard', NULL, NULL, '2026-04-09 05:55:44', '2026-04-09 05:56:05'),
(85, 90, 14, 1, 'locked', 'standard', NULL, NULL, '2026-04-09 06:41:49', '2026-04-09 06:50:56'),
(86, 91, 14, 1, 'open', 'dispute', 5, '2026-04-09 07:16:27', '2026-04-09 07:13:49', NULL),
(87, 92, 14, 1, 'locked', 'standard', NULL, NULL, '2026-04-09 07:28:52', '2026-04-09 07:30:02'),
(88, 93, 14, 1, 'locked', 'standard', NULL, NULL, '2026-04-09 13:04:34', '2026-04-09 13:18:45'),
(89, 96, 14, 1, 'open', 'dispute', 6, '2026-04-09 13:33:55', '2026-04-09 13:31:34', NULL),
(90, 97, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-22 10:53:54', NULL),
(91, 98, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-24 10:59:38', NULL),
(92, 99, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-24 10:59:38', NULL),
(93, 100, 14, 1, 'open', 'standard', NULL, NULL, '2026-04-24 11:00:51', NULL),
(94, NULL, 16, 1, 'open', 'standard', NULL, NULL, '2026-05-09 02:23:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_chat_messages`
--

CREATE TABLE `order_chat_messages` (
  `messageID` int(11) NOT NULL,
  `chatID` int(11) NOT NULL COMMENT 'FK to order_chats',
  `senderUserID` int(11) NOT NULL COMMENT 'FK to users',
  `messageText` varchar(2500) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_chat_messages`
--

INSERT INTO `order_chat_messages` (`messageID`, `chatID`, `senderUserID`, `messageText`, `createdAt`) VALUES
(28, 7, 14, 'hello I have ordered 3 pieces', '2026-02-14 05:15:20'),
(29, 7, 1, 'yes we are looking into it', '2026-02-14 05:15:37'),
(30, 7, 14, 'alright waiting for approval', '2026-02-14 05:15:47'),
(31, 7, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/349b0fa05db3a4749c9da14ddc6850791695b86c4c7a7d34ec17510aeb05bd43\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-14 05:16:27'),
(32, 7, 1, 'done', '2026-02-14 05:16:53'),
(33, 8, 1, 'hwy', '2026-02-14 11:29:02'),
(34, 9, 1, 'hey', '2026-02-14 14:20:59'),
(35, 9, 1, 'Hey', '2026-02-15 01:40:44'),
(36, 9, 1, 'Hi', '2026-02-15 01:40:45'),
(37, 10, 14, 'hey', '2026-02-15 02:36:25'),
(38, 10, 1, 'Hey', '2026-02-15 02:38:06'),
(39, 10, 1, 'are you interested in the order?', '2026-02-15 02:38:14'),
(40, 10, 14, 'Yes approve the request', '2026-02-15 02:40:29'),
(41, 10, 1, 'ok', '2026-02-15 02:40:47'),
(42, 10, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/0bc83fe219d5f37d6046bfd3ed8dfee5a3e6328a5b0284b4564e6a25f99f3faa\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-15 02:41:30'),
(43, 10, 1, 'Payment received and secured in escrow!\n\nOrder #32\nAmount: $40.00\n\n⚠️ Funds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-15 02:43:29'),
(44, 11, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3e87b8ea90bf164229dddecb489bf0b4ce4b56a0e366664bc406c18ded92d74c\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-16 13:09:32'),
(45, 12, 10, 'hey', '2026-02-16 13:16:19'),
(46, 12, 1, 'Hey', '2026-02-16 13:18:12'),
(47, 13, 14, 'hey', '2026-02-16 13:19:08'),
(48, 13, 1, 'hey', '2026-02-16 13:20:04'),
(49, 13, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/7e9beddade7d8356caae0940710ec188bf9533c6196ae624c214ad16d91496ef\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-16 13:20:40'),
(50, 13, 1, 'Payment received and secured in escrow!\n\nOrder #35\nAmount: $100.00\n\n⚠️ Funds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-16 13:23:22'),
(51, 13, 1, 'Your order has been shipped!\n\nOrder #35\nTracking Number: 123\n\nShipping Notes:\nTEST\n\n✅ Once you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-02-20 08:43:38'),
(52, 10, 1, 'Your order has been shipped!\n\nOrder #32\nTracking Number: 1223\n\nShipping Notes:\njb\n\n✅ Once you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-02-20 10:28:10'),
(53, 13, 1, '✅ Delivery Confirmed!\n\nOrder #35\nThe buyer has confirmed receipt of the product.\n\n Funds are being released to your account now.\n\nThank you for your business!', '2026-02-20 11:59:55'),
(54, 13, 1, '✅ Thank you for confirming delivery!\n\nOrder #35\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-02-20 11:59:55'),
(55, 14, 14, 'hey', '2026-02-20 13:16:34'),
(56, 14, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/f02ac241e4541ebdef7f25b7c4ad33cbc90031aa26e1130205f488c387b7b427\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-20 13:17:16'),
(57, 14, 1, 'Payment received and secured in escrow!\n\nOrder #36\nAmount: $20.00\n\n⚠️ Funds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-20 13:21:01'),
(58, 14, 1, 'Your order has been shipped!\n\nOrder #36\nTracking Number: 1234\n\nShipping Notes:\nshipped\n\n✅ Once you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-02-20 13:21:28'),
(59, 14, 1, '✅ Delivery Confirmed!\n\nOrder #36\nThe buyer has confirmed receipt of the product.\n\n Funds are being released to your account now.\n\nThank you for your business!', '2026-02-20 13:21:49'),
(60, 14, 1, '✅ Thank you for confirming delivery!\n\nOrder #36\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-02-20 13:21:49'),
(61, 15, 14, 'hey', '2026-02-22 08:37:18'),
(62, 15, 1, '✅ Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3bb84b53407e4fdce4979966edcfe51ad9f35211ff2b9be79b7e6e20ae483426\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-22 08:37:56'),
(63, 15, 1, 'Payment received and secured in escrow!\n\nOrder #37\nAmount: $100.00\n\n⚠️ Funds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-22 08:42:07'),
(64, 15, 1, 'Your order has been shipped!\n\nOrder #37\nTracking Number: 12345\n\nShipping Notes:\nshipped\n\n✅ Once you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-02-22 08:42:24'),
(65, 15, 1, 'Delivery Confirmed!\n\nOrder #37\nThe buyer has confirmed receipt of the product.\n\n Funds are being released to your account now.\n\nThank you for your business!', '2026-02-22 08:48:44'),
(66, 15, 1, 'Thank you for confirming delivery!\n\nOrder #37\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-02-22 08:48:44'),
(67, 16, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-02-22 10:45:16'),
(68, 17, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-02-22 10:56:17'),
(69, 17, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttps://superindulgent-jaylynn-sievelike.ngrok-free.dev/equipmanager/checkout/pay/9d59a8749c7da9507b716d3c346c5f708dfb2543856944285e57a761dce3dc83\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-22 11:01:01'),
(70, 17, 1, 'Payment received and secured in escrow!\n\nOrder #39\nAmount: $20.00\n\nFunds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-22 11:05:20'),
(71, 16, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/8d266169040d361e15f32f38dd2c90c69e2a92372f8ff8b741c26b2bad317337\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-22 11:56:58'),
(72, 18, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-02-22 20:09:21'),
(73, 18, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/35016785fea70ede1ad952f704def13986489b7b5c373d9add90a89f1a58c964\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-22 20:10:00'),
(74, 18, 1, 'Payment received and secured in escrow!\n\nOrder #40\nAmount: $20.00\n\nFunds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-22 20:10:57'),
(75, 18, 1, 'Your order is ready for pickup!\n\nOrder #40\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-02-22 20:11:31'),
(76, 16, 1, 'Payment received and secured in escrow!\n\nOrder #38\nAmount: $20.00\n\nFunds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-22 20:25:32'),
(77, 18, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/8547481d6ab14068da8e744afa29833923c0f00b43c80e0b640824e22a0e844e\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-23 10:23:51'),
(78, 18, 1, 'Payment received and secured in escrow!\n\nOrder #40\nAmount: $20.00\n\nFunds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-23 10:32:13'),
(79, 18, 1, 'Your order is ready for pickup!\n\nOrder #40\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-02-23 10:32:29'),
(80, 18, 1, 'Pickup Confirmed!\n\nOrder #40\nThe buyer has collected the item.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-02-23 10:48:22'),
(81, 18, 1, 'Thank you for confirming pickup!\n\nOrder #40\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-02-23 10:48:22'),
(82, 19, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-02-23 12:49:29'),
(83, 19, 1, 'ok', '2026-02-23 12:50:23'),
(84, 19, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/98c67fce44d2ee581a95f35c631c0b029a0fe3d70049bcdc74f4a2443226f124\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-02-23 12:50:44'),
(85, 19, 1, 'Payment received and secured in escrow!\n\nOrder #41\nAmount: $20.00\n\nFunds will be held until the buyer confirms receipt of the product.\n\nPlease ship the product and mark the order as \'Shipped\' in your dashboard.', '2026-02-23 12:51:38'),
(86, 19, 1, 'Your order is ready for pickup!\n\nOrder #41\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-02-23 12:52:56'),
(87, 19, 1, 'Pickup Confirmed!\n\nOrder #41\nThe buyer has collected the item.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-02-23 12:53:06'),
(88, 19, 1, 'Thank you for confirming pickup!\n\nOrder #41\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-02-23 12:53:06'),
(89, 20, 14, 'New Order Request\n\nItem: equip q\nType: Rental (Equipment)\nQuantity: 3\nTotal: $300.00\nRental Period: 2026-01-10 to 2026-01-15\n\nPlease review and approve my order request.', '2026-03-15 22:29:57'),
(90, 21, 14, 'New Order Request\n\nItem: equip q\nType: Rental (Equipment)\nQuantity: 1\nTotal: $40.00\nRental Period: 2026-01-08 to 2026-01-10\n\nPlease review and approve my order request.', '2026-03-15 22:45:26'),
(91, 22, 14, 'New Order Request\n\nItem: equip q\nType: Rental (Equipment)\nQuantity: 2\nTotal: $80.00\nRental Period: 2026-01-08 to 2026-01-10\n\nPlease review and approve my order request.', '2026-03-17 13:36:57'),
(92, 23, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-17 13:49:10'),
(93, 24, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-03-17 14:04:20'),
(94, 25, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-17 14:14:20'),
(95, 26, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-17 14:14:42'),
(96, 27, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-17 14:17:08'),
(97, 28, 14, 'New Order Request\n\nItem: equip q\nType: Rental (Equipment)\nQuantity: 1\nTotal: $120.00\nRental Period: 2026-01-09 to 2026-01-15\n\nPlease review and approve my order request.', '2026-03-17 14:18:16'),
(98, 29, 14, 'New Order Request\n\nItem: Asad\nType: Rental (Workforce)\nQuantity: 1\nTotal: $648.00\nRental Period: 2026-01-01 to 2026-01-03\n\nPlease review and approve my order request.', '2026-03-17 14:42:50'),
(99, 30, 14, 'New Order Request\n\nItem: Asad\nType: Rental (Workforce)\nQuantity: 1\nTotal: $648.00\nRental Period: 2026-01-01 to 2026-01-03\n\nPlease review and approve my order request.', '2026-03-17 14:43:39'),
(100, 31, 14, 'New Order Request\n\nItem: Asad\nType: Rental (Workforce)\nQuantity: 1\nTotal: $648.00\nRental Period: 2026-01-05 to 2026-01-07\n\nPlease review and approve my order request.', '2026-03-17 14:49:32'),
(101, 32, 14, 'New Order Request\n\nItem: Asad\nType: Rental (Workforce)\nQuantity: 1\nTotal: $648.00\nRental Period: 2026-01-01 to 2026-01-03\n\nPlease review and approve my order request.', '2026-03-17 14:51:31'),
(102, 28, 14, 'hey', '2026-03-17 15:09:03'),
(103, 28, 14, 'hey', '2026-03-17 16:13:46'),
(104, 33, 14, 'New Order Request\n\nItem: Asad\nType: Rental (Workforce)\nQuantity: 1\nTotal: $648.00\nRental Period: 2026-01-01 to 2026-01-03\n\nPlease review and approve my order request.', '2026-03-17 16:14:17'),
(105, 33, 14, 'hey', '2026-03-17 16:14:22'),
(106, 33, 14, 'hey', '2026-03-17 16:19:42'),
(107, 33, 14, 'how are you', '2026-03-17 16:19:53'),
(108, 33, 1, 'hell', '2026-03-18 04:22:26'),
(109, 33, 1, 'o', '2026-03-18 04:22:27'),
(110, 33, 1, 'hehe', '2026-03-18 04:22:29'),
(111, 33, 1, 'hi', '2026-03-18 04:22:39'),
(112, 33, 1, 'hi', '2026-03-18 04:22:42'),
(113, 33, 1, 'hi', '2026-03-18 04:22:44'),
(114, 33, 1, 'hi', '2026-03-18 04:22:45'),
(115, 33, 1, 'hi', '2026-03-18 04:22:45'),
(116, 34, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 9\nTotal: $1,000.00\nRental Period: 2026-03-19 to 2026-03-29\n\nPlease review and approve my order request.', '2026-03-18 16:21:58'),
(117, 34, 14, 'hey', '2026-03-18 16:22:02'),
(118, 35, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 3\nTotal: $340.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-18 16:31:43'),
(119, 36, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 9\nTotal: $1,090.00\nRental Period: 2026-03-19 to 2026-03-31\n\nPlease review and approve my order request.', '2026-03-18 16:37:16'),
(120, 37, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 9\nTotal: $370.00\nRental Period: 2026-03-24 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-18 16:37:41'),
(121, 38, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 8\nTotal: $740.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-19 08:16:24'),
(122, 39, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 3\nTotal: $160.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-19 08:32:25'),
(123, 40, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 3\nTotal: $340.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-19 08:34:06'),
(124, 41, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 4\nTotal: $180.00\nRental Period: 2026-03-26 to 2026-03-28\n\nPlease review and approve my order request.', '2026-03-19 11:45:33'),
(125, 42, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 4\nTotal: $380.00\nRental Period: 2026-03-19 to 2026-03-26\n\nPlease review and approve my order request.', '2026-03-19 20:41:43'),
(126, 43, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $120.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-19 20:50:50'),
(127, 44, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $120.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-19 20:51:52'),
(128, 45, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $170.00\nRental Period: 2026-03-21 to 2026-03-28\n\nPlease review and approve my order request.', '2026-03-19 20:57:57'),
(129, 46, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 10\nTotal: $900.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-19 20:59:49'),
(130, 34, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $190.00\nRental Period: 2026-03-19 to 2026-03-28\n\nPlease review and approve my order request.', '2026-03-19 21:03:09'),
(131, 47, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $130.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-19 21:03:32'),
(132, 48, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $180.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-19 21:04:21'),
(133, 49, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $120.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-19 21:04:55'),
(134, 50, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $130.00\nRental Period: 2026-03-26 to 2026-03-29\n\nPlease review and approve my order request.', '2026-03-19 21:06:47'),
(135, 51, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $180.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-19 21:08:34'),
(136, 52, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $130.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-19 21:19:26'),
(137, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/e1c41f239fbae6cc0ad84c215d179c41e8ff448a455377a045ba4c6d9b684f28\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:24:40'),
(138, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/05b6fee077272283b1cab70ffffdbb3fa07357d0ace86be06e5a23a6a9f45648\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:24:48'),
(139, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/70ff7e60c85bbf3e1cfa4fcc9f1755e8a902764f323e526ee01fd7f2dd54156a\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:25:05'),
(140, 52, 1, '❌ Your purchase request has been declined.\n\nIf you have any questions or would like to discuss alternatives, feel free to message us here.', '2026-03-19 21:25:11'),
(141, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ace9aa6bed23b117db6e697f6298f2bf68ff698dbd525696bc2b77a5bb2b0a37\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:25:29'),
(142, 20, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/f9ee11fdcc0cc7fdf279d9f94c7fccda38b31830d0687d21ab239560c6211b85\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:25:40'),
(143, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/f9fb87c9e80d45aee142a50f6df0899e33f83ab37fe0c2f5dab870f933077a32\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:41:24'),
(144, 52, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/53ea5ca6dfcd5666c247ce5b2fba4171a5f063b670b2616cc30f6fa870293784\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-19 21:41:30'),
(145, 51, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/c82b44877e60662c47fddcfa67d612e458cdc020be2625bba805ac8157ce921d\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-20 06:53:42'),
(146, 50, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/1c9b9892e3986625dce7cab1879ba46f84e394f35d53bdee877d1a8fdfdea1cf\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-20 06:54:02'),
(147, 53, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 8\nTotal: $340.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-22 02:38:59'),
(148, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3c87497a1aa9a1e4bc8e9ccf457a67eb2c6117db412e37ef2d5791e31e8b366c\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 02:42:08'),
(149, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/e545bd2cc88c89205e9c81a25fa4982027b5033e06e62211b466daf57f2d0601\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 02:42:28'),
(150, 28, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ffc992f299e60bd9487959392681eb76d505deef7f06272b00cc669a5121c687\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 02:43:40'),
(151, 28, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/1c1b8e4f82d66c3a3ebbf4a7bc7336e24cca9ef9d7362c37be086cb0fd58514f\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 02:44:04'),
(152, 54, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-22 02:44:29'),
(153, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/01a636f85e4d3b68fc13c057e20df6f9f1e0a01a2c287dac5be17b72a03837c3\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 02:44:49'),
(154, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/4b1c12e325bbf87a4cd66e4af1748d6690729108476d8de20f3a3fe5e7e7f3ee\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:15:22'),
(155, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3d8d327b01a5c183f099b1b0ce0e3b557d5d8ac48c1f5c4df6d2e71867b0c410\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:15:34'),
(156, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ba293fa688fa67998c547f6f2cb277c2fe7a259d1689ac1c6bd76b94854622f6\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:15:40'),
(157, 9, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/21c1b7a610572f38a752ea07a7808b20d4c9c9b8a8ab2f938dfbd1f29cb7f3e9\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:16:08'),
(158, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/b0a6232a83c9187f8a632749f8966f0cabd4ec97e76cc839e9f094797a56592f\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:30:17'),
(159, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3b111f9e5dcc0471b9ae52cee05f203a6bde7cb48117951841d1551111f6eff7\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:30:22'),
(160, 42, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/625f92ea4bbbf1bfd5aca8c6f8a53d89f1f7ef5486e66effd62ffbc081413054\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:30:31'),
(161, 23, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ddbbcb73eecd35ede0af05a62f6cab5c61d3947c4d0313e6ee28f5ce1c8d0d3e\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:30:41'),
(162, 12, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/fd372fd0558ce444b8404e4229d667236ef83775f960b8526e4dadcd3e527d05\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:30:50'),
(163, 12, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/c61bc32583fe10652c99a455e294a2a37bd09bcab0d94464eaf24ff7e3a72b8c\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:32:26'),
(164, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/0831084afee32a25c292d346524e8af552c9727c07547f8d02219e9da7d9f52d\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:34:34'),
(165, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/b77d9d39b1c26b33eb486977e5d48f9db0b77634dcd424c6786f1875a7df98db\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:41:37'),
(166, 54, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/c03c877beca492731d2a9efbc0a78e72eb9797fcf9a2dba8d903a757dfd53395\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:41:43'),
(167, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ae343269ff7daeae2b3807bb99e31147bd5a32bb00d70f9523cae942a9959bc5\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:41:49'),
(168, 12, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/14dd6cad7f1f5893eb40c6f505df60b4268864df294d6fd5ff4b1f4ad241e51a\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:41:55'),
(169, 55, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-22 07:45:10'),
(170, 55, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/c1b8525d5f3e35a974e7ba040b42579f30ed5e4238ebd0495efb9b4798f7da16\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:45:23'),
(171, 12, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/a58a64e5f82c390e03a2dc2302a5932ce15cecafe9c83ceb52b71d9c79fd174a\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:55:47'),
(172, 56, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $0.00\n\nPlease review and approve my order request.', '2026-03-22 07:56:26'),
(173, 55, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/16968984a45fa947d2b15e46cf820477da2314825d97bdd697cb3c6313040cd6\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:56:44'),
(174, 56, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/f51d6a1881f675f5cd07d67bb8228457dc9a902b6120e58010ebf4971cd81753\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:56:49'),
(175, 53, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/b87d05580fbeced4a222ebc432f3dd3621fb849bea3bfe97ab1adeaadb428ace\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 07:56:57'),
(176, 57, 14, 'New Order Request\n\nItem: equip q\nType: Purchase (Equipment)\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-03-22 07:59:49'),
(177, 58, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 3\nTotal: $190.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-22 14:28:18'),
(178, 58, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/dfe8f7a825f5e18d744216787af215c6e64181ad713c78de2fc1208aa8bc0e99\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-22 14:28:49'),
(179, 59, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 4\nTotal: $180.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-22 14:35:13'),
(180, 60, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 4\nTotal: $220.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-22 14:35:37'),
(181, 61, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 4\nTotal: $220.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-22 14:36:13'),
(182, 62, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $120.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-22 14:51:01'),
(183, 63, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 2\nTotal: $140.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-22 14:51:35'),
(184, 64, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $20.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-22 14:52:29'),
(185, 58, 1, 'Payment received and secured in escrow!\n\nOrder #63\nAmount: $190.00\n\n', '2026-03-23 05:37:07'),
(186, 63, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/17901e86c4cd89d6d2917fb6ed7b6e4e95babd79b4ac947d82b81378698e5b46\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-23 05:48:52'),
(187, 64, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/600daa8b22ef7a72049cf491a5352b2e3deee7f40784a608f0c846233728a688\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-23 05:48:57'),
(188, 65, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $100.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 06:55:28'),
(189, 66, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental (Equipment)\nQuantity: 1\nTotal: $100.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-23 06:55:42'),
(190, 67, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $20.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-23 07:13:16'),
(191, 68, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 07:15:13'),
(192, 69, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $20.00\nRental Period: 2026-03-19 to 2026-03-21\n\nPlease review and approve my order request.', '2026-03-23 07:21:24'),
(193, 70, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 07:21:45'),
(194, 71, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 07:24:47'),
(195, 71, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/5e922ea15ab470e647b4508102d1d859e111bc33ecc8b47e0008269f763b6295\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-23 07:26:49'),
(196, 72, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-23 07:27:36'),
(197, 73, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-03-19 to 2026-03-27\n\nPlease review and approve my order request.', '2026-03-23 07:32:55'),
(198, 74, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 07:33:05'),
(199, 75, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $40.00\nRental Period: 2026-03-19 to 2026-03-22\n\nPlease review and approve my order request.', '2026-03-23 07:35:37'),
(200, 75, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/419e08a8ac3b4f5addfb171083d3005779d7dd964a3dc34df866241bb7d26b67\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-23 07:37:41'),
(201, 76, 1, 'Payment received and secured in escrow!\n\nOrder #94\nAmount: $40.00\n\n', '2026-03-23 08:40:26'),
(202, 75, 1, 'Your order has been shipped!\n\nOrder #78\n\nOnce you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-03-23 08:54:45'),
(203, 75, 1, 'Delivery Confirmed!\n\nOrder #78\nThe buyer has confirmed receipt of the product.\n\nðŸ’° Funds are being released to your account now.\n\nThank you for your business!', '2026-03-23 08:59:06'),
(204, 75, 1, 'Thank you for confirming delivery!\n\nOrder #78\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-03-23 08:59:06'),
(205, 75, 1, 'This chat has been escalated to a dispute.\nIssue ID #1 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-03-23 10:52:52'),
(206, 75, 1, 'This chat has been escalated to a dispute.\nIssue ID #2 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-03-23 10:59:45'),
(207, 77, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $50.00\nRental Period: 2026-03-19 to 2026-03-23\n\nPlease review and approve my order request.', '2026-03-23 12:09:01'),
(208, 77, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/1d7267b5f1a2b41d426e10c37f593f055266d33b4fd3f763ee89d66e0b0b3f3d\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-03-23 12:09:20'),
(209, 78, 1, 'Payment received and secured in escrow!\n\nOrder #95\nAmount: $50.00\n\n', '2026-03-23 12:10:34'),
(210, 77, 1, 'Your order has been shipped!\n\nOrder #79\n\nOnce you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-03-23 12:11:51'),
(211, 77, 1, 'Delivery Confirmed!\n\nOrder #79\nThe buyer has confirmed receipt of the product.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-03-23 12:12:03'),
(212, 77, 1, 'Thank you for confirming delivery!\n\nOrder #79\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-03-23 12:12:03'),
(213, 77, 1, 'This chat has been escalated to a dispute.\nIssue ID #3 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-03-23 12:17:52'),
(214, 79, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-03-19 to 2026-03-26\n\nPlease review and approve my order request.', '2026-04-04 15:14:11'),
(215, 79, 14, 'Hey', '2026-04-04 15:14:18'),
(216, 79, 1, 'G�� Your purchase request has been declined.\n\nReason: adfsadf\n\nIf you have any questions or would like to discuss alternatives, feel free to message us here.', '2026-04-04 15:16:27'),
(217, 80, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-03-19 to 2026-03-26\n\nPlease review and approve my order request.', '2026-04-04 15:18:06'),
(218, 80, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/84fa07aba65425a8d98a5a83790de120cf8528c89e9cff377c3dd8371f042c70\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-04 15:19:00'),
(219, 80, 1, 'Payment received and secured in escrow!\n\nOrder #81\nAmount: $180.00\n\n', '2026-04-04 15:21:27'),
(220, 80, 1, 'This chat has been escalated to a dispute.\nIssue ID #4 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-04-04 15:27:58'),
(221, 80, 10, 'hello', '2026-04-04 15:29:14'),
(222, 80, 10, 'what\'s the problem?', '2026-04-04 15:29:18'),
(223, 80, 1, 'company admin', '2026-04-04 15:29:42'),
(224, 80, 14, 'user', '2026-04-04 15:29:46'),
(225, 80, 10, 'super admin', '2026-04-04 15:29:53'),
(226, 80, 10, '✅ Issue #4 marked as resolved by SuperAdmin. This dispute chat remains available for buyer, company admin, and superadmin until order completion.', '2026-04-04 15:30:03'),
(227, 80, 1, 'Your order has been shipped!\n\nOrder #81\n\nOnce you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-04-04 15:31:14'),
(228, 80, 1, 'Delivery Confirmed!\n\nOrder #81\nThe buyer has confirmed receipt of the product.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-04 15:31:29'),
(229, 80, 1, 'Thank you for confirming delivery!\n\nOrder #81\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-04 15:31:29'),
(230, 81, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $100.00\nRental Period: 2026-04-17 to 2026-04-26\n\nPlease review and approve my order request.', '2026-04-04 15:33:04'),
(231, 81, 1, 'G�� Your purchase request has been declined.\n\nIf you have any questions or would like to discuss alternatives, feel free to message us here.', '2026-04-04 15:33:49'),
(232, 82, 14, 'New Order Request\n\nItem: Asad\nType: Rental\nQuantity: 1\nTotal: $2,268.00\nRental Period: 2026-01-01 to 2026-01-07\n\nPlease review and approve my order request.', '2026-04-04 15:34:27'),
(233, 82, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/3805a491b0b845b13e96f8bee42f3aec006a2e758165f304ccc8a94484658ed5\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-04 15:34:43'),
(234, 82, 1, 'Payment received and secured in escrow!\n\nOrder #83\nAmount: $2,268.00\n\n', '2026-04-04 15:38:41'),
(235, 82, 1, 'Your order is ready for pickup!\n\nOrder #83\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-04-04 15:38:58'),
(236, 82, 1, 'Pickup Confirmed!\n\nOrder #83\nThe buyer has collected the item.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-04 15:39:20'),
(237, 82, 1, 'Thank you for confirming pickup!\n\nOrder #83\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-04 15:39:20'),
(238, 83, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $150.00\nRental Period: 2026-04-12 to 2026-04-26\n\nPlease review and approve my order request.', '2026-04-04 15:41:53'),
(239, 83, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/5768836661b70254419d7892041b59c17051d3dd95ad99e1a1c3eaa2d7d156e8\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-04 15:42:27'),
(240, 74, 1, 'Your purchase request has been declined.\n\nIf you have any questions or would like to discuss alternatives, feel free to message us here.', '2026-04-07 13:08:11'),
(241, 84, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $40.00\nRental Period: 2026-04-09 to 2026-04-12\n\nPlease review and approve my order request.', '2026-04-09 05:55:44'),
(242, 84, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 05:56:05'),
(243, 67, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $40.00\nRental Period: 2026-04-09 to 2026-04-12\n\nPlease review and approve my order request.', '2026-04-09 05:56:57'),
(244, 67, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 05:57:10'),
(245, 68, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-04-17 to 2026-04-19\n\nPlease review and approve my order request.', '2026-04-09 05:58:10'),
(246, 68, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 05:58:32'),
(247, 69, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $90.00\nRental Period: 2026-04-09 to 2026-04-17\n\nPlease review and approve my order request.', '2026-04-09 06:03:43'),
(248, 69, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 06:04:01'),
(249, 70, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $90.00\nRental Period: 2026-04-09 to 2026-04-17\n\nPlease review and approve my order request.', '2026-04-09 06:40:39'),
(250, 70, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 06:41:06'),
(251, 85, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $50.00\nRental Period: 2026-04-14 to 2026-04-18\n\nPlease review and approve my order request.', '2026-04-09 06:41:49'),
(252, 85, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/f7d69b68aa44f2bf9eeb55759e7db7ccf03b10316cb64edf68f0a9505fd5005c\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 06:48:22'),
(253, 85, 1, 'Payment received and secured in escrow!\n\nOrder #90\nAmount: $50.00', '2026-04-09 06:49:34'),
(254, 85, 1, 'This order has been cancelled. This chat is now closed.\n\nPayment update: A refund of 50.00 DKK has been initiated to your Stripe account.', '2026-04-09 06:50:56'),
(255, 86, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $90.00\nRental Period: 2026-04-18 to 2026-04-26\n\nPlease review and approve my order request.', '2026-04-09 07:13:49'),
(256, 86, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/38f3bde274d55544a2fb688ab44e6c9348eef006fefc8d25e25c6ca922d20934\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 07:14:10'),
(257, 86, 1, 'Payment received and secured in escrow!\n\nOrder #91\nAmount: $90.00', '2026-04-09 07:14:53'),
(258, 86, 1, 'Your order is ready for pickup!\n\nOrder #91\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-04-09 07:15:37'),
(259, 86, 1, 'Pickup Confirmed!\n\nOrder #91\nThe buyer has collected the item.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-09 07:15:58'),
(260, 86, 1, 'Thank you for confirming pickup!\n\nOrder #91\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-09 07:15:58'),
(261, 86, 1, '🚨 This chat has been escalated to a dispute.\nIssue ID #5 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-04-09 07:16:27'),
(262, 86, 10, 'ok', '2026-04-09 07:17:52'),
(263, 86, 10, '✅ Issue #5 resolved by SuperAdmin. Outcome: No Action. afasf\n\nThis dispute chat remains available for buyer, company admin, and superadmin until order completion.', '2026-04-09 07:18:08'),
(264, 87, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $90.00\nRental Period: 2026-04-09 to 2026-04-17\n\nPlease review and approve my order request.', '2026-04-09 07:28:52'),
(265, 87, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/73ab47d4d2e76c229ce4d2d57866158c22a4aa08fa4894727d50fc6cd9018fc8\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 07:29:04'),
(266, 87, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 07:30:02'),
(267, 10, 1, 'Delivery Confirmed!\n\nOrder #1\nThe buyer has confirmed receipt of the product.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-09 10:40:33'),
(268, 10, 1, 'Thank you for confirming delivery!\n\nOrder #1\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-09 10:40:33');
INSERT INTO `order_chat_messages` (`messageID`, `chatID`, `senderUserID`, `messageText`, `createdAt`) VALUES
(269, 88, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $90.00\nRental Period: 2026-04-09 to 2026-04-17\n\nPlease review and approve my order request.', '2026-04-09 13:04:34'),
(270, 88, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/509c0871b2cb61101d06194fe9ad35f0f781411b88b71f3a800368c9701a6541\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 13:06:03'),
(271, 88, 1, 'Payment received and secured in escrow!\n\nOrder #93\nAmount: $190.00', '2026-04-09 13:09:00'),
(272, 88, 1, 'Your order has been shipped!\n\nOrder #93\n\nOnce you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.', '2026-04-09 13:18:17'),
(273, 88, 1, 'Delivery Confirmed!\n\nOrder #93\nThe buyer has confirmed receipt of the product.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-09 13:18:45'),
(274, 88, 1, 'Thank you for confirming delivery!\n\nOrder #93\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-09 13:18:45'),
(275, 76, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-04-12 to 2026-04-19\n\nPlease review and approve my order request.', '2026-04-09 13:23:42'),
(276, 76, 1, 'This order has been cancelled. This chat is now closed.', '2026-04-09 13:27:22'),
(277, 78, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $50.00\nRental Period: 2026-04-14 to 2026-04-18\n\nPlease review and approve my order request.', '2026-04-09 13:27:53'),
(278, 78, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/c00bdb66562cbea72b472c3b5ec7f8026437ded202426a32d43312f5353a8287\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 13:28:05'),
(279, 78, 1, 'Payment received and secured in escrow!\n\nOrder #95\nAmount: $50.00', '2026-04-09 13:29:05'),
(280, 78, 1, 'This order has been cancelled. This chat is now closed.\n\nPayment update: A refund of 50.00 $ has been initiated to your Stripe account.', '2026-04-09 13:29:38'),
(281, 89, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $80.00\nRental Period: 2026-04-17 to 2026-04-24\n\nPlease review and approve my order request.', '2026-04-09 13:31:34'),
(282, 89, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/ed3a1998b581cb82a2892d550d7e4e6beab2b3571ec1bda4eb5c0b2159b0447b\n\nThis link does not expire.\n\nIf you have any questions, feel free to message us!', '2026-04-09 13:32:12'),
(283, 89, 1, 'Payment received and secured in escrow!\n\nOrder #96\nAmount: $80.00', '2026-04-09 13:32:58'),
(284, 89, 1, 'Your order is ready for pickup!\n\nOrder #96\nPlease visit us at our location to collect your item.\n\nOnce you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.', '2026-04-09 13:33:07'),
(285, 89, 1, 'Pickup Confirmed!\n\nOrder #96\nThe buyer has collected the item.\n\nFunds are being released to your account now.\n\nThank you for your business!', '2026-04-09 13:33:20'),
(286, 89, 1, 'Thank you for confirming pickup!\n\nOrder #96\nPayment has been released to the seller.\n\nWe hope you enjoy your purchase!', '2026-04-09 13:33:20'),
(287, 89, 1, '🚨 This chat has been escalated to a dispute.\nIssue ID #6 has been reported.\nA platform administrator has been added and will review the dispute shortly.\nPlease continue to communicate here.', '2026-04-09 13:33:55'),
(288, 90, 14, 'New Order Request\n\nItem: equip q\nType: Purchase\nQuantity: 1\nTotal: $20.00\n\nPlease review and approve my order request.', '2026-04-22 10:53:54'),
(289, 90, 1, 'Your purchase request has been approved!\n\nYou can now complete your payment using this secure link:\nhttp://localhost/equipmanager/checkout/pay/eae948423f197715265486be599355f2f082cd145a0ccf4488dc1d7cc70318ce\n\nThis link will expire in 7 days.\n\nIf you have any questions, feel free to message us!', '2026-04-22 10:54:25'),
(290, 90, 1, 'Payment received and secured in escrow!\n\nOrder #97\nAmount: $20.00', '2026-04-22 10:55:38'),
(291, 32, 14, 'hello', '2026-04-24 10:23:48'),
(292, 91, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-04-24 to 2026-04-26\n\nPlease review and approve my order request.', '2026-04-24 10:59:38'),
(293, 92, 14, 'New Order Request\n\nItem: Test Equipmr\nType: Rental\nQuantity: 1\nTotal: $30.00\nRental Period: 2026-04-24 to 2026-04-26\n\nPlease review and approve my order request.', '2026-04-24 10:59:38'),
(294, 93, 14, 'New Order Request\n\nItem: Faisal\nType: Rental\nQuantity: 1\nTotal: $2,250.00\nRental Period: 2026-05-07 to 2026-05-15\n\nPlease review and approve my order request.', '2026-04-24 11:00:51'),
(295, 93, 14, 'available?', '2026-04-24 11:00:58');

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
(6, 5, 3, 3, 0),
(7, 6, 5, 10, 0),
(8, 6, 6, 10, 0),
(9, 4, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `pCatID` int(11) NOT NULL COMMENT '0=marketplace listing',
  `itemID` int(11) DEFAULT NULL COMMENT 'shop listing ID',
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

INSERT INTO `projects` (`ProjectID`, `companyID`, `pCatID`, `itemID`, `pName`, `pLocation`, `pStartDate`, `pEndDate`, `pDesc`, `pImg1`, `pImg2`, `pImg3`, `pImg4`, `pImg5`, `pImg6`, `pImg7`, `pImg8`, `pImg9`, `pImg10`, `pStatus`, `pDraftStatus`, `createdAt`) VALUES
(1, 1, 0, 1, 'Website Marketplace Listing', 'asdasd', '2026-01-01', '2026-01-07', 'Workforce Listing on website Marketplace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2025-12-29 18:01:06'),
(3, 1, 0, 4, 'Website Marketplace Listing', 'test address', '2026-01-08', '2026-01-15', 'Equipment Listing on website Marketplace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2026-01-08 18:28:33'),
(4, 1, 4, NULL, 'lahore plubbing', 'lahore', '2026-01-09', '2026-01-13', 'asfas', '695ff92ce3f32_1767897388.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2026-01-08 18:36:30'),
(6, 1, 0, 8, 'Website Marketplace Listing', 'test address', '2026-03-19', '2026-04-26', 'Equipment Listing on website Marketplace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2026-03-18 20:19:43'),
(7, 1, 0, 9, 'Website Marketplace Listing', 'askjfd', '2026-04-09', '2026-05-31', 'Workforce Listing on website Marketplace', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2026-04-09 15:55:27'),
(8, 1, 4, NULL, 'skdjfa', 'asdf', '2026-04-17', '2026-04-29', 'asdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2026-04-16 09:15:39'),
(9, 1, 4, NULL, 'gasf', 'asfd', '2026-04-30', '2026-05-08', 'asf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2026-04-24 13:45:39'),
(10, 1, 4, NULL, 'afa', 'df', '2026-05-27', '2026-07-01', 'kj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 3, '2026-05-05 17:27:09');

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
(1, 1, 1),
(2, 0, 5),
(3, 0, 4),
(4, 0, 3),
(5, 7, 3),
(6, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `rental_completion_log`
--

CREATE TABLE `rental_completion_log` (
  `completionID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) DEFAULT NULL,
  `workforcePaymentID` int(11) DEFAULT NULL,
  `itemType` int(11) NOT NULL COMMENT '1=equipment, 2=workforce',
  `quantity` int(11) DEFAULT NULL,
  `completionDate` date NOT NULL,
  `quantityReturned` int(11) DEFAULT NULL COMMENT 'How much inventory was returned',
  `completedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_completion_log`
--

INSERT INTO `rental_completion_log` (`completionID`, `equipmentPaymentID`, `workforcePaymentID`, `itemType`, `quantity`, `completionDate`, `quantityReturned`, `completedAt`) VALUES
(1, 97, NULL, 1, 0, '2026-04-04', 0, '2026-04-04 15:32:31'),
(2, NULL, 9, 2, 1, '2026-04-04', 1, '2026-04-04 15:39:37'),
(3, 106, NULL, 1, 0, '2026-04-09', 0, '2026-04-09 07:18:55'),
(4, 108, NULL, 1, 0, '2026-04-09', 0, '2026-04-09 13:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `rental_issues`
--

CREATE TABLE `rental_issues` (
  `issueID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) DEFAULT NULL,
  `workforcePaymentID` int(11) DEFAULT NULL,
  `orderID` int(11) NOT NULL,
  `issueType` enum('late_delivery','late_return','damaged','missing_parts','malfunction','other') NOT NULL,
  `issueTitle` varchar(255) NOT NULL,
  `issueDescription` text NOT NULL,
  `reportedBy` int(11) NOT NULL,
  `reporterType` enum('renter','owner') NOT NULL,
  `reportedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `issueStatus` enum('reported','under_review','resolved','closed') NOT NULL DEFAULT 'reported',
  `assignedToAdmin` int(11) DEFAULT NULL,
  `resolutionNotes` text DEFAULT NULL,
  `resolutionOutcome` enum('refund_full','refund_partial','compensation','no_action','insurance_claim') DEFAULT NULL,
  `resolvedAt` timestamp NULL DEFAULT NULL,
  `resolvedBy` int(11) DEFAULT NULL,
  `refundAmount` decimal(10,2) DEFAULT NULL,
  `compensationAmount` decimal(10,2) DEFAULT NULL,
  `attachmentUrls` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachmentUrls`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_issues`
--

INSERT INTO `rental_issues` (`issueID`, `equipmentPaymentID`, `workforcePaymentID`, `orderID`, `issueType`, `issueTitle`, `issueDescription`, `reportedBy`, `reporterType`, `reportedAt`, `issueStatus`, `assignedToAdmin`, `resolutionNotes`, `resolutionOutcome`, `resolvedAt`, `resolvedBy`, `refundAmount`, `compensationAmount`, `attachmentUrls`, `createdAt`, `updatedAt`) VALUES
(1, 94, NULL, 78, 'damaged', 'adf', 'adf', 1, 'owner', '2026-03-23 14:52:52', 'reported', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-23 10:52:52', '2026-03-23 10:52:52'),
(2, 94, NULL, 78, 'damaged', 'fdsa', 'asdf', 14, 'renter', '2026-03-23 14:59:44', 'reported', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-23 10:59:44', '2026-03-23 10:59:44'),
(3, 95, NULL, 79, 'damaged', 'dfs', 'df', 1, 'owner', '2026-03-23 16:17:52', 'reported', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-23 12:17:52', '2026-03-23 12:17:52'),
(4, 97, NULL, 81, 'late_return', 'asdfasa', 'asdfas', 1, 'owner', '2026-04-04 18:27:58', 'resolved', NULL, 'Issue resolved by SuperAdmin from issue chat.', 'no_action', '2026-04-04 15:30:03', 10, NULL, NULL, NULL, '2026-04-04 15:27:58', '2026-04-04 15:30:03'),
(5, 106, NULL, 91, 'damaged', 'dfas', 'adsf', 14, 'renter', '2026-04-09 10:16:27', 'resolved', NULL, 'afasf', 'no_action', '2026-04-09 07:18:08', 10, NULL, NULL, NULL, '2026-04-09 07:16:27', '2026-04-09 07:18:08'),
(6, 111, NULL, 96, 'damaged', 'The Item was broken', 'test test', 14, 'renter', '2026-04-09 16:33:55', 'reported', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-09 13:33:55', '2026-04-09 13:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `rental_quantity_locks`
--

CREATE TABLE `rental_quantity_locks` (
  `lockID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rentalStartDate` date NOT NULL,
  `rentalEndDate` date NOT NULL,
  `lockedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `unlockedAt` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `lockStatus` enum('locked','unlocked','released') NOT NULL DEFAULT 'locked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_quantity_locks`
--

INSERT INTO `rental_quantity_locks` (`lockID`, `equipmentID`, `equipmentPaymentID`, `quantity`, `rentalStartDate`, `rentalEndDate`, `lockedAt`, `unlockedAt`, `notes`, `lockStatus`) VALUES
(1, 6, 77, 3, '2026-03-19', '2026-03-22', '2026-03-22 18:28:49', NULL, NULL, 'locked'),
(2, 6, 82, 2, '2026-03-19', '2026-03-21', '2026-03-23 09:48:52', NULL, NULL, 'locked'),
(3, 6, 83, 1, '2026-03-19', '2026-03-21', '2026-03-23 09:48:57', NULL, NULL, 'locked'),
(4, 6, 90, 1, '2026-03-19', '2026-03-22', '2026-03-23 11:26:49', NULL, NULL, 'locked'),
(5, 6, 94, 1, '2026-03-19', '2026-03-22', '2026-03-23 11:37:41', NULL, NULL, 'locked'),
(6, 6, 97, 1, '2026-03-19', '2026-03-26', '2026-04-04 18:19:00', '2026-04-04 15:32:31', 'Completed', 'unlocked'),
(7, 6, 99, 1, '2026-04-12', '2026-04-26', '2026-04-04 18:42:27', '2026-04-04 15:42:43', 'Cancelled', 'unlocked'),
(8, 6, 105, 1, '2026-04-14', '2026-04-18', '2026-04-09 09:48:22', '2026-04-09 06:50:56', 'Cancelled', 'unlocked'),
(9, 6, 106, 1, '2026-04-18', '2026-04-26', '2026-04-09 10:14:10', '2026-04-09 07:18:55', 'Completed', 'unlocked'),
(10, 6, 107, 1, '2026-04-09', '2026-04-17', '2026-04-09 10:29:04', '2026-04-09 07:30:02', 'Cancelled', 'unlocked'),
(11, 6, 108, 1, '2026-04-09', '2026-04-17', '2026-04-09 16:06:03', '2026-04-09 13:20:03', 'Completed', 'unlocked'),
(12, 6, 110, 1, '2026-04-14', '2026-04-18', '2026-04-09 16:28:05', '2026-04-09 13:29:38', 'Cancelled', 'unlocked'),
(13, 6, 111, 1, '2026-04-17', '2026-04-24', '2026-04-09 16:32:12', NULL, NULL, 'locked');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `equipmentPaymentID` int(11) DEFAULT NULL,
  `workforcePaymentID` int(11) DEFAULT NULL,
  `reviewerID` int(11) NOT NULL,
  `revieweeID` int(11) NOT NULL,
  `transactionType` enum('purchase','rental','workforce') NOT NULL,
  `roleType` enum('buyer','seller','renter','owner','worker','client') NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `reviewText` varchar(500) DEFAULT NULL,
  `categoryRatings` longtext DEFAULT NULL,
  `tagsJson` longtext DEFAULT NULL,
  `visibilityStatus` enum('visible','hidden','under_review') NOT NULL DEFAULT 'visible',
  `editWindowExpiry` datetime NOT NULL,
  `isEdited` tinyint(1) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `orderID`, `equipmentPaymentID`, `workforcePaymentID`, `reviewerID`, `revieweeID`, `transactionType`, `roleType`, `rating`, `reviewText`, `categoryRatings`, `tagsJson`, `visibilityStatus`, `editWindowExpiry`, `isEdited`, `createdAt`, `updatedAt`) VALUES
(1, 8, 41, NULL, 14, 1, 'purchase', 'buyer', 5, 'asdkfljlkasfjlaksjdf', NULL, '[\"good\"]', 'visible', '2026-05-01 08:55:10', 0, '2026-04-30 06:55:10', '2026-04-30 06:55:10'),
(2, 3, 36, NULL, 14, 1, 'purchase', 'buyer', 5, 'acha tha sahi tha bilkul', NULL, '[\"\"]', 'visible', '2026-05-06 17:52:08', 0, '2026-05-05 15:52:08', '2026-05-05 15:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `review_media`
--

CREATE TABLE `review_media` (
  `mediaID` int(11) NOT NULL,
  `reviewID` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `mimeType` varchar(100) NOT NULL,
  `fileSize` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_reports`
--

CREATE TABLE `review_reports` (
  `reportID` int(11) NOT NULL,
  `reviewID` int(11) NOT NULL,
  `reportedBy` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `status` enum('open','dismissed','actioned') NOT NULL DEFAULT 'open',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopequipments`
--

CREATE TABLE `shopequipments` (
  `shopEqpID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `web_catID` int(11) NOT NULL,
  `equipQty` int(11) NOT NULL,
  `eqpBrandModel` varchar(500) NOT NULL,
  `eqpSpecs` varchar(1500) NOT NULL,
  `eqpCondition` varchar(1500) NOT NULL,
  `eqpLocCity` varchar(100) NOT NULL,
  `eqpAdd` varchar(1500) DEFAULT NULL,
  `eqpRentalType` tinyint(1) DEFAULT NULL COMMENT '1=perday 2=per week 3=permonth 4=yearly',
  `eqpPrice` varchar(100) NOT NULL,
  `eqpAvailableStart` date NOT NULL,
  `eqpAvailableEnd` date NOT NULL,
  `eqpimg1` varchar(300) DEFAULT NULL,
  `eqpimg2` varchar(300) DEFAULT NULL,
  `eqpimg3` varchar(300) DEFAULT NULL,
  `eqpimg4` varchar(300) DEFAULT NULL,
  `eqpimg5` varchar(300) DEFAULT NULL,
  `eqpimg6` varchar(300) DEFAULT NULL,
  `eqpimg7` varchar(300) DEFAULT NULL,
  `eqpimg8` varchar(300) DEFAULT NULL,
  `eqpimg9` varchar(300) DEFAULT NULL,
  `eqpimg10` varchar(300) DEFAULT NULL,
  `eqpDeliveryOpt` tinyint(1) NOT NULL COMMENT '1=can be dilvered 2= pickup only ',
  `eqpRules` varchar(2000) DEFAULT NULL COMMENT '(damage, return, etc.)',
  `noteForRenter` varchar(2000) DEFAULT NULL,
  `addRequirments` varchar(2000) DEFAULT NULL COMMENT 'for renter',
  `deliveryCharge` decimal(10,2) DEFAULT NULL,
  `deliveryChargeBearer` tinyint(1) DEFAULT NULL COMMENT '1=company pays, 2=renter pays'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopequipments`
--

INSERT INTO `shopequipments` (`shopEqpID`, `itemID`, `equipmentID`, `web_catID`, `equipQty`, `eqpBrandModel`, `eqpSpecs`, `eqpCondition`, `eqpLocCity`, `eqpAdd`, `eqpRentalType`, `eqpPrice`, `eqpAvailableStart`, `eqpAvailableEnd`, `eqpimg1`, `eqpimg2`, `eqpimg3`, `eqpimg4`, `eqpimg5`, `eqpimg6`, `eqpimg7`, `eqpimg8`, `eqpimg9`, `eqpimg10`, `eqpDeliveryOpt`, `eqpRules`, `noteForRenter`, `addRequirments`, `deliveryCharge`, `deliveryChargeBearer`) VALUES
(1, 2, 6, 6, 2, 'dfh', 'hdfgh', '2', 'As', 'fasf', 1, '4', '2026-01-02', '2026-01-07', '2_1_1767031337.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, ' gsdg', 'sdgs', 'dgsd', NULL, NULL),
(2, 3, 4, 9, 3, 'gsdg', 'sdgsdg | asfasf', '3', 'Dusseldorf', 'sdgsd', NULL, '34', '2026-01-19', '2026-01-22', '3_1_1767031373.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'ddddd', NULL, NULL, NULL, NULL),
(3, 4, 5, 9, 81, 'awf', 'ffff', '1', 'Lahore', 'test address', NULL, '20', '2026-01-08', '2026-01-15', '4_1_1767896876.jpeg', '4_2_1767896876.jpg', '4_3_1767896876.png', '4_4_1767896876.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, ' asfas', 'asfas', 'afsfas', NULL, NULL),
(4, 6, 7, 9, 12, 'awf', '', '4', 'Ja', 'test address', 1, '13', '2026-03-28', '2026-04-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 8, 6, 9, 2, 'dfh', '', '4', 'Los Angeles', 'test address', 1, '10', '2026-03-19', '2026-04-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, ' jh', 'jhg', 'jjgh', 100.00, 2),
(7, 10, 4, 9, 12, 'awf', '', '4', '2', 'test address', NULL, '10', '2026-04-18', '2026-05-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 11, 9, 6, 19, 'Brand Test', '', '4', 'test', 'test', NULL, '16', '2026-04-28', '2026-05-31', '11_1_1777037689.webp', '11_2_1777037689.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, 14, 8, 6, 13, 'Brand Test', '', '4', 'testt', 'test', 1, '25', '2026-04-30', '2026-05-27', '14_1_1777039334.webp', '14_2_1777039334.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, 15, 7, 6, 3, 'Brand Test', ' ', '4', 'test', 'test', NULL, '15', '2026-04-24', '2026-05-25', '15_1_1777039590.webp', '15_2_1777039590.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(11, 16, 7, 6, 0, 'Brand Test', '', '4', 'Lahore', 'test', 2, '17', '2026-04-24', '2026-05-24', '16_1_1777039723.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shopitem`
--

CREATE TABLE `shopitem` (
  `itemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `companyID` int(11) DEFAULT NULL,
  `pageID` int(11) DEFAULT NULL,
  `itemType` tinyint(1) NOT NULL COMMENT '1=equipment 2=workforce',
  `saleType` tinyint(1) NOT NULL COMMENT '1=sale 0=rental',
  `itemStatus` tinyint(1) NOT NULL COMMENT '1=approved, 2=pending approval 3=rejected 0=drafted',
  `liveStatus` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=live 0=not live'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopitem`
--

INSERT INTO `shopitem` (`itemID`, `userID`, `companyID`, `pageID`, `itemType`, `saleType`, `itemStatus`, `liveStatus`) VALUES
(1, 1, 1, NULL, 2, 0, 1, 0),
(2, 1, 1, NULL, 1, 0, 0, 0),
(3, 1, 1, NULL, 1, 1, 2, 1),
(4, 1, 1, NULL, 1, 1, 1, 1),
(5, 1, 1, NULL, 2, 0, 0, 0),
(6, 1, 1, NULL, 1, 0, 0, 0),
(8, 1, 1, NULL, 1, 0, 1, 0),
(9, 1, 1, NULL, 2, 0, 2, 0),
(10, 1, 1, NULL, 1, 1, 0, 0),
(11, 1, 1, NULL, 1, 1, 0, 0),
(12, 1, 1, NULL, 2, 0, 0, 0),
(13, 1, 1, NULL, 2, 0, 1, 1),
(14, 1, 1, NULL, 1, 0, 1, 1),
(15, 1, 1, NULL, 1, 1, 1, 1),
(16, 1, 1, NULL, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shopworkforce`
--

CREATE TABLE `shopworkforce` (
  `shopWorkforceID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `workforceID` int(11) NOT NULL,
  `web_catID` int(11) NOT NULL,
  `workforceCV` varchar(100) NOT NULL,
  `workforceCertif` varchar(100) DEFAULT NULL,
  `workforceCity` varchar(500) NOT NULL,
  `WorkforceAdd` varchar(1200) DEFAULT NULL,
  `workforceRentalType` tinyint(1) NOT NULL COMMENT '1=perday 2=per week 3=permonth 4=yearly	',
  `workforcePrice` int(11) NOT NULL,
  `workforceAvailableStart` date NOT NULL,
  `workforceAvailableEnd` date NOT NULL,
  `workforceDeliveryOpt` tinyint(1) NOT NULL COMMENT '1=can be dilvered 2= pickup only',
  `workforceRules` varchar(2000) DEFAULT NULL COMMENT '(damage, return, etc.)',
  `workforcenoteForRenter` varchar(2000) DEFAULT NULL,
  `workforceaddRequirments` varchar(2000) DEFAULT NULL COMMENT 'for renter',
  `deliveryCharge` decimal(10,2) DEFAULT NULL,
  `deliveryChargeBearer` tinyint(1) DEFAULT NULL COMMENT '1=company pays, 2=renter pays'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopworkforce`
--

INSERT INTO `shopworkforce` (`shopWorkforceID`, `itemID`, `workforceID`, `web_catID`, `workforceCV`, `workforceCertif`, `workforceCity`, `WorkforceAdd`, `workforceRentalType`, `workforcePrice`, `workforceAvailableStart`, `workforceAvailableEnd`, `workforceDeliveryOpt`, `workforceRules`, `workforcenoteForRenter`, `workforceaddRequirments`, `deliveryCharge`, `deliveryChargeBearer`) VALUES
(1, 1, 1, 7, '1_cv_1767031261.pdf', '1_cert_1767031261.png', 'As', 'asdasd', 1, 324, '2026-01-01', '2026-01-07', 1, ' afsf', 'fasf', 'asfas', NULL, NULL),
(2, 5, 1, 7, '5_cv_1769432470.png', NULL, 'Lahore', '', 2, 5, '2026-02-24', '2026-02-28', 2, 'fsdf', NULL, NULL, NULL, NULL),
(3, 9, 3, 5, '9_cv_1775750110.pdf', NULL, 'Lahore', 'askjfd', 1, 30, '2026-04-09', '2026-05-31', 1, ' asdf', 'asdf', 'adsf', 10.00, 2),
(4, 12, 5, 5, '12_cv_1777037750.pdf', NULL, 'tst', 'test', 2, 170, '2026-04-30', '2026-05-27', 0, NULL, NULL, NULL, NULL, NULL),
(5, 13, 5, 7, '13_cv_1777038542.pdf', NULL, 'Test', 'Test', 2, 250, '2026-04-30', '2026-05-19', 0, NULL, NULL, NULL, NULL, NULL);

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
-- Table structure for table `supportticketchat`
--

CREATE TABLE `supportticketchat` (
  `chatID` int(11) NOT NULL,
  `supportTicketID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `chatText` varchar(2500) NOT NULL,
  `chatTimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supportticketchat`
--

INSERT INTO `supportticketchat` (`chatID`, `supportTicketID`, `userID`, `chatText`, `chatTimeStamp`) VALUES
(1, 1, 1, 'tesdt ticket', '2025-12-01 13:56:40'),
(2, 2, 1, 'hiasdfasf', '2025-12-01 13:59:44'),
(3, 3, 1, 'website not working', '2025-12-01 14:00:52'),
(4, 1, 1, 'update?', '2025-12-02 18:08:08'),
(5, 1, 1, 'hii', '2025-12-02 18:19:43'),
(6, 1, 1, 'yo?', '2025-12-02 18:23:29'),
(7, 1, 1, 'o paiii', '2025-12-02 18:26:37'),
(8, 2, 1, 'hello', '2025-12-02 18:26:45'),
(9, 1, 1, 'hellosss', '2025-12-02 18:55:15'),
(10, 2, 1, 'o paii kidan ', '2025-12-02 18:55:26'),
(11, 1, 10, 'Yo', '2025-12-04 12:37:17'),
(12, 1, 10, 'GG', '2025-12-04 12:37:54'),
(13, 1, 10, 'im on it', '2025-12-04 12:46:42'),
(14, 1, 1, 'OPk waiting', '2025-12-04 12:50:06'),
(15, 1, 10, 'ok it is done', '2025-12-04 13:05:26'),
(16, 1, 1, 'ok thanks', '2025-12-04 13:05:35'),
(17, 2, 10, 'Hi Let me check ', '2025-12-05 09:58:35'),
(18, 2, 1, 'ok fast', '2025-12-05 09:59:27'),
(19, 1, 1, 'hi', '2025-12-07 11:48:39'),
(20, 1, 10, 'Yooo', '2025-12-07 11:48:56'),
(21, 1, 10, 'ad', '2025-12-15 10:25:23'),
(22, 1, 10, 'Hi I done tha', '2025-12-15 10:40:10'),
(23, 1, 1, 'a', '2025-12-15 10:40:18'),
(24, 1, 10, 'dasd', '2025-12-15 10:44:36'),
(25, 1, 1, 'asdas', '2025-12-15 10:48:19'),
(26, 4, 1, 'asdasd', '2025-12-15 17:11:31'),
(27, 2, 10, 'Hi', '2025-12-18 15:57:15'),
(28, 2, 1, 'Hi', '2025-12-18 15:57:30'),
(29, 4, 1, 'heelo', '2025-12-27 21:49:52'),
(30, 5, 1, 'check please', '2026-01-20 17:25:37'),
(31, 5, 10, 'Checking', '2026-01-20 17:27:47'),
(32, 5, 10, 'it done', '2026-01-20 17:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `supporttickets`
--

CREATE TABLE `supporttickets` (
  `supportTicketID` int(11) NOT NULL,
  `supportTicketsCatID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `supportSubject` varchar(500) NOT NULL,
  `supportMessage` varchar(2500) NOT NULL,
  `supportTicketTimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `supportTicketStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=response needed from admin 2= responses waiting from company 3=completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supporttickets`
--

INSERT INTO `supporttickets` (`supportTicketID`, `supportTicketsCatID`, `userID`, `supportSubject`, `supportMessage`, `supportTicketTimeStamp`, `supportTicketStatus`) VALUES
(1, 1, 1, 'Em is not working', 'tesdt ticket', '2025-12-01 13:56:40', 3),
(2, 2, 1, 'paymetn wont get through', 'hiasdfasf', '2025-12-01 13:59:44', 3),
(3, 3, 1, 'websiute down', 'website not working', '2025-12-01 14:00:52', 3),
(4, 1, 1, 'Em is not working', 'asdasd', '2025-12-15 17:11:31', 1),
(5, 3, 1, 'Order not placing', 'check please', '2026-01-20 17:25:37', 3);

-- --------------------------------------------------------

--
-- Table structure for table `supportticketscat`
--

CREATE TABLE `supportticketscat` (
  `supportTicketsCatID` int(11) NOT NULL,
  `supportCat` varchar(500) NOT NULL,
  `supportCatStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0=non active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supportticketscat`
--

INSERT INTO `supportticketscat` (`supportTicketsCatID`, `supportCat`, `supportCatStatus`) VALUES
(1, 'EM Tracking', 1),
(2, 'Payments', 1),
(3, 'Websites', 1),
(4, 'Others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `settingID` int(11) NOT NULL,
  `settingKey` varchar(100) NOT NULL,
  `settingValue` text NOT NULL,
  `settingType` enum('string','number','boolean','json') NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL COMMENT 'SuperAdmin userID',
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`settingID`, `settingKey`, `settingValue`, `settingType`, `description`, `updatedBy`, `updatedAt`) VALUES
(1, 'marketplace_commission_percent', '4.50', 'number', 'Global commission percentage for all marketplace transactions', 10, '2026-02-08 07:33:21');

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
(10, 10, '6205', 'comWG3f5', 0),
(11, 11, '1616', 'ZRPNJeV6', 0),
(12, 12, '4815', 'tXaB0Ry7', 0),
(13, 13, '3701', 'cq2PjIaL', 0),
(14, 14, '5769', 'GlVpmPOf', 1),
(15, 15, '2543', 'r1vjc92n', 0),
(16, 16, '2312', '6eAGB2iwQUEcayJ5', 1);

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
(5, 1, 5, 8),
(6, 1, 6, 15),
(7, 1, 7, 16);

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
(10, 'test', '03000000000', 'lumixedgeseo@gmail.com', 'c93ccd78b2076528346216b3b2f701e6', 1, 1),
(11, 'ali', '123456', 'muhammadali@gmail.com', 'fa377a1337126da4e11ee722242c7ba9', 4, 2),
(12, 'Muhammad Ali ', '123456', 'muhammadalizahid0621@gmail.com', 'a8f5f167f44f4964e6c998dee827110c', 4, 2),
(13, 'company123', '03326876256', 'muhammadalizahid@gmail.com', '4297f44b13955235245b2497399d7a93', 2, 2),
(14, 'Muhammad Ali ', '123456', 'muhammadalizahid01@gmail.com', 'fa377a1337126da4e11ee722242c7ba9', 4, 1),
(15, 'Employee', '123456', 'test@gmail.com', NULL, 4, 2),
(16, 'EmployeeTest', '123456', 'employee1@gmail.com', '033836b6cedd9a857d82681aafadbc19', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_blogs`
--

CREATE TABLE `web_blogs` (
  `web_blogID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `web_blogImg` varchar(300) NOT NULL,
  `blogCatID` int(11) NOT NULL,
  `web_blogDate` varchar(30) NOT NULL,
  `web_blogTitle` varchar(300) NOT NULL,
  `web_blogDesp` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_blogs`
--

INSERT INTO `web_blogs` (`web_blogID`, `pageID`, `web_blogImg`, `blogCatID`, `web_blogDate`, `web_blogTitle`, `web_blogDesp`) VALUES
(6, 9, '5d3941770f26300df2d786ea848e6689.png', 1, '2025-11-26', 'asdfasaa', '<p>sfafsfa</p>');

-- --------------------------------------------------------

--
-- Table structure for table `web_blog_cat`
--

CREATE TABLE `web_blog_cat` (
  `blogCatID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `blogCat` varchar(200) NOT NULL,
  `blogCatDesc` varchar(2500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_blog_cat`
--

INSERT INTO `web_blog_cat` (`blogCatID`, `pageID`, `blogCat`, `blogCatDesc`) VALUES
(1, 4, 'Plumbin Hack', 'aassdfasdfa'),
(3, 7, 'Willa Flowerss', 'Excepturi vitae recu');

-- --------------------------------------------------------

--
-- Table structure for table `web_cat`
--

CREATE TABLE `web_cat` (
  `web_catID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `web_catIcon` varchar(300) NOT NULL,
  `web_catName` varchar(30) NOT NULL,
  `web_catDesp` varchar(2000) NOT NULL,
  `web_cat_type` tinyint(1) NOT NULL COMMENT '1=equipment 2=workforce'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_cat`
--

INSERT INTO `web_cat` (`web_catID`, `pageID`, `web_catIcon`, `web_catName`, `web_catDesp`, `web_cat_type`) VALUES
(5, 10, '4c73c3db9d7cf2def6a9ccb016448623.svg', 'Skilled Technicians', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 2),
(6, 11, '6738c55b20339448317ae52272836e40.svg', 'Construction Equipment', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 1),
(7, 12, '42e12c7b2a66a5ed293f173de9a7e6bd.svg', 'Electrical Installers', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 2),
(8, 13, 'de0544ccbc4a8be3835c5ea351b7dacb.svg', 'Skilled Technicians', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 2),
(9, 14, '3a745a47fe1543fecde65d9a9f2b4295.svg', 'Plumbing Equipment', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_company`
--

CREATE TABLE `web_company` (
  `web_companyID` int(11) NOT NULL,
  `web_companyIcon` varchar(300) NOT NULL,
  `web_companyStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 1=Active and 0=Deactive '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_company`
--

INSERT INTO `web_company` (`web_companyID`, `web_companyIcon`, `web_companyStatus`) VALUES
(2, '03eb1f186896c190736ab06dfbf582df.svg', 1),
(3, 'ad9358d1abcc07bb9603eaf3849cd088.svg', 1),
(4, '45b1d18d044bba9163625fb0077c6d46.svg', 1),
(5, '08ac83eb73a3c43f9a27d37b79c463f4.svg', 1),
(6, '8eefe305b601673edf4b9860d5da423a.svg', 1),
(7, 'b73c7825e2f30a2c1b4e33996519486f.svg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_contact_form`
--

CREATE TABLE `web_contact_form` (
  `contactID` int(11) NOT NULL,
  `contactName` varchar(200) NOT NULL,
  `contactEmail` varchar(200) NOT NULL,
  `contactSubject` varchar(500) NOT NULL,
  `contactMsg` varchar(1200) NOT NULL,
  `contactDate` datetime NOT NULL DEFAULT current_timestamp(),
  `contactStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=new 2=reponded'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `web_contact_form`
--

INSERT INTO `web_contact_form` (`contactID`, `contactName`, `contactEmail`, `contactSubject`, `contactMsg`, `contactDate`, `contactStatus`) VALUES
(1, 'Tahir Iqbal', 'revotahir@gmail.com', 'asdf', 'asdfas', '2026-01-27 19:20:38', 2),
(2, 'Kip and Tricks', 'revotahir@gmail.com', 'asdas', 'aaaa', '2026-01-27 22:54:32', 1),
(3, 'Tobias', 'test@tobias.com', 'EM Tracking', 'I want to buy.....', '2026-02-02 20:41:22', 2);

-- --------------------------------------------------------

--
-- Table structure for table `web_pages`
--

CREATE TABLE `web_pages` (
  `pageID` int(11) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `pageType` tinyint(1) NOT NULL COMMENT '1= Utality, 2= catory or product list 3= product detail\r\n4= blog list 5= blog detail',
  `pageStatus` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active 0= 404'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_pages`
--

INSERT INTO `web_pages` (`pageID`, `slug`, `pageType`, `pageStatus`) VALUES
(3, 'plubmber', 2, 1),
(4, 'plumbin-hack', 4, 1),
(7, 'willa-flowers', 4, 1),
(9, 'asdfas', 5, 1),
(10, 'skilled-technicians', 2, 1),
(11, 'construction-equipment', 2, 1),
(12, 'electrical-installers', 2, 1),
(13, 'skilled-technicians', 2, 0),
(14, 'construction-equipment', 2, 1),
(15, '', 1, 1),
(16, 'about-us', 1, 1),
(17, 'contact-us', 1, 1),
(18, 'how-it-works', 1, 1),
(19, 'features', 1, 1),
(20, 'marketplace', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `web_page_meta`
--

CREATE TABLE `web_page_meta` (
  `metaID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `metaTittle` varchar(500) DEFAULT NULL,
  `metaKeywords` varchar(500) DEFAULT NULL,
  `metaDesc` varchar(2500) DEFAULT NULL,
  `h1` varchar(500) DEFAULT NULL,
  `h2` varchar(500) DEFAULT NULL,
  `p1` varchar(2500) DEFAULT NULL,
  `p2` varchar(2500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_page_meta`
--

INSERT INTO `web_page_meta` (`metaID`, `pageID`, `metaTittle`, `metaKeywords`, `metaDesc`, `h1`, `h2`, `p1`, `p2`) VALUES
(2, 3, 'Plubmber | equipmanager.dk ', 'a,b,c,d,ff', 'aaa', 'h111 ', 'h222 ', 'hd111 ', 'hd222 '),
(3, 4, 'Plumbin Hack | equipmanager.dk', 'asdfas,asda,as', 'test descritpion', 'he', 'hr', 'pe', 'ps'),
(6, 7, 'Quia modi eos possim', 'Quidem dolore eu ill', 'Duis ea obcaecati quuuuuuu', 'Accusantium consequa', 'Ad voluptatem Molli', 'Irure iusto nemo rep', 'Excepteur excepturi '),
(8, 9, 'asdfas | equipmanager.dk', 'asfa,rdgdf,dfgdf', 'asfasaaaaaa', NULL, NULL, NULL, NULL),
(9, 10, 'Skilled Technicians | equipmanager.dk', 'test,sdfas,asdas', 'test', '', '', '', ''),
(10, 11, 'Construction Equipment | equipmanager.dk', '', '', '', '', '', ''),
(11, 12, 'Electrical Installers | equipmanager.dk', '', '', '', '', '', ''),
(12, 13, 'Skilled Technicians | equipmanager.dk', '', '', '', '', '', ''),
(13, 14, 'Construction Equipment | equipmanager.dk', '', '', '', '', '', ''),
(14, 15, 'Home | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL),
(15, 16, 'About Us | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL),
(16, 17, 'Contact Us | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL),
(17, 18, 'How it Works | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL),
(18, 19, 'Features | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL),
(19, 20, 'Marketplace | equipmanager.dk', 'test', 'test dewsc', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

CREATE TABLE `web_setting` (
  `settingID` tinyint(1) NOT NULL,
  `websiteStatus` tinyint(1) DEFAULT 1 COMMENT '1= live 2 = coming soon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_setting`
--

INSERT INTO `web_setting` (`settingID`, `websiteStatus`) VALUES
(1, 1);

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

--
-- Dumping data for table `web_success`
--

INSERT INTO `web_success` (`web_successID`, `web_successIcon`, `web_successName`, `web_successDes`, `web_successStatus`) VALUES
(2, 'dce9cb23e16eb506b6d8b6822a7b699b.svg', 'Listed Tools', '200+', 1),
(3, 'cacc5055d99e0ee14f4dd3595feafaa4.svg', 'Active Companies', '10+', 1),
(4, '62f8e33eb5c5987fa0246445ea267c22.svg', 'Workforce Members', '500+', 1),
(5, 'b9e0a6c02889efbbf8a08d62b278092d.svg', 'Average Rating', '4.9', 1);

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

--
-- Dumping data for table `web_testimonial`
--

INSERT INTO `web_testimonial` (`web_testimonialID`, `web_testimonialRating`, `web_testimonialDesp`, `web_testimonialImg`, `web_testimonialName`, `web_testimonialLocation`, `web_testimonialStatus`) VALUES
(2, '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', 'c34f957ab271b9013f68715da336ad18.png', 'Alex', 'USA', 1),
(3, '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', 'ecab3c296b41f1c7b62637131cc6a00a.png', 'Sam', 'California', 1),
(4, '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', 'ecab3c296b41f1c7b62637131cc6a00a.png', 'Anthony', 'Germany', 1),
(5, '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', 'ecab3c296b41f1c7b62637131cc6a00a.png', 'Parteek', 'UAE', 1),
(6, '5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.', 'ecab3c296b41f1c7b62637131cc6a00a.png', 'Alex', 'Dubai', 0);

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
(1, 1, 'Asad', '1232', 'creative.sol8264@gmail.com', '2774e66d6df7a50c7d8f40938c6d8ae7.png', 'sdfsdfsd', 2),
(2, 1, 'Atif', '3423', 'revotahir@gmail.com', 'images.png', 'sdfsd', 1),
(3, 1, 'Tayyab', '2342', 'revotahir@gmail.c', 'images.png', 'sfdh', 2),
(4, 1, 'JB', '3443', 'creative.sol8264@gmail.c', '3625e21ed7b48855b4c5a9d4b1768401.png', 'gjg', 2),
(5, 1, 'Faisal', '32323', 'per@gmail.com', 'images.png', 'sdfsd', 2),
(6, 1, 'Employee', '123456', 'employeetest@gmail.com', 'images.png', 'This is the first try to test successfull employee creation', 1),
(7, 1, 'EmployeeTest', '123456', 'employee1@gmail.com', 'images.png', 'testing', 1);

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
(27, 19, 5),
(29, 18, 6),
(30, 18, 7);

-- --------------------------------------------------------

--
-- Table structure for table `workforce_payments`
--

CREATE TABLE `workforce_payments` (
  `workforcePaymentID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL COMMENT 'FK to shopitem',
  `workforceID` int(11) NOT NULL COMMENT 'FK to workforce',
  `buyerUserID` int(11) NOT NULL COMMENT 'FK to users',
  `sellerCompanyID` int(11) NOT NULL COMMENT 'FK to companydetail',
  `stripeSessionID` varchar(255) DEFAULT NULL,
  `stripePaymentIntentID` varchar(255) DEFAULT NULL,
  `grossAmount` decimal(10,2) NOT NULL COMMENT 'Total amount paid by customer',
  `commissionPercent` decimal(5,2) NOT NULL COMMENT 'Commission % at time of payment',
  `commissionAmount` decimal(10,2) NOT NULL COMMENT 'Calculated commission',
  `netAmount` decimal(10,2) NOT NULL COMMENT 'Amount to company after commission',
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `rentalStartDate` date NOT NULL,
  `rentalEndDate` date NOT NULL,
  `rentalType` enum('daily','weekly','monthly','yearly') NOT NULL,
  `paymentStatus` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `orderStatus` enum('requested','approved','rejected','payment_pending','payment_secured','payment_approved','shipped','pickup_ready','delivered','completed','cancelled','refunded') NOT NULL DEFAULT 'requested',
  `rentalRequestStatus` enum('request_pending','request_approved','request_rejected','awaiting_handover','rental_active','rental_overdue','return_requested','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled') DEFAULT 'request_pending',
  `requestApprovedAt` timestamp NULL DEFAULT NULL,
  `requestApprovedBy` int(11) DEFAULT NULL COMMENT 'Company admin user ID who approved',
  `paymentMetadata` text DEFAULT NULL COMMENT 'JSON metadata',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelledBy` int(11) DEFAULT NULL COMMENT 'UserID who initiated cancellation',
  `cancelledAt` timestamp NULL DEFAULT NULL,
  `cancellationReason` text DEFAULT NULL,
  `refundAmount` decimal(10,2) DEFAULT NULL,
  `refundProcessedAt` timestamp NULL DEFAULT NULL,
  `stripeRefundID` varchar(255) DEFAULT NULL,
  `renterConfirmedReturn` tinyint(1) NOT NULL DEFAULT 0,
  `renterConfirmedAt` timestamp NULL DEFAULT NULL,
  `renterReturnNotes` text DEFAULT NULL,
  `ownerConfirmedReturn` tinyint(1) NOT NULL DEFAULT 0,
  `ownerConfirmedAt` timestamp NULL DEFAULT NULL,
  `ownerReturnNotes` text DEFAULT NULL,
  `hasActiveIssue` tinyint(1) NOT NULL DEFAULT 0,
  `currentIssueID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workforce_payments`
--

INSERT INTO `workforce_payments` (`workforcePaymentID`, `itemID`, `workforceID`, `buyerUserID`, `sellerCompanyID`, `stripeSessionID`, `stripePaymentIntentID`, `grossAmount`, `commissionPercent`, `commissionAmount`, `netAmount`, `currency`, `rentalStartDate`, `rentalEndDate`, `rentalType`, `paymentStatus`, `orderStatus`, `rentalRequestStatus`, `requestApprovedAt`, `requestApprovedBy`, `paymentMetadata`, `createdAt`, `updatedAt`, `cancelledBy`, `cancelledAt`, `cancellationReason`, `refundAmount`, `refundProcessedAt`, `stripeRefundID`, `renterConfirmedReturn`, `renterConfirmedAt`, `renterReturnNotes`, `ownerConfirmedReturn`, `ownerConfirmedAt`, `ownerReturnNotes`, `hasActiveIssue`, `currentIssueID`) VALUES
(4, 1, 1, 14, 1, NULL, NULL, 648.00, 4.50, 29.16, 618.84, 'USD', '2026-01-01', '2026-01-03', 'daily', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 18:42:50', '2026-03-17 18:42:50', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL),
(5, 1, 1, 14, 1, NULL, NULL, 648.00, 4.50, 29.16, 618.84, 'USD', '2026-01-01', '2026-01-03', 'daily', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 18:43:39', '2026-03-17 18:43:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL),
(6, 1, 1, 14, 1, NULL, NULL, 648.00, 4.50, 29.16, 618.84, 'USD', '2026-01-05', '2026-01-07', 'daily', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 18:49:32', '2026-03-17 18:49:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL),
(7, 1, 1, 14, 1, NULL, NULL, 648.00, 4.50, 29.16, 618.84, 'USD', '2026-01-01', '2026-01-03', 'daily', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 18:51:31', '2026-03-17 18:51:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL),
(8, 1, 1, 14, 1, NULL, NULL, 648.00, 4.50, 29.16, 618.84, 'USD', '2026-01-01', '2026-01-03', 'daily', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-03-17 20:14:17', '2026-03-17 20:14:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL),
(9, 1, 1, 14, 1, NULL, 'pi_3TIZ5cRvTgzTht4w06HzFC0s', 2268.00, 4.50, 102.06, 2165.94, 'USD', '2026-01-01', '2026-01-07', 'daily', 'paid', 'completed', 'rental_completed', '2026-04-04 15:34:43', 1, '{\"equipment_amount\":\"2268.00\",\"delivery_amount\":\"0.00\",\"total_amount\":\"2268.00\",\"delivery_method\":1,\"customer_email\":\"muhammadalizahid0621@gmail.com\",\"customer_phone\":\"+923326876256\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\",\"pickup_ready_by\":1,\"pickup_ready_at\":\"2026-04-04 20:38:58\",\"pickup_confirmed_by\":14,\"pickup_confirmed_at\":\"2026-04-04 20:39:20\",\"delivery_confirmation_method\":\"pickup\"}', '2026-04-04 15:34:26', '2026-04-04 15:39:37', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-04 15:39:28', '', 1, '2026-04-04 15:39:37', 'Confirmed from orders list', 0, NULL),
(10, 13, 5, 14, 1, NULL, NULL, 2250.00, 4.50, 101.25, 2148.75, 'USD', '2026-05-07', '2026-05-15', 'weekly', 'pending', 'requested', 'request_pending', NULL, NULL, '{\"equipment_amount\":\"2250.00\",\"delivery_amount\":\"0.00\",\"delivery_method\":1,\"customer_email\":\"\",\"customer_phone\":\"\",\"delivery_name\":\"\",\"delivery_street\":\"\",\"delivery_city\":\"\",\"delivery_postal\":\"\",\"delivery_country\":\"\",\"delivery_notes\":\"\"}', '2026-04-24 11:00:51', '2026-04-24 11:00:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workforce_payouts`
--

CREATE TABLE `workforce_payouts` (
  `workforcePayoutID` int(11) NOT NULL,
  `workforcePaymentID` int(11) NOT NULL COMMENT 'FK to workforce_payments',
  `companyID` int(11) NOT NULL COMMENT 'FK to companydetail',
  `payoutAmount` decimal(10,2) NOT NULL COMMENT 'Net amount to be paid out',
  `payoutStatus` enum('pending','approved','released','rejected') NOT NULL DEFAULT 'pending',
  `approvedBy` int(11) DEFAULT NULL COMMENT 'SuperAdmin userID',
  `approvedAt` timestamp NULL DEFAULT NULL,
  `payoutNotes` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workforce_payouts`
--

INSERT INTO `workforce_payouts` (`workforcePayoutID`, `workforcePaymentID`, `companyID`, `payoutAmount`, `payoutStatus`, `approvedBy`, `approvedAt`, `payoutNotes`, `createdAt`, `updatedAt`) VALUES
(1, 9, 1, 2165.94, 'pending', NULL, NULL, NULL, '2026-04-04 18:39:37', '2026-04-04 18:39:37');

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
-- Indexes for table `equipment_payments`
--
ALTER TABLE `equipment_payments`
  ADD PRIMARY KEY (`equipmentPaymentID`),
  ADD UNIQUE KEY `unique_stripe_session` (`stripeSessionID`),
  ADD KEY `idx_buyer` (`buyerUserID`),
  ADD KEY `idx_seller` (`sellerCompanyID`),
  ADD KEY `idx_item` (`itemID`),
  ADD KEY `idx_equipment` (`equipmentID`),
  ADD KEY `idx_payment_status` (`paymentStatus`),
  ADD KEY `idx_created` (`createdAt`),
  ADD KEY `idx_order_status` (`orderStatus`),
  ADD KEY `idx_seller_status` (`sellerCompanyID`,`orderStatus`),
  ADD KEY `idx_buyer_status` (`buyerUserID`,`orderStatus`),
  ADD KEY `idx_checkout_token` (`checkoutToken`),
  ADD KEY `fk_approved_by_user` (`approvedBy`),
  ADD KEY `fk_shipped_by_user` (`shippedBy`),
  ADD KEY `fk_delivered_by_user` (`deliveredBy`),
  ADD KEY `idx_rental_status` (`rentalRequestStatus`,`orderStatus`,`rentalStartDate`,`rentalEndDate`),
  ADD KEY `idx_ep_cancelled` (`rentalRequestStatus`,`cancelledAt`),
  ADD KEY `fk_ep_current_issue` (`currentIssueID`);

--
-- Indexes for table `equipment_payouts`
--
ALTER TABLE `equipment_payouts`
  ADD PRIMARY KEY (`equipmentPayoutID`),
  ADD UNIQUE KEY `unique_payment_payout` (`equipmentPaymentID`),
  ADD KEY `idx_company` (`companyID`),
  ADD KEY `idx_status` (`payoutStatus`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `idx_notif_user_unread` (`userID`,`isRead`,`createdAt`),
  ADD KEY `idx_notif_created` (`createdAt`),
  ADD KEY `relatedOrderID` (`relatedOrderID`),
  ADD KEY `relatedIssueID` (`relatedIssueID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `idx_equipmentPaymentID` (`equipmentPaymentID`),
  ADD KEY `idx_workforcePaymentID` (`workforcePaymentID`);

--
-- Indexes for table `order_chats`
--
ALTER TABLE `order_chats`
  ADD PRIMARY KEY (`chatID`),
  ADD KEY `fk_oc_dispute_issue` (`disputeIssueID`);

--
-- Indexes for table `order_chat_messages`
--
ALTER TABLE `order_chat_messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `idx_chat_time` (`chatID`,`createdAt`);

--
-- Indexes for table `projectcategory`
--
ALTER TABLE `projectcategory`
  ADD PRIMARY KEY (`pCatID`);

--
-- Indexes for table `projectequipmentassign`
--
ALTER TABLE `projectequipmentassign`
  ADD PRIMARY KEY (`assignID`),
  ADD KEY `idx_projectequipmentassign_workforceID` (`workforceID`);

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
  ADD PRIMARY KEY (`projectWorkforceLinkID`),
  ADD KEY `idx_projectworkforcelink_workforceID` (`workforceID`);

--
-- Indexes for table `rental_completion_log`
--
ALTER TABLE `rental_completion_log`
  ADD PRIMARY KEY (`completionID`),
  ADD KEY `idx_dates` (`completionDate`),
  ADD KEY `idx_returned` (`quantityReturned`);

--
-- Indexes for table `rental_issues`
--
ALTER TABLE `rental_issues`
  ADD PRIMARY KEY (`issueID`),
  ADD KEY `idx_ri_status` (`issueStatus`,`reportedAt`),
  ADD KEY `idx_ri_order` (`orderID`),
  ADD KEY `idx_ri_reporter` (`reportedBy`),
  ADD KEY `equipmentPaymentID` (`equipmentPaymentID`),
  ADD KEY `workforcePaymentID` (`workforcePaymentID`);

--
-- Indexes for table `rental_quantity_locks`
--
ALTER TABLE `rental_quantity_locks`
  ADD PRIMARY KEY (`lockID`),
  ADD KEY `equipmentPaymentID` (`equipmentPaymentID`),
  ADD KEY `idx_equipment_dates` (`equipmentID`,`rentalStartDate`,`rentalEndDate`),
  ADD KEY `idx_status` (`lockStatus`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`),
  ADD UNIQUE KEY `uniq_reviewer_order` (`reviewerID`,`orderID`),
  ADD KEY `idx_reviewee_created` (`revieweeID`,`createdAt`),
  ADD KEY `idx_order_created` (`orderID`,`createdAt`),
  ADD KEY `idx_transaction_type` (`transactionType`),
  ADD KEY `fk_reviews_equipment_payment` (`equipmentPaymentID`),
  ADD KEY `fk_reviews_workforce_payment` (`workforcePaymentID`);

--
-- Indexes for table `review_media`
--
ALTER TABLE `review_media`
  ADD PRIMARY KEY (`mediaID`),
  ADD KEY `idx_review_media_review` (`reviewID`);

--
-- Indexes for table `review_reports`
--
ALTER TABLE `review_reports`
  ADD PRIMARY KEY (`reportID`),
  ADD UNIQUE KEY `uniq_reporter_review` (`reviewID`,`reportedBy`),
  ADD KEY `idx_report_status` (`status`,`createdAt`),
  ADD KEY `fk_review_reports_user` (`reportedBy`);

--
-- Indexes for table `shopequipments`
--
ALTER TABLE `shopequipments`
  ADD PRIMARY KEY (`shopEqpID`);

--
-- Indexes for table `shopitem`
--
ALTER TABLE `shopitem`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `shopworkforce`
--
ALTER TABLE `shopworkforce`
  ADD PRIMARY KEY (`shopWorkforceID`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skillID`);

--
-- Indexes for table `supportticketchat`
--
ALTER TABLE `supportticketchat`
  ADD PRIMARY KEY (`chatID`);

--
-- Indexes for table `supporttickets`
--
ALTER TABLE `supporttickets`
  ADD PRIMARY KEY (`supportTicketID`);

--
-- Indexes for table `supportticketscat`
--
ALTER TABLE `supportticketscat`
  ADD PRIMARY KEY (`supportTicketsCatID`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`settingID`),
  ADD UNIQUE KEY `unique_setting_key` (`settingKey`);

--
-- Indexes for table `userauth`
--
ALTER TABLE `userauth`
  ADD PRIMARY KEY (`authID`);

--
-- Indexes for table `usercompanyworkforcelink`
--
ALTER TABLE `usercompanyworkforcelink`
  ADD PRIMARY KEY (`userCompanyWorkforceLinkID`),
  ADD KEY `idx_usercompanyworkforcelink_userID` (`userID`),
  ADD KEY `idx_usercompanyworkforcelink_workforceID` (`workforceID`);

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
-- Indexes for table `web_blog_cat`
--
ALTER TABLE `web_blog_cat`
  ADD PRIMARY KEY (`blogCatID`);

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
-- Indexes for table `web_contact_form`
--
ALTER TABLE `web_contact_form`
  ADD PRIMARY KEY (`contactID`);

--
-- Indexes for table `web_pages`
--
ALTER TABLE `web_pages`
  ADD PRIMARY KEY (`pageID`);

--
-- Indexes for table `web_page_meta`
--
ALTER TABLE `web_page_meta`
  ADD PRIMARY KEY (`metaID`);

--
-- Indexes for table `web_setting`
--
ALTER TABLE `web_setting`
  ADD PRIMARY KEY (`settingID`);

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
-- Indexes for table `workforce_payments`
--
ALTER TABLE `workforce_payments`
  ADD PRIMARY KEY (`workforcePaymentID`),
  ADD UNIQUE KEY `unique_stripe_session` (`stripeSessionID`),
  ADD KEY `idx_buyer` (`buyerUserID`),
  ADD KEY `idx_seller` (`sellerCompanyID`),
  ADD KEY `idx_item` (`itemID`),
  ADD KEY `idx_workforce` (`workforceID`),
  ADD KEY `idx_payment_status` (`paymentStatus`),
  ADD KEY `idx_created` (`createdAt`),
  ADD KEY `idx_rental_status` (`rentalRequestStatus`,`paymentStatus`,`rentalStartDate`,`rentalEndDate`),
  ADD KEY `idx_wp_cancelled` (`rentalRequestStatus`,`cancelledAt`),
  ADD KEY `fk_wp_current_issue` (`currentIssueID`),
  ADD KEY `idx_order_status` (`orderStatus`),
  ADD KEY `idx_seller_status` (`sellerCompanyID`,`orderStatus`),
  ADD KEY `idx_buyer_status` (`buyerUserID`,`orderStatus`);

--
-- Indexes for table `workforce_payouts`
--
ALTER TABLE `workforce_payouts`
  ADD PRIMARY KEY (`workforcePayoutID`),
  ADD UNIQUE KEY `unique_payment_payout` (`workforcePaymentID`),
  ADD KEY `idx_company` (`companyID`),
  ADD KEY `idx_status` (`payoutStatus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companydetail`
--
ALTER TABLE `companydetail`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `equipment_payments`
--
ALTER TABLE `equipment_payments`
  MODIFY `equipmentPaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `equipment_payouts`
--
ALTER TABLE `equipment_payouts`
  MODIFY `equipmentPayoutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `order_chats`
--
ALTER TABLE `order_chats`
  MODIFY `chatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `order_chat_messages`
--
ALTER TABLE `order_chat_messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `projectcategory`
--
ALTER TABLE `projectcategory`
  MODIFY `pCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projectequipmentassign`
--
ALTER TABLE `projectequipmentassign`
  MODIFY `assignID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectequipmentlink`
--
ALTER TABLE `projectequipmentlink`
  MODIFY `projectequipmentLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projectworkforcelink`
--
ALTER TABLE `projectworkforcelink`
  MODIFY `projectWorkforceLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rental_completion_log`
--
ALTER TABLE `rental_completion_log`
  MODIFY `completionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rental_issues`
--
ALTER TABLE `rental_issues`
  MODIFY `issueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rental_quantity_locks`
--
ALTER TABLE `rental_quantity_locks`
  MODIFY `lockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_media`
--
ALTER TABLE `review_media`
  MODIFY `mediaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_reports`
--
ALTER TABLE `review_reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopequipments`
--
ALTER TABLE `shopequipments`
  MODIFY `shopEqpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shopitem`
--
ALTER TABLE `shopitem`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `shopworkforce`
--
ALTER TABLE `shopworkforce`
  MODIFY `shopWorkforceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skillID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `supportticketchat`
--
ALTER TABLE `supportticketchat`
  MODIFY `chatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `supporttickets`
--
ALTER TABLE `supporttickets`
  MODIFY `supportTicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supportticketscat`
--
ALTER TABLE `supportticketscat`
  MODIFY `supportTicketsCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `settingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userauth`
--
ALTER TABLE `userauth`
  MODIFY `authID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `usercompanyworkforcelink`
--
ALTER TABLE `usercompanyworkforcelink`
  MODIFY `userCompanyWorkforceLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `web_blogs`
--
ALTER TABLE `web_blogs`
  MODIFY `web_blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `web_blog_cat`
--
ALTER TABLE `web_blog_cat`
  MODIFY `blogCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `web_cat`
--
ALTER TABLE `web_cat`
  MODIFY `web_catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `web_company`
--
ALTER TABLE `web_company`
  MODIFY `web_companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `web_contact_form`
--
ALTER TABLE `web_contact_form`
  MODIFY `contactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `web_pages`
--
ALTER TABLE `web_pages`
  MODIFY `pageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `web_page_meta`
--
ALTER TABLE `web_page_meta`
  MODIFY `metaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `web_setting`
--
ALTER TABLE `web_setting`
  MODIFY `settingID` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `web_success`
--
ALTER TABLE `web_success`
  MODIFY `web_successID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `web_testimonial`
--
ALTER TABLE `web_testimonial`
  MODIFY `web_testimonialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workforce`
--
ALTER TABLE `workforce`
  MODIFY `workforceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `workforceskilllink`
--
ALTER TABLE `workforceskilllink`
  MODIFY `workforceSkillLinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `workforce_payments`
--
ALTER TABLE `workforce_payments`
  MODIFY `workforcePaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `workforce_payouts`
--
ALTER TABLE `workforce_payouts`
  MODIFY `workforcePayoutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment_payments`
--
ALTER TABLE `equipment_payments`
  ADD CONSTRAINT `fk_approved_by_user` FOREIGN KEY (`approvedBy`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_delivered_by_user` FOREIGN KEY (`deliveredBy`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ep_current_issue` FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues` (`issueID`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_equip_pay_buyer` FOREIGN KEY (`buyerUserID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `fk_equip_pay_equipment` FOREIGN KEY (`equipmentID`) REFERENCES `equipment` (`equipmentID`),
  ADD CONSTRAINT `fk_equip_pay_item` FOREIGN KEY (`itemID`) REFERENCES `shopitem` (`itemID`),
  ADD CONSTRAINT `fk_equip_pay_seller` FOREIGN KEY (`sellerCompanyID`) REFERENCES `companydetail` (`companyID`),
  ADD CONSTRAINT `fk_shipped_by_user` FOREIGN KEY (`shippedBy`) REFERENCES `users` (`userID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `equipment_payouts`
--
ALTER TABLE `equipment_payouts`
  ADD CONSTRAINT `fk_equip_payout_company` FOREIGN KEY (`companyID`) REFERENCES `companydetail` (`companyID`),
  ADD CONSTRAINT `fk_equip_payout_payment` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`relatedOrderID`) REFERENCES `orders` (`orderID`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`relatedIssueID`) REFERENCES `rental_issues` (`issueID`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_equipment_payment` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_workforce_payment` FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments` (`workforcePaymentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_chats`
--
ALTER TABLE `order_chats`
  ADD CONSTRAINT `fk_oc_dispute_issue` FOREIGN KEY (`disputeIssueID`) REFERENCES `rental_issues` (`issueID`) ON DELETE SET NULL;

--
-- Constraints for table `rental_issues`
--
ALTER TABLE `rental_issues`
  ADD CONSTRAINT `rental_issues_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_issues_ibfk_2` FOREIGN KEY (`reportedBy`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_issues_ibfk_3` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`) ON DELETE SET NULL,
  ADD CONSTRAINT `rental_issues_ibfk_4` FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments` (`workforcePaymentID`) ON DELETE SET NULL;

--
-- Constraints for table `rental_quantity_locks`
--
ALTER TABLE `rental_quantity_locks`
  ADD CONSTRAINT `rental_quantity_locks_ibfk_1` FOREIGN KEY (`equipmentID`) REFERENCES `equipment` (`equipmentID`),
  ADD CONSTRAINT `rental_quantity_locks_ibfk_2` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_equipment_payment` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_reviewee` FOREIGN KEY (`revieweeID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_reviewer` FOREIGN KEY (`reviewerID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_workforce_payment` FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments` (`workforcePaymentID`) ON DELETE SET NULL;

--
-- Constraints for table `review_media`
--
ALTER TABLE `review_media`
  ADD CONSTRAINT `fk_review_media_review` FOREIGN KEY (`reviewID`) REFERENCES `reviews` (`reviewID`) ON DELETE CASCADE;

--
-- Constraints for table `review_reports`
--
ALTER TABLE `review_reports`
  ADD CONSTRAINT `fk_review_reports_review` FOREIGN KEY (`reviewID`) REFERENCES `reviews` (`reviewID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_reports_user` FOREIGN KEY (`reportedBy`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `workforce_payments`
--
ALTER TABLE `workforce_payments`
  ADD CONSTRAINT `fk_work_pay_buyer` FOREIGN KEY (`buyerUserID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `fk_work_pay_item` FOREIGN KEY (`itemID`) REFERENCES `shopitem` (`itemID`),
  ADD CONSTRAINT `fk_work_pay_seller` FOREIGN KEY (`sellerCompanyID`) REFERENCES `companydetail` (`companyID`),
  ADD CONSTRAINT `fk_work_pay_workforce` FOREIGN KEY (`workforceID`) REFERENCES `workforce` (`workforceID`),
  ADD CONSTRAINT `fk_wp_current_issue` FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues` (`issueID`) ON DELETE SET NULL;

--
-- Constraints for table `workforce_payouts`
--
ALTER TABLE `workforce_payouts`
  ADD CONSTRAINT `fk_work_payout_company` FOREIGN KEY (`companyID`) REFERENCES `companydetail` (`companyID`),
  ADD CONSTRAINT `fk_work_payout_payment` FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments` (`workforcePaymentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
