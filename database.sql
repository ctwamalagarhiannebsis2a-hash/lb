CREATE DATABASE IF NOT EXISTS lutongbahay;
USE lutongbahay;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status ENUM('pending','approved') NOT NULL DEFAULT 'pending',
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, status, role) VALUES
('admin', '$2b$12$MjxIhVoNLFlYAIHJsxDgR.LW.DIi/yMrEywpuLYyTWoMWjWmwUBIe', 'approved', 'admin');
