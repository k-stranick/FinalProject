<?php

class FormHandler
{
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
     * Validate product data.
     *
     * @param array $data Product data to validate
     * @return array Validation result (success and error messages)
     */
    public static function validateProductData(array $data)
    {
        $errors = [];

        if (empty($data['item_name'])) {
            $errors[] = "Item name is required.";
        }
        if ($data['price'] <= 0) {
            $errors[] = "Price must be greater than zero.";
        }
        if (empty($data['city'])) {
            $errors[] = "City is required.";
        }
        if (empty($data['state'])) {
            $errors[] = "State is required.";
        }
        if (empty($data['condition'])) {
            $errors[] = "Condition is required.";
        }
        if (empty($data['description'])) {
            $errors[] = "Description is required.";
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
