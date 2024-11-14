-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 01:46 PM
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
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EventID` varchar(50) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Duration` int(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Organizer` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`EventID`, `EventName`, `Date`, `Time`, `Duration`, `Description`, `Organizer`, `Status`) VALUES
('E001', 'Chess competition', '2024-07-31', '18:17:00', 2, 'About chess', 'Chess Sdn Bhd', 'On-Going'),
('E002', 'LOL competition', '2024-08-29', '17:17:00', 4, 'About lol', 'Chess Sdn Bhd', 'On-Going'),
('E003', 'Valorant', '2024-10-26', '14:36:00', 2, 'about valorant', 'Chess Sdn Bhd', 'Rejected'),
('E004', 'web', '2024-08-28', '21:47:00', 3, 'web dev', 'abc', 'On-Going'),
('E005', 'Algorithm', '2024-07-31', '20:40:00', 3, 'About algorithm', 'Chess Sdn Bhd', 'Pending'),
('E006', 'play', '2024-11-29', '03:57:00', 3, 'play play', 'Chess Sdn Bhd', 'Pending'),
('E007', 'test', '2024-12-08', '17:14:00', 3, 'testing', 'joyert', 'On-Going');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `No` int(11) NOT NULL,
  `EventID` varchar(255) NOT NULL,
  `UserID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`No`, `EventID`, `UserID`) VALUES
