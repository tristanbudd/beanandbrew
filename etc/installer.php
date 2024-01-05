<?php
if (file_exists("../settings.json")) {
    $error_message = "Installation already complete, to reset process delete settings.json";
    header("Location: error.php?error_message=$error_message");
}

$error_message = "This page is currently unavailable.";
header("Location: error.php?error_message=$error_message");

$connection_successful = false;

$errors_found = false;
$error_message = "";

$display = array(
    'server_name' => '',
    'username' => '',
    'password' => '',
    'database_name' => ''
);

if(isset($_POST['test_connection'])) {
    foreach($_POST as $key => $value) {
        if (isset($display[$key])) {
            $display[$key] = htmlspecialchars($value);
        }
    }

    if ($_POST['server_name'] == "" or $_POST['database_name'] == "") {
        $error_message = "Please fill out all fields.";
        $errors_found = true;
    } else {
        $server_name = $_POST['server_name'];
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";
        $database_name = $_POST['database_name'];

        $server_name = trim($server_name);
        $username = trim($username);
        $password = trim($password);
        $database_name = trim($database_name);

        $server_name = stripslashes($server_name);
        $username = stripslashes($username);
        $password = stripslashes($password);
        $database_name = stripslashes($database_name);

        $conn = mysqli_connect($server_name, $username, $password, $database_name);

        if ($conn->connect_errno) {
            $error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
            $errors_found = true;
            die("could not connect");
        } else {
            $query = "CREATE DATABASE IF NOT EXISTS ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $database_name);
            $stmt->execute();

            if ($stmt->error) {
                $error_message = "Error creating database: " . $stmt->error;
                $errors_found = true;
            } else {
                $display = array(
                    'server_name' => '',
                    'username' => '',
                    'password' => '',
                    'database_name' => ''
                );

                $error_message = "Database Connection Successful!";
                $errors_found = true;
                $connection_successful = true;
            }

            $stmt->close();
            $conn->close();
        }
    }
}

/*
touch("../settings.json");

$settings_file = fopen("../settings.json", "w");

$default_data = '{"server_name": "localhost", "username": "root", "password": "", "database_name": "bean_and_brew"}';
fwrite($settings_file, $default_data);

fclose($settings_file);
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Installer</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="google" content="nositelinkssearchbox">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Indulge in the rich flavors of coffee at Bean & Brew. Explore our wide range of coffee blends, brewing equipment, and accessories. Discover tools that elevate your coffee experience, making every sip a moment of joy.">
    <meta name="keywords" content="Bean & Brew, Coffee, Coffee Website, Coffee Blends, Brewing Equipment, Coffee Accessories, Coffee Flavors, Coffee Shop, Coffee Tools, Coffee Experience, Coffee Moments, Morning Delight, Coffee Lover, Coffee Recipes, Coffee Tips, Coffee Tasting, Coffee Brewing Techniques, Coffee Grinder, Coffee Maker, French Press, Espresso Machine, Coffee Beans, Coffee Filters, Coffee Mugs, Coffee Storage, Coffee Gadgets">
    <meta name="author" content="Tristan Budd">
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

    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    <form method="post" action="">
        <label>Server Name
            <input type="text" name="server_name" placeholder="localhost"/>
        </label>

        <label>Username
            <input type="text" name="username" placeholder="root"/>
        </label>

        <label>Password
            <input type="password" name="password" placeholder=""/>
        </label>

        <label>Database Name
            <input type="text" name="database_name" placeholder="bean_and_brew"/>
        </label>

        <button type="submit" name="test_connection">Test Connection</button>
        <button type="submit" name="test_connection">Clear Database</button>
        <button type="submit" name="submit">Submit</button>

        <?php
        if ($errors_found) {
            echo("<p class='error-message'>$error_message</p>");
        }
        ?>
    </form>
</body>
</html>
