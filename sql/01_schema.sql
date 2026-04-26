-- ============================================================
-- IMS DATABASE SCHEMA
-- Run this file first in phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS ims_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ims_db;

-- ----------------------------
-- DDL: TABLE CREATION
-- ----------------------------

CREATE TABLE users (
    user_id       INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('admin','student','company') NOT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE departments (
    dept_id   INT AUTO_INCREMENT PRIMARY KEY,
    dept_name VARCHAR(100) NOT NULL UNIQUE,
    dept_code VARCHAR(10)  NOT NULL UNIQUE
);

CREATE TABLE students (
    student_id      INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL UNIQUE,
    dept_id         INT NOT NULL,
    full_name       VARCHAR(100) NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    phone           VARCHAR(15),
    gpa             DECIMAL(3,2) CHECK (gpa >= 0.00 AND gpa <= 4.00),
    enrollment_year YEAR NOT NULL,
    status          ENUM('active','graduated','dropped') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
);

CREATE TABLE companies (
    company_id       INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT NOT NULL UNIQUE,
    company_name     VARCHAR(150) NOT NULL,
    industry         VARCHAR(100) NOT NULL,
    city             VARCHAR(100) NOT NULL,
    contact_email    VARCHAR(100) NOT NULL UNIQUE,
    contact_phone    VARCHAR(15),
    established_year YEAR,
    verified         TINYINT(1) DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE supervisors (
    supervisor_id INT AUTO_INCREMENT PRIMARY KEY,
    company_id    INT NOT NULL,
    full_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    designation   VARCHAR(100),
    salary        DECIMAL(10,2),
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE CASCADE
);

CREATE TABLE internships (
    internship_id    INT AUTO_INCREMENT PRIMARY KEY,
    company_id       INT NOT NULL,
    supervisor_id    INT,
    title            VARCHAR(150) NOT NULL,
    description      TEXT,
    domain           VARCHAR(100) NOT NULL,
    stipend          DECIMAL(10,2) DEFAULT 0.00,
    duration_months  INT NOT NULL CHECK (duration_months > 0),
    start_date       DATE NOT NULL,
    end_date         DATE NOT NULL,
    slots            INT DEFAULT 1,
    status           ENUM('open','closed','completed') DEFAULT 'open',
    FOREIGN KEY (company_id)   REFERENCES companies(company_id) ON DELETE CASCADE,
    FOREIGN KEY (supervisor_id) REFERENCES supervisors(supervisor_id) ON DELETE SET NULL
);

CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id     INT NOT NULL,
    internship_id  INT NOT NULL,
    applied_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    status         ENUM('pending','shortlisted','accepted','rejected') DEFAULT 'pending',
    cover_note     TEXT,
    reviewed_at    DATETIME,
    UNIQUE KEY uq_student_internship (student_id, internship_id),
    FOREIGN KEY (student_id)    REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (internship_id) REFERENCES internships(internship_id) ON DELETE CASCADE
);

CREATE TABLE placements (
    placement_id   INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL UNIQUE,
    start_date     DATE NOT NULL,
    end_date       DATE NOT NULL,
    actual_stipend DECIMAL(10,2),
    grade          VARCHAR(5),
    feedback       TEXT,
    completed      TINYINT(1) DEFAULT 0,
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE
);
