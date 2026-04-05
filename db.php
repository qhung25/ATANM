
<?php
// db chạy localhost, bên xamp.
$host = "localhost";
$user = "root"; 
$pass = "";     
$dbname = "user1";

// db chạy trên Proxmox, File Zilla
// $host = "your_proxmox_host";
// $user = "adminhung";
// $pass = "123456";
// $dbname = "users1";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
?>