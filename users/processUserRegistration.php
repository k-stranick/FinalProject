<?php
session_start(); // Start the session

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
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
    $registrationData = FormHandler::getAccountSettingsData($_POST);

    // Validate registration data
    $validationResult = FormHandler::validateUserData($registrationData, true);
    if (!$validationResult['success']) {
        $_SESSION['error_message'] = implode('<br>', $validationResult['errors']);
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
            $_SESSION['success_message'] = "Registration successful. Welcome!";
            header('Location: ../pages/welcome.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Failed to register. Please try again.";
            header('Location: ../pages/register.php');
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: ../pages/register.php');
        exit;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleRegistration($userController);
}
