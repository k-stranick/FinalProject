<?php
class ProductController
{
    private $db;

    /**
     * Constructor to initialize the database connection
     * @param mysqli $db Database connection object
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Fetch all products with optional sorting
     * @param string $column Column to sort by
     * @param string $order Sorting order (ASC or DESC)
     * @return array List of products
     */
    public function fetchProducts($column = 'id', $order = 'ASC')
    {
        $allowedColumns = ['id', 'item_name', 'price', 'city', 'state', 'condition'];
        $column = in_array($column, $allowedColumns) ? $column : 'id';
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM products ORDER BY `$column` $order";
        $result = $this->db->query($query);

        if (!$result) {
            $this->handleError("Error fetching products");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Fetch a single product by its ID
     * @param int $id Product ID
     * @return array|null Product details or null if not found
     */
    public function fetchProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } finally {
            $stmt->close();
        }
    }

    /**
     * Add a new product
     * @param string $itemName Product name
     * @param float $itemPrice Product price
     * @param string $city City
     * @param string $state State
     * @param string $condition Product condition
     * @param string $itemDescription Product description
     * @param string $imagePaths Comma-separated image paths
     * @return string Success or error message
     */
    public function addProducts($itemName, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths)
    {
        $query = "INSERT INTO products (item_name, price, city, `state`, `condition`, `description`, image_path) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("sdsssss", $itemName, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths);
            $stmt->execute();
            return "Product added successfully.";
        } catch (Exception $e) {
            return "Error adding product: " . $stmt->error;
        } finally {
            $stmt->close();
        }
    }

    /**
     * Delete a product by its ID
     * @param int $id Product ID
     * @return string Success or error message
     */
    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return "Product deleted successfully.";
        } catch (Exception $e) {
            return "Error deleting product: " . $stmt->error;
        } finally {
            $stmt->close();
        }
    }

    /**
     * Update a product
     * @param int $product_id Product ID
     * @param string $item_name Product name
     * @param string $description Product description
     * @param float $price Product price
     * @param string $condition Product condition
     * @param string $city City
     * @param string $state State
     * @return string Success or error message
     */
    public function updateProduct($product_id, $item_name, $description, $price, $condition, $city, $state)
    {
        $query = "UPDATE products SET 
                  item_name = ?, `description` = ?, price = ?, `condition` = ?, city = ?, `state` = ? 
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("ssdsssi", $item_name, $description, $price, $condition, $city, $state, $product_id);
            $stmt->execute();
            return "Product updated successfully.";
        } catch (Exception $e) {
            return "Error updating product: " . $stmt->error;
        } finally {
            $stmt->close();
        }
    }

    /**
     * Handle errors by throwing an exception
     * @param string $message Error message
     * @throws Exception
     */
    private function handleError($message)
    {
        throw new Exception($message . ": " . $this->db->error);
    }

    // // Get sorting order for headers
    // public function getSortOrder($currentColumn, $column, $order)
    // {
    //     return ($currentColumn === $column && $order === 'ASC') ? 'DESC' : 'ASC';
    // }

    // // Get sorting icon for headers
    // public function getSortIcon($currentColumn, $column, $order)
    // {
    //     if ($currentColumn === $column) {
    //         return $order === 'ASC' ? '▲' : '▼';
    //     }
    //     return '';
    // }
}
