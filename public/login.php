<?php
session_start();
require_once __DIR__ . '/config/database.php';
$login_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT admin_id, password_hash, username FROM admin WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password_input, $row['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];

            header('Location: dashboard.php');
            exit;
        }
    }

    $login_message = '<div class="error-message">Invalid username or password.</div>';
    $stmt->close();
}

$pageTitle = 'Admin Login - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div class="report-form-container">
        <h2 style="text-align: center; color: var(--color-primary);">Administrator Login</h2>
        <?= $login_message ?>

        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Admin username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <button type="submit">Log In</button>
        </form>

        <p style="text-align: center; margin-top: var(--space-4);">
            Don't have an account?
            <a href="register.php" style="color: var(--color-success); font-weight: 600; text-decoration: none;">Register here</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
