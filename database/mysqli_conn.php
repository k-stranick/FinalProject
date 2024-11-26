<?php
require_once '../database/database_build_script/database_config.php';

/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 * ***************************
 * 
 * MySQLi Database Connection Script
 *
 * This script establishes a connection to the MySQL database for the Second Hand Herold website.
 * It includes the following functionalities:
 *
 * 1. **Database Configuration**: Includes the database configuration file for connection details.
 * 2. **Connection Establishment**: Creates a new MySQLi connection using the provided configuration.
 * 3. **Error Handling**: Checks for connection errors and handles them appropriately.
 *
 * **Dependencies**:
 * - `database_config.php`: Contains the database configuration details such as host, username, password, and database name.
 *
 * **Process Flow**:
 * - Includes the database configuration file.
 * - Establishes a connection to the MySQL database using MySQLi.
 * - Checks for connection errors and handles them appropriately.
 */

/* $db_conn is a database connection object. It will be used with other functions
   so that we can communicate with the database server. */

$db_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if ($db_conn->connect_errno) {
    die("Failed to connect to MySQL server: " . $db_conn->connect_error);
}

?>