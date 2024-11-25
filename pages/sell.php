<?php

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../php_functions/checkAuth.php';
$title = 'Post a Listing';
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <?php include '../partials/sellForm.php'; ?>
    </main>
    <div>
        <?php include '../partials/footer.php'; ?>
    </div>
</body>

</html>