
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
 * This script handles the form for users to post items for sale on the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Form Handling**: Displays a form for users to enter item details such as title, description, price, condition, city, state, and images.
 * 2. **Validation Messages**: Displays success or error messages based on the form submission result.
 *
 * **Dependencies**:
 * - `submitItem.php`: Processes the form submission and handles item data storage.
 *
 * **Page Structure**:
 * - **Messages**: Displays alerts to indicate success or error in posting the item.
 * - **Sell Form**: Allows users to enter item details and upload images.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? false;
unset($_SESSION['message'], $_SESSION['error']);
?>
<div class="container mt-5  mb-5">
    <?php if ($message): ?>
        <div class="alert <?= $error ? 'alert-danger' : 'alert-success'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <h2 class="text-center">Want to Sell Something? Post It Here!</h2>
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Form is now limited to 6 out of 12 columns on medium or larger screens -->
            <div class="form-section">
                <form action="../products/submitItem.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="itemTitle">Item Title</label>
                        <input type="text" class="form-control" id="itemTitle" name="itemTitle" placeholder="Enter item" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Item Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter item description" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="state">Condition</label>
                            <input type="text" class="form-control" id="condition" name="condition" placeholder="Enter Condition" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image">Upload Item Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>