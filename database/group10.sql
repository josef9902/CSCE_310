-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 04, 2023 at 09:08 PM
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
-- Database: `group10`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `ADMIN_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`ADMIN_ID`) VALUES
(20),
(23),
(29);

-- --------------------------------------------------------

--
-- Table structure for table `APPOINTMENTS`
--

CREATE TABLE `APPOINTMENTS` (
  `APP_ID` int(11) NOT NULL,
  `BARBER_ID` int(11) NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
  `TIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `APPOINTMENTS`
--

INSERT INTO `APPOINTMENTS` (`APP_ID`, `BARBER_ID`, `CUSTOMER_ID`, `TIME`) VALUES
(20, 17, 2, '2023-05-10 22:14:00'),
(22, 17, 2, '2023-06-03 13:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `BARBER`
--

CREATE TABLE `BARBER` (
  `BARBER_ID` int(11) NOT NULL,
  `SERV_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `BARBER`
--

INSERT INTO `BARBER` (`BARBER_ID`, `SERV_ID`) VALUES
(17, 3),
(21, 3),
(28, 3);

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `CUSTOMER_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`CUSTOMER_ID`) VALUES
(2),
(18);

-- --------------------------------------------------------

--
-- Table structure for table `REVIEW`
--

CREATE TABLE `REVIEW` (
  `REV_ID` int(11) NOT NULL,
  `BARBER_ID` int(11) NOT NULL,
  `CUST_ID` int(11) NOT NULL,
  `RATING` decimal(2,1) NOT NULL,
  `DESCRIPTION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `REVIEW`
--

INSERT INTO `REVIEW` (`REV_ID`, `BARBER_ID`, `CUST_ID`, `RATING`, `DESCRIPTION`) VALUES
(1, 17, 2, 2.0, 'not good');

-- --------------------------------------------------------

--
-- Table structure for table `SERVICES`
--

CREATE TABLE `SERVICES` (
  `SERV_ID` int(11) NOT NULL,
  `SERV_NAME` varchar(50) NOT NULL,
  `PRICE` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `SERVICES`
--

INSERT INTO `SERVICES` (`SERV_ID`, `SERV_NAME`, `PRICE`) VALUES
(3, 'Full Service', 323.00),
(4, 'Trim', 15.00),
(5, 'Hair wash', 6.00);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `USER_ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `FIRST_NAME` varchar(50) NOT NULL,
  `LAST_NAME` varchar(50) NOT NULL,
  `PH_NUM` varchar(15) NOT NULL,
  `LOCATION` varchar(100) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`USER_ID`, `USERNAME`, `FIRST_NAME`, `LAST_NAME`, `PH_NUM`, `LOCATION`, `PASSWORD`) VALUES
(2, 'test_customer', 'test', 'customer', '7777777777', 'aggieland', '123'),
(17, 'test_barber', 'test', 'barber', '7777777777', 'fdsfsdf', '1'),
(18, 'johnwick', 'john', 'wick', '555-1234', 'wick cityy', '123'),
(20, 'admin', 'admin', 'man', '7777777777', 'admin land', '123'),
(21, 'adfsdafsd', 'dafdsfdsa', 'adfds', '555-1234', 'asdfs', 'asdfsda'),
(23, 'test_admin', 'test', 'admin', '555-1234', 'dfdfd', '1'),
(28, 'a_barber', 'ryan', 'jones', '555-1234', 'aggieland', '1'),
(29, 'another_admin', 'another', 'admin', '555-1234', 'dfd', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `APPOINTMENTS`
--
ALTER TABLE `APPOINTMENTS`
  ADD PRIMARY KEY (`APP_ID`),
  ADD KEY `BARBER_ID` (`BARBER_ID`),
  ADD KEY `CUSTOMER_ID` (`CUSTOMER_ID`);

--
-- Indexes for table `BARBER`
--
ALTER TABLE `BARBER`
  ADD PRIMARY KEY (`BARBER_ID`),
  ADD KEY `SERV_ID` (`SERV_ID`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`CUSTOMER_ID`);

--
-- Indexes for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD PRIMARY KEY (`REV_ID`),
  ADD KEY `BARBER_ID` (`BARBER_ID`),
  ADD KEY `CUST_ID` (`CUST_ID`);

--
-- Indexes for table `SERVICES`
--
ALTER TABLE `SERVICES`
  ADD PRIMARY KEY (`SERV_ID`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APPOINTMENTS`
--
ALTER TABLE `APPOINTMENTS`
  MODIFY `APP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `REVIEW`
--
ALTER TABLE `REVIEW`
  MODIFY `REV_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `SERVICES`
--
ALTER TABLE `SERVICES`
  MODIFY `SERV_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`ADMIN_ID`) REFERENCES `USERS` (`USER_ID`);

--
-- Constraints for table `APPOINTMENTS`
--
ALTER TABLE `APPOINTMENTS`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`BARBER_ID`) REFERENCES `BARBER` (`BARBER_ID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `CUSTOMER` (`CUSTOMER_ID`);

--
-- Constraints for table `BARBER`
--
ALTER TABLE `BARBER`
  ADD CONSTRAINT `barber_ibfk_1` FOREIGN KEY (`BARBER_ID`) REFERENCES `USERS` (`USER_ID`),
  ADD CONSTRAINT `barber_ibfk_2` FOREIGN KEY (`SERV_ID`) REFERENCES `SERVICES` (`SERV_ID`);

--
-- Constraints for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `USERS` (`USER_ID`);

--
-- Constraints for table `REVIEW`
--
ALTER TABLE `REVIEW`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`BARBER_ID`) REFERENCES `BARBER` (`BARBER_ID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`CUST_ID`) REFERENCES `CUSTOMER` (`CUSTOMER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
