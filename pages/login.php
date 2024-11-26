<?php

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 * ***************************
 * 
 * Login Page Script
 *
 * This script handles the login page for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Login Form Display**: Displays a login form for users to enter their credentials.
 * 2. **Error Message Display**: Displays error messages based on user actions.
 * 3. **Registration Link**: Provides a link to the registration page for new users.
 *
 * **Dependencies**:
 * - `mysqli_conn.php`: Provides the database connection.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `footer.php`: Contains the HTML footer.
 *
 * **Page Structure**:
 * - **Header and Navigation Bar**: Includes the header and navigation bar for consistent layout across the site.
 * - **Login Form**: Displays a form for users to enter their username and password.
 * - **Error Message**: Displays error messages if any are set in the URL.
 * - **Registration Link**: Provides a link to the registration page for new users.
 * - **Footer**: Includes the footer for consistent layout across the site.
 */

require_once '../database/mysqli_conn.php';
$title = 'Login';
$stylesheets = ['../css/login.css']; // Include login-specific styles
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

                        <form method="post" action="../database/passwordAuthenticate.php">
                            <?php if (isset($_GET['error'])): ?> <!-- Check if an error message is set in the URL -->
                                <div class="error-message">
                                    <?= htmlspecialchars($_GET['error']) ?> <!-- shorthand syntax for php echo command to Display the error message -->
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