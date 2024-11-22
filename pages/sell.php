<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

$title = 'Sell an Item';
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