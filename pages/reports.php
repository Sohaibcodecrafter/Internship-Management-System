<?php
$pageTitle = 'Reports';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

// Report 1: Applications by status
$appsByStatus = $pdo->query("
    SELECT status, COUNT(*) AS total
    FROM applications
    GROUP BY status
")->fetchAll();

// Report 2: Placements per department
$placementsByDept = $pdo->query("
    SELECT d.dept_name, COUNT(p.placement_id) AS placements
    FROM placements p
    INNER JOIN applications a ON p.application_id = a.application_id
    INNER JOIN students     s ON a.student_id      = s.student_id
    INNER JOIN departments  d ON s.dept_id         = d.dept_id
    GROUP BY d.dept_id, d.dept_name
    ORDER BY placements DESC
")->fetchAll();

// Report 3: Monthly applications (DATE FUNCTIONS)
$monthlyApps = $pdo->query("
    SELECT YEAR(applied_at)  AS yr,
           MONTH(applied_at) AS mo,
           COUNT(*)          AS total
    FROM applications
    GROUP BY yr, mo
    ORDER BY yr, mo
")->fetchAll();

// Report 4: Supervisor highest salary per company
$supervisorSalaries = $pdo->query("
    SELECT c.company_name,
           sup.full_name AS supervisor,
           sup.salary,
           UPPER(sup.designation) AS designation_upper
    FROM supervisors sup
    INNER JOIN companies c ON sup.company_id = c.company_id
    WHERE sup.salary = (
        SELECT MAX(s2.salary) FROM supervisors s2 WHERE s2.company_id = sup.company_id
    )
    ORDER BY sup.salary DESC
")->fetchAll();

// Report 5: Department GPA stats with HAVING
$deptGPA = $pdo->query("
    SELECT d.dept_name,
           COUNT(s.student_id) AS student_count,
           ROUND(AVG(s.gpa),2) AS avg_gpa,
           MIN(s.gpa) AS min_gpa,
           MAX(s.gpa) AS max_gpa
    FROM students s
    INNER JOIN departments d ON s.dept_id = d.dept_id
    GROUP BY d.dept_id, d.dept_name
    HAVING avg_gpa > 0
    ORDER BY avg_gpa DESC
")->fetchAll();

require_once __DIR__ . '/reports_view.php';
require_once __DIR__ . '/../includes/footer.php';
