<?php
// Kết nối DB nhom3_db
$conn = new mysqli("localhost", "root", "", "nhom3_db");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách thành viên
$sql = "SELECT * FROM members";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Giới thiệu thành viên nhóm 3</title>
</head>
<body>

    <div class="header">
        <h1>Thành Viên Nhóm 3</h1>
        <p>Đăng nhập để xem thông tin</p>
    </div>

    <div class="team-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="member-card">
                <div class="avatar-container">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <span class="member-role"><?php echo htmlspecialchars($row['position']); ?></span>
                <h2 class="member-name"><?php echo htmlspecialchars($row['fullname']); ?></h2>
                <p class="member-desc"><?php echo htmlspecialchars($row['sub_role']); ?></p>
                <p class="member-desc">MSSV: <?php echo htmlspecialchars($row['student_id']); ?></p>
                <a href="login.php" class="btn-contact">Đăng nhập</a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có dữ liệu thành viên.</p>
        <?php endif; ?>
    </div>

</body>
</html>