-- ============================================================
-- EquipManager Rental Lifecycle System - Database Migration
-- Created: 2026-03-20
-- Description: Adds cancellation, return confirmation, issue
--              reporting, dispute chat, and notification system.
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. UPDATE ENUM: equipment_payments.rentalRequestStatus
--    Add 'rental_overdue' and 'under_review'
-- ============================================================
ALTER TABLE `equipment_payments`
MODIFY COLUMN `rentalRequestStatus` ENUM(
    'request_pending',
    'request_approved',
    'request_rejected',
    'rental_active',
    'rental_overdue',
    'rental_completed',
    'rental_cancelled',
    'under_review'
) NULL DEFAULT 'request_pending';

-- ============================================================
-- 2. UPDATE ENUM: workforce_payments.rentalRequestStatus
-- ============================================================
ALTER TABLE `workforce_payments`
MODIFY COLUMN `rentalRequestStatus` ENUM(
    'request_pending',
    'request_approved',
    'request_rejected',
    'rental_active',
    'rental_overdue',
    'rental_completed',
    'rental_cancelled',
    'under_review'
) NULL DEFAULT 'request_pending';

-- ============================================================
-- 3. ADD CANCELLATION FIELDS: equipment_payments
-- ============================================================
ALTER TABLE `equipment_payments`
ADD COLUMN `cancelledBy` INT(11) NULL COMMENT 'UserID who initiated cancellation' AFTER `fundsReleasedAt`,
ADD COLUMN `cancelledAt` TIMESTAMP NULL AFTER `cancelledBy`,
ADD COLUMN `cancellationReason` TEXT NULL AFTER `cancelledAt`,
ADD COLUMN `refundAmount` DECIMAL(10,2) NULL COMMENT 'Amount refunded (may differ from grossAmount)' AFTER `cancellationReason`,
ADD COLUMN `refundProcessedAt` TIMESTAMP NULL AFTER `refundAmount`,
ADD COLUMN `stripeRefundID` VARCHAR(255) NULL COMMENT 'Stripe refund transaction ID' AFTER `refundProcessedAt`,
ADD INDEX `idx_ep_cancelled` (`rentalRequestStatus`, `cancelledAt`);

-- ============================================================
-- 4. ADD CANCELLATION FIELDS: workforce_payments
-- ============================================================
ALTER TABLE `workforce_payments`
ADD COLUMN `cancelledBy` INT(11) NULL COMMENT 'UserID who initiated cancellation',
ADD COLUMN `cancelledAt` TIMESTAMP NULL,
ADD COLUMN `cancellationReason` TEXT NULL,
ADD COLUMN `refundAmount` DECIMAL(10,2) NULL,
ADD COLUMN `refundProcessedAt` TIMESTAMP NULL,
ADD COLUMN `stripeRefundID` VARCHAR(255) NULL,
ADD INDEX `idx_wp_cancelled` (`rentalRequestStatus`, `cancelledAt`);

-- ============================================================
-- 5. ADD RETURN CONFIRMATION FIELDS: equipment_payments
-- ============================================================
ALTER TABLE `equipment_payments`
ADD COLUMN `renterConfirmedReturn` TINYINT(1) NOT NULL DEFAULT 0 AFTER `stripeRefundID`,
ADD COLUMN `renterConfirmedAt` TIMESTAMP NULL AFTER `renterConfirmedReturn`,
ADD COLUMN `renterReturnNotes` TEXT NULL AFTER `renterConfirmedAt`,
ADD COLUMN `ownerConfirmedReturn` TINYINT(1) NOT NULL DEFAULT 0 AFTER `renterReturnNotes`,
ADD COLUMN `ownerConfirmedAt` TIMESTAMP NULL AFTER `ownerConfirmedReturn`,
ADD COLUMN `ownerReturnNotes` TEXT NULL COMMENT 'Condition notes, damages, etc.' AFTER `ownerConfirmedAt`;

-- ============================================================
-- 6. ADD RETURN CONFIRMATION FIELDS: workforce_payments
-- ============================================================
ALTER TABLE `workforce_payments`
ADD COLUMN `renterConfirmedReturn` TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN `renterConfirmedAt` TIMESTAMP NULL,
ADD COLUMN `renterReturnNotes` TEXT NULL,
ADD COLUMN `ownerConfirmedReturn` TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN `ownerConfirmedAt` TIMESTAMP NULL,
ADD COLUMN `ownerReturnNotes` TEXT NULL;

