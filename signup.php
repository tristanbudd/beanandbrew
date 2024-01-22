<?php
session_start();
include("etc/connection.php");
include("etc/validation.php");

$error_message = NULL;
$errors_found = 0;

$display = array(
    'username' => '',
    'email' => '',
    'password' => ''
);

foreach($_POST as $key => $value) {
    if (isset($display[$key])) {
        $display[$key] = htmlspecialchars($value);
    }
}

if (!empty($_POST)) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($_POST['username'] == "" or $_POST['email'] == "" or $_POST['password'] == "") {
        $error_message = "Please fill out all fields.";
        $errors_found++;
    } elseif (check_length($username, 3, 32)) {
        $error_message = "Username must be 3 characters or more and less than 32 characters.";
        $errors_found++;
    } elseif (check_length($email, 3, 128)) {
        $error_message = "Email must be 3 characters or more and less than 128 characters.";
        $errors_found++;
    } elseif (check_whitespace($username) or check_whitespace($email) or check_whitespace($password)) {
        $error_message = "No whitespace is allowed.";
        $errors_found++;
    } elseif (check_email($email)) {
        $error_message = "Please enter a valid email address.";
        $errors_found++;
    } elseif (check_special_characters($username)) {
        $error_message = "No special characters are allowed in the username.";
        $errors_found++;
    } elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",$password)) {
        $error_message = "Password must be 8 or more characters, a mix of uppercase and lowercase characters, a number and a special symbol.";
        $errors_found++;
    } elseif ($password != $confirm_password) {
        $error_message = "The Confirmation Password must match with your Password, Please try again.";
        $errors_found++;
    }

    $username = clean_input($username);
    $email = clean_input($email);
    $password = clean_input($password);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
    if (mysqli_num_rows($query_result) > 0) {
        $error_message = "An account under this email already exists, please try another or sign in.";
        $errors_found++;
    }

    if ($errors_found == 0) {
        $display = array(
            'username' => '',
            'email' => '',
            'password' => ''
        );

        $account_created = date('Y-m-d H:i:s');

        $hash_options = [
            'cost' => 12
        ];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $hash_options);

        $query = "INSERT INTO users (username, email, password, account_created) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $account_created);

        $stmt->execute();

        $stmt->close();

        $query = "SELECT * FROM users WHERE email = '$email'";
        $query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
        if (mysqli_num_rows($query_result) > 0) {
            $query_result_table = mysqli_fetch_array($query_result);
            $_SESSION['id'] = $query_result_table['id'];
            header("location: dashboard.php");
        } else {
            echo "<script> alert('An error occurred obtaining your Session ID, redirecting to the login page.'); </script>";
            header("location: login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Sign Up</title>

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
            <li><a href="lessons.php">View Lessons</a></li>
        </ul>
    </nav>

    <nav class="mobile-nav">
        <ul class="nav-main-mobile">
            <li class="nav-deco"><a href="index.php">Home</a></li>
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
                <h2>Sign Up</h2>
                <p>Create an account for Bean & Brew for free.</p>
                <br>
                <div class="login-form">
                    <form method="post" action="">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-input" type="text" name="username" id="username" maxlength="24" placeholder="Enter Username..." value="<?php echo $display['username']; ?>">

                        <div class="username_check" id="username_check">
                            <br>
                            <p class="form-label">Username must contain the following:</p>
                            <p id="username3" class="form-label invalid">Must be more than <b>2 characters</b></p>
                            <p id="username32" class="form-label invalid">Must be less than <b>32 characters</b></p>
                            <br>
                        </div>

                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" type="text" name="email" id="email" maxlength="64" placeholder="Enter Email..." value="<?php echo $display['email']; ?>">

                        <div class="email_check" id="email_check">
                            <br>
                            <p class="form-label">Email must contain the following:</p>
                            <p id="valid_email" class="form-label invalid">A <b>valid email address</b></p>
                            <p id="email3" class="form-label invalid">Must be more than <b>2 characters</b></p>
                            <p id="email128" class="form-label invalid">Must be less than <b>128 characters</b></p>
                            <br>
                        </div>

                        <label class="form-label" for="password">Password</label>
                        <input class="form-input" type="password" name="password" id="password" maxlength="64" placeholder="Enter Password..." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[#?!@$%^&*-]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, a special symbol, and at least 8 or more characters." value="<?php echo $display['password']; ?>">

                        <div class="password_check" id="password_check">
                            <br>
                            <p class="form-label">Password must contain the following:</p>
                            <p id="letter" class="form-label invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="form-label invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="form-label invalid">A <b>number</b></p>
                            <p id="symbol" class="form-label invalid">A <b>special symbol</b></p>
                            <p id="length" class="form-label invalid">Minimum <b>8 characters</b></p>
                            <br>
                        </div>

                        <label class="form-label" for="password">Confirm Password</label>
                        <input class="form-input" type="password" name="confirm_password" id="confirm_password" maxlength="64" placeholder="Enter Password Confirmation...">

                        <div class="password_confirm_check" id="password_confirm_check">
                            <br>
                            <p class="form-label">Password must contain the following:</p>
                            <p id="matching" class="form-label invalid">A <b>matching password</b></p>
                            <br>
                        </div>

                        <br>

                        <div class="error-message">
                            <?php
                            if (!is_null($error_message)) {
                                echo("<label>$error_message</label>");
                            }
                            ?>
                        </div>

                        <button class="form-button" type="submit" value="submit">Sign Up</button>
                        <p>Already have an account? Click <a href="login.php">Here</a> to log in.</p>
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