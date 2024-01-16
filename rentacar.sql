-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2024 at 01:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentacar`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `pickup_location` int(11) NOT NULL,
  `return_location` int(11) NOT NULL,
  `total_cost` decimal(6,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `car_id`, `pickup_date`, `return_date`, `pickup_location`, `return_location`, `total_cost`, `status`) VALUES
(3, 3, 4, '2024-01-17', '2024-01-26', 1, 1, 270.00, 'Completed'),
(5, 3, 9, '2024-01-16', '2024-01-31', 1, 1, 450.00, 'Cancelled'),
(6, 3, 8, '2024-01-16', '2024-01-31', 1, 1, 450.00, 'Completed'),
(7, 3, 6, '2024-01-17', '2024-01-26', 1, 1, 270.00, 'active'),
(8, 3, 7, '2024-01-17', '2024-01-26', 1, 1, 270.00, 'active'),
(9, 5, 4, '2024-01-17', '2024-01-27', 1, 4, 300.00, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `licence_plate` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `fueltype` varchar(255) NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `image`, `brand`, `model`, `licence_plate`, `year`, `color`, `fueltype`, `availability`) VALUES
(4, 'car_rental.avif', 'BMW', 'i13', 'SE87S3', 2021, 'Gray', 'Diesel', 0),
(5, 'mercedes-a-klasse.png', 'Mercedes', 'A 54', 'B5TY78', 2020, 'Gray', 'Petrol', 0),
(6, 'BMW.jpeg', 'BMW', 'iX3', '09PDK2', 2022, 'Gray', 'Electric', 0),
(7, 'bmw-2-series-coupe-2023-0087-478x320.png', 'BMW', '2X', 'HI2614', 2023, 'Red', 'Electric', 0),
(8, 'b16921705768b1510ca805fd8be3c15b.png', 'Range Rover', 'GX8', '34VL7S', 2023, 'Black', 'Electric', 1),
(9, 'mokka-e-cgi.png', 'Opel', 'Mokka-e', 'PKG98S', 2023, 'Green', 'Electric', 1);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(50) NOT NULL,
  `housenumber` varchar(50) NOT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `image`, `location_name`, `postalcode`, `country`, `city`, `street`, `housenumber`, `phonenumber`, `email`) VALUES
(1, 'building.jpeg', 'Aqua Building', '2124 DE', 'netherlands', 'Utrecht', 'werhx', '818', '2057921738', 'Aqua.VZ.rentacar@gmail.com'),
(4, 'het_gebouw-f01.jpg', 'Het Gebouw', '1079 CK', 'netherlands', 'Rotterdam', 'Wertstraat', '65', '0209876543', 'HetGebouw@vzrent.com'),
(5, '20150316_Almere_75.jpeg', 'The Wave', '1309', 'netherlands', 'Almere', 'Qazstraat', '950', '020654903922', 'TheWave@vzrent.com'),
(6, 'Architectuur-Almere-Side-by-Side.jpg', 'Omni', '1311 GB', 'netherlands', 'Almere', 'Opelstrastraat', '47', '02065390922', 'Omni@vzrent.com');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `work_email` varchar(255) NOT NULL,
  `private_email` varchar(255) NOT NULL,
  `phonenumber` int(11) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `department` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `housenumber` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `firstname`, `lastname`, `date_of_birth`, `work_email`, `private_email`, `phonenumber`, `salary`, `department`, `function`, `postalcode`, `country`, `city`, `street`, `housenumber`, `password`) VALUES
(1, 'Julie', 'Kraanen', '2006-01-14', 'test2@gmail.com', 'test@gmail.com', 2147483647, 400.00, 'ICT', 'Software Developer', '1104 SR', 'Netherlands', 'Amsterdam', 'Eefsfs', 23, '$2y$10$4WIuALm3gilNXh51fGzLZ.Of.ADBhqGy2n1FTcs/SDTzzX3cXlBMC');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` int(11) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `housenumber` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bookings` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `date_of_birth`, `email`, `phonenumber`, `postalcode`, `country`, `city`, `street`, `housenumber`, `password`, `bookings`, `type`) VALUES
(1, '', '', '0000-00-00', 'admin@gmail.com', 0, '', '', '', '', 0, '$2y$10$lLVWRtBKkz/MrikyALyf9uIerm.Nsl6ublB0qQffKCSR8IvflUur6', 0, 'admin'),
(3, 'test2', 'test2', '2006-01-12', 'test2@gmail.com', 2147483647, '1104 SR', 'Netherlands', 'Amsterdam', 'Engcobo', 45, '$2y$10$SE/cUVfpUJe/4J1pHJIjjuH0EiFosdheZkuP/0NKZ81bNn78IRn6y', 0, 'customer'),
(4, 'Wert', 'Snow', '2006-01-10', 'wertooo@gmail.com', 678934332, '1870 DV', 'netherlands', 'Almere', 'Tuertstraat', 117, '$2y$10$fTd.3bKcX87.ESAe4Ix2a.x./CskOD0pqR/TRm8z6iXmzyVGLk41K', 0, 'customer'),
(5, 'Toei', 'Oenraw', '1111-11-11', 'toei@test.nl', 612345678, '1111cs', 'netherlands', 'Utrecht', 'werhx', 76, '$2y$10$sjOsuloK8FIjalWsC5lYe.1Nbq.l5IaccLKgcH6c80hDrmqc4cI.e', 0, 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `pickup_location` (`pickup_location`),
  ADD KEY `return_location` (`return_location`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
