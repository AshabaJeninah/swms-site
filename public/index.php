<?php
$pageTitle = 'Welcome to SWMS - Smart Waste Management';
$extraHead = <<<HTML
    <style>
        .division-spotlight {
            background: linear-gradient(rgba(21, 63, 91, 0.75), rgba(21, 63, 91, 0.75)), url('assets/images/hero_background.png') no-repeat center center;
        }
    </style>
HTML;

include __DIR__ . '/includes/header.php';
?>

    <div class="division-spotlight">
        <h2>Kawempe Smart Waste Management System</h2>
        <p style="font-size: var(--text-xl); font-weight: bold; letter-spacing: 0.5px;">"Smart Bins. Smart People. Smart Kawempe"</p>
        <p>Powered by IoT technology and community action for a cleaner, greener city</p>
        <p>Have you spotted an issue? Click Report to help keep Kawempe clean.</p>
        <a href="report.php" class="action-launch"><i class="fas fa-exclamation-triangle"></i> Report an Issue Now</a>
    </div>

    <div class="app-shell">
        <h2 class="page-heading">How We Work - Our Integrated Solutions</h2>
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

<?php include __DIR__ . '/includes/footer.php'; ?>
