<?php
$host = "localhost";
$user = "root"; // Mặc định của XAMPP là root
$pass = "";     // Mặc định của XAMPP là rỗng
$dbname = "user1";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
?>