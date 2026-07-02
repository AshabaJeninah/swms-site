<?php
session_start();
require_once __DIR__ . '/config/app.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$bins = $conn->query('SELECT bin_id, location_name, latitude, longitude, current_fill_level, status, last_updated FROM bins ORDER BY location_name')->fetch_all(MYSQLI_ASSOC);
$incidents = $conn->query('SELECT id, location, report_type, status FROM incident_reports ORDER BY reported_at DESC LIMIT 10');

$pageTitle = 'Monitoring Dashboard - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell">
    <h2 style="text-align: center; color: var(--secondary-blue);">MONITORING DASHBOARD</h2>
    <p style="text-align: center;">
        <a href="manage_bins.php" class="nav-trigger-btn">Manage Bins</a>
    </p>

    <?php include __DIR__ . '/includes/bin_map.php'; ?>
</div>

<div class="logistics-optimization-summary" style="margin-top: 40px;">
    <h3>Incidents & Reports</h3>
    <table class="audit-log-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Location</th>
                <th>Issue Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($incidents && $incidents->num_rows > 0): ?>
                <?php while ($row = $incidents->fetch_assoc()): ?>
                    <tr>
                        <td>#<?= (int) $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td><?= htmlspecialchars($row['report_type']) ?></td>
                        <td>
                            <form method="POST" action="update_report_status.php" style="display: flex; gap: 6px; align-items: center;">
                                <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                <select name="status" onchange="this.form.submit()" style="width: auto; margin: 0; padding: 4px;">
                                    <?php foreach (['Pending', 'Investigating', 'Resolved'] as $option): ?>
                                        <option value="<?= $option ?>" <?= $row['status'] === $option ? 'selected' : '' ?>><?= $option ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No incidents reported yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
