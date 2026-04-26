USE ims_db;

-- ==============================================
-- INDEXES
-- ==============================================

-- Speed up application lookups by student
CREATE INDEX idx_applications_student   ON applications(student_id);
-- Speed up application lookups by internship
CREATE INDEX idx_applications_internship ON applications(internship_id);
-- Speed up internship searches by domain
CREATE INDEX idx_internships_domain     ON internships(domain);
-- Speed up student searches by department
CREATE INDEX idx_students_dept          ON students(dept_id);
-- Speed up company searches by city
CREATE INDEX idx_companies_city         ON companies(city);
-- Speed up status filtering on applications
CREATE INDEX idx_applications_status    ON applications(status);


-- ==============================================
-- VIEWS
-- ==============================================

-- View 1: Student Application Overview (uses JOIN)
CREATE OR REPLACE VIEW vw_student_applications AS
SELECT
    s.student_id,
    s.full_name        AS student_name,
    d.dept_name,
    i.title            AS internship_title,
    c.company_name,
    a.status           AS application_status,
    a.applied_at
FROM applications a
INNER JOIN students    s ON a.student_id    = s.student_id
INNER JOIN internships i ON a.internship_id = i.internship_id
INNER JOIN companies   c ON i.company_id    = c.company_id
INNER JOIN departments d ON s.dept_id       = d.dept_id;

-- View 2: Placement Report (uses multiple JOINs)
CREATE OR REPLACE VIEW vw_placement_report AS
SELECT
    p.placement_id,
    s.full_name        AS student_name,
    c.company_name,
    i.title            AS internship_title,
    sup.full_name      AS supervisor_name,
    p.start_date,
    p.end_date,
    TIMESTAMPDIFF(MONTH, p.start_date, p.end_date) AS duration_months,
    p.actual_stipend,
    p.grade,
    p.completed
FROM placements p
INNER JOIN applications a  ON p.application_id  = a.application_id
INNER JOIN students     s  ON a.student_id       = s.student_id
INNER JOIN internships  i  ON a.internship_id    = i.internship_id
INNER JOIN companies    c  ON i.company_id       = c.company_id
LEFT  JOIN supervisors  sup ON i.supervisor_id   = sup.supervisor_id;

-- View 3: Company Internship Summary (Aggregate)
CREATE OR REPLACE VIEW vw_company_summary AS
SELECT
    c.company_name,
    c.industry,
    c.city,
    COUNT(DISTINCT i.internship_id)                            AS total_internships,
    COUNT(DISTINCT a.application_id)                           AS total_applications,
    COUNT(DISTINCT CASE WHEN a.status='accepted' THEN a.application_id END) AS accepted_count,
    AVG(i.stipend)                                             AS avg_stipend,
    MAX(i.stipend)                                             AS max_stipend
FROM companies c
LEFT JOIN internships  i ON c.company_id    = i.company_id
LEFT JOIN applications a ON i.internship_id = a.internship_id
GROUP BY c.company_id, c.company_name, c.industry, c.city;


-- ==============================================
-- QUERIES COVERING ALL REQUIRED CONCEPTS
-- ==============================================

-- ---- JOINS ----

-- INNER JOIN: Students with accepted applications
SELECT s.full_name, i.title, c.company_name, a.status
FROM applications a
INNER JOIN students    s ON a.student_id    = s.student_id
INNER JOIN internships i ON a.internship_id = i.internship_id
INNER JOIN companies   c ON i.company_id    = c.company_id
WHERE a.status = 'accepted';

-- LEFT JOIN: All students, show internship if applied (NULL if not)
SELECT s.full_name, i.title, a.status
FROM students s
LEFT JOIN applications a ON s.student_id    = a.student_id
LEFT JOIN internships  i ON a.internship_id = i.internship_id;

-- RIGHT JOIN: All internships, show applications (NULL if no applicants)
SELECT i.title, s.full_name, a.status
FROM applications a
RIGHT JOIN internships i ON a.internship_id = i.internship_id
LEFT  JOIN students    s ON a.student_id    = s.student_id;

