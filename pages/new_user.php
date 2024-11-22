<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

require_once '../database/mysqli_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert user data into the database
    $stmt = $db_conn->prepare("INSERT INTO users (first_name, last_name, email, user_name, `password`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $user_name, $password);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration successful! Please log in.";
        header("Location: login.php"); // Redirect to login page
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
$title = 'Register New User';
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">
    <main class="content flex-grow-1">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="post" action="" class="p-4 border rounded shadow-sm bg-light">
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
                            <label for="user_name" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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