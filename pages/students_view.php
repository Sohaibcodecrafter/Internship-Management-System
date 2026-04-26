<div class="page-header">
    <div>
        <h1 class="page-title">Students</h1>
        <p class="page-subtitle">Manage all registered students</p>
    </div>
    <?php if (isAdmin()): ?>
    <a href="students_add.php" class="btn btn-primary">+ Add Student</a>
    <?php endif; ?>
</div>

<!-- Search & Filter -->
<form method="GET" action="" id="filterForm">
    <div class="filter-bar">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" class="live-search"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search by name, email...">
        </div>

        <select name="dept_id" class="select-field" style="width:180px;" onchange="this.form.submit()">
            <option value="">All Departments</option>
            <?php foreach ($departments as $d): ?>
            <option value="<?= $d['dept_id'] ?>" <?= ($_GET['dept_id'] ?? '') == $d['dept_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['dept_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>

        <select name="status" class="select-field" style="width:160px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="active"    <?= ($_GET['status']??'')==='active'    ?'selected':'' ?>>Active</option>
            <option value="graduated" <?= ($_GET['status']??'')==='graduated' ?'selected':'' ?>>Graduated</option>
            <option value="dropped"   <?= ($_GET['status']??'')==='dropped'   ?'selected':'' ?>>Dropped</option>
        </select>

        <a href="?" class="btn btn-ghost btn-sm">Clear ✕</a>
    </div>
</form>

<!-- Students Table -->
<div class="card bento-12">
    <?php if (empty($students)): ?>
        <div class="empty-state">
            <div class="empty-icon">🎓</div>
            <p>No students found matching your criteria.</p>
        </div>
    <?php else: ?>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>GPA</th>
                    <th>Year</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s): ?>
                <tr>
                    <td style="color:var(--text-muted)"><?= $s['student_id'] ?></td>
                    <td style="font-weight:500"><?= htmlspecialchars($s['full_name']) ?></td>
                    <td style="color:var(--text-secondary)"><?= htmlspecialchars($s['email']) ?></td>
                    <td><span class="badge badge-primary"><?= htmlspecialchars($s['dept_name']) ?></span></td>
                    <td style="font-weight:600"><?= number_format($s['gpa'], 2) ?></td>
                    <td style="color:var(--text-muted)"><?= $s['enrollment_year'] ?></td>
                    <td>
                        <?php $cls = match($s['status']) {
                            'active'=>'success','graduated'=>'primary','dropped'=>'danger', default=>'neutral'
                        }; ?>
                        <span class="badge badge-<?= $cls ?>"><?= ucfirst($s['status']) ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
