-- Migration: Cleanup stuck received_by_owner rentals
-- Date: 2026-03-24
-- Goal:
-- 1) Finalize rentals stuck in received_by_owner when BOTH parties already confirmed return.
-- 2) Align orderStatus to completed for those finalized rentals.
--
-- Safe scope:
-- - Only rows with rentalRequestStatus='received_by_owner'
-- - Only rows with renterConfirmedReturn=1 AND ownerConfirmedReturn=1
-- - Does NOT touch active/incomplete returns

START TRANSACTION;

-- -----------------------------------------------------
-- Workforce payments cleanup
-- -----------------------------------------------------
UPDATE `workforce_payments`
SET
  `rentalRequestStatus` = 'rental_completed',
  `orderStatus` = 'completed',
  `updatedAt` = NOW()
WHERE `rentalRequestStatus` = 'received_by_owner'
  AND COALESCE(`renterConfirmedReturn`, 0) = 1
  AND COALESCE(`ownerConfirmedReturn`, 0) = 1;

-- -----------------------------------------------------
-- Equipment payments cleanup
-- -----------------------------------------------------
UPDATE `equipment_payments`
SET
  `rentalRequestStatus` = 'rental_completed',
  `orderStatus` = 'completed',
  `updatedAt` = NOW(),
  `completedAt` = COALESCE(`completedAt`, NOW())
WHERE `rentalRequestStatus` = 'received_by_owner'
  AND COALESCE(`renterConfirmedReturn`, 0) = 1
  AND COALESCE(`ownerConfirmedReturn`, 0) = 1;

COMMIT;
