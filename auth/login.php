<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Both fields are required.';
    } else {
        $pdo  = getDB();
        $stmt = $pdo->prepare('SELECT user_id, password_hash, role FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['role']     = $user['role'];
            header('Location: ../pages/dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
// Frontend renders the login form; $error is passed to the view
require_once __DIR__ . '/../pages/login_view.php';
