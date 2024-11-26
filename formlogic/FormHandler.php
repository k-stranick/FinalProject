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
 * This class provides utility methods for handling form data on the Second Hand Herold website. 
 * The class includes functionalities for sanitizing inputs, extracting and validating form data, 
 * and handling file uploads.
 * 
 * Key Features:
 * - **Sanitization**: Ensures data integrity by sanitizing user inputs.
 * - **Data Extraction**: Extracts and prepares product and user data for processing.
 * - **Validation**: Provides rules to validate data integrity for products and users.
 * - **File Uploads**: Manages file uploads, ensuring secure handling of image files.
 * 
 * **Methods**:
 * - `sanitizeInput($input)`: Sanitizes a string input to prevent XSS attacks.
 * - `sanitizePrice($price)`: Validates and sanitizes a price input to ensure it's a valid float.
 * - `getProductData($post, $user_id)`: Extracts and sanitizes product data from form submissions.
 * - `getUserData($post)`: Extracts and sanitizes account settings or registration data.
 * - `validateProductData($data)`: Validates the integrity of product data fields.
 * - `validateUserData($data, $isRegistration)`: Validates user data, including optional password checks.
 * - `handleFileUploads($files, $uploadDir)`: Handles the upload of image files and returns file paths.
 */

class FormHandler
{
    /**
     * Sanitizes a string input to prevent malicious code injection.
     *
     * @param string $input The raw input string.
     * @return string Sanitized string.
     */
    public static function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    /**
     * Validates and sanitizes a price input.
     *
     * Ensures the price is a positive float value. If a negative value is provided, it defaults to 0.
     *
     * @param mixed $price The raw price input.
     * @return float Sanitized price.
     */
    public static function sanitizePrice($price)
    {
        return floatval($price >= 0 ? $price : 0);
    }

    /**
     * Extracts and sanitizes product data from form submissions.
     *
     * This method is designed to process product-related data submitted via forms, ensuring
     * that all inputs are sanitized and valid before further processing.
     *
     * @param array $post The form data from $_POST.
     * @param int|null $user_id The ID of the user submitting the product (optional).
     * @return array An associative array containing sanitized product data.
     */
    public static function getProductData(array $post, $user_id)
    {
        return [
            'item_name' => self::sanitizeInput($post['itemTitle'] ?? ''),
            'price' => self::sanitizePrice($post['price'] ?? 0),
            'city' => self::sanitizeInput($post['city'] ?? ''),
            'state' => self::sanitizeInput($post['state'] ?? ''),
            'condition' => self::sanitizeInput($post['condition'] ?? ''),
            'description' => self::sanitizeInput($post['description'] ?? ''),
            'product_id' => $post['product_id'] ?? null, // For edit operations.
            'user_id' => $user_id // User ID for logged-in users.
        ];
    }

    /**
     * Extracts and sanitizes account settings or registration data.
     *
     * This method is used to process data related to user account settings or registration.
     *
     * @param array $post The form data from $_POST.
     * @return array An associative array containing sanitized user data.
     */
    public static function getUserData(array $post)
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
     * Validates product data for completeness and integrity.
     *
     * This method checks if all required fields for a product submission are filled
     * and meet the expected criteria.
     *
     * @param array $data The product data to validate.
     * @return array An associative array with `success` (bool) and `errors` (array).
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
     * Validates user data for account settings or registration.
     *
     * This method checks if all required fields for user data are filled,
     * validates the email format, and ensures password fields match (if required).
     *
     * @param array $data The user data to validate.
     * @param bool $isRegistration Indicates if the validation is for a registration process.
     * @return array An associative array with `success` (bool) and `errors` (array).
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

        // Additional check for registration: password is required.
        if ($isRegistration && empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Handles file uploads and returns a comma-separated list of uploaded file paths.
     *
     * This method processes the uploaded files, saves them to the specified directory,
     * and returns their file paths.
     *
     * @param array $files The uploaded files from $_FILES.
     * @param string $uploadDir The directory to upload files to.
     * @return string Comma-separated list of uploaded file paths.
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

?>