-- ============================================================
-- 7. CREATE TABLE: rental_issues
-- ============================================================
CREATE TABLE IF NOT EXISTS `rental_issues` (
    `issueID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

    -- Link to payment record (one of these will be set)
    `equipmentPaymentID` INT(11) NULL,
    `workforcePaymentID` INT(11) NULL,
    `orderID` VARCHAR(50) NOT NULL,

    -- Issue details
    `issueType` ENUM('late_delivery','late_return','damaged','missing_parts','malfunction','other') NOT NULL,
    `issueTitle` VARCHAR(255) NOT NULL,
    `issueDescription` TEXT NOT NULL,

    -- Reporter details
    `reportedBy` INT(11) NOT NULL COMMENT 'UserID of reporter',
    `reporterType` ENUM('renter','owner') NOT NULL,
    `reportedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Status tracking
    `issueStatus` ENUM('reported','under_review','resolved','closed') NOT NULL DEFAULT 'reported',
    `assignedToAdmin` INT(11) NULL COMMENT 'SuperAdmin handling this',

    -- Resolution
    `resolutionNotes` TEXT NULL,
    `resolutionOutcome` ENUM('refund_full','refund_partial','compensation','no_action','insurance_claim') NULL,
    `resolvedAt` TIMESTAMP NULL,
    `resolvedBy` INT(11) NULL COMMENT 'SuperAdmin who resolved',

    -- Financial impact
    `refundAmount` DECIMAL(10,2) NULL,
    `compensationAmount` DECIMAL(10,2) NULL,

    -- Attachments (evidence photos - JSON array of URLs)
    `attachmentUrls` JSON NULL COMMENT 'Array of image URLs',

    -- Timestamps
    `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Indexes
    INDEX `idx_ri_status` (`issueStatus`, `reportedAt`),
    INDEX `idx_ri_order` (`orderID`),
    INDEX `idx_ri_reporter` (`reportedBy`),

    -- Foreign keys
    FOREIGN KEY (`orderID`) REFERENCES `orders`(`orderID`) ON DELETE CASCADE,
    FOREIGN KEY (`reportedBy`) REFERENCES `users`(`userID`) ON DELETE CASCADE,
    FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments`(`equipmentPaymentID`) ON DELETE SET NULL,
    FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments`(`workforcePaymentID`) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 8. ADD ISSUE FLAGS: equipment_payments
-- ============================================================
ALTER TABLE `equipment_payments`
ADD COLUMN `hasActiveIssue` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Flag for quick filtering' AFTER `ownerReturnNotes`,
ADD COLUMN `currentIssueID` INT(11) NULL AFTER `hasActiveIssue`,
ADD FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 9. ADD ISSUE FLAGS: workforce_payments
-- ============================================================
ALTER TABLE `workforce_payments`
ADD COLUMN `hasActiveIssue` TINYINT(1) NOT NULL DEFAULT 0 AFTER `ownerReturnNotes`,
ADD COLUMN `currentIssueID` INT(11) NULL,
ADD FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 10. UPDATE order_chats: add dispute & SuperAdmin support
-- ============================================================
ALTER TABLE `order_chats`
ADD COLUMN `chatType` ENUM('standard','dispute') NOT NULL DEFAULT 'standard' AFTER `chatStatus`,
ADD COLUMN `disputeIssueID` INT(11) NULL AFTER `chatType`,
ADD COLUMN `superAdminJoinedAt` TIMESTAMP NULL AFTER `disputeIssueID`,
ADD FOREIGN KEY (`disputeIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 11. CREATE TABLE: notifications
-- ============================================================
CREATE TABLE IF NOT EXISTS `notifications` (
    `notificationID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

    -- Recipient
    `userID` INT(11) NOT NULL COMMENT 'Recipient user',

    -- Notification content
    `notificationType` ENUM(
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
        'checkout_link_expired'
    ) NOT NULL,

    `notificationTitle` VARCHAR(255) NOT NULL,
    `notificationBody` TEXT NOT NULL,

    -- Links
    `relatedOrderID` VARCHAR(50) NULL,
    `relatedIssueID` INT(11) NULL,
    `actionUrl` VARCHAR(500) NULL COMMENT 'URL to navigate to on click',

    -- Status
    `isRead` TINYINT(1) NOT NULL DEFAULT 0,
    `readAt` TIMESTAMP NULL,
    `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Indexes
    INDEX `idx_notif_user_unread` (`userID`, `isRead`, `createdAt`),
    INDEX `idx_notif_created` (`createdAt`),

    -- Foreign keys
    FOREIGN KEY (`userID`) REFERENCES `users`(`userID`) ON DELETE CASCADE,
    FOREIGN KEY (`relatedOrderID`) REFERENCES `orders`(`orderID`) ON DELETE SET NULL,
    FOREIGN KEY (`relatedIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- MIGRATION COMPLETE
-- Tables modified: equipment_payments, workforce_payments,
--                  order_chats
-- Tables created: rental_issues, notifications
-- ============================================================
