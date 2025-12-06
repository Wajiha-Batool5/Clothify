<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothify - Login</title>
    <link rel="stylesheet" href="style.css">
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
                Don't have an account? <a href="register.html">Sign Up</a>
            </p>
        </div>
    </section>

</body>
</html>
