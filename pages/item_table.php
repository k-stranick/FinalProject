<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024
require_once '../database/mysqli_conn.php';
require_once '../php/productController.php';

// Initialize ProductController
$productController = new ProductController($db_conn);

$title = 'Item Overview';
$stylesheets = ['../css/edit-table.css'];
include '../partials/header.php';
include '../partials/navBar.php';


// Sorting logic
$column = $_GET['column'] ?? 'id';
$order = $_GET['order'] ?? 'ASC';
$allowedColumns = ['id', 'item_name', 'price', 'city', 'state', 'condition'];

// Sanitize and validate sorting parameters
$column = in_array($column, $allowedColumns) ? $column : 'id';
$order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

// Fetch sorted products
$products = $productController->fetchProducts($column, $order);

// Helper functions for sorting icons and order toggling
function getSortOrder($currentColumn, $column, $currentOrder)
{
  return ($currentColumn === $column && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
}

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
                  <a href="?column=id&order=<?php echo getSortOrder($column, 'id', $order); ?>">Product ID <span class="sort-icon"><?php echo getSortIcon($column, 'id', $order); ?></span></a>
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
                      <a href="product_edit.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                    </td>
                    <td class="text-center">
                      <a href="product_delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Delete
                      </a>
                    </td>
                    <td class="text-center"><?php echo htmlspecialchars($product['id']); ?></td>
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