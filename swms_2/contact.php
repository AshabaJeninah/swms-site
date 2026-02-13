<?php

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "swms_simple"; 
$port = 3306; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = @new mysqli($host, $user, $password, $database, $port);

    if ($conn->connect_error) {
        $message = '<div class="error-message">Database connection failed. Please try again later.</div>';
    } else {
        $name = $conn->real_escape_string($_POST['name'] ?? 'Anonymous');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $subject = 'General Feedback/Inquiry'; 
        $msg = $conn->real_escape_string($_POST['message']);

        if (empty($msg)) {
            $message = '<div class="error-message">Message field cannot be empty.</div>';
        } else {
            $sql = "INSERT INTO contact_feedback (name, email, subject, message) 
                    VALUES ('$name', '$email', '$subject', '$msg')";
            
            if ($conn->query($sql) === TRUE) {
                $message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                                <i class="fas fa-check-circle"></i> Thank you! Your message has been sent.
                            </div>';
            } else {
                $message = '<div class="error-message">Error submitting message: ' . $conn->error . '</div>';
            }
        }
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SWMS</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1><img src="images/hero_background.jpg" alt="SWMS Logo" class="logo-icon"> Smart Waste Management System</h1>
        <nav>
            <a href="index.php">System Overview</a>
            <a href="report.php">Report Here</a>
            <a href="contact.php" style="background-color: #2980b9;">Contact Us</a>
            <a href="login.php" style="background-color: #2980b9; color: var(--header-blue); margin-left: 15px; font-weight: bold; padding: 8px 15px;">
                ADMIN LOGIN
            </a>
        </nav>
    </header>

<div style="display: flex; justify-content: center; gap: 30px; margin: 50px auto; max-width: 1050px;">
    
    <div class="report-form-container" style="flex: 2; margin: 0; padding: 30px;">
        <h2 style="font-size: 2.5em; color: var(--text-color); margin-bottom: 25px;">Send Us a Message</h2>
        <?php echo $message; ?>
        
        <form action="contact.php" method="POST">
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="email required">

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