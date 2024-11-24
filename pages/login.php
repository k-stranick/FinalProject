<?php
// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Project 3
// Due: 11/22/2024

require_once '../database/mysqli_conn.php';
$title = 'Login Page';
$stylesheets = ['../css/global.css', '../css/login.css']; // Include both global and login-specific styles
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">

    <!-- Log in form -->
    <main class="content flex-grow-1 entry-section">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-section">
                        <h2>Welcome Back!</h2>
                        <p>
                            Log in to your account to explore amazing deals on pre-loved items.
                            Not a member yet? <a href="register.php">Register now</a> and join our community today!
                        </p>

                        <form method="post" action="../php_functions/passwordAuthenticate.php">
                            <?php if (isset($_GET['error'])): ?>
                                <div class="error-message">
                                    <?= htmlspecialchars($_GET['error']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Log In</button>
                        </form>

                        <p class="mt-3">
                            <a href="#">Forgot Password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>

</html>