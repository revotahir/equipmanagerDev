-- Migration: Cleanup corrupted notification/chat text placeholders and enforce utf8mb4
-- Date: 2026-04-07

START TRANSACTION;

-- Ensure notification/chat tables use utf8mb4 for future compatibility.
ALTER TABLE notifications CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE order_chat_messages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Remove known corrupted placeholder sequences in notification titles/bodies.
UPDATE notifications
SET
  notificationTitle = TRIM(REPLACE(REPLACE(REPLACE(REPLACE(notificationTitle, '????', ''), 'G��', ''), '�', ''), '  ', ' ')),
  notificationBody  = TRIM(REPLACE(REPLACE(REPLACE(REPLACE(notificationBody,  '????', ''), 'G��', ''), '�', ''), '  ', ' '));

-- Remove known corrupted placeholder sequences in automated chat messages.
UPDATE order_chat_messages
SET messageText = TRIM(REPLACE(REPLACE(REPLACE(REPLACE(messageText, '????', ''), 'G��', ''), '�', ''), '  ', ' '));

COMMIT;
