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
 * Logout Script
 *
 * This script handles the user logout process for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Session Start**: Starts the session to access session variables.
 * 2. **Session Unset**: Unsets all session variables to clear the session data.
 * 3. **Session Destroy**: Destroys the session to log the user out.
 * 4. **Redirection**: Redirects the user to the login page after logging out.
 *
 * **Process Flow**:
 * - Starts the session.
 * - Unsets all session variables.
 * - Destroys the session.
 * - Redirects the user to the login page.
 */

// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../pages/login.php");
exit();
?>