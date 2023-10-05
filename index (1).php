<?php 
    session_start();
    if (isset($_SESSION['id'])) {
        header("Location: loading.php"); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Conference Room Management</title>
</head>
<body>
    <nav>
        <h1>Conference Room</h1>
    </nav>
    <div class="container">
        <form method="post" action="login.php" id="login-form" class="form">
            <h2>Login</h2>
            <input type="text" id="login-email" placeholder="Email or Phone" name="email_phone" required>
            <input type="password" id="login-password" placeholder="Password" name="password" required>
            <button id="login" type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="#" id="toggle-signup">Sign Up</a></p>
        </form>
        <form method="post" action="register.php" id="signup-form" class="form">
            <h2>Sign Up</h2>
            <input type="text" id="signup-name" placeholder="Name" name="fullname" required>
            <input type="email" id="email" placeholder="Email" name="email" required oninput="validateEmail()">
            <div id="email-message"></div>
            <input type="tel" id="phone" placeholder="Phone Number" name="phone" required>
            <input type="password" id="password" placeholder="Password" name="password" required oninput="validatePassword()">
            <div id="password-message"></div>
            <input type="password" id="confirm-password" placeholder="Confirm Password" required oninput="validateConfirmPassword()">
            <div id="confirm-password-message"></div>
            <button id="register-btn" type="submit" name="register">Sign Up</button>
            <p>Already have an account? <a href="#" id="toggle-login">Login</a></p>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
