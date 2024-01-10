<?php
$error_amount = 0;
$error_message = "";

if (!file_exists("settings.json")) {
    $error_message = "Error locating settings.json, If not setup go to /etc/installer.php";
    header("Location: etc/error.php?error_message=$error_message");
} else {
    $settings_data = file_get_contents("settings.json");

    if ($settings_data === false) {
        $error_message = "Error fetching settings.json data. (Not Found)";
        $error_amount += 1;
    }

    if (filesize("settings.json") == 0 or file_get_contents("settings.json") == "") {
        $error_message = "Error fetching settings.json data. (File Empty)";
        $error_amount += 1;
    }

    $settings_json = json_decode($settings_data);

    if (!isset($settings_json->server_name) || !isset($settings_json->username) || !isset($settings_json->password) || !isset($settings_json->database_name)) {
        $error_message = "Error fetching settings.json data. (Invalid Contents)";
        $error_amount += 1;
    }

    if ($error_amount > 0) {
        header("Location: etc/error.php?error_message=$error_message");
    } else {
        $conn = new mysqli($settings_json->server_name, $settings_json->username, $settings_json->password);

        if ($conn->connect_errno) {
            $error_message = "Failed to connect to MySQL: " . $conn->connect_error;
            header("Location: etc/error.php?error_message=" . urlencode($error_message));
            exit();
        }

        $database_name = $settings_json->database_name;
        $query = "CREATE DATABASE IF NOT EXISTS $database_name";

        if (!$conn->query($query) === TRUE) {
            $error_message = "Error creating database: " . $conn->error;
            header("Location: etc/error.php?error_message=$error_message");
            exit();
        }
    }
}

?>