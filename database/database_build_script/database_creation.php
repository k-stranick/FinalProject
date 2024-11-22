<?php
ob_start(); // Turn on output buffering
require_once 'database_config.php'; // Load configuration

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */


/*****
 * This script executes the SQL file that creates the database, tables, and initial data.
 * It's meant to run the SQL script in an existing MySQL database or it will create the database 
 * if it does now exist.
 *****/

// Create connection to the MySQL server (connect without DB_NAME)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, '', DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$db_check_query = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($db_check_query) === TRUE) {
    echo "Database created or already exists.\n";
} else {
    die("Error creating database: " . $conn->error);
}

// Now, select the created (or existing) database
$conn->select_db(DB_NAME);

// Path to your SQL file that contains the database creation script
$sql_file = __DIR__ . '/users.sql'; // Dynamic path to the SQL file

// Check if the SQL file exists
if (!file_exists($sql_file)) {
    die("Error: The SQL file does not exist at path: $sql_file\n");
}

// Read the SQL file
$sql = file_get_contents($sql_file);

// Split the SQL script into individual statements
$queries = explode(';', $sql);

// Execute each query separately
foreach ($queries as $query) {
    $query = trim($query); // Remove unnecessary whitespace
    if (!empty($query)) {
        if ($conn->query($query) === TRUE) {
            echo "Query executed successfully: \n$query\n\n";
        } else {
            echo "Error executing query: " . $conn->error . "\n";
        }
    }
}
$output = ob_get_clean(); // Get the output buffer and clean it
echo nl2br($output); // Output the result
// Close the connection
$conn->close();

echo "Database setup complete.\n";
?>


<!-- resources 
https://www.php.net/manual/en/ref.mysql.php
https://www.php.net/manual/en/mysqli.quickstart.connections.php
https://stackoverflow.com/questions/14037290/what-does-or-mean-in-php
https://www.w3schools.com/php/func_string_nl2br.asp
https://www.php.net/manual/en/function.nl2br.php
https://www.php.net/manual/en/function.ob-start.php
-->