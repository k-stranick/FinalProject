<?php
session_start();
require_once '../database/mysqli_conn.php'; // test do i need this? 

if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}


/**
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Project 3
 * Due: 11/22/2024
 */

$title = 'Login Page';
$stylesheets = ['../css/login.css'];
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">

    <!-- Log in form -->
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="post" action="../php_functions/authenticate.php" class="p-4 border rounded shadow-sm bg-light">
                        <?php if (isset($_GET['error'])): ?>
                            <p class="error-message">Error: <?= htmlspecialchars($_GET['error']) ?></p>
                        <?php endif; ?>
                        <h2 class="text-center mb-4">Login</h2>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div>
                            <h6 class="text-center mt-4"> New to Second Hand Herold? Sign-up <span> <a href="register.php">HERE</a></span></h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div>
        <?php include '../partials/footer.php'; ?>
    </div>
</body>

</html>