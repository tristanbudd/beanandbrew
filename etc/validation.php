<?php
function check_special_characters($value): bool {
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
        return true;
    } else {
        return false;
    }
}

function check_email($value): bool {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function check_length($value, $min, $max): bool {
    if (strlen($value) < $min or strlen($value) > $max) {
        return true;
    } else {
        return false;
    }
}

function check_whitespace($value): bool {
    if (preg_match("/^\s*$/",$value)) {
        return true;
    } else {
        return false;
    }
}

function clean_input($value) {
    $value = strip_tags($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $value = trim($value);

    return $value;
}