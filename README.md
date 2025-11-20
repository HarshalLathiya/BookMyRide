🚗 BookMyRide – Online Car Rental Management System

BookMyRide is a full-featured web-based car rental management system that allows users to browse cars, make bookings, and manage rentals online while providing admins with complete control over cars, bookings, customers, and reports.

🌐 Project Overview

BookMyRide is designed to simplify car rentals through an intuitive interface, secure authentication, dynamic pricing, and a powerful admin panel. Built with PHP + MySQL, it ensures fast performance, responsive UI, and smooth functionality across all devices.

🛠️ Tech Stack
Frontend

HTML5, CSS3, JavaScript

Bootstrap 5 (fully responsive)

Font Awesome Icons

Custom CSS for each page

Backend

PHP (Procedural)

MySQL (with MySQLi)

PHP Sessions for authentication

Secure password hashing (password_hash / password_verify)

✨ Key Features
👤 User Features

User Registration & Login

Role-based redirection (User / Admin)

Responsive home page with available cars

Car details and availability status

Full booking system with:

Pickup/Drop dates

Locations

Personal info

Payment method

Dynamic pricing calculation

First 3 days → base price

After 3 days → 10% discount

Real-time form validation

Password reset via email

Testimonials, Contact, Cars listing pages

🛡️ Admin Features

Admin Dashboard with statistics

Manage Cars (Add / View / Update)

Manage Bookings (All Bookings page)

Manage Users

Generate Reports

Role-based access (only admins allowed)

🗄️ Database Structure

Database: bookmyride

Tables:

users (admin + users)

cars

bookings

categories

payments

Includes major car models: Ertiga, Swift, Innova, Thar, Fortuner, etc.

📁 Project File Structure
/
│── index.php
│── booking.php
│── login.php
│── register.php
│── cars.php
│── contact.php
│── testimonials.php
│── db.php
│── bookmyride.sql
│
├── /admin
│   ├── dashboard_admin.php
│   ├── Add_car.php
│   ├── View_cars.php
│   ├── all_bookings.php
│   ├── customers.php
│   └── report.php
│
├── /assets
│   ├── /css (index.css, booking.css, admin.css)
│   └── /images
│
└── /includes
    ├── header.php
    └── footer.php

🔒 Security Implementations

Password hashing

Session-based authentication

Input sanitization

Admin restrictions

🚀 User Flow

User registers or logs in

Browses available cars

Selects & fills the booking form

JavaScript calculates rental cost

Booking submitted → stored in database

Admin manages bookings and cars

📦 How to Run Locally

Download or clone the repository

Start XAMPP → Apache + MySQL

Import bookmyride.sql into phpMyAdmin

Place project folder in:

htdocs/


Visit:

http://localhost/bookmyride/

📝 Author

Developed by Lathiya Harshal
IT Student | Full-Stack Learner | Freelance DeveDeveloper 

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
