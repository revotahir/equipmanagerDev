-- ============================================================
-- EquipManager Rental Lifecycle - FIXUP Migration
-- Runs the remaining statements after the first migration
-- partially failed due to FK type mismatch on orderID
-- orders.orderID = INT(11), not VARCHAR(50)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. CREATE TABLE: rental_issues (corrected FK types)
-- ============================================================
CREATE TABLE IF NOT EXISTS `rental_issues` (
    `issueID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

    -- Link to payment record
    `equipmentPaymentID` INT(11) NULL,
    `workforcePaymentID` INT(11) NULL,
    `orderID` INT(11) NOT NULL,

    -- Issue details
    `issueType` ENUM('late_delivery','late_return','damaged','missing_parts','malfunction','other') NOT NULL,
    `issueTitle` VARCHAR(255) NOT NULL,
    `issueDescription` TEXT NOT NULL,

    -- Reporter details
    `reportedBy` INT(11) NOT NULL,
    `reporterType` ENUM('renter','owner') NOT NULL,
    `reportedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Status tracking
    `issueStatus` ENUM('reported','under_review','resolved','closed') NOT NULL DEFAULT 'reported',
    `assignedToAdmin` INT(11) NULL,

    -- Resolution
    `resolutionNotes` TEXT NULL,
    `resolutionOutcome` ENUM('refund_full','refund_partial','compensation','no_action','insurance_claim') NULL,
    `resolvedAt` TIMESTAMP NULL,
    `resolvedBy` INT(11) NULL,

    -- Financial impact
    `refundAmount` DECIMAL(10,2) NULL,
    `compensationAmount` DECIMAL(10,2) NULL,

    -- Attachments
    `attachmentUrls` JSON NULL,

    -- Timestamps
    `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Indexes
    INDEX `idx_ri_status` (`issueStatus`, `reportedAt`),
    INDEX `idx_ri_order` (`orderID`),
    INDEX `idx_ri_reporter` (`reportedBy`),

    FOREIGN KEY (`orderID`) REFERENCES `orders`(`orderID`) ON DELETE CASCADE,
    FOREIGN KEY (`reportedBy`) REFERENCES `users`(`userID`) ON DELETE CASCADE,
    FOREIGN KEY (`equipmentPaymentID`) REFERENCES `equipment_payments`(`equipmentPaymentID`) ON DELETE SET NULL,
    FOREIGN KEY (`workforcePaymentID`) REFERENCES `workforce_payments`(`workforcePaymentID`) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- 2. ADD ISSUE FLAGS: equipment_payments
-- ============================================================
ALTER TABLE `equipment_payments`
ADD COLUMN IF NOT EXISTS `hasActiveIssue` TINYINT(1) NOT NULL DEFAULT 0 AFTER `ownerReturnNotes`,
ADD COLUMN IF NOT EXISTS `currentIssueID` INT(11) NULL AFTER `hasActiveIssue`;

-- Add FK separately (will silently fail if constraint already exists)
ALTER TABLE `equipment_payments`
ADD CONSTRAINT `fk_ep_current_issue`
FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 3. ADD ISSUE FLAGS: workforce_payments
-- ============================================================
ALTER TABLE `workforce_payments`
ADD COLUMN IF NOT EXISTS `hasActiveIssue` TINYINT(1) NOT NULL DEFAULT 0 AFTER `ownerReturnNotes`,
ADD COLUMN IF NOT EXISTS `currentIssueID` INT(11) NULL;

ALTER TABLE `workforce_payments`
ADD CONSTRAINT `fk_wp_current_issue`
FOREIGN KEY (`currentIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 4. UPDATE order_chats: dispute support
-- ============================================================
ALTER TABLE `order_chats`
ADD COLUMN IF NOT EXISTS `chatType` ENUM('standard','dispute') NOT NULL DEFAULT 'standard' AFTER `chatStatus`,
ADD COLUMN IF NOT EXISTS `disputeIssueID` INT(11) NULL AFTER `chatType`,
ADD COLUMN IF NOT EXISTS `superAdminJoinedAt` TIMESTAMP NULL AFTER `disputeIssueID`;

ALTER TABLE `order_chats`
ADD CONSTRAINT `fk_oc_dispute_issue`
FOREIGN KEY (`disputeIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL;

-- ============================================================
-- 5. CREATE TABLE: notifications (corrected FK types)
-- ============================================================
CREATE TABLE IF NOT EXISTS `notifications` (
    `notificationID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

    `userID` INT(11) NOT NULL,

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

    `relatedOrderID` INT(11) NULL,
    `relatedIssueID` INT(11) NULL,
    `actionUrl` VARCHAR(500) NULL,

    `isRead` TINYINT(1) NOT NULL DEFAULT 0,
    `readAt` TIMESTAMP NULL,
    `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX `idx_notif_user_unread` (`userID`, `isRead`, `createdAt`),
    INDEX `idx_notif_created` (`createdAt`),

    FOREIGN KEY (`userID`) REFERENCES `users`(`userID`) ON DELETE CASCADE,
    FOREIGN KEY (`relatedOrderID`) REFERENCES `orders`(`orderID`) ON DELETE SET NULL,
    FOREIGN KEY (`relatedIssueID`) REFERENCES `rental_issues`(`issueID`) ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- 6. UPDATE ENUMs (idempotent - won't fail if already done)
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

SET FOREIGN_KEY_CHECKS = 1;

-- FIXUP MIGRATION COMPLETE
