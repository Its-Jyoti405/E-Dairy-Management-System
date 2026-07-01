# 🥛 E-Dairy Management System

An online dairy management and shopping system developed using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. The system enables users to browse dairy products, place orders, manage their accounts, and allows administrators to manage products, customers, and orders through an admin dashboard.

---

## 📌 Features

### 👤 User Module
- User Registration and Login
- Browse Dairy Products
- Search Products
- Add Products to Cart
- Place Orders
- View Order History
- Contact Page

### 🔐 Admin Module
- Admin Login
- Dashboard
- Add, Update and Delete Products
- Manage Orders
- Manage Users
- View Customer Messages

---

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** XAMPP (Apache + MySQL)

---

## 📂 Project Structure

```
E-Dairy-Management-System/
│
├── css/
├── js/
├── images/
├── uploaded_img/
├── about.php
├── cart.php
├── checkout.php
├── config.php
├── contact.php
├── home.php
├── index.php
├── login.php
├── logout.php
├── orders.php
├── register.php
├── shop.php
├── shop_dbb.sql
└── README.md
```

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Its-Jyoti405/E-Dairy-Management-System.git
```

### 2. Move the project

Copy the project folder to:

```
C:\xampp\htdocs\
```

### 3. Create Database

Open **phpMyAdmin** and create a database:

```
shop_dbb
```

### 4. Import Database

Import the file:

```
shop_dbb.sql
```

### 5. Configure Database

Open:

```
config.php
```

Update the database connection if required:

```php
$conn = mysqli_connect("localhost","root","","shop_dbb",3307);
```

> If your MySQL runs on the default port, replace **3307** with **3306**.

### 6. Run the Project

Start **Apache** and **MySQL** using XAMPP.

Open:

```
http://localhost/E-Dairy-Management-System/
```

---

## 📸 Screenshots

You can add screenshots here.

Example:

```
Home Page

Login Page

Product Page

Shopping Cart

Admin Dashboard
```

---

## 🎯 Future Enhancements

- Online Payment Gateway
- Order Tracking
- Email Notifications
- Product Reviews & Ratings
- Inventory Management
- Sales Reports
- Responsive Mobile Design

---

## 👩‍💻 Author

**Jyoti Gavali**

- GitHub: https://github.com/Its-Jyoti405

---

## 📄 License

This project is created for educational and learning purposes.
