<?php
session_start();
// Kết nối DB đúng tên database của nhóm
$conn = new mysqli("localhost", "root", "", "nhom3_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    // Tìm thành viên dựa trên Mã số sinh viên
    $sql = "SELECT * FROM members WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['user'] = $result->fetch_assoc();
        header("Location: profile.php"); // Đăng nhập thành công thì chuyển hướng
        exit();
    } else {
        $error = "Sai Mã số sinh viên! Vui lòng thử lại.";
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
        .login-form { background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; margin: 0 auto; text-align: center;}
        input { width: 100%; padding: 0.8rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 0.5rem; }
        .btn-submit { width: 100%; border: none; cursor: pointer; background: var(--primary-color); color: white; padding: 10px; border-radius: 5px; margin-top: 10px; font-weight: bold;}
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Đăng Nhập</h2>
        <?php if(isset($error)) echo "<p style='color:red; font-size: 0.9em;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="student_id" placeholder="Nhập Mã số sinh viên (VD: 4651050104)" required>
            <button type="submit" class="btn-submit">Đăng nhập vào Profile</button>
        </form>
    </div>
</body>
</html>