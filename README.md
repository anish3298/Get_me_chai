# ☕ Get Me Chai — Full-Stack Food Ordering Platform

**Get Me Chai** is a full-stack web-based food ordering platform that allows users to browse food items, manage their cart, place orders, and make online payments.

The application also includes an **Admin Dashboard** for managing menu items, customer orders, and user accounts.

Built using **HTML, CSS, JavaScript, PHP, and MySQL**.

---

## 🚀 Live Demo


🔗 **GitHub:** [Add your GitHub repository URL here]

---

## 📌 Features

### 👤 User Features

* User registration and login
* Secure session management
* Browse available food/menu items
* Add items to shopping cart
* Update cart items
* Remove items from cart
* Place food orders
* Online payment integration
* View order-related information

### 👨‍💼 Admin Features

* Admin authentication
* Admin dashboard
* Manage menu/food items
* Add new products
* Update product information
* Delete products
* Manage customer orders
* Manage user accounts
* Monitor order information

---

## 🛠️ Tech Stack

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL

### Payment

* Online Payment Gateway

### Development Tools

* Git
* GitHub
* VS Code
* XAMPP

---

## 🏗️ Application Architecture

```text id="u2k5g4"
                       ┌───────────────────┐
                       │       User        │
                       └─────────┬─────────┘
                                 │
                                 ▼
                       ┌───────────────────┐
                       │   Web Frontend    │
                       │ HTML/CSS/JS       │
                       └─────────┬─────────┘
                                 │
                                 ▼
                       ┌───────────────────┐
                       │   PHP Backend     │
                       │                   │
                       │ Authentication    │
                       │ Cart Management   │
                       │ Order Processing  │
                       └──────┬───────┬────┘
                              │       │
                 ┌────────────┘       └────────────┐
                 ▼                                 ▼
        ┌─────────────────┐              ┌─────────────────┐
        │     MySQL       │              │ Payment Gateway │
        │                 │              │                 │
        │ Users           │              │ Online Payment  │
        │ Products        │              │ Processing      │
        │ Orders          │              └─────────────────┘
        │ Other Data      │
        └─────────────────┘


                       ┌───────────────────┐
                       │      Admin        │
                       └─────────┬─────────┘
                                 │
                                 ▼
                       ┌───────────────────┐
                       │  Admin Dashboard  │
                       │                   │
                       │ Products          │
                       │ Orders            │
                       │ Users             │
                       └───────────────────┘
```

---

## 🔄 How It Works

### 1. User Registration / Login

Users can create an account and log in to access the food ordering functionality.

### 2. Browse Menu

Users can browse the available food/menu items.

### 3. Shopping Cart

Users can add food items to their cart and modify their selected items before placing an order.

### 4. Order Placement

After reviewing the cart, users can proceed with order placement.

### 5. Online Payment

The application integrates an online payment gateway to support digital payment for orders.

### 6. Order Management

Order-related information is stored in the MySQL database and can be managed through the Admin Dashboard.

### 7. Admin Management

Administrators can manage:

* Food/menu items
* Customer orders
* User accounts

---

## 🔐 Authentication & Session Management

The application implements user authentication and session management to control access to protected functionality.

```text id="u6q7m1"
                    Login
                      │
                      ▼
              ┌───────────────┐
              │ Authenticate  │
              │    User       │
              └───────┬───────┘
                      │
              ┌───────┴────────┐
              │                │
              ▼                ▼
           User             Admin
              │                │
              ▼                ▼
       Food Ordering      Admin Dashboard
              │                │
              ▼                ├── Manage Products
        Cart / Orders         ├── Manage Orders
                              └── Manage Users
```

---

## 🗄️ Database

MySQL is used as the primary database for storing application data.

The database manages information related to:

* Users
* Products / Menu Items
* Orders
* Cart-related data
* Payment/order information
* Other application-specific records

> Update this section with the exact table names from your database.

