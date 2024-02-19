<?php
# Including connection information and starting the session.
session_start();
include("etc/connection.php");

$basket_total = 0.00;
$vat = 0.00;

$count = 0;
if(isset($_SESSION['basket'])) {
    foreach($_SESSION['basket'] as $key => $basket_item) {
        $count += 1;
    }
}

$item_count = $count;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Shop</title>

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
            <li><a href="index.php">Home</a></li>
            <li>Pre-Order Coffee<div class="nav-selected"></div></li>
            <li><a href="bookings.php">Create Booking</a></li>
            <li><a href="lessons.php">View Lessons</a></li>
        </ul>
    </nav>

    <nav class="mobile-nav">
        <ul class="nav-main-mobile">
            <li class="nav-deco">Pre-Order Coffee<div class="nav-selected"></div></li>
            <li class="nav-deco"><a href="index.php">Home</a></li>
            <li class="nav-deco"><a href="bookings.php">Create Booking</a></li>
            <li class="nav-deco"><a href="lessons.php">View Lessons</a></li>
        </ul>
    </nav>
</header>

<div class="single-section">
    <div class="container">
        <div class="single-section-row">
            <div class="single-section-column">
                <h2>Your Basket</h2>
                <p>Add items, remove items and confirm your order here:</p>
            </div>
        </div>
    </div>
</div>

<?php
if ($item_count > 0) {
    echo("<div class='single-section'>");
        echo("<div class='container'>");
            echo("<div class='single-section-row'>");
                echo("<div class='single-section-column'>");
                    if(isset($_SESSION['basket'])) {
                        foreach ($_SESSION['basket'] as $basket_item) {
                            $id = $basket_item['item'];

                            $query = "SELECT * FROM items WHERE item_id = '$id'";
                            $query_result = $conn->query($query);

                            foreach($query_result as $row) {
                                $name = $row["name"];
                                $description = $row["description"];
                                $price = $row["price"];
                                $basket_total += $price;
                                $stock = $row["stock"];
                                $image_url = $row["image_url"];

                                if (strlen($description) > 100) {
                                    $description = substr($description, 0, 100);
                                    $description = rtrim($description, " \t\n\r\0\x0B");
                                    $description .= "...";
                                }
                            }

                            echo("<a href='shop_view.php?id=$id'><div class='basket-block'>");
                                echo("<img src='$image_url' alt='$name Image'></img>");
                                echo("<h2>$name</h2>");
                                echo("<p>$description</p>");
                                echo("<br>");
                                echo("<p>Total: £" . number_format($price * $basket_item['quantity'], 2) . "<br>(£" . number_format($price, 2) . " Each)</p>");
                            echo("</div></a>");

                            echo "<a href='shop_functions.php?action=add_item&id=$id&stock=$stock'><p>Add One (+)</p></a>";
                            echo "<a href='shop_functions.php?action=remove_item&id=$id'><p>Remove One (-)</p></a>";
                            echo("<br>");

                            $vat = $basket_total / 5;
                        }
                    }
                echo("</div>");
            echo("</div>");
        echo("</div>");
    echo("</div>");

    echo("<div class='single-section'>");
        echo("<div class='container'>");
            echo("<div class='single-section-row'>");
                echo("<div class='single-section-column'>");
                    echo("<p>VAT (20%): £" . number_format($vat, 2) . "</p>");
                    echo("<p>Basket Total: £" . number_format($basket_total, 2) . "</p>");
                    echo("<br>");
                    echo("<button onclick=\"location.href='shop_functions.php?action=clear_basket'\">Clear Basket</button>");
                    echo("<button onclick=\"location.href='shop_functions.php?action=place_order'\">Place Order</button>");
                echo("</div>");
            echo("</div>");
        echo("</div>");
    echo("</div>");
} else {
    echo("<div class='single-section'>");
        echo("<div class='container'>");
            echo("<div class='single-section-row'>");
                echo("<div class='single-section-column'>");
                    echo("<p>Your Basket Is Empty</p>");
                echo("</div>");
            echo("</div>");
        echo("</div>");
    echo("</div>");
}

echo("<div class='single-section'>");
    echo("<div class='container'>");
        echo("<div class='single-section-row'>");
            echo("<div class='single-section-column'>");
                echo("<a href='shop.php'><p><- Continue Shopping</p></a>");
            echo("</div>");
        echo("</div>");
    echo("</div>");
echo("</div>");
?>

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
