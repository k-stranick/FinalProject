<?php

class FormHandler
{

    /**
     * Sanitize a string input.
     *
     * @param string $input Raw input
     * @return string Sanitized input
     */
    public static function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    /**
     * Validate and sanitize price input.
     *
     * @param mixed $price Raw price input
     * @return float Sanitized and validated price
     */
    public static function sanitizePrice($price)
    {
        return floatval($price >= 0 ? $price : 0);
    }

    /**
     * Extract and sanitize product data from form submission.
     *
     * @param array $post $_POST data
     * @param int|null $user_id Optional user ID (for submissions)
     * @return array Sanitized product data
     */
    public static function getProductData(array $post, $user_id = null)
    {
        return [
            'item_name' => self::sanitizeInput($post['itemTitle'] ?? ''),
            'price' => self::sanitizePrice($post['price'] ?? 0),
            'city' => self::sanitizeInput($post['city'] ?? ''),
            'state' => self::sanitizeInput($post['state'] ?? ''),
            'condition' => self::sanitizeInput($post['condition'] ?? ''),
            'description' => self::sanitizeInput($post['description'] ?? ''),
            'product_id' => $post['product_id'] ?? null, // For edit operations
            'user_id' => $user_id // For submissions with logged-in users
        ];
    }

    /**
     * Extract and sanitize account settings data from form submission.
     *
     * @param array $post $_POST data
     * @return array Sanitized account settings data
     */
    public static function getAccountSettingsData(array $post)
    {
        return [
            'first_name' => self::sanitizeInput($post['first_name'] ?? ''),
            'last_name' => self::sanitizeInput($post['last_name'] ?? ''),
            'username' => self::sanitizeInput($post['username'] ?? ''),
            'email' => self::sanitizeInput($post['email'] ?? ''),
            'password' => self::sanitizeInput($post['password'] ?? ''),
            'confirm_password' => self::sanitizeInput($post['confirm_password'] ?? '')
        ];
    }

    /**
     * Validate product data.
     *
     * @param array $data Product data to validate
     * @return array Validation result (success and error messages)
     */
    public static function validateProductData(array $data)
    {
        $errors = [];

        $validationRules = [
            'item_name' => 'Item name is required.',
            'price' => 'Price must be greater than zero.',
            'city' => 'City is required.',
            'state' => 'State is required.',
            'condition' => 'Condition is required.',
            'description' => 'Description is required.'
        ];

        foreach ($validationRules as $field => $errorMessage) {
            if ($field === 'price') {
                if ($data[$field] <= 0) {
                    $errors[] = $errorMessage;
                }
            } else {
                if (empty($data[$field])) {
                    $errors[] = $errorMessage;
                }
            }
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }

 /**
     * Validate user data for account settings or registration.
     *
     * @param array $data User data to validate
     * @param bool $isRegistration Flag to indicate if it's a registration (password required)
     * @return array Validation result (success and error messages)
     */
    public static function validateUserData(array $data, bool $isRegistration = false)
    {
        $errors = [];

        $validationRules = [
            'first_name' => 'First name is required.',
            'last_name' => 'Last name is required.',
            'username' => 'Username is required.',
            'email' => 'Email is required.',
            'email_format' => 'Invalid email format.',
            'password_match' => 'Passwords do not match.'
        ];

        foreach ($validationRules as $rule => $errorMessage) {
            switch ($rule) {
                case 'email_format':
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = $errorMessage;
                    }
                    break;
                case 'password_match':
                    if (!empty($data['password']) && $data['password'] !== $data['confirm_password']) {
                        $errors[] = $errorMessage;
                    }
                    break;
                default:
                    if (empty($data[$rule])) {
                        $errors[] = $errorMessage;
                    }
                    break;
            }
        }

        // Additional check for registration: password is required
        if ($isRegistration && empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Handle file uploads and return comma-separated file paths.
     *
     * @param array $files $_FILES data
     * @param string $uploadDir Upload directory
     * @return string Comma-separated list of uploaded file paths
     */
    public static function handleFileUploads(array $files, $uploadDir = '../media/')
    {
        $imagePaths = [];

        foreach ($files['name'] as $key => $name) {
            $tmpName = $files['tmp_name'][$key];
            $filePath = $uploadDir . basename($name);

            if (move_uploaded_file($tmpName, $filePath)) {
                $imagePaths[] = $filePath;
            }
        }

        return implode(',', $imagePaths);
    }
}
