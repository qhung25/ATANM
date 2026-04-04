<?php
session_start();
require_once 'db.php';

if (isset($_POST['login'])) {
    // Làm sạch dữ liệu đầu vào
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users1 WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn SQL: " . mysqli_error($conn));
    }

    // Nếu tìm thấy đúng 1 người dùng
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Lưu thông tin vào Session
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];

        // Lấy username để tạo tên file điều hướng
        // Ví dụ: username là 'nhi' sẽ chuyển đến 'nhi.php'
    // ... đoạn code lấy target_page ...
    $target_page = $user['username'] . ".php";

    if (file_exists($target_page)) {
        header("Location: " . $target_page);
    } else {
        // Nếu không có file riêng, báo lỗi thay vì về profile.php
        echo "<script>alert('Lỗi: Trang cá nhân của bạn chưa được khởi tạo!'); window.location='index.php';</script>";
    }
    exit(); // Luôn dùng exit sau header chuyển hướng
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='index.php';</script>";
    }
}
?>