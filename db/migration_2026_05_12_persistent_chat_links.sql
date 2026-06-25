-- Persistent chat-to-order mapping
-- Date: 2026-05-12

START TRANSACTION;

CREATE TABLE IF NOT EXISTS `order_chat_links` (
  `linkID` INT NOT NULL AUTO_INCREMENT,
  `chatID` INT NOT NULL,
  `orderID` INT NOT NULL,
  `linkedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`linkID`),
  UNIQUE KEY `uniq_order_chat_links_order` (`orderID`),
  KEY `idx_order_chat_links_chat` (`chatID`),
  KEY `idx_order_chat_links_linked_at` (`linkedAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Backfill legacy order_chat mapping rows.
INSERT INTO `order_chat_links` (`chatID`, `orderID`, `linkedAt`)
SELECT oc.`chatID`, oc.`orderID`, COALESCE(oc.`createdAt`, NOW())
FROM `order_chats` oc
LEFT JOIN `order_chat_links` ocl ON ocl.`orderID` = oc.`orderID`
WHERE oc.`orderID` IS NOT NULL
  AND ocl.`orderID` IS NULL;

-- Normalize standard chat state: persistent chats must stay open 24/7.
UPDATE `order_chats`
SET `chatStatus` = 'open',
    `lockedAt` = NULL
WHERE `chatType` = 'standard'
  AND `chatStatus` <> 'open';

-- Canonicalize legacy mappings so all orders for one buyer/company pair point
-- to a single standard chat (oldest chatID in that pair).
UPDATE `order_chat_links` ocl
JOIN `orders` o ON o.`orderID` = ocl.`orderID`
LEFT JOIN `equipment_payments` ep ON ep.`equipmentPaymentID` = o.`equipmentPaymentID`
LEFT JOIN `workforce_payments` wp ON wp.`workforcePaymentID` = o.`workforcePaymentID`
JOIN (
    SELECT MIN(`chatID`) AS canonicalChatID, `buyerUserID`, `sellerCompanyID`
    FROM `order_chats`
    WHERE `chatType` = 'standard'
    GROUP BY `buyerUserID`, `sellerCompanyID`
) canon
  ON canon.`buyerUserID` = COALESCE(ep.`buyerUserID`, wp.`buyerUserID`)
 AND canon.`sellerCompanyID` = COALESCE(ep.`sellerCompanyID`, wp.`sellerCompanyID`)
SET ocl.`chatID` = canon.`canonicalChatID`;

-- Merge legacy standard-chat messages into canonical chat per buyer/company pair.
UPDATE `order_chat_messages` m
JOIN `order_chats` oc ON oc.`chatID` = m.`chatID`
JOIN (
    SELECT MIN(`chatID`) AS canonicalChatID, `buyerUserID`, `sellerCompanyID`
    FROM `order_chats`
    WHERE `chatType` = 'standard'
    GROUP BY `buyerUserID`, `sellerCompanyID`
) canon
  ON canon.`buyerUserID` = oc.`buyerUserID`
 AND canon.`sellerCompanyID` = oc.`sellerCompanyID`
SET m.`chatID` = canon.`canonicalChatID`
WHERE oc.`chatType` = 'standard'
  AND oc.`chatID` <> canon.`canonicalChatID`;

-- Remove orphan mappings before adding foreign keys.
-- Some legacy datasets can contain order IDs no longer present in `orders`.
DELETE ocl
FROM `order_chat_links` ocl
LEFT JOIN `orders` o ON o.`orderID` = ocl.`orderID`
WHERE o.`orderID` IS NULL
   OR ocl.`orderID` IS NULL
   OR ocl.`orderID` <= 0;

DELETE ocl
FROM `order_chat_links` ocl
LEFT JOIN `order_chats` oc ON oc.`chatID` = ocl.`chatID`
WHERE oc.`chatID` IS NULL
   OR ocl.`chatID` IS NULL
   OR ocl.`chatID` <= 0;

-- Helpful lookup indexes for persistent chat resolution.
SET @db_name := DATABASE();

SET @idx_sql := (
  SELECT IF(
    EXISTS (
      SELECT 1 FROM information_schema.statistics
      WHERE table_schema = @db_name
        AND table_name = 'order_chats'
        AND index_name = 'idx_order_chats_buyer_company_type'
    ),
    'SELECT 1',
    'ALTER TABLE `order_chats` ADD INDEX `idx_order_chats_buyer_company_type` (`buyerUserID`, `sellerCompanyID`, `chatType`)'
  )
);
PREPARE stmt FROM @idx_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @idx_sql := (
  SELECT IF(
    EXISTS (
      SELECT 1 FROM information_schema.statistics
      WHERE table_schema = @db_name
        AND table_name = 'order_chat_messages'
        AND index_name = 'idx_order_chat_messages_chat_created'
    ),
    'SELECT 1',
    'ALTER TABLE `order_chat_messages` ADD INDEX `idx_order_chat_messages_chat_created` (`chatID`, `createdAt`)'
  )
);
PREPARE stmt FROM @idx_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Add FK order_chat_links.chatID -> order_chats.chatID if missing.
SET @fk_sql := (
  SELECT IF(
    EXISTS (
      SELECT 1 FROM information_schema.referential_constraints
      WHERE constraint_schema = @db_name
        AND table_name = 'order_chat_links'
        AND constraint_name = 'fk_order_chat_links_chat'
    ),
    'SELECT 1',
    'ALTER TABLE `order_chat_links` ADD CONSTRAINT `fk_order_chat_links_chat` FOREIGN KEY (`chatID`) REFERENCES `order_chats`(`chatID`) ON DELETE CASCADE ON UPDATE CASCADE'
  )
);
PREPARE stmt FROM @fk_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Add FK order_chat_links.orderID -> orders.orderID if missing.
SET @fk_sql := (
  SELECT IF(
    EXISTS (
      SELECT 1 FROM information_schema.referential_constraints
      WHERE constraint_schema = @db_name
        AND table_name = 'order_chat_links'
        AND constraint_name = 'fk_order_chat_links_order'
    ),
    'SELECT 1',
    'ALTER TABLE `order_chat_links` ADD CONSTRAINT `fk_order_chat_links_order` FOREIGN KEY (`orderID`) REFERENCES `orders`(`orderID`) ON DELETE CASCADE ON UPDATE CASCADE'
  )
);
PREPARE stmt FROM @fk_sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

COMMIT;

