<?php
session_start();
include("etc/connection.php");
include("etc/validation.php");

if (isset($_SESSION['id'])) {
    header("Location: dashboard.php");
}

$error_message = NULL;
$errors_found = 0;

$display = array(
    'email' => '',
    'password' => ''
);

foreach($_POST as $key => $value) {
    if (isset($display[$key])) {
        $display[$key] = htmlspecialchars($value);
    }
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($_POST['email'] == "" or $_POST['password'] == "") {
        $error_message = "Please fill out all fields.";
        $errors_found++;
    }

    $email = clean_input($email);
    $password = clean_input($password);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
    if (!mysqli_num_rows($query_result) > 0) {
        $error_message = "No accounts under this email address exist, please ensure it is correct or sign up.";
        $errors_found++;
    }

    if ($errors_found == 0) {
        $row = mysqli_fetch_array($query_result);
        $hash = $row['password'];
        if (!password_verify($password, $hash)) {
            $error_message = "Password is invalid, please try again...";
            $errors_found++;
        }

        if ($errors_found == 0) {
            $display = array(
                'email' => '',
                'password' => ''
            );

            $query = "SELECT * FROM users WHERE email = '$email'";
            $query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
            if (mysqli_num_rows($query_result) > 0) {
                $query_result_table = mysqli_fetch_array($query_result);
                $_SESSION['id'] = $query_result_table['user_id'];
                header("location: dashboard.php");
            } else {
                echo "<script> alert('An error occurred obtaining your Session ID, please try again.'); </script>";
                header("location: login.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Log In</title>

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
        </ul>
    </nav>

    <nav class="mobile-nav">
        <ul class="nav-main-mobile">
            <button class="header-button" onclick="location.href='index.php'">Return To Homepage</button>
        </ul>
    </nav>
</header>

<div class="single-section">
    <div class="container">
        <div class="single-section-row">
            <div class="single-section-column">
                <h2>Log In</h2>
                <p>Log in to the Bean & Brew platform.</p>
                <br>
                <div class="login-form">
                    <form method="post" action="">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" type="text" name="email" id="email" placeholder="Enter Email..." value="<?php echo $display['email']; ?>">

                        <label class="form-label" for="password">Password</label>
                        <input class="form-input" type="password" name="password" id="password" placeholder="Enter Password..." value="<?php echo $display['password']; ?>">
                        <a id="password_view_text" onclick="toggle_view_password()">Show Password</a>

                        <br>

                        <div class="error-message">
                            <?php
                            if (!is_null($error_message)) {
                                echo("<label>$error_message</label>");
                            }
                            ?>
                        </div>

                        <button class="form-button" type="submit" value="submit">Log In</button>
                        <p>Don't have an account? Click <a href="signup.php">Here</a> to sign up.</p>
                    </form>
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