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
 * Authentication Check Script
 *
 * This script ensures that the user is authenticated before allowing access to certain pages.
 * It includes the following functionalities:
 *
 * 1. **Session Start**: Starts the session to access session variables.
 * 2. **Authentication Check**: Checks if the user is authenticated by verifying the presence of `user_id` in the session.
 * 3. **Redirection**: Redirects unauthenticated users to the login page.
 *
 * **Process Flow**:
 * - Starts the session.
 * - Checks if `user_id` is set in the session.
 * - If `user_id` is not set, redirects the user to the login page.
 */

// Start the session
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not authenticated
    header('Location: login.php');
    exit();
}
?>