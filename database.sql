CREATE DATABASE IF NOT EXISTS grok_motohub;
USE grok_motohub;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(50),
    featured BOOLEAN DEFAULT 0
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, image, category, featured) VALUES
('Racer X1', 'Гоночный мотоцикл с двигателем 250cc', 4999.99, 'images/racer_x1.png', 'Спортивные', 1),
('Racer Z2', 'Спортивный мотоцикл для трека', 6499.99, 'images/racer_z2.png', 'Спортивные', 1),
('Racer Y3', 'Мотоцикл для начинающих гонщиков', 3999.99, 'images/racer_y3.png', 'Классические', 0),
('Tourer T1', 'Комфортный мотоцикл для дальних поездок', 7999.99, 'images/tourer_t1.png', 'Туристические', 0);