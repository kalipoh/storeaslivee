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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        $query = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Password salah.";
            }
        } else {
            $error_message = "Username tidak ditemukan.";
        }
    } else {
        $error_message = "Harap isi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

        .login-container {
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

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #1a1a1a;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .login-header p {
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

        .login-button {
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

        .login-button:hover {
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

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }

            .login-header h1 {
                font-size: 1.8rem;
            }
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            color: #666;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .forgot-password {
            text-align: right;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome</h1>
            <p>Please entering to your Account</p>
        </div>
        <?php if ($error_message) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
                	
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>
            <button type="submit" class="login-button">Masuk</button>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
<div class="register-link" style="text-align: center; margin-top: 1rem;">
    <p>Don't have an account? <a href="register.php" style="color: #667eea; text-decoration: none;">Register here</a></p>
</div>
            
        </form>
    </div>
</body>
</html>