-- ============================================================
-- ALTER: Add verification_requested to companies
-- Run if not already applied
-- ============================================================
USE ims_db;

-- Idempotent via procedure
DELIMITER //
CREATE PROCEDURE add_verification_col()
BEGIN
    IF NOT EXISTS (
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA='ims_db' AND TABLE_NAME='companies' AND COLUMN_NAME='verification_requested'
    ) THEN
        ALTER TABLE companies ADD COLUMN verification_requested TINYINT(1) DEFAULT 0 AFTER verified;
    END IF;
END //
DELIMITER ;
CALL add_verification_col();
DROP PROCEDURE IF EXISTS add_verification_col;
