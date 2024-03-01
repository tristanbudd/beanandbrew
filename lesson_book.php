<?php
# Including connection information and starting the session.
session_start();
include("etc/connection.php");

# If Lesson ID is not set, redirect to the lessons page.
if (isset($_GET['lesson_id'])) {
    $lesson_id = $_GET['lesson_id'];
} else {
    header("Location: lessons.php");
}

# If Session ID is not set, redirect to the login page.
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['id'];
}

$query = "SELECT * FROM lessons WHERE lesson_id = '$lesson_id'";
$query_result = mysqli_query($conn , $query) or die("MySQL Error: " . mysqli_error($conn));
if (mysqli_num_rows($query_result) > 0) {
    $result_array = mysqli_fetch_array($query_result);
    $seats_available = $result_array['available_spaces'];
} else {
    header("Location: lessons.php");
}

$error_message = NULL;
$errors_found = 0;
$current_date = date('Y-m-d');
$booking_type = "Lesson";

$display = array(
    'seats' => 0,
);

foreach($_POST as $key => $value) {
    if (isset($display[$key])) {
        $display[$key] = htmlspecialchars($value);
    }
}

if (!empty($_POST)) {
    $seats = $_POST['seats'];
    $location = $_POST['location'];
    $booking_date = $_POST['date'];

    if ($_POST['seats'] == "" or $_POST['location'] == "default") {
        $error_message = "Please fill out all fields.";
        $errors_found++;
    } else if ($_POST['seats'] < 1 or $_POST['seats'] > $seats_available) {
        $error_message = "Seats must be more than 0 and less than the amount of spaces available for the lesson.";
        $errors_found++;
    } else if (!isset($_POST['date']) or $_POST['date'] < $current_date) {
        $error_message = "You must select a date in the future.";
        $errors_found++;
    }

    if ($errors_found == 0) {
        $display = array(
            'seats' => 0,
        );

        $query = "INSERT INTO bookings (booking_user_id, restaurant, seats, booking_date, booking_date_created, booking_type) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $user_id, $location, $seats, $booking_date, $current_date, $booking_type);

        $stmt->execute();

        $stmt->close();

        header("Location: lesson_book_successful.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Bookings</title>

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
                <br><br>
                <h2>Booking A Lesson</h2>
                <p>Please enter details to book this lesson.</p>
                <br>
                <?php
                $query = "SELECT * FROM lessons WHERE lesson_id = '$lesson_id'";
                $query_result = $conn->query($query);
                $row = mysqli_fetch_array($query_result);

                $title = $row["title"];
                $description = $row["description"];
                $date = $row["date"];
                $duration = $row["duration"];
                $available_spaces = $row["available_spaces"];

                echo("<div class='lesson-block'>");

                echo("<h3>$title</h3>");
                echo("<p>$description</p>");
                echo("<p><b>Date:</b> $date</p>");
                echo("<p><b>Duration:</b> $duration</p>");
                echo("<p><b>Available Spaces:</b> $available_spaces</p>");

                echo("</div></a>");
                ?>
                <br>
                <div class="login-form">
                    <form method="post" action="">
                        <label class="form-label" for="seats">How many spaces do you want?</label>
                        <input class="form-input" type="number" name="seats" id="seats" min="0" max="<?php echo $seats_available ?>" value="<?php echo $display['seats']; ?>">

                        <label class="form-label" for="location">At which restaurant location?</label>
                        <select class="form-input" name="location" id="location">
                            <option value="default">Please select an option...</option>
                            <option value="harrogate">Harrogate</option>
                            <option value="leeds">Leeds</option>
                            <option value="knaresboroughcastle">Knaresborough Castle</option>
                        </select>

                        <label class="form-label" for="date">What day do you want the lesson?</label>
                        <input class="form-input" type="date" name="date" id="date" min="<?php echo $current_date ?>">

                        <br>

                        <div class="error-message">
                            <?php
                            if (!is_null($error_message)) {
                                echo("<label>$error_message</label>");
                            }
                            ?>
                        </div>

                        <button class="form-button" type="submit" value="submit">Book Lesson</button>
                        <p>Not for you? Click <a href="lessons.php">Here</a> to choose a different lesson.</p>
                    </form>
                </div>
                <br><br>
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