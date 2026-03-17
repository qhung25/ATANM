-- Tạo database (nếu chưa có) và sử dụng nó
CREATE DATABASE IF NOT EXISTS nhom13_db;
USE nhom13_db;

-- Tạo bảng lưu thông tin thành viên
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    mssv VARCHAR(20) NOT NULL,
    school_year VARCHAR(20) NOT NULL,
    bio TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Chèn dữ liệu của 3 thành viên vào bảng
INSERT INTO members (name, role, mssv, school_year, bio) VALUES
('Trương Vang Việt', 'Coder', '4651050319', 'Năm 3', 'Trương Vang Việt sở thích chơi game và thể thao. Đam mê cầu lông và chạy bộ. Một tuần thường dành thời gian chạy bộ để rèn luyện sức khỏe.'),
('Quốc Hùng', 'Trưởng Nhóm / Quản lý Dự án/Tester', '4651050104', 'Năm 3', 'Với vai trò là người dẫn dắt, Quốc Hùng đảm bảo mọi thành viên luôn đi đúng hướng. Anh có khả năng quản lý thời gian tuyệt vời và kỹ năng giải quyết vấn đề phức tạp một cách nhanh chóng.'),
('Bảo Nhi', 'Coder', '4651050187', 'Năm 3', 'Bảo Nhi là người tạo ra những giao diện người dùng tuyệt đẹp và trực quan, giúp trải nghiệm của khách hàng luôn ở mức cao nhất.');