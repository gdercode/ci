-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2022 at 04:53 PM
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
(3, 'kagabo', 'pascal', 'kagabo@gmail.com', '+250782546968', 'kagabo', '$2y$10$P/nHHTQusyihPMiPuqDFWuMvUqJNGn6C6/kDG8Gu1RfQCe7PW2tlC', '2022-08-04 20:28:58', '2022-08-04 20:28:58', 1);

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
(4, 'anyRole2', 35);

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
-- Constraints for dumped tables
--

--
-- Constraints for table `all_user_table`
--
ALTER TABLE `all_user_table`
  ADD CONSTRAINT `all_user_table_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `role_table` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
