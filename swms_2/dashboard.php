<?php
include('connect.php'); 
$query = "SELECT * FROM bins LIMIT 1"; 
$result = mysqli_query($conn, $query);
$bin = mysqli_fetch_assoc($result);

$fill = $bin['current_fill_level'] ?? 0;
$loc = $bin['location_name'] ?? 'Not Set';
$status = $bin['status'] ?? 'Unknown';
$updated = $bin['last_updated'] ?? 'N/A';
$bar_color = "#2ecc71"; 
if ($fill >= 90) { $bar_color = "#e74c3c"; }      
elseif ($fill >= 70) { $bar_color = "#f1c40f"; }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <header>
        <h1><img src="images/hero_background.jpg" alt="SWMS Logo" class="logo-icon"> Smart Waste Management System</h1>

         <div class="menu-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>
        <nav id="nav-list">
            <a href="index.php">System Overview</a>
            <a href="report.php">Report Here</a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php" style="background-color: #1a5c88; margin-left: 15px; font-weight: bold;">
                ADMIN LOGIN
            </a>
        </nav>
    </header>
       

<div class="app-shell">
    <h2 style="text-align: center; color: var(--secondary-blue);">MONITORING DASHBOARD</h2>

    <div class="monitoring-network" style="display: block; max-width: 550px; margin: 0 auto;">
        <div class="vessel-status-card" style="border-left: 8px solid <?php echo $bar_color; ?>;">
            
            <div class="vessel-identity-header">
                <h3><i class="fas fa-trash"></i> <?php echo $loc; ?></h3>
                <span class="status-badge" style="background: <?php echo $bar_color; ?>; color: white;">
                    <?php echo strtoupper($status); ?>
                </span>
            </div>

            <div class="capacity-meter" style="height: 30px; margin-top: 15px;">
                <div class="fill-progress-bar" style="width: <?php echo $fill; ?>%; background: <?php echo $bar_color; ?>;"></div>
            </div>
            
            <p style="text-align: right; font-weight: bold; margin-top: 5px;">
                Current Level: <?php echo $fill; ?>%
            </p>

            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; display: grid; grid-template-columns: 1fr 1fr; font-size: 0.9em;">
                <span><strong>ID:</strong> #<?php echo $bin['bin_id']; ?></span>
                <span><strong>Updated:</strong> <?php echo $updated; ?></span>
            </div>
        </div>
    </div>
</div>
    <div class="logistics-optimization-summary" style="margin-top: 40px;">
        <h3>Incidents & Reports</h3>
        <table class="audit-log-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Issue Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#882</td>
                    <td>Main St.</td>
                    <td>Overflowing</td>
                    <td><span class="rating-metric poor">Pending</span></td>
                </tr>
                <tr>
                    <td>#881</td>
                    <td>Church Rd.</td>
                    <td>Sensor Fault</td>
                    <td><span class="rating-metric excellent">Resolved</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<footer>
        <p>Connect With Us</p>
        <p>0100400100</p>
        <p>+256754343434 / +256751111111</p>
        <p>swmsuganda@gmail.com</p>
        <div class="footer-divider"></div>
        <p>&copy;2026 Smart Waste Management System | All rights Reserved</p>
    </footer>

<script src="script.js"></script>

</body>
</html>