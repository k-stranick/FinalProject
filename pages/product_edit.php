<?php

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../php_functions/productController.php';

$productController = new ProductController($db_conn);
$title = 'Edit Listings';
include '../partials/header.php';
include '../partials/navBar.php';


// Fetch product ID from URL
$product_id = $_GET['product_id'] ?? null;
$error = false;
$message = "";
$images = []; // Initialize $images to an empty array


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = htmlspecialchars(trim($_POST['product_id']));
    $item_name = htmlspecialchars(trim($_POST['itemTitle']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = htmlspecialchars(trim($_POST['price']));
    $condition = htmlspecialchars(trim($_POST['condition']));
    $city = htmlspecialchars(trim($_POST['city']));
    $state = strtoupper(htmlspecialchars(trim($_POST['state'])));

    // Handle image upload
    $newImagePaths = null;
    if (!empty($_FILES['images']['name'][0])) {
        $newImagePaths = $productController->uploadImages($_FILES['images']);
    }

    // Validate required fields
    if (empty($item_name) || empty($description) || empty($price) || empty($condition) || empty($city) || empty($state)) {
        $error = true;
        $message = "All fields are required.";
    } else {
        // Update product via ProductController
        $message = $productController->updateProduct($product_id, $item_name, $description, $price, $condition, $city, $state, $newImagePaths);

        // Refresh product details after update
        $product = $productController->fetchProductById($product_id);
        $item_name = $product['item_name'];
        $description = $product['description'];
        $price = $product['price'];
        $condition = $product['condition'];
        $city = $product['city'];
        $state = $product['state'];
        $images = !empty($product['image_path']) ? explode(',', $product['image_path']) : [];
    }
} else {
    // Load product details for the given product_id
    if ($product_id) {
        $product = $productController->fetchProductById($product_id);
        if (!$product) {
            header("Location: item_table.php?message=Product not found.");
            exit();
        }
        $item_name = $product['item_name'];
        $description = $product['description'];
        $price = $product['price'];
        $condition = $product['condition'];
        $city = $product['city'];
        $state = $product['state'];
        $images = !empty($product['image_path']) ? explode(',', $product['image_path']) : [];
    } else {
        header("Location: item_table.php?message=Invalid product ID.");
        exit();
    }
}
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