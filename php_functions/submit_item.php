<?php

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../php_functions/productController.php';
require_once '../php_functions/FormHandler.php';

// Initialize the ProductController
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
            $_SESSION['message'] = $result;
            $_SESSION['error'] = false;
        } else {
            $_SESSION['message'] = $result;
            $_SESSION['error'] = true;
        }
    }

    // Redirect back to the form
    header("Location: ../pages/products.php");
    exit();
}
?>