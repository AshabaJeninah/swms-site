<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$bin = $conn->query('SELECT * FROM bins LIMIT 1')->fetch_assoc();

$fill = $bin['current_fill_level'] ?? 0;
$loc = $bin['location_name'] ?? 'Not Set';
$status = $bin['status'] ?? 'Unknown';
$updated = $bin['last_updated'] ?? 'N/A';
$bar_color = '#2ecc71';
if ($fill >= 90) {
    $bar_color = '#e74c3c';
} elseif ($fill >= 70) {
    $bar_color = '#f1c40f';
}

$incidents = $conn->query('SELECT id, location, report_type, status FROM incident_reports ORDER BY reported_at DESC LIMIT 10');

$pageTitle = 'Monitoring Dashboard - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell">
    <h2 style="text-align: center; color: var(--secondary-blue);">MONITORING DASHBOARD</h2>

    <div class="monitoring-network" style="display: block; max-width: 550px; margin: 0 auto;">
        <div class="vessel-status-card" style="border-left: 8px solid <?= htmlspecialchars($bar_color) ?>;">

            <div class="vessel-identity-header">
                <h3><i class="fas fa-trash"></i> <?= htmlspecialchars($loc) ?></h3>
                <span class="status-badge" style="background: <?= htmlspecialchars($bar_color) ?>; color: white;">
                    <?= htmlspecialchars(strtoupper($status)) ?>
                </span>
            </div>

            <div class="capacity-meter" style="height: 30px; margin-top: 15px;">
                <div class="fill-progress-bar" style="width: <?= (int) $fill ?>%; background: <?= htmlspecialchars($bar_color) ?>;"></div>
            </div>

            <p style="text-align: right; font-weight: bold; margin-top: 5px;">
                Current Level: <?= (int) $fill ?>%
            </p>

            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; display: grid; grid-template-columns: 1fr 1fr; font-size: 0.9em;">
                <span><strong>ID:</strong> #<?= (int) ($bin['bin_id'] ?? 0) ?></span>
                <span><strong>Updated:</strong> <?= htmlspecialchars((string) $updated) ?></span>
            </div>
        </div>
    </div>
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
                        <td><span class="rating-metric <?= $row['status'] === 'Resolved' ? 'excellent' : 'poor' ?>"><?= htmlspecialchars($row['status']) ?></span></td>
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
