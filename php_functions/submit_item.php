<!-- 
Name: Kyle Stranick
Course: ITN 264
Section: 201
Title: Assignment 10: Display Database Data
Due: 11/8/2024
-->

<?php
// Database connection
require_once '../database/mysqli_conn.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form fields
    $itemTitle = $_POST['itemTitle'];
    $itemDescription = $_POST['itemDescription'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $itemPrice = $_POST['price'];
    $condition = $_POST['condition'];
    //$condition = " "; // Example condition; replace with a form value if available

    // Array to hold image paths
    $uploadedImages = [];

    // Process each uploaded image
    foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
        // Get the original filename
        $fileName = $_FILES['image']['name'][$key];
        $filePath = "../media/" . basename($fileName); // Save to media folder

        // Move the uploaded file to the desired location
        if (move_uploaded_file($tmp_name, $filePath)) {
            $uploadedImages[] = $filePath; // Add to the image paths array
        }
    }

    // Convert image paths array to a comma-separated string
    $imagePaths = implode(",", $uploadedImages);

    // Step 1: Prepare the INSERT query with placeholders for values
    $query = "INSERT INTO products (item_name, price, city, `state`, `condition`, `description`, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db_conn->prepare($query);

    // Step 2: Bind parameters to the placeholders with appropriate data types
    // Here, 'sdssss' specifies the data types in order
    $stmt->bind_param("sdsssss", $itemTitle, $itemPrice, $city, $state, $condition, $itemDescription, $imagePaths);

    // Step 3: Execute the statement
    if ($stmt->execute()) {
        // Redirect to the product page after successful submission
        header("Location: ../pages/products.php"); 
        exit(); // Make sure to call exit to stop further script execution
    } else {
        echo "Error: " . $stmt->error;
    }

    // Step 4: Close statement and connection
    $stmt->close();
    $db_conn->close();
}
?>