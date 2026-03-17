-- XÓA DATABASE CŨ (nếu có)
DROP DATABASE IF EXISTS nhom_13;

-- TẠO DATABASE
CREATE DATABASE nhom_13 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE nhom_13;

-- Tạo bảng users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    role VARCHAR(50),
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu
INSERT INTO users (fullname, role, username, password) VALUES 
('Trương Vang Việt', 'Kỹ Thuật', 'vangviet', '123'),
('Đặng Quốc Hùng', 'Trưởng Nhóm', 'quochung', '456'),
('Bảo Nhi', 'Thiết Kế', 'baonhi', '789');