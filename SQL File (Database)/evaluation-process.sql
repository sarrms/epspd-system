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
-- Database: `evaluation-process`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `employeenumber` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `employeenumber`, `username`, `name`, `password`) VALUES
(1, 'OJT2023-0011', 'louie', 'Louie Jay E. Tutor', 'Eregi2023');

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `id` int(11) NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `college` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`id`, `acronym`, `college`) VALUES
(1, 'CAFA', 'College of Architecture and Fine Arts'),
(2, 'CAS', 'College of Arts and Sciences'),
(3, 'CBPA', 'College of Business and Public Administration'),
(4, 'CED', 'College of Education'),
(5, 'CEN', 'College of Engineering'),
(6, 'CHTM', 'College of Hospitality and Tourism Management'),
(7, 'CIT', 'College of Industrial Technology'),
(8, 'CCJE', 'College of Criminal Justice Education');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `acronym` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `college` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `acronym`, `course`, `college`) VALUES
(1, 'BS ARCHI', 'Bachelor of Science in Architecture', 1),
(2, 'BSID', 'Bachelor of Science in Interior Design', 1),
(3, 'BFA', 'Bachelor in Fine Arts', 1),
(4, 'BSAP', 'Bachelor of Science in Applied Physics', 2),
(5, 'BSCS', 'Bachelor of Science in Computer Science', 2),
(6, 'BS INFOTECH', 'Bachelor of Science in Information Technology', 2),
(7, 'BSPSYCH', 'Bachelor of Science in Psychology', 2),
(8, 'BSMATH', 'Bachelor of Science in Mathematics', 2),
(9, 'BSBA', 'Bachelor of Science in Business Administration', 3),
(10, 'BS ENTREP', 'Bachelor of Science in Entrepreneurship', 3),
(11, 'BSOM', 'Bachelor of Science in Office Management', 3),
(12, 'BSPA', 'Bachelor of Science in Public Administration', 3),
(13, 'BSE', 'Bachelor in Secondary Education', 4),
(14, 'BSNEd', 'Bachelor in Special Needs Education', 4),
(15, 'BTLE', 'Bachelor in Technology and Livelihood Education', 4),
(16, 'TCP', 'Professional Education/Subjects', 4),
(17, 'BSCHE', 'Bachelor of Science in Chemical Engineering', 5),
(18, 'BSCE', 'Bachelor of Science in Civil Engineering', 5),
(19, 'BSEE', 'Bachelor of Science in Electrical Engineering', 5),
(20, 'BSME', 'Bachelor of Science in Mechanical Engineering', 5),
(21, 'BSCOE', 'Bachelor of Science in Computer Engineering', 5),
(22, 'BST', 'Bachelor of Science in Tourism Management', 6),
(23, 'BSHM', 'Bachelor of Science in Hospitality Management', 6),
(24, 'BSIT', 'Bachelor of Science in Industrial Technology', 7),
(25, 'BSCRIM', 'Bachelor of Science in Criminology', 8);

-- --------------------------------------------------------

--
-- Table structure for table `coursesubject`
--

CREATE TABLE `coursesubject` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `yearlevel` int(11) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coursesubject`
--

INSERT INTO `coursesubject` (`id`, `course`, `subject`, `yearlevel`, `semester`) VALUES
(1, 6, 11, 4, 2),
(7, 6, 1, 3, 2),
(8, 6, 2, 3, 2),
(9, 6, 3, 3, 2),
(10, 6, 4, 3, 2),
(11, 6, 5, 3, 2),
(12, 6, 6, 3, 2),
(13, 6, 7, 3, 2),
(14, 6, 8, 3, 2),
(15, 6, 9, 3, 2),
(16, 6, 10, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dean`
--

