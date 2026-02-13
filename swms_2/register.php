<?php

session_start();

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "swms_simple"; 
$port = 3306; 

$register_message = '';

$AUTHORIZED_IDS = ["KCCA01", "KCCA02", "KCCA03", "KCCA04", "KCCA05"]; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = @new mysqli($host, $user, $password, $database, $port);

    if ($conn->connect_error) {
        $register_message = '<div class="error-message">Database connection failed.</div>';
    } else {
        $emp_id = strtoupper(trim($conn->real_escape_string($_POST['emp_id']))); 
        $pass = $_POST['password'];

        
        if (!in_array($emp_id, $AUTHORIZED_IDS)) {
            $register_message = '<div class="error-message">Invalid Organizational ID. Registration denied.</div>';
        } elseif (strlen($pass) < 6) {
            $register_message = '<div class="error-message">Password must be at least 6 characters.</div>';
        } else {
           
            $check = $conn->prepare("SELECT admin_id FROM admin WHERE username = ?");
            $check->bind_param("s", $emp_id);
            $check->execute();
            if ($check->get_result()->num_rows > 0) {
                $register_message = '<div class="error-message">This ID is already registered to an account.</div>';
            } else {
                
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO admin (username, password_hash) VALUES (?, ?)");
                $stmt->bind_param("ss", $emp_id, $hash);

                if ($stmt->execute()) {
                    $register_message = '<div style="padding: 15px; background-color: var(--primary-green); color: white; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                        <i class="fas fa-check-circle"></i> Registration Successful! <br>
                        Username: <strong>' . $emp_id . '</strong> <br>
                        <a href="login.php" style="color: white; font-weight: bold; text-decoration: underline;">Proceed to Login</a>
                    </div>';
                }
                $stmt->close();
            }
            $check->close();
        }
    }
    if (isset($conn)) $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup - SWMS</title>
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
            <a href="contact.php">Contact</a>
            <a href="login.php" style="background-color: #2980b9; color: var(--header-blue); margin-left: 15px; font-weight: bold; padding: 8px 15px; border: 1px solid var(--header-blue); border-radius: 5px;">ADMIN LOGIN</a>
        </nav>
    </header>

    <div class="report-form-container" style="max-width: 450px;">
        <h2 style="text-align: center; color: var(--text-color);">Admin Registration</h2>
        <p style="text-align: center; margin-bottom: 25px; font-size: 0.9em; color: var(--text-color);">Enter your official Organizational ID and choose a secure password.</p>
        
        <?php echo $register_message; ?>
        
        <form action="register.php" method="POST">
            <label for="emp_id">Organizational ID:</label>
            <input type="text" id="emp_id" name="emp_id" placeholder="ID Number" required>

            <label for="password">Choose Password:</label>
            <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required>

            <button type="submit">Create Admin Account</button>
        </form>
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