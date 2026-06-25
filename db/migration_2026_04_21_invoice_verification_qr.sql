-- Migration: Invoice verification token support for QR-based authenticity checks
-- Date: 2026-04-21

START TRANSACTION;

-- Add persistent verification token fields to orders (used for invoice QR verification links)
ALTER TABLE `orders`
  ADD COLUMN IF NOT EXISTS `invoiceVerifyToken` varchar(96) DEFAULT NULL COMMENT 'Opaque token for public invoice verification' AFTER `workforcePaymentID`,
  ADD COLUMN IF NOT EXISTS `invoiceVerifyIssuedAt` timestamp NULL DEFAULT NULL COMMENT 'When invoice verification token was first generated' AFTER `invoiceVerifyToken`;

-- Ensure token uniqueness to prevent collisions
SET @idx_exists := (
  SELECT COUNT(1)
  FROM information_schema.statistics
  WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND index_name = 'uniq_invoice_verify_token'
);

SET @idx_sql := IF(
  @idx_exists = 0,
  'ALTER TABLE `orders` ADD UNIQUE KEY `uniq_invoice_verify_token` (`invoiceVerifyToken`)',
  'SELECT 1'
);

PREPARE stmt FROM @idx_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
