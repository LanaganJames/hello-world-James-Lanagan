CREATE DATABASE IF NOT EXISTS shopdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode
USE shopdb;

CREATE TABLE if NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shu VARCHAR(32) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price_cents INT NOT NULL CHECK (price_cents >- 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);