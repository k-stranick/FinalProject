<?php
require_once '../php_functions/checkAuth.php';

require_once '../database/mysqli_conn.php';
require_once '../php_functions/productController.php';

$productController = new ProductController($db_conn);

// Get the product_id from the POST request
$product_id = $_POST['product_id'] ?? null;

if ($product_id) {
    try {
        $message = $productController->deleteProduct($product_id);
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => $message,
        ];
    } catch (Exception $e) {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => $e->getMessage(),
        ];
    }
} else {
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Invalid product ID.',
    ];
}

header('Location: ../pages/item_table.php');
exit();
