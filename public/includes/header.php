<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'SWMS - Smart Waste Management') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?= $extraHead ?? '' ?>
</head>
<body>
    <header>
        <h1><img src="assets/images/hero_background.jpg" alt="SWMS Logo" class="logo-icon"> Smart Waste Management System</h1>

        <div class="menu-toggle" id="mobile-menu">
            <i class="fas fa-bars"></i>
        </div>
        <nav id="nav-list">
            <a href="index.php">System Overview</a>
            <a href="report.php">Report Here</a>
            <a href="contact.php">Contact Us</a>
            <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                <a href="dashboard.php" class="nav-admin-btn">DASHBOARD</a>
                <a href="logout.php" class="nav-admin-btn">LOGOUT</a>
            <?php else: ?>
                <a href="login.php" class="nav-admin-btn">ADMIN LOGIN</a>
            <?php endif; ?>
        </nav>
    </header>
