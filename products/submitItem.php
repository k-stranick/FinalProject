<?php

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Assignment 10: Display Database Data
 * Due: 11/8/2024
 * ***************************
 * 
 * Product Submission Script
 *
 * This script handles the submission of a new product for sale on the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Authentication Check**: Ensures the user is authenticated before allowing product submission.
 * 2. **Form Handling**: Retrieves and sanitizes form data, handles image uploads, and validates product data.
 * 3. **Product Addition**: Adds the new product to the database.
 * 4. **Feedback Messages**: Provides success or error messages based on the submission result.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing this script.
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 * - `productController.php`: Contains methods for handling product-related database operations.
 * - `FormHandler.php`: Provides helper functions for form data sanitization, validation, and file uploads.
 *
 * **Process Flow**:
 * - Checks if the form was submitted via POST request.
 * - Retrieves and sanitizes form data using `FormHandler`.
 * - Handles image uploads and validates product data.
 * - Attempts to add the product using the `ProductController`.
 * - Sets a success or error message based on the result.
 * - Redirects the user back to the products page with the feedback message.
 */

// Include necessary files and initialize the ProductController
require_once '../sessionmgmt/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../products/productController.php';
require_once '../formlogic/FormHandler.php';

$productController = new ProductController($db_conn);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    // Retrieve and sanitize form fields
    $productData = FormHandler::getProductData($_POST, $user_id);

    // Handle image upload
    $imagePaths = FormHandler::handleFileUploads($_FILES['image']);

    // Validate product data
    $validationResult = FormHandler::validateProductData($productData);
    if (!$validationResult['success']) {
        // Set error message if validation fails
        $_SESSION['message'] = implode('<br>', $validationResult['errors']);
        $_SESSION['error'] = true;
    } else {
        // Add product via ProductController
        $result = $productController->addProducts(
            $productData['item_name'],
            $productData['price'],
            $productData['city'],
            $productData['state'],
            $productData['condition'],
            $productData['description'],
            $imagePaths,
            $user_id
        );

        if ($result === "Product added successfully.") {
            // Set success message if product is added successfully
            $_SESSION['message'] = $result;
            $_SESSION['error'] = false;
        } else {
            // Set error message if product addition fails
            $_SESSION['message'] = $result;
            $_SESSION['error'] = true;
        }
    }

    // Redirect back to the products page with the feedback message
    header("Location: ../pages/products.php");
    exit();
}
?>