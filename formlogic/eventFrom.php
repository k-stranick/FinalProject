<!-- 
Name: Kyle Stranick
Course: ITN 264
Section: 201
Title: Assignment 10: Display Database Data
Due: 11/8/2024
-->

<?php
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];

    // Basic validation
    if (!empty($fullName) && !empty($email)) {
        
        // For now, just output the data (you can save this to a database or send an email)
        echo "Thank you, " . htmlspecialchars($fullName) . "! We have received your registration with the email: " . htmlspecialchars($email);
	} else {
        echo "Please fill in all fields.";
    }
}
?>