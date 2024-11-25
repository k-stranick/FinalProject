<?php

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 *
 * This script handles the product editing page where users can update their product listings.
 * It includes the following functionalities:
 * - Fetching product details from the database.
 * - Displaying a form pre-filled with the product's current information.
 * - Handling form submission to update product information.
 * - Handling image uploads for the product.
 * - Displaying success or error messages based on the update result.
 *
 * The script ensures that the user is authenticated before accessing the page.
 * It also includes the header and navigation bar for consistent layout across the site.
 *
 * Dependencies:
 * - checkAuth.php: Ensures the user is authenticated.
 * - mysqli_conn.php: Provides the database connection.
 * - productController.php: Contains methods for fetching and managing product data.
 * - FormHandler.php: Contains methods for handling form data and file uploads.
 * - header.php: Contains the HTML header and includes necessary CSS and JS files.
 * - navBar.php: Contains the navigation bar.
 * - footer.php: Contains the HTML footer.
 */

// Include necessary files and ensure the user is authenticated
require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../php_functions/productController.php';
require_once '../php_functions/FormHandler.php'; // Include FormHandler

// Initialize ProductController
$productController = new ProductController($db_conn);

function loadProduct($productController, $product_id)
{
    $product = $productController->fetchProductById($product_id);
    if (!$product) {
        header("Location: item_table.php?message=Product not found.");
        exit();
    }
    return $product;
}

// Set title and include header and nav bar
$title = 'Edit Listings';
include '../partials/header.php';
include '../partials/navBar.php';

// Fetch product ID from URL
$product_id = $_GET['product_id'] ?? null;

// Initialize variables
$error = false;
$message = "";
$images = []; // Initialize $images to an empty array
$item_name = '';
$description = '';
$price = '';
$condition = '';
$city = '';
$state = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Ensure $user_id is defined
    $productData = FormHandler::getProductData($_POST, $user_id);

    // Handle image upload
    $newImagePaths = !empty($_FILES['images']['name'][0])
        ? FormHandler::handleFileUploads($_FILES['images'])
        : null;

    // Validate required fields
    $validationResult = FormHandler::validateProductData($productData);
    if (!$validationResult['success']) {
        $_SESSION['message'] = implode('<br>', $validationResult['errors']);
        $_SESSION['error'] = true;
    } else {
        // Update product via ProductController
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

        // Refresh product details after update
        $product = loadProduct($productController, $product_id);
    }
} elseif ($product_id) {
    // Load product details for the given product_id
    $product = loadProduct($productController, $product_id);
} else {
    header("Location: item_table.php?message=Invalid product ID.");
    exit();
}

// Assign product details to variables
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
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-section">
                        <form method="post" action="product_edit.php?product_id=<?php echo $product_id; ?>" enctype="multipart/form-data">
                            <h2 class="text-center">Edit Item Details</h2>
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <div class="mb-3">
                                <label for="itemTitle">Item Title</label>
                                <input type="text" class="form-control" id="itemTitle" name="itemTitle" value="<?php echo $item_name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description">Item Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="condition">Condition</label>
                                <input type="text" class="form-control" id="condition" name="condition" value="<?php echo $condition; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="images">Upload Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>
                            <div class="mb-3">
                                <label>Current Images</label>
                                <div class="current-images">
                                    <?php foreach ($images as $image): ?>
                                        <img src="<?php echo $image; ?>" alt="Product Image" class="img-thumbnail" style="max-width: 100px;">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="item_table.php" class="btn btn-secondary">Back</a>
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