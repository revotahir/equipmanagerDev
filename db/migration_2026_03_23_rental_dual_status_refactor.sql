-- Migration: Rental dual-status refactor
-- Date: 2026-03-23
-- Goal:
-- 1) Keep orderStatus for request/payment/fulfillment for BOTH equipment and workforce.
-- 2) Use rentalRequestStatus as rental lifecycle status after handover.

START TRANSACTION;

-- -----------------------------------------------------
-- 1) Add orderStatus to workforce_payments
-- -----------------------------------------------------
ALTER TABLE `workforce_payments`
  ADD COLUMN `orderStatus` ENUM(
    'requested','approved','rejected','payment_pending','payment_secured','payment_approved',
    'shipped','pickup_ready','delivered','completed','cancelled','refunded'
  ) NOT NULL DEFAULT 'requested' AFTER `paymentStatus`;

-- Backfill orderStatus from existing lifecycle states
UPDATE `workforce_payments`
SET `orderStatus` = CASE `rentalRequestStatus`
  WHEN 'request_pending' THEN 'requested'
  WHEN 'request_approved' THEN 'payment_pending'
  WHEN 'request_rejected' THEN 'rejected'
  WHEN 'rental_active' THEN 'delivered'
  WHEN 'rental_completed' THEN 'completed'
  WHEN 'rental_cancelled' THEN 'cancelled'
  ELSE 'requested'
END;

ALTER TABLE `workforce_payments`
  ADD KEY `idx_order_status` (`orderStatus`),
  ADD KEY `idx_seller_status` (`sellerCompanyID`,`orderStatus`),
  ADD KEY `idx_buyer_status` (`buyerUserID`,`orderStatus`);

-- -----------------------------------------------------
-- 2) Expand rental lifecycle enums
-- -----------------------------------------------------
ALTER TABLE `equipment_payments`
  MODIFY COLUMN `rentalRequestStatus` ENUM(
    'request_pending','request_approved','request_rejected','awaiting_handover',
    'rental_active','rental_overdue','return_requested','returned_by_renter',
    'received_by_owner','under_review','rental_completed','rental_cancelled'
  ) DEFAULT 'request_pending';

ALTER TABLE `workforce_payments`
  MODIFY COLUMN `rentalRequestStatus` ENUM(
    'request_pending','request_approved','request_rejected','awaiting_handover',
    'rental_active','rental_overdue','return_requested','returned_by_renter',
    'received_by_owner','under_review','rental_completed','rental_cancelled'
  ) DEFAULT 'request_pending';

COMMIT;
