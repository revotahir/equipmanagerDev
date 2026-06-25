START TRANSACTION;

CREATE TABLE IF NOT EXISTS `reviews` (
  `reviewID` int(11) NOT NULL AUTO_INCREMENT,
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
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`reviewID`),
  UNIQUE KEY `uniq_reviewer_order` (`reviewerID`,`orderID`),
  KEY `idx_reviewee_created` (`revieweeID`,`createdAt`),
  KEY `idx_order_created` (`orderID`,`createdAt`),
  KEY `idx_transaction_type` (`transactionType`),
  CONSTRAINT `fk_reviews_order` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_equipment_payment` FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments` (`equipmentPaymentID`) ON DELETE SET NULL,
  CONSTRAINT `fk_reviews_workforce_payment` FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments` (`workforcePaymentID`) ON DELETE SET NULL,
  CONSTRAINT `fk_reviews_reviewer` FOREIGN KEY (`reviewerID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_reviewee` FOREIGN KEY (`revieweeID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  CONSTRAINT `chk_reviews_rating` CHECK (`rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `review_media` (
  `mediaID` int(11) NOT NULL AUTO_INCREMENT,
  `reviewID` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `mimeType` varchar(100) NOT NULL,
  `fileSize` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`mediaID`),
  KEY `idx_review_media_review` (`reviewID`),
  CONSTRAINT `fk_review_media_review` FOREIGN KEY (`reviewID`) REFERENCES `reviews` (`reviewID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `review_reports` (
  `reportID` int(11) NOT NULL AUTO_INCREMENT,
  `reviewID` int(11) NOT NULL,
  `reportedBy` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `status` enum('open','dismissed','actioned') NOT NULL DEFAULT 'open',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`reportID`),
  UNIQUE KEY `uniq_reporter_review` (`reviewID`,`reportedBy`),
  KEY `idx_report_status` (`status`,`createdAt`),
  CONSTRAINT `fk_review_reports_review` FOREIGN KEY (`reviewID`) REFERENCES `reviews` (`reviewID`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_reports_user` FOREIGN KEY (`reportedBy`) REFERENCES `users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `notifications`
  MODIFY COLUMN `notificationType` enum(
    'rental_request_created',
    'rental_approved',
    'rental_rejected',
    'rental_cancelled',
    'rental_started',
    'rental_overdue',
    'rental_completed',
    'payment_received',
    'payment_released',
    'issue_reported',
    'issue_resolved',
    'return_requested',
    'return_confirmed',
    'checkout_link_expiring',
    'checkout_link_expired',
    'review_requested',
    'review_received'
  ) NOT NULL;

COMMIT;
