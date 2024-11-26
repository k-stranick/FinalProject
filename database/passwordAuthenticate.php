<?php
session_start(); // Start the session

require_once '../database/mysqli_conn.php';

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 * ***************************
 * 
 * User Authentication Script
 *
 * This script handles user authentication for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Account Lockout Check**: Checks if the user account is locked due to failed login attempts.
 * 2. **Failed Attempts Reset**: Resets the failed login attempts and last failed attempt timestamp for a user.
 * 3. **Failed Attempts Increment**: Increments the failed login attempts for a user and updates the last failed attempt timestamp.
 * 4. **Redirection with Error**: Redirects the user to the login page with an error message.
 * 5. **User Authentication**: Authenticates the user by verifying the username and password.
 *
 * **Dependencies**:
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 *
 * **Process Flow**:
 * - Starts the session.
 * - Includes the necessary files and initializes the database connection.
 * - Defines helper functions for account lockout check, failed attempts reset, failed attempts increment, and redirection with error.
 * - Handles the login form submission.
 * - Retrieves and sanitizes user input from the login form.
 * - Queries the database to retrieve user data.
 * - Checks if the account is locked.
 * - Verifies the entered password against the stored hash.
 * - Resets failed attempts on successful login.
 * - Increments failed attempts on failed login.
 * - Redirects the user with appropriate feedback messages.
 */

/**
 * Checks if the user account is locked due to failed login attempts.
 *
 * @param int $failedAttempts Number of failed login attempts.
 * @param string $lastFailedAttempt Timestamp of the last failed login attempt.
 * @param int $lockoutDuration Lockout duration in seconds (default: 900 seconds or 15 minutes).
 * @return bool True if the account is locked, false otherwise.
 */
function checkLockout($failedAttempts, $lastFailedAttempt, $lockoutDuration = 900)
{
    return $failedAttempts >= 3 && time() - strtotime($lastFailedAttempt) < $lockoutDuration;
}

/**
 * Resets the failed login attempts and last failed attempt timestamp for a user.
 *
 * @param mysqli $db_conn Database connection object.
 * @param int $userId ID of the user whose attempts need to be reset.
 */
function resetFailedAttempts($db_conn, $userId)
{
    $stmt = $db_conn->prepare("UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}

/**
 * Increments the failed login attempts for a user and updates the last failed attempt timestamp.
 *
 * @param mysqli $db_conn Database connection object.
 * @param int $userId ID of the user whose attempts need to be incremented.
 */
function incrementFailedAttempts($db_conn, $userId)
{
    $stmt = $db_conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_attempt = NOW() WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}

/**
 * Redirects the user to the login page with an error message.
 *
 * @param string $message Error message to display on the login page.
 */
function redirectWithError($message)
{
    header("Location: ../pages/login.php?error=" . urlencode($message));
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to retrieve user data
    $stmt = $db_conn->prepare("SELECT user_id, password_hash, failed_attempts, last_failed_attempt FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, fetch their data
        $user = $result->fetch_assoc();
        $userId = $user['user_id'];
        $hash = $user['password_hash'];
        $failedAttempts = $user['failed_attempts'];
        $lastFailedAttempt = $user['last_failed_attempt'];

        // Check if the account is locked
        if (checkLockout($failedAttempts, $lastFailedAttempt)) {
            redirectWithError("Account locked. Try again later.");
        }

        // Verify the entered password against the stored hash
        if (password_verify($password, $hash)) {
            // Successful login: reset failed attempts and start a session
            resetFailedAttempts($db_conn, $userId);
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            header("Location: ../pages/index.php");
            exit();
        } else {
            // Failed login: increment failed attempts
            incrementFailedAttempts($db_conn, $userId);
            $failedAttempts++;
            if ($failedAttempts >= 3) {
                redirectWithError("Account locked. Try again later.");
            } else {
                redirectWithError("Invalid username or password.");
            }
        }
    } else {
        // Username not found in the database
        redirectWithError("Invalid username or password.");
    }
}
?>