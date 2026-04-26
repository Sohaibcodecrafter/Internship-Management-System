USE ims_db;

-- ----------------------------
-- DML: INSERT SAMPLE DATA
-- ----------------------------

-- Users (passwords are bcrypt hashes of 'password123')
INSERT INTO users (username, password_hash, role) VALUES
('admin',        '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'admin'),
('ali_hassan',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student'),
('sara_iqbal',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student'),
('bilal_khan',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student'),
('zara_malik',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student'),
('usman_ch',     '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student'),
('techcorp_pk',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company'),
('netsol_tech',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company'),
('systems_ltd',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company');

-- Departments
INSERT INTO departments (dept_name, dept_code) VALUES
('Computer Science',        'CS'),
('Software Engineering',    'SE'),
('Information Technology',  'IT'),
('Electrical Engineering',  'EE'),
('Business Administration', 'BA');

-- Students
INSERT INTO students (user_id, dept_id, full_name, email, phone, gpa, enrollment_year) VALUES
(2, 1, 'Ali Hassan',    'ali.hassan@student.edu',   '03001234567', 3.75, 2021),
(3, 1, 'Sara Iqbal',    'sara.iqbal@student.edu',   '03009876543', 3.50, 2021),
(4, 2, 'Bilal Khan',    'bilal.khan@student.edu',   '03331234567', 3.20, 2022),
(5, 3, 'Zara Malik',    'zara.malik@student.edu',   '03451234567', 3.80, 2022),
(6, 4, 'Usman Ch',      'usman.ch@student.edu',     '03111234567', 2.90, 2020);

-- Companies
INSERT INTO companies (user_id, company_name, industry, city, contact_email, contact_phone, established_year, verified) VALUES
(7, 'TechCorp PK',   'Software Development', 'Lahore',    'hr@techcorppk.com',  '04299887766', 2010, 1),
(8, 'NetSol Technologies', 'ERP Solutions', 'Lahore',    'careers@netsol.com', '04288776655', 1995, 1),
(9, 'Systems Ltd',   'IT Consulting',        'Islamabad', 'jobs@systems.com',   '05199887766', 2005, 1);

-- Supervisors
INSERT INTO supervisors (company_id, full_name, email, designation, salary) VALUES
(1, 'Kamran Arif',   'kamran@techcorppk.com',  'Senior Developer',    180000.00),
(1, 'Nadia Saeed',   'nadia@techcorppk.com',   'Project Manager',     220000.00),
(2, 'Hassan Raza',   'hassan@netsol.com',       'Technical Lead',      250000.00),
(2, 'Ayesha Tariq',  'ayesha@netsol.com',       'HR Manager',          195000.00),
(3, 'Omar Farooq',   'omar@systems.com',        'Solutions Architect',  270000.00);

-- Internships
INSERT INTO internships (company_id, supervisor_id, title, description, domain, stipend, duration_months, start_date, end_date, slots, status) VALUES
(1, 1, 'Web Development Intern',       'Build and maintain web apps using Laravel.', 'Web Development', 25000.00, 3, '2024-06-01', '2024-08-31', 3, 'open'),
(1, 2, 'Mobile App Intern',            'Develop cross-platform mobile apps.',         'Mobile Dev',      20000.00, 2, '2024-07-01', '2024-08-31', 2, 'open'),
(2, 3, 'ERP Module Intern',            'Work on NetSol ERP customizations.',          'ERP',             30000.00, 6, '2024-05-01', '2024-10-31', 4, 'open'),
(2, 4, 'Business Analysis Intern',     'Gather requirements and create docs.',        'Business',        15000.00, 3, '2024-06-01', '2024-08-31', 2, 'closed'),
(3, 5, 'Cloud Infrastructure Intern',  'Manage AWS/Azure cloud setups.',              'Cloud Computing', 35000.00, 4, '2024-07-01', '2024-10-31', 2, 'open');

-- Applications
INSERT INTO applications (student_id, internship_id, status, cover_note, reviewed_at) VALUES
(1, 1, 'accepted',    'I am passionate about web development.',   '2024-05-10 10:00:00'),
(1, 3, 'pending',     'ERP interests me greatly.',                 NULL),
(2, 1, 'shortlisted', 'I have Laravel experience.',               '2024-05-11 11:00:00'),
(2, 5, 'pending',     'Cloud is my focus area.',                  NULL),
(3, 2, 'rejected',    'Mobile dev is my strength.',               '2024-05-09 09:00:00'),
(4, 3, 'accepted',    'I want to learn ERP systems.',             '2024-05-12 14:00:00'),
(5, 5, 'accepted',    'I have AWS certification.',                '2024-05-13 09:00:00'),
(3, 5, 'pending',     'Interested in cloud infrastructure.',       NULL);

-- Placements (for accepted applications: IDs 1, 6, 7)
INSERT INTO placements (application_id, start_date, end_date, actual_stipend, grade, feedback, completed) VALUES
(1, '2024-06-01', '2024-08-31', 25000.00, 'A',  'Excellent performance, highly recommended.', 0),
(6, '2024-05-01', '2024-10-31', 30000.00, 'B+', 'Good contribution to the ERP module.',       0),
(7, '2024-07-01', '2024-10-31', 35000.00, NULL, NULL,                                          0);

-- ----------------------------
-- DML: UPDATE & DELETE EXAMPLES
-- ----------------------------

-- Update a student's status
UPDATE students SET status = 'graduated' WHERE student_id = 5;

-- Update a company's verification status
UPDATE companies SET verified = 1 WHERE company_id = 3;

-- Soft-close an internship
UPDATE internships SET status = 'closed' WHERE internship_id = 2;

-- Delete a rejected application (cleanup)
DELETE FROM applications WHERE status = 'rejected' AND student_id = 3 AND internship_id = 2;
