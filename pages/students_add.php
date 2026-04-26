<?php
$pageTitle = 'Add Student';
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
$pdo = getDB();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username    = trim($_POST['username'] ?? '');
    $password    = $_POST['password'] ?? '';
    $full_name   = trim($_POST['full_name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $dept_id     = (int)($_POST['dept_id'] ?? 0);
    $gpa         = (float)($_POST['gpa'] ?? 0);
    $enroll_year = (int)($_POST['enrollment_year'] ?? date('Y'));

    // Validation
    if ($username === '')      $errors[] = 'Username is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($full_name === '')     $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if ($dept_id === 0)        $errors[] = 'Department is required.';
    if ($gpa < 0 || $gpa > 4) $errors[] = 'GPA must be between 0.00 and 4.00.';

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            // Insert user
            $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), 'student']);
            $user_id = $pdo->lastInsertId();

            // Insert student
            $stmt = $pdo->prepare('INSERT INTO students (user_id, dept_id, full_name, email, phone, gpa, enrollment_year) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute([$user_id, $dept_id, $full_name, $email, $phone, $gpa, $enroll_year]);

            $pdo->commit();
            $success = true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

$departments = $pdo->query('SELECT dept_id, dept_name FROM departments')->fetchAll();
require_once __DIR__ . '/students_add_view.php';
require_once __DIR__ . '/../includes/footer.php';
