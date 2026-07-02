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
            $message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                            <i class="fas fa-check-circle"></i> Thank you! Your message has been sent.
                        </div>';
        } else {
            $message = '<div class="error-message">Error submitting message. Please try again.</div>';
        }
        $stmt->close();
    }
}

$pageTitle = 'Contact Us - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: center; gap: 30px; margin: 50px auto; max-width: 1050px;">

    <div class="report-form-container" style="flex: 2; margin: 0; padding: 30px;">
        <h2 style="font-size: 2.5em; color: var(--text-color); margin-bottom: 25px;">Send Us a Message</h2>
        <?= $message ?>

        <form action="contact.php" method="POST">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="email required">

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" placeholder="Your message" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div style="flex: 1; margin: 0; align-self: flex-start;">

        <div class="contact-info-block" style="margin-bottom: 20px;">
            <h3>Connect with Us</h3>

            <p>
                <i class="fas fa-phone-alt"></i>
                (+256)-7810020003/ (+256)-751002003
            </p>
            <p>
                <i class="fas fa-envelope"></i>
                swmsuganda@gmail.com
            </p>
            <p>
                <i class="fas fa-map-marker-alt"></i>
                KCCA Headquarters, Kampala, Uganda
            </p>
        </div>

        <div class="contact-info-block">
            <h3>Urgent Request?</h3>
            <p style="font-size: 1em; margin-bottom: 10px; color: var(--text-color);">
                In case of any emergency reporting, please use our hotline for immediate dispatch assistance.
            </p>
            <p style="font-size: 1.2em; font-weight: bold; color: var(--primary-green);">
                <i class="fas fa-exclamation-triangle"></i> Call: 0100400100
            </p>
        </div>

    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
