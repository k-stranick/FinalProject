<?php

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 *
 * This script handles the account settings page where users can update their account information.
 * It includes the following functionalities:
 * - Fetching current user data from the database.
 * - Displaying a form pre-filled with the user's current information.
 * - Handling form submission to update user information.
 * - Displaying success or error messages based on the update result.
 *
 * The script uses the UserController class to interact with the database.
 * It also includes the header and navigation bar for consistent layout across the site.
 *
 * Dependencies:
 * - checkAuth.php: Ensures the user is authenticated.
 * - mysqli_conn.php: Provides the database connection.
 * - UserController.php: Contains methods for fetching and updating user data.
 * - header.php: Contains the HTML header and includes necessary CSS and JS files.
 * - navBar.php: Contains the navigation bar.
 * - footer.php: Contains the HTML footer.
 */

// Include necessary files and initialize the UserController
require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../php_functions/UserController.php';

$title = 'Account Settings';
include '../partials/header.php';
include '../partials/navBar.php';

// Initialize the UserController
$userController = new UserController($db_conn);

// Fetch current user data
$user_id = $_SESSION['user_id'];
$user = $userController->fetchUserById($user_id);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']); // Confirm password field

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {
        try {
            // Update user information
            $updated = $userController->updateUser($user_id, $username, $email, $password, $first_name, $last_name);

            if ($updated) {
                // Update the username in the session
                $_SESSION['username'] = $username;

                $_SESSION['message'] = "Account updated successfully.";
                header('Location: accountSettings.php');
                exit;
            } else {
                $_SESSION['error'] = "Failed to update account. Please try again.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
}
?>

<body class="global-body">
    <main class="content flex-grow-1">

        <div class="container mt-5">
            <h1>Account Settings</h1>

            <!-- Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['message'];
                    unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Account Settings Form -->
            <form action="accountSettings.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Account</button>
                </div>
            </form>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>