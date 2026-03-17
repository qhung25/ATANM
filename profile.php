<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <title>Thông tin cá nhân</title>
</head>
<body>
    <div class="header">
        <h1>Chào mừng, <?php echo $user['full_name']; ?>!</h1>
    </div>
    
    <div class="member-card" style="margin: 0 auto; max-width: 400px;">
        <div class="avatar-container">
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </div>
        <span class="member-role"><?php echo $user['role']; ?></span>
        <h2 class="member-name"><?php echo $user['full_name']; ?></h2>
        <p class="member-desc">MSSV: <?php echo $user['student_id']; ?></p>
        <p class="member-desc"><?php echo $user['description']; ?></p>
        <br>
        <a href="logout.php" style="color: red; text-decoration: none;">Đăng xuất</a>
    </div>
</body>
</html>