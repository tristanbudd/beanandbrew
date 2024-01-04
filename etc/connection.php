<?php
$error_amount = 0;
$error_message = "";

if (!file_exists("../settings.json")) {
    $error_message = "Error locating settings.json, If not setup go to /etc/installer.php";
    header("Location: error.php?error_message=$error_message&retry_url=index.php");
} else {
    $settings_data = file_get_contents("../settings.json");

    if ($settings_data === false) {
        $error_message = "Error fetching settings.json data. (Not Found)";
        $error_amount += 1;
    }

    if (filesize("../settings.json") == 0 or file_get_contents("../settings.json") == "") {
        $error_message = "Error fetching settings.json data. (File Empty)";
        $error_amount += 1;
    }

    $settings_json = json_decode($settings_data);

    if (!isset($settings_json->server_name) || !isset($settings_json->username) || !isset($settings_json->password) || !isset($settings_json->database_name)) {
        $error_message = "Error fetching settings.json data. (Invalid Contents)";
        $error_amount += 1;
    }

    if ($error_amount > 0) {
        header("Location: error.php?error_message=$error_message&retry_url=index.php");
    } else {
        echo("<p>Success</p>");
    }
}

?>