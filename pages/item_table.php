<?php

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 *
 * This script handles the item overview page where users can manage and edit their product listings.
 * It includes the following functionalities:
 * - Displaying a table of products with sorting capabilities.
 * - Providing buttons to edit or delete each product.
 * - Displaying success or error messages based on user actions.
 *
 * The script ensures that the user is authenticated before accessing the page.
 * It also includes the header and navigation bar for consistent layout across the site.
 *
 * Dependencies:
 * - checkAuth.php: Ensures the user is authenticated.
 * - mysqli_conn.php: Provides the database connection.
 * - productController.php: Contains methods for fetching and managing product data.
 * - header.php: Contains the HTML header and includes necessary CSS and JS files.
 * - navBar.php: Contains the navigation bar.
 * - footer.php: Contains the HTML footer.
 */

require_once '../php_functions/checkAuth.php';
require_once '../database/mysqli_conn.php';
require_once '../products/productController.php';

// Initialize ProductController
$productController = new ProductController($db_conn);

$title = 'Your Listings';
$stylesheets = ['../css/edit-table.css'];
include '../partials/header.php';
include '../partials/navBar.php';


// Sorting logic
$column = $_GET['column'] ?? 'product_id';
$order = $_GET['order'] ?? 'ASC';
$allowedColumns = ['product_id', 'item_name', 'price', 'city', 'state', 'condition'];

// Sanitize and validate sorting parameters
$column = in_array($column, $allowedColumns) ? $column : 'product_id';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
$user_id = $_SESSION['user_id'];
// Fetch sorted products
$products = $productController->fetchProductsByUserId($user_id, $column, $order);


/**
 * Get the sort order for a column.
 *
 * @param string $currentColumn The current column being sorted.
 * @param string $column The column to sort.
 * @param string $currentOrder The current sort order (ASC or DESC).
 * @return string The new sort order (ASC or DESC).
 */function getSortOrder($currentColumn, $column, $currentOrder)
{
  return ($currentColumn === $column && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
}

/**
 * Get the sort icon for a column.
 *
 * @param string $currentColumn The current column being sorted.
 * @param string $column The column to sort.
 * @param string $currentOrder The current sort order (ASC or DESC).
 * @return string The sort icon (▲ or ▼) or an empty string if not sorted.
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
                  <a href="?column=product_id&order=<?php echo getSortOrder($column, 'product_id', $order); ?>">Product ID <span class="sort-icon"><?php echo getSortIcon($column, 'product_id', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=item_name&order=<?php echo getSortOrder($column, 'item_name', $order); ?>">Item Name <span class="sort-icon"><?php echo getSortIcon($column, 'item_name', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=price&order=<?php echo getSortOrder($column, 'price', $order); ?>">Price <span class="sort-icon"><?php echo getSortIcon($column, 'price', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=city&order=<?php echo getSortOrder($column, 'city', $order); ?>">City <span class="sort-icon"><?php echo getSortIcon($column, 'city', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=state&order=<?php echo getSortOrder($column, 'state', $order); ?>">State <span class="sort-icon"><?php echo getSortIcon($column, 'state', $order); ?></span></a>
                </th>
                <th class="text-center sortable-header">
                  <a href="?column=condition&order=<?php echo getSortOrder($column, 'condition', $order); ?>">Condition <span class="sort-icon"><?php echo getSortIcon($column, 'condition', $order); ?></span></a>
                </th>
                <th class="text-center">Description</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                  <tr>
                    <td class="text-center">
                      <a href="product_edit.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                    </td>
                    <td class="text-center">
                      <form method="post" action="../products/productDelete.php" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash-alt"></i> Delete
                        </button>
                      </form>
                    </td>
                    <td class="text-center"><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($product['item_name']); ?></td>
                    <td class="text-center">$<?php echo htmlspecialchars($product['price']); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($product['city']); ?></td>
                    <td class="text-center"><?php echo strtoupper(htmlspecialchars($product['state'])); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($product['condition']); ?></td>
                    <td><?php echo htmlspecialchars(substr($product['description'], 0, 45)) . '...'; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-center">No products found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
            <?php if (isset($_SESSION['message'])): ?>
              <div class="alert alert-<?php echo $_SESSION['message']['type'] === 'success' ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['message']['text']; ?>
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