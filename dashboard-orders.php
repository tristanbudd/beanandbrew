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
<div class="area">
    <div class="single-section">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <h2>Your Orders</h2>
                    <p>View all of your current and previous pre-orders.</p>
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
