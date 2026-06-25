-- Migration: Sync orderStatus with rentalRequestStatus for terminal rental outcomes
-- Date: 2026-04-07

START TRANSACTION;

-- Equipment rentals: request rejected should be reflected in orderStatus.
UPDATE equipment_payments
SET orderStatus = 'rejected', updatedAt = NOW()
WHERE LOWER(COALESCE(saleType, '')) IN ('rental', '0', '2')
  AND rentalRequestStatus = 'request_rejected'
  AND orderStatus <> 'rejected';

-- Workforce rentals: request rejected should be reflected in orderStatus.
UPDATE workforce_payments
SET orderStatus = 'rejected', updatedAt = NOW()
WHERE rentalRequestStatus = 'request_rejected'
  AND orderStatus <> 'rejected';

-- Equipment rentals: rental cancelled should be reflected in orderStatus.
UPDATE equipment_payments
SET orderStatus = 'cancelled', updatedAt = NOW()
WHERE LOWER(COALESCE(saleType, '')) IN ('rental', '0', '2')
  AND rentalRequestStatus = 'rental_cancelled'
  AND orderStatus <> 'cancelled';

-- Workforce rentals: rental cancelled should be reflected in orderStatus.
UPDATE workforce_payments
SET orderStatus = 'cancelled', updatedAt = NOW()
WHERE rentalRequestStatus = 'rental_cancelled'
  AND orderStatus <> 'cancelled';

COMMIT;