CREATE TABLE `dean` (
  `id` int(11) NOT NULL,
  `dean` varchar(100) NOT NULL,
  `college` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dean`
--

INSERT INTO `dean` (`id`, `dean`, `college`) VALUES
(1, 'Ar. Diane A. Jose', 1),
(2, 'Mrs. Rodora T. Oliveros', 2),
(3, 'Dr. Willy O. Gapasin', 3),
(4, 'Dr. Evangeline M. Sangalang', 4),
(5, 'Engr. Robel A. Nomorosa', 5),
(6, 'Dr. Maria Rhoda D. Dinaga', 6),
(7, 'Mr. Erwin P. Ordovez', 7),
(8, 'Dr. Anabel D. Riva', 8);

-- --------------------------------------------------------

--
-- Table structure for table `head`
--

CREATE TABLE `head` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `head`
--

INSERT INTO `head` (`id`, `name`, `position`) VALUES
(1, 'Julie Ann O. Espiritu', 'registrar'),
(4, 'Dr. Rogelio T. Mamaradlo', 'president');

-- --------------------------------------------------------

--
-- Table structure for table `kurso`
--

CREATE TABLE `kurso` (
  `id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kurso`
--

INSERT INTO `kurso` (`id`, `course`) VALUES
(1, 'Bachelor of Science in Architecture'),
(2, 'Bachelor of Science in Interior Design'),
(3, 'Bachelor in Fine Arts'),
(4, 'Bachelor of Science in Applied Physics'),
(5, 'Bachelor of Science in Computer Science'),
(6, 'Batsilyer sa Agham sa Impormasyong Panteknolohiya'),
(7, 'Bachelor of Science in Psychology'),
(8, 'Bachelor of Science in Mathematics'),
(9, 'Bachelor of Science in Business Administration'),
(10, 'Bachelor of Science in Entrepreneurship'),
(11, 'Bachelor of Science in Office Management'),
(12, 'Bachelor of Science in Public Administration'),
(13, 'Bachelor in Secondary Education'),
(14, 'Bachelor in Special Needs Education'),
(15, 'Bachelor in Technology and Livelihood Education'),
(16, 'Professional Education/Subjects'),
(17, 'Bachelor of Science in Chemical Engineering'),
(18, 'Bachelor of Science in Civil Engineering'),
(19, 'Bachelor of Science in Electrical Engineering'),
(20, 'Bachelor of Science in Mechanical Engineering'),
(21, 'Bachelor of Science in Computer Engineering'),
(22, 'Bachelor of Science in Tourism Management'),
(23, 'Bachelor of Science in Hospitality Management'),
(24, 'Bachelor of Science in Industrial Technology'),
(25, 'Bachelor of Science in Criminology');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `major` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`id`, `course`, `major`) VALUES
(1, 2, 'Painting'),
(2, 2, 'Visual Communication'),
(3, 13, 'Science'),
(4, 13, 'Mathematics'),
(5, 13, 'Filipino'),
(6, 15, 'Home Economics'),
(7, 15, 'Industrial Arts'),
(8, 24, 'Automotive Technology'),
(9, 24, 'Electrical Technology'),
(10, 24, 'Electronics Technology'),
(11, 24, 'Food Technology'),
(12, 24, 'Fashion and Apparel Technology'),
(13, 24, 'Industrial Chemistry'),
(14, 24, 'Drafting Technology'),
(15, 24, 'Machine Shop Technology');

-- --------------------------------------------------------

--
-- Table structure for table `medyor`
--

CREATE TABLE `medyor` (
  `id` int(11) NOT NULL,
  `major` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medyor`
--

INSERT INTO `medyor` (`id`, `major`) VALUES
(1, 'Painting'),
(2, 'Visual Communication'),
(3, 'Science'),
(4, 'Mathematics'),
(5, 'Filipino'),
(6, 'Home Economics'),
(7, 'Industrial Arts'),
(8, 'Automotive Technology'),
(9, 'Electrical Technology'),
(10, 'Electronics Technology'),
(11, 'Food Technology'),
(12, 'Fashion and Apparel Technology'),
(13, 'Industrial Chemistry'),
(14, 'Drafting Technology'),
(15, 'Machine Shop Technology');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `id` int(11) NOT NULL,
  `prefix` varchar(10) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `prefix`, `lastname`, `firstname`, `middlename`) VALUES
(1, 'Ms.', 'Cornell', 'Devorah Anne', 'V'),
(2, 'Ms.', 'Gamil', 'Dasha Marie', 'T'),
(3, 'Mr.', 'Costales', 'Jefferson', 'A'),
(4, 'Dr.', 'Paguigan', 'Jesus', 'S'),
(5, 'Ms.', 'Anuncio', 'Hazel', 'F'),
(6, 'Ms.', 'Fajardo', 'Joevelyn', ''),
(7, 'Ms.', 'Latip', 'Merlita', 'C'),
(8, 'Ms.', 'Matias', 'Shiela Marie', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `code` varchar(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `unitlec` varchar(11) NOT NULL,
  `unitlab` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `code`, `title`, `unitlec`, `unitlab`) VALUES
(1, 'GELIFEWR', 'The Life and Works of Rizal', '3.0', '0.0'),
(2, 'GEELECES', 'Environtmental Science', '3.0', '0.0'),
(3, 'MOBAPLEC', 'Mobile Application Development (iOS & Android) Lecture', '2.0', '0.0'),
(4, 'MOBAPLAB', 'Mobile Application Development (iOS & Android) Laboratory', '0.0', '1.0'),
(5, 'PFORMTEC', 'Platform Technologies', '2.0', '1.0'),
(6, 'ITTHESI1', 'Capstone Project and Research 1', '3.0', '0.0'),
(7, 'IAASLEC2', 'Information Assurance and Security 2 (Lecture)', '2.0', '0.0'),
(8, 'IAASLAB2', 'Information Assurance and Security 2 (Laboratory)', '0.0', '1.0'),
(9, 'SYSARCH1', 'Systems Integration and Architecture 1 (Lecture)', '2.0', '0.0'),
(10, 'SYSARLB1', 'Systems Integration and Architecture 1 (Laboratory)', '0.0', '1.0'),
(11, 'ITINTERN', 'Practicum/Internship', '10.0', '0.0');

-- --------------------------------------------------------

--
-- Table structure for table `subjectprofessor`
--

CREATE TABLE `subjectprofessor` (
  `id` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `professor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjectprofessor`
--

INSERT INTO `subjectprofessor` (`id`, `subject`, `professor`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 3),
(5, 5, 4),
(6, 6, 5),
(7, 7, 6),
(8, 8, 6),
(9, 9, 7),
(10, 10, 7),
(11, 11, 5),
(12, 11, 6),
(13, 11, 8),
(14, 6, 8);

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
(1, 'OJT2023-0011', 'louie', 'Louie Jay E. Tutor', 'Eregi2023');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coursesubject`
--
ALTER TABLE `coursesubject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dean`
--
ALTER TABLE `dean`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `head`
--
ALTER TABLE `head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kurso`
--
ALTER TABLE `kurso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medyor`
--
ALTER TABLE `medyor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjectprofessor`
--
ALTER TABLE `subjectprofessor`
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
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `coursesubject`
--
ALTER TABLE `coursesubject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dean`
--
ALTER TABLE `dean`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `head`
--
ALTER TABLE `head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kurso`
--
ALTER TABLE `kurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `medyor`
--
ALTER TABLE `medyor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subjectprofessor`
--
ALTER TABLE `subjectprofessor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
