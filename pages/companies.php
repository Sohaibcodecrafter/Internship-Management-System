<?php
$pageTitle = 'Companies';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

// Search & Filter
$search   = trim($_GET['search'] ?? '');
$city     = trim($_GET['city'] ?? '');
$verified = $_GET['verified'] ?? '';

$where  = ['1=1'];
$params = [];

if ($search !== '') {
    $where[]  = '(c.company_name LIKE ? OR c.industry LIKE ? OR c.contact_email LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if ($city !== '') {
    $where[]  = 'c.city = ?';
    $params[] = $city;
}
if ($verified !== '') {
    $where[]  = 'c.verified = ?';
    $params[] = (int)$verified;
}

$sql  = 'SELECT c.* FROM companies c
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY c.company_name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$companies = $stmt->fetchAll();

$cities = $pdo->query('SELECT DISTINCT city FROM companies ORDER BY city')->fetchAll(PDO::FETCH_COLUMN);
?>
<?php require_once __DIR__ . '/companies_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
