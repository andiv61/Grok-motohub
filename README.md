Racer Motorcycles Admin Panel
Добро пожаловать в репозиторий админ-панели для стартапа по продаже мототехники и экипировки Racer! Этот проект создан для управления каталогом товаров, заказами, складскими остатками, интеграцией с маркетплейсами (Ozon, Wildberries) и аналитикой продаж. Админ-панель разработана с использованием бесплатных инструментов и ориентирована на простоту использования для начинающих.
Описание проекта
Админ-панель предназначена для автоматизации бизнес-процессов стартапа по продаже мототехники (мопеды, скутеры, мотоциклы, квадроциклы) и экипировки (шлемы) бренда Racer. Основной склад находится в г. Аксай, Ростовская область. Панель позволяет:

Управлять каталогом товаров (добавление, редактирование, удаление).
Обрабатывать заказы с сайта и маркетплейсов.
Вести учет складских остатков.
Интегрироваться с маркетплейсами (Ozon, Wildberries) для синхронизации товаров и заказов.
Импортировать/экспортировать данные в формате CSV.
Получать аналитику продаж и остатков.
Отправлять уведомления о заказах в Telegram.

Технологии

Бэкенд: PHP (для сервера и API).
Фронтенд: HTML, CSS (Bootstrap 5), JavaScript (Axios, Chart.js).
База данных: SQLite (простая и бесплатная).
Интеграции:
Ozon API (выгрузка товаров, импорт заказов).
Telegram Bot API (уведомления).


Хостинг: Render.com (бесплатный тариф) или локальный сервер (XAMPP).
Инструменты: Visual Studio Code, Git, GitHub.

Структура проекта
racer-motorcycles/
├── admin/
│   ├── login.php          # Форма входа в админ-панель
│   ├── dashboard.php      # Дашборд с ключевыми метриками
│   ├── products.php       # Управление каталогом товаров
│   ├── orders.php         # Управление заказами
│   ├── stock.php          # Управление складом
│   ├── analytics.php      # Аналитика продаж и остатков
│   ├── marketplaces.php   # Интеграция с маркетплейсами
│   └── telegram.php       # Настройка уведомлений в Telegram
├── includes/
│   ├── db.php             # Подключение к базе данных
│   ├── header.php         # Общий заголовок для админ-страниц
│   └── footer.php         # Общий футер для админ-страниц
├── css/
│   └── styles.css         # Пользовательские стили
├── js/
│   └── script.js          # Логика фронтенда (графики, AJAX)
├── images/
│   └── placeholder.png    # Заглушка для изображений
├── utils/
│   ├── import_csv.php     # Импорт товаров из CSV
│   └── export_csv.php     # Экспорт товаров в CSV
├── index.php              # Главная страница (редирект на админку или клиентский сайт)
├── .gitignore             # Игнорируемые файлы (например, database.db)
├── README.md              # Этот файл
└── database.sql           # Схема базы данных

Установка
Требования

Компьютер с Windows, macOS или Linux.
Установленные программы:
XAMPP (для локального сервера с PHP и Apache).
Visual Studio Code (редактор кода).
Git (для работы с репозиторием).


Аккаунт на GitHub.
Telegram-бот (токен и chat_id).
API-ключ Ozon (опционально, для интеграции).

Шаги установки

Клонируйте репозиторий:
git clone https://github.com/andiv61/Grok-motohub.git
cd racer-motorcycles


Установите XAMPP:

Скачайте и установите XAMPP.
Запустите Apache и убедитесь, что он работает (откройте http://localhost в браузере).


Разместите проект:

Скопируйте папку racer-motorcycles в C:\xampp\htdocs (Windows) или /opt/lampp/htdocs (Linux).
Откройте http://localhost/racer-motorcycles в браузере.


Настройте базу данных:

Создайте базу данных SQLite:
Скопируйте database.sql в db/racer.db.
Выполните команды из database.sql с помощью SQLite (например, через sqlite3 db/racer.db < database.sql).


Настройте подключение в includes/db.php (укажите путь к db/racer.db).


Настройте Telegram:

Создайте бота через @BotFather в Telegram, получите токен.
Найдите ваш chat_id через @userinfobot.
Обновите admin/telegram.php с вашим токеном и chat_id.


Настройте Ozon (опционально):

Зарегистрируйтесь на seller.ozon.ru.
Получите API-ключ и добавьте его в admin/marketplaces.php.


Запустите проект:

Откройте http://localhost/racer-motorcycles/admin/login.php.
Войдите с тестовыми данными (например, логин: admin, пароль: password).



Использование

Вход:

Перейдите на admin/login.php.
Используйте учетные данные администратора.


Управление товарами (admin/products.php):

Добавляйте, редактируйте или удаляйте товары (мопеды, шлемы).
Импортируйте товары из CSV через utils/import_csv.php.
Экспортируйте товары в CSV через utils/export_csv.php.


Управление заказами (admin/orders.php):

Просматривайте и обновляйте статусы заказов (новый, в обработке, отправлен).
Заказы с маркетплейсов импортируются автоматически.


Склад (admin/stock.php):

Проверяйте остатки товаров.
Получайте уведомления о низких запасах (<3 шт. для техники, <10 шт. для шлемов).


Аналитика (admin/analytics.php):

Просматривайте графики продаж по категориям и регионам.
Экспортируйте отчеты в CSV.


Маркетплейсы (admin/marketplaces.php):

Выгружайте товары на Ozon.
Импортируйте заказы с маркетплейсов.


Уведомления (admin/telegram.php):

Получайте уведомления о новых заказах в Telegram.



База данных
Схема базы данных описана в database.sql:
CREATE TABLE products (
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

CREATE TABLE orders (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER,
  quantity INTEGER,
  customer_name TEXT,
  customer_phone TEXT,
  status TEXT,
  source TEXT,
  created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT UNIQUE,
  password TEXT,
  role TEXT
);

Развертывание на хостинг

Render.com (бесплатный тариф):

Создайте аккаунт на render.com.
Подключите репозиторий https://github.com/andiv61/Grok-motohub.
Настройте переменные окружения:
PHP_VERSION=8.1
TELEGRAM_BOT_TOKEN=ваш_токен
TELEGRAM_CHAT_ID=ваш_chat_id
OZON_API_KEY=ваш_ключ


Разверните проект.


Проверка:

Откройте URL, предоставленный Render (например, https://grok-motohub.onrender.com/admin/login.php).



Требования к разработке

Для новичков:

Изучите основы PHP на YouTube ("PHP за час", канал "Фрилансер по жизни").
Пройдите уроки по Bootstrap и Chart.js на freeCodeCamp.
Используйте документацию:
PHP
SQLite
Ozon API
Telegram Bot API




Тестирование:

Проверьте добавление товаров, заказов, импорт/экспорт CSV.
Убедитесь, что уведомления в Telegram работают.
Протестируйте выгрузку товаров на Ozon.



Известные ограничения

SQLite используется для простоты, но для больших объемов данных (>1000 заказов/мес) рекомендуется перейти на MySQL.
Интеграция с Wildberries не реализована (добавить позже через API).
Нет поддержки изображений товаров (можно добавить в будущем).

Контакты
Для вопросов и поддержки:

Telegram: @andiv61 (замените на ваш контакт).
GitHub Issues: Создать issue.

Лицензия
MIT License. См. файл LICENSE (добавить, если требуется).
# Grok MotoHub
Сайт для продажи мотоциклов с админкой.

## Установка
1. Установите Node.js.
2. Выполните npm install.
3. Запустите npm start.

## Использование
- Откройте http://localhost:3000/admin/products.html для админки.