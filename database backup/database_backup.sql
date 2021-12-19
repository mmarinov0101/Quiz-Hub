-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2021 at 01:13 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStudentScoresBelowForty` ()  BEGIN
    
    SELECT final_score, user_forename, user_surname, username FROM attempt NATURAL JOIN user WHERE attempt.final_score < 40 AND !is_staff; 
    
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(10) UNSIGNED NOT NULL,
  `answer_content` varchar(300) NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `is_correct` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attempt`
--

CREATE TABLE `attempt` (
  `attempt_id` int(10) UNSIGNED NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `date_of_attempt` date NOT NULL,
  `final_score` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_quizzes`
--

CREATE TABLE `deleted_quizzes` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `date_of_deletion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(10) UNSIGNED NOT NULL,
  `question_content` varchar(300) NOT NULL,
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `question_score` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(10) UNSIGNED NOT NULL,
  `quiz_name` varchar(100) NOT NULL,
  `quiz_author_username` varchar(50) NOT NULL,
  `quiz_available` bit(1) NOT NULL,
  `quiz_duration_in_minutes` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `quiz`
--
DELIMITER $$
CREATE TRIGGER `before_quiz_delete` BEFORE DELETE ON `quiz` FOR EACH ROW INSERT INTO deleted_quizzes
  SET quiz_id = OLD.quiz_id,
  	  staff_id = OLD.quiz_author_username,
      date_of_deletion = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `user_password_hash` varbinary(8000) NOT NULL,
  `user_forename` varchar(50) NOT NULL,
  `user_surname` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_staff` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `attempt`
--
ALTER TABLE `attempt`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `deleted_quizzes`
--
ALTER TABLE `deleted_quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD UNIQUE KEY `quiz_id` (`quiz_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attempt`
--
ALTER TABLE `attempt`
  MODIFY `attempt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON UPDATE CASCADE;

--
-- Constraints for table `attempt`
--
ALTER TABLE `attempt`
  ADD CONSTRAINT `attempt_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `attempt_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `deleted_quizzes`
--
ALTER TABLE `deleted_quizzes`
  ADD CONSTRAINT `deleted_quizzes_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `user` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
