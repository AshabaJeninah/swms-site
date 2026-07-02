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
            $message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">Bin added.</div>';
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
            $message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">Bin updated.</div>';
        }
    } elseif ($action === 'delete') {
        $bin_id = (int) ($_POST['bin_id'] ?? 0);
        $stmt = $conn->prepare('DELETE FROM bins WHERE bin_id = ?');
        $stmt->bind_param('i', $bin_id);
        $stmt->execute();
        $stmt->close();
        $message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">Bin deleted.</div>';
    }
}

$bins = $conn->query('SELECT bin_id, location_name, latitude, longitude, current_fill_level, status, last_updated FROM bins ORDER BY location_name')->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Manage Bins - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell">
    <h2 style="text-align: center; color: var(--secondary-blue);">MANAGE BINS</h2>

    <?= $message ?>

    <div class="incident-form" style="max-width: 600px; margin: 0 auto 40px;">
        <h3 style="margin-top: 0;">Add a Bin</h3>
        <form method="POST" action="manage_bins.php">
            <input type="hidden" name="action" value="add">
            <label for="location_name">Location Name:</label>
            <input type="text" id="location_name" name="location_name" required>

            <label for="latitude">Latitude (optional):</label>
            <input type="text" id="latitude" name="latitude" placeholder="e.g. 0.3672">

            <label for="longitude">Longitude (optional):</label>
            <input type="text" id="longitude" name="longitude" placeholder="e.g. 32.5825">

            <button type="submit" class="submit-btn">Add Bin</button>
        </form>
    </div>

    <table class="audit-log-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Location &amp; Coordinates</th>
                <th>Fill</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bins)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No bins registered yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($bins as $bin): ?>
                    <tr>
                        <td>#<?= (int) $bin['bin_id'] ?></td>
                        <td>
                            <form method="POST" action="manage_bins.php" style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="bin_id" value="<?= (int) $bin['bin_id'] ?>">
                                <input type="text" name="location_name" value="<?= htmlspecialchars($bin['location_name']) ?>" style="width: 160px; margin: 0;" required>
                                <input type="text" name="latitude" value="<?= htmlspecialchars((string) $bin['latitude']) ?>" placeholder="lat" style="width: 90px; margin: 0;">
                                <input type="text" name="longitude" value="<?= htmlspecialchars((string) $bin['longitude']) ?>" placeholder="lng" style="width: 90px; margin: 0;">
                                <button type="submit" class="submit-btn" style="width: auto; padding: 6px 14px;">Save</button>
                            </form>
                        </td>
                        <td><?= (int) $bin['current_fill_level'] ?>%</td>
                        <td><span class="rating-metric <?= $bin['status'] === 'Critical' ? 'very-poor' : ($bin['status'] === 'Warning' ? 'average' : 'excellent') ?>"><?= htmlspecialchars($bin['status']) ?></span></td>
                        <td>
                            <form method="POST" action="manage_bins.php" onsubmit="return confirm('Delete this bin?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="bin_id" value="<?= (int) $bin['bin_id'] ?>">
                                <button type="submit" class="submit-btn" style="width: auto; padding: 6px 14px; background-color: #e74c3c;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
