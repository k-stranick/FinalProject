<?php
session_start();
require_once '../database/mysqli_conn.php';

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

/**
 * Validates the provided email address.
 *
 * @param string $email Email address to validate.
 * @return bool True if the email is valid, false otherwise.
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Checks if the passwords match.
 *
 * @param string $password The main password.
 * @param string $confirmPassword The confirmation password.
 * @return bool True if passwords match, false otherwise.
 */
function passwordsMatch($password, $confirmPassword)
{
    return $password === $confirmPassword;
}

/**
 * Checks if the username or email already exists in the database.
 *
 * @param mysqli $db_conn Database connection object.
 * @param string $user_name Username to check.
 * @param string $email Email to check.
 * @return bool True if username or email exists, false otherwise.
 */
function userExists($db_conn, $user_name, $email)
{
    $stmt = $db_conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user_name, $email);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Inserts a new user into the database.
 *
 * @param mysqli $db_conn Database connection object.
 * @param string $first_name First name of the user.
 * @param string $last_name Last name of the user.
 * @param string $email Email of the user.
 * @param string $user_name Username of the user.
 * @param string $password_hash Hashed password.
 * @return bool True if insertion was successful, false otherwise.
 */
function insertUser($db_conn, $first_name, $last_name, $email, $user_name, $password_hash)
{
    $stmt = $db_conn->prepare("INSERT INTO users (first_name, last_name, email, username, password_hash) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $user_name, $password_hash);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

/**
 * Redirects the user with an error message.
 *
 * @param string $message Error message to display.
 * @param string $redirectUrl The URL to redirect to.
 */
function redirectWithError($message, $redirectUrl)
{
    $_SESSION['error_message'] = $message;
    header("Location: $redirectUrl");
    exit();
}

// Handle the registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and capture form data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $user_name = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password_hash']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate email
    if (!isValidEmail($email)) {
        redirectWithError("Invalid email format.", "../pages/register.php");
    }

    // Check if passwords match
    if (!passwordsMatch($password, $confirm_password)) {
        redirectWithError("Passwords do not match.", "../pages/register.php");
    }

    // Check if the username or email already exists
    if (userExists($db_conn, $user_name, $email)) {
        redirectWithError("Username or email already exists.", "../pages/register.php");
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    if (insertUser($db_conn, $first_name, $last_name, $email, $user_name, $password_hash)) {
        // Store user data in session and redirect to the welcome page
        $_SESSION['user_first_name'] = $first_name;
        $_SESSION['user_last_name'] = $last_name;
        $_SESSION['user_email'] = $email;
        $_SESSION['username'] = $user_name;
        $_SESSION['success_message'] = "Registration successful! Welcome!";
        header("Location: ../pages/welcome.php");
        exit();
    } else {
        redirectWithError("Registration failed. Please try again.", "../pages/register.php");
    }
}
