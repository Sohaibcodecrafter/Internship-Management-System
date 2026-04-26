<?php
$pageTitle = 'Companies';
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
$pdo = getDB();

// Handle activate/deactivate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_active'])) {
    $uid = (int)$_POST['user_id'];
    $newActive = (int)$_POST['new_active'];
    $pdo->prepare('UPDATE users SET is_active = ? WHERE user_id = ?')->execute([$newActive, $uid]);
    $_SESSION['flash'] = ['type'=>'success','msg'=>'Company account status updated.'];
    header('Location: companies.php'); exit;
}

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

$sql  = 'SELECT c.*, u.is_active FROM companies c
         INNER JOIN users u ON c.user_id = u.user_id
         WHERE ' . implode(' AND ', $where) . '
         ORDER BY c.company_name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$companies = $stmt->fetchAll();

$cities = $pdo->query('SELECT DISTINCT city FROM companies ORDER BY city')->fetchAll(PDO::FETCH_COLUMN);
?>
<?php require_once __DIR__ . '/companies_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
