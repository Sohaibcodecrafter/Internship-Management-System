<?php
$pageTitle = 'Internships';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

// Search & Filter
$search            = trim($_GET['search'] ?? '');
$domain            = trim($_GET['domain'] ?? '');
$internship_status = trim($_GET['internship_status'] ?? '');
$stipend_min       = $_GET['stipend_min'] ?? '';
$stipend_max       = $_GET['stipend_max'] ?? '';

$where  = ['1=1'];
$params = [];

if ($search !== '') {
    $where[]  = '(i.title LIKE ? OR i.domain LIKE ? OR c.company_name LIKE ?)';
    $s = "%$search%";
    array_push($params, $s, $s, $s);
}
if ($domain !== '') {
    $where[]  = 'i.domain = ?';
    $params[] = $domain;
}
if (in_array($internship_status, ['open','closed','completed'])) {
    $where[]  = 'i.status = ?';
    $params[] = $internship_status;
}
if ($stipend_min !== '' && $stipend_max !== '') {
    $where[]  = 'i.stipend BETWEEN ? AND ?';
    array_push($params, $stipend_min, $stipend_max);
}

$sql  = "SELECT i.*, c.company_name, sup.full_name AS supervisor_name
         FROM internships i
         INNER JOIN companies c ON i.company_id = c.company_id
         LEFT JOIN supervisors sup ON i.supervisor_id = sup.supervisor_id
         WHERE " . implode(' AND ', $where) . "
         ORDER BY i.start_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$internships = $stmt->fetchAll();

$domains = $pdo->query('SELECT DISTINCT domain FROM internships ORDER BY domain')->fetchAll(PDO::FETCH_COLUMN);
?>
<?php require_once __DIR__ . '/internships_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
