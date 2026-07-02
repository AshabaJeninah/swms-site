<?php
require_once __DIR__ . '/config/database.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?: 'Anonymous';
    $email = $_POST['email'] ?? '';
    $subject = 'General Feedback/Inquiry';
    $msg = trim($_POST['message'] ?? '');

    if ($msg === '') {
        $message = '<div class="error-message">Message field cannot be empty.</div>';
    } else {
        $stmt = $conn->prepare('INSERT INTO contact_feedback (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $email, $subject, $msg);

        if ($stmt->execute()) {
            $message = '<div class="success-message"><i class="fas fa-check-circle"></i> Thank you! Your message has been sent.</div>';
        } else {
            $message = '<div class="error-message">Error submitting message. Please try again.</div>';
        }
        $stmt->close();
    }
}

$pageTitle = 'Contact Us - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell" style="display: flex; gap: var(--space-6); flex-wrap: wrap; align-items: flex-start;">
    <div class="report-form-container" style="flex: 2; min-width: 280px; margin: 0;">
        <h2 style="color: var(--color-primary); margin-bottom: var(--space-5);">Send Us a Message</h2>
        <?= $message ?>

        <form action="contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="you@example.com">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" placeholder="Your message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div style="flex: 1; min-width: 240px;">
        <div class="contact-info-block" style="margin-bottom: var(--space-5);">
            <h3 style="color: var(--color-primary); margin-top: 0;">Connect with Us</h3>
            <p><i class="fas fa-phone-alt"></i>&nbsp; (+256)-7810020003 / (+256)-751002003</p>
            <p><i class="fas fa-envelope"></i>&nbsp; swmsuganda@gmail.com</p>
            <p><i class="fas fa-map-marker-alt"></i>&nbsp; KCCA Headquarters, Kampala, Uganda</p>
        </div>

        <div class="contact-info-block">
            <h3 style="color: var(--color-primary); margin-top: 0;">Urgent Request?</h3>
            <p style="color: var(--color-text-muted);">In case of any emergency reporting, please use our hotline for immediate dispatch assistance.</p>
            <p style="font-weight: 700; color: var(--color-success);"><i class="fas fa-exclamation-triangle"></i> Call: 0100400100</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
