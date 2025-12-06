<?php
session_start();

// Include database connection and User class
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../models/User.php';

// Handle login form submission
if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = new User($conn);

    // Verify user credentials
    $loggedInUser = $user->verify($email, $password);

    if($loggedInUser){
        // Store user info in session
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['username'] = $loggedInUser['username'];
        $_SESSION['email'] = $loggedInUser['email'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothify - Login</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

    <!-- LOGIN SECTION -->
    <section class="login-section">
        <div class="login-card">
            <div class="login-logo">Clothify</div>
            <h2>Welcome Back</h2>
            <p class="login-subtitle">Sign in to continue</p>
            <form action="login_process.php" method="POST">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder=" " required>
                    <label for="password">Password</label>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="signup-text">
                Don't have an account? <a href="register.php">Sign Up</a>
            </p>
        </div>
    </section>

</body>
</html>
