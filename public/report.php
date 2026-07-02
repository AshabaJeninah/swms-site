<?php
require_once __DIR__ . '/config/database.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['reporter_name'] ?: 'Anonymous Citizen';
    $location = $_POST['location'] ?? '';
    $report_type = $_POST['report_type'] ?? '';
    $details = $_POST['details'] ?? '';
    $contact = $_POST['contact'] ?? null;

    $stmt = $conn->prepare("INSERT INTO incident_reports (reporter_name, location, report_type, details, contact_info, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param('sssss', $name, $location, $report_type, $details, $contact);

    if ($stmt->execute()) {
        $message = '<div class="success-message"><i class="fas fa-check-circle"></i> Report submitted successfully! We will review this incident shortly.</div>';
    } else {
        $message = '<div class="error-message">Error saving report. Please try again.</div>';
    }
    $stmt->close();
}

$pageTitle = 'Report an Incident - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div class="incident-form" style="max-width: 560px; width: 100%;">
        <h2><i class="fas fa-exclamation-triangle"></i> Report an Incident</h2>
        <p style="color: var(--color-text-muted);">
            Use this form to report any issues. We shall help with any issue in the shortest time possible.<br>
            <span style="color: var(--color-success); font-weight: 600;">"Kozesa foomu eno okuwandiika ebizibu byona. Tugenda kukuyamba okukola ku bizibu bino mu budde obutali bungi."</span>
        </p>

        <?= $message ?>

        <form method="POST" action="report.php">
            <label for="report_type">Type of Incident:</label>
            <select id="report_type" name="report_type" required>
                <option value="">-- Select Incident Type --</option>
                <option value="Illegal Dumping">Illegal Dumping</option>
                <option value="Damaged Bin">Damaged Bin</option>
                <option value="Non-Collection">Missed collecting rubbish</option>
                <option value="Overflowing Area">Overflowing bins</option>
                <option value="Other">Other Issue</option>
            </select>

            <label for="location">Specific Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="details">Detailed Description of the Issue:</label>
            <textarea id="details" name="details" rows="6" required></textarea>

            <button type="submit">Submit Incident Report</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
