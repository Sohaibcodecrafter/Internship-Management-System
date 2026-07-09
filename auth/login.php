<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

// Check for flash messages
if (isset($_SESSION['flash'])) {
    if ($_SESSION['flash']['type'] === 'error') {
        $error = $_SESSION['flash']['msg'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Both fields are required.';
    } else {
        $pdo  = getDB();
        $stmt = $pdo->prepare('SELECT user_id, password_hash, role, is_active FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Check if account is active
            if (isset($user['is_active']) && $user['is_active'] == 0) {
                $error = 'Your account has been deactivated. Please contact an administrator.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['username'] = $username;
                $_SESSION['role']     = $user['role'];

                // Role-based redirect
                switch ($user['role']) {
                    case 'student': header('Location: /pages/student_internships.php'); break;
                    case 'company': header('Location: /pages/company_dashboard.php'); break;
                    default:        header('Location: /pages/dashboard.php'); break;
                }
                exit;
            }
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
// Frontend renders the login form; $error is passed to the view
require_once __DIR__ . '/../pages/login_view.php';
