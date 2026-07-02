<?php
session_start();
require_once __DIR__ . '/config/database.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $allowedStatuses = ['Pending', 'Investigating', 'Resolved'];

    if ($id > 0 && in_array($status, $allowedStatuses, true)) {
        $stmt = $conn->prepare('UPDATE incident_reports SET status = ? WHERE id = ?');
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: dashboard.php');
exit;
