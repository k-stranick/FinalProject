<?php

/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

// Include the necessary files
require_once '../database/mysqli_conn.php';
require_once '../formlogic/FormHandler.php';
require_once '../users/UserController.php';

$title = 'Register New User';
include '../partials/header.php';
include '../partials/navBar.php';

// Set message and error variables from session
$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? false;
unset($_SESSION['message'], $_SESSION['error']);
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">

                    <!-- Messages -->
                    <?php if ($message): ?>
                        <div class="alert <?= $error ? 'alert-danger' : 'alert-success'; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>


                    <!-- Registration Form -->
                    <?php
                    $action = '../users/processUserRegistration.php';
                    $first_name = '';
                    $last_name = '';
                    $email = '';
                    $username = '';
                    $password_placeholder = 'Enter password';
                    $confirm_password_placeholder = 'Confirm password';
                    $button_text = 'Register';
                    $require_password = true; // Password fields are required
                    include '../partials/userForm.php';
                    ?>
                </div>
            </div>
        </div>
    </main>

    <div>
        <?php include '../partials/footer.php' ?>
    </div>
</body>

</html>