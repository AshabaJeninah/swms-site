<?php
require_once __DIR__ . '/../config/database.php';
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
        $message = '<div style="padding: 15px; background-color: #2ecc71; color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                        <i class="fas fa-check-circle"></i> Report submitted successfully! We will review this incident shortly.
                    </div>';
    } else {
        $message = '<div class="error-message">Error saving report. Please try again.</div>';
    }
    $stmt->close();
}

$pageTitle = 'Report an Incident - SWMS';
include __DIR__ . '/includes/header.php';
?>

    <div class="container">
        <div class="report-form-container" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">

            <h2 style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> Report an Incident</h2>
            <p style="color: #555; font-size: 16px;"> Use this form to report any issues. we shall help with any issue in the shortest time possible.<br>
                <span style="color: #27ae60; font-weight: bold;">"Kozesa foomu eno okuwandiika ebizibu byona.Tugenda kukuyamba okukola ku bizibu bino mu budde obutali bungi."</span>
            </p>

            <?= $message ?>

            <form method="POST" action="report.php">

                <label for="report_type">Type of Incident:</label>
                <select id="report_type" name="report_type" required>
                    <option value="">-- Select Incident Type --</option>
                    <option value="Illegal Dumping">Illegal Dumping</option>
                    <option value="Damaged Bin">Damaged Bin</option>
                    <option value="Non-Collection">Missed collecting rubbish</option>
                    <option value="Overflowing Area">overflowing bins</option>
                    <option value="Other">Other Issue</option>
                </select>

                <label for="location" style="font-weight: bold; color: #2c3e50;">Specific Location :</label>
                <input type="text" id="location" name="location" required>
                <label for="details">Detailed Description of the Issue:</label>
                <textarea id="details" name="details" rows="7" required></textarea>
                <button type="submit">Submit Incident Report</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
