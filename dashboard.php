<?php
session_start();

include("etc/connection.php");

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
<header>
    <a class="nav-logo-link" href="index.php"><img class="nav-logo" src="img/bean_and_brew.png" alt="Bean & Brew Logo"></a>

    <button class="burger">
        <div class="bar"></div>
    </button>

    <nav class="nav-main">
        <ul class="nav-links">
            <button class="header-button" onclick="location.href='index.php'">Return To Homepage</button>
            <button class="header-button" onclick="location.href='etc/logout.php'">Log Out</button>
        </ul>
    </nav>

    <nav class="mobile-nav">
        <ul class="nav-main-mobile">
            <button class="header-button-mobile" onclick="location.href='index.php'">Return To Homepage</button>
            <button class="header-button-mobile" onclick="location.href='etc/logout.php'">Log Out</button>
        </ul>
    </nav>
</header>

<div class="single-section">
    <div class="container">
        <div class="single-section-row">
            <div class="single-section-column">
                <h2>Customer Dashboard</h2>
                <p>Here you can access your orders, bookings and more.</p>
            </div>
        </div>
    </div>
</div>

<div class="double-section">
    <div class="container">
        <div class="double-section-row">
            <div class="double-section-column">
                <h2>Your Bookings:</h2>
                <?php
                $query = "SELECT * FROM bookings WHERE booking_user_id = '$user_id'";
                $query_result = $conn->query($query);

                foreach($query_result as $row) {
                    $booking_id = $row["booking_id"];
                    $restaurant = $row["restaurant"];
                    $seats = $row["seats"];
                    $booking_date = $row["booking_date"];
                    $booking_date_created = $row["booking_date_created"];
                    $booking_type = $row["booking_type"];

                    $restaurant = ucfirst($restaurant);

                    $current_date = date("Y-m-d");
                    if ($booking_date >= $current_date) {
                        echo("<div class='lesson-block'>");
                        echo("<h2>Booking ID: $booking_id</h2>");
                        echo("<p>Booked For: $booking_date</p>");
                        echo("<p>Date Booked: $booking_date_created</p>");
                        echo("<p>Booking Type: $booking_type</p>");
                        echo("<br>");
                        echo("<p>Spaces Booked: $seats</p>");
                        echo("<p>Restaurant: $restaurant</p>");
                        echo("</div>");
                    }
                }
                ?>
            </div>
            <div class="double-section-column">
                <h2>Previous Bookings:</h2>
                <?php
                $query = "SELECT * FROM bookings WHERE booking_user_id = '$user_id'";
                $query_result = $conn->query($query);

                foreach($query_result as $row) {
                    $booking_id = $row["booking_id"];
                    $restaurant = $row["restaurant"];
                    $seats = $row["seats"];
                    $booking_date = $row["booking_date"];
                    $booking_date_created = $row["booking_date_created"];
                    $booking_type = $row["booking_type"];

                    $restaurant = ucfirst($restaurant);

                    $current_date = date("Y-m-d");
                    if ($booking_date < $current_date) {
                        echo("<div class='lesson-block'>");
                        echo("<h2>Booking ID: $booking_id</h2>");
                        echo("<p>Booked For: $booking_date</p>");
                        echo("<p>Date Booked: $booking_date_created</p>");
                        echo("<p>Booking Type: $booking_type</p>");
                        echo("<br>");
                        echo("<p>Spaces Booked: $seats</p>");
                        echo("<p>Restaurant: $restaurant</p>");
                        echo("</div>");
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="double-section">
    <div class="container">
        <div class="double-section-row">
            <div class="double-section-column">
                <h2>Your Pre-Orders:</h2>
                <?php
                $query = "SELECT * FROM orders WHERE order_user_id = '$user_id'";
                $query_result = $conn->query($query);

                foreach($query_result as $row) {
                    $order_id = $row["order_id"];
                    $order_total = $row["order_total"];
                    $order_date = $row["order_date"];
                    $order_status = $row["order_status"];
                    $order_items = $row["order_items"];

                    if ($order_status == 0) {
                        $order_status = "Order Received";
                    } else if ($order_status == 1) {
                        $order_status = "Order Preparing";
                    } else if ($order_status == 2) {
                        $order_status = "Order Completed";
                    } else {
                        $order_status = "Unknown";
                    }

                    $current_date = date("Y-m-d");
                    if ($order_date >= $current_date) {
                        echo("<div class='lesson-block'>");
                        echo("<h2>Order ID: $order_id</h2>");
                        echo("<p>Order Status: $order_status</p>");
                        $items = explode(",", $order_items);

                        echo("<p>Order Items:</p>");

                        foreach ($items as $item) {
                            $item_details = explode(":", $item);
                            $item_id = $item_details[0];
                            $quantity = $item_details[1];

                            $quantity = $quantity . "x";
                            $query = "SELECT * FROM items WHERE item_id = '$item_id'";
                            $query_result = $conn->query($query);
                            $query_result_array = mysqli_fetch_array($query_result);

                            $item_name = $query_result_array['name'];
                            echo("<p>$quantity $item_name</p>");
                        }

                        echo("<br>");
                        echo("<p>Order Total: £" . number_format($order_total, 2));
                        echo("<p>Ordered On: $order_date</p>");
                        echo("</div>");
                    }
                }
                ?>
            </div>
            <div class="double-section-column">
                <h2>Previous Orders:</h2>
                <?php
                $query = "SELECT * FROM orders WHERE order_user_id = '$user_id'";
                $query_result = $conn->query($query);

                foreach($query_result as $row) {
                    $order_id = $row["order_id"];
                    $order_total = $row["order_total"];
                    $order_date = $row["order_date"];
                    $order_status = $row["order_status"];
                    $order_items = $row["order_items"];

                    if ($order_status == 0) {
                        $order_status = "Order Received";
                    } else if ($order_status == 1) {
                        $order_status = "Order Preparing";
                    } else if ($order_status == 2) {
                        $order_status = "Order Completed";
                    } else {
                        $order_status = "Unknown";
                    }

                    $current_date = date("Y-m-d");
                    if ($order_date < $current_date) {
                        echo("<div class='lesson-block'>");
                        echo("<h2>Order ID: $order_id</h2>");
                        echo("<p>Order Status: $order_status</p>");
                        $items = explode(",", $order_items);

                        echo("<p>Order Items:</p>");

                        foreach ($items as $item) {
                            $item_details = explode(":", $item);
                            $item_id = $item_details[0];
                            $quantity = $item_details[1];

                            $quantity = $quantity . "x";
                            $query = "SELECT * FROM items WHERE item_id = '$item_id'";
                            $query_result = $conn->query($query);
                            $query_result_array = mysqli_fetch_array($query_result);

                            $item_name = $query_result_array['name'];
                            echo("<p>$quantity $item_name</p>");
                        }

                        echo("<br>");
                        echo("<p>Order Total: £" . number_format($order_total, 2));
                        echo("<p>Ordered On: $order_date</p>");
                        echo("</div>");
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="single-section">
    <div class="container">
        <div class="single-section-row">
            <div class="single-section-column">
                <h2>Account Settings</h2>
                <p>Here you can change various account settings.</p>
                <br>
                <button onclick="location.href='changepassword.php'">Change Password</button>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-row">
            <div class="footer-column">
                <h2>BEAN & BREW</h2>
                <ul>
                    <li><p>Copyright © Bean & Brew (<?php echo(date("Y")) ?>)<br><br>All Rights Reserved</p></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>NAVIGATION</h2>
                <ul>
                    <li><a href="shop.php">Pre-Order Coffee</a></li>
                    <li><a href="bookings.php">Create Booking</a></li>
                    <li><a href="lessons.php">View Lessons</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>LEGAL</h2>
                <ul>
                    <li><a href="#">Terms Of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h2>SOCIAL MEDIA</h2>
                <div class="footer-social">
                    <a href="https://twitter.com/bean_and_brew"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://facebook.com/bean_and_brew"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://youtube.com/bean_and_brew"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://tiktok.com/bean_and_brew"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
