-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 02:40 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paragraf`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_insurance_users`
--

CREATE TABLE `group_insurance_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_insurance_users`
--

INSERT INTO `group_insurance_users` (`id`, `user_id`, `firstname`, `lastname`, `email`, `date_of_birth`) VALUES
(1, 2, 'Ime2', 'Prezime2', 'ime2@prezime2.com', '1996-04-06'),
(2, 2, 'Ime4', 'Prezime4', 'ime4@prezime4', '1963-05-12'),
(3, 2, 'Ime5', 'Prezime5', 'ime5@prezime5.com', '1997-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `insurance_type` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `date_from` varchar(255) NOT NULL,
  `date_to` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `insurance_type`, `email`, `phone`, `date_from`, `date_to`) VALUES
(1, 'Ime Prezime', 'Individual-Insurance', 'ime.prezime@yahoo.com', '381-652844458', '2018-11-16', '2018-11-30'),
(2, 'Ime1 Prezime1', 'Group-Insurance', 'ime1@prezime1.com', '381-78457865', '2018-11-15', '2018-11-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_insurance_users`
--
ALTER TABLE `group_insurance_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_insurance_users`
--
ALTER TABLE `group_insurance_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
