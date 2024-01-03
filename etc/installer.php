<?php
if (!file_exists("../settings.json")) {
    touch("../settings.json");

    $settings_file = fopen("../settings.json", "w");

    $default_data = '{"server_name": "localhost", "username": "root", "password": "", "database_name": "bean_and_brew"}';
    fwrite($settings_file, $default_data);

    fclose($settings_file);
}
?>