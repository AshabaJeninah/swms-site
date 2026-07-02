<?php
session_start();
require_once __DIR__ . '/config/database.php';
$register_message = '';

$AUTHORIZED_IDS = ['KCCA01', 'KCCA02', 'KCCA03', 'KCCA04', 'KCCA05'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = strtoupper(trim($_POST['emp_id'] ?? ''));
    $pass = $_POST['password'] ?? '';

    if (!in_array($emp_id, $AUTHORIZED_IDS, true)) {
        $register_message = '<div class="error-message">Invalid Organizational ID. Registration denied.</div>';
    } elseif (strlen($pass) < 6) {
        $register_message = '<div class="error-message">Password must be at least 6 characters.</div>';
    } else {
        $check = $conn->prepare('SELECT admin_id FROM admin WHERE username = ?');
        $check->bind_param('s', $emp_id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            $register_message = '<div class="error-message">This ID is already registered to an account.</div>';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO admin (username, password_hash) VALUES (?, ?)');
            $stmt->bind_param('ss', $emp_id, $hash);

            if ($stmt->execute()) {
                $register_message = '<div class="success-message">
                    <i class="fas fa-check-circle"></i> Registration Successful! Username: <strong>' . htmlspecialchars($emp_id) . '</strong><br>
                    <a href="login.php" style="color: white; font-weight: 600; text-decoration: underline;">Proceed to Login</a>
                </div>';
            } else {
                $register_message = '<div class="error-message">Registration failed. Please try again.</div>';
            }
            $stmt->close();
        }
        $check->close();
    }
}

$pageTitle = 'Admin Setup - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div class="report-form-container">
        <h2 style="text-align: center; color: var(--color-primary);">Admin Registration</h2>
        <p style="text-align: center; font-size: var(--text-sm); color: var(--color-text-muted);">Enter your official Organizational ID and choose a secure password.</p>

        <?= $register_message ?>

        <form action="register.php" method="POST">
            <label for="emp_id">Organizational ID:</label>
            <input type="text" id="emp_id" name="emp_id" placeholder="ID Number" required>

            <label for="password">Choose Password:</label>
            <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required>

            <button type="submit">Create Admin Account</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
