<?php
$pageTitle = 'Students';
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
$pdo = getDB();

// Handle activate/deactivate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_active'])) {
    $uid = (int)$_POST['user_id'];
    $newActive = (int)$_POST['new_active'];
    $pdo->prepare('UPDATE users SET is_active = ? WHERE user_id = ?')->execute([$newActive, $uid]);
    $_SESSION['flash'] = ['type'=>'success','msg'=>'User status updated.'];
    header('Location: students.php'); exit;
}

// Search & Filter
$search   = trim($_GET['search'] ?? '');
$dept_id  = (int)($_GET['dept_id'] ?? 0);
$status   = $_GET['status'] ?? '';

$where  = ['1=1'];
$params = [];

if ($search !== '') {
    $where[]  = '(s.full_name LIKE ? OR s.email LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($dept_id > 0) {
    $where[]  = 's.dept_id = ?';
    $params[] = $dept_id;
}
if (in_array($status, ['active','graduated','dropped'])) {
    $where[]  = 's.status = ?';
    $params[] = $status;
}

$sql  = 'SELECT s.*, d.dept_name, u.is_active FROM students s
         INNER JOIN departments d ON s.dept_id = d.dept_id
         INNER JOIN users u ON s.user_id = u.user_id
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY s.full_name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

$departments = $pdo->query('SELECT dept_id, dept_name FROM departments')->fetchAll();
?>
<?php require_once __DIR__ . '/students_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
