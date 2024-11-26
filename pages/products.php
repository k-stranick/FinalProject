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
 * Products Page Script
 *
 * This script handles the display of products for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Authentication Check**: Ensures the user is authenticated before accessing the page.
 * 2. **Product Retrieval**: Fetches products from the database.
 * 3. **Product Display**: Renders individual product cards for each product.
 * 4. **Submission Form Section**: Includes a form for users to submit new products.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing the page.
 * - `mysqli_conn.php`: Provides the database connection.
 * - `productController.php`: Contains methods for handling product-related database operations.
 * - `productCard.php`: Contains the function to render individual product cards.
 * - `sellForm.php`: Contains the form for users to submit new products.
 *
 * **Page Structure**:
 * - **Header and Navigation Bar**: Includes the header and navigation bar for consistent layout across the site.
 * - **Product Display**: Displays a list of products fetched from the database.
 * - **Submission Form Section**: Includes a form for users to submit new products.
 * - **Footer**: Includes the footer for consistent layout across the site.
 */

// Include necessary files
require_once '../sessionmgmt/checkAuth.php'; // Ensure the user is authenticated
require_once '../database/mysqli_conn.php'; // Database connection
require_once '../products/productController.php'; // Database controller
require_once '../products/productCard.php'; // Renders individual product cards

// Initialize ProductController
$productController = new ProductController($db_conn);

// Query to fetch products from the database
$products = $productController->fetchAllProducts();

// Page settings
$title = "Listings";
$stylesheets = ['../css/products.css'];
include '../partials/header.php'; // Include the header
include '../partials/navbar.php'; // Include the navigation bar
?>

<body class="global-body">
    <main class="content flex-grow-1">

        <!-- Displays Products from database -->
        <div class="container mt-5">
            <h1 class="text-center mb-4">Browse What Everyone Has To Offer!</h1>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <?php renderProductCard($product); // Render individual product card 
                        ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No products available at this time.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submission Form Section -->
        <?php include '../partials/sellForm.php'; // Include the form for users to submit new products 
        ?>
    </main>

    <?php include '../partials/footer.php'; // Include the footer 
    ?>
</body>

</html>