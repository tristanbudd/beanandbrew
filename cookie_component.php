<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="script.js"></script>
    </head>

    <body>
        <?php
        if (!isset($_COOKIE['cookie_notice'])) {
            echo("<div class='single-section' id='cookie_notice_window'>");
            echo("<div class='container'>");
            echo("<div class='single-section-row'>");
            echo("<div class='single-section-column'>");
            echo("<h2>Cookie Notice</h2>");
            echo("<p>Bean & Brew uses cookies to store data on your computer to improve your experience with the website.</p>");
            echo("<br>");
            echo("<button onclick='accept_cookies()'>Accept Cookies</button>");
            echo("<button onclick='decline_cookies()'>Decline Cookies</button>");
            echo("</div>");
            echo("</div>");
            echo("</div>");
            echo("</div>");
        }
        ?>
    </body>
</html>