-- SELF JOIN: Supervisors in the same company
SELECT a.full_name AS supervisor_one, b.full_name AS supervisor_two, a.company_id
FROM supervisors a
INNER JOIN supervisors b ON a.company_id = b.company_id AND a.supervisor_id < b.supervisor_id;


-- ---- OPERATORS ----

-- BETWEEN: Internships with stipend in range
SELECT title, stipend FROM internships
WHERE stipend BETWEEN 20000 AND 35000;

-- IN: Students in specific departments
SELECT full_name, dept_id FROM students
WHERE dept_id IN (1, 2, 3);

-- NOT IN: Internships with no accepted application
SELECT title FROM internships
WHERE internship_id NOT IN (
    SELECT DISTINCT internship_id FROM applications WHERE status = 'accepted'
);

-- LIKE: Search student by name pattern
SELECT full_name, email FROM students WHERE full_name LIKE '%ali%';

-- AND / OR: Filter applications
SELECT * FROM applications
WHERE (status = 'pending' OR status = 'shortlisted')
  AND applied_at >= '2024-05-01';


-- ---- DATE FUNCTIONS ----

-- TIMESTAMPDIFF: Duration of placements in days
SELECT p.placement_id,
       TIMESTAMPDIFF(DAY, p.start_date, p.end_date)  AS duration_days,
       TIMESTAMPDIFF(MONTH, p.start_date, p.end_date) AS duration_months
FROM placements p;

-- YEAR() / MONTH(): Applications grouped by month
SELECT YEAR(applied_at) AS yr, MONTH(applied_at) AS mo, COUNT(*) AS total
FROM applications
GROUP BY yr, mo
ORDER BY yr, mo;

-- CURDATE(): Currently open internships
SELECT title, start_date, end_date FROM internships
WHERE status = 'open' AND end_date >= CURDATE();

-- Highest salary among supervisors (per company)
SELECT c.company_name, MAX(sup.salary) AS highest_salary
FROM supervisors sup
INNER JOIN companies c ON sup.company_id = c.company_id
GROUP BY c.company_id, c.company_name;


-- ---- CHARACTER FUNCTIONS ----

SELECT
    UPPER(full_name)                    AS name_upper,
    LOWER(email)                        AS email_lower,
    LENGTH(full_name)                   AS name_length,
    SUBSTRING(email, 1, LOCATE('@', email) - 1) AS username_part,
    CONCAT(full_name, ' (', email, ')') AS display_label
FROM students;


-- ---- AGGREGATE FUNCTIONS ----

-- COUNT, SUM, AVG, MIN, MAX with GROUP BY
SELECT
    d.dept_name,
    COUNT(s.student_id)  AS total_students,
    AVG(s.gpa)           AS avg_gpa,
    MIN(s.gpa)           AS min_gpa,
    MAX(s.gpa)           AS max_gpa
FROM students s
INNER JOIN departments d ON s.dept_id = d.dept_id
GROUP BY d.dept_id, d.dept_name;

-- HAVING: Departments with avg GPA above 3.0
SELECT d.dept_name, AVG(s.gpa) AS avg_gpa
FROM students s
INNER JOIN departments d ON s.dept_id = d.dept_id
GROUP BY d.dept_id, d.dept_name
HAVING avg_gpa > 3.0;

-- Total stipend paid out in confirmed placements
SELECT SUM(actual_stipend) AS total_stipend_paid FROM placements;


-- ---- SUBQUERIES ----

-- Students who applied to more than 1 internship
SELECT full_name FROM students
WHERE student_id IN (
    SELECT student_id FROM applications
    GROUP BY student_id
    HAVING COUNT(*) > 1
);

-- Internships with above-average stipend
SELECT title, stipend FROM internships
WHERE stipend > (SELECT AVG(stipend) FROM internships);

-- Student with highest GPA per department
SELECT s.full_name, s.gpa, d.dept_name
FROM students s
INNER JOIN departments d ON s.dept_id = d.dept_id
WHERE s.gpa = (
    SELECT MAX(gpa) FROM students s2 WHERE s2.dept_id = s.dept_id
);
