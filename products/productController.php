<?php
class ProductController
{
    private $db;

    /************************************************************************
     * Constructor to initialize the database connection
     * @param mysqli $db Database connection object
     ************************************************************************/
    public function __construct($db)
    {
        $this->db = $db;
    }

    /************************************************************************
     * Fetch all products with optional sorting
     * @param string $column Column to sort by
     * @param string $order Sorting order (ASC or DESC)
     * @return array List of products
     ************************************************************************/

    public function fetchAllProducts($column = 'product_id', $order = 'ASC')
    {
        $allowedColumns = ['product_id', 'item_name', 'price', 'city', 'state', 'condition'];
        $column = in_array($column, $allowedColumns) ? $column : 'product_id';
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM products ORDER BY `$column` $order";
        $stmt = $this->db->query($query);

        if (!$stmt) {
            $this->handleError("Error executing query");
        }

        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    /************************************************************************
     * Fetch all products by user ID
     * @param int $user_id User ID
     * @param string $column Column to sort by
     * @param string $order Sorting order (ASC or DESC)
     * @return array List of products
     ************************************************************************/
    public function fetchProductsByUserId($user_id, $column = 'product_id', $order = 'ASC')
    {
        $allowedColumns = ['product_id', 'item_name', 'price', 'city', 'state', 'condition'];
        $column = in_array($column, $allowedColumns) ? $column : 'product_id';
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM products WHERE user_id = ? ORDER BY `$column` $order";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Error preparing statement");
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $this->handleError("Error fetching products");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    } // will this need to retrive images as well?

    /************************************************************************
     * Fetch a single product by its ID for editing
     * this will load a single item for editing
     * @param int $id Product ID
     * @return array|null Product details or null if not found
     ************************************************************************/
    public function fetchProductById($id)
    {
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        } finally {
            $stmt->close();
        }
    } // will this need to have images as well? 
      // will this need to have user_id as well?
      // wil this need to have allowedColumns as well?

    /************************************************************************
     * Add a new product
     * @param string $itemName Product name
     * @param float $itemPrice Product price
     * @param string $city City
     * @param string $state State
     * @param string $condition Product condition
     * @param string $itemDescription Product description
     * @param string $imagePaths Comma-separated image paths
     * @return string Success or error message
     *************************************************************************/
    public function addProducts($itemName, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths, $user_id)
    {
        $query = "INSERT INTO products (item_name, price, city, `state`, `condition`, `description`, image_path, user_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("sdsssssi", $itemName, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths, $user_id);
            $stmt->execute();
            return "Product added successfully.";
        } catch (Exception $e) {
            return "Error adding product: " . $stmt->error;
        } finally {
            $stmt->close();
        }
    }

    /************************************************************************
     * Delete a product by its ID
     * @param int $id Product ID
     * @return string Success or error message
     ************************************************************************/
    public function deleteProduct($product_id)
    {
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            return "Product deleted successfully.";
        } catch (Exception $e) {
            return "Error deleting product: " . $stmt->error;
        } finally {
            $stmt->close();
        } // will this need to handle image deletion? 
        // will this need to handle allowedColumns deletion?
    }

    /************************************************************************
     * Update a product
     * @param int $product_id Product ID
     * @param string $item_name Item name
     * @param string $description Item description
     * @param float $price Item price
     * @param string $condition Item condition
     * @param string $city Item city
     * @param string $state Item state
     * @param string|null $imagePaths Comma-separated image paths
     * @return string Update result message
     ************************************************************************/
    public function updateProduct($product_id, $item_name, $description, $price, $condition, $city, $state, $newImagePaths = null)
    {
        // Fetch existing image paths
        $existingProduct = $this->fetchProductById($product_id);
        $existingImagePaths = $existingProduct['image_path'];

        // Merge new image paths with existing ones
        if ($newImagePaths) {
            $imagePaths = $existingImagePaths ? $existingImagePaths . ',' . $newImagePaths : $newImagePaths;
        } else {
            $imagePaths = $existingImagePaths;
        }

        $query = "UPDATE products SET 
                  item_name = ?, `description` = ?, price = ?, `condition` = ?, city = ?, `state` = ?, image_path = ? 
                  WHERE product_id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            $this->handleError("Statement preparation failed");
        }

        try {
            $stmt->bind_param("ssdssssi", $item_name, $description, $price, $condition, $city, $state, $imagePaths, $product_id);
            $stmt->execute();
            return "Product updated successfully.";
        } catch (Exception $e) {
            return "Error updating product: " . $stmt->error;
        } finally {
            $stmt->close();
        }
    }




    /************************************************************************
     * Upload images
     * @param array $files Uploaded files
     * @return string Comma-separated image paths
     ************************************************************************/
    // public function uploadImages($files)
    // {
    //     $imagePaths = [];
    //     $uploadDir = '../media/';

    //     foreach ($files['name'] as $key => $name) {
    //         $tmpName = $files['tmp_name'][$key];
    //         $filePath = $uploadDir . basename($name);

    //         if (move_uploaded_file($tmpName, $filePath)) {
    //             $imagePaths[] = $filePath;
    //         }
    //     }

    //     return implode(',', $imagePaths);
    // }



    
    /************************************************************************
     * Handle errors by throwing an exception
     * @param string $message Error message
     * @throws Exception
     ************************************************************************/
    private function handleError($message)
    {
        throw new Exception($message . ": " . $this->db->error);
    }
}
