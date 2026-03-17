-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 07:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30
CREATE DATABASE nhom_13;
USE nhom_13;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nhom_13`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

-- Tạo bảng thành viên
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    role VARCHAR(50),
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chèn dữ liệu 3 thành viên từ ảnh
INSERT INTO users (fullname, role, username, password) VALUES 
('Trương Vang Việt', 'Kỹ Thuật', 'vangviet', '123'),
('Quốc Hùng', 'Trưởng Nhóm', 'quochung', '456'),
('Bảo Nhi', 'Thiết Kế', 'baonhi', '789');