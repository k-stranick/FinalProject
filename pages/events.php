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
 * This script handles the events page where users can view upcoming community market events.
 * It includes the following functionalities:
 *
 * 1. **Jumbotron Section**: Displays a brief introduction to the event.
 * 2. **Event Details Section**: Provides detailed information about the upcoming event.
 * 3. **Event Registration**: Allows users to reserve a spot at the event via a registration form.
 *
 * **Dependencies**:
 * - `checkAuth.php`: Ensures the user is authenticated before accessing the page.
 * - `header.php`: Contains the HTML header and includes necessary CSS and JS files.
 * - `navBar.php`: Contains the navigation bar.
 * - `footer.php`: Contains the HTML footer.
 *
 * **Page Structure**:
 * - **Jumbotron Section**: Introduces the event with a title, description, and a call-to-action button.
 * - **Event Details Section**: Displays the event's date, time, location, and additional details.
 * - **Event Registration Modal**: Provides a form for users to register for the event.
 * - **Styling**: Utilizes Bootstrap for styling and responsiveness.
 */

require_once '../sessionmgmt/checkAuth.php';
$title = 'Events';
$stylesheets = ['../css/eventspage.css'];
include '../partials/header.php';
include '../partials/navBar.php';
?>

<body class="global-body">
    <main class="content flex-grow-1">

        <!-- Jumbotron Section -->
        <div class="jumbotron text-center">
            <h1 class="display-4">Upcoming Community Market Event</h1>
            <p class="lead">Join us for our biggest local resale event of the year!</p>
            <hr class="my-4">
            <p>Find amazing deals on local items, meet other community members, and enjoy a fun-filled day at the market!</p>
            <a class="btn btn-light btn-lg mb-2" href="../resources/resources.html" role="button">Learn More</a>
        </div>

        <!-- Event Details Section -->
        <div class="container event-section mb-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="../media/fleamarket.jpg" class="img-fluid event-image" alt="Community Market Event">
                </div>
                <div class="col-md-6">
                    <h2>Berlin Flea Market Bash</h2>
                    <h4>Hosted by Secondhand Herold</h4>
                    <p><strong>Date:</strong> October 15, 2024</p>
                    <p><strong>Time:</strong> 10:00 AM - 9:00 PM</p>
                    <p><strong>Location:</strong> Berlin, MD</p>
                    <p>Hosted by the wonderful folks you know and love here at Secondhand Herold, don't miss the opportunity
                        to sell your items or grab some amazing deals at the Berlin Flea Market!
                        There will be food trucks, entertainment, and a lot of great finds. Whether you're looking to buy or
                        sell, this is an event for the entire family.</p>
                    <p>Sellers reserve your spot today and everyone else come prepared for a fun day at the market!</p>
                    <!-- Button trigger modal -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Reserve Your
                        Spot</a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Event Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../formlogic/registerForm.php" method="post">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="form-group">
                                <label for="telephone">Telephone Number</label>
                                <input type="tel" class="form-control" id="telephone" name="telephone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <?php include '../partials/footer.php'; ?>
</body>

</html>