(7, 'E001', 'U002'),
(8, 'E001', 'U004'),
(9, 'E002', 'U004'),
(10, 'E002', 'U002'),
(11, 'E001', 'U007'),
(12, 'E001', 'U009'),
(13, 'E001', 'U011'),
(14, 'E004', 'U002'),
(15, 'E001', 'U008');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(50) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DOB` date DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `DOB`, `Gender`, `Role`) VALUES
('C009', 'joyert', 'joyert@gmail.com', '$2y$10$f4hpOLnJilspK3pSVOJOcOumOUnEJlTeH.J.pe8caMm1BVMO366ei', NULL, NULL, 'Company'),
('C011', 'testcompany', 'testcompany@gmail.com', '$2y$10$JChrhjb7BLhS3Fudlw32J.EgKmbH09J82FnptK8DuE9SutbA.sXEm', NULL, NULL, 'Company'),
('U001', 'Admin', 'admin@gmail.com', '$2y$10$fcK/NDy71.spTl.DHU4kDOQi7EABZaC1a9SGvyUnlM85w3dEtC1ae', NULL, NULL, 'Admin'),
('U002', 'Wei Min', 'user@gmail.com', 'user', '2024-06-15', 'Male', 'User'),
('U005', 'Khor Wei Min', 'weimin@gmail.com', '123', NULL, NULL, 'User'),
('U006', 'weimin', '123123@gmail.com', '123123', NULL, NULL, 'User'),
('U007', 'ppp', 'ppp@gmail.com', '$2y$10$5dm/aVKVUV01m4nMKcgcG.pB.Dtk9KQDXby3V6OF1gQtiQo/dAauy', NULL, NULL, 'User'),
('U008', 'joy', 'joy@gmail.com', '$2y$10$clabtehQyLGpO0MqrB9WOu/u2bysNbuHDCNzUWRAGo/pms90FfaMe', NULL, NULL, 'User'),
('U009', 'joyer', 'joyer@gmail.com', '$2y$10$m/PyVK5SOSFux6tQO4Y02.EzklIB348FOQPWiU5ege1PcxxsmvZbK', NULL, NULL, 'User'),
('U010', 'usertest', 'usertest@gmail.com', '$2y$10$4CO3RvrVxYG9owZiC5C3Beh/ckg8Hi1A86vYA4qZDUz7AbKqO3DCm', NULL, NULL, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `LogID` int(11) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`LogID`, `UserID`, `Action`, `Timestamp`) VALUES
(1, 'U002', 'Logged in', '2024-11-12 15:28:00'),
(2, 'U003', 'Logged in', '2024-11-12 15:28:10'),
(3, 'U001', 'Logged in', '2024-11-12 15:28:26'),
(4, 'U001', 'Logged in', '2024-11-12 16:05:11'),
(5, 'U001', 'Logged in', '2024-11-12 17:04:24'),
(6, 'U003', 'Logged in', '2024-11-12 17:34:27'),
(7, 'U001', 'Logged in', '2024-11-12 17:34:37'),
(8, 'U001', 'Logged in', '2024-11-12 17:36:23'),
(9, 'U001', 'Logged in', '2024-11-13 10:39:53'),
(10, 'U001', 'Logged in', '2024-11-13 11:28:38'),
(11, 'joy@gmail.com', 'Failed login attempt', '2024-11-13 12:30:29'),
(12, 'joy@gmail.com', 'Failed login attempt', '2024-11-13 12:32:48'),
(13, 'joy@gmail.com', 'Failed login attempt', '2024-11-13 12:32:58'),
(14, 'U001', 'Logged in', '2024-11-13 12:33:12'),
(15, 'U003', 'Logged in', '2024-11-13 12:37:27'),
(16, 'Unknown', 'Failed login attempt', '2024-11-13 12:38:19'),
(17, 'U008', 'Logged in', '2024-11-13 12:38:47'),
(18, 'Unknown', 'Failed login attempt', '2024-11-13 12:48:24'),
(19, 'Unknown', 'Failed login attempt', '2024-11-13 12:48:30'),
(20, 'Unknown', 'Failed login attempt', '2024-11-13 12:48:41'),
(21, 'U008', 'Logged in', '2024-11-13 12:48:55'),
(22, 'Unknown', 'Failed login attempt', '2024-11-13 12:54:48'),
(23, 'Unknown', 'Failed login attempt', '2024-11-13 12:54:55'),
(24, 'Unknown', 'Failed login attempt', '2024-11-13 12:55:01'),
(25, 'U003', 'Logged in', '2024-11-13 12:56:24'),
(26, 'U001', 'Logged in', '2024-11-13 12:56:33'),
(27, 'U003', 'Logged in', '2024-11-13 12:56:41'),
(28, 'joy@gmail.com', 'Failed login attempt', '2024-11-13 12:56:58'),
(29, 'U002', 'Logged in', '2024-11-13 12:57:14'),
(30, 'joyer@gmail.com', 'Failed login attempt', '2024-11-13 12:58:10'),
(31, 'U002', 'Logged in', '2024-11-13 12:58:18'),
(32, 'Unknown', 'Failed login attempt', '2024-11-13 13:05:24'),
(33, 'Unknown', 'Failed login attempt', '2024-11-13 13:05:37'),
(34, 'U008', 'Logged in', '2024-11-13 13:05:45'),
(35, 'C009', 'Logged in', '2024-11-13 13:06:35'),
(36, 'U001', 'Logged in', '2024-11-13 13:08:13'),
(37, 'C009', 'Logged in', '2024-11-13 13:10:41'),
(38, 'U001', 'Logged in', '2024-11-13 13:11:05'),
(39, 'Unknown', 'Failed login attempt', '2024-11-13 16:21:43'),
(40, 'Unknown', 'Failed login attempt', '2024-11-13 16:22:52'),
(41, 'Unknown', 'Failed login attempt: Email not found', '2024-11-13 16:25:49'),
(42, 'Unknown', 'Failed login attempt: Email not found', '2024-11-13 16:25:52'),
(43, 'U009', 'Logged in', '2024-11-13 16:26:20'),
(44, 'U009', 'Failed login attempt: Incorrect password', '2024-11-13 16:26:30'),
(45, 'U009', 'Failed login attempt - Wrong password', '2024-11-13 16:28:23'),
(46, 'U009', 'Failed login attempt - Wrong password', '2024-11-13 16:28:26'),
(47, 'U009', 'Failed login attempt - Wrong password', '2024-11-13 16:28:34'),
(48, 'U009', 'Logged in', '2024-11-13 16:28:44'),
(49, 'Unknown', 'Failed login attempt - Non-existent email', '2024-11-13 16:28:59'),
(50, 'U001', 'Logged in', '2024-11-13 16:29:14'),
(51, 'U001', 'Logged in', '2024-11-14 17:04:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`LogID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
