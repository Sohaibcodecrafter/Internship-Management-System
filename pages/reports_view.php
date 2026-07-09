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
                        <td data-label="Department"><?= htmlspecialchars($r['dept_name']) ?></td>
                        <td data-label="Students"><?= $r['student_count'] ?></td>
                        <td data-label="Avg GPA"><strong><?= $r['avg_gpa'] ?></strong></td>
                        <td data-label="Min GPA" style="color:var(--accent-danger)"><?= $r['min_gpa'] ?></td>
                        <td data-label="Max GPA" style="color:var(--accent-success)"><?= $r['max_gpa'] ?></td>
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
                        <td data-label="Company"><?= htmlspecialchars($r['company_name']) ?></td>
                        <td data-label="Supervisor"><?= htmlspecialchars($r['supervisor']) ?></td>
                        <td data-label="Designation" style="color:var(--text-muted);font-size:0.8rem"><?= htmlspecialchars($r['designation_upper']) ?></td>
                        <td data-label="Salary"><strong>PKR <?= number_format($r['salary']) ?></strong></td>
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
                        <td data-label="Department"><?= htmlspecialchars($r['dept_name']) ?></td>
                        <td data-label="Placements"><span class="badge badge-success"><?= $r['placements'] ?></span></td>
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
                        <td data-label="Year"><?= $r['yr'] ?></td>
                        <td data-label="Month"><?= $months[(int)$r['mo']] ?></td>
                        <td data-label="Applications"><?= $r['total'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
