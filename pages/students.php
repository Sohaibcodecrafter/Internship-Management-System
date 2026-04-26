<?php
$pageTitle = 'Students';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

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

$sql  = 'SELECT s.*, d.dept_name FROM students s
         INNER JOIN departments d ON s.dept_id = d.dept_id
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY s.full_name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

$departments = $pdo->query('SELECT dept_id, dept_name FROM departments')->fetchAll();
?>
<?php require_once __DIR__ . '/students_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
