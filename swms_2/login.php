<?php

session_start();

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "swms_simple"; 
$port = 3306; 

$login_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = @new mysqli($host, $user, $password, $database, $port);

    if ($conn->connect_error) {
        $login_message = '<div class="error-message">Database connection failed: ' . $conn->connect_error . '</div>';
    } else {
        $username = $conn->real_escape_string($_POST['username']);
        $password_input = $_POST['password'];

        $stmt = $conn->prepare("SELECT admin_id, password_hash, username FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password_input, $row['password_hash'])) {
                $_SESSION['admin_logged_in'] = TRUE;
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['admin_username'] = $row['username'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                $login_message = '<div class="error-message">Invalid username or password.</div>';
            }
        } else {
            $login_message = '<div class="error-message">Invalid username or password.</div>';
        }

        $stmt->close();
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
    <title>Admin Login - SWMS</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .report-form-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 10px;
            border-left: 5px solid #3498db;
        }
        
        .report-form-container h2 {
            color: #2c3e50 !important;
        }
        
        .report-form-container label {
            color: #2c3e50 !important;
            font-weight: bold !important;
        }
        
        .report-form-container input[type="text"],
        .report-form-container input[type="password"] {
            background-color: #ffffff !important;
            border: 2px solid #3498db !important;
            color: #2c3e50 !important;
            padding: 10px !important;
            border-radius: 5px !important;
            width: 100% !important;
            margin-bottom: 15px !important;
            box-sizing: border-box !important;
        }
        
        .report-form-container input[type="text"]:focus,
        .report-form-container input[type="password"]:focus {
            outline: none !important;
            border-color: #2980b9 !important;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5) !important;
        }
        
        .report-form-container button {
            background-color: #27ae60 !important;
            color: white !important;
            padding: 12px 30px !important;
            border: none !important;
            border-radius: 5px !important;
            cursor: pointer !important;
            font-weight: bold !important;
            font-size: 16px !important;
            width: 100% !important;
            transition: 0.3s !important;
        }
        
        .report-form-container button:hover {
            background-color: #229954 !important;
        }
    </style>
</head>
<body>
    <header>
        <h1><img src="images/hero_background.jpg" alt="SWMS Logo" class="logo-icon"> Smart Waste Management System</h1>
        <nav>
            <a href="index.php">System Overview</a>
            <a href="report.php">Report Here</a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php" style="background-color: #2980b9; color: white; margin-left: 15px; font-weight: bold; padding: 8px 15px;">
                ADMIN LOGIN
            </a>
        </nav>
    </header>

<div class="report-form-container" style="max-width: 450px;">
    <h2 style="font-size: 2.2em; margin-bottom: 25px;">Administrator Login</h2>
    <?php echo $login_message; ?>
    
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