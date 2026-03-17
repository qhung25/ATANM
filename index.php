<?php
session_start();

// 1. Cấu hình kết nối Database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "nhom_13"; // Tên database trong file SQL của bạn

$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = "";

// 2. Xử lý khi nhấn nút Đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];
        
        // Đăng nhập thành công
        echo "<script>alert('Chào mừng " . $row['fullname'] . " (" . $row['role'] . ")!');</script>";
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Hệ thống - Nhóm 13</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; }
        .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; }
        h2 { text-align: center; color: #333; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error { color: red; font-size: 14px; text-align: center; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>ĐĂNG NHẬP</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <div style="margin-top: 15px; font-size: 12px; color: #666;">
        <p>Gợi ý tài khoản test:</p>
        <ul>
            <li>quochung / 456 (Trưởng Nhóm)</li>
            <li>vangviet / 123 (Kỹ Thuật)</li>
            <li>baonhi / 789 (Thiết Kế)</li>
        </ul>
    </div>
</div>

</body>
</html>