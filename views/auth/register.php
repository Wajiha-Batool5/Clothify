<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothify - Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- SIGNUP SECTION -->
    <section class="login-section signup-section">
        <div class="login-card">
            <div class="login-logo">Clothify</div>
            <h2>Create Account</h2>
            <p class="login-subtitle">Sign up to start shopping</p>
            <form action="signup_process.php" method="POST">
                <div class="input-group">
                    <input type="text" id="name" name="name" placeholder=" " required>
                    <label for="name">Full Name</label>
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
                Already have an account? <a href="login.html">Login</a>
            </p>
        </div>
    </section>

</body>
</html>
