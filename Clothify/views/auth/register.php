<?php
session_start();

// Include database connection and User class
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../models/User.php';

// Handle form submission
if(isset($_POST['register'])){

    // Get user input safely
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Debugging (optional) - remove after testing
    // var_dump($username, $email, $password); exit;

    // Basic validation
    if(empty($username) || empty($email) || empty($password)){
        $error = "All fields are required!";
    } else {
        $user = new User($conn);

        // Check if email already exists
        if($user->findByEmail($email)){
            $error = "Email already registered!";
        } else {
            // Create new user with the input username
            if($user->create($username, $email, $password)){
                $_SESSION['success'] = "Account created successfully!";
                header("Location: login.php"); // redirect to login page
                exit;
            } else {
                $error = "Error creating account!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothify - Sign Up</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

    <!-- SIGNUP SECTION -->
    <section class="login-section signup-section">
        <div class="login-card">
            <div class="login-logo">Clothify</div>
            <h2>Create Account</h2>
            <p class="login-subtitle">Sign up to start shopping</p>
            <form action="register_process.php" method="POST">
                <div class="input-group">
                    <input type="text" id="username" name="username" placeholder=" " required>
                    <label for="username">UserName</label>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder=" " required>
                    <label for="password">Password</label>
                </div>
                <div class="input-group">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
                    <label for="confirm_password">Confirm Password</label>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p class="signup-text">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </div>
    </section>

</body>
</html>
