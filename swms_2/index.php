
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SWMS - Smart Waste Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .division-spotlight {
            background: linear-gradient(rgba(44, 62, 80, 0.7), rgba(44, 62, 80, 0.7)), url('images/hero_background.jpg') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 80px 40px;
            text-align: center;
        }

        .division-spotlight h2 {
            font-size: 3.5em;
            margin-bottom: 15px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .division-spotlight p {
            font-size: 1.2em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .action-launch {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 18px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border: 2px solid white;
        }

        .action-launch:hover {
            background-color: #c0392b;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .sanitation-array {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .status-node {
            background: white;
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            border-left: 6px solid var(--secondary-blue);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .status-node:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .status-node:nth-child(1) {
            border-left-color: #3498db;
        }

        .status-node:nth-child(1) i {
            color: #3498db;
        }

        .status-node:nth-child(2) {
            border-left-color: #27ae60;
        }

        .status-node:nth-child(2) i {
            color: #27ae60;
        }

        .status-node:nth-child(3) {
            border-left-color: #f39c12;
        }

        .status-node:nth-child(3) i {
            color: #f39c12;
        }

        .status-node i {
            font-size: 3.5em;
            margin-bottom: 20px;
        }
        
        .status-node h3 {
            color: #2c3e50;
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .status-node p {
            color: #7f8c8d;
            line-height: 1.6;
        }

        .app-shell {
            padding: 80px 40px;
            background-color: #f8f9fa;
        }

        .app-shell h2 {
            color: #16a085;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
            border-bottom: 4px solid #27ae60;
            display: inline-block;
            padding-bottom: 10px;
            margin-left: 50%;
            transform: translateX(-50%);
        }
    </style>
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

    <div class="division-spotlight">
        <h2>Kawempe Smart Waste Management System</h2>
        <p style="font-size: 1.5em; margin: 20px 0; font-weight: bold; letter-spacing: 1px;">"Smart Bins. Smart People. Smart Kawempe"</p>
        <p>Powered by IoT technology and community action for a cleaner, greener city</p>
        <p style="margin: 30px 0; font-size: 1.1em; opacity: 0.95;">Have you spotted an issue? Click Report to help keep Kawempe clean.</p>
        <a href="report.php" class="action-launch"><i class="fas fa-exclamation-triangle"></i> Report an Issue Now</a>
    </div>

    <div class="app-shell">
        
        <h2 style="text-align: center; color: #16a085; margin-bottom: 40px; font-size: 2.2em;"> Our Objectives</h2>
        <div class="sanitation-array">
            
            <div class="status-node">
                <i class="fas fa-microchip"></i>
                <h3>IoT Monitoring</h3>
                <p>Real-time Waste monitoring system with sensors placed in bins that transmit live fill levels to our dashboard, ensuring bins are collected only when full.</p>
            </div>
            
             <div class="status-node">
                <i class="fas fa-comments"></i>
                <h3>Community Feedback</h3>
                <p>Community-driven reporting platform where YOU can report issues and help us respond faster to waste management problems in your area.</p>
            </div>
            
            <div class="status-node">
                <i class="fas fa-route"></i>
                <h3>Optimized Routing</h3>
                <p>Advanced algorithms calculate the most efficient collection routes based on live fill data, drastically reducing fuel consumption and operational time.</p>
            </div>
            
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