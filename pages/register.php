<?php

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

// Include the database connection
require_once '../database/mysqli_conn.php';

$title = 'Register New User';
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <?php
                    // Display success or error messages
                    if (isset($_SESSION['success_message'])) {
                        echo "<div class='alert alert-success text-center'>{$_SESSION['success_message']}</div>";
                        unset($_SESSION['success_message']);
                    }
                    if (isset($_SESSION['error_message'])) {
                        echo "<div class='alert alert-danger text-center'>{$_SESSION['error_message']}</div>";
                        unset($_SESSION['error_message']);
                    }
                    ?>
                    <form method="post" action="../php_functions/process_user_registration.php" class="p-4 border rounded shadow-sm bg-light">
                        <h2 class="text-center mb-4">Register</h2>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_hash" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password_hash" name="password_hash" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div>
        <?php include '../partials/footer.php' ?>
    </div>
</body>

</html>