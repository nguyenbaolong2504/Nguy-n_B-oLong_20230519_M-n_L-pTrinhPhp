CREATE DATABASE lab11 CHARACTER SET utf8mb4;
USE lab11;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    status TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO categories (name, slug, description, status) VALUES
('Điện thoại', 'dien-thoai', 'Danh mục điện thoại', 1),
('Laptop', 'laptop', 'Danh mục laptop', 1),
('Phụ kiện', 'phu-kien', 'Danh mục phụ kiện', 1),
('Tablet', 'tablet', 'Danh mục máy tính bảng', 1),
('Âm thanh', 'am-thanh', 'Danh mục thiết bị âm thanh', 0);
