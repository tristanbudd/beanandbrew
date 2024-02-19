<?php
# Including connection information.
include("etc/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Lessons</title>

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
                <li><a href="shop.php">Pre-Order Coffee</a></li>
                <li><a href="bookings.php">Create Booking</a></li>
                <li>View Lessons<div class="nav-selected"></div></li>
            </ul>
        </nav>

        <nav class="mobile-nav">
            <ul class="nav-main-mobile">
                <li class="nav-deco">View Lessons<div class="nav-selected"></div></li>
                <li class="nav-deco"><a href="index.php">Home</a></li>
                <li class="nav-deco"><a href="shop.php">Pre-Order Coffee</a></li>
                <li class="nav-deco"><a href="bookings.php">Create Booking</a></li>
            </ul>
        </nav>
    </header>

    <div class="single-section">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <h2>View Lessons</h2>
                    <p>View all of our available lessons here:</p>

                    <?php
                        $query = "SELECT * FROM lessons";
                        $query_result = $conn->query($query);

                        if (mysqli_num_rows($query_result) == 0) {
                            echo "<br><br><h3>No Lessons Available, Try Again Later!</h3>";
                        } else {
                            $amount_found = strval(mysqli_num_rows($query_result));

                            $query = "SELECT SUM(available_spaces) FROM lessons";
                            $query_result = $conn->query($query);
                            $row = $query_result->fetch_row();
                            $spaces_available = $row[0];

                            echo "<p>($amount_found Lessons Found) ($spaces_available Spaces Available)</p>";

                            $offset_amount = $_GET['offset'] ?? 0;

                            $query = "SELECT * FROM lessons LIMIT 10 OFFSET $offset_amount";
                            $query_result = $conn->query($query);

                            foreach($query_result as $row) {
                                $id = $row["lesson_id"];
                                $title = $row["title"];
                                $description = $row["description"];
                                $date = $row["date"];
                                $duration = $row["duration"];
                                $available_spaces = $row["available_spaces"];

                                if ($available_spaces > 0) {
                                    echo("<a href='lesson_book.php?lesson_id=$id'><div class='lesson-block'>");
                                } else {
                                    echo("<div class='lesson-block-red'>");
                                }

                                echo("<h3>$title</h3>");
                                echo("<p>$description</p>");
                                echo("<p><b>Date:</b> $date</p>");
                                echo("<p><b>Duration:</b> $duration</p>");
                                echo("<p><b>Available Spaces:</b> $available_spaces</p>");

                                echo("</div></a>");
                            }

                            $query = "SELECT * FROM lessons";
                            $query_result = $conn->query($query);

                            if (strval(mysqli_num_rows($query_result)) > 10) {
                                $next_amount = $offset_amount + 10;
                                $previous_amount = $offset_amount - 10;
                                if ($offset_amount < mysqli_num_rows($query_result) - 1) {
                                    echo "<a href='?offset=$next_amount'><p>Next -></p></a>";
                                }

                                if ($offset_amount > 0) {
                                    echo "<a href='?offset=$previous_amount'><p><- Previous</p></a>";
                                }
                            }
                        }
                    ?>
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
