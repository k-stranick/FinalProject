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
 * Sell Page Script
 *
 * This script handles the sell page for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Authentication Check**: Ensures the user is authenticated before accessing the page.
 * 2. **Sell Form Display**: Includes the form for users to submit new products for sale.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing the page.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `sellForm.php`: Contains the form for users to submit new products.
 * - `footer.php`: Contains the HTML footer.
 *
 * **Page Structure**:
 * - **Header and Navigation Bar**: Includes the header and navigation bar for consistent layout across the site.
 * - **Sell Form**: Displays the form for users to submit new products for sale.
 * - **Footer**: Includes the footer for consistent layout across the site.
 */

// Include necessary files
require_once '../sessionmgmt/checkAuth.php'; // Ensure the user is authenticated
$title = 'Post a Listing';
include '../partials/header.php'; // Include the header
include '../partials/navBar.php'; // Include the navigation bar
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <?php include '../partials/sellForm.php'; // Include the form for users to submit new products ?>
    </main>
    <div>
        <?php include '../partials/footer.php'; // Include the footer ?>
    </div>
</body>

</html>