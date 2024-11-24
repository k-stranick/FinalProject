<?php

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php'; // Database connection
require_once '../php_functions/productController.php'; // Database controller
require_once '../php_functions/productCard.php'; // Renders individual product cards

// Initialize ProductController
$productController = new ProductController($db_conn);

// Query to fetch products from the database
//$products = $productController->fetchProducts();
$products = $productController->fetchAllProducts();

// Page settings
$title = "Products";
$stylesheets = ['../css/products.css'];
include '../partials/header.php';
include '../partials/navbar.php';
?>

<body class="global-body">
    <main class="content flex-grow-1">

        <!-- Displays Products from database -->
        <div class="container mt-5">
            <h1 class="text-center mb-4">Browse What Everyone Has To Offer!</h1>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <?php renderProductCard($product); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No products available at this time.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submission Form Section -->
        <?php include '../partials/sellForm.php'; ?>
    </main>

    <?php include '../partials/footer.php' ?>
</body>

</html>