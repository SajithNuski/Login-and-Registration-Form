# 🔐 Login & Registration System (PHP + MySQL)

A simple and secure user authentication system built using PHP and MySQL. This project allows users to register, login, and manage sessions.

---

## 🚀 Features

- User Registration
- User Login
- Session Management
- Flash Messages (Success/Error)
- Password Protection
- Clean UI (HTML, CSS)

---

## 🛠️ Technologies Used

- PHP (Core PHP)
- MySQL (Database)
- HTML5 & CSS3
- JavaScript (optional for UI)

---

## 📁 Project Structure

project-folder/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── config/
│ └── database.php
├── assets/
│ ├── css/
│ └── js/
└── database/
└── database.sql
└── RADME.md

---

## ⚙️ Installation (Local Setup)

1. Install XAMPP or any local server
2. Move project folder to: htdocs/
3. Start Apache & MySQL
4. Open browser:

http://localhost/project-folder

---

## 🗄️ Database Setup

1. Go to:http://localhost/phpmyadmin
2. Create a new database (e.g. `login_system`)
3. Import:database/database.sql

---

## 🔧 Configuration

Update your database connection in:

```php
config/database.php

$host = "localhost";
$dbname = "login_system";
$username = "root";
$password = "";
```
