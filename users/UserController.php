<?php
class UserController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchUserById($user_id)
    {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Error preparing statement");
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $this->handleError("Error fetching user");
        }

        return $result->fetch_assoc();
    }

    public function updateUser($user_id, $username, $email, $password = null, $first_name = null, $last_name = null)
    {
        if ($password) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users SET username = ?, email = ?, password_hash = ?, first_name = ?, last_name = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssssi", $username, $email, $password_hash, $first_name, $last_name, $user_id);
        } else {
            $query = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssssi", $username, $email, $first_name, $last_name, $user_id);
        }

        if (!$stmt) {
            $this->handleError("Error preparing statement: ");
        }

        return $stmt->execute();
    }

    public function registerUser($username, $email, $password, $first_name, $last_name)
    {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", $username, $email, $password_hash, $first_name, $last_name);

        if (!$stmt) {
            $this->handleError("Error preparing statement: ");
        }

        return $stmt->execute();
    }

    private function handleError($message)
    {
        throw new Exception($message . ": " . $this->db->error);
    }
}
