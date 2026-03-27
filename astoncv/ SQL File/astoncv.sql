-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 26, 2026 at 03:18 AM
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
-- Database: `astoncv`
--

-- --------------------------------------------------------

--
-- Table structure for table `cvs`
--

CREATE TABLE `cvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyprogramming` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `URLlinks` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cvs`
--

INSERT INTO `cvs` (`id`, `name`, `email`, `password`, `keyprogramming`, `profile`, `education`, `URLlinks`) VALUES
(5, 'Hermon Seferad', 'Herry@gmail.com', '$2y$10$BEyKpSKQjWd1b9S6ezsyk.e9hAV6RPPZEZogOTnCQbEb4RCG6hRqG', 'Phyton, SQL, Javascript, C++, PHP, HTML,CSS', 'Passionate Python developer with a focus on machine learning and data science. I enjoy building intelligent systems that turn raw data into meaningful insights. \r\n\r\nand i love gaming :)', 'BSc Computer Science, Aston University , 2025-2029', 'https://github.com/Hermo17'),
(6, 'james', 'james@gmail.com', '$2y$10$XCwqeF8Mo93hZo4L/msUe.l.yzDgOQ0tpyYn.o2Yq3dzrO/ivA9C6', 'JavaScript, React', 'Full-stack JavaScript developer who loves building fast and beautiful web apps. Experienced in React on the frontend and Node.js on the backend.', 'BSc Computer Science, University of Manchester, 2019-2022', 'https://github.com/james-dev-test'),
(7, 'Sofia Martinez', 'sofia.martinez@test.com', '$2y$10$eCpBjxFeHTPpUACZ5KWzBO8NiB5qLaQyzo/FTlXlGyXB2mD/D0Hla', 'Java, Spring Boot', 'Backend Java developer with a strong interest in microservices and scalable enterprise systems. Clean code and solid architecture are my priorities.', 'MEng Software Engineering, University of Birmingham, 2018-2022', 'https://github.com/sofia-martinez-test'),
(8, 'Aisha Patel', 'aisha.patel@test.com', '$2y$10$W9wwPVj.Mb0/spju7ie.POsaXPjBy2Qfj4x2SZ0do.MHchwYwjt42', 'PHP, Laravel', 'Web developer with solid PHP and Laravel experience. I enjoy building dynamic database-driven websites and clean REST APIs for real world applications.', 'BSc Computer Science, Aston University, 2021-2024', 'https://github.com/aisha-patel-test'),
(9, 'Noah Williams', 'noah.williams@test.com', '$2y$10$rXgP8KDaB.u7DKtqzYMzHusE9GGaBMZLv37W.UWrSrch.Dzg4fqfC', 'C++, Rust', 'Systems programmer passionate about low-level development and performance. I work on embedded systems and love squeezing every bit of efficiency out of hardware.', 'BEng Computer Engineering, University of Bristol, 2019-2023', 'https://github.com/noah-williams-dev-test'),
(10, 'Emma Johnson', 'emma.johnson@test.com', '$2y$10$EGuRm8fZeZnzbn8Ob9VTYuibxGUdWBZeB7wv.X8QnL/A7MFINEeLG', 'React, TypeScript', 'Frontend developer with a strong eye for design and accessibility. I specialise in building clean, responsive and inclusive user interfaces with React and TypeScript.', 'BSc Web Development, University of Sheffield, 2020-2023', 'https://github.com/emma-johnson-dev');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
