<?php
$host = "localhost";
$user = "adminhung"; 
$pass = "123456";     
$dbname = "users1";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
?>