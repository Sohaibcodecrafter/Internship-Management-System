<div class="page-header">
    <div>
        <h1 class="page-title">Reports</h1>
        <p class="page-subtitle">Aggregate analytics across students, companies, and placements</p>
    </div>
</div>

<div class="bento-grid">

    <!-- Applications by Status -->
    <div class="card bento-4">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Applications by Status</h3>
        <?php foreach ($appsByStatus as $row): ?>
        <?php $cls = match($row['status']){'accepted'=>'success','pending'=>'warning','rejected'=>'danger','shortlisted'=>'primary',default=>'neutral'}; ?>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
            <span class="badge badge-<?= $cls ?>"><?= ucfirst($row['status']) ?></span>
            <strong><?= $row['total'] ?></strong>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Department GPA Stats -->
    <div class="card bento-8">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">GPA by Department</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Department</th><th>Students</th><th>Avg GPA</th><th>Min GPA</th><th>Max GPA</th></tr></thead>
                <tbody>
                    <?php foreach ($deptGPA as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['dept_name']) ?></td>
                        <td><?= $r['student_count'] ?></td>
                        <td><strong><?= $r['avg_gpa'] ?></strong></td>
                        <td style="color:var(--accent-danger)"><?= $r['min_gpa'] ?></td>
                        <td style="color:var(--accent-success)"><?= $r['max_gpa'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Supervisor Highest Salary -->
    <div class="card bento-6">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Highest Salary Supervisors</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Company</th><th>Supervisor</th><th>Designation</th><th>Salary</th></tr></thead>
                <tbody>
                    <?php foreach ($supervisorSalaries as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['company_name']) ?></td>
                        <td><?= htmlspecialchars($r['supervisor']) ?></td>
                        <td style="color:var(--text-muted);font-size:0.8rem"><?= htmlspecialchars($r['designation_upper']) ?></td>
                        <td><strong>PKR <?= number_format($r['salary']) ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Placements by Department -->
    <div class="card bento-6">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Placements by Department</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Department</th><th>Placements</th></tr></thead>
                <tbody>
                    <?php foreach ($placementsByDept as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['dept_name']) ?></td>
                        <td><span class="badge badge-success"><?= $r['placements'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Application Trend -->
    <div class="card bento-12">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Monthly Application Trend</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Year</th><th>Month</th><th>Applications</th></tr></thead>
                <tbody>
                    <?php
                    $months = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    foreach ($monthlyApps as $r): ?>
                    <tr>
                        <td><?= $r['yr'] ?></td>
                        <td><?= $months[(int)$r['mo']] ?></td>
                        <td><?= $r['total'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
