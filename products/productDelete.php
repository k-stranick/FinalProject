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
 * Product Deletion Script
 *
 * This script handles the deletion of a product from the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Authentication Check**: Ensures the user is authenticated before allowing product deletion.
 * 2. **Product Deletion**: Deletes the specified product from the database.
 * 3. **Feedback Messages**: Provides success or error messages based on the deletion result.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing this script.
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 * - `productController.php`: Contains methods for handling product-related database operations.
 *
 * **Process Flow**:
 * - Retrieves the `product_id` from the POST request.
 * - Attempts to delete the product using the `ProductController`.
 * - Sets a success or error message based on the result.
 * - Redirects the user back to the item table page with the feedback message.
 */

// Include necessary files and initialize the ProductController
require_once '../sessionmgmt/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../products/productController.php';

$productController = new ProductController($db_conn);

// Get the product_id from the POST request
$product_id = $_POST['product_id'] ?? null;

if ($product_id) {
    try {
        // Attempt to delete the product
        $message = $productController->deleteProduct($product_id);
        // Set success message
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => $message,
        ];
    } catch (Exception $e) {
        // Set error message if deletion fails
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => $e->getMessage(),
        ];
    }
} else {
    // Set error message if product_id is invalid
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Invalid product ID.',
    ];
}

// Redirect to the item table page with the feedback message
header('Location: ../pages/listingtable.php');
exit();