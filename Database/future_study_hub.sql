-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 05:18 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `future_study_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `password`) VALUES
(0, 'admin', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `exam_date` datetime NOT NULL,
  `total_marks` int(11) NOT NULL,
  `passing_marks` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `sub_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `exam`
--
DELIMITER $$
CREATE TRIGGER `trg_exam_date_validation` BEFORE INSERT ON `exam` FOR EACH ROW SET NEW.exam_date = IF(NEW.exam_date < NOW(), NOW(), NEW.exam_date)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `feedback_text` varchar(255) DEFAULT NULL,
  `feedback_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `feedback`
--
DELIMITER $$
CREATE TRIGGER `trg_feedback_date_validation` BEFORE INSERT ON `feedback` FOR EACH ROW SET NEW.feedback_date = IF(NEW.feedback_date > NOW(), NOW(), NEW.feedback_date)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sub_id` int(11) DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `material_name`, `description`, `sub_id`, `pdf_path`) VALUES
(1, 'log_book', 'book', 2, 'uploads/project_log_book.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `description`) VALUES
(1, 'IELTS GENERAL ', 'Purpose: The General Training version is usually taken by those who wish to migrate to an English-speaking country for work, training programs, or secondary education.'),
(2, 'IELTS ACADEMIC', 'Purpose: This version of the test is primarily for individuals who plan to pursue higher education or professional registration in an English-speaking environment.');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `noticeTitle` varchar(255) DEFAULT NULL,
  `noticeDetails` mediumtext DEFAULT NULL,
  `Date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `noticeTitle`, `noticeDetails`, `Date`) VALUES
(1, 'EXAM DATE', '26-03-2024 Start Internal Exam.', '2024-03-23 04:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `onetimepassword`
--

CREATE TABLE `onetimepassword` (
  `id` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `right_mark` int(11) NOT NULL,
  `wrong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(8) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `enrollment_date` date DEFAULT current_timestamp(),
  `validation` varchar(50) NOT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `email`, `dob`, `password`, `contact_no`, `gender`, `enrollment_date`, `validation`, `module_id`) VALUES
(1, 'Manthan', 'sinojiyamanthan01@gmail.com', '2005-03-23', '82a85d8a', 2147483647, 'male', NULL, '', NULL),
(2, 'monu', 'admin@gmail.com', '2000-03-23', '9aaf4a4d', 2147483647, 'male', '2024-03-18', '', NULL),
(3, 'manthan', 'Manthan@gmail.com', '2024-03-18', 'ea63b607', 2147483647, 'male', '2024-03-19', '', NULL),
(4, 'dhamo', 'dkathiriya2005@gmail.com', '2000-10-11', '0bc5c73a', 1234567890, 'male', '2024-03-19', '', NULL),
(5, 'Zeel', 'zeel@gmail.com', '2004-08-01', '91a18835', 2147483647, 'male', '2024-03-22', '', NULL),
(6, 'manthan', 'sinojiyamanthan23@gmail.com', '2005-03-23', 'manthan', 2147483647, 'male', '2024-03-27', '', NULL);

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `trg_encrypt_password` BEFORE INSERT ON `student` FOR EACH ROW SET NEW.password = SHA2(NEW.password, 256)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_enrollment_date_validation` BEFORE INSERT ON `student` FOR EACH ROW SET NEW.enrollment_date = IF(NEW.enrollment_date > NOW(), NOW(), NEW.enrollment_date)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(100) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`sub_id`, `sub_name`, `module_id`, `description`) VALUES
(1, 'Listening', 1, ' Purpose: This section assesses the ability to understand spoken English in various contexts.'),
(2, 'Writing', 1, ' Purpose: This section evaluates the ability to present written information effectively and construct well-argued essays.'),
(3, 'Reading', 1, 'Purpose: This section measures reading skills and the ability to grasp information from different written sources.'),
(4, 'Speaking', 1, ' Purpose: This section evaluates spoken English proficiency, including pronunciation, fluency, and the ability to engage in a conversation.');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` int(11) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `dob` date NOT NULL,
  `validation` varchar(100) NOT NULL,
  `course_field` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `module_name` varchar(20) NOT NULL,
  `hire_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_name`, `email`, `contact_no`, `gender`, `dob`, `validation`, `course_field`, `password`, `module_id`, `module_name`, `hire_date`) VALUES
(1, 'Preet ', 'sinojiyamanthan01@gmail.com', 2147483647, 'Male', '1990-02-09', '', 'Reading', '0FgZiDvv', 1, '', '2024-03-18 00:00:00'),
(2, 'manthan', 'sinojiyamanthan23@gmail.com', 2147483647, 'Male', '2000-01-04', '', 'Listening', 'password', 2, '', '2024-03-23 00:00:00'),
(4, 'Deep', 'deepkhirasariya1@gmail.com', 1234567890, 'male', '2006-12-05', '', 'Writing', 'password', 2, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wr_quiz`
--

CREATE TABLE `wr_quiz` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `sub_id` (`sub_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `sub_id` (`sub_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `sub_id` (`sub_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `student_ibfk_1` (`module_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `wr_quiz`
--
ALTER TABLE `wr_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wr_quiz`
--
ALTER TABLE `wr_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `exam_ibfk_2` FOREIGN KEY (`sub_id`) REFERENCES `subject` (`sub_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `subject` (`sub_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`),
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`sub_id`) REFERENCES `subject` (`sub_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`);

--
-- Constraints for table `wr_quiz`
--
ALTER TABLE `wr_quiz`
  ADD CONSTRAINT `wr_quiz_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

ALTER TABLE `video_access`
  ADD CONSTRAINT `video_access_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
