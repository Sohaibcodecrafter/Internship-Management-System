-- ============================================================
-- IMS EXTRA SEED DATA — 10+ rows per table
-- All passwords: bcrypt of 'password123'
-- ============================================================
USE ims_db;

-- ── Users (10 students + 5 companies + 1 extra admin) ──
INSERT INTO users (username, password_hash, role, is_active) VALUES
('ahmed_ali',     '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('sara_khan',     '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('bilal_hassan2', '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('zainab_malik',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('usman_tariq',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('hina_noor',     '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('faisal_iqbal',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('ayesha_raza',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('omar_sheikh',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('maryam_baig',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'student', 1),
('techventures',  '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1),
('nexadigital',   '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1),
('softbridge',    '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1),
('dataminds',     '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1),
('pixelforge',    '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'company', 1),
('admin2',        '$2y$10$9uHeqOMF185X2f10BJ5LbOurgvVTCjWevm1wvYnnU7C7b1Q2Cy.q2', 'admin',   1);

-- Get the IDs dynamically using variables
SET @uid_ahmed   = (SELECT user_id FROM users WHERE username='ahmed_ali');
SET @uid_sara    = (SELECT user_id FROM users WHERE username='sara_khan');
SET @uid_bilal   = (SELECT user_id FROM users WHERE username='bilal_hassan2');
SET @uid_zainab  = (SELECT user_id FROM users WHERE username='zainab_malik');
SET @uid_usman   = (SELECT user_id FROM users WHERE username='usman_tariq');
SET @uid_hina    = (SELECT user_id FROM users WHERE username='hina_noor');
SET @uid_faisal  = (SELECT user_id FROM users WHERE username='faisal_iqbal');
SET @uid_ayesha  = (SELECT user_id FROM users WHERE username='ayesha_raza');
SET @uid_omar    = (SELECT user_id FROM users WHERE username='omar_sheikh');
SET @uid_maryam  = (SELECT user_id FROM users WHERE username='maryam_baig');
SET @uid_tech    = (SELECT user_id FROM users WHERE username='techventures');
SET @uid_nexa    = (SELECT user_id FROM users WHERE username='nexadigital');
SET @uid_soft    = (SELECT user_id FROM users WHERE username='softbridge');
SET @uid_data    = (SELECT user_id FROM users WHERE username='dataminds');
SET @uid_pixel   = (SELECT user_id FROM users WHERE username='pixelforge');

-- ── Students ──
INSERT INTO students (user_id, dept_id, full_name, email, phone, gpa, enrollment_year) VALUES
(@uid_ahmed,  1, 'Ahmed Ali',      'ahmed.ali@fast.edu.pk',    '03001234501', 3.75, 2022),
(@uid_sara,   1, 'Sara Khan',      'sara.khan@nust.edu.pk',    '03001234502', 3.50, 2021),
(@uid_bilal,  2, 'Bilal Hassan',   'bilal.h@uet.edu.pk',       '03001234503', 3.20, 2022),
(@uid_zainab, 3, 'Zainab Malik',   'zainab.m@comsats.edu.pk',  '03001234504', 3.80, 2023),
(@uid_usman,  5, 'Usman Tariq',    'usman.t@iba.edu.pk',       '03001234505', 3.60, 2021),
(@uid_hina,   4, 'Hina Noor',      'hina.n@giki.edu.pk',       '03001234506', 3.45, 2022),
(@uid_faisal, 1, 'Faisal Iqbal',   'faisal.i@qau.edu.pk',      '03001234507', 3.10, 2023),
(@uid_ayesha, 2, 'Ayesha Raza',    'ayesha.r@uop.edu.pk',      '03001234508', 3.55, 2022),
(@uid_omar,   1, 'Omar Sheikh',    'omar.s@lums.edu.pk',       '03001234509', 3.90, 2021),
(@uid_maryam, 3, 'Maryam Baig',    'maryam.b@itu.edu.pk',      '03001234510', 3.70, 2023);

-- ── Companies ──
INSERT INTO companies (user_id, company_name, industry, city, contact_email, contact_phone, established_year, verified) VALUES
(@uid_tech,  'TechVentures PK',  'Software Development', 'Karachi',   'hr@techventures.pk',  '02199001122', 2012, 1),
(@uid_nexa,  'NexaDigital',      'Digital Marketing',    'Lahore',    'jobs@nexadigital.pk',  '04299003344', 2016, 1),
(@uid_soft,  'SoftBridge',       'IT Consulting',        'Islamabad', 'careers@softbridge.pk','05199005566', 2008, 1),
(@uid_data,  'DataMinds',        'Data Science',         'Karachi',   'intern@dataminds.pk',  '02199007788', 2019, 1),
(@uid_pixel, 'PixelForge',       'UI/UX Design',         'Lahore',    'hr@pixelforge.pk',     '04299009900', 2020, 1);

-- ── Supervisors ──
INSERT INTO supervisors (company_id, full_name, email, designation, salary) VALUES
((SELECT company_id FROM companies WHERE user_id=@uid_tech), 'Tariq Mehmood', 'tariq@techventures.pk', 'CTO', 350000.00),
((SELECT company_id FROM companies WHERE user_id=@uid_nexa), 'Sana Ahmed',    'sana@nexadigital.pk',   'Director Marketing', 280000.00),
((SELECT company_id FROM companies WHERE user_id=@uid_soft), 'Imran Qureshi', 'imran@softbridge.pk',   'Senior Architect', 320000.00),
((SELECT company_id FROM companies WHERE user_id=@uid_data), 'Fatima Zahra',  'fatima@dataminds.pk',   'Lead Data Scientist', 300000.00),
((SELECT company_id FROM companies WHERE user_id=@uid_pixel),'Hamza Ali',     'hamza@pixelforge.pk',   'Creative Director', 290000.00);

-- Get company IDs
SET @cid_tech  = (SELECT company_id FROM companies WHERE user_id=@uid_tech);
SET @cid_nexa  = (SELECT company_id FROM companies WHERE user_id=@uid_nexa);
SET @cid_soft  = (SELECT company_id FROM companies WHERE user_id=@uid_soft);
SET @cid_data  = (SELECT company_id FROM companies WHERE user_id=@uid_data);
SET @cid_pixel = (SELECT company_id FROM companies WHERE user_id=@uid_pixel);

-- ── Internships (using ACTUAL schema: domain, duration_months, start_date, end_date, slots) ──
INSERT INTO internships (company_id, title, description, domain, stipend, duration_months, start_date, end_date, slots, status) VALUES
(@cid_tech,  'PHP Backend Intern',         'Build REST APIs using PHP and Laravel.',                 'Web Development',   25000.00, 3, '2026-06-01', '2026-08-31', 3, 'open'),
(@cid_tech,  'React Frontend Intern',      'Build responsive UI components in React.',               'Frontend',          20000.00, 3, '2026-06-15', '2026-09-15', 2, 'open'),
(@cid_nexa,  'Digital Marketing Intern',    'SEO optimization and social media campaign management.', 'Digital Marketing', 15000.00, 2, '2026-06-01', '2026-07-31', 3, 'open'),
(@cid_nexa,  'Content Writing Intern',      'Write engaging blogs and web copy.',                     'Content',           10000.00, 2, '2026-07-01', '2026-08-31', 2, 'open'),
(@cid_soft,  'IT Support Intern',           'Helpdesk tickets and network troubleshooting.',          'IT Support',        18000.00, 3, '2026-06-01', '2026-08-31', 2, 'open'),
(@cid_soft,  'Business Analyst Intern',     'Gather requirements and document solutions.',            'Business Analysis', 12000.00, 2, '2026-07-01', '2026-08-31', 2, 'open'),
(@cid_data,  'Data Science Intern',         'Clean datasets and build analytics dashboards.',         'Data Science',      30000.00, 4, '2026-06-01', '2026-09-30', 3, 'open'),
(@cid_data,  'ML Research Intern',          'Implement ML models for production use.',                'Machine Learning',  35000.00, 4, '2026-07-01', '2026-10-31', 2, 'open'),
(@cid_pixel, 'UI/UX Design Intern',         'Design user interfaces and prototypes in Figma.',        'UI/UX Design',      15000.00, 2, '2026-06-15', '2026-08-15', 2, 'open'),
(@cid_pixel, 'Graphic Design Intern',       'Create brand identity and marketing assets.',            'Graphic Design',    12000.00, 2, '2026-07-01', '2026-08-31', 2, 'open');

-- Get new student IDs
SET @sid_ahmed   = (SELECT student_id FROM students WHERE user_id=@uid_ahmed);
SET @sid_sara    = (SELECT student_id FROM students WHERE user_id=@uid_sara);
SET @sid_bilal   = (SELECT student_id FROM students WHERE user_id=@uid_bilal);
SET @sid_zainab  = (SELECT student_id FROM students WHERE user_id=@uid_zainab);
SET @sid_usman   = (SELECT student_id FROM students WHERE user_id=@uid_usman);
SET @sid_hina    = (SELECT student_id FROM students WHERE user_id=@uid_hina);
SET @sid_faisal  = (SELECT student_id FROM students WHERE user_id=@uid_faisal);
SET @sid_ayesha  = (SELECT student_id FROM students WHERE user_id=@uid_ayesha);
SET @sid_omar    = (SELECT student_id FROM students WHERE user_id=@uid_omar);
SET @sid_maryam  = (SELECT student_id FROM students WHERE user_id=@uid_maryam);

-- Get new internship IDs (offset from existing ones)
SET @iid1 = (SELECT internship_id FROM internships WHERE title='PHP Backend Intern' AND company_id=@cid_tech LIMIT 1);
SET @iid2 = (SELECT internship_id FROM internships WHERE title='React Frontend Intern' AND company_id=@cid_tech LIMIT 1);
SET @iid3 = (SELECT internship_id FROM internships WHERE title='Digital Marketing Intern' AND company_id=@cid_nexa LIMIT 1);
SET @iid4 = (SELECT internship_id FROM internships WHERE title='Content Writing Intern' AND company_id=@cid_nexa LIMIT 1);
SET @iid5 = (SELECT internship_id FROM internships WHERE title='IT Support Intern' AND company_id=@cid_soft LIMIT 1);
SET @iid6 = (SELECT internship_id FROM internships WHERE title='Business Analyst Intern' AND company_id=@cid_soft LIMIT 1);
SET @iid7 = (SELECT internship_id FROM internships WHERE title='Data Science Intern' AND company_id=@cid_data LIMIT 1);
SET @iid8 = (SELECT internship_id FROM internships WHERE title='ML Research Intern' AND company_id=@cid_data LIMIT 1);
SET @iid9 = (SELECT internship_id FROM internships WHERE title='UI/UX Design Intern' AND company_id=@cid_pixel LIMIT 1);
SET @iid10= (SELECT internship_id FROM internships WHERE title='Graphic Design Intern' AND company_id=@cid_pixel LIMIT 1);

-- ── Applications ──
INSERT INTO applications (student_id, internship_id, cover_note, status, applied_at) VALUES
(@sid_ahmed,   @iid1, 'I am passionate about PHP backend development. I have built 3 Laravel projects during my CS degree at FAST-NUCES Karachi and have strong MySQL skills.', 'pending',     NOW()),
(@sid_ahmed,   @iid3, 'Digital marketing aligns with my business skills. I have managed the social media pages for my university tech society for two semesters.', 'shortlisted', NOW()),
(@sid_sara,    @iid2, 'As a React developer I have built 3 full-stack projects. I am proficient in modern JavaScript, TypeScript, and CSS-in-JS solutions.', 'shortlisted', NOW()),
(@sid_sara,    @iid7, 'Data science is my career goal. I have completed 2 Kaggle competitions in NLP and scored in the top 15% in both challenges.', 'accepted',    NOW()),
(@sid_bilal,   @iid1, 'I have strong MySQL and PHP skills developed through my final year project — a hospital management system built with pure PHP.', 'rejected',    NOW()),
(@sid_zainab,  @iid5, 'Networking and IT support are my strengths. I hold a Cisco CCNA certification and have interned at a local ISP for 6 weeks.', 'pending',     NOW()),
(@sid_usman,   @iid6, 'Business analysis experience from my internship simulation course at IBA. I create data-driven requirement docs using Confluence.', 'shortlisted', NOW()),
(@sid_hina,    @iid9, 'I have used Figma professionally in my engineering design projects and won a national UI design competition at GIKI.', 'pending',     NOW()),
(@sid_faisal,  @iid7, 'My data analysis project using Python and Pandas won first place in QAU science fair. I also know SQL and Tableau.', 'pending',     NOW()),
(@sid_ayesha,  @iid1, 'I built 2 published apps on Google Play Store using PHP backends. I am comfortable with RESTful APIs and database optimization.', 'shortlisted', NOW()),
(@sid_omar,    @iid8, 'ML research intern role perfectly fits my LUMS coursework in deep learning and reinforcement learning. Published 1 conference paper.', 'accepted',    NOW()),
(@sid_maryam,  @iid7, 'Power BI dashboards and SQL analysis are my core skills from my data science degree. I have analyzed 5 real-world datasets at ITU.', 'shortlisted', NOW());

-- ── Placements (for accepted applications) ──
SET @app_sara_ds = (SELECT application_id FROM applications WHERE student_id=@sid_sara AND internship_id=@iid7 LIMIT 1);
SET @app_omar_ml = (SELECT application_id FROM applications WHERE student_id=@sid_omar AND internship_id=@iid8 LIMIT 1);

INSERT INTO placements (application_id, start_date, end_date, actual_stipend) VALUES
(@app_sara_ds, '2026-06-01', '2026-09-30', 30000.00),
(@app_omar_ml, '2026-07-01', '2026-10-31', 35000.00);

-- ── Notifications ──
INSERT INTO notifications (user_id, message, is_read, created_at) VALUES
(@uid_ahmed,  'Your application for "PHP Backend Intern" is under review.',        0, NOW()),
(@uid_sara,   'Your application for "Data Science Intern" has been accepted! 🎉',  0, NOW()),
(@uid_bilal,  'Your application for "PHP Backend Intern" was not selected.',       1, NOW()),
(@uid_omar,   'Your application for "ML Research Intern" has been accepted! 🎉',   0, NOW()),
(@uid_tech,   'New application received for "PHP Backend Intern" from Ahmed Ali.', 0, NOW()),
(@uid_tech,   'New application received for "PHP Backend Intern" from Bilal Hassan.', 1, NOW()),
(@uid_data,   'New application received for "Data Science Intern" from Sara Khan.',  0, NOW()),
(@uid_pixel,  'New application received for "UI/UX Design Intern" from Hina Noor.', 0, NOW());
