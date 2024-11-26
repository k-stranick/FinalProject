<?php

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 * ***************************
 * 
 * User Registration Page Script
 *
 * This script handles the registration page for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Form Display**: Displays a registration form for users to enter their details.
 * 2. **Feedback Messages**: Displays success or error messages based on user actions.
 *
 * **Dependencies**:
 * - `mysqli_conn.php`: Provides the database connection.
 * - `FormHandler.php`: Provides helper functions for form data sanitization and validation.
 * - `UserController.php`: Contains methods for handling user-related database operations.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `footer.php`: Contains the HTML footer.
 *
 * **Page Structure**:
 * - **Header and Navigation Bar**: Includes the header and navigation bar for consistent layout across the site.
 * - **Feedback Messages**: Displays success or error messages based on user actions.
 * - **Registration Form**: Displays a form for users to enter their registration details.
 * - **Footer**: Includes the footer for consistent layout across the site.
 */

// Include the necessary files
require_once '../database/mysqli_conn.php';
require_once '../formlogic/FormHandler.php';
require_once '../users/UserController.php';
require_once '../users/processUserRegistration.php';

$title = 'Register New User';
include '../partials/header.php'; // Include the header
include '../partials/navBar.php'; // Include the navigation bar

// Set message and error variables from session
$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? false;
$form_data = $_SESSION['form_data'] ?? []; // Retrieve form data from session
unset($_SESSION['message'], $_SESSION['error'], $_SESSION['form_data']); // Unset the session variables after use
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

                    <!-- Registration Form -->
                    <?php
                    $action = '../users/processUserRegistration.php';
                    $first_name = $form_data['first_name'] ?? '';
                    $last_name = $form_data['last_name'] ?? '';
                    $email = $form_data['email'] ?? '';
                    $username = $form_data['username'] ?? '';
                    $password_placeholder = 'Enter password';
                    $confirm_password_placeholder = 'Confirm password';
                    $button_text = 'Register';
                    $require_password = true; // Password fields are required
                    include '../partials/userForm.php'; // Include the user form
                    ?>
                </div>
            </div>
        </div>
    </main>

    <?php include '../partials/footer.php'; // Include the footer 
    ?>
</body>

</html>