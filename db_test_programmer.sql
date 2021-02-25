-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2021 at 07:35 AM
-- Server version: 10.3.27-MariaDB-0+deb10u1
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_test_programmer`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` enum('Laki-Laki','Perempuan') NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `name`, `gender`, `parent_id`) VALUES
(1, 'Budi', 'Laki-Laki', NULL),
(2, 'Dedi', 'Laki-Laki', 2),
(3, 'Dodi', 'Laki-Laki', 1),
(4, 'Dede', 'Laki-Laki', 1),
(5, 'Dewi', 'Perempuan', 1),
(6, 'Feri', 'Laki-Laki', 2),
(7, 'Farah', 'Perempuan', 2),
(8, 'Gugus', 'Laki-Laki', 3),
(9, 'Gandi', 'Laki-Laki', 3),
(10, 'Hani', 'Perempuan', 4),
(11, 'Hana', 'Perempuan', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `fk_person` (`parent_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person` FOREIGN KEY (`parent_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
