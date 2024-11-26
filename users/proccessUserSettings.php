<?php
session_start(); // Start the session

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 * ***************************
 * 
 * User Account Settings Processing Script
 *
 * This script handles the processing of user account settings changes for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Session Start**: Starts the session to manage user session data.
 * 2. **Form Handling**: Retrieves and sanitizes form data, validates account settings data.
 * 3. **User Update**: Updates the user information in the database.
 * 4. **Feedback Messages**: Provides success or error messages based on the update result.
 *
 * **Dependencies**:
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 * - `FormHandler.php`: Provides helper functions for form data sanitization and validation.
 * - `UserController.php`: Contains methods for handling user-related database operations.
 *
 * **Process Flow**:
 * - Starts the session.
 * - Includes necessary files and initializes the `UserController`.
 * - Checks if the form was submitted via POST request.
 * - Retrieves and sanitizes form data using `FormHandler`.
 * - Validates account settings data.
 * - Attempts to update the user information using the `UserController`.
 * - Sets a success or error message based on the result.
 * - Redirects the user to the appropriate page with the feedback message.
 */

// Include the necessary files
require_once '../database/mysqli_conn.php';
require_once '../formlogic/FormHandler.php';
require_once '../users/UserController.php';

// Initialize the UserController
$userController = new UserController($db_conn);

// Fetch current user data
$user_id = $_SESSION['user_id'];

// Function to handle form submission
function handleFormSubmission($userController, $user_id)
{
    $accountData = FormHandler::getUserData($_POST);

    // Validate account settings data
    $validationResult = FormHandler::validateUserData($accountData);
    if (!$validationResult['success']) {
        $_SESSION['error'] = implode('<br>', $validationResult['errors']);
        header('Location: ../pages/accountSettings.php');
        exit;
    }

    // Check if passwords match
    if (!empty($accountData['password']) && $accountData['password'] !== $accountData['confirm_password']) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../pages/accountSettings.php');
        exit;
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
            $_SESSION['first_name'] = $accountData['first_name'];
            $_SESSION['last_name'] = $accountData['last_name'];
            $_SESSION['email'] = $accountData['email'];
            $_SESSION['message'] = "Account updated successfully.";
            header('Location: ../pages/accountSettings.php');
            exit;
        } else {
            $_SESSION['error'] = "Failed to update account. Please try again.";
            header('Location: ../pages/accountSettings.php');
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: ../pages/accountSettings.php');
        exit;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleFormSubmission($userController, $user_id);
}
?>