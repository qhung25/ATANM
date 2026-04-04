<?php
session_start();
require_once 'db.php'; // Kết nối database

// Kiểm tra quyền truy cập: Nếu chưa đăng nhập hoặc không phải Hùng thì xử lý
// Ở đây mình cho phép mọi user đã đăng nhập đều xem được CV này, 
// nhưng dữ liệu sẽ lấy đúng của user 'hung' từ DB
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Truy vấn lấy dữ liệu của 'hung'
$target_user = 'hung';
$sql = "SELECT * FROM users1 WHERE username='$target_user'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Tách chuỗi bio để hiển thị đẹp hơn (dựa trên dấu chấm trong database)
    // Cột bio hiện tại: "Ngày sinh 25/05/2005.Đam mê công nghệ..."
    $bio_parts = explode('.', $user['bio']);
    $birthday = isset($bio_parts[0]) ? trim($bio_parts[0]) : "Chưa cập nhật";
    $passion = isset($bio_parts[1]) ? trim($bio_parts[1]) : "";
    $location = isset($bio_parts[2]) ? trim($bio_parts[2]) : "";
    $hobbies = isset($bio_parts[3]) ? trim($bio_parts[3]) : "";
} else {
    die("Dữ liệu người dùng không tồn tại trong hệ thống.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional CV - <?php echo $user['fullname']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #2ed573;
            --danger-color: #ff4757;
            --bg-gradient: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
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
            max-width: 850px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            display: flex;
            overflow: hidden;
        }

        /* Sidebar trái */
        .cv-sidebar {
            background-color: #2c3e50;
            color: #ecf0f1;
            width: 300px;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            margin-bottom: 20px;
            border: 4px solid rgba(255,255,255,0.1);
        }

        .cv-sidebar h2 { font-size: 20px; text-align: center; margin-bottom: 5px; }
        .cv-sidebar p.tagline { font-size: 14px; opacity: 0.7; margin-bottom: 30px; }

        .contact-info { width: 100%; }
        .contact-item { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; font-size: 13px; }
        .contact-item i { color: var(--primary-color); font-size: 16px; }

        /* Nội dung chính bên phải */
        .cv-main {
            flex: 1;
            padding: 50px;
            background: #fff;
            position: relative;
        }

        .section { margin-bottom: 35px; }
        .section-title {
            font-size: 18px;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .content-text { color: #555; line-height: 1.7; font-size: 15px; }

        /* Nút bấm */
        .action-group {
            position: absolute;
            bottom: 40px;
            right: 50px;
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-encrypt { background: var(--secondary-color); color: white; }
        .btn-encrypt:hover { background: #26af5f; transform: scale(1.05); }

        .btn-logout { background: var(--danger-color); color: white; }
        .btn-logout:hover { background: #e04050; transform: scale(1.05); }

        @media (max-width: 700px) {
            .cv-card { flex-direction: column; }
            .cv-sidebar { width: 100%; }
            .action-group { position: static; margin-top: 30px; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="cv-card">
    <div class="cv-sidebar">
        <div class="profile-img"><i class="bi bi-person-fill"></i></div>
        <h2><?php echo $user['fullname']; ?></h2>
        <p class="tagline"><?php echo $user['major']; ?></p>

        <div class="contact-info">
            <div class="contact-item"><i class="bi bi-calendar3"></i> <?php echo $birthday; ?></div>
            <div class="contact-item"><i class="bi bi-geo-alt-fill"></i> <?php echo $location; ?></div>
            <div class="contact-item"><i class="bi bi-envelope-fill"></i> <?php echo $user['username']; ?>@gmail.com</div>
        </div>
    </div>

    <div class="cv-main">
        <div class="section">
            <h3 class="section-title"><i class="bi bi-info-circle-fill"></i> Giới thiệu</h3>
            <p class="content-text"><?php echo $passion; ?>. Hiện tại, tôi đang học tập và phát triển kỹ năng tại chuyên ngành <?php echo $user['major']; ?>.</p>
        </div>

        <div class="section">
            <h3 class="section-title"><i class="bi bi-controller"></i> Sở thích & Hoạt động</h3>
            <p class="content-text"><?php echo $hobbies; ?>. Đây là những hoạt động giúp tôi cân bằng cuộc sống và nạp lại năng lượng sau giờ học.</p>
        </div>

        <div class="section">
            <h3 class="section-title"><i class="bi bi-mortarboard-fill"></i> Học vấn</h3>
            <p class="content-text">Sinh viên ngành Công nghệ thông tin - Chuyên ngành Mạng máy tính.</p>
        </div>

        <div class="action-group">
            <a href="mahoa_Hung.php" class="btn btn-encrypt">
                <i class="bi bi-shield-lock"></i> Mã hóa
            </a>
            <a href="logout.php" class="btn btn-logout">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </div>
    </div>
</div>

</body>
</html>