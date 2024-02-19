<?php
# Including connection information.
include("etc/connection.php");
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
                    <h2>Pre-Order Coffee</h2>
                    <p>Pre-Order Coffee or Bakery Items here:</p>

                    <?php
                        $query = "SELECT * FROM items";
                        $query_result = $conn->query($query);

                        if (mysqli_num_rows($query_result) == 0) {
                            echo "<br><br><h3>No Items Available, Try Again Later!</h3>";
                        } else {
                            $amount_found = strval(mysqli_num_rows($query_result));

                            $query = "SELECT SUM(in_stock) FROM items";
                            $query_result = $conn->query($query);
                            $row = $query_result->fetch_row();
                            $stock_left = $row[0];

                            echo "<p>($amount_found Products Found) ($stock_left Items In Stock)</p>";
                        }
                    ?>

                    <br>
                    <button onclick="location.href='shop_basket.php'">View Basket</button>
                </div>
            </div>
        </div>
    </div>

    <div class="triple-section">
        <div class="container">
            <div class="triple-section-row">
                <?php
                $query = "SELECT * FROM items";
                $query_result = $conn->query($query);

                if (mysqli_num_rows($query_result) != 0) {
                    $offset_amount = $_GET['offset'] ?? 0;

                    $query = "SELECT * FROM items LIMIT 9 OFFSET $offset_amount";
                    $query_result = $conn->query($query);
                }

                foreach($query_result as $row) {
                    $id = $row["item_id"];
                    $name = $row["name"];
                    $description = $row["description"];
                    $price = $row["price"];
                    $in_stock = $row["in_stock"];
                    $image_url = $row["image_url"];

                    if ($in_stock > 0) {
                        if (strlen($description) > 100) {
                            $description = substr($description, 0, 100);
                            $description = rtrim($description, " \t\n\r\0\x0B");
                            $description .= "...";
                        }

                        echo("<div class='triple-section-column'>");
                        echo("<img src='$image_url' alt='$name Image'></img>");
                        echo("<h2>$name</h2>");
                        echo("<p>$description</p>");
                        echo("<br>");
                        echo("<p>£" . number_format($price, 2) . " • $in_stock In Stock</p>");
                        echo("<br>");
                        echo "<button onclick=\"location.href='shop_view.php?id=$id'\">View Product</button>";
                        echo "<button onclick=\"location.href='shop_functions.php?action=add_item&id=$id&stock=$in_stock'\">Add To Basket</button>";
                        echo("</div>");
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="single-section">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <?php
                    $query = "SELECT * FROM items";
                    $query_result = $conn->query($query);

                    if (mysqli_num_rows($query_result) > 9) {
                        $next_amount = $offset_amount + 9;
                        $previous_amount = $offset_amount - 9;

                        if ($offset_amount + 9 < mysqli_num_rows($query_result)) {
                            echo "<a href='?offset=$next_amount'><p>Next -></p></a>";
                        }

                        if ($offset_amount > 0) {
                            echo "<a href='?offset=$previous_amount'><p><- Previous</p></a>";
                        }
                    }
                    ?>
                </div>
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