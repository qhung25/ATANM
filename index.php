<?php
session_start();

// ==========================================
// 1. CẤU HÌNH KẾT NỐI DATABASE
// ==========================================
$host = '127.0.0.1'; // Chạy trên cùng server Proxmox
$dbname = 'nhom13_db';
$db_user = 'root';   // Đổi thành user MySQL trên server của bạn
$db_pass = 'web@123';       // Đổi thành mật khẩu MySQL trên server của bạn

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: Vui lòng kiểm tra lại cấu hình DB.");
}

// ==========================================
// 2. XỬ LÝ ĐĂNG NHẬP / ĐĂNG XUẤT
// ==========================================
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $member_id = $_POST['member_id'];

        // Kiểm tra tài khoản nhóm (student13 / kcntt)
        if ($username === 'student13' && $password === 'kcntt') {
            $_SESSION['logged_in'] = true;
            $_SESSION['member_id'] = $member_id;
        } else {
            $login_error = 'Sai tài khoản hoặc mật khẩu!';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'logout') {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

// ==========================================
// 3. TRUY XUẤT DỮ LIỆU
// ==========================================
// Lấy danh sách tất cả thành viên để hiển thị ở trang chủ
$stmt = $pdo->query("SELECT id, name, role FROM members");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nếu đã đăng nhập, lấy chi tiết thành viên đang xem
$current_member = null;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->execute([$_SESSION['member_id']]);
    $current_member = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống giới thiệu thành viên - Nhóm 13</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

    <?php if ($current_member): ?>
        
        <div id="auth-status-bar" style="display: flex;">
            <div class="status-indicator"></div>
            <span id="active-user-name"><?= htmlspecialchars($current_member['name']) ?></span>
        </div>

        <section id="view-profile" class="view-section active">
            <div class="profile-card">
                <div class="profile-header"></div>
                <div class="profile-body">
                    <div class="profile-avatar">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="var(--primary-color)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="profile-info">
                        <h2><?= htmlspecialchars($current_member['name']) ?></h2>
                        <span class="role"><?= htmlspecialchars($current_member['role']) ?></span>
                    </div>
                    
                    <div class="profile-stats">
                        <div class="stat-item">
                            <b><?= htmlspecialchars($current_member['mssv']) ?></b>
                            <span>MSSV</span>
                        </div>
                        <div class="stat-item">
                            <b><?= htmlspecialchars($current_member['school_year']) ?></b>
                            <span>Năm học</span>
                        </div>
                    </div>

                    <div style="text-align: left; margin: 0 3rem;">
                        <h3 style="font-size: 1rem; color: var(--primary-color); margin-bottom: 0.5rem; text-transform: uppercase;">Tiểu sử cá nhân</h3>
                        <p class="profile-bio"><?= nl2br(htmlspecialchars($current_member['bio'])) ?></p>
                    </div>

                    <div class="profile-actions" style="margin-top: 2rem;">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="logout">
                            <button type="submit" class="btn-back">Đăng xuất & Quay lại</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    <?php else: ?>

        <section id="view-list" class="view-section active">
            <div class="header">
                <h1>Thành Viên Nhóm 13</h1>
                <p>Sử dụng tài khoản được cấp để vào hệ thống</p>
            </div>

            <div class="team-container">
                <?php foreach ($members as $mem): ?>
                <div class="member-card">
                    <div class="avatar-box">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="var(--primary-color)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <span class="member-role"><?= htmlspecialchars($mem['role']) ?></span>
                    <h2 class="member-name"><?= htmlspecialchars($mem['name']) ?></h2>
                    <button class="btn-open-login" onclick="openLoginModal(<?= $mem['id'] ?>, '<?= addslashes($mem['name']) ?>')">Đăng nhập</button>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div id="login-modal" class="modal-overlay <?= !empty($login_error) ? 'active' : '' ?>">
            <div class="modal-content">
                <button class="close-modal" onclick="closeLoginModal()">&times;</button>
                <div style="text-align: center; margin-bottom: 20px;">
                    <h2 id="modal-title-name">Đăng nhập</h2>
                    <p style="color: var(--text-sub); font-size: 0.85rem;">Vui lòng nhập đúng thông tin tài khoản nhóm</p>
                </div>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="member_id" id="hidden-member-id" value="<?= isset($_POST['member_id']) ? htmlspecialchars($_POST['member_id']) : '' ?>">
                    
                    <div class="form-group">
                        <label>Tài khoản</label>
                        <input type="text" name="username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-submit-login">Vào hồ sơ</button>
                    
                    <?php if (!empty($login_error)): ?>
                        <p style="color: var(--error-color); font-size: 0.8rem; margin-top: 10px; text-align: center; font-weight: 600;">
                            <?= htmlspecialchars($login_error) ?>
                        </p>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <script>
            function openLoginModal(id, name) {
                document.getElementById('modal-title-name').innerText = `Đăng nhập cho ${name}`;
                document.getElementById('hidden-member-id').value = id;
                document.getElementById('login-modal').classList.add('active');
            }

            function closeLoginModal() {
                document.getElementById('login-modal').classList.remove('active');
            }
        </script>

    <?php endif; ?>

</body>
</html>