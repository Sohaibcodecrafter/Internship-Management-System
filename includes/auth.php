<?php
session_start();

function requireLogin(): void {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ims/auth/login.php');
        exit;
    }
}

function requireRole(string $role): void {
    requireLogin();
    if ($_SESSION['role'] !== $role && $_SESSION['role'] !== 'admin') {
        header('Location: /ims/pages/dashboard.php');
        exit;
    }
}

function isAdmin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function currentUserId(): int {
    return (int) ($_SESSION['user_id'] ?? 0);
}
