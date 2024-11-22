<?php
session_start();
// Include the database connection
require_once '../database/mysqli_conn.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}      

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

/**
 * Welcome Page with User Session Management
 * 
 * This script displays a welcome page for registered users by retrieving session data. 
 * It provides a logout feature to clear session data and redirects to the registration page 
 * if no session data exists.
 * 
 * Features:
 * - Displays user information stored in session variables.
 * - Handles user logout, clearing the session and redirecting to the registration page.
 * - Shows a success message upon successful registration, if available.
 * - Prompts unregistered users to register if session data is missing.
 * 
 * Dependencies:
 * - Requires `header.php` and `navBar.php` for the page layout.
 * - Includes `footer.php` for the page footer.
 * 
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Assignment 11: Sessions
 * Due: 11/22/2024
 */

$title = 'Welcome';
$stylesheets = ['../css/welcome.css'];
include '../partials/header.php';
include '../partials/navBar.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: register.php"); // Redirect to registration page or login page
    exit();
}

// Check if session data exists
if (isset($_SESSION['user_first_name'])):
?>

    <body class="global-body">
        <main class="content flex-grow-1">
            <div class="container mt-5">
                <!-- Display success message if set -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success_message']; ?>
                    </div>
                    <?php unset($_SESSION['success_message']); // Clear the success message after displaying it 
                    ?>
                <?php endif; ?>

                <!-- Registration complete message -->
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <h3 class="mb-3">Registration Complete</h3>
                        <p>Welcome to the site! You have successfully registered. Your details are displayed below.</p>
                    </div>
                </div>

                <!-- User details -->
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <h1>Welcome, <?= $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']; ?>!</h1>
                        <p><strong>Email:</strong> <?= $_SESSION['user_email']; ?></p>
                        <p><strong>Username:</strong> <?= $_SESSION['username']; ?></p>

                        <!-- Login Button-->
                        <form method="POST" action="login.php" class="mt-4">
                            <button type="submit" name="logout" class="btn btn-danger w-50">Return to Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <div>
            <?php include '../partials/footer.php'; ?>
        </div>
    </body>

<?php else: ?>

    <body class="global-body">
        <main class="content flex-grow-1">
            <div class="container mt-5 text-center">
                <h3>User data not found. Please register first.</h3>
            </div>
        </main>
    </body>
<?php endif; ?>

</html>