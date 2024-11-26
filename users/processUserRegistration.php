<?php
session_start(); // Start the session

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 * ***************************
 * 
 * User Registration Processing Script
 *
 * This script handles the processing of user registration for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Session Start**: Starts the session to manage user session data.
 * 2. **Form Handling**: Retrieves and sanitizes form data, validates registration data.
 * 3. **User Registration**: Registers the new user in the database.
 * 4. **Feedback Messages**: Provides success or error messages based on the registration result.
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
 * - Validates registration data.
 * - Attempts to register the user using the `UserController`.
 * - Sets a success or error message based on the result.
 * - Redirects the user to the appropriate page with the feedback message.
 */

// Include the necessary files
require_once '../database/mysqli_conn.php';
require_once '../formlogic/FormHandler.php';
require_once '../users/UserController.php';

// Initialize the UserController
$userController = new UserController($db_conn);

// Function to handle form submission
function handleRegistration($userController)
{
    // Retrieve and sanitize form data
    $registrationData = FormHandler::getUserData($_POST);

    // Validate registration data
    $validationResult = FormHandler::validateUserData($registrationData, true);
    if (!$validationResult['success']) {
        // Set error message if validation fails
        $_SESSION['error'] = implode('<br>', $validationResult['errors']);
        $_SESSION['form_data'] = $registrationData; // Save form data in session
        header('Location: ../pages/register.php');
        exit;
    }

    // Check if passwords match
    if (!empty($registrationData['password']) && $registrationData['password'] !== $registrationData['confirm_password']) {
        $_SESSION['error'] = 'Passwords do not match.';
        $_SESSION['form_data'] = $registrationData; // Save form data in session
        header('Location: ../pages/register.php');
        exit;
    }

    try {
        // Register new user
        $registered = $userController->registerUser(
            $registrationData['username'],
            $registrationData['email'],
            $registrationData['password'],
            $registrationData['first_name'],
            $registrationData['last_name']
        );

        if ($registered) {
            // Set user data in session
            foreach ($registrationData as $key => $value) {
                $_SESSION[$key] = $value;
            }
            // Set success message
            $_SESSION['message'] = "Registration successful. Welcome!";
            $_SESSION['error'] = false;
            unset($_SESSION['form_data']); // Clear form data from session
            header('Location: ../pages/register.php');
            exit;
        } else {
            // Set error message if registration fails
            $_SESSION['message'] = "Failed to register. Please try again.";
            $_SESSION['error'] = true;
            $_SESSION['form_data'] = $registrationData; // Save form data in session
            header('Location: ../pages/register.php');
            exit;
        }
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $_SESSION['error'] = 'The email address is already registered.';
        } else {
            $_SESSION['error'] = $e->getMessage();
        }
        $_SESSION['form_data'] = $registrationData; // Save form data in session
        header('Location: ../pages/register.php');
        exit;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleRegistration($userController);
}
