<?php
session_start();
if(isset($_SESSION['username'])) {
    header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Khung chứa cả 2 phần: Thông tin và Form đăng nhập */
        .login-wrapper {
            display: flex;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            max-width: 750px;
            width: 100%;
            overflow: hidden; /* Để bo góc không bị vỡ */
        }

        /* Phần bên trái: Ô chứa danh sách tài khoản */
        .info-box {
            flex: 1;
            background-color: #f4f7f6; /* Nền hơi xám nhạt để tạo điểm nhấn */
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 1px solid #e1e5ee;
        }

        .info-box h3 {
            color: #4a90e2;
            margin-bottom: 20px;
            font-size: 20px;
            text-align: center;
        }

        .info-box p {
            color: #555;
            font-size: 15px;
            margin-bottom: 12px;
            font-family: 'Courier New', Courier, monospace; /* Đổi font cho giống dạng code/tài khoản */
            background: #ffffff;
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px dashed #b8c2d1;
            text-align: center;
        }

        /* Phần bên phải: Form đăng nhập */
        .login-form {
            flex: 1;
            padding: 40px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
            font-size: 26px;
        }

        .login-form form {
            display: flex;
            flex-direction: column;
        }

        .login-form input {
            padding: 14px 15px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-form input:focus {
            border-color: #8ec5fc;
            box-shadow: 0 0 5px rgba(142, 197, 252, 0.5);
            outline: none;
        }

        .login-form button {
            padding: 14px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .login-form button:hover {
            background-color: #357abd;
        }

        .login-form button:active {
            transform: scale(0.98);
        }

        /* Responsive: Tự động rớt dòng khi xem trên màn hình nhỏ */
        @media (max-width: 650px) {
            .login-wrapper {
                flex-direction: column;
            }
            .info-box {
                border-right: none;
                border-bottom: 1px solid #e1e5ee;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="info-box">
            <h3>Tài khoản Test</h3>
            <p>hung - 123456</p>
            <p>viet - 456789</p>
            <p>nhi - 456789</p>
        </div>

        <div class="login-form">
            <h2>Đăng nhập</h2>
            <form action="login_process.php" method="POST">
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <button type="submit" name="login">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>