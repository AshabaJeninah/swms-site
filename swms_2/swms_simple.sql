-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 08:45 AM
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
-- Database: `swms_simple`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'KCCA01', '$2y$10$ycyta1qimfi5QGHE0vX2cOmUaixxb9cC.MMU/AbG6u7C.XS8bwKne', '2025-12-12 10:29:10'),
(2, 'KCCA02', '$2y$10$C0WjggOyYeeHq1He0xnqi.uH.EygVCzAqu91q1velei.QNN65cbA.', '2026-01-04 08:35:03'),
(3, 'KCCA03', '$2y$10$j6zP6VwZunR62XZktbOwpuVIHmwuJKk9lCQD.sUMuCqm8ma6F3wVi', '2026-02-12 15:49:48'),
(4, 'KCCA04', '$2y$10$KDtNhMxpTA/2kr7TXEO62.xhxgqY4L/MBDc8v9BwuORSGTMHBxK8i', '2026-02-13 07:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `bins`
--

CREATE TABLE `bins` (
  `bin_id` int(11) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `current_fill_level` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT 'OK',
  `last_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bins`
--

INSERT INTO `bins` (`bin_id`, `location_name`, `latitude`, `longitude`, `current_fill_level`, `status`, `last_updated`) VALUES
(1, 'IoT Prototype Testing Site (Bin #1)', NULL, NULL, 25, 'OK', '2025-12-11 15:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `contact_feedback`
--

CREATE TABLE `contact_feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_feedback`
--

INSERT INTO `contact_feedback` (`id`, `name`, `email`, `subject`, `message`, `timestamp`) VALUES
(1, 'Ashaba Jeninah', 'ashaba@gmail.com', 'Good', 'jnml,.lopijhgftrewq', '2025-12-11 15:57:42'),
(2, 'Ashaba Jeninah', 'ashaba@gmail.com', 'General Feedback/Inquiry', 'asderf', '2025-12-11 20:38:20'),
(3, 'Mungu Maxwell', 'ashaba@gmail.com', 'General Feedback/Inquiry', 'rdtyuiopl,mnbvcfyujk', '2025-12-11 21:16:13'),
(4, 'Mungu Maxwell', 'ashaba@gmail.com', 'General Feedback/Inquiry', 'asdvbnm,./\'[poiuytd', '2026-01-06 13:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `incident_reports`
--

CREATE TABLE `incident_reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `report_type` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident_reports`
--

INSERT INTO `incident_reports` (`id`, `reporter_name`, `location`, `report_type`, `details`, `contact_info`, `status`, `reported_at`) VALUES
(1, '', 'Kawempe', 'Illegal Dumping', 'flllllll', '', 'Pending', '2025-12-11 12:56:51'),
(2, 'Anonymous Citizen', 'Kawempe', 'Illegal Dumping', 'asdfghj', '', 'Pending', '2026-01-06 10:14:29'),
(3, 'Anonymous Citizen', 'Mpererwe', 'Other', 'the bins have filled so muc and they are smelling.', '', 'Pending', '2026-02-12 15:08:37'),
(4, 'Anonymous Citizen', 'Mpererwe boda stage', 'Illegal Dumping', 'people have dumped bottles', '', 'Pending', '2026-02-12 15:24:13'),
(5, 'Anonymous Citizen', 'Kyanja', 'Illegal Dumping', 'the bins are fill', '', 'Pending', '2026-02-13 07:17:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bins`
--
ALTER TABLE `bins`
  ADD PRIMARY KEY (`bin_id`);

--
-- Indexes for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident_reports`
--
ALTER TABLE `incident_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bins`
--
ALTER TABLE `bins`
  MODIFY `bin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_feedback`
--
ALTER TABLE `contact_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incident_reports`
--
ALTER TABLE `incident_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
