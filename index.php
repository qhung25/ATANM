<?php
session_start();

// HIỂN THỊ LỖI (rất quan trọng khi debug)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kết nối database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "nhom_13";

$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Lỗi kết nối DB: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // tránh lỗi undefined
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // chống lỗi SQL cơ bản
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        echo "<script>alert('Chào mừng " . $row['fullname'] . "');</script>";
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>

<h2>ĐĂNG NHẬP</h2>

<?php if($error) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Tên đăng nhập"><br><br>
    <input type="password" name="password" placeholder="Mật khẩu"><br><br>
    <button type="submit">Đăng nhập</button>
</form>

</body>
</html>