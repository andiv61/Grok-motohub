CREATE TABLE IF NOT EXISTS products (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  article TEXT UNIQUE,
  dealer_price REAL,
  retail_price REAL,
  stock INTEGER,
  category TEXT,
  description TEXT,
  created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS orders (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER,
  quantity INTEGER,
  customer_name TEXT,
  customer_phone TEXT,
  status TEXT,
  source TEXT,
  created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT UNIQUE,
  password TEXT,
  role TEXT
);

-- Удаляем существующего пользователя admin, если он есть
DELETE FROM users WHERE username = 'admin';

-- Добавляем тестового пользователя (admin:password)
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$nT5vmJMKSKjpg4KefpSI/.spMlf3Qrp4UykvEBqP5AQi073dueJ4W', 'admin');