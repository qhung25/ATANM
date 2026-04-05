<?php
session_start();
require_once 'db.php'; // Kết nối database

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Truy vấn lấy dữ liệu của 'viet'
$target_user = 'viet';
$sql = "SELECT * FROM users1 WHERE username='$target_user'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    $bio_parts = explode('.', $user['bio']);
    $birthday = isset($bio_parts[0]) ? trim($bio_parts[0]) : "Chưa cập nhật";
    $passion = isset($bio_parts[1]) ? trim($bio_parts[1]) : "";
    $location = isset($bio_parts[2]) ? trim($bio_parts[2]) : "";
    $hobbies = isset($bio_parts[3]) ? trim($bio_parts[3]) : "";
} else {
    die("Dữ liệu người dùng 'viet' không tồn tại.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo $user['fullname']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #ff7f50; /* Coral Orange */
            --secondary-color: #6c5ce7; /* Soft Purple */
            --danger-color: #d63031;
            --bg-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .cv-card {
            background: #ffffff;
            width: 100%;
            max-width: 900px;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: row-reverse; /* Đảo ngược sidebar sang phải */
            overflow: hidden;
        }

        .cv-sidebar {
            background-color: #2d3436;
            color: #dfe6e9;
            width: 320px;
            padding: 50px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 5px solid var(--primary-color);
        }

        .profile-img {
            width: 140px;
            height: 140px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px; /* Bo góc kiểu hiện đại thay vì hình tròn */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 60px;
            margin-bottom: 25px;
            transform: rotate(-5deg);
        }

        .cv-sidebar h2 { font-size: 22px; text-align: center; margin-bottom: 5px; color: #fff; }
        .cv-sidebar p.tagline { font-size: 14px; color: var(--primary-color); margin-bottom: 40px; font-weight: bold; }

        .contact-info { width: 100%; }
        .contact-item { 
            background: rgba(255,255,255,0.05);
            padding: 12px;
            border-radius: 10px;
            display: flex; 
            align-items: center; 
            gap: 12px; 
            margin-bottom: 15px; 
            font-size: 14px; 
        }
        .contact-item i { color: var(--primary-color); font-size: 18px; }

        .cv-main {
            flex: 1;
            padding: 60px;
            background: #fff;
            position: relative;
        }

        .section { margin-bottom: 40px; }
        .section-title {
            font-size: 20px;
            color: var(--secondary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::after {
            content: "";
            flex: 1;
            height: 2px;
            background: #f0f0f0;
        }

        .content-text { color: #2d3436; line-height: 1.8; font-size: 16px; }

        .action-group {
            margin-top: 20px;
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .btn-encrypt { background: var(--primary-color); color: white; box-shadow: 0 4px 15px rgba(255, 127, 80, 0.3); }
        .btn-encrypt:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(255, 127, 80, 0.5); }

        .btn-logout { border: 2px solid #ddd; color: #777; }
        .btn-logout:hover { background: var(--danger-color); color: white; border-color: var(--danger-color); }

        @media (max-width: 800px) {
            .cv-card { flex-direction: column; }
            .cv-sidebar { width: 100%; border-left: none; border-bottom: 5px solid var(--primary-color); }
        }
    </style>
</head>
<body>

<div class="cv-card">
    <!-- Sidebar đặt bên phải ở màn hình lớn -->
    <div class="cv-sidebar">
        <div class="profile-img"><i class="bi bi-person-bounding-box"></i></div>
        <h2><?php echo $user['fullname']; ?></h2>
        <p class="tagline"><?php echo $user['major']; ?></p>

        <div class="contact-info">
            <div class="contact-item"><i class="bi bi-balloon-heart"></i> <?php echo $birthday; ?></div>
            <div class="contact-item"><i class="bi bi-map"></i> <?php echo $location; ?></div>
            <div class="contact-item"><i class="bi bi-mailbox"></i> <?php echo $user['username']; ?>@gmail.com</div>
        </div>
    </div>

    <div class="cv-main">
        <div class="section">
            <h3 class="section-title"><i class="bi bi-stars"></i> Bản thân</h3>
            <p class="content-text"><?php echo $passion; ?>. Thích coi ytb khi ăn cơm và thích chơi game 1m khi rảnh.</p>
        </div>

        <div class="section">
            <h3 class="section-title"><i class="bi bi-cpu-fill"></i> Kỹ năng & Đam mê</h3>
            <p class="content-text"><?php echo $hobbies; ?>. Đam mê cầu lông được 2 năm thì bỏ, kỹ năng giao tiếp tốt (bóc phét).</p>
        </div>

        <div class="section">
            <h3 class="section-title"><i class="bi bi-award"></i> Học tập</h3>
            <p class="content-text">Hiện đang theo đuổi chuyên ngành mạng <strong><?php echo $user['major']; ?></strong> tại Đại học Công nghệ.</p>
        </div>

        <div class="action-group">
            <a href="mahoa_viet.php" class="btn btn-encrypt">
                <i class="bi bi-lock-fill"></i> Mã hóa tao đi
            </a>
            <a href="logout.php" class="btn btn-logout">
                <i class="bi bi-power"></i> Go out
            </a>
        </div>
    </div>
</div>

</body>
</html>