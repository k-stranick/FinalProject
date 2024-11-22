<?php
require_once '../database/database_build_script/database_config.php';

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

/*****
 *
 * This file contains the MySQL server configuration settings and makes the connection to
 * the database server.
 *
 *****/

/* $db_conn is a database connection object.  It will be used with other functions
        so that we can communicate with the database server. */

$db_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if ($db_conn->connect_errno) {
	die("Failed to connect to MySQL server: " . $db_conn->connect_error);
}

?>  