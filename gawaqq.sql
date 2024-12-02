-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 06:14 AM
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
-- Database: `gawaqq`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_token` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password_hash`, `role`, `created_at`, `verification_token`, `email_verified`) VALUES
(1, 'asdasdasds1231', 'bjbecause24dasdas@gmail.com', '$2y$10$MLQaTzuIw./OvJ2qf0vmIOTSPlVAnrpr4HSeSpXzIRVR4i4nMB2ey', 'admin', '2024-12-01 22:31:38', NULL, 0),
(2, 'dasdasdas213', 'sadasdasdas12312@gmail.com', '$2y$10$BuBwirrcvQ3RK19oG2MANeuzYIpwrP2WqRREUUWAc59kmNuohcZ96', 'client', '2024-12-01 22:33:25', NULL, 0),
(8, 'sadsa asdasdas', 'bjbecause24@gmail.com', '$2y$10$m549hHikC3g2m1.sgwQEwOtvUP8faS7eMihrkJzJat4t4c78AazNC', 'client', '2024-12-02 05:00:07', 'cc11942060b416d5eec344485cca9ed6', 0),
(11, 'sadasdas', 'bernardo.johnmichael.bscs2022@gmail.com', '$2y$10$hI4apSpzHn.EXvfrgkIZ7elbrQlKQJ3hBiebdlUXPeaOyRYkP/kOm', 'client', '2024-12-02 05:08:09', NULL, 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
