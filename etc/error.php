<?php
    if (isset($_GET['error_message'])) {
        $error_message = $_GET['error_message'];
    } else {
        $error_message = "Unknown";
    }

    if (isset($_GET['retry_url'])) {
        $retry_url = $_GET['retry_url'];
    } else {
        $retry_url = "../index.php";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bean & Brew - Error</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="google" content="nositelinkssearchbox">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Indulge in the rich flavors of coffee at Bean & Brew. Explore our wide range of coffee blends, brewing equipment, and accessories. Discover tools that elevate your coffee experience, making every sip a moment of joy.">
    <meta name="keywords" content="Bean & Brew, Coffee, Coffee Website, Coffee Blends, Brewing Equipment, Coffee Accessories, Coffee Flavors, Coffee Shop, Coffee Tools, Coffee Experience, Coffee Moments, Morning Delight, Coffee Lover, Coffee Recipes, Coffee Tips, Coffee Tasting, Coffee Brewing Techniques, Coffee Grinder, Coffee Maker, French Press, Espresso Machine, Coffee Beans, Coffee Filters, Coffee Mugs, Coffee Storage, Coffee Gadgets">
    <meta name="author" content="Tristan Budd">
    <meta name="copyright" content="Copyright © Bean & Brew (<?php echo(date("Y")) ?>)" />

    <meta name="apple-mobile-web-app-title" content="Bean & Brew">
    <meta name="application-name" content="Bean & Brew">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="theme-color" content="#000000">

    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="manifest" href="../favicons/site.webmanifest">
    <link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#000000">

    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
    <div class="error-page">
        <h1>Uh Oh! An Error Has Occurred</h1>
        <div class="error-spacer"></div>
        <p><?php echo($error_message) ?></p>
        <button type="button" onclick="window.location.href='<?php echo $retry_url; ?>'">Retry</button>
        <button type="button" onclick="window.location.href='../index.php'">Return To Home</button>
    </div>
</body>
</html>
