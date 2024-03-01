<?php
# Including connection information and starting the session.
session_start();
include("etc/connection.php");

# If Session ID is not set, redirect to the login page.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Dashboard</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Indulge in the rich flavors of coffee at Bean & Brew. Explore our wide range of coffee blends, brewing equipment, and accessories. Discover tools that elevate your coffee experience, making every sip a moment of joy.">
    <meta name="keywords" content="Bean & Brew, Coffee, Coffee Website, Coffee Blends, Brewing Equipment, Coffee Accessories, Coffee Flavors, Coffee Shop, Coffee Tools, Coffee Experience, Coffee Moments, Morning Delight, Coffee Lover, Coffee Recipes, Coffee Tips, Coffee Tasting, Coffee Brewing Techniques, Coffee Grinder, Coffee Maker, French Press, Espresso Machine, Coffee Beans, Coffee Filters, Coffee Mugs, Coffee Storage, Coffee Gadgets">
    <meta name="author" content="Fill this out when snacks isn't watching.">
    <meta name="copyright" content="Copyright © Bean & Brew (<?php echo(date("Y")) ?>)" />

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/site.webmanifest">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#7b7b7b">
    <link rel="shortcut icon" href="/favicons/favicon.ico">

    <link rel="stylesheet" href="style.css" type="text/css">

    <script src="https://kit.fontawesome.com/7a8bccb54b.js" crossorigin="anonymous"></script>
    <script src="script.js" async></script>
</head>
<body>
<?php include_once("cookie_component.php"); ?>

<div class="area">
    <div class="single-section" style="background-color: #000000;">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <h2>Customer Dashboard</h2>
                    <p>Here you can access your orders, bookings and more.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="single-section" style="background-color: #000000;">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <p>Select A TAB To Continue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="single-section" style="background-color: #000000;">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <h2>Account Settings</h2>
                    <p>Here you can change various account settings.</p>
                    <br>
                    <button onclick="location.href='changepassword.php'">Change Password</button>
                    <button onclick="location.href='changeusername.php'">Change Username</button>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="main-menu">
    <ul>
        <li>
            <a href="dashboard.php">
                <i class="fa fa-house-user fa-2x"></i>
                <span class="nav-text">
                           Homepage
                        </span>
            </a>

        </li>
        <li>
            <a href="dashboard-bookings.php">
                <i class="fa fa-book fa-2x"></i>
                <span class="nav-text">
                           My Bookings
                        </span>
            </a>
        </li>
        <li>
            <a href="dashboard-orders.php">
                <i class="fa fa-map-marker fa-2x"></i>
                <span class="nav-text">
                            My Pre-Orders
                        </span>
            </a>
        </li>
    </ul>

    <ul class="logout">
        <li>
            <a href="index.php">
                <i class="fa fa-home fa-2x"></i>
                <span class="nav-text">
                            Return To Homepage
                        </span>
            </a>
        </li>
        <li>
            <a href="etc/logout.php">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">
                            Log Out
                        </span>
            </a>
        </li>
    </ul>
</nav>
</body>
</html>
