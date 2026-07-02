<?php
require_once __DIR__ . '/config/database.php';

$apiKey = getenv('IOT_API_KEY');
if ($apiKey && ($_GET['key'] ?? '') !== $apiKey) {
    http_response_code(403);
    exit('Forbidden');
}

if (!isset($_GET['bin_id'], $_GET['level'])) {
    http_response_code(400);
    exit('Error: Missing parameters. Usage: update_bin.php?bin_id=1&level=50&key=YOUR_KEY');
}

$id = (int) $_GET['bin_id'];
$level = max(0, min(100, (int) $_GET['level']));

$status = 'OK';
if ($level >= 90) {
    $status = 'Critical';
} elseif ($level >= 70) {
    $status = 'Warning';
}

$stmt = $conn->prepare('UPDATE bins SET current_fill_level = ?, status = ?, last_updated = NOW() WHERE bin_id = ?');
$stmt->bind_param('isi', $level, $status, $id);

if ($stmt->execute()) {
    echo "Success: Bin #$id updated to $level%";
} else {
    http_response_code(500);
    echo 'Error updating record.';
}
$stmt->close();
