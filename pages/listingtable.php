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
 * Product Overview and Management Script
 *
 * This script provides functionality for managing product listings on the Second Hand Herold website. 
 * It allows users to view, sort, edit, and delete their product listings.
 *
 * **Key Features**:
 * 1. **Product Display**: Displays a table of product listings fetched from the database.
 * 2. **Sorting**: Allows users to sort products by various attributes (e.g., product ID, item name, price, etc.).
 * 3. **Edit/Delete Options**: Provides buttons to edit or delete individual products.
 * 4. **Success/Error Messaging**: Displays success or error messages for user actions (e.g., successful deletion).
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing the page.
 * - `mysqli_conn.php`: Provides the database connection.
 * - `productController.php`: Contains methods for fetching and managing product data.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `footer.php`: Contains the HTML footer.
 *
 * **Process Flow**:
 * - Fetch the user's product listings from the database.
 * - Allow sorting of products based on query parameters (`column` and `order`).
 * - Display the product listings in a table with options to edit or delete each product.
 * - Handle user actions such as sorting, editing, and deletion.
 */

// Include required files for authentication, database connection, and product management
require_once '../sessionmgmt/checkAuth.php'; // Ensure user is logged in
require_once '../database/mysqli_conn.php'; // Database connection
require_once '../products/productController.php'; // Product management functions

// Initialize ProductController for interacting with the database
$productController = new ProductController($db_conn);

// Page configuration
$title = 'Your Listings'; // Page title
$stylesheets = ['../css/edit-table.css']; // Custom stylesheet for table styling
include '../partials/header.php'; // Include header
include '../partials/navBar.php'; // Include navigation bar

// Handle sorting parameters
$column = $_GET['column'] ?? 'product_id'; // Default sort column is `product_id`
$order = $_GET['order'] ?? 'ASC'; // Default sort order is ascending
$allowedColumns = ['product_id', 'item_name', 'price', 'city', 'state', 'condition']; // Allowed sort columns

// Sanitize and validate sorting parameters
$column = in_array($column, $allowedColumns) ? $column : 'product_id';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

// Get user ID from session
$user_id = $_SESSION['user_id']; // Assumes `user_id` is stored in session after login

// Fetch products for the logged-in user, sorted by the selected column and order
$products = $productController->fetchProductsByUserId($user_id, $column, $order);

/**
 * Get the sort order for a column.
 *
 * This function toggles the sort order between `ASC` and `DESC` for the selected column.
 *
 * @param string $currentColumn The column currently being sorted.
 * @param string $column The column to check.
 * @param string $currentOrder The current sort order (`ASC` or `DESC`).
 * @return string The new sort order for the column (`ASC` or `DESC`).
 */
function getSortOrder($currentColumn, $column, $currentOrder)
{
  return ($currentColumn === $column && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
}

/**
 * Get the sort icon for a column.
 *
 * This function returns the appropriate sort icon (▲ for ascending or ▼ for descending)
 * based on the current column and sort order.
 *
 * @param string $currentColumn The column currently being sorted.
 * @param string $column The column to check.
 * @param string $currentOrder The current sort order (`ASC` or `DESC`).
 * @return string The sort icon (▲ or ▼) or an empty string if the column is not currently sorted.
 */
function getSortIcon($currentColumn, $column, $currentOrder)
{
  if ($currentColumn === $column) {
    return $currentOrder === 'ASC' ? '▲' : '▼';
  }
  return '';
}
?>

<body class="global-body">
  <main class="content flex-grow-1">
    <div class="hero-section text-center">
      <h1>Product Management</h1>
      <p class="lead">Manage and edit product listings with ease</p>
    </div>

    <div id="home" class="container my-5">
      <div class="table-container">
        <h2 class="text-center mb-4" style="color: #3582b6;">Products</h2>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
                <th class="text-center sortable-header">
                  <a href="?column=product_id&order=<?= getSortOrder($column, 'product_id', $order); ?>">Product ID <span class="sort-icon"><?= getSortIcon($column, 'product_id', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=item_name&order=<?= getSortOrder($column, 'item_name', $order); ?>">Item Name <span class="sort-icon"><?= getSortIcon($column, 'item_name', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=price&order=<?= getSortOrder($column, 'price', $order); ?>">Price <span class="sort-icon"><?= getSortIcon($column, 'price', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=city&order=<?= getSortOrder($column, 'city', $order); ?>">City <span class="sort-icon"><?= getSortIcon($column, 'city', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=state&order=<?= getSortOrder($column, 'state', $order); ?>">State <span class="sort-icon"><?= getSortIcon($column, 'state', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=condition&order=<?= getSortOrder($column, 'condition', $order); ?>">Condition <span class="sort-icon"><?= getSortIcon($column, 'condition', $order); ?></span></a>
                </th>
                <th class="text-center">Description</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                  <tr>
                    <td class="text-center">
                      <a href="editlisting.php?product_id=<?= $product['product_id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                    </td>
                    <td class="text-center">
                      <form method="post" action="../products/productDelete.php" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash-alt"></i> Delete
                        </button>
                      </form>
                    </td>
                    <td class="text-center"><?= htmlspecialchars($product['product_id']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($product['item_name']); ?></td>
                    <td class="text-center">$<?= htmlspecialchars($product['price']); ?></td>
                    <td class="text-center"><?= htmlspecialchars($product['city']); ?></td>
                    <td class="text-center"><?= strtoupper(htmlspecialchars($product['state'])); ?></td>
                    <td class="text-center"><?= htmlspecialchars($product['condition']); ?></td>
                    <td><?= htmlspecialchars(substr($product['description'], 0, 45)) . '...'; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center">No products found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
            <?php if (isset($_SESSION['message'])): ?>
              <div class="alert alert-<?= $_SESSION['message']['type'] === 'success' ? 'success' : 'danger'; ?>">
                <?= $_SESSION['message']['text']; ?>
              </div>
              <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
          </table>
        </div>
      </div>
    </div>
  </main>
  <div>
    <?php include '../partials/footer.php'; ?>
  </div>
</body>

</html>