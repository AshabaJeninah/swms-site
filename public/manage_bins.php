<?php
session_start();
require_once __DIR__ . '/config/database.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $location_name = trim($_POST['location_name'] ?? '');
        $latitude = $_POST['latitude'] !== '' ? (float) $_POST['latitude'] : null;
        $longitude = $_POST['longitude'] !== '' ? (float) $_POST['longitude'] : null;

        if ($location_name === '') {
            $message = '<div class="error-message">Location name is required.</div>';
        } else {
            $stmt = $conn->prepare('INSERT INTO bins (location_name, latitude, longitude, current_fill_level, status) VALUES (?, ?, ?, 0, ?)');
            $status = 'OK';
            $stmt->bind_param('sdds', $location_name, $latitude, $longitude, $status);
            $stmt->execute();
            $stmt->close();
            $message = '<div class="success-message">Bin added.</div>';
        }
    } elseif ($action === 'edit') {
        $bin_id = (int) ($_POST['bin_id'] ?? 0);
        $location_name = trim($_POST['location_name'] ?? '');
        $latitude = $_POST['latitude'] !== '' ? (float) $_POST['latitude'] : null;
        $longitude = $_POST['longitude'] !== '' ? (float) $_POST['longitude'] : null;

        if ($location_name === '' || $bin_id <= 0) {
            $message = '<div class="error-message">Location name is required.</div>';
        } else {
            $stmt = $conn->prepare('UPDATE bins SET location_name = ?, latitude = ?, longitude = ? WHERE bin_id = ?');
            $stmt->bind_param('sddi', $location_name, $latitude, $longitude, $bin_id);
            $stmt->execute();
            $stmt->close();
            $message = '<div class="success-message">Bin updated.</div>';
        }
    } elseif ($action === 'delete') {
        $bin_id = (int) ($_POST['bin_id'] ?? 0);
        $stmt = $conn->prepare('DELETE FROM bins WHERE bin_id = ?');
        $stmt->bind_param('i', $bin_id);
        $stmt->execute();
        $stmt->close();
        $message = '<div class="success-message">Bin deleted.</div>';
    }
}

$bins = $conn->query('SELECT bin_id, location_name, latitude, longitude, current_fill_level, status, last_updated FROM bins ORDER BY location_name')->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Manage Bins - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell">
    <h2 class="page-heading">Manage Bins</h2>

    <?= $message ?>

    <div class="incident-form" style="max-width: 600px; margin: 0 auto var(--space-7);">
        <h3 style="margin-top: 0;">Add a Bin</h3>
        <form method="POST" action="manage_bins.php">
            <input type="hidden" name="action" value="add">
            <label for="location_name">Location Name:</label>
            <input type="text" id="location_name" name="location_name" required>

            <div class="form-row" style="display: flex; gap: var(--space-3);">
                <div style="flex: 1;">
                    <label for="latitude">Latitude (optional):</label>
                    <input type="text" id="latitude" name="latitude" placeholder="e.g. 0.3672">
                </div>
                <div style="flex: 1;">
                    <label for="longitude">Longitude (optional):</label>
                    <input type="text" id="longitude" name="longitude" placeholder="e.g. 32.5825">
                </div>
            </div>

            <button type="submit">Add Bin</button>
        </form>
    </div>

    <h3 style="color: var(--color-primary);">Registered Bins</h3>

    <?php if (empty($bins)): ?>
        <p style="text-align: center; color: var(--color-text-muted);">No bins registered yet.</p>
    <?php else: ?>
        <div class="bin-card-grid">
            <?php foreach ($bins as $bin): ?>
                <div class="bin-card" style="border-left-color: <?= $bin['status'] === 'Critical' ? 'var(--color-danger)' : ($bin['status'] === 'Warning' ? 'var(--color-warning-light)' : 'var(--color-success-light)') ?>;">
                    <div class="bin-card-header">
                        <h3>#<?= (int) $bin['bin_id'] ?> &middot; <?= (int) $bin['current_fill_level'] ?>%</h3>
                        <span class="rating-metric <?= $bin['status'] === 'Critical' ? 'very-poor' : ($bin['status'] === 'Warning' ? 'average' : 'excellent') ?>"><?= htmlspecialchars($bin['status']) ?></span>
                    </div>

                    <form method="POST" action="manage_bins.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="bin_id" value="<?= (int) $bin['bin_id'] ?>">

                        <label for="location_name_<?= (int) $bin['bin_id'] ?>">Location Name</label>
                        <input type="text" id="location_name_<?= (int) $bin['bin_id'] ?>" name="location_name" value="<?= htmlspecialchars($bin['location_name']) ?>" required>

                        <div class="form-row">
                            <div style="flex: 1;">
                                <label for="lat_<?= (int) $bin['bin_id'] ?>">Latitude</label>
                                <input type="text" id="lat_<?= (int) $bin['bin_id'] ?>" name="latitude" value="<?= htmlspecialchars((string) $bin['latitude']) ?>" placeholder="lat">
                            </div>
                            <div style="flex: 1;">
                                <label for="lng_<?= (int) $bin['bin_id'] ?>">Longitude</label>
                                <input type="text" id="lng_<?= (int) $bin['bin_id'] ?>" name="longitude" value="<?= htmlspecialchars((string) $bin['longitude']) ?>" placeholder="lng">
                            </div>
                        </div>

                        <div class="bin-card-actions">
                            <button type="submit" class="btn-sm submit-btn" style="flex: 1;">Save</button>
                        </div>
                    </form>

                    <form method="POST" action="manage_bins.php" onsubmit="return confirm('Delete this bin?');" style="margin-top: var(--space-2);">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="bin_id" value="<?= (int) $bin['bin_id'] ?>">
                        <button type="submit" class="btn-sm btn-danger" style="width: 100%;">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
