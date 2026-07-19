# OfficeHub

OfficeHub is a web-based **Office Equipment Shopping and Inventory Management System** developed using **PHP**, **MySQL**, **Bootstrap 5**, and **PHPMailer**. The system enables customers to browse and purchase office equipment while allowing administrators to manage products, inventory, users, and system activities through a secure dashboard.

🌐 **Live Website:**  
https://officehub-mark.infinityfreeapp.com

---

## ✨ Features

### Guest

- Home Page
- About Page
- User Registration
- Email Verification via Gmail SMTP
- Secure Login

### Buyer

- Browse Products
- Shopping Cart
- Checkout
- Cash on Delivery (COD)

### Administrator

- Dashboard
- Product Management (Add, Edit, Delete)
- User Management
- Inventory Management
- Audit Logs

---

## 🔒 Security Features

- Password Hashing using PHP `password_hash()`
- Password Verification using PHP `password_verify()`
- Session-Based Authentication
- Email Verification using PHPMailer and Gmail SMTP
- Unique Verification Tokens
- Role-Based Access Control (Admin and Buyer)

---

## 🛠️ Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- PHPMailer
- Composer
- XAMPP
- Git
- GitHub
- InfinityFree (Web Hosting)

---

## 📂 Project Structure

```text
OfficeHub/
├── admin/
├── assets/
├── auth/
├── buyer/
├── config/
├── database/
├── includes/
├── vendor/
├── about.php
├── index.php
├── composer.json
├── composer.lock
├── README.md
└── sample_accounts.txt
```

---

## 🚀 Installation

1. Clone or download this repository.
2. Copy the project folder into your XAMPP `htdocs` directory.
3. Import `database/officehub.sql` into MySQL using phpMyAdmin.
4. Configure the database connection in `config/database.php`.
5. Configure Gmail SMTP credentials in `config/mail.php`.
6. Start Apache and MySQL using XAMPP.
7. Open the project in your browser.

---

## 📄 Sample Accounts

Sample administrator and buyer accounts are provided in:

```text
sample_accounts.txt
```

> **Note:** Demo accounts on the hosted website are pre-verified for testing purposes. Newly registered users must verify their email before they can log in.

---

## 👨‍💻 Developer

**Mark Joshua Dayao**

Bachelor of Science in Information Technology

Far Eastern University – Institute of Technology

---

## 📌 Disclaimer

This project was developed for educational purposes as a course requirement in PHP Web Development.
