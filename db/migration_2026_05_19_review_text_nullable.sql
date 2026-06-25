-- Allow optional review text (rating-only reviews)
ALTER TABLE `reviews`
  MODIFY COLUMN `reviewText` VARCHAR(500) NULL;
