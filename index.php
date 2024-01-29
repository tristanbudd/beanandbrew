<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Home</title>

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
                <li>Home<div class="nav-selected"></div></li>
                <li><a href="shop.php">Pre-Order Coffee</a></li>
                <li><a href="bookings.php">Create Booking</a></li>
                <li><a href="lessons.php">View Lessons</a></li>
            </ul>
        </nav>

        <nav class="mobile-nav">
            <ul class="nav-main-mobile">
                <li class="nav-deco">Home<div class="nav-selected"></div></li>
                <li class="nav-deco"><a href="shop.php">Pre-Order Coffee</a></li>
                <li class="nav-deco"><a href="bookings.php">Create Booking</a></li>
                <li class="nav-deco"><a href="lessons.php">View Lessons</a></li>
            </ul>
        </nav>
    </header>

    <div class="single-section">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <img src="img/bean_and_brew_large.png" alt="Image of a cafe interior.">
                    <h2>Welcome to Bean & Brew!</h2>
                    <p>Life Is Hard. Coffee Makes It Better.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="double-section">
        <div class="container">
            <div class="double-section-row">
                <div class="double-section-column">
                    <img src="img/preorder_img.jpg" alt="Image of a cafe interior.">
                </div>
                <div class="double-section-column">
                    <h2>Pre-Order Coffee</h2>
                    <p>Here you can pre-order coffee that will be freshly prepared and waiting for you when you arrive at one of our three restaurant locations. Simply choose the items you are looking for, add to basket and then create an account to place your order.</p>
                    <br>
                    <button onclick="location.href='shop.php'">Pre-Order Coffee</button>
                </div>
            </div>
        </div>
    </div>

    <div class="double-section">
        <div class="container">
            <div class="double-section-row">
                <div class="double-section-column">
                    <img src="img/createbooking_img.jpg" alt="Image of a coffee machine.">
                </div>
                <div class="double-section-column">
                    <h2>Create Booking</h2>
                    <p>Here you will be able to create bookings to visit one of our three restaurant locations. If you want to reserve a space click the link below, enter some simple contact information and your time of arrival, and we will find you a place!</p>
                    <br>
                    <button onclick="location.href='bookings.php'">Create Booking</button>
                </div>
            </div>
        </div>
    </div>

    <div class="double-section">
        <div class="container">
            <div class="double-section-row">
                <div class="double-section-column">
                    <img src="img/viewlessons_img.jpg" alt="Image of a baker with dough on the table.">
                </div>
                <div class="double-section-column">
                    <h2>View Lessons</h2>
                    <p>Here you can pre-order coffee that will be freshly prepared and waiting for you when you arrive at one of our three restaurant locations. Simply choose the items you are looking for, add to basket and then create an account to place your order.</p>
                    <br>
                    <button onclick="location.href='lessons.php'">View Lessons</button>
                </div>
            </div>
        </div>
    </div>

    <div class="single-section">
        <div class="container">
            <div class="single-section-row">
                <div class="single-section-column">
                    <h2>Customer Dashboard</h2>
                    <p>Log In or Sign Up to access the Customer Dashboard.</p>
                    <br>
                    <button onclick="location.href='login.php'">Log In</button>
                    <button onclick="location.href='signup.php'">Sign Up</button>
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