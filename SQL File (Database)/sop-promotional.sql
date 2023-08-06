-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2023 at 05:12 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sop-promotional`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `college` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course`, `college`) VALUES
(1, 'Advanced Baking', ''),
(2, 'Arduino Programming', ''),
(3, 'Automotive Servicing', ''),
(4, 'Bartending', ''),
(5, 'Basic Computer', '1'),
(6, 'Bookkeeping', ''),
(7, 'Bread and Pastry Production', ''),
(8, 'CAD with Application', ''),
(9, 'Computer Programming', ''),
(10, 'Computer System Servicing', ''),
(11, 'Cookery', ''),
(12, 'Electrical Installation & Maintenance', ''),
(13, 'Food and Beverage Services', ''),
(14, 'Food Processing & Preservation', ''),
(15, 'Garments & Fashion Design', ''),
(16, 'Household Services/Housekeeping w/ Hotel Operations', ''),
(17, 'Reflexology and Massage Theraphy', ''),
(18, 'Refrigeration & Aircon Services', ''),
(19, 'Shielded Metal Arc Welding', ''),
(20, 'Web Page Development', '');

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE `gradesheet` (
  `id` int(11) NOT NULL,
  `studentnumber` varchar(100) NOT NULL,
  `attendance` varchar(11) NOT NULL,
  `block1` varchar(11) NOT NULL,
  `block2` varchar(11) NOT NULL,
  `block3` varchar(11) NOT NULL,
  `block4` varchar(11) NOT NULL,
  `block5` varchar(11) NOT NULL,
  `block6` varchar(11) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `course` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `schoolyear` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gradesheet`
--

INSERT INTO `gradesheet` (`id`, `studentnumber`, `attendance`, `block1`, `block2`, `block3`, `block4`, `block5`, `block6`, `remarks`, `course`, `term`, `schoolyear`) VALUES
(1, '194-0516', '75', '2', '11', '1', '1', '', '', 'promoted', 20, 0, '2022-2023'),
(7, '194-0477', '77', '33', '12', '2', '2', '', '', 'promoted', 20, 0, '2022-2023');

-- --------------------------------------------------------

--
-- Table structure for table `gsblocktitle`
--

CREATE TABLE `gsblocktitle` (
  `id` int(11) NOT NULL,
  `block1` varchar(11) NOT NULL,
  `block2` varchar(11) NOT NULL,
  `block3` varchar(11) NOT NULL,
  `block4` varchar(11) NOT NULL,
  `block5` varchar(11) NOT NULL,
  `block6` varchar(11) NOT NULL,
  `course` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `schoolyear` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gsblocktitle`
--

INSERT INTO `gsblocktitle` (`id`, `block1`, `block2`, `block3`, `block4`, `block5`, `block6`, `course`, `term`, `schoolyear`) VALUES
(1, 'quiz', 'activity', 'pre-lim', 'mid-term', 'final', 'recitation', 20, 0, '2022-2023');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `studentnumber` varchar(100) NOT NULL,
  `course` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `age` int(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactnumber` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `father` varchar(100) NOT NULL,
  `fatheroccupation` varchar(100) NOT NULL,
  `mother` varchar(100) NOT NULL,
  `motheroccupation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `studentnumber`, `course`, `lastname`, `firstname`, `middlename`, `age`, `address`, `email`, `contactnumber`, `gender`, `birthday`, `status`, `father`, `fatheroccupation`, `mother`, `motheroccupation`) VALUES
(1, '194-0516', 20, 'Doblada', 'Mhel Jhona', 'Poras', 22, 'Mandaluyong City', '', '', 'F', '2000-12-11', 'new', '', '', '', ''),
(2, '194-0477', 20, 'Tutor', 'Louie Jay', 'Espanola', 22, 'Antipolo Cty', '', '', 'M', '2001-05-23', 'new', '', '', '', ''),
(4, '000-0000', 6, 'Biik', 'Neneng', '', 22, '', '', '', 'F', '2000-12-11', 'new', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `employeenumber` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `employeenumber`, `username`, `name`, `password`) VALUES
(1, 'OJT2023-0003', 'jhona', 'Mhel Jhona P. Doblada', 'Eregi2023');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gradesheet`
--
ALTER TABLE `gradesheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gsblocktitle`
--
ALTER TABLE `gsblocktitle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gradesheet`
--
ALTER TABLE `gradesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gsblocktitle`
--
ALTER TABLE `gsblocktitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
