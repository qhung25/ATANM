<?php
session_start();
require_once 'db.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

// Sửa dòng này:
$sql = "SELECT * FROM users1 WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

// Thêm đoạn này để kiểm tra lỗi nếu query thất bại
if (!$result) {
    die("Lỗi truy vấn SQL: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 1) {
    // ... code cũ của bạn ...

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        header("Location: profile.php");
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='index.php';</script>";
    }
}
}
?>