<?php
include 'connect.php';
$table = "incident_reports"; 

// $conn = @new mysqli($host, $user, $password, $database);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($conn->connect_error) {
        $message = '<div class="error-message">Error: Database connection failed. Please try again later.</div>';
    } else {
        $name = $conn->real_escape_string($_POST['reporter_name'] ?? 'Anonymous Citizen');
        $location = $conn->real_escape_string($_POST['location']);
        $report_type = $conn->real_escape_string($_POST['report_type']);
        $details = $conn->real_escape_string($_POST['details']);
        $contact = $conn->real_escape_string($_POST['contact'] ?? NULL);

        $sql = "INSERT INTO $table (reporter_name, location, report_type, details, contact_info, status) 
                VALUES ('$name', '$location', '$report_type', '$details', '$contact', 'Pending')";
        
        if ($conn->query($sql) === TRUE) {
            $message = '<div style="padding: 15px; background-color: #2ecc71; color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                            <i class="fas fa-check-circle"></i> Report submitted successfully! We will review this incident shortly.
                        </div>';
        } else {
            $message = '<div class="error-message">Error saving report: ' . $conn->error . '</div>';
        }
    }
}


if (isset($conn) && !$conn->connect_error) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Reporting Portal - SWMS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <header>
        <h1><img src="images/hero_background.jpg" alt="SWMS Logo" class="logo-icon"> Smart Waste Management System</h1>
        <nav>
            <a href="index.php">System Overview</a>
            <a href="report.php">Report Here</a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php" style="background-color: #3498db; margin-left: 15px; font-weight: bold;">
                ADMIN LOGIN
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="report-form-container" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            
            <h2 style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> Report an Incident</h2>
            <p style="color: #555; font-size: 16px;"> Use this form to report any issues. we shall help with any issue in the shortest time possible.<br>
                <span style="color: #27ae60; font-weight: bold;">"Kozesa foomu eno okuwandiika ebizibu byona.Tugenda kukuyamba okukola ku bizibu bino mu budde obutali bungi."</span>
            </p>
            
            <?php echo $message; ?>

            <form method="POST" action="report.php" style="background-color: #f8f9fa; padding: 30px; border-radius: 10px; border-left: 5px solid #e74c3c;">
                
                <label for="report_type" style="font-weight: bold; color: #2c3e50;">Type of Incident:</label>
                <select id="report_type" name="report_type" required style="background-color: #ffffff; border: 2px solid #3498db; color: #2c3e50; padding: 10px; border-radius: 5px; width: 100%; margin-bottom: 15px;">
                    <option value="">-- Select Incident Type --</option>
                    <option value="Illegal Dumping">Illegal Dumping</option>
                    <option value="Damaged Bin">Damaged Bin</option>
                    <option value="Non-Collection">Missed collecting rubbish</option>
                    <option value="Overflowing Area">overflowing bins</option>
                    <option value="Other">Other Issue</option>
                </select>

                <label for="location" style="font-weight: bold; color: #2c3e50;">Specific Location :</label>
                <input type="text" id="location" name="location" style="border: 2px solid #3498db; padding: 10px; border-radius: 5px; width: 100%; margin-bottom: 15px;" >

                <label for="details" style="font-weight: bold; color: #2c3e50;">Detailed Description of the Issue:</label>
                <textarea id="details" name="details" rows="7" style="border: 2px solid #3498db; padding: 10px; border-radius: 5px; width: 100%; margin-bottom: 15px; font-family: Arial;"></textarea>

                

                <button type="submit" style="background-color: #27ae60; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 16px; transition: 0.3s;">Submit Incident Report</button>
            </form>
        </div>
    </div>

    <footer>
        <p>Connect With Us</p>
        <p>0100400100</p>
        <p>+256754343434 / +256751111111</p>
        <p>swmsuganda@gmail.com</p>
        <div class="footer-divider"></div>
        <p>&copy;2025 Smart Waste Management System | All rights Reserved</p>
    </footer>

</body>
</html>