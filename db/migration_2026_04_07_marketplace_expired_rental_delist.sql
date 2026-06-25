-- Migration: Delist expired rental listings from marketplace
-- Date: 2026-04-07
-- Purpose:
--   1) Ensure rental listings with availability end date in the past are not live.
--   2) Keep purchase listings unaffected.

START TRANSACTION;

-- Equipment rentals: itemType=1, saleType=0
UPDATE shopitem si
INNER JOIN shopequipments se ON se.itemID = si.itemID
SET si.liveStatus = 0
WHERE si.itemType = 1
  AND si.saleType = 0
  AND si.liveStatus = 1
  AND se.eqpAvailableEnd IS NOT NULL
  AND se.eqpAvailableEnd <> '0000-00-00'
  AND DATE(se.eqpAvailableEnd) < CURDATE();

-- Workforce rentals: itemType=2
UPDATE shopitem si
INNER JOIN shopworkforce sw ON sw.itemID = si.itemID
SET si.liveStatus = 0
WHERE si.itemType = 2
  AND si.liveStatus = 1
  AND sw.workforceAvailableEnd IS NOT NULL
  AND sw.workforceAvailableEnd <> '0000-00-00'
  AND DATE(sw.workforceAvailableEnd) < CURDATE();

COMMIT;

-- Optional verification queries
-- SELECT COUNT(*) AS expired_equipment_still_live
-- FROM shopitem si
-- INNER JOIN shopequipments se ON se.itemID = si.itemID
-- WHERE si.itemType = 1
--   AND si.saleType = 0
--   AND si.liveStatus = 1
--   AND DATE(se.eqpAvailableEnd) < CURDATE();
--
-- SELECT COUNT(*) AS expired_workforce_still_live
-- FROM shopitem si
-- INNER JOIN shopworkforce sw ON sw.itemID = si.itemID
-- WHERE si.itemType = 2
--   AND si.liveStatus = 1
--   AND DATE(sw.workforceAvailableEnd) < CURDATE();
