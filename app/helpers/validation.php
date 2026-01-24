<?php

function isRequired($field) {
    return isset($field) && trim($field) !== '';
}

function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function minLength($field, $length) {
    return strlen(trim($field)) >= $length;
}

function maxLength($field, $length) {
    return strlen(trim($field)) <= $length;
}

function isMatch($field1, $field2) {
    return $field1 === $field2;
}

function isNumber($field) {
    return is_numeric($field);
}

function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function isValidDateTime($datetime) {
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
    return $d && $d->format('Y-m-d H:i:s') === $datetime;
}

function sanitize($field) {
    return htmlspecialchars(strip_tags(trim($field)));
}

function isValidPassword($password) {
    return minLength($password, 6);
}
?>
