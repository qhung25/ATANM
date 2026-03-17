<?php
session_start();
// Kết nối DB
$conn = new mysqli("localhost", "root", "", "sales_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $result->fetch_assoc();
        header("Location: profile.php"); // Đăng nhập thành công thì chuyển hướng
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Nhóm 3</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .login-form { background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; }
        input { width: 100%; padding: 0.8rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 0.5rem; }
        .btn-submit { width: 100%; border: none; cursor: pointer; background: var(--primary-color); color: white; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Đăng Nhập</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>
    </div>
</body>
</html>