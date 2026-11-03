<?php
$conn = mysqli_connect("localhost", "root", "", "lutongbahay");
if (!$conn) {
    die("Database connection failed.");
}
session_start();

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
