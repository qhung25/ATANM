<?php
// 1. Cấu hình kết nối Database (Dựa trên ảnh của bạn)
$servername = "localhost";
$username = "student13"; 
$password = "web@123"; 
$dbname = "sales_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("<p style='color:red'>Kết nối thất bại: " . $conn->connect_error . "</p>");
}

// 2. Lấy dữ liệu từ bảng sales
$sql = "SELECT * FROM sales";
$result = $conn->query($sql);

// 3. Danh sách thành viên nhóm (Bạn có thể sửa tên ở đây)
$members = [
    ["ten" => "Nguyễn Quốc Hùng", "vaitro" => "Nhóm trưởng", "mssv" => "21001234"],
    ["ten" => "Nguyễn Văn A", "vaitro" => "Backend", "mssv" => "21005678"],
    ["ten" => "Trần Thị B", "vaitro" => "Frontend", "mssv" => "21009999"],
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dự án Web Nhóm - Quản lý Bán hàng</title>
    <style>
        /* Tổng thể */
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1000px; margin: auto; }
        h2 { text-align: center; color: #1a73e8; text-transform: uppercase; margin-top: 40px; }

        /* CSS Thành viên (Flexbox) */
        .team-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-bottom: 50px; }
        .card { background: white; padding: 20px; border-radius: 15px; width: 220px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .avatar { width: 60px; height: 60px; background: #1a73e8; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 24px; font-weight: bold; }
        .name { font-weight: bold; font-size: 1.1em; margin-bottom: 5px; }
        .role { color: #666; font-size: 0.9em; margin-bottom: 10px; }
        .mssv { font-size: 0.8em; background: #e8f0fe; color: #1a73e8; padding: 3px 12px; border-radius: 20px; }

        /* CSS Bảng dữ liệu */
        .table-container { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1a73e8; color: white; text-align: left; padding: 12px; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover { background-color: #f8f9fa; }
        .status-ok { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Thành viên thực hiện</h2>
    <div class="team-grid">
        <?php foreach ($members as $m): ?>
            <div class="card">
                <div class="avatar"><?php echo mb_substr($m['ten'], 0, 1); ?></div>
                <div class="name"><?php echo $m['ten']; ?></div>
                <div class="role"><?php echo $m['vaitro']; ?></div>
                <span class="mssv"><?php echo $m['mssv']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <hr style="border: 0; height: 1px; background: #ddd; margin: 40px 0;">

    <h2>Dữ liệu doanh thu (từ Database)</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row["id"]; ?></td>
                            <td><strong><?php echo $row["product_name"]; ?></strong></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td><?php echo number_format($row["price"]); ?> VNĐ</td>
                            <td><span class="status-ok">● Đã bán</span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center; padding: 20px;">Chưa có dữ liệu nào trong bảng sales.</p>
        <?php endif; ?>
    </div>
</div>

<?php $conn->close(); // Đóng kết nối ?>
</body>
</html>