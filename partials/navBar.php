<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="landing.php">Second Hand Herold</a>

    <!-- Hamburger button for smaller screens -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <!-- Home Link -->
            <li class="nav-item">
                <a class="nav-link" href="landing.php">Home</a>
            </li>

            <!-- Listings Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="listingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Listings
                </a>
                <ul class="dropdown-menu" aria-labelledby="listingsDropdown">
                    <li><a class="dropdown-item" href="sell.php">Sell an Item</a></li>
                    <li><a class="dropdown-item" href="products.php">Browse Items</a></li>
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
                    Account
                </a>
                <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                    <li><a class="dropdown-item" href="account_settings.php">Account Settings</a></li>
                    <li><a class="dropdown-item" href="item_table.php">Edit Listings</a></li>
                    <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>