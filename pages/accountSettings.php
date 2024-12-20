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
 * This script handles the account settings page where users can update their account information.
 * It includes the following functionalities:
 *
 * 1. **Fetching User Data**: Retrieves the current user's information from the database.
 * 2. **Form Handling**: Pre-fills an HTML form with the user's current information, allowing 
 *    users to update fields such as first name, last name, email, username, and password.
 * 3. **Validation and Updates**: Validates form inputs, processes the update via the 
 *    `UserController`, and provides feedback to the user through success/error messages.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing this page.
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 * - `UserController.php`: Contains methods for handling user-related database operations.
 * - `FormHandler.php`: Provides helper functions for form data sanitization and validation.
 * - `header.php`, `navBar.php`, and `footer.php`: Include reusable UI components for consistency across pages.
 *
 * **Key Methods**:
 * - `handleFormSubmission($userController, $user_id)`: Handles the form submission to update user details.
 *
 * **Page Structure**:
 * - **Messages**: Displays alerts to indicate success or error in updating the user information.
 * - **Account Settings Form**: Allows users to update their first name, last name, email, username, and password.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

// Include necessary files and initialize the UserController
require_once '../sessionmgmt/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../users/UserController.php';
//require_once '../users/proccessUserSettings.php';
require_once '../formlogic/FormHandler.php';

$title = 'Account Settings';
include '../partials/header.php';
include '../partials/navBar.php';

// Initialize the UserController
$userController = new UserController($db_conn);

// Fetch current user data
$user_id = $_SESSION['user_id'];
$user = $userController->fetchUserById($user_id);

// Set message and error variables from session
$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? false;
unset($_SESSION['message'], $_SESSION['error']); // Unset the session variables after use
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">

                    <!-- Messages -->
                    <?php if ($message || $error): ?>
                        <div class="alert <?= $error ? 'alert-danger' : 'alert-success'; ?>">
                            <?php echo $error ? $error : $message; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Account Settings Form -->
                    <?php
                    $action = '../users/proccessUserSettings.php';
                    $first_name = $user['first_name'] ?? '';
                    $last_name = $user['last_name'] ?? '';
                    $email = $user['email'] ?? '';
                    $username = $user['username'] ?? '';
                    $password_placeholder = 'Leave blank to keep current password';
                    $confirm_password_placeholder = 'Re-enter new password';
                    $button_text = 'Update Account';
                    $require_password = false; // Password fields are optional
                    include '../partials/userForm.php';
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>