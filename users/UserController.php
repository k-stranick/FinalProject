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
 * User Controller
 *
 * This class handles user-related database operations for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Fetch User by ID**: Retrieves user details based on the user ID.
 * 2. **Update User**: Updates user details in the database.
 * 3. **Register User**: Registers a new user in the database.
 *
 * **Methods**:
 * - `fetchUserById($user_id)`: Retrieves user details based on the user ID.
 * - `updateUser($user_id, $username, $email, $password, $first_name, $last_name)`: Updates user details in the database.
 * - `registerUser($username, $email, $password, $first_name, $last_name)`: Registers a new user in the database.
 */

class UserController
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    /**
     * Fetch a user by their ID
     * 
     * This function retrieves the details of a user from the database based on the provided user ID.
     * 
     * @param int $user_id User ID
     * @return array|null User details as an associative array or null if not found
     */
    public function fetchUserById($user_id)
    {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Error preparing statement");
        }

        $stmt->bind_param("i", $user_id); // Bind the user ID as an integer parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $this->handleError("Error fetching user");
        }

        return $result->fetch_assoc();
    }

    /**
     * Update user details
     * 
     * This function updates the details of an existing user in the database with the provided information.
     * 
     * @param int $user_id User ID
     * @param string $username Username
     * @param string $email Email
     * @param string|null $password Password (optional)
     * @param string|null $first_name First name (optional)
     * @param string|null $last_name Last name (optional)
     * @return bool True on success, false on failure
     */
    public function updateUser($user_id, $username, $email, $password = null, $first_name = null, $last_name = null)
    {
        if ($password) {
            // If password is provided, hash it and include it in the update query
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username = ?, email = ?, password_hash = ?, first_name = ?, last_name = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssssi", $username, $email, $password_hash, $first_name, $last_name, $user_id);
        } else {
            // If password is not provided, exclude it from the update query
            $query = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssi", $username, $email, $first_name, $last_name, $user_id);
        }

        if (!$stmt) {
            $this->handleError("Error preparing statement: ");
        }

        return $stmt->execute();
    }

    /**
     * Register a new user
     * 
     * This function inserts a new user into the database with the provided details.
     * 
     * @param string $username Username
     * @param string $email Email
     * @param string $password Password
     * @param string $first_name First name
     * @param string $last_name Last name
     * @return bool True on success, false on failure
     */
    public function registerUser($username, $email, $password, $first_name, $last_name)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password using the default algorithm
        $query = "INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Error preparing statement");
        }

        $stmt->bind_param("sssss", $username, $email, $password_hash, $first_name, $last_name); // Bind the parameters to the SQL query
        return $stmt->execute();
    }

    /**
     * Handle errors by throwing an exception
     * 
     * @param string $message Error message
     * @throws Exception
     */
    private function handleError($message)
    {
        throw new Exception($message . ": " . $this->db->error);
    }
}
?>