---

## 📂 Project Structure

> Update the structure below according to your actual repository.

```text id="7f9r0n"
Get-Me-Chai/
│
├── admin/
│   ├── dashboard.php
│   ├── products.php
│   ├── orders.php
│   └── users.php
│
├── user/
│   ├── cart.php
│   ├── orders.php
│   └── ...
│
├── css/
│   └── style.css
│
├── js/
│   └── script.js
│
├── images/
│   └── ...
│
├── config/
│   └── database.php
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── .gitignore
└── README.md
```

---

## ⚙️ Installation & Setup

### 1. Clone the Repository

```bash id="8cxv9n"
git clone YOUR_GITHUB_REPOSITORY_URL
```

### 2. Move Project to XAMPP

Copy the project into:

```text id="1w6b6r"
C:\xampp\htdocs\
```

Example:

```text id="0qv1jr"
C:\xampp\htdocs\Get-Me-Chai
```

### 3. Start XAMPP

Open XAMPP Control Panel and start:

```text id="2g7t5s"
Apache
MySQL
```

### 4. Create MySQL Database

Open:

```text id="s7k5y2"
http://localhost/phpmyadmin
```

Create a database for the project.

Example:

```text id="9w6d3p"
get_me_chai
```

### 5. Import Database

Import the project's SQL database file through phpMyAdmin.

```text id="x5q2p4"
phpMyAdmin
     ↓
Select Database
     ↓
Import
     ↓
database.sql
```

### 6. Configure Database Connection

Update your PHP database configuration.

Example:

```php id="0x7p9v"
$host = "localhost";
$username = "root";
$password = "";
$database = "get_me_chai";
```

> Use the actual database name and configuration used by your project.

### 7. Run the Application

Open the application in your browser:

```text id="m6g1ks"
http://localhost/Get-Me-Chai/
```

---

## 💳 Payment Integration

The application includes an online payment gateway for processing digital payments during order placement.

> If your implementation specifically uses **Razorpay**, replace this section with:

```text id="w3h8r1"
### Razorpay Integration

Razorpay is integrated into the application to enable online payments during the food ordering process.

Payment workflow:

User
 ↓
Cart
 ↓
Place Order
 ↓
Razorpay Checkout
 ↓
Payment
 ↓
Order Processing
```

---

## 📸 Screenshots

Add screenshots of the actual application here.

### 🏠 Home Page

```text id="9m2c4k"
[ Add Home Page Screenshot Here ]
```

### 🍔 Menu / Products

```text id="7k3v8p"
[ Add Menu Screenshot Here ]
```

### 🛒 Shopping Cart

```text id="q5n1s6"
[ Add Cart Screenshot Here ]
```

### 💳 Payment

```text id="v2d8m4"
[ Add Payment Screenshot Here ]
```

### 👨‍💼 Admin Dashboard

```text id="f8k2p7"
[ Add Admin Dashboard Screenshot Here ]
```

---

## 🎯 Key Learning Outcomes

Through this project, I gained practical experience in:

* Full-stack web application development
* PHP backend development
* MySQL database management
* CRUD operations
* User authentication
* Session management
* Shopping cart implementation
* Order management
* Payment gateway integration
* Admin dashboard development
* Database-driven application development
* Git and GitHub

---

## 🔮 Future Improvements

* Order tracking
* Email/SMS order notifications
* Product search and filtering
* Customer reviews and ratings
* Advanced admin analytics
* Coupon and discount system
* Order history improvements
* REST API integration
* Improved payment verification
* Mobile-first UI improvements

---

## 👨‍💻 Developer

### Anish Kumar Ojha

**Junior Software Developer | Full Stack Developer**

* GitHub:https://github.com/anish3298
* LinkedIn:https://www.linkedin.com/in/anish-kumar-ojha-6246a6269/

---

## 📄 License

This project was developed for learning and portfolio purposes.

