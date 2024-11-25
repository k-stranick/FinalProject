<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Second Hand Herold</a>

    <!-- Hamburger button for smaller screens -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <!-- Home Link -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>

            <!-- Listings Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="listingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Listings
                </a>
                <ul class="dropdown-menu" aria-labelledby="listingsDropdown">
                    <li><a class="dropdown-item" href="sell.php">Post a Listing</a></li>
                    <li><a class="dropdown-item" href="products.php">Browse Listings</a></li>
                    <li><a class="dropdown-item" href="item_table.php">Edit Listings</a></li>
                </ul>
            </li>

            <!-- Events Link -->
            <li class="nav-item">
                <a class="nav-link" href="events.php">Events</a>
            </li>

            <!-- Account Link -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['username']) : 'Account'; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a class="dropdown-item" href="accountSettings.php">Account Settings</a></li>
                        <li><a class="dropdown-item" href="item_table.php">Edit Listings</a></li>
                        <li><a class="dropdown-item" href="../users/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="login.php">Login</a></li>
                        <li><a class="dropdown-item" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>
