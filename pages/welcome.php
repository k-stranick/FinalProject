<?php
session_start();

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Assignment 11: Sessions
 * Due: 11/22/2024
 * ***************************
 * 
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
 * **Dependencies**:
 * - `mysqli_conn.php`: Provides the database connection.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `footer.php`: Contains the HTML footer.
 * 
 * **Page Structure**:
 * - **Header and Navigation Bar**: Includes the header and navigation bar for consistent layout across the site.
 * - **User Information**: Displays user information stored in session variables.
 * - **Logout Feature**: Provides a button to return to the login page.
 * - **Footer**: Includes the footer for consistent layout across the site.
 */

require_once '../database/mysqli_conn.php'; // Include the database connection

$title = 'Welcome';
$stylesheets = ['../css/welcome.css'];
include '../partials/header.php'; // Include the header
include '../partials/navBar.php'; // Include the navigation bar

// Check if session data exists
if (isset($_SESSION['first_name'])):
    $message = $_SESSION['message'] ?? '';
    $error = $_SESSION['error'] ?? false;
    unset($_SESSION['message'], $_SESSION['error']);
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="profile-icon">
                <?php
                // Show the first letter of the user's first name
                echo strtoupper(substr($_SESSION['first_name'] ?? 'A', 0, 1));
                ?>
            </div>
            <h3>Registration Complete</h3>
            <p>Welcome to the site! You have successfully registered. Your details are displayed below.</p>

            <!-- User details -->
            <h1>Welcome, <?= htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']); ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']); ?></p>

            <!-- Return to Login Button -->
            <form method="POST" action="login.php" class="mt-4">
                <button type="submit" name="login" class="btn btn-danger w-50">Return to Login</button>
            </form>
        </div>
    </main>
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

<?php include '../partials/footer.php'; // Include the footer ?>
</html>