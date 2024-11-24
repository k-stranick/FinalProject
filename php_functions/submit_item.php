<?php

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../php_functions/productController.php';

// Initialize the ProductController
$productController = new ProductController($db_conn);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    // Retrieve form fields
    $itemTitle = $_POST['itemTitle'];
    $itemDescription = $_POST['description'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $itemPrice = $_POST['price'];
    $condition = $_POST['condition'];

    // Handle image upload
    $imagePaths = $productController->uploadImages($_FILES['image']);

    // Add product via ProductController
    $result = $productController->addProducts($itemTitle, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths, $user_id);

    if ($result === "Product added successfully.") {
        $_SESSION['message'] = $result;
        $_SESSION['error'] = false;
    } else {
        $_SESSION['message'] = $result;
        $_SESSION['error'] = true;
    }

    // Redirect back to the form
    header("Location: ../pages/products.php");
    exit();
}
?>