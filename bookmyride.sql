-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 11:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmyride`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `car_type` varchar(100) NOT NULL,
  `pickup_date` date NOT NULL,
  `drop_date` date NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `drop_location` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `car_id`, `full_name`, `email`, `phone`, `car_type`, `pickup_date`, `drop_date`, `pickup_location`, `drop_location`, `payment_method`, `created_at`, `status`) VALUES
(1, 5, 'Lathiya Harshal', 'harshalplathiya@gmail.com', '9737612352', 'Fortuner', '2025-09-16', '2025-09-19', 'chital', 'Ahmedabad ', 'Cash on Drop', '2025-09-15 17:24:13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fuel_type` varchar(50) DEFAULT 'Petrol',
  `transmission` varchar(50) DEFAULT 'Manual',
  `seating_capacity` int(11) DEFAULT 5,
  `mileage` varchar(50) DEFAULT '—',
  `engine` varchar(100) DEFAULT '—',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `name`, `category`, `price_per_day`, `image`, `status`, `created_at`, `fuel_type`, `transmission`, `seating_capacity`, `mileage`, `engine`, `description`) VALUES
(1, 'Ertiga', 'ertiga', 500.00, 'ertiga.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '—', '—', NULL),
(2, 'Swift', 'swift', 400.00, 'swift.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '—', '—', NULL),
(3, 'Innova', 'innova', 800.00, 'innova.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '—', '—', NULL),
(4, 'Thar', 'thar', 900.00, 'thar_roxx.avif', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '—', '—', NULL),
(5, 'Fortuner', 'fortuner', 1000.00, 'fortuner.avif', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '—', '—', NULL),
(7, 'XUV700', 'fortuner', 2000.00, 'xuv700.avif', 'available', '2025-09-15 19:39:28', 'Petrol', 'Manual', 5, '—', '—', NULL),
(8, 'Baleno', 'sedan', 300.00, '1763670976_Baleno.avif', 'available', '2025-11-20 20:36:16', 'Petrol', 'Manual', 5, '21', '1197cc', 'The Maruti Baleno is the brand\'s premium hatchback with a long list of modern features, spacious cabin for five occupants and good looks.');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'ertiga', 'Compact and fuel efficient'),
(2, 'swift', 'Small and sporty'),
(3, 'innova', 'Spacious and comfortable'),
(4, 'thar', 'Rugged and off-road capable'),
(5, 'fortuner', 'Luxury SUV'),
(6, 'verna', 'Sedan with style');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'Admin', 'Admin@gmail.com', '$2y$10$Vm9q4Q0UKjvtLaufLfzDkegs/LzU.UKLBHw4WdTM7ASkEHivHi1WG', 1, '2025-09-15 17:08:42'),
(2, 'Lathiya Harshal', 'harshalplathiya@gmail.com', '$2y$10$DoTttxFY7TjmXVkI9swcKev5SP7bDU8BrOOAUUrT0Estuu0hSSW6i', 0, '2025-09-15 17:17:29'),
(3, 'Sarvaiya Dharmik', 'sarvaiyadharmik@gmail.com', '$2y$10$O9PJGNw.r1dMXR7g4y2djunKlFW8bAsK5uynjcaK/QBiii2RAU0.6', 0, '2025-09-15 20:44:16'),
(4, 'Mihir Lathiya', 'mihir@gmail.com', '$2y$10$bSKxw8/2i9hHRCzg4cJNaer/ohArMj4YElLTZSZ3rbPhwBqbsZxu6', 0, '2025-11-20 22:05:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
