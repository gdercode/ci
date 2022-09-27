-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2022 at 11:04 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crime`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_user_table`
--

CREATE TABLE `all_user_table` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_mobile` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_update_date` datetime NOT NULL,
  `user_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_user_table`
--

INSERT INTO `all_user_table` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_mobile`, `username`, `user_password`, `registration_date`, `user_update_date`, `user_role_id`) VALUES
(1, 'superAdmin', 'superAdmin', 'superAdmin@gmail.com', '+250782546969', 'superAdmin', '$2y$10$psjPKzl2I4DauRYmSAnxUOA3Ev/Z5qrWPWQnPdM40TlF7qPhcuTJe', '2022-08-04 10:42:55', '0000-00-00 00:00:00', 1),
(3, 'kagabo', 'pascal', 'kagabo@gmail.com', '+250782546968', 'kagabo', '$2y$10$NvQStG65ERdzjcbqkxPx/.aNh8OBtQyzXSgwZTZNsnLsc6sxwWvqq', '2022-08-04 20:28:58', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_table`
--

CREATE TABLE `role_table` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_table`
--

INSERT INTO `role_table` (`role_id`, `role_name`, `role_percentage`) VALUES
(1, 'superAdmin', 100),
(4, 'anyone', 20);

-- --------------------------------------------------------

--
-- Table structure for table `testimony_table`
--

CREATE TABLE `testimony_table` (
  `t_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  `testimony` text NOT NULL,
  `testimony_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimony_table`
--

INSERT INTO `testimony_table` (`t_id`, `u_id`, `w_id`, `testimony`, `testimony_date`) VALUES
(1, 1, 10, 'uyu ntakintu muziho', '2022-09-08 11:38:48'),
(2, 1, 10, 'uyu jewe ndamuzi ararengana ', '2022-09-08 11:45:40'),
(3, 1, 10, 'uyu ntahave', '2022-09-08 11:46:58'),
(4, 1, 10, 'nibyo', '2022-09-08 11:47:35'),
(5, 1, 10, 'nibyo', '2022-09-08 11:52:32'),
(6, 3, 10, 'inyangamugayo', '2022-09-09 08:53:13'),
(7, 1, 12, 'Uyu ndamuzi ni mubi cyane \r\n', '2022-09-12 10:55:59'),
(8, 1, 12, 'hhhh', '2022-09-12 10:56:16'),
(9, 1, 13, 'Uyu ndamuzi n umujura ', '2022-09-27 10:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `wanted_table`
--

CREATE TABLE `wanted_table` (
  `wanted_id` int(11) NOT NULL,
  `wanted_First_name` varchar(50) DEFAULT NULL,
  `wanted_last_name` varchar(50) DEFAULT NULL,
  `wanted_gender` varchar(6) DEFAULT NULL,
  `wanted_age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wanted_table`
--

INSERT INTO `wanted_table` (`wanted_id`, `wanted_First_name`, `wanted_last_name`, `wanted_gender`, `wanted_age`) VALUES
(10, 'Gakuba', 'Paul', 'Male', 32),
(11, 'uwase', 'Pascaline', 'female', 21),
(12, 'gakubaf', 'paulf', 'male', 55),
(13, 'butoya', 'kabange', 'male', 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_user_table`
--
ALTER TABLE `all_user_table`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `role_table`
--
ALTER TABLE `role_table`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `testimony_table`
--
ALTER TABLE `testimony_table`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `w_id` (`w_id`);

--
-- Indexes for table `wanted_table`
--
ALTER TABLE `wanted_table`
  ADD PRIMARY KEY (`wanted_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_user_table`
--
ALTER TABLE `all_user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_table`
--
ALTER TABLE `role_table`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimony_table`
--
ALTER TABLE `testimony_table`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wanted_table`
--
ALTER TABLE `wanted_table`
  MODIFY `wanted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_user_table`
--
ALTER TABLE `all_user_table`
  ADD CONSTRAINT `all_user_table_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `role_table` (`role_id`);

--
-- Constraints for table `testimony_table`
--
ALTER TABLE `testimony_table`
  ADD CONSTRAINT `testimony_table_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `all_user_table` (`user_id`),
  ADD CONSTRAINT `testimony_table_ibfk_2` FOREIGN KEY (`w_id`) REFERENCES `wanted_table` (`wanted_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
