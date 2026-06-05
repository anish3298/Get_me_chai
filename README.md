# ChaiAdda ☕

A modern chai ordering website built with **HTML, CSS, JavaScript, PHP, and MySQL** for XAMPP.

## Folder structure

```text
Get_me_chai/
├── assets/
│   ├── css/style.css
│   ├── js/app.js
│   └── images/upi-qr.svg
├── config/db.php
├── database/chai_adda.sql
├── includes/
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── cart.php
├── checkout.php
├── history.php
├── index.php
├── login.php
├── logout.php
├── menu.php
├── payment.php
├── place_order.php
├── product.php
├── register.php
└── tracking.php
```

## Features

- Responsive Indian chai theme UI
- Home, menu, product, cart, checkout, payment and tracking pages
- Cart with `localStorage`
- Search and category filters
- Login / register with PHP + MySQL
- Order placement and history
- Payment UI with UPI QR + bank transfer
- Nearby chai shops, ratings, reviews and evening offers

## XAMPP setup

1. Copy the project into `C:/xampp/htdocs/Get_me_chai`.
2. Start **Apache** and **MySQL** from XAMPP Control Panel.
3. Open **phpMyAdmin** and import `database/chai_adda.sql`.
4. Visit:
   - `http://localhost/Get_me_chai/index.php`
   - `http://localhost/Get_me_chai/menu.php`

## Notes

- If MySQL is not connected yet, the UI still works in **demo mode** using fallback sample products.
- For GitHub Pages, only the frontend assets/pages can be reused; PHP/MySQL needs XAMPP or a live PHP host.
#Get_me_chai
# Get_me_chai
