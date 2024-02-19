<?php
# Including connection information, validation and starting the session.
session_start();
include("etc/connection.php");
include("etc/validation.php");

# If Session ID is not set, redirect to the login page.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['id'];
}

$error_message = NULL;
$errors_found = 0;

# Saving data so that it's not lost on page refresh.
$display = array(
    'old_password' => '',
    'new_username' => ''
);

foreach($_POST as $key => $value) {
    if (isset($display[$key])) {
        $display[$key] = htmlspecialchars($value);
    }
}

if (!empty($_POST)) {
    $old_password = $_POST['old_password'];
    $new_username = $_POST['new_username'];

    # Collecting and validating the data from the form.
    if ($_POST['old_password'] == "" or $_POST['new_password'] == "" or $_POST['confirm_new_password'] == "") {
        $error_message = "Please fill out all fields.";
        $errors_found++;
    } elseif (check_length($new_username, 2, 32)) {
        $error_message = "Username must be 2 characters or more and less than 32 characters.";
        $errors_found++;
    } elseif (check_whitespace($new_username)) {
        $error_message = "No whitespace is allowed.";
        $errors_found++;
    } elseif (check_special_characters($new_username)) {
        $error_message = "No special characters are allowed in the username.";
        $errors_found++;
    }

    $old_password = clean_input($old_password);
    $new_username = clean_input($new_username);

    $query = "SELECT * FROM users WHERE user_id = '$id'";
    $query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
    if (!mysqli_num_rows($query_result) > 0) {
        echo("<script>alert('No accounts under this ID, Redirecting...')</script>");
        header("Location: login.php");
    }

    # If there are no errors, proceed to the next section.
    if ($errors_found == 0) {
        $display = array(
            'old_password' => '',
            'new_username' => ''
        );

        # Save the updated username to database.
        $query = "UPDATE users SET username = ? WHERE user_id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $new_username, $id);

        $stmt->execute();

        $stmt->close();

        header("Location: dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Change Username</title>

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
            <button class="header-button" onclick="location.href='dashboard.php'">Return To Dashboard</button>
        </ul>
    </nav>

    <nav class="mobile-nav">
        <ul class="nav-main-mobile">
            <button class="header-button" onclick="location.href='dashboard.php'">Return To Dashboard</button>
        </ul>
    </nav>
</header>

<div class="single-section">
    <div class="container">
        <div class="single-section-row">
            <div class="single-section-column">
                <h2>Change Username</h2>
                <p>Change the username to your Bean & Brew account.</p>
                <br>
                <div class="login-form">
                    <form method="post" action="">
                        <label class="form-label" for="old_password">Old Password</label>
                        <input class="form-input" type="password" name="old_password" id="old_password" placeholder="Enter Old Password..." value="<?php echo $display['old_password']; ?>">

                        <label class="form-label" for="new_username">New Username</label>
                        <input class="form-input" type="text" name="new_username" id="new_username" placeholder="Enter New Username..." value="<?php echo $display['new_username']; ?>">

                        <br>

                        <div class="error-message">
                            <?php
                            if (!is_null($error_message)) {
                                echo("<label>$error_message</label>");
                            }
                            ?>
                        </div>

                        <button class="form-button" type="submit" value="submit">Change Username</button>
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