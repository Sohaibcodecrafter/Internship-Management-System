-- ============================================================
-- IMS MIGRATION: New tables for Modules 2-5
-- Run AFTER 01_schema.sql + 02_sample_data.sql
-- ============================================================
USE ims_db;

-- Notifications table
CREATE TABLE IF NOT EXISTS notifications (
    notif_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    message    TEXT NOT NULL,
    is_read    TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Reviews table
CREATE TABLE IF NOT EXISTS reviews (
    review_id  INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    company_id INT NOT NULL,
    rating     INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment    TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_student_company (student_id, company_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE
);

-- Add is_active to users if not exists
-- MySQL doesn't support IF NOT EXISTS for columns, so use a procedure
DELIMITER //
CREATE PROCEDURE add_is_active_column()
BEGIN
    IF NOT EXISTS (
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA='ims_db' AND TABLE_NAME='users' AND COLUMN_NAME='is_active'
    ) THEN
        ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER role;
    END IF;
END //
DELIMITER ;
CALL add_is_active_column();
DROP PROCEDURE IF EXISTS add_is_active_column;

-- Add cv_file to students if not exists
DELIMITER //
CREATE PROCEDURE add_cv_column()
BEGIN
    IF NOT EXISTS (
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA='ims_db' AND TABLE_NAME='students' AND COLUMN_NAME='cv_file'
    ) THEN
        ALTER TABLE students ADD COLUMN cv_file VARCHAR(255) DEFAULT NULL;
    END IF;
END //
DELIMITER ;
CALL add_cv_column();
DROP PROCEDURE IF EXISTS add_cv_column;

-- Add profile_pic to students if not exists
DELIMITER //
CREATE PROCEDURE add_pic_column()
BEGIN
    IF NOT EXISTS (
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA='ims_db' AND TABLE_NAME='students' AND COLUMN_NAME='profile_pic'
    ) THEN
        ALTER TABLE students ADD COLUMN profile_pic VARCHAR(255) DEFAULT NULL;
    END IF;
END //
DELIMITER ;
CALL add_pic_column();
DROP PROCEDURE IF EXISTS add_pic_column;
