<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        body {
            background-image: url('images/bg-2.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        /* Styling for Home Button */
        .home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease;
        }

        .home-btn:hover {
            background-color: #45a049;
        }

        /* Styling for User Login Button */
        .user-login-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #008CBA;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease;
        }

        .user-login-btn:hover {
            background-color: #007bb5;
        }

        /* Centering the form */
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            position: relative;
        }

        /* Container for the login form */
        .container {
            background-color: rgba(255, 255, 255, 0.9);  /* Slight background to make form visible */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: scale(1.05);
        }

        /* Styling for the form title */
        .text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Styling for the input fields and labels */
        .data {
            margin-bottom: 20px;
            position: relative;
        }

        .data label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            position: absolute;
            top: -18px;
            left: 12px;
            background-color: #fff;
            padding: 0 5px;
            font-size: 16px;
        }

        .data input {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .data input:focus {
            border-color: #4CAF50;
        }

        /* Styling for the login button */
        .btn button {
            width: 100%;
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        /* Forgot password link */
        .forgot-pass {
            margin-top: 10px;
        }

        .forgot-pass a {
            color: #007bff;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-pass a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Close button for the form */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="center">
        <?php
        if(isset($_SESSION['status'])) {
            echo $_SESSION['status'];
            unset($_SESSION['status']);
        }
        ?>

        <!-- Home Page Button -->
        <a href="index.php" class="home-btn">Home</a>

        <!-- User Login Button -->
        <a href="userlogin.php" class="user-login-btn">User Login</a>

        <!-- Centered Form Container -->
        <div class="container">
            <div class="text">ADMIN LOGIN</div>
            <form action="login_check.php" method="POST">
                <div class="data">
                    <label>Email or Phone</label>
                    <input type="text" name="adminemail" required>
                </div>
                <div class="data">
                    <label>Password</label>
                    <input type="password" name="adminpassword" required>
                </div>
                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
                <div class="btn">
                    <button type="submit" name="adminsubmit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
