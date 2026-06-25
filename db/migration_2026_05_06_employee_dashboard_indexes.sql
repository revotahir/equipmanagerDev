-- Employee dashboard performance indexes.
-- Safe to run repeatedly on MySQL/MariaDB.

SET @schema_name = DATABASE();

SET @sql = (
    SELECT IF(COUNT(*) = 0,
        'ALTER TABLE projectworkforcelink ADD INDEX idx_projectworkforcelink_workforceID (workforceID)',
        'SELECT 1'
    )
    FROM information_schema.statistics
    WHERE table_schema = @schema_name
      AND table_name = 'projectworkforcelink'
      AND index_name = 'idx_projectworkforcelink_workforceID'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = (
    SELECT IF(COUNT(*) = 0,
        'ALTER TABLE projectequipmentassign ADD INDEX idx_projectequipmentassign_workforceID (workforceID)',
        'SELECT 1'
    )
    FROM information_schema.statistics
    WHERE table_schema = @schema_name
      AND table_name = 'projectequipmentassign'
      AND index_name = 'idx_projectequipmentassign_workforceID'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = (
    SELECT IF(COUNT(*) = 0,
        'ALTER TABLE usercompanyworkforcelink ADD INDEX idx_usercompanyworkforcelink_userID (userID)',
        'SELECT 1'
    )
    FROM information_schema.statistics
    WHERE table_schema = @schema_name
      AND table_name = 'usercompanyworkforcelink'
      AND index_name = 'idx_usercompanyworkforcelink_userID'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = (
    SELECT IF(COUNT(*) = 0,
        'ALTER TABLE usercompanyworkforcelink ADD INDEX idx_usercompanyworkforcelink_workforceID (workforceID)',
        'SELECT 1'
    )
    FROM information_schema.statistics
    WHERE table_schema = @schema_name
      AND table_name = 'usercompanyworkforcelink'
      AND index_name = 'idx_usercompanyworkforcelink_workforceID'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
