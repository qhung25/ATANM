<?php
session_start();
require_once 'db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Truy vấn lấy thông tin của Nhi từ bảng users1
$target_user = 'nhi'; 
$sql = "SELECT * FROM users1 WHERE username='$target_user'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    die("Không tìm thấy thông tin người dùng Nhi.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang của <?php echo $user['fullname']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   <style>
 * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    /* Giữ nguyên background gradient để đồng bộ tone màu với trang đăng nhập */
    background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.profile-card {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 500px; /* Rộng hơn form login một chút để chứa thông tin */
    color: #333;
}

.profile-card h1 {
    text-align: center;
    font-size: 26px;
    margin-bottom: 15px;
    color: #4a90e2; /* Tiêu đề màu xanh đồng bộ với nút đăng nhập */
}

.profile-card hr {
    border: 0;
    height: 1px;
    background: #eaeaea;
    margin: 20px 0;
}

.profile-card p {
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 12px;
}

.profile-card strong {
    color: #555;
    display: inline-block;
    width: 140px; /* Giúp các mục (Họ tên, Chuyên ngành...) căn lề thẳng hàng nhau */
}

.button-group {
    display: flex;       /* Kích hoạt flexbox */
    gap: 15px;          /* Tạo khoảng cách giữa 2 nút */
    margin-top: 25px;
    justify-content: center; /* Căn giữa 2 nút trong card */
}

.logout {
    display: block;
    width: 200px;
    text-align: center;
    padding: 14px;
    margin-top: 25px;
    background-color: #ff4757; /* Màu đỏ nổi bật cho hành động đăng xuất */
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.1s ease;
}

.logout:hover {
    background-color: #ff6b81;
}

.logout:active {
    transform: scale(0.98);
}
    </style>
</head>
<body>
    <div class="profile-card">
        <h1>Thông tin cá nhân</h1>
        <hr>
        <p><strong>Họ và tên:</strong> <?php echo $user['fullname']; ?></p>
        <p><strong>Tên đăng nhập:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Chuyên ngành:</strong> <?php echo $user['major']; ?></p>
        <p><strong>Giới thiệu:</strong> <?php echo $user['bio']; ?></p>
        <br>
        <div class="button-group">
            <a href="logout.php" class="logout">Đăng xuất</a>
            <a href="playfair.html" class="logout">Mã hóa</a>
        </div>
    </div>
</body>
</html>