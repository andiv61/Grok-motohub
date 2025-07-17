CREATE DATABASE racer_motorcycles;
USE racer_motorcycles;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    featured BOOLEAN DEFAULT 0
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, image, featured) VALUES
('Racer X1', 'Гоночный мотоцикл с двигателем 250cc', 4999.99, 'images/racer_x1.png', 1),
('Racer Z2', 'Спортивный мотоцикл для трека', 6499.99, 'images/racer_z2.png', 1),
('Racer Y3', 'Мотоцикл для начинающих гонщиков', 3999.99, 'images/racer_y3.png', 0);