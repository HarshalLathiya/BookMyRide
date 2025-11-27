-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 02:55 PM
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
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `estimated_km` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `car_id`, `full_name`, `email`, `phone`, `car_type`, `pickup_date`, `drop_date`, `pickup_location`, `drop_location`, `payment_method`, `created_at`, `status`, `estimated_km`) VALUES
(1, 5, 'Lathiya Harshal', 'harshalplathiya@gmail.com', '9737612352', 'Fortuner', '2025-09-16', '2025-09-19', 'chital', 'Ahmedabad ', 'Cash on Drop', '2025-09-15 17:24:13', 'Completed', NULL),
(2, 1, 'Sarvaiya Dharmik', 'sarvaiyadharmik@gmail.com', '9904065847', 'Ertiga', '0000-00-00', '0000-00-00', 'amreli', 'amreli', 'Cash on Drop', '2025-11-25 11:39:27', 'Completed', NULL),
(3, 2, 'Varshil Lathiya', 'VarshilLathiya@gmail.com', '9484871696', 'Swift', '0000-00-00', '0000-00-00', 'Adalaj', 'Adalaj', 'Cash on Drop', '2025-11-25 11:43:17', 'Completed', NULL),
(4, 1, 'Lathiya Harshal', 'harshalplathiya@gmail.com', '9737612352', 'Ertiga', '0000-00-00', '0000-00-00', 'chital', 'chital', 'UPI', '2025-11-25 12:06:28', 'Completed', NULL),
(5, 1, 'Nikhil Lathiya', 'NikhilLathiya@gmail.com', '7046473969', 'Ertiga', '2025-11-27', '2025-11-29', 'Gandhidham', 'Gandhidham,s7', 'UPI', '2025-11-26 15:31:46', 'Completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fuel_type` varchar(50) DEFAULT 'Petrol',
  `transmission` varchar(50) DEFAULT 'Manual',
  `seating_capacity` int(11) DEFAULT 5,
  `mileage` varchar(50) DEFAULT '—',
  `engine` varchar(100) DEFAULT '—',
  `description` text DEFAULT NULL,
  `price_per_km` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `name`, `category`, `image`, `status`, `created_at`, `fuel_type`, `transmission`, `seating_capacity`, `mileage`, `engine`, `description`, `price_per_km`) VALUES
(1, 'Ertiga', 'ertiga', 'ertiga.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 7, '21', '1462cc', 'A practical 7-seater MPV delivering strong fuel efficiency and smooth family-focused performance.', 11.00),
(2, 'Swift', 'swift', 'swift.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '25', '1197cc', 'A lightweight, fun-to-drive hatchback known for its quick pickup and excellent mileage.', 13.00),
(3, 'Innova', 'innova', 'innova.jpg', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 7, '11', '2393cc', 'A powerful and reliable MPV offering superior comfort and long-distance touring capability.', 25.00),
(4, 'Thar', 'thar', 'thar_roxx.avif', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 6, '16', '2184cc', 'A rugged off-road SUV designed for adventure with strong torque and true 4x4 capability.', 15.00),
(5, 'Fortuner', 'fortuner', 'fortuner.avif', 'available', '2025-09-15 17:08:42', 'Petrol', 'Manual', 5, '15', '2755cc', 'A premium full-size SUV delivering commanding road presence and robust diesel performance.', 30.00),
(7, 'XUV700', 'fortuner', 'xuv700.avif', 'available', '2025-09-15 19:39:28', 'Petrol', 'Manual', 5, '17', '1999cc', 'A feature-rich modern SUV with strong turbo performance and advanced safety technology.', 20.00),
(8, 'Baleno', 'sedan', '1763670976_Baleno.avif', 'available', '2025-11-20 20:36:16', 'Petrol', 'Manual', 5, '21', '1197cc', 'The Maruti Baleno is the brand\'s premium hatchback with a long list of modern features, spacious cabin for five occupants and good looks.', 15.00),
(9, 'Scorpio ', 'suv', '1764171736_Scorpio.avif', 'available', '2025-11-26 15:42:16', 'Diesel', 'Automatic', 7, '15', '2184cc', 'The Mahindra Scorpio is an iconic full-size SUV with a dominant road presence, spacious front two rows, and a powerful 2.2-litre diesel manual engine to propel this seven or nine seater SUV. ', 20.00);

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `method`, `status`, `created_at`) VALUES
(1, 2, 2200.00, 'Cash on Drop', 'pending', '2025-11-25 11:39:27'),
(2, 3, 1950.00, 'Cash on Drop', 'pending', '2025-11-25 11:43:17'),
(3, 4, 2200.00, 'UPI', 'pending', '2025-11-25 12:06:28'),
(4, 5, 0.00, 'UPI', 'pending', '2025-11-26 15:31:46');

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
(3, 'Sarvaiya Dharmik', 'sarvaiyadharmik@gmail.com', '$2y$10$DA8ny0YSfTcw9kdt8N3suejtL.9enp9du8U0JhiJSJSncgd/6P2oy', 0, '2025-09-15 20:44:16'),
(4, 'Mihir Lathiya', 'mihir@gmail.com', '$2y$10$bSKxw8/2i9hHRCzg4cJNaer/ohArMj4YElLTZSZ3rbPhwBqbsZxu6', 0, '2025-11-20 22:05:57'),
(5, 'Varshil Lathiya', 'VarshilLathiya@gmail.com', '$2y$10$uQL22X7wDKyiOO8ZiQes9OKLhjAOiwaGZc2o8TQt4MN7kmSVprlyS', 0, '2025-11-20 22:31:57'),
(6, 'Nikhil Lathiya', 'NikhilLathiya@gmail.com', '$2y$10$NuFMzp.f9bkpOv0nDVQD7./.LiOQHCQD2pJKy8WP28jpEq3W3yqUK', 0, '2025-11-25 12:13:35'),
(7, 'Navdeep Bhalu', 'NavdeepBhalu@gmail.com', '$2y$10$dQo9raAloU/7hEUiRCe1H.ZiVatn6SNbfbeehh41GzJoyNVb6m882', 0, '2025-11-26 15:44:05');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
