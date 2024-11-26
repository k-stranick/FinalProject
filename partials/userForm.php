<?php
/**
 * ***************************
 * Name: Kyle Stranick
 * Course: ITN 264
 * Section: 201
 * Title: Final Project
 * Due: 12/3/2024
 * ***************************
 * 
 * Reusable User Form Component
 *
 * This file contains the HTML form for user registration and account settings.
 * It includes the following functionalities:
 *
 * 1. **Form Handling**: Displays a form for users to enter their first name, last name, email, username, and password.
 * 2. **Pre-filled Fields**: Accepts variables to pre-fill the form fields based on the context (registration or account settings).
 *
 * **Variables**:
 * - `$action`: The form action URL.
 * - `$first_name`: The first name of the user.
 * - `$last_name`: The last name of the user.
 * - `$email`: The email of the user.
 * - `$username`: The username of the user.
 * - `$password_placeholder`: Placeholder text for the password field.
 * - `$confirm_password_placeholder`: Placeholder text for the confirm password field.
 * - `$button_text`: The text for the submit button.
 * - `$require_password`: Boolean to determine if the password fields are required.
 *
 * **Page Structure**:
 * - **Form Fields**: Allows users to enter their first name, last name, email, username, and password.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

?>

<form method="post" action="<?= htmlspecialchars($action); ?>" class="p-4 border rounded shadow-sm bg-light">
    <h2 class="text-center mb-4"><?php echo $title; ?></h2>
    <div class="row">
        <div class="col-md-6">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name ?? ''); ?>" required>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username ?? ''); ?>" required>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?= htmlspecialchars($password_placeholder); ?>" <?= $require_password ? 'required' : ''; ?>>
        </div>
        <div class="col-md-6">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?= htmlspecialchars($confirm_password_placeholder); ?>" <?= $require_password ? 'required' : ''; ?>>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-100"><?= htmlspecialchars($button_text); ?></button>
    </div>
</form>