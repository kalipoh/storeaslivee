<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$host = "sql212.infinityfree.com";
$username = "if0_38396302";
$password = "laurentindra12";
$database = "if0_38396302_aslive_gadget_store"; // Changed to match username prefix
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Cek apakah username sudah ada
            $check_username = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $check_username->bind_param("s", $username);
            $check_username->execute();
            $result = $check_username->get_result();
            
            if ($result->num_rows === 0) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user baru
                $query = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $query->bind_param("sss", $username, $email, $hashed_password);
                
                if ($query->execute()) {
                    $success_message = "Registrasi berhasil! Silakan login.";
                    header("refresh:3;url=login.php");
                } else {
                    $error_message = "Gagal mendaftar. Silakan coba lagi.";
                }
            } else {
                $error_message = "Username sudah digunakan.";
            }
        } else {
            $error_message = "Password tidak cocok.";
        }
    } else {
        $error_message = "Harap isi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gunakan style yang sama seperti login form */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .register-container:hover {
            transform: translateY(-5px);
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h1 {
            color: #1a1a1a;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .register-header p {
            color: #666;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 12px 45px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .register-button:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
            padding: 10px;
            border-radius: 8px;
            background: rgba(220, 53, 69, 0.1);
            font-size: 0.9rem;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 1rem;
            padding: 10px;
            border-radius: 8px;
            background: rgba(40, 167, 69, 0.1);
            font-size: 0.9rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Register</h1>
            <p>Create your account</p>
        </div>
        <?php 
        if ($error_message) { 
            echo "<p class='error-message'>$error_message</p>"; 
        }
        if ($success_message) { 
            echo "<p class='success-message'>$success_message</p>"; 
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="register-button">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </form>
    </div>
</body>
</html>