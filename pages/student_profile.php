<?php
$pageTitle = 'My Profile';
require_once __DIR__ . '/../includes/header.php';
requireRole('student');
$pdo = getDB();
$userId = currentUserId();

$student = $pdo->prepare('SELECT s.*, u.username FROM students s JOIN users u ON s.user_id = u.user_id WHERE s.user_id = ?');
$student->execute([$userId]);
$student = $student->fetch();

if (!$student) { echo '<div class="alert alert-error">Student profile not found.</div>'; require_once __DIR__ . '/../includes/footer.php'; exit; }

$departments = $pdo->query('SELECT dept_id, dept_name FROM departments ORDER BY dept_name')->fetchAll();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $deptId = (int)($_POST['dept_id'] ?? 0);
    $gpa = (float)($_POST['gpa'] ?? 0);
    $enrollYear = (int)($_POST['enrollment_year'] ?? 0);

    $errors = [];
    if (empty($fullName)) $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
    if ($deptId < 1) $errors[] = 'Select a department.';

    // Check email uniqueness (excluding self)
    $check = $pdo->prepare('SELECT COUNT(*) FROM students WHERE email = ? AND student_id != ?');
    $check->execute([$email, $student['student_id']]);
    if ($check->fetchColumn() > 0) $errors[] = 'Email already in use.';

    // CV Upload
    $cvFile = $student['cv_file'];
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['cv_file']['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed)) {
            $errors[] = 'CV must be PDF or DOCX.';
        } elseif ($_FILES['cv_file']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'CV must be under 2MB.';
        } else {
            $ext = pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION);
            $cvFile = $student['student_id'] . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['cv_file']['tmp_name'], __DIR__ . '/../assets/uploads/cvs/' . $cvFile);
        }
    }

    // Profile pic upload
    $profilePic = $student['profile_pic'] ?? null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['profile_pic']['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, ['image/jpeg', 'image/png'])) {
            $errors[] = 'Photo must be JPG or PNG.';
        } elseif ($_FILES['profile_pic']['size'] > 1024 * 1024) {
            $errors[] = 'Photo must be under 1MB.';
        } else {
            $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
            $profilePic = $student['student_id'] . '_photo_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], __DIR__ . '/../assets/uploads/photos/' . $profilePic);
        }
    }

    if (!empty($errors)) {
        $error = implode('<br>', $errors);
    } else {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE students SET full_name=?, email=?, phone=?, dept_id=?, gpa=?, enrollment_year=?, cv_file=?, profile_pic=? WHERE student_id=?');
        $stmt->execute([$fullName, $email, $phone ?: null, $deptId, $gpa ?: null, $enrollYear, $cvFile, $profilePic, $student['student_id']]);
        $pdo->commit();
        $success = 'Profile updated successfully!';

        // Re-fetch
        $student = $pdo->prepare('SELECT s.*, u.username FROM students s JOIN users u ON s.user_id = u.user_id WHERE s.user_id = ?');
        $student->execute([$userId]);
        $student = $student->fetch();
    }
}

require_once __DIR__ . '/student_profile_view.php';
require_once __DIR__ . '/../includes/footer.php';
