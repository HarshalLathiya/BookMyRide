# 🚗 **BookMyRide – Online Car Rental Management System**

*A modern PHP + MySQL web platform for seamless car rentals.*

<p align="center">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black">
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge">

</p>

---

## 🚀 **Overview**

**BookMyRide** is a complete car rental management system built for both **customers** and **administrators**.
It provides smooth car browsing, quick bookings, dynamic pricing, secure authentication, and full backend control.

The project focuses on clean UI, responsive design, and secure backend architecture.

---

## ✨ **Why BookMyRide?**

✔ Fast & responsive
✔ Clean modern UI
✔ Secure authentication
✔ Real-time booking price calculation
✔ Full admin control
✔ Built with industry-standard tech

---

## 🛠️ **Tech Stack**

### **Frontend**

* HTML5
* CSS3 + Custom Styles
* JavaScript
* Bootstrap 5
* Font Awesome Icons

### **Backend**

* PHP (Procedural)
* MySQL (MySQLi)
* PHP Sessions
* Password hashing & validation

---

## 🔥 **Key Features**

### 👥 **User Features**

* Account Registration & Login
* Role-based redirection (User / Admin)
* Browse available cars
* View car details
* Full booking system:

  * Pickup & Drop dates
  * Locations
  * Personal info
  * Payment method
* **Dynamic Pricing**

  * First 3 days → normal price
  * After 3 days → **10% discount**
* Real-time validation (JS)
* Password reset via email
* Testimonials & Contact pages

---

### 🛡️ **Admin Features**

* Powerful dashboard
* Manage cars (Add / Edit / View)
* Manage bookings
* Manage customers
* Generate reports
* Strict admin-only access

---

## 🗄️ **Database Structure**

**Database Name:** `bookmyride`

| Table        | Description                       |
| ------------ | --------------------------------- |
| `users`      | User accounts (admin + customers) |
| `cars`       | Car inventory and details         |
| `bookings`   | All booking records               |
| `categories` | Car categories                    |
| `payments`   | Payment details                   |

Includes sample cars like **Ertiga, Swift, Innova, Thar, Fortuner**, etc.

---

## 📁 **Project Structure**

```
/
├── index.php
├── booking.php
├── login.php
├── register.php
├── cars.php
├── contact.php
├── testimonials.php
├── db.php
├── bookmyride.sql
│
├── admin/
│   ├── dashboard_admin.php
│   ├── Add_car.php
│   ├── View_cars.php
│   ├── all_bookings.php
│   ├── customers.php
│   └── report.php
│
├── assets/
│   ├── css/
│   └── images/
│
└── includes/
    ├── header.php
    └── footer.php
```

---

## 🔐 **Security Features**

* **Password hashing**
* **Session-based login control**
* **Sanitized inputs**
* **Admin-only protected routes**

---

## 🚀 **How to Run Locally**

### 1️⃣ Clone the repository

```sh
git clone https://github.com/yourusername/bookmyride.git
```

### 2️⃣ Move project to XAMPP

Place folder inside:

```
xampp/htdocs/
```

### 3️⃣ Start XAMPP

Start **Apache** + **MySQL**

### 4️⃣ Import the database

Use phpMyAdmin → Import → select `bookmyride.sql`

### 5️⃣ Run project

Visit:

```
http://localhost/bookmyride/
```

---

## 👨‍💻 **Developer**

**Lathiya Harshal**
IT Student | Full-Stack Learner | Freelance Developer

---

## ⭐ **Support the Project**

If you like this project, give it a **star ⭐ on GitHub** — it motivates me!
