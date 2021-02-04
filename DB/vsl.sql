-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2020 at 01:50 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsl`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(33) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `payable_amount` int(20) NOT NULL,
  `target_date` date NOT NULL,
  `assigned_person` varchar(100) NOT NULL,
  `created_user` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `project_name`, `payable_amount`, `target_date`, `assigned_person`, `created_user`, `create_date`) VALUES
(5, '5', 4543, '2020-01-01', '1,2,4', 1, '2020-01-27 05:31:51'),
(6, 'two', 343, '2019-12-31', '1,2', 1, '2020-01-27 05:32:23'),
(7, 'sdsdfdsf', 343, '2020-01-16', '1', 1, '2020-01-27 05:32:34'),
(8, 'one', 0, '0000-00-00', '', 1, '2020-01-27 08:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `collect_bills`
--

CREATE TABLE `collect_bills` (
  `id` int(11) NOT NULL,
  `project_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `collection_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collect_bills`
--

INSERT INTO `collect_bills` (`id`, `project_id`, `amount`, `collection_date`, `created_at`) VALUES
(1, 6, 333, '2020-01-22', '2020-01-27 08:14:49'),
(2, 6, 10, '2020-02-07', '2020-01-27 08:20:39'),
(3, 7, 2147483647, '2020-01-30', '2020-01-27 08:37:31'),
(4, 5, 444, '2020-01-29', '2020-01-29 09:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE `developers` (
  `id` int(23) NOT NULL,
  `title` varchar(255) NOT NULL,
  `task_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `update_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `title`, `task_manager`, `assignment`, `status`, `team_member`, `assign_date`, `delivery_date`, `remarks`, `update_date`, `created_user`) VALUES
(9, '1', '2', '<p>fdgff<br></p>', 'Skipped', '1, 2', '2020-01-01', '2020-01-07', 'fdsfdsf', '2020-01-21', 1),
(10, 'dsfdsf', '2', '<p>cbvvcbvbv<br></p>', 'In Progress', '2', '2020-01-15', '2020-01-10', 'dsfdsf', '2020-01-08', 1),
(11, 'sdsad', '2', '<p>cvcv<br></p>', 'In Progress', '2', '2020-01-01', '2020-01-06', 'sdsad', '2020-01-22', 1),
(12, '45435435sdsadsadsa', '1', '<ol><li>sadsad</li><li>sad</li><li>sad</li><li>sadddddddddddddddddddddddddddddddddd</li><li>dsa</li><li>d</li><li>sad</li><li>sad<br></li></ol>', 'Skipped', '2', '2019-04-17', '2019-12-31', '435435sdsds', '2020-01-01', 1),
(13, 'sdsadsad', 'Select Manager', '<p>dsfdsfdsf<br></p>', 'In Progress', '1, 2', '2020-01-07', '2020-01-02', 'sadasd', '2020-01-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `marketings`
--

CREATE TABLE `marketings` (
  `id` int(23) NOT NULL,
  `title` varchar(255) NOT NULL,
  `task_manager` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assignment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `update_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marketings`
--

INSERT INTO `marketings` (`id`, `title`, `task_manager`, `assignment`, `status`, `team_member`, `amount`, `assign_date`, `delivery_date`, `remarks`, `update_date`, `created_user`) VALUES
(9, 'dsfdsf', '2', '<p>cvcxvcx<br></p>', 'Done', '1, 2', '455454', '2020-01-02', '2020-01-02', 'dsfdsf', '2020-01-31', 0),
(10, 'dsfdsf', '2', '<p>cbvvcbvbv<br></p>', 'In Progress', '2', '4543', '2020-01-15', '2020-01-10', 'dsfdsf', '2020-01-08', 1),
(11, 'sdsad44', '1', '<p>cvcv4444444444<br></p>', 'Done', '1', '433444444444', '2020-01-01', '2020-01-06', 'sdsad444', '2020-01-28', 0),
(12, '45435435', '1', '<ol><li>sadsad</li><li>sad</li><li>sad</li><li>sa</li><li>dsa</li><li>d</li><li>sad</li><li>sad<br></li></ol>', 'Done', '2', '45354', '2020-01-17', '2019-12-31', '435435', '2020-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spouse_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_married` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `official_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person_relations` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact_person_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `previous_working_experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `references` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `emp_type`, `company`, `father_name`, `mother_name`, `spouse_name`, `is_married`, `personal_phone`, `official_phone`, `current_address`, `permanent_address`, `national_id`, `passport_no`, `blood_group`, `emergency_contact_person`, `emergency_contact_person_relations`, `emergency_contact_person_phone`, `previous_working_experience`, `references`, `dob`, `join_date`, `work_type`, `resume`, `photo`, `status`, `department_name`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'monir', 'a@gmail.com', '96e79218965eb72c92a549dd5a330112', 'super_admin', '22', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'images/491-4917283_software-development-company-banner-hd-png-download.png', '', '', '', '2020-01-21 07:04:00', '2020-01-21 07:04:00'),
(2, 'Karim', 'ab@gmail.com', '96e79218965eb72c92a549dd5a330112', 'super_admin', '22', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'images/491-4917283_software-development-company-banner-hd-png-download.png', '', '', '', '2020-01-21 07:04:00', '2020-01-21 07:04:00'),
(4, 'kobir', 'azzxzxd@gmail.com', '9a1d5a1c27be75c831130d667c8a9f07', 'super_admin', 'venture_solution, moiur', 'dsfdsf', 'dsfdsf', 'fdgdfg', 'married', '543543543543', '', 'fdgfdg', 'fdgdf', '43543543', '435435435', '4', 'dfdsf', 'dsfdsf', '4354543543543', '', 'gfdgfd', '2020-01-17', '2020-01-24', 'fdgfdg', 'resumes/72334958_2668197576544377_4583711187031556096_n.png', 'images/491-4917283_software-development-company-banner-hd-png-download.png', 'active', 'software_department', 'junior_developer', '2020-01-22 07:04:20', '2020-01-22 07:04:20'),
(5, 'fdsfdsf', 'admsdsdsin@gmail.com', '15c3ccf6be6413af817eae3a5f91a591', 'team_lead', 'moiur', 'dssad', 'sdsad', 'sdsads', 'unmarried', '343433', '323432432', 'dsdfdsf', 'dfdsfds', '32423432', '34324', '32', '343', 'ewewq', '34343', '3', 'sdsad', '2020-01-15', '2016-02-16', 'dfdf', 'resumes/magazine .jpg', '491-4917283_software-development-company-banner-hd-png-download.png', 'active', 'marketting_department', 'junior_developer', '2020-01-27 09:13:29', '2020-01-27 09:13:29'),
(6, 'monir', 'admin@gmail.com', '96e79218965eb72c92a549dd5a330112', 'super_admin', '22', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'images/491-4917283_software-development-company-banner-hd-png-download.png', '', '', '', '2020-01-21 07:04:00', '2020-01-21 07:04:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collect_bills`
--
ALTER TABLE `collect_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketings`
--
ALTER TABLE `marketings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `collect_bills`
--
ALTER TABLE `collect_bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int(23) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `marketings`
--
ALTER TABLE `marketings`
  MODIFY `id` int(23) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
