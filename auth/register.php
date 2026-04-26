<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /ims/pages/dashboard.php');
    exit;
}

$error = '';
$success = '';
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getDB();
    $role = trim($_POST['role'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $old = $_POST;

    // Common validation
    $errors = [];
    if (!in_array($role, ['student', 'company'])) $errors[] = 'Invalid role selected.';
    if (strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';

    // Check username uniqueness
    if (empty($errors)) {
        $check = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
        $check->execute([$username]);
        if ($check->fetchColumn() > 0) {
            $errors[] = 'Username already taken.';
        }
    }

    // Role-specific validation
    if ($role === 'student') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $deptId = (int)($_POST['dept_id'] ?? 0);
        $enrollYear = (int)($_POST['enrollment_year'] ?? date('Y'));
        $gpa = (float)($_POST['gpa'] ?? 0);
        $phone = trim($_POST['phone'] ?? '');

        if (empty($fullName)) $errors[] = 'Full name is required.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if ($deptId < 1) $errors[] = 'Please select a department.';
        if ($enrollYear < 2000 || $enrollYear > (int)date('Y')) $errors[] = 'Invalid enrollment year.';

        // Check email uniqueness
        if (empty($errors)) {
            $check = $pdo->prepare('SELECT COUNT(*) FROM students WHERE email = ?');
            $check->execute([$email]);
            if ($check->fetchColumn() > 0) $errors[] = 'Email already registered.';
        }
    } elseif ($role === 'company') {
        $companyName = trim($_POST['company_name'] ?? '');
        $industry = trim($_POST['industry'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $contactEmail = trim($_POST['contact_email'] ?? '');
        $contactPhone = trim($_POST['contact_phone'] ?? '');
        $estYear = (int)($_POST['established_year'] ?? 0);

        if (empty($companyName)) $errors[] = 'Company name is required.';
        if (empty($industry)) $errors[] = 'Industry is required.';
        if (empty($city)) $errors[] = 'City is required.';
        if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid contact email is required.';

        if (empty($errors)) {
            $check = $pdo->prepare('SELECT COUNT(*) FROM companies WHERE contact_email = ?');
            $check->execute([$contactEmail]);
            if ($check->fetchColumn() > 0) $errors[] = 'Contact email already registered.';
        }
    }

    if (!empty($errors)) {
        $error = implode('<br>', $errors);
    } else {
        try {
            $pdo->beginTransaction();

            // Insert user
            $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, role, is_active) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role, 1]);
            $userId = (int)$pdo->lastInsertId();

            if ($role === 'student') {
                $stmt = $pdo->prepare('INSERT INTO students (user_id, dept_id, full_name, email, phone, gpa, enrollment_year) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$userId, $deptId, $fullName, $email, $phone ?: null, $gpa ?: null, $enrollYear]);
                $pdo->commit();
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Registration successful! You can now log in.'];
            } else {
                $stmt = $pdo->prepare('INSERT INTO companies (user_id, company_name, industry, city, contact_email, contact_phone, established_year, verified) VALUES (?, ?, ?, ?, ?, ?, ?, 0)');
                $stmt->execute([$userId, $companyName, $industry, $city, $contactEmail, $contactPhone ?: null, $estYear ?: null]);
                $pdo->commit();
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Registration successful! Your company account is pending admin verification.'];
            }

            header('Location: /ims/auth/login.php');
            exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = 'Registration failed. Please try again.';
        }
    }
}

// Fetch departments for student dropdown
$pdo = getDB();
$departments = $pdo->query('SELECT dept_id, dept_name FROM departments ORDER BY dept_name')->fetchAll();

require_once __DIR__ . '/register_view.php';
