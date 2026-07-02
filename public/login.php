<?php
session_start();
require_once __DIR__ . '/../config/database.php';
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
$extraHead = <<<HTML
    <style>
        .report-form-container h2 {
            color: #2c3e50 !important;
        }

        .report-form-container input[type="text"]:focus,
        .report-form-container input[type="password"]:focus {
            outline: none !important;
            border-color: #2980b9 !important;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5) !important;
        }

        .report-form-container button {
            background-color: #27ae60 !important;
        }
    </style>
HTML;

include __DIR__ . '/includes/header.php';
?>

<div class="report-form-container" style="max-width: 450px;">
    <h2 style="font-size: 2.2em; margin-bottom: 25px;">Administrator Login</h2>
    <?= $login_message ?>

    <form action="login.php" method="POST">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Admin username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Log In</button>
    </form>

    <p style="text-align: center; margin-top: 15px; font-size: 1em;">
        Don't have an account?
        <a href="register.php" style="color: var(--primary-green); font-weight: bold; text-decoration: none;">Register here</a>
    </p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
