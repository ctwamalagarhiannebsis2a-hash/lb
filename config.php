<?php
// Database connection (XAMPP defaults: user "root", empty password)
$conn = mysqli_connect("localhost", "root", "", "lutongbahay");
if (!$conn) {
    die("Database connection failed.");
}
session_start();

// Escape text before printing it in HTML
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
