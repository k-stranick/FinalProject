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
 * - FormHandler.php: Contains methods for handling form data and file uploads.
 * - header.php: Contains the HTML header and includes necessary CSS and JS files.
 * - navBar.php: Contains the navigation bar.
 * - footer.php: Contains the HTML footer.
 */

// Include necessary files and initialize the UserController
require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../users/UserController.php';
require_once '../formlogic/FormHandler.php';

$title = 'Account Settings';
include '../partials/header.php';
include '../partials/navBar.php';

// Initialize the UserController
$userController = new UserController($db_conn);

// Fetch current user data
$user_id = $_SESSION['user_id'];
$user = $userController->fetchUserById($user_id);

// Function to handle form submission
function handleFormSubmission($userController, $user_id)
{
    $accountData = FormHandler::getAccountSettingsData($_POST);

    // Validate account settings data
    $validationResult = FormHandler::validateUserData($accountData);
    if (!$validationResult['success']) {
        $_SESSION['error'] = implode('<br>', $validationResult['errors']);
        return false;
    }

    // If password is empty, do not update it
    $password = !empty($accountData['password']) ? $accountData['password'] : null;

    try {
        // Update user information
        $updated = $userController->updateUser(
            $user_id,
            $accountData['username'],
            $accountData['email'],
            $password,
            $accountData['first_name'],
            $accountData['last_name']
        );

        if ($updated) {
            // Update the username in the session
            $_SESSION['username'] = $accountData['username'];

            $_SESSION['message'] = "Account updated successfully.";
            header('Location: accountSettings.php');
            exit;
        } else {
            $_SESSION['error'] = "Failed to update account. Please try again.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    return false;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleFormSubmission($userController, $user_id);
}

// Set message and error variables from session
$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? false;
unset($_SESSION['message'], $_SESSION['error']);

?>

<body class="global-body">
    <main class="content flex-grow-1">

        <div class="container mt-5">
            <h1>Account Settings</h1>

            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert <?= $error ? 'alert-danger' : 'alert-success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Account Settings Form -->
            <?php
            $action = 'accountSettings.php';
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
    </main>
    <?php include '../partials/footer.php'; ?>
</body>

</html>