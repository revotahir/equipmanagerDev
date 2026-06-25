-- Migration: Rental Request System
-- Date: 2026-03-16
-- Purpose: Add rental request workflow with quantity locking/unlocking

-- Add columns to equipment_payments to track rental request status
ALTER TABLE equipment_payments
ADD COLUMN rentalRequestStatus ENUM('request_pending', 'request_approved', 'request_rejected', 'rental_active', 'rental_completed', 'rental_cancelled') DEFAULT 'request_pending' 
AFTER orderStatus;

ALTER TABLE equipment_payments
ADD COLUMN quantityLocked INT(11) DEFAULT 0 COMMENT 'Quantity locked for this rental when approved'
AFTER rentalRequestStatus;

ALTER TABLE equipment_payments
ADD COLUMN requestApprovedAt TIMESTAMP NULL 
AFTER quantityLocked;

ALTER TABLE equipment_payments
ADD COLUMN requestApprovedBy INT(11) DEFAULT NULL COMMENT 'Company admin user ID who approved'
AFTER requestApprovedAt;

-- Add same columns to workforce_payments
ALTER TABLE workforce_payments
ADD COLUMN rentalRequestStatus ENUM('request_pending', 'request_approved', 'request_rejected', 'rental_active', 'rental_completed', 'rental_cancelled') DEFAULT 'request_pending' 
AFTER paymentStatus;

ALTER TABLE workforce_payments
ADD COLUMN requestApprovedAt TIMESTAMP NULL 
AFTER rentalRequestStatus;

ALTER TABLE workforce_payments
ADD COLUMN requestApprovedBy INT(11) DEFAULT NULL COMMENT 'Company admin user ID who approved'
AFTER requestApprovedAt;

-- Create rental_quantity_locks table to track quantity reservations
CREATE TABLE IF NOT EXISTS rental_quantity_locks (
  lockID INT(11) NOT NULL AUTO_INCREMENT,
  equipmentID INT(11) NOT NULL,
  equipmentPaymentID INT(11) NOT NULL,
  quantity INT(11) NOT NULL,
  rentalStartDate DATE NOT NULL,
  rentalEndDate DATE NOT NULL,
  lockedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  unlockedAt TIMESTAMP NULL,
  lockStatus ENUM('locked', 'unlocked', 'released') NOT NULL DEFAULT 'locked',
  PRIMARY KEY (lockID),
  FOREIGN KEY (equipmentID) REFERENCES equipment(equipmentID),
  FOREIGN KEY (equipmentPaymentID) REFERENCES equipment_payments(equipmentPaymentID),
  INDEX idx_equipment_dates (equipmentID, rentalStartDate, rentalEndDate),
  INDEX idx_status (lockStatus)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create rental_completion_log table to track when rentals end
CREATE TABLE IF NOT EXISTS rental_completion_log (
  completionID INT(11) NOT NULL AUTO_INCREMENT,
  equipmentPaymentID INT(11) DEFAULT NULL,
  workforcePaymentID INT(11) DEFAULT NULL,
  itemType INT(11) NOT NULL COMMENT '1=equipment, 2=workforce',
  quantity INT(11) DEFAULT NULL,
  completionDate DATE NOT NULL,
  quantityReturned INT(11) DEFAULT NULL COMMENT 'How much inventory was returned',
  completedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (completionID),
  INDEX idx_dates (completionDate),
  INDEX idx_returned (quantityReturned)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Update equipment table to track rental-specific available quantity
ALTER TABLE equipment
ADD COLUMN equipRentalTotalQuantity INT(11) DEFAULT 0 COMMENT 'Total units available for rental'
AFTER equipTotalQuantity;

ALTER TABLE equipment
ADD COLUMN equipRentalLockedQuantity INT(11) DEFAULT 0 COMMENT 'Units currently locked for approved rentals'
AFTER equipRentalTotalQuantity;

-- Add index for equipment_payments rental status queries
ALTER TABLE equipment_payments
ADD INDEX idx_rental_status (rentalRequestStatus, orderStatus, rentalStartDate, rentalEndDate);

ALTER TABLE workforce_payments
ADD INDEX idx_rental_status (rentalRequestStatus, paymentStatus, rentalStartDate, rentalEndDate);
