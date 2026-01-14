# Clothify

### A Complete Women’s Clothing E-Commerce Web Application

Clothify is a fully functional e-commerce website developed for a women’s clothing brand using core PHP and MySQL. The project focuses on providing a smooth shopping experience for users while giving administrators full control over products and users through a dedicated admin panel.

This project was built as a practical implementation of web development concepts, combining frontend design with backend logic, database management, and authentication.

---

## Project Overview

The main goal of Clothify is to simulate a real online clothing store where customers can explore products and administrators can manage the store efficiently.

The system is divided into two major parts:

* **User Interface (Customer Side)**
* **Admin Panel (Management Side)**

Each part is secured, structured, and designed to reflect how real-world e-commerce platforms operate.

---

## User Side Features (Customer Experience)

The user side is designed to be simple, clean, and easy to navigate.

* User registration and login system
* Secure session-based authentication
* Browse women’s clothing products
* View detailed product information including images
* Add products to the shopping cart
* Smooth navigation between pages
* Clean and user-friendly interface

The focus is on ease of use so that users can browse products without confusion.

---

## Admin Panel Features (Store Management)

The admin panel allows full control over the website content.

* Add new products with images
* Update existing product details
* Delete products from the store
* View and manage registered users
* Organized admin dashboard
* Separate admin styling for clarity

Only authorized admins can access these features, ensuring security and proper management.

---

## Technologies Used

### Frontend

* HTML5
* CSS3

### Backend

* Core PHP

### Database

* MySQL

### Server Environment

* Apache Server
* XAMPP / WAMP

This project avoids frameworks to clearly demonstrate core PHP logic and database handling.

---

## Project Structure

```
Clothify/
│
├── admin/
│   ├── add_product.php
│   ├── edit_product.php
│   ├── update_product.php
│   ├── manage_users.php
│   ├── view_orders.php
│   ├── view_orders_items.php
│   ├── index.php
│   ├── admin.css
│   └── uploads/
│
├── api/
│
├── assets/
│   ├── css/
│   └── images/
│
├── config/
│   ├── db.php
│
├── controllers/
├── models/
│
├── views/
│   └── auth/
│   └── cart/
│   └── checkout/
│   └── confirmation/
│   └── include/
│   └── products/
│
├── index.php
└── README.md
```

This structure separates admin logic, user views, assets, and configuration files to keep the project organized and readable.

---

## Database Configuration

* The project uses **MySQL** as the database
* Database connection details are stored in `config.php`
* Tables include:

  * Users
  * Products
  * Carts

All CRUD operations are handled using PHP and SQL queries.

---

## Installation & Setup Guide

Follow these steps to run the project locally:

1. Install **XAMPP** or **WAMP**
2. Start **Apache** and **MySQL**
3. Copy the `Clothify` folder into:

   ```
   htdocs
   ```
4. Open **phpMyAdmin**
5. Create a database (example: `clothify_db`)
6. Import the provided SQL file (if available)
7. Update database credentials in `config.php`
8. Open your browser and go to:

   ```
   http://localhost/Clothify
   ```

---

## Admin Access

* Admin panel URL:

  ```
  http://localhost/Clothify/admin/index.php
  ```

---

## Security Considerations

* Session-based authentication
* Restricted admin access
* Basic input validation
* Controlled image upload directory

These measures help protect the application from unauthorized access.

---

## Future Improvements

This project can be enhanced further by adding:

* Online payment gateway
* Order placement and tracking system
* Product search and filtering
* Password hashing improvements
* Responsive mobile design
* Email notifications for users

---
