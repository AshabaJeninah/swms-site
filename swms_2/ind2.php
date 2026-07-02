<?php
// File: index.php - The Public Landing Page (Redesigned with images)

// Ensure your database credentials are at the top if you want to show a live stat count
$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "swms_db"; 

$conn = @new mysqli($host, $user, $password, $database);
$report_count = 0;

if (!$conn->connect_error) {
    $result = $conn->query("SELECT COUNT(*) as total FROM reports");
    if ($result) {
        $row = $result->fetch_assoc();
        $report_count = $row['total'];
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SWMS: Smart Waste Management System for Kawempe</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <header>
        <h1><img src="https://via.placeholder.com/30/28a745/FFFFFF?text=🗑️" alt="Logo" class="logo-icon"> Smart Waste Management System (SWMS)</h1>
        <nav>
            <a href="index.php">System Overview</a>
            <a href="dashboard.php">IoT Monitoring Dashboard</a>
            <a href="report.php">Community Reporting Portal</a>
            <a href="admin_reports.php">Admin Reports</a>
            <a href="contact.php">Contact Us</a>
        </nav>
    </header>

    <div class="container">
        
        <div class="hero-section">
            <h2>Harnessing Data to Keep Kampala Clean and Safe.</h2>
            <p>"Unraveling a key to a balanced and vibrant life through smart waste management."</p>
            <a href="report.php" class="cta-button">
                REPORT AN ISSUE NOW 🚨
            </a>
            <?php if ($report_count > 0): ?>
                <p style="margin-top: 25px; font-size: 1em; color: #eee;">
                    Join over **<?php echo $report_count; ?>** community members actively reporting issues.
                </p>
            <?php endif; ?>
        </div>

        <h2 style="text-align: center; color: var(--blue-grey); margin-bottom: 40px; font-size: 2.2em;">Our Integrated Solutions</h2>

        <div class="solutions-grid">
            
            <div class="solution-card">
                <img src="https://images.unsplash.com/photo-1579728956272-b34e55e09419?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQzNzZ8MHwxfHNlYXJjaHwyMHx8aW90JTIwc2Vuc29yc3xlbnwwfHx8fDE3MDM2MDI0Nzh8MA&ixlib=rb-4.0.3&q=80&w=1080" alt="IoT Sensors">
                <div class="solution-card-content">
                    <h3>IoT Monitoring & Alerts</h3>
                    <p>Smart bins relay live fill levels to the dashboard, preventing overflows and reducing illegal dumping across Kawempe.</p>
                </div>
            </div>
            
            <div class="solution-card">
                <img src="https://images.unsplash.com/photo-1549611018-d421262d0e14?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQzNzZ8MHwxfHNlYXJjaHw3fHxvcHRpbWl6YXRpb24lMjByb3V0ZXN8ZW58MHx8fHwxNzAzNjAyNTY2fDA&ixlib=rb-4.0.3&q=80&w=1080" alt="Route Optimization">
                <div class="solution-card-content">
                    <h3>AI-Driven Route Optimization</h3>
                    <p>Analytics generate the most efficient collection routes, cutting fuel costs and operational time for KCCA operations.</p>
                </div>
            </div>
            
            <div class="solution-card">
                <img src="https://images.unsplash.com/photo-1595180630656-7871a3e601c3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NTQzNzZ8MHwxfHNlYXJjaHwxNXx8Y29tbXVuaXR5JTIwZW5nYWdlbWVudHxlbnwwfHx8fDE3MDM2MDI2MjV8MA&ixlib=rb-4.0.3&q=80&w=1080" alt="Community Engagement">
                <div class="solution-card-content">
                    <h3>Community Reporting Portal</h3>
                    <p>Citizens actively partner in waste management by submitting real-time reports on local issues through an accessible web portal.</p>
                </div>
            </div>
            
        </div>
        
    </div>

    <footer>
        <p>Connect With Us</p>
        <p>+2567xxxxxxxx</p>
        <p>+2567xxxxxxxx / +2567xxxxxxxx</p>
        <p>contact@swmsuganda.com</p>
        <div class="footer-divider"></div>
        <p>&copy;2024 Smart Waste Management System | All rights Reserved</p>
    </footer>

</body>
</html>