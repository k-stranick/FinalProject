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
 * Product Card Component
 *
 * This file contains a function to render a product card for displaying product details.
 * It includes the following functionalities:
 *
 * 1. **Image Carousel**: Displays a carousel of product images.
 * 2. **Product Details**: Shows the product's name, location, price, condition, and description.
 * 3. **View More Button**: Provides a button to view more details about the product.
 *
 * **Function**:
 * - `renderProductCard($product)`: Renders a product card with the provided product details.
 *
 * **Parameters**:
 * - `$product`: An associative array containing the product details.
 *
 * **Page Structure**:
 * - **Image Carousel**: Displays a carousel of product images.
 * - **Product Details**: Shows the product's name, location, price, condition, and description.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

function renderProductCard($product) {
    // Split the image paths into an array
    $imagePaths = explode(",", $product['image_path']);
    ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <!-- Image Carousel -->
            <div id="carousel<?= $product['product_id'] ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($imagePaths as $index => $imagePath): ?>
                        <!-- Carousel Item -->
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars(trim($imagePath)) ?>" class="d-block w-100" alt="Product Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $product['product_id'] ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $product['product_id'] ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
            <!-- Product Details -->
            <div class="card-body text-start d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= htmlspecialchars($product['item_name']) ?></h5>
                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($product['city']) ?>, <?= strtoupper(htmlspecialchars($product['state'])) ?></p>
                <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>
                <p class="card-text"><strong>Condition:</strong> <?= htmlspecialchars($product['condition']) ?></p>
                <p class="card-text"><strong>Description:</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <!-- View More Button -->
                <a href="#" class="btn btn-primary">View More Details</a>
            </div>
        </div>
    </div>
    <?php
}
?>