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
 * This script manages the product editing functionality for the "Second Hand Herald" project. 
 * It allows authenticated users to view and update their product listings. The script 
 * performs the following key tasks:
 *
 * 1. **Fetching Product Details**: Retrieves product information based on the `product_id` 
 *    passed via the query string.
 * 2. **Form Handling**: Pre-fills an HTML form with the current product details, allowing 
 *    users to edit fields such as the item title, description, price, condition, and more.
 * 3. **Image Uploads**: Handles the addition of new images to the product listing. 
 *    Existing images are displayed for user reference.
 * 4. **Validation and Updates**: Validates form inputs, processes the update via the 
 *    `ProductController`, and provides feedback to the user through success/error messages.
 * 5. **Redirection**: Ensures the user is redirected to the appropriate page if 
 *    `product_id` is invalid or the product is not found.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures that the user is authenticated before accessing this page.
 * - `mysqli_conn.php`: Provides a connection to the MySQL database.
 * - `productController.php`: Contains methods for handling product-related database operations.
 * - `FormHandler.php`: Provides helper functions for form data sanitization, validation, and file uploads.
 * - `header.php`, `navBar.php`, and `footer.php`: Include reusable UI components for consistency across pages.
 *
 * **Key Methods**:
 * - `loadProduct($productController, $product_id)`: Loads a product from the database 
 *    and redirects if the product is not found.
 * 
 * **Page Structure**:
 * - **Form Fields**: Allows users to update item title, description, price, condition, city, 
 *   state, and images.
 * - **Validation Messages**: Displays alerts to indicate success or error in updating the product.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

// Include necessary files and ensure the user is authenticated
require_once '../sessionmgmt/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../products/productController.php';
require_once '../formlogic/FormHandler.php'; // Include FormHandler

/**
 * Helper function to load a product by ID.
 * 
 * @param ProductController $productController Instance of the ProductController class.
 * @param int $product_id ID of the product to be loaded.
 * @return array The product details as an associative array.
 */
function loadProduct($productController, $product_id)
{
    $product = $productController->fetchProductById($product_id);
    if (!$product) {
        // Redirect if the product is not found.
        header("Location: item_table.php?message=Product not found.");
        exit();
    }
    return $product;
}

// Initialize the ProductController using the database connection.
$productController = new ProductController($db_conn);

// Define page title and include header and navigation bar.
$title = 'Edit Listings';
include '../partials/header.php';
include '../partials/navBar.php';

// Fetch the product ID from the URL query string.
$product_id = $_GET['product_id'] ?? null;

// Initialize default variables.
$error = false;
$message = "";
$images = [];
$item_name = '';
$description = '';
$price = '';
$condition = '';
$city = '';
$state = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission to update product details.
    $user_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID.

    // Extract and sanitize form data using FormHandler.
    $productData = FormHandler::getProductData($_POST, $user_id);

    // Handle image uploads if new images are provided.
    $newImagePaths = !empty($_FILES['images']['name'][0])
        ? FormHandler::handleFileUploads($_FILES['images'])
        : null;

    // Validate the form inputs.
    $validationResult = FormHandler::validateProductData($productData);
    if (!$validationResult['success']) {
        // Display validation errors as a message.
        $_SESSION['message'] = implode('<br>', $validationResult['errors']);
        $_SESSION['error'] = true;
    } else {
        // Update the product in the database using ProductController.
        $message = $productController->updateProduct(
            $product_id,
            $productData['item_name'],
            $productData['description'],
            $productData['price'],
            $productData['condition'],
            $productData['city'],
            $productData['state'],
            $newImagePaths
        );

        // Reload product details after the update.
        $product = loadProduct($productController, $product_id);
    }
} elseif ($product_id) {
    // Fetch product details for a valid product ID.
    $product = loadProduct($productController, $product_id);
} else {
    // Redirect if no valid product ID is provided.
    header("Location: item_table.php?message=Invalid product ID.");
    exit();
}

// Assign product details to variables for pre-filling the form.
$item_name = $product['item_name'];
$description = $product['description'];
$price = $product['price'];
$condition = $product['condition'];
$city = $product['city'];
$state = $product['state'];
$images = !empty($product['image_path']) ? explode(',', $product['image_path']) : [];
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5 mb-5">
            <?php if ($message): ?>
                <div class="alert <?= $error ? 'alert-danger' : 'alert-success'; ?>">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-section">
                        <form method="post" action="editListing.php?product_id=<?= $product_id; ?>" enctype="multipart/form-data">
                            <h2 class="text-center">Edit Item Details</h2>
                            <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                            <div class="mb-3">
                                <label for="itemTitle">Item Title</label>
                                <input type="text" class="form-control" id="itemTitle" name="itemTitle" value="<?= $item_name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description">Item Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?= $description; ?></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?= $city; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?= $state; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= $price; ?>" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="condition">Condition</label>
                                <input type="text" class="form-control" id="condition" name="condition" value="<?= $condition; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="images">Upload Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>
                            <div class="mb-3">
                                <label>Current Images</label>
                                <div class="current-images">
                                    <?php foreach ($images as $image): ?>
                                        <img src="<?= $image; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 100px;">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="listingtable.php" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div>
        <?php include '../partials/footer.php'; ?>
    </div>
</body>

</html>