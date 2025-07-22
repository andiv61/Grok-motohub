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
  customer_id INTEGER,
  customer_name TEXT,
  customer_phone TEXT,
  status TEXT,
  source TEXT,
  created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE,
  password TEXT,
  role TEXT,
  reset_token TEXT,
  reset_expiry TEXT
);

CREATE TABLE IF NOT EXISTS customers (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  email TEXT UNIQUE,
  phone TEXT,
  type TEXT, -- 'retail' или 'wholesale'
  created_at TEXT DEFAULT (datetime('now'))
);

-- Удаляем существующего пользователя admin
DELETE FROM users WHERE email = 'admin@racer.ru';

-- Добавляем тестового администратора (email: admin@racer.ru, пароль: password)
INSERT INTO users (email, password, role) VALUES ('admin@racer.ru', '$2y$10$3mQ4ZwKg2hIg0SGOLP99EuhhC0J3tGuCrLvsDQuoMic8LcC8Rxg26', 'admin');

-- Добавляем тестовых клиентов
INSERT OR IGNORE INTO customers (name, email, phone, type) VALUES ('Иван Иванов', 'ivan@example.com', '+79991234567', 'retail');
INSERT OR IGNORE INTO customers (name, email, phone, type) VALUES ('ООО МотоТрейд', 'mototrade@example.com', '+79997654321', 'wholesale');