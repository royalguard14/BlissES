-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 03:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blissec`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` int(11) NOT NULL,
  `start` year(4) NOT NULL,
  `end` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `start`, `end`) VALUES
(4, 2024, 2025),
(6, 2025, 2026);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `eh_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('P','A','T','E') NOT NULL COMMENT 'P = Present, A = Absent, T = Tardy, E = Excused',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `user_id`, `eh_id`, `date`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(13, 220, 33, '2024-11-25', 'A', 'sakit sa ulo', '2024-11-24 16:27:11', '2024-11-25 02:41:08'),
(15, 222, 20, '2024-11-26', 'P', NULL, '2024-11-24 16:39:14', '2024-11-25 02:25:59'),
(16, 221, 34, '2024-11-25', 'E', 'usato', '2024-11-24 16:39:26', '2024-11-24 17:11:43'),
(17, 223, 21, '2024-11-25', 'P', NULL, '2024-11-24 16:39:34', '2024-11-24 16:55:11'),
(18, 224, 22, '2024-11-25', 'P', NULL, '2024-11-24 16:51:38', '2024-11-24 16:55:12'),
(19, 225, 23, '2024-11-25', 'P', NULL, '2024-11-24 16:51:50', '2024-11-24 16:59:13'),
(20, 236, 30, '2024-11-25', 'E', 'sad', '2024-11-24 16:52:32', '2024-11-24 17:12:20'),
(21, 230, 28, '2024-11-25', 'P', NULL, '2024-11-24 17:03:28', '2024-11-24 17:03:28'),
(22, 222, 20, '2024-11-25', 'P', NULL, '2024-11-25 02:41:18', '2024-11-25 02:41:18'),
(23, 221, 34, '2024-11-28', 'P', NULL, '2024-11-28 06:37:50', '2024-11-28 06:37:50'),
(24, 220, 33, '2024-12-11', 'P', NULL, '2024-12-11 12:24:49', '2024-12-11 12:24:49'),
(25, 221, 34, '2024-12-11', 'E', NULL, '2024-12-11 12:24:52', '2024-12-11 12:25:13'),
(26, 231, 35, '2024-12-12', 'P', NULL, '2024-12-12 14:18:52', '2024-12-12 14:18:52'),
(27, 232, 36, '2024-12-12', 'A', NULL, '2024-12-12 14:18:53', '2024-12-12 14:18:53'),
(28, 233, 37, '2024-12-12', 'P', NULL, '2024-12-12 14:18:55', '2024-12-12 14:18:55'),
(29, 234, 38, '2024-12-12', 'P', NULL, '2024-12-12 14:18:56', '2024-12-12 14:18:56'),
(30, 235, 39, '2024-12-12', 'P', NULL, '2024-12-12 14:18:57', '2024-12-12 14:18:57'),
(31, 231, 35, '2024-12-14', 'P', NULL, '2024-12-13 23:58:05', '2024-12-13 23:58:05'),
(32, 232, 36, '2024-12-14', 'P', NULL, '2024-12-13 23:58:06', '2024-12-13 23:58:06'),
(33, 233, 37, '2024-12-14', 'P', NULL, '2024-12-13 23:58:07', '2024-12-13 23:58:07'),
(34, 234, 38, '2024-12-14', 'A', NULL, '2024-12-13 23:58:08', '2024-12-13 23:58:08'),
(35, 235, 39, '2024-12-14', 'P', NULL, '2024-12-13 23:58:10', '2024-12-13 23:58:10'),
(36, 246, 43, '2024-12-14', 'P', NULL, '2024-12-14 03:06:53', '2024-12-14 03:06:53'),
(37, 247, 44, '2024-12-14', 'A', NULL, '2024-12-14 03:06:54', '2024-12-14 03:06:54'),
(38, 238, 40, '2024-12-14', 'T', NULL, '2024-12-14 03:06:55', '2024-12-14 03:20:40'),
(39, 240, 41, '2024-12-14', 'E', 'Headache', '2024-12-14 03:06:56', '2024-12-14 03:20:56'),
(40, 242, 42, '2024-12-14', 'A', NULL, '2024-12-14 03:06:57', '2024-12-14 03:06:57'),
(41, 250, 50, '2024-12-14', 'P', NULL, '2024-12-14 03:29:38', '2024-12-14 03:29:38'),
(42, 251, 51, '2024-12-14', 'T', NULL, '2024-12-14 03:29:39', '2024-12-14 03:29:39'),
(43, 312, 68, '2024-12-14', 'P', NULL, '2024-12-14 03:29:41', '2024-12-14 03:29:41'),
(44, 313, 69, '2024-12-14', 'P', NULL, '2024-12-14 03:29:41', '2024-12-14 03:29:41'),
(45, 314, 70, '2024-12-14', 'T', NULL, '2024-12-14 03:29:42', '2024-12-14 03:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `campus_info`
--

CREATE TABLE `campus_info` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `function` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campus_info`
--

INSERT INTO `campus_info` (`id`, `name`, `function`) VALUES
(1, 'School Name', 'BLISS Elementary School'),
(2, 'School ID', '132112'),
(3, 'Address', 'Bliss Libertad, Butuan City'),
(4, 'Logo', NULL),
(5, 'Principal', 'Luz F. Bongabong'),
(6, 'Present School Year', '4'),
(7, 'Institutional Email', '@gmail.com'),
(8, 'Grading', '1'),
(9, 'Time out Duration (Seconds)', '10'),
(10, 'Title', 'Bliss Elementary School'),
(11, 'System name', 'Web-based Student Records Management System for Bliss Elementary School');

-- --------------------------------------------------------

--
-- Table structure for table `emoji`
--

CREATE TABLE `emoji` (
  `id` int(11) NOT NULL,
  `shortcode` varchar(50) NOT NULL,
  `unicode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_history`
--

CREATE TABLE `enrollment_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `grade_level_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `adviser_id` int(11) NOT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollment_history`
--

INSERT INTO `enrollment_history` (`id`, `user_id`, `grade_level_id`, `section_id`, `adviser_id`, `academic_year_id`, `enrollment_date`) VALUES
(20, 222, 2, 30, 260, 4, '2024-06-06'),
(21, 223, 2, 30, 260, 4, '2024-11-24'),
(22, 224, 2, 30, 260, 4, '2024-11-24'),
(23, 225, 2, 30, 260, 4, '2024-11-24'),
(24, 226, 2, 30, 260, 4, '2024-11-24'),
(25, 227, 2, 30, 260, 4, '2024-11-24'),
(26, 228, 2, 30, 260, 4, '2024-11-24'),
(27, 229, 2, 30, 260, 4, '2024-11-24'),
(28, 230, 2, 30, 260, 4, '2024-11-24'),
(29, 239, 2, 30, 260, 4, '2024-11-24'),
(30, 236, 2, 30, 260, 4, '2024-11-24'),
(31, 237, 2, 30, 260, 4, '2024-11-24'),
(32, 241, 2, 30, 260, 4, '2024-11-24'),
(33, 220, 2, 30, 260, 4, '2024-11-24'),
(34, 221, 2, 30, 260, 4, '2024-11-24'),
(35, 231, 1, 11, 267, 4, '2024-12-12'),
(36, 232, 1, 11, 267, 4, '2024-12-12'),
(37, 233, 1, 11, 267, 4, '2024-12-12'),
(38, 234, 1, 11, 267, 4, '2024-12-12'),
(39, 235, 1, 11, 267, 4, '2024-12-12'),
(40, 238, 2, 21, 289, 4, '2024-12-13'),
(41, 240, 2, 21, 289, 4, '2024-12-13'),
(42, 242, 2, 21, 289, 4, '2024-12-13'),
(43, 246, 2, 21, 289, 4, '2024-12-13'),
(44, 247, 2, 21, 289, 4, '2024-12-13'),
(45, 243, 2, 34, 271, 4, '2024-12-13'),
(46, 244, 2, 34, 271, 4, '2024-12-13'),
(47, 245, 2, 34, 271, 4, '2024-12-13'),
(48, 248, 2, 34, 271, 4, '2024-12-13'),
(49, 249, 2, 34, 271, 4, '2024-12-13'),
(50, 250, 3, 1, 275, 4, '2024-12-13'),
(51, 251, 3, 1, 275, 4, '2024-12-13'),
(52, 252, 3, 1, 275, 4, '2024-12-13'),
(53, 253, 3, 3, 293, 4, '2024-12-13'),
(54, 254, 3, 3, 293, 4, '2024-12-13'),
(55, 255, 3, 3, 293, 4, '2024-12-13'),
(56, 256, 3, 3, 293, 4, '2024-12-13'),
(57, 257, 4, 54, 277, 4, '2024-12-13'),
(58, 258, 4, 54, 277, 4, '2024-12-13'),
(59, 259, 4, 54, 277, 4, '2024-12-13'),
(60, 294, 6, 100, 281, 4, '2024-12-13'),
(61, 295, 6, 100, 281, 4, '2024-12-13'),
(62, 296, 6, 100, 281, 4, '2024-12-13'),
(63, 297, 6, 100, 281, 4, '2024-12-13'),
(64, 298, 6, 100, 281, 4, '2024-12-13'),
(65, 308, 6, 100, 281, 4, '2024-12-13'),
(66, 309, 6, 100, 281, 4, '2024-12-13'),
(67, 310, 6, 100, 281, 4, '2024-12-13'),
(68, 312, 3, 1, 275, 4, '2024-12-13'),
(69, 313, 3, 1, 275, 4, '2024-12-13'),
(70, 314, 3, 1, 275, 4, '2024-12-13'),
(71, 315, 4, 54, 277, 4, '2024-12-13'),
(72, 316, 4, 54, 277, 4, '2024-12-13'),
(73, 317, 4, 54, 277, 4, '2024-12-13'),
(74, 299, 4, 64, 278, 4, '2024-12-13'),
(75, 300, 4, 64, 278, 4, '2024-12-13'),
(76, 301, 4, 64, 278, 4, '2024-12-13'),
(77, 311, 4, 64, 278, 4, '2024-12-13'),
(78, 318, 4, 64, 278, 4, '2024-12-13'),
(79, 319, 4, 64, 278, 4, '2024-12-13'),
(80, 302, 5, 86, 279, 4, '2024-12-13'),
(81, 303, 5, 86, 279, 4, '2024-12-13'),
(82, 304, 5, 86, 279, 4, '2024-12-13'),
(83, 305, 5, 86, 279, 4, '2024-12-13'),
(84, 320, 5, 86, 279, 4, '2024-12-13'),
(85, 321, 5, 86, 279, 4, '2024-12-13'),
(86, 322, 5, 86, 279, 4, '2024-12-13'),
(87, 306, 5, 75, 280, 4, '2024-12-13'),
(88, 307, 5, 75, 280, 4, '2024-12-13'),
(89, 330, 3, 3, 293, 4, '2024-12-13'),
(90, 331, 3, 3, 293, 4, '2024-12-13'),
(91, 332, 3, 3, 293, 4, '2024-12-13'),
(92, 323, 5, 75, 280, 4, '2024-12-13'),
(93, 333, 5, 75, 280, 4, '2024-12-13'),
(94, 334, 5, 75, 280, 4, '2024-12-13'),
(95, 335, 5, 75, 280, 4, '2024-12-13'),
(96, 324, 6, 92, 282, 4, '2024-12-13'),
(97, 325, 6, 92, 282, 4, '2024-12-13'),
(98, 326, 6, 92, 282, 4, '2024-12-13'),
(99, 336, 6, 92, 282, 4, '2024-12-13'),
(100, 337, 6, 92, 282, 4, '2024-12-13'),
(101, 338, 6, 92, 282, 4, '2024-12-13'),
(102, 327, 7, 105, 283, 4, '2024-12-13'),
(103, 328, 7, 105, 283, 4, '2024-12-13'),
(104, 329, 7, 105, 283, 4, '2024-12-13'),
(105, 339, 7, 105, 283, 4, '2024-12-13'),
(106, 340, 7, 105, 283, 4, '2024-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `grade_level`
--

CREATE TABLE `grade_level` (
  `id` int(11) NOT NULL,
  `level` varchar(20) NOT NULL,
  `section_ids` varchar(500) DEFAULT NULL,
  `subject_ids` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grade_level`
--

INSERT INTO `grade_level` (`id`, `level`, `section_ids`, `subject_ids`) VALUES
(1, 'Kinder Garden', '2,4,5,6,7,8,9,10,11,12,13,14,15,16', '17,18,19,20'),
(2, 'Grade I', '17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', '1,2,3,4,5'),
(3, 'Grade II', '1,3', '6,7,8,9,10'),
(4, 'Grade III', '54,64', '11,12,13,14,15,16'),
(5, 'Grade IV', '75,86', '21,22,23,24,25,26,27'),
(6, 'Grade V', '92,100', NULL),
(7, 'Grade VI', '105,110', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_records`
--

CREATE TABLE `grade_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `eh_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grading_id` int(11) NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grade_records`
--

INSERT INTO `grade_records` (`id`, `user_id`, `eh_id`, `subject_id`, `grading_id`, `grade`, `created_at`, `updated_at`) VALUES
(1, 222, 20, 1, 1, '80.00', '2024-11-28 10:24:16', '2024-11-28 10:46:50'),
(2, 221, 34, 1, 1, '90.00', '2024-11-28 10:24:24', '2024-11-28 10:27:37'),
(3, 221, 34, 2, 1, '86.00', '2024-11-28 10:24:27', '2024-11-28 10:27:34'),
(4, 221, 34, 3, 1, '80.00', '2024-11-28 10:27:31', '2024-11-28 10:27:31'),
(5, 222, 20, 2, 1, '100.00', '2024-11-28 10:46:54', '2024-11-28 10:46:54'),
(6, 220, 33, 1, 2, '89.00', '2024-12-11 12:22:59', '2024-12-11 12:22:59'),
(7, 220, 33, 2, 2, '87.00', '2024-12-11 12:23:10', '2024-12-11 12:23:10'),
(8, 220, 33, 3, 2, '60.00', '2024-12-11 12:23:15', '2024-12-11 12:23:16'),
(9, 220, 33, 4, 2, '90.00', '2024-12-11 12:23:19', '2024-12-11 12:23:19'),
(10, 220, 33, 5, 2, '89.00', '2024-12-11 12:23:23', '2024-12-11 12:23:23'),
(11, 221, 34, 1, 2, '90.00', '2024-12-11 12:23:35', '2024-12-11 12:23:35'),
(12, 221, 34, 2, 2, '91.00', '2024-12-11 12:23:36', '2024-12-11 12:23:36'),
(13, 221, 34, 3, 2, '89.00', '2024-12-11 12:23:39', '2024-12-11 12:23:40'),
(14, 221, 34, 4, 2, '70.00', '2024-12-11 12:23:41', '2024-12-11 12:23:41'),
(15, 221, 34, 5, 2, '89.00', '2024-12-11 12:23:43', '2024-12-11 12:23:43'),
(16, 233, 37, 17, 2, '80.00', '2024-12-12 14:16:27', '2024-12-12 14:17:05'),
(17, 233, 37, 18, 2, '85.00', '2024-12-12 14:17:06', '2024-12-12 14:17:12'),
(18, 233, 37, 19, 2, '90.00', '2024-12-12 14:17:13', '2024-12-12 14:17:14'),
(19, 233, 37, 20, 2, '90.00', '2024-12-12 14:17:16', '2024-12-12 14:17:16'),
(20, 234, 38, 17, 2, '82.00', '2024-12-12 14:17:20', '2024-12-12 14:17:24'),
(21, 234, 38, 18, 2, '89.00', '2024-12-12 14:17:27', '2024-12-12 14:17:27'),
(22, 234, 38, 19, 2, '87.00', '2024-12-12 14:17:32', '2024-12-12 14:17:35'),
(23, 234, 38, 20, 2, '88.00', '2024-12-12 14:17:38', '2024-12-12 14:17:38'),
(24, 235, 39, 17, 2, '90.00', '2024-12-12 14:17:42', '2024-12-12 14:17:44'),
(25, 235, 39, 18, 2, '87.00', '2024-12-12 14:17:47', '2024-12-12 14:17:47'),
(26, 235, 39, 19, 2, '91.00', '2024-12-12 14:17:50', '2024-12-12 14:17:51'),
(27, 235, 39, 20, 2, '95.00', '2024-12-12 14:17:54', '2024-12-12 14:17:55'),
(28, 231, 35, 17, 2, '91.00', '2024-12-12 14:17:58', '2024-12-12 14:18:04'),
(29, 231, 35, 18, 2, '86.00', '2024-12-12 14:18:08', '2024-12-12 14:18:08'),
(30, 231, 35, 19, 2, '88.00', '2024-12-12 14:18:11', '2024-12-12 14:18:11'),
(31, 231, 35, 20, 2, '92.00', '2024-12-12 14:18:13', '2024-12-12 14:18:14'),
(32, 232, 36, 17, 2, '85.00', '2024-12-12 14:18:19', '2024-12-12 14:18:22'),
(33, 232, 36, 18, 2, '86.00', '2024-12-12 14:18:24', '2024-12-12 14:18:25'),
(34, 232, 36, 19, 2, '95.00', '2024-12-12 14:18:27', '2024-12-12 14:18:28'),
(35, 232, 36, 20, 2, '89.00', '2024-12-12 14:18:31', '2024-12-12 14:18:31'),
(36, 231, 35, 17, 1, '80.00', '2024-12-14 00:17:28', '2024-12-14 00:17:35'),
(37, 231, 35, 18, 1, '89.00', '2024-12-14 00:17:35', '2024-12-14 00:17:36'),
(38, 231, 35, 19, 1, '90.00', '2024-12-14 00:17:37', '2024-12-14 00:17:38'),
(39, 231, 35, 20, 1, '87.00', '2024-12-14 00:17:40', '2024-12-14 00:17:40'),
(40, 233, 37, 17, 1, '90.00', '2024-12-14 03:00:10', '2024-12-14 03:00:14'),
(41, 233, 37, 18, 1, '89.00', '2024-12-14 03:00:16', '2024-12-14 03:00:16'),
(42, 233, 37, 19, 1, '81.00', '2024-12-14 03:00:17', '2024-12-14 03:00:18'),
(43, 233, 37, 20, 1, '90.00', '2024-12-14 03:00:20', '2024-12-14 03:00:20'),
(44, 234, 38, 17, 1, '86.00', '2024-12-14 03:00:24', '2024-12-14 03:00:25'),
(45, 234, 38, 18, 1, '88.00', '2024-12-14 03:00:26', '2024-12-14 03:00:26'),
(46, 234, 38, 19, 1, '90.00', '2024-12-14 03:00:26', '2024-12-14 03:00:27'),
(47, 234, 38, 20, 1, '91.00', '2024-12-14 03:00:28', '2024-12-14 03:00:29'),
(48, 235, 39, 17, 1, '80.00', '2024-12-14 03:00:32', '2024-12-14 03:00:35'),
(49, 235, 39, 18, 1, '87.00', '2024-12-14 03:00:37', '2024-12-14 03:00:37'),
(50, 235, 39, 19, 1, '86.00', '2024-12-14 03:00:39', '2024-12-14 03:00:40'),
(51, 235, 39, 20, 1, '81.00', '2024-12-14 03:00:43', '2024-12-14 03:00:45'),
(52, 232, 36, 17, 1, '89.00', '2024-12-14 03:01:32', '2024-12-14 03:01:33'),
(53, 232, 36, 18, 1, '87.00', '2024-12-14 03:01:36', '2024-12-14 03:01:36'),
(54, 232, 36, 19, 1, '89.00', '2024-12-14 03:01:37', '2024-12-14 03:01:38'),
(55, 232, 36, 20, 1, '90.00', '2024-12-14 03:01:40', '2024-12-14 03:01:40'),
(56, 246, 43, 1, 1, '90.00', '2024-12-14 03:07:21', '2024-12-14 03:07:21'),
(57, 246, 43, 2, 1, '80.00', '2024-12-14 03:07:22', '2024-12-14 03:07:22'),
(58, 246, 43, 3, 1, '89.00', '2024-12-14 03:07:23', '2024-12-14 03:07:23'),
(59, 246, 43, 4, 1, '82.00', '2024-12-14 03:07:24', '2024-12-14 03:07:25'),
(60, 246, 43, 5, 1, '92.00', '2024-12-14 03:07:28', '2024-12-14 03:07:28'),
(61, 238, 40, 1, 1, '92.00', '2024-12-14 03:07:32', '2024-12-14 03:07:32'),
(62, 238, 40, 2, 1, '90.00', '2024-12-14 03:07:34', '2024-12-14 03:07:34'),
(63, 238, 40, 3, 1, '87.00', '2024-12-14 03:07:35', '2024-12-14 03:07:35'),
(64, 238, 40, 4, 1, '86.00', '2024-12-14 03:07:36', '2024-12-14 03:07:36'),
(65, 238, 40, 5, 1, '95.00', '2024-12-14 03:07:38', '2024-12-14 03:07:40'),
(66, 247, 44, 1, 1, '89.00', '2024-12-14 03:08:34', '2024-12-14 03:08:34'),
(67, 247, 44, 2, 1, '90.00', '2024-12-14 03:08:36', '2024-12-14 03:08:36'),
(68, 247, 44, 3, 1, '87.00', '2024-12-14 03:08:37', '2024-12-14 03:08:37'),
(69, 247, 44, 4, 1, '86.00', '2024-12-14 03:08:38', '2024-12-14 03:08:39'),
(70, 247, 44, 5, 1, '98.00', '2024-12-14 03:08:40', '2024-12-14 03:08:40'),
(71, 312, 68, 6, 1, '87.00', '2024-12-14 03:29:24', '2024-12-14 03:29:24'),
(72, 312, 68, 7, 1, '90.00', '2024-12-14 03:29:25', '2024-12-14 03:29:26'),
(73, 312, 68, 8, 1, '85.00', '2024-12-14 03:29:29', '2024-12-14 03:29:29'),
(74, 312, 68, 9, 1, '95.00', '2024-12-14 03:29:30', '2024-12-14 03:29:31'),
(75, 312, 68, 10, 1, '91.00', '2024-12-14 03:29:34', '2024-12-14 03:29:34'),
(76, 240, 41, 1, 1, '89.00', '2024-12-14 04:06:07', '2024-12-14 04:06:09'),
(77, 240, 41, 2, 1, '87.00', '2024-12-14 04:06:10', '2024-12-14 04:06:10'),
(78, 240, 41, 3, 1, '80.00', '2024-12-14 04:06:20', '2024-12-14 04:06:20'),
(79, 240, 41, 4, 1, '85.00', '2024-12-14 04:06:23', '2024-12-14 04:06:23'),
(80, 240, 41, 5, 1, '87.00', '2024-12-14 04:06:26', '2024-12-14 04:06:26'),
(81, 242, 42, 1, 1, '89.00', '2024-12-14 04:06:28', '2024-12-14 04:06:29'),
(82, 242, 42, 2, 1, '90.00', '2024-12-14 04:06:30', '2024-12-14 04:06:32'),
(83, 242, 42, 3, 1, '89.00', '2024-12-14 04:06:37', '2024-12-14 04:06:40'),
(84, 242, 42, 4, 1, '89.00', '2024-12-14 04:06:47', '2024-12-14 04:06:47'),
(85, 242, 42, 5, 1, '90.00', '2024-12-14 04:06:49', '2024-12-14 04:06:49'),
(86, 221, 34, 4, 1, '60.00', '2024-12-19 09:11:59', '2024-12-19 09:12:02'),
(87, 222, 20, 3, 1, '90.00', '2024-12-19 09:12:23', '2024-12-19 09:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `is_read`, `sent_at`) VALUES
(1, 221, 226, 'hi', 0, '2024-11-30 23:38:43'),
(2, 221, 230, 'ccc', 0, '2024-11-30 23:39:42'),
(3, 221, 223, 'hello zhie', 0, '2024-12-01 00:40:10'),
(4, 221, 239, 'haifah', 0, '2024-12-01 00:40:27'),
(5, 221, 222, 'hello zhie', 1, '2024-12-01 00:45:03'),
(6, 221, 222, 'asd', 1, '2024-12-01 01:00:05'),
(7, 221, 222, 'sdsd', 1, '2024-12-01 01:03:45'),
(8, 221, 241, 'haifah', 0, '2024-12-01 01:11:53'),
(9, 221, 222, 'ssddsd', 1, '2024-12-01 01:47:26'),
(10, 221, 222, 'sdsd', 1, '2024-12-01 01:51:41'),
(11, 221, 222, 'oi', 1, '2024-12-01 01:52:01'),
(12, 221, 222, 'awy', 1, '2024-12-01 01:53:28'),
(13, 221, 222, 'gago', 1, '2024-12-01 01:57:48'),
(14, 222, 221, 'gwapo mo naman', 1, '2024-12-01 01:58:55'),
(15, 221, 239, 'sd', 0, '2024-12-01 02:02:08'),
(16, 221, 222, 'sd', 1, '2024-12-01 02:04:56'),
(17, 221, 222, 'dfd', 1, '2024-12-01 02:05:33'),
(18, 221, 222, 'sda', 1, '2024-12-01 02:06:28'),
(19, 221, 222, 'asdasdasd', 1, '2024-12-01 02:11:41'),
(20, 221, 222, 'asd', 1, '2024-12-01 02:19:28'),
(21, 221, 222, 'sadasd', 1, '2024-12-01 02:19:47'),
(22, 221, 222, 'sd', 1, '2024-12-01 02:26:46'),
(23, 221, 222, 'sdsdasdasd', 1, '2024-12-01 02:29:29'),
(24, 221, 222, 'sdsdasdasd', 1, '2024-12-01 02:32:14'),
(25, 221, 222, 'sdsdasdasd', 1, '2024-12-01 02:32:19'),
(26, 221, 239, 'asdasd', 0, '2024-12-01 02:32:27'),
(27, 221, 222, 'asd', 1, '2024-12-01 07:54:57'),
(28, 221, 222, 'asdasd', 1, '2024-12-01 08:30:40'),
(29, 221, 222, 'ghaiza', 1, '2024-12-01 08:31:01'),
(30, 221, 222, 'ghaiza', 1, '2024-12-01 08:31:01'),
(31, 221, 222, 'ghaizar', 1, '2024-12-01 08:31:06'),
(32, 221, 222, 'pangit', 1, '2024-12-01 08:32:13'),
(33, 221, 220, 'oi pangit', 0, '2024-12-01 08:34:33'),
(34, 221, 220, 'oi', 0, '2024-12-01 08:35:35'),
(35, 221, 220, 'oi', 0, '2024-12-01 08:40:03'),
(36, 221, 220, 'asdasd', 0, '2024-12-01 08:40:52'),
(37, 221, 220, 'asdasd', 0, '2024-12-01 08:41:21'),
(38, 221, 220, 'asd', 0, '2024-12-01 08:42:25'),
(39, 221, 222, 'kalo', 1, '2024-12-01 08:44:59'),
(40, 221, 222, 'kalo', 1, '2024-12-01 08:45:07'),
(41, 221, 222, 'oi', 1, '2024-12-01 08:48:31'),
(42, 221, 220, 'asgfaastgas', 0, '2024-12-01 08:50:39'),
(43, 221, 220, 'pangit mo ba', 0, '2024-12-01 08:50:51'),
(44, 221, 222, 'awit ka', 1, '2024-12-01 08:51:26'),
(45, 221, 220, 'po', 0, '2024-12-01 09:02:39'),
(46, 221, 239, '1', 0, '2024-12-01 09:02:50'),
(47, 221, 239, '2', 0, '2024-12-01 09:02:51'),
(48, 221, 239, '3', 0, '2024-12-01 09:02:51'),
(49, 221, 239, '4', 0, '2024-12-01 09:02:52'),
(50, 221, 239, '5', 0, '2024-12-01 09:04:10'),
(51, 221, 222, '55', 1, '2024-12-01 09:05:34'),
(52, 221, 222, 'asdasd', 1, '2024-12-01 09:16:01'),
(53, 221, 222, 'sent', 1, '2024-12-01 09:32:52'),
(54, 221, 222, 'asdsad', 1, '2024-12-01 09:33:06'),
(55, 221, 222, 'oi pangit mo', 1, '2024-12-01 09:34:17'),
(56, 221, 222, 'sasd', 1, '2024-12-01 09:34:22'),
(58, 222, 221, 'kapal mo nmn', 1, '2024-12-01 09:36:50'),
(59, 221, 222, 'oi kalo', 1, '2024-12-01 10:17:47'),
(60, 222, 221, 'bakit', 1, '2024-12-01 10:18:09'),
(61, 221, 222, 'dba ang panit niya?', 1, '2024-12-01 10:18:16'),
(62, 222, 221, 'nino?', 1, '2024-12-01 10:18:26'),
(63, 222, 221, 'cya', 1, '2024-12-01 10:18:29'),
(64, 222, 221, 'uu', 1, '2024-12-01 10:18:37'),
(65, 221, 222, 'ho', 1, '2024-12-01 18:37:11'),
(66, 221, 260, 'fds', 1, '2024-12-01 18:37:21'),
(67, 221, 220, 'hello', 0, '2024-12-11 20:29:52'),
(68, 220, 221, 'hi', 1, '2024-12-11 20:29:57'),
(69, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:42:55'),
(70, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:42:57'),
(71, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:42:59'),
(72, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:43:08'),
(73, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:43:11'),
(74, 260, 221, 'nganong absent karun?', 1, '2024-12-11 20:43:25'),
(75, 260, 221, 'nganong absent karun', 1, '2024-12-11 20:43:31'),
(76, 260, 221, 'hi', 1, '2024-12-11 20:43:38'),
(77, 221, 260, 'absent ko karun maam', 1, '2024-12-11 20:44:32'),
(78, 260, 221, 'ngano man', 1, '2024-12-11 20:45:02'),
(79, 260, 221, 'ngano man', 1, '2024-12-11 20:45:04'),
(80, 260, 221, 'ngano man', 1, '2024-12-11 20:45:06'),
(81, 260, 221, 'ngano man', 1, '2024-12-11 20:45:10'),
(82, 260, 221, 'ngano man', 1, '2024-12-11 20:45:26'),
(83, 260, 222, 'hi', 1, '2024-12-11 21:04:44'),
(84, 260, 222, 'hi', 1, '2024-12-11 21:04:44'),
(85, 260, 222, 'hi', 1, '2024-12-11 21:04:45'),
(86, 260, 222, 'hi', 1, '2024-12-11 21:04:45'),
(87, 260, 222, 'hi', 1, '2024-12-11 21:04:48'),
(88, 260, 222, 'nganong absent ka?', 1, '2024-12-11 21:09:20'),
(89, 260, 222, 'nganong absent ka?', 1, '2024-12-11 21:10:25'),
(90, 260, 222, 'nganong absent ka?', 1, '2024-12-11 21:10:25'),
(91, 260, 222, 'nganong absent ka?', 1, '2024-12-11 21:10:41'),
(92, 260, 221, 'bakit ka absent ngayon', 1, '2024-12-12 13:21:13'),
(93, 221, 260, 'masakit ulo ko', 1, '2024-12-12 13:22:52'),
(94, 232, 267, 'hi', 0, '2024-12-12 22:11:22'),
(95, 238, 289, 'maam absent ko karun', 0, '2024-12-14 12:19:54'),
(96, 238, 289, 'maam', 0, '2024-12-14 12:24:48'),
(97, 221, 260, 'maam', 1, '2024-12-18 08:03:17'),
(98, 260, 221, 'yes?', 1, '2024-12-18 08:05:16'),
(99, 221, 260, 'wla lang', 1, '2024-12-18 08:24:33'),
(100, 260, 221, 'ok', 1, '2024-12-18 08:26:00'),
(101, 221, 222, 'calo', 1, '2024-12-18 14:24:36'),
(102, 222, 221, 'oi', 1, '2024-12-18 14:25:43'),
(103, 222, 221, 'wuy', 1, '2024-12-18 14:26:05'),
(104, 221, 222, 'oi', 1, '2024-12-18 14:26:41'),
(105, 222, 221, 'bakit', 1, '2024-12-18 14:26:58'),
(106, 221, 222, 'sdsds', 1, '2024-12-18 14:27:50'),
(107, 221, 222, '212156', 1, '2024-12-18 14:29:33'),
(108, 221, 222, 'ascalo', 1, '2024-12-18 14:30:08'),
(109, 221, 222, 'cabatingan to teacher', 1, '2024-12-18 14:30:13'),
(110, 221, 222, 'cabatingan to teacher', 1, '2024-12-18 14:30:13'),
(111, 222, 221, 'ok', 1, '2024-12-18 14:30:33'),
(112, 221, 260, 'hello tracher', 1, '2024-12-18 20:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `message_emoji`
--

CREATE TABLE `message_emoji` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `emoji_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parent_children`
--

CREATE TABLE `parent_children` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `children` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parent_children`
--

INSERT INTO `parent_children` (`id`, `user_id`, `children`) VALUES
(1, 265, '323,220'),
(2, 342, '321,340,257,294'),
(3, 344, '231,232'),
(4, 345, '233');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`) VALUES
(5, 'Manage Academic Info'),
(3, 'Manage Accounts'),
(9, 'Manage Attendance'),
(4, 'Manage Campus'),
(6, 'Manage Enrollment'),
(10, 'Manage Faculty'),
(8, 'Manage Grades'),
(7, 'Manage Learners'),
(12, 'Manage messages'),
(2, 'Manage Permissions'),
(1, 'Manage Roles'),
(13, 'Parent Access'),
(11, 'Student Access');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `photo_path` varchar(500) DEFAULT NULL,
  `profile_id` int(11) NOT NULL,
  `lrn` varchar(12) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `sex` enum('M','F','') DEFAULT NULL,
  `birth_date` date NOT NULL,
  `age_as_of_oct_31` int(11) NOT NULL,
  `mother_tongue` varchar(50) DEFAULT NULL,
  `ip_ethnic_group` varchar(50) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `house_street_sitio_purok` varchar(255) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `municipality_city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `fathers_name` varchar(50) DEFAULT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `guardian_name` varchar(50) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `photo_path`, `profile_id`, `lrn`, `last_name`, `first_name`, `middle_name`, `sex`, `birth_date`, `age_as_of_oct_31`, `mother_tongue`, `ip_ethnic_group`, `religion`, `house_street_sitio_purok`, `barangay`, `municipality_city`, `province`, `fathers_name`, `mother_name`, `guardian_name`, `relationship`, `contact_number`, `created_at`) VALUES
(199, NULL, 219, '132023230013', 'ADTOON', 'CHRISTIAN MARK', 'MAGLINAO', 'M', '2017-12-27', 0, 'Cebuano / Sinugbuanong Binisay', 'No Data', 'Christianity', 'No Data', 'MAHAY', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MAGLINAO,JOYCE MARIE CHRISTINE,CLARIDAD,', 'ADTOON, CYREL MARK CASOCOT', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(200, NULL, 220, '212502230070', 'AMORA', 'JAN LUCAS', 'LIBARNES', 'M', '2018-01-17', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'NEW SOCIETY VILLAGE POB. (BGY. 26)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'LIBARNES,JINGLE,SALAR,', 'AMORA, NICSON JOSE', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(201, 'assets/img/profile/132023230235.png', 221, '132023230235', 'CABATINGAN', 'ELIAKYM', 'BUSCANO', 'M', '2018-02-28', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'SAN VICENTE', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BUSCANO,REBECCA,AGUSTIN,', 'CABATINGAN, PAUL LAGRADA', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(202, NULL, 222, '132118230189', 'CALO', 'AKIL MARK', 'BALAGULAN', 'M', '2017-12-31', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'LIMAHA POB. (BGY. 14)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BALAGULAN,APRILYN,JUMADLA,', 'CALO, MARK ALVIN ABOC', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(203, NULL, 223, '132023230124', 'EJANDRA', 'KAIZZER JAZZ', 'POJAS', 'M', '2018-04-18', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BAAN RIVERSIDE POB. (BGY. 20)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'POJAS,JOAHLY ROSE,LOOD,', 'EJANDRA, KENDALL DAO', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(204, NULL, 224, '405978230006', 'GUMANIT', 'KING RIBEN', 'DELECTOR', 'M', '2018-09-07', 0, 'Cebuano', NULL, 'Christianity', NULL, 'OBRERO POB. (BGY. 18)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'DELECTOR,RIZA,ACEBEDO,', 'GUMANIT, BENJIE BOY SAVELLON', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(205, NULL, 225, '132023230076', 'JAMIL', 'ALLYSON DWEN', '-', 'M', '2017-05-03', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'GOLDEN RIBBON POB. (BGY. 2)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'JAMIL,MELANIE,DEARINE,', '', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(206, NULL, 226, '132023230305', 'NOMIO', 'RAFHAEL', 'BARRETO', 'M', '2018-10-09', 0, 'Cebuano', NULL, 'Christianity', NULL, 'NEW SOCIETY VILLAGE POB. (BGY. 26)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BARRETO,RITZEL LYN,TONGOL,', 'NOMIO, RICKY BUQUE', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(207, NULL, 227, '132023230299', 'PALAO', 'MONAIM', 'NAGAMORA', 'M', '2018-06-04', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'NEW SOCIETY VILLAGE POB. (BGY. 26)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'NAGAMORA,OMERAH,NOOR,', 'PALAO, MANTANI MACABUNAR', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(208, NULL, 228, '212502230105', 'TOMO', 'SYMEON REUVEN', 'MAG-ISA', 'M', '2017-01-11', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'TAGUIBO', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MAG-ISA,MARIA NIÑA,PIOL,', 'TOMO, RISTY PADUA', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(209, NULL, 229, '410419230015', 'VELASCO', 'VINCE HALLY', 'PAHIT', 'M', '2018-03-24', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'SAN VICENTE', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'PAHIT,MARIDEL,POLISTICO,', 'VELASCO, ERVIN DUMANDAN', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(210, NULL, 230, '472513230043', 'VILLONES', 'XIMMON BLAKE', 'MACUNO', 'M', '2018-06-25', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BANCASI', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MACUNO,EMILY JOY,BUAYA,', 'VILLONES, JAMES MHYR DAHOYLA', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(211, NULL, 231, '132023230109', 'WONG', 'SEAN ANDRIE', 'JAÑA', 'M', '2017-12-15', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'LAPU-LAPU POB. (BGY. 8)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'JAÑA,MIKKI,GASTA,', 'WONG, ROBERT SALIBAY', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(212, NULL, 232, '501553230018', 'ZOILO', 'ELDZHOOD', 'BACLAY', 'M', '2018-05-02', 0, 'Cebuano/Kana/Sinugboanong Bini', NULL, 'Christianity', NULL, 'BAAN KM 3', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BACLAY,MARIE GRACE,NACAR,', 'ZOILO, ELDOVRELE FUENTES', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(213, NULL, 233, '132023230231', 'CAMPOS', 'REE ANN GRACE', 'SUAREZ', 'F', '2017-12-09', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BADING POB. (BGY. 22)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'SUAREZ,ANVIC GRACE,ALBORES,', 'CAMPOS, REEDICK JOHN PAUMIG', NULL, NULL, NULL, '2024-11-24 02:04:34'),
(214, NULL, 234, '132023230028', 'CANU-OG', 'ZAYEEN FAYE', 'RAMOS', 'F', '2018-05-31', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'LIBERTAD', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'RAMOS,CRIZALYN,CABALLES,', 'CANU-OG, REY BATIQUIN', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(215, NULL, 235, '132023230194', 'CORBES', 'MAJA SOPHIA', 'ALENYABON', 'F', '2018-04-20', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BADING POB. (BGY. 22)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ALENYABON,JANETH,R,', 'CORBES, MARLON J', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(216, NULL, 236, '132023230201', 'DEGAMON', 'ROSELYN', 'FEDILIS', 'F', '2012-11-01', 0, 'Sinurigaonon', NULL, 'Christianity', NULL, 'BAAN KM 3', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'FEDILIS,ROSALINA,REÑUS,', 'DEGAMON, ARCADIO VILLARONZA JR', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(217, NULL, 237, '132023230137', 'EGAY', 'JHIELIANNE', 'LASWE', 'F', '2017-11-27', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BUHANGIN POB. (BGY. 19)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'LASWE,JACQUELOU,QUERIE-QUERIE,', 'EGAY, ELONUF RANA', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(218, 'assets/img/profile/132123230004.jpg', 238, '132123230004', 'GALSIM', 'CARRA JANINE', 'MUCA', 'F', '2018-10-19', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BANCASI', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MUCA,REJEAN,LINGA-ON,', 'GALSIM, CARLO FLORIDA', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(219, NULL, 239, '132023230214', 'KHAN', 'HAIFA', 'BURGOS', 'F', '2018-02-23', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Islam', NULL, 'VILLA KANANGA', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BURGOS,MARITES,SAGON,', 'KHAN, MOHAMMED TABREZ', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(220, NULL, 240, '212502230090', 'LASTIMOSA', 'CELESTINE JHIME', 'CAGAPE', 'F', '2012-06-12', 0, 'Cebuano / Sinugbuanong Binisay', 'No Data', 'Christianity', 'No Data', 'BONBON', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'CAGAPE,DIMEMHOR,ARELLANO,', 'LASTIMOSA, JACOB TRILLO', 'No Data', 'No Data', 'No Data', '2024-11-24 02:04:35'),
(221, NULL, 241, '132023230216', 'LEGASPI', 'JULIA OFELIA', 'RUBIO', 'F', '2018-02-10', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'GOLDEN RIBBON POB. (BGY. 2)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'RUBIO,LEAH MAE,CALANG,', 'LEGASPI, JOEFFER ALINGASA', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(222, NULL, 242, '132023230034', 'PULIDO', 'SOFIA JADE', 'LARIOSA', 'F', '2017-11-10', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Buddhism', NULL, 'DOONGAN', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'LARIOSA,GAY AMOR,ERNO,', 'PULIDO, JOHN CARLO GABRIEL', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(223, NULL, 243, '212502230146', 'SAGON', 'ALEXANDRA LOUISE', 'ELUMBA', 'F', '2017-12-18', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'AGUSAN PEQUEÃ‘O', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ELUMBA,LUCYMAR,ALBERIO,', 'SAGON, ARNEL ARAGON', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(224, NULL, 244, '132023230036', 'SALVAÑA', 'BLAKELY VEAN', '-', 'F', '2018-05-16', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'PORT POYOHON POB. (BGY. 17 - NEW ASIA)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'SALVAÑA,VIOL KIMBERLY CRIS,,', '', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(225, NULL, 245, '212502230033', 'VIDAL', 'HANNIYAH RAYN', 'ALBANO', 'F', '2018-02-12', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'GOLDEN RIBBON POB. (BGY. 2)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ALBANO,HANNAH MAY,ALIGAM,', 'VIDAL, RAYNAN BAYABAYA', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(226, NULL, 246, '132023230227', 'CAMPOS', 'CHRIS DIRRECK', 'CASTILLO', 'M', '2018-03-23', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'ONG YIU POB. (BGY. 16)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'CASTILLO,MARY GRACE,ACOSTA,', 'CAMPOS, ENGELBERT LORENZO', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(227, NULL, 247, '132023230092', 'HILO', 'ART DANIEL', 'GAMIL', 'M', '2018-04-02', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'JOSE RIZAL POB. (BGY. 25)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'GAMIL,SHAMEN,SULAPAS,', 'HILO, ARTEMIO CASAS', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(228, NULL, 248, '212502230058', 'MARCIAL', 'KRISTOFF LYLE', 'ACERA', 'M', '2018-09-08', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'ANTONGALON', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ACERA,CHRISTIAN MAE,TIMBAL,', 'MARCIAL, MAERC JOSEPH PATETE', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(229, NULL, 249, '132023230095', 'MERCADO', 'RXIAN ELIOT', 'ABARQUEZ', 'M', '2017-12-11', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BAAN KM 3', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ABARQUEZ,ROCHE JANE,ANDRADE,', 'MERCADO, RALPH CHRISTIAN JULAO', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(230, NULL, 250, '501285230005', 'NAPIZA', 'LUKE ALEXANDER', 'RIVERA', 'M', '2018-09-06', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'MAON POB. (BGY. 1)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'RIVERA,SHIELA MAE,PEREZ,', 'NAPIZA, CHRISTIAN TORREGOSA', NULL, NULL, NULL, '2024-11-24 02:04:36'),
(231, NULL, 251, '132023230004', 'PADEN', 'BRIX EDRIANE', 'QUINTANA', 'M', '2017-12-10', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'MAHOGANY POB. (BGY. 21)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'QUINTANA,JOY,BUSA,', 'PADEN, ARNEL AMOGUIS', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(232, NULL, 252, '132023230003', 'PADEN', 'HENARRY CLIENT', 'QUINTANA', 'M', '2017-12-10', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'MAHOGANY POB. (BGY. 21)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'QUINTANA,JOY,BUSA,', 'PADEN, ARNEL AMOGUIS', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(233, NULL, 253, '132023230280', 'PAGALAN', 'JAMES RAYCIAN', 'DURAN', 'M', '2018-01-28', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BADING POB. (BGY. 22)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'DURAN,NICHELLE SHANE,ALIM,', 'PAGALAN, RAYMART LEMOS', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(234, NULL, 254, '132023230273', 'PANTALEON', 'KIER CYAN', 'INCHOCO', 'M', '2017-11-07', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BANZA', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'INCHOCO,KIMBERLY,-,', 'PANTALEON, ROITER ENTEÑA', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(235, NULL, 255, '132023230244', 'PLAZA', 'CHRIS EVAN', 'OSIGAN', 'M', '2018-10-25', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BADING POB. (BGY. 22)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'OSIGAN,RICHEL,FORTUN,', 'PLAZA, FRANCISCO FRANCISCO JR', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(236, NULL, 256, '132023230250', 'REYES', 'DANIEL', 'SALAS', 'M', '2018-03-19', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'DAGOHOY POB. (BGY. 7)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'SALAS,DIOSCORA,AMONCIO,', 'REYES, ARNEL LUSTERIO', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(237, NULL, 257, '212502230051', 'ROSALES', 'AIVANN JACOB', 'GABORNE', 'M', '2018-10-17', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'LAPU-LAPU POB. (BGY. 8)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'GABORNE,CHRISTINE,VILLARIAS,', 'ROSALES, ROMMEL OMBAO', NULL, NULL, NULL, '2024-11-24 02:04:37'),
(238, NULL, 258, '132023230278', 'TALLEDO', 'RENZO', 'ARNAIZ', 'M', '2018-06-11', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'HOLY REDEEMER POB. (BGY. 23)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'ARNAIZ,ROBELEN,MONTON,', 'TALLEDO, REYMON LLAMAS', NULL, NULL, NULL, '2024-11-24 02:04:38'),
(239, NULL, 259, '132023230253', 'UTAR', 'JAYDEE TYLER', 'BURDEOS', 'M', '2018-05-30', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'MAON POB. (BGY. 1)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BURDEOS,DEVINE GRACE,LAURITO,', '', NULL, NULL, NULL, '2024-11-24 02:04:38'),
(242, NULL, 265, NULL, 'Ghaizar', 'Parents', 'atara', 'M', '2024-11-30', 0, '', '', 'ISlam', 'No Data', 'No Data', 'No Data', 'No Data', NULL, NULL, NULL, NULL, '09277294457', '2024-11-30 10:49:43'),
(244, 'assets/img/default-profile.png', 260, NULL, 'Sausal', 'Krisha', 'R', NULL, '2002-09-08', 0, 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', NULL, NULL, NULL, NULL, NULL, '2024-12-12 05:21:13'),
(245, NULL, 267, NULL, 'Pines', 'Cecelia', 'M.', 'F', '1918-03-12', 0, 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', 'No Data', NULL, NULL, NULL, NULL, NULL, '2024-12-12 05:54:51'),
(248, NULL, 271, NULL, 'Ocampo', 'Grace', 'N', 'F', '1988-03-10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-12 13:59:34'),
(250, NULL, 275, NULL, 'Noval', 'Divine Grace', 'R', '', '1998-10-20', 0, 'Bisaya', 'N/a', 'Iglesia', 'Emenville Subd', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:41'),
(252, NULL, 277, NULL, 'Sarmiento', 'Maricel', 'A', '', '1995-09-08', 0, 'Bisaya', 'N/a', 'Catholic', 'Balanghai', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:41'),
(253, NULL, 278, NULL, 'Lovete', 'Gloria', 'N', '', '1980-10-05', 0, 'Bisaya', 'N/a', 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:41'),
(254, NULL, 279, NULL, 'Lanurias', 'Cyrus', 'C', '', '1973-05-10', 0, 'Bisaya', 'N/a', 'Catholic', 'Balanghai', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:41'),
(255, NULL, 280, NULL, 'Banjao', 'Manilyn', 'A', '', '1957-04-09', 0, 'Bisaya', 'N/a', 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:41'),
(256, NULL, 281, NULL, 'Dapacino', 'Mary Grace', 'G', '', '1912-06-12', 0, 'Bisaya', 'N/a', 'Catholic', 'Bliss', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:42'),
(257, NULL, 282, NULL, 'Obejas', 'Jeaneth', 'M', '', '1900-07-11', 0, 'Bisaya', 'N/a', 'Catholic', 'Libertad', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:42'),
(258, NULL, 283, NULL, 'Gapayao', 'Charmie', 'O', '', '1901-05-08', 0, 'Bisaya', 'N/a', 'Catholic', 'Bancasi', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:42'),
(259, NULL, 284, NULL, 'Quines', 'Mailyn', 'M', '', '1985-07-03', 0, 'Bisaya', 'N/a', 'Catholic', 'Libertad', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 14:48:42'),
(263, NULL, 289, NULL, 'Quizada', 'Shella Rose', 'A', '', '1976-09-11', 0, 'Bisaya', 'N/a', 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Caraga', NULL, NULL, NULL, NULL, NULL, '2024-12-12 15:18:28'),
(264, NULL, 290, NULL, 'Pines', 'Cecelia Mae', 'M', 'F', '1981-07-08', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-12 15:21:07'),
(265, NULL, 293, NULL, 'Ramos', 'Josefina', 'A', 'F', '1998-12-20', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13 00:53:32'),
(266, NULL, 294, '1321126357', 'SAUSAL', 'ANDRO JOSHUA', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6A Balanghai', 'Libertad', 'Butuan City', 'Cagara', 'Meriam Sausal', 'Alexjandro Sausal', NULL, NULL, NULL, '2024-12-13 07:24:12'),
(267, NULL, 295, '1321126353', 'APAT', 'GERNAN', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:12'),
(268, NULL, 296, '1321123456', 'ARBIOL', 'GIAN', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B Bliss', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:12'),
(269, NULL, 297, '1321127689', 'AYUBAN', 'GIENO', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:12'),
(270, NULL, 298, '1321127684', 'BRILLANTE', 'JOSEPH', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:12'),
(271, NULL, 299, '1321123546', 'BUYANTE', 'JHON T', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6 Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(272, NULL, 300, '1321126357', 'CULINTAS', 'GENEXIS', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6A Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(273, NULL, 301, '1321126353', 'FUENTES', 'JHEVONZYLIAH', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(274, NULL, 302, '1321123456', 'LORETO', 'KIAN', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B Bliss', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(275, NULL, 303, '1321127689', 'MANILAG', 'JIM', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(276, NULL, 304, '1321127684', 'NANCA', 'CHARLS', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:13'),
(277, NULL, 305, '1321123546', 'RANOCO', 'YURI', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6 Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(278, NULL, 306, '1321125264.6', 'REMENTIZO', 'RICHARD', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Bliss', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(279, NULL, 307, '1321125098.0', 'TUGAY', 'RENE', '', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(280, NULL, 308, '1321124931.5', 'ARIAS', 'DIANNE', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(281, NULL, 309, '1321124764.9', 'BAYRON', 'IVY', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Emenville', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(282, NULL, 310, '1321124598.4', 'CAGUMAY', 'CLOUIE', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B Bliss', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(283, NULL, 311, '1321124431.8', 'CALDERON', 'SYLCIE', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:14'),
(284, 'assets/img/profile/1321124265.3.jpeg', 312, '1321124265.3', 'CARIÑOSA', 'JEIANNA', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(285, NULL, 313, '1321124098.8', 'CASCAJO', 'BLESS', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6 Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(286, NULL, 314, '1321123932.2', 'CATUBIGAN', 'CHOOZEN', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Bliss', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(287, NULL, 315, '1321123765.7', 'CUTAMORA', 'PRINCESS', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(288, NULL, 316, '1321123599.1', 'DOCDOC', 'JOY', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(289, NULL, 317, '1321123432.6', 'ELERIA', 'ANGELA', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Emenville', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:15'),
(290, NULL, 318, '1321123266.0', 'LOMARDA', 'FRANCIS', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Balanghai', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:16'),
(291, NULL, 319, '1321123099.5', 'MORILLO', 'ELLAIZA', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:16'),
(292, NULL, 320, '1321122933', 'POLILLO', 'MEKAYLA', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Emenville', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:16'),
(293, NULL, 321, '1321122766.4', 'ROSALES', 'JASMINE', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:16'),
(294, NULL, 322, '1321122433.3', 'YUMO', 'WENDYL', '', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'Paradise', 'Libertad', 'Butuan City', 'Cagara', '', '', NULL, NULL, NULL, '2024-12-13 07:24:16'),
(295, NULL, 323, '1321123546', 'ALEJO', 'JAYVIE', 'ARIBA', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6A BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:12'),
(296, NULL, 324, '1321123546', 'ALMOSARA', 'TAYRON', 'BUYO', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'PARADISE', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:12'),
(297, NULL, 325, '1321123546', 'ATANOG', 'JOHN LLOYD', 'OBA', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'BLISS', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:12'),
(298, NULL, 326, '1321123546', 'BANZON', 'LIAM', 'PARDILLO', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6B BLISS', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(299, NULL, 327, '1321123546', 'BOYBANTING', 'KLEJOHN', 'ALMOSARA', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'PARADISE', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(300, NULL, 328, '1321123546', 'CUTAO', 'JOHN MICHAEL', 'ANDOHOYAN', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'LIBERTAD', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(301, NULL, 329, '1321123546', 'PARDILLO', 'ADRIAN', '-', 'M', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(302, NULL, 330, '1321123546', 'CAÑETE', 'KEMBERLEE', 'DIMPAL', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(303, NULL, 331, '1321123546', 'CASTAÑOS', 'BABY JANE', 'CASAS', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(304, NULL, 332, '1321123546', 'DEJARLO', 'CHAÑINA', 'MAGHILUM', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:13'),
(305, NULL, 333, '1321123546', 'DEJARLO', 'RHEA JANE', 'MAGHILUM', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(306, NULL, 334, '1321123546', 'DIVINO', 'NICOLE', '-', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6E BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(307, NULL, 335, '1321123546', 'ESTRADA', 'KEANNA JEAN', 'MAGHILUM', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'PARADISE', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(308, NULL, 336, '1321123546', 'MILLARE', 'ABBYGEL', 'ATANOG', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'BLISS', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(309, NULL, 337, '1321123546', 'PANILAGA', 'SARAH JEAN', 'PURISIMA', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(310, NULL, 338, '1321123546', 'PARDILLO', 'CLAER', 'TAYCO', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'BLISS', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:14'),
(311, NULL, 339, '1321123546', 'PONLAON', 'ABEGUIL', '-', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'PARADISE', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:15'),
(312, NULL, 340, '1321123546', 'ROSALES', 'JULIE MAE', 'ROSAL', 'F', '0000-00-00', 0, 'Bisaya', NULL, 'Catholic', 'P-6A BALANGHAI', 'LIBERTAD', 'BUTUAN CITY', 'CARAGA', '', '', NULL, NULL, NULL, '2024-12-13 13:52:15'),
(313, NULL, 342, NULL, 'Sausal', 'Parents', 'R', 'F', '1987-04-08', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '09662649734', '2024-12-13 23:24:34'),
(314, NULL, 344, NULL, 'Wong', 'Parents', 'J', 'M', '1956-05-06', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0909645643', '2024-12-14 00:00:32'),
(315, NULL, 345, NULL, 'Campos', 'Parents', 'S', 'F', '2015-03-12', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0927364891', '2024-12-14 00:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `permission_id` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `permission_id`) VALUES
(1, 'Zear Developer', '5,3,9,4,6,10,8,7,12,2,1,13,11'),
(2, 'Faculty', '9,8,7,12'),
(3, 'Learners', '12,11'),
(4, 'Registrar', '5,4,6,10,7,12'),
(6, 'Parents', '12,13');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `section_name` varchar(50) NOT NULL,
  `daytime` enum('Morning','Afternoon','Whole Day') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `adviser_id`, `section_name`, `daytime`) VALUES
(1, 275, 'COURTEOUS', 'Whole Day'),
(2, 268, 'COURTEOUS', 'Afternoon'),
(3, 293, 'HARMONY', 'Morning'),
(4, NULL, 'HARMONY', 'Afternoon'),
(5, NULL, 'HEADSTART - FAITH', 'Morning'),
(6, NULL, 'HEADSTART - CHARITY', 'Afternoon'),
(7, 219, 'HOPE', 'Morning'),
(8, NULL, 'HOPE', 'Afternoon'),
(9, 276, 'KIND', 'Whole Day'),
(10, NULL, 'KIND', 'Afternoon'),
(11, 290, 'LOVE', 'Whole Day'),
(12, NULL, 'LOVE', 'Afternoon'),
(13, NULL, 'LOYAL', 'Morning'),
(14, NULL, 'LOYAL', 'Afternoon'),
(15, NULL, 'PEACE', 'Morning'),
(16, NULL, 'PEACE', 'Afternoon'),
(17, NULL, 'ASPARAGUS', 'Whole Day'),
(18, NULL, 'BEANS', 'Afternoon'),
(19, NULL, 'BROCCOLI', 'Afternoon'),
(20, NULL, 'CABBAGE', 'Afternoon'),
(21, 289, 'CARROTS', 'Whole Day'),
(22, NULL, 'CELERY', 'Morning'),
(23, NULL, 'CHAYOTE', 'Afternoon'),
(24, NULL, 'EGGPLANT', 'Afternoon'),
(25, NULL, 'GRAHAM BELL SSES', 'Whole Day'),
(26, NULL, 'LETTUCE', 'Afternoon'),
(27, NULL, 'PECHAY', 'Afternoon'),
(28, NULL, 'POTATO', 'Morning'),
(29, NULL, 'RADISH', 'Morning'),
(30, 260, 'SQUASH', 'Morning'),
(31, 31, 'THOMAS EDISON SSES', 'Whole Day'),
(32, NULL, 'TOMATO', 'Morning'),
(33, NULL, 'TURNIP', 'Morning'),
(34, 271, 'UPO', 'Whole Day'),
(35, NULL, 'CATTLEYA', 'Whole Day'),
(36, NULL, 'CHARLES DARWIN - SSES', 'Whole Day'),
(37, NULL, 'DAFFODIL', 'Whole Day'),
(38, NULL, 'DAHLIA', 'Whole Day'),
(39, NULL, 'DAISY', 'Whole Day'),
(40, NULL, 'ISAAC NEWTON SSES', 'Whole Day'),
(41, NULL, 'JASMINE', 'Whole Day'),
(42, NULL, 'LAVENDER', 'Whole Day'),
(43, NULL, 'LILY', 'Whole Day'),
(44, NULL, 'ORCHIDS', 'Whole Day'),
(45, NULL, 'PEONY', 'Whole Day'),
(46, NULL, 'ROSAL', 'Whole Day'),
(47, NULL, 'ROSE', 'Whole Day'),
(48, NULL, 'SAMPAGUITA', 'Whole Day'),
(49, NULL, 'SANTAN', 'Whole Day'),
(50, NULL, 'SUNFLOWER', 'Whole Day'),
(51, NULL, 'TULIP', 'Whole Day'),
(52, NULL, 'VANDA', 'Whole Day'),
(53, NULL, 'VIOLET', 'Whole Day'),
(54, 277, 'APPLE', 'Whole Day'),
(55, NULL, 'APRICOT', 'Whole Day'),
(56, NULL, 'ATIS', 'Whole Day'),
(57, NULL, 'CHERRY', 'Whole Day'),
(58, NULL, 'CHICO', 'Whole Day'),
(59, NULL, 'DALANDAN', 'Whole Day'),
(60, NULL, 'GALILEO SSES', 'Whole Day'),
(61, NULL, 'GRAPES', 'Whole Day'),
(62, NULL, 'GUAVA', 'Whole Day'),
(63, NULL, 'JACKFRUIT', 'Whole Day'),
(64, 278, 'MANGO', 'Whole Day'),
(65, NULL, 'MANGOSTEEN', 'Whole Day'),
(66, NULL, 'MARIE CURIE SSES', 'Whole Day'),
(67, NULL, 'ORANGE', 'Whole Day'),
(68, NULL, 'PAPAYA', 'Whole Day'),
(69, NULL, 'PEACH', 'Whole Day'),
(70, NULL, 'PINEAPPLE', 'Whole Day'),
(71, NULL, 'POMELO', 'Whole Day'),
(72, NULL, 'STRAWBERRY', 'Whole Day'),
(73, NULL, 'AMBER', 'Whole Day'),
(74, NULL, 'BERYL', 'Whole Day'),
(75, 280, 'DIAMOND', 'Whole Day'),
(76, NULL, 'EINSTEIN SSES', 'Whole Day'),
(77, NULL, 'EMERALD', 'Whole Day'),
(78, NULL, 'ERATOSTHENES - SSES', 'Whole Day'),
(79, NULL, 'GARNET', 'Whole Day'),
(80, NULL, 'IVORY', 'Whole Day'),
(81, NULL, 'MOONSTONE', 'Whole Day'),
(82, NULL, 'ONYX', 'Whole Day'),
(83, NULL, 'OPAL', 'Whole Day'),
(84, NULL, 'PEARL', 'Whole Day'),
(85, NULL, 'QUARTZ', 'Whole Day'),
(86, 279, 'RUBY', 'Whole Day'),
(87, NULL, 'SAPPHIRE', 'Whole Day'),
(88, NULL, 'TOPAZ', 'Whole Day'),
(89, NULL, 'BANABA', 'Whole Day'),
(90, NULL, 'BANI', 'Whole Day'),
(91, NULL, 'COCONUT', 'Whole Day'),
(92, 282, 'FALCATA', 'Whole Day'),
(93, NULL, 'FIBONACCI STEC', 'Whole Day'),
(94, NULL, 'HINDANG', 'Whole Day'),
(95, NULL, 'IPIL-IPIL', 'Whole Day'),
(96, NULL, 'LAWAAN', 'Whole Day'),
(97, NULL, 'MAGKUNO', 'Whole Day'),
(98, NULL, 'MANGROVE', 'Whole Day'),
(99, NULL, 'MAPLE', 'Whole Day'),
(100, 281, 'NARRA', 'Whole Day'),
(101, NULL, 'PILI', 'Whole Day'),
(102, NULL, 'PYTHAGORAS STEC', 'Whole Day'),
(103, NULL, 'YAKAL', 'Whole Day'),
(104, NULL, 'AGONCILLO', 'Whole Day'),
(105, 283, 'AGUINALDO', 'Whole Day'),
(106, NULL, 'AQUINO', 'Whole Day'),
(107, NULL, 'ARCHIMEDES STEC', 'Whole Day'),
(108, NULL, 'ARISTOTLE STEC', 'Whole Day'),
(109, NULL, 'BALTAZAR', 'Whole Day'),
(110, 284, 'BONIFACIO', 'Whole Day'),
(111, NULL, 'BURGOS', 'Whole Day'),
(112, NULL, 'DAGOHOY', 'Whole Day'),
(113, NULL, 'DE JESUS', 'Whole Day'),
(114, NULL, 'DEL PILAR', 'Whole Day'),
(115, NULL, 'GABRIELA SILANG', 'Whole Day'),
(116, NULL, 'GOMEZ', 'Whole Day'),
(117, NULL, 'HUMABON', 'Whole Day'),
(118, NULL, 'JACINTO', 'Whole Day'),
(119, NULL, 'JUAN LUNA', 'Whole Day'),
(120, NULL, 'LAPU-LAPU', 'Whole Day'),
(121, NULL, 'MABINI', 'Whole Day'),
(122, NULL, 'PONCE', 'Whole Day'),
(123, NULL, 'ZAMORA', 'Whole Day');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`) VALUES
(1, 'Language', ''),
(2, 'Reading and Literacy', ''),
(3, 'Mathematics 1', ''),
(4, 'Makabansa 1', ''),
(5, 'GMRC 1', ''),
(6, 'Filipino 1', ''),
(7, 'English 1', ''),
(8, 'Mathematics 2', ''),
(9, 'Makabansa 2', ''),
(10, 'GMRC 2', ''),
(11, 'Filipino 2', ''),
(12, 'English 2', ''),
(13, 'Mathematics 3', ''),
(14, 'Makabansa 3', ''),
(15, 'GMRC 3', ''),
(16, 'Science 1', ''),
(17, 'Cognitive Development', ''),
(18, 'Literacy, Language and communi', ''),
(19, 'Socio-Emotional Development', ''),
(20, 'Values Development', ''),
(21, 'Filipino 4', ''),
(22, 'English 4', ''),
(23, 'Science 4', ''),
(24, 'Aral Pan', ''),
(25, 'EPP', ''),
(26, 'MAPEH', ''),
(27, 'Math', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `isDelete` tinyint(1) DEFAULT 0,
  `profile_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `role_id`, `isActive`, `isDelete`, `profile_id`, `created_at`, `updated_at`) VALUES
(2, 'zhie@zear.developer.com', 'admin', '$2y$10$Y3A7u1B6/Fchy.twJAypLOhLmD1/KCYjy/BGce2P5jUOKThSTXD3u', 1, 1, 0, NULL, '2024-11-03 03:22:39', '2024-11-20 12:18:34'),
(219, 'christian mark.adtoon@zear_developer.com', 'vmw2HxCr', '$2y$10$sQx8lJhtwUilTIvVhVCBAemwlXQb8rRtVdlu1yXA8de8bnpBd7RDC', 2, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 03:48:11'),
(220, 'jan lucas.amora@zear_developer.com', 'fDBzpz8c', '$2y$10$QNTd0cy75EpiODoDdFyviuih82YrF1FmD80lRyKDYyAqQPGpwx/0C', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 02:04:33'),
(221, 'eliakym.cabatingan@zear_developer.com', 'cabatingan', '$2y$10$GQgaCagLpuEFWIBTDEREYeY3B4ciH/E0vmhWMPotfBdv43mcDnUsu', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-28 05:52:59'),
(222, 'akil mark.calo@zear_developer.com', 'calo', '$2y$10$2TuU5S2T2qQRJlPx88ZGx.1cJGa/phYEUJMzJcDDuZY8aGNF3tf2S', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-12-01 01:36:40'),
(223, 'kaizzer jazz.ejandra@zear_developer.com', 'hV5Fzfr7', '$2y$10$cWTDoCsDhF6XlmOyRpzQA.uPoAe/8IxvUmvHRhcFlRQqiDc2bQN1e', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 02:04:33'),
(224, 'king riben.gumanit@zear_developer.com', 'rNzbrj0R', '$2y$10$C.XFNzvXPZsxzXrXKbIGV.yxz.SqplMn2n1LwDMY0Q1RZqAULnNm.', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 02:04:33'),
(225, 'allyson dwen.jamil@zear_developer.com', 'fQLit8Yi', '$2y$10$H7IfnGVoIFY/Q7u8aBZyBu4uwsOOOOAy8SA5iNoqrxwEcKUS4WVWS', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 02:04:33'),
(226, 'rafhael.nomio@zear_developer.com', 'bv34bWLz', '$2y$10$YnckMzn.Lu0P3P2Jr4FKJubKQrrr30eDRfCPil30h08zm4e4d9l46', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(227, 'monaim.palao@zear_developer.com', '1SvmKcbL', '$2y$10$X1Z/mG2AC4kKMm7obVGKUOSEK1Ia85YMpsumCE7S0ozmpJlltfTWu', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(228, 'symeon reuven.tomo@zear_developer.com', 'CvifYguj', '$2y$10$9mxpDrcbTLqzz8QqsZ.0puSeJJLSLL1E69HXbl8Z0B7F7UKbpOUHa', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(229, 'vince hally.velasco@zear_developer.com', 'neC52usq', '$2y$10$ztsIYvuWT248FQEoerCLcey1B6jDIyFQeZtw.GfMeLXNkydHT4/by', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(230, 'ximmon blake.villones@zear_developer.com', 'CNXRmrSf', '$2y$10$RzXeJa.yykY0zosVBAMBG.g9LrkZQxTdyec1yCqtmfzRrLQmJuyZi', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(231, 'sean andrie.wong@zear_developer.com', '11uzdCoU', '$2y$10$.CQIBrmJ7hP5.1JaXCLGKORpiV4MWAsnOhFrA5lFR3HQTwwrsgFCm', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(232, 'eldzhood.zoilo@zear_developer.com', '7wyqNkC8', '$2y$10$be9HC5wEG/7LzJ.FBgww7eH0Gwwt2EH7Ps.NYMGhp8WyLKBObS5ve', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(233, 'ree ann grace.campos@zear_developer.com', 'DA86mNOu', '$2y$10$wSMMii3IhsTw2nqREfycSOY4YwypqYRC9P77WY9A1uEYpHmMoozQm', 3, 1, 0, NULL, '2024-11-24 02:04:34', '2024-11-24 02:04:34'),
(234, 'zayeen faye.canu-og@zear_developer.com', 'UrQDGwTc', '$2y$10$M5ZtSPfX1BGW4SDG4RZYwuzMQ40kreeAhkdX.fxOY36H0uhBQv3h.', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(235, 'maja sophia.corbes@zear_developer.com', 'Tf9Z7ydc', '$2y$10$MH0Z1iqgd0wPRc5BIwjL/.WFFXfHwnncgMxS4aRPCvlnekzyxlv2W', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(236, 'roselyn.degamon@zear_developer.com', 'TACSpQVh', '$2y$10$0NIeg3c6LjiwD08ubqWa1eUC1UE.2M2cuyW.OdNH/py3nSudfwtIW', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(237, 'jhielianne.egay@zear_developer.com', 'UegWCtFX', '$2y$10$oVKiRrakisv/unIQ/mVP9eIaM3yGrFxQTyxgonrKKlpTuZmzicMUq', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(238, 'carra janine.galsim@zear_developer.com', 'yjqKYVun', '$2y$10$CNP3840JAS7b58jsVIB3JOSNiGiLre0RtNcjv26HvyB1IZRfvPGaa', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(239, 'haifa.khan@zear_developer.com', 'fzfPo4Wf', '$2y$10$50e.tt6AfWEjbIp8JYbFUOqWoYW0V/g5sckxEQfYlsfAvQCE48E/K', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(240, 'celestine jhime.lastimosa@zear_developer.com', 'izB6NcMX', '$2y$10$ziXTVkTtRSy99sUwR9nNAurmPnt.5sps1dyK1fwRmHKRvJsFMjMty', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(241, 'julia ofelia.legaspi@zear_developer.com', 'VyorSyV9', '$2y$10$.leHhQi0C1d02DPFWTXexuzWVnF8G/chv7UuCkeEiEzC4JlzBdBB2', 3, 1, 0, NULL, '2024-11-24 02:04:35', '2024-11-24 02:04:35'),
(242, 'sofia jade.pulido@zear_developer.com', '0UfLaHL2', '$2y$10$juJ4jf3YdYXgRiC7ZXG1vejZ7CmuaDnbH24t49YJ3dnTdO75E/GJ6', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(243, 'alexandra louise.sagon@zear_developer.com', 'LMzXaAE4', '$2y$10$wQge9zm30EwXKMrjE.ggVeteSqMB.hyXfAUOWG4yNp.d7Fjb91ogK', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(244, 'blakely vean.salvaÑa@zear_developer.com', '0tsP6qBu', '$2y$10$OKfIm8w0WJgN1fN64POjTO2lXVg5OEbfye4vOD54yhPf22Ez5Dm/W', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(245, 'hanniyah rayn.vidal@zear_developer.com', 'DdgQGvcX', '$2y$10$A3r7ibMYbiNTZZxpXlO.Q.IUxNypz/NrmPVDbllsz7iXCxAjgkjOK', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(246, 'chris dirreck.campos@zear_developer.com', '7CdH28uI', '$2y$10$dRsPnXUOR6OJYwnNLYLR4u.2l7lT01oCrqwz/ePQiKaeZ7Jlk8cDq', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(247, 'art daniel.hilo@zear_developer.com', '8UgX80YA', '$2y$10$AJu4tx7HzXz7WX6hgHNVj.UC1dfpaVmNV9g.oY8Xi9BaXn25aHwau', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(248, 'kristoff lyle.marcial@zear_developer.com', '95SjA866', '$2y$10$2H91KErqSltfo1T13PSQ3eIsmzKVd7vtsMv7J8Lt7D.cL5iVRF.YW', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(249, 'rxian eliot.mercado@zear_developer.com', 'BTMekTIE', '$2y$10$oa2PMFAZPOahIN14BZovXur8tW0AKCh8TDbOI3neMGAUp3xa1L3LO', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(250, 'luke alexander.napiza@zear_developer.com', 'jEtVdXwD', '$2y$10$qevDHeiSrVnJ3P1ukG0qSOw5XPsQqjy8MClIf2tPC83.d31Y9jeZS', 3, 1, 0, NULL, '2024-11-24 02:04:36', '2024-11-24 02:04:36'),
(251, 'brix edriane.paden@zear_developer.com', 'mevq2lPE', '$2y$10$EEPPeI86vad/vxvgSPucy.c6pqdYUki4aDYF6Pg.vBtSSqf4B3O8e', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(252, 'henarry client.paden@zear_developer.com', 'IiXp02ln', '$2y$10$wnnX4OCJsSeuR4GFYqfc8udtOciqRlZpX3VZA50bP6uHgQ1iKT4XS', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(253, 'james raycian.pagalan@zear_developer.com', 'e91uWRa8', '$2y$10$ScJeImGcOH5Ya6kPsJ.ljOSXcAdjQqgNHZkuJp5bew5g0jazEOQKe', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(254, 'kier cyan.pantaleon@zear_developer.com', 'j03GEjqg', '$2y$10$HoUeTttAjYfTOz7XfsKj1OZYxCby4FxlbnMZ1PgFlSqoxJ3JATd1y', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(255, 'chris evan.plaza@zear_developer.com', 'GbIdQhVx', '$2y$10$z7H7Krniww7FUpSU44Buoukc7snitUTwFIHkhHb6khGfioCG4ERfC', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(256, 'daniel.reyes@zear_developer.com', 'sTvoQLBC', '$2y$10$Pl6a50jf6w5cWbk9q.cvPuF5gTTIKQliSW7CpZpme27A0O1vEG1Xq', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(257, 'aivann jacob.rosales@zear_developer.com', 'KZZ5PZ7r', '$2y$10$4iaNc1Nu8fvF11UONoDj2.93DF0Xfy9152v4FJ1co3LfAgNMgiNKS', 3, 1, 0, NULL, '2024-11-24 02:04:37', '2024-11-24 02:04:37'),
(258, 'renzo.talledo@zear_developer.com', '8kKkBXIo', '$2y$10$/H1qtCaYgRZDUL3wmV6rRewJHYCA4nVJ87reCxoN/k.AfnkrCTHai', 3, 1, 0, NULL, '2024-11-24 02:04:38', '2024-11-24 02:04:38'),
(259, 'jaydee tyler.utar@zear_developer.com', 'nncg88FW', '$2y$10$0kRWfBy5zIuMujG1cDaQ8u3PcuJiELSz.fxAduWilpCqFwU7/swo6', 3, 1, 0, NULL, '2024-11-24 02:04:38', '2024-11-24 02:04:38'),
(260, 'No Data', 'teacher', '$2y$10$QNMzGh05nj/ijafvDFrOi.CjVgeyCHddXwnbrz.raRH9QOeP536dG', 2, 1, 0, NULL, '2024-11-24 04:18:42', '2024-12-13 14:11:36'),
(261, NULL, 'registrar', '$2y$10$UQ8Yl1EIs7gfDHUejsFIx.twCH6LCpi2rR156aI8g0ox.WelRukQa', 4, 1, 0, NULL, '2024-11-30 00:56:28', '2024-11-30 00:56:28'),
(265, 'paarents.ghaizar', 'parent', '$2y$10$giUEe9BRPLQ6HSOASqB4FewIWtXKAy8riQjZ7bfbXBkYVd3vfv1oS', 6, 1, 0, NULL, '2024-11-30 10:49:43', '2024-11-30 11:16:09'),
(267, 'cecelia.pines@zear_developer.com', 'cecelia', '$2y$10$I8aDprizFiYpm0JYO9emxe40J20zdBqZy8KiCtyrMIBetbZMCw/1S', 2, 1, 0, NULL, '2024-12-12 05:54:51', '2024-12-12 06:37:29'),
(271, 'grace.ocampo@gmail.com', '00YyHu4B', '$2y$10$3C970AObqGwCh1XIU9V9W.pccHNV9Za/.wLmJZZYMPnqzNg74R5oK', 2, 1, 0, NULL, '2024-12-12 13:59:34', '2024-12-12 13:59:34'),
(275, 'divine.grace.noval@gmail.com', 'Kmtlfa9X', '$2y$10$CA/bAJlorv0ICs7JjInxUewIV9nAbgsGItndRt6khOu3yA6BE/BSO', 2, 1, 0, NULL, '2024-12-12 14:48:41', '2024-12-12 14:48:41'),
(277, 'maricel.sarmiento@gmail.com', '1WVgyvWd', '$2y$10$A3Pn7dMOrlAu4aDkiJt7HeVZJYJz4/GJEg4WzFBFuzDCI8HYBBmLq', 2, 1, 0, NULL, '2024-12-12 14:48:41', '2024-12-12 14:48:41'),
(278, 'gloria.lovete@gmail.com', '1nOHvlkJ', '$2y$10$sCND3hUFr5l48vliICx8Q./t.Kc3TZ5/6urYNTQwPzqBsNPzmflLe', 2, 1, 0, NULL, '2024-12-12 14:48:41', '2024-12-12 14:48:41'),
(279, 'cyrus.lanurias@gmail.com', 'VrAavsqG', '$2y$10$FrGvn5gXVKsFZNlD7IRNj.l5KKKOF6omSguxOQSq5AkLJ3GKxwKQK', 2, 1, 0, NULL, '2024-12-12 14:48:41', '2024-12-12 14:48:41'),
(280, 'manilyn.banjao@gmail.com', 'yIobXGCt', '$2y$10$iModpnH5Fi2/GzrsUd5PHexdJzD/kzSiA6k0WsS366SouNHEnQKrK', 2, 1, 0, NULL, '2024-12-12 14:48:41', '2024-12-12 14:48:41'),
(281, 'mary.grace.dapacino@gmail.com', 'jucFcNDb', '$2y$10$KGo3PKtubRzfrA8W1IAuFe2vD4PhrN6tN.wIKcrqQpL0.mH4WQOlq', 2, 1, 0, NULL, '2024-12-12 14:48:42', '2024-12-12 14:48:42'),
(282, 'jeaneth.obejas@gmail.com', 'n9AtIrY7', '$2y$10$/ya3o/lhe44EwcLhFrtINeOKH/ykD.lqPyKhQ/.SzdBrfEPocxdJS', 2, 1, 0, NULL, '2024-12-12 14:48:42', '2024-12-12 14:48:42'),
(283, 'charmie.gapayao@gmail.com', 'a2kBer7l', '$2y$10$NadpDl5QrA0478SKPFRjAOrht7qtJCZliWp8A5ZZmoTc5VucInXLi', 2, 1, 0, NULL, '2024-12-12 14:48:42', '2024-12-12 14:48:42'),
(284, 'mailyn.quines@gmail.com', 'RroDE1tS', '$2y$10$L2RQiN4fb.L7MVDbNfLmfuEBO/evUgzJFOdCdfQWfbkEgakhVc3ky', 2, 1, 0, NULL, '2024-12-12 14:48:42', '2024-12-12 14:48:42'),
(289, 'shella.rose.quizada@gmail.com', 'Y2c6fpIn', '$2y$10$6CdysBqzZjIMY2crEM7mEuozImd3KSr4mooNg6KGw1Z1WQv2RHbqK', 2, 1, 0, NULL, '2024-12-12 15:18:28', '2024-12-12 15:18:28'),
(290, 'cecelia.mae.pines@gmail.com', 'nz2cFEHR', '$2y$10$rqgtdRso9BsLlJ8TiGJyLeZmQsSeHplo5VwvMj/t31edIfw/Tz2Tm', 2, 1, 0, NULL, '2024-12-12 15:21:07', '2024-12-12 15:21:07'),
(293, 'josefina.ramos@gmail.com', '53KhxqpL', '$2y$10$hxTnAEiLBl2ntZ0xBZuuW.M/ZyHp4bkZRN3RB1onz69AZOzEa8br.', 2, 1, 0, NULL, '2024-12-13 00:53:32', '2024-12-13 00:53:32'),
(294, 'andro.joshua.sausal@gmail.com', '8AsVGsyf', '$2y$10$R5mz53qee2tizyiMKFhu.uTTlTm.Dlw2nljBo1Tny3rUQW1ie8aoK', 3, 1, 0, NULL, '2024-12-13 07:24:12', '2024-12-13 07:24:12'),
(295, 'gernan.apat@gmail.com', 'zZ5fkrhF', '$2y$10$yHdiuYH1B9rBrGV.I1skrOu030pz51EAnedAMxHtaS5bGdphfw8Ci', 3, 1, 0, NULL, '2024-12-13 07:24:12', '2024-12-13 07:24:12'),
(296, 'gian.arbiol@gmail.com', 'vYnOjFhu', '$2y$10$oir5ztBvQ5v/TIhh.82AGuJvwOapMrYd30z0A0CT9xNeXL.kDj/Ja', 3, 1, 0, NULL, '2024-12-13 07:24:12', '2024-12-13 07:24:12'),
(297, 'gieno.ayuban@gmail.com', 'UIyVZeMx', '$2y$10$BuWklC4ZkaeSsUQzxlHbxu8z4y0fJvGL9mdRU7zWMehsf2lUnrrKG', 3, 1, 0, NULL, '2024-12-13 07:24:12', '2024-12-13 07:24:12'),
(298, 'joseph.brillante@gmail.com', 'FnVwTYbk', '$2y$10$nJ0zrOod2MVP3OBcR2cMEOubNIpP4mih0TjcsTXBgQQERAplb49Yq', 3, 1, 0, NULL, '2024-12-13 07:24:12', '2024-12-13 07:24:12'),
(299, 'jhon.t.buyante@gmail.com', 'q5fAOiDw', '$2y$10$2DVGOVJecaY2h86VyMrbnu/OJKeTXL6DQNHof9Sqnbi7qsAwK8VGy', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(300, 'genexis.culintas@gmail.com', 'ELXR6YC2', '$2y$10$X6MlVBIO076FS/9jTH.8m.cG9MgCx65CWVWEExzs4tYQmE3mOkQJ6', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(301, 'jhevonzyliah.fuentes@gmail.com', 'X9UDJ24R', '$2y$10$hC0CnL77wnog9xFnNuIcfuWHx0dKt4vSg5P80LujK9LbZyITk3G8G', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(302, 'kian.loreto@gmail.com', 'JY3SP26s', '$2y$10$XSrWP2jXeLy9vR9D.9.i1OVpuniPeU9cvBrQ1a2rdUPkX85084ham', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(303, 'jim.manilag@gmail.com', 'VdRgRxzg', '$2y$10$d/HWxfemKPrv1s7mzksli.pN77sKBBy2W8QbSbqrWcWMnPQkfcIcy', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(304, 'charls.nanca@gmail.com', '74eJUHoD', '$2y$10$maRBlG834ADM3oAhivrIH.7lp06uPMBA5gj2T2mZscb0tUi4dxgXi', 3, 1, 0, NULL, '2024-12-13 07:24:13', '2024-12-13 07:24:13'),
(305, 'yuri.ranoco@gmail.com', 'FbOQrIML', '$2y$10$dGlX7OMSCsik8no1n2w1e.4PCrII1wPAxPowzpSGha/aNuqur6AHe', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(306, 'richard.rementizo@gmail.com', 'ziG0T5M6', '$2y$10$Ypo1K0uoVMYlos3SoeMktuW.Yyg6wlgqrUZbiIVZ9yK3Lkwxn.c9y', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(307, 'rene.tugay@gmail.com', 'TxOG7P6E', '$2y$10$JWwm4.OE459THaGfiF1ix.KhBGwrvvKKK1aJiCLx1SPjQBuhHqzlC', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(308, 'dianne.arias@gmail.com', 'jULBrmRN', '$2y$10$Ux5x0WucpI.dahY28.IBqO1DP.mElsKY.eyUZD.r5/NtQhElyWyyO', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(309, 'ivy.bayron@gmail.com', 'XtWrOklE', '$2y$10$eyyLTW3oJd8FBcVw3hmfIuaq7AWv8cvCFaBCZkSkm6JB6rPHNNVyy', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(310, 'clouie.cagumay@gmail.com', 'vblcFcll', '$2y$10$9gqUmWTXzY6PoLdJm6o3qenrXOjZWCoLcZA8DWtq8DIzxFwYR8dku', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(311, 'sylcie.calderon@gmail.com', 'uBsWLj73', '$2y$10$8SEEjtDxEvRxV5949LVAuOvBCtkccufES3uBf/cv/OWdNGqH8yxjO', 3, 1, 0, NULL, '2024-12-13 07:24:14', '2024-12-13 07:24:14'),
(312, 'jeianna.cariÑosa@gmail.com', 'vlKQRDRo', '$2y$10$JqnkQSE8XdhIQrxbIp0rWe7djbj.uBucb1J.r3t2EbXHtPxDXaMim', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(313, 'bless.cascajo@gmail.com', 'jOKS7NTX', '$2y$10$X7s1CNzKAFy3hkwS4Y9PtePjeUW8.rtz8rCp/N7sXR83AUu4Z8MwS', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(314, 'choozen.catubigan@gmail.com', 'iAT03p5U', '$2y$10$v2ql8JLl1NrPd/v5fmRZZu3WpjrVji1mMXYlyrfl9HSE0ni.8iE6u', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(315, 'princess.cutamora@gmail.com', 'lt5yeLNS', '$2y$10$cOb804Ve9BqpSUhzrAoML.HXpzQoDiSQojhiH8ssqJWxy0prZIhhG', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(316, 'joy.docdoc@gmail.com', 'CkUMswxf', '$2y$10$AY5ysNKaoR/1HMAtumOe0eLFEwZI10Ko0YQSfjyKKWsNJEUivFQf.', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(317, 'angela.eleria@gmail.com', 'O3G195wB', '$2y$10$vL41U6yp2Do9c8ObESNcnepaNMOEK3mdKPrLJuPiRBQl1HbEKsRXK', 3, 1, 0, NULL, '2024-12-13 07:24:15', '2024-12-13 07:24:15'),
(318, 'francis.lomarda@gmail.com', 'WBXk4rGE', '$2y$10$EePbM6z0ys0mn3e/R9idA.RlmpcYPSpRnuTwoOWnBVPNrqefB4Q8y', 3, 1, 0, NULL, '2024-12-13 07:24:16', '2024-12-13 07:24:16'),
(319, 'ellaiza.morillo@gmail.com', 'zCydZi8Q', '$2y$10$/TJyCTnOaeg/6PEzU5HQ3.TzdkFr4sZpJ6npiX1wcsBanen1UlP7C', 3, 1, 0, NULL, '2024-12-13 07:24:16', '2024-12-13 07:24:16'),
(320, 'mekayla.polillo@gmail.com', 'l2hWMoVb', '$2y$10$7SQkViio5feaSSDuDLvIIu7KBQjRJN0jIdhjcaLPqhM8zItuLTcLu', 3, 1, 0, NULL, '2024-12-13 07:24:16', '2024-12-13 07:24:16'),
(321, 'jasmine.rosales@gmail.com', 'i8KMfrX5', '$2y$10$XUKeItmjy47iWay4A3sSGeg80R67DekFunV.dhhTRVXDui5FUi0e6', 3, 1, 0, NULL, '2024-12-13 07:24:16', '2024-12-13 07:24:16'),
(322, 'wendyl.yumo@gmail.com', 'gmLFabSy', '$2y$10$fHIbfQKq4YD5ohm8zCVZyupcx9PtVcxPNt12pLSF.Dn07iZWPt16m', 3, 1, 0, NULL, '2024-12-13 07:24:16', '2024-12-13 07:24:16'),
(323, 'jayvie.alejo@gmail.com', 'l1QUVnp0', '$2y$10$..QcIljxCPALMxGm9iqCOueT9.JDs7JJboucdtrExbeyAyWDKmwe6', 3, 1, 0, NULL, '2024-12-13 13:52:12', '2024-12-13 13:52:12'),
(324, 'tayron.almosara@gmail.com', 'wTANicC0', '$2y$10$tvRrMreqICxDb5Lkz/pur.m3egXNLM945Gf/8NxtR4bZon4QAFuS.', 3, 1, 0, NULL, '2024-12-13 13:52:12', '2024-12-13 13:52:12'),
(325, 'john.lloyd.atanog@gmail.com', 'YDrPCxNL', '$2y$10$cfSRixBQTTYreKjg9yz1Re3EyjTZotk7hF4HcUJxfWDMqP9Q4DHG2', 3, 1, 0, NULL, '2024-12-13 13:52:12', '2024-12-13 13:52:12'),
(326, 'liam.banzon@gmail.com', '9U8c8Twx', '$2y$10$S2Zt5ltzIDM9d5.H8741j.gT3lRI8huPWcTbngBzMjG4FO.JDPsam', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(327, 'klejohn.boybanting@gmail.com', 'RnAhGIoc', '$2y$10$SmT4qZXMcaSWjdjDckPNAuegHeblVjD5Q6YjY80Bk2ZXafzIK4dTK', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(328, 'john.michael.cutao@gmail.com', '6bJbo1G2', '$2y$10$7zCxfL76yoO7fEVFOPKiUey1OiPLI/bby9qiDUX0i/7XAD5yi1sb2', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(329, 'adrian.pardillo@gmail.com', 'djPbmegX', '$2y$10$TRC6jan8dEaaAAp3bpR1FeHeJX9CcAO7d9p1sCb55bxJ0Vwz9R4qW', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(330, 'kemberlee.caÑete@gmail.com', 'vC4G529C', '$2y$10$FnK7bk3Cs0QBA1uLS/e5oeG/TqSlsASsFnvnSK.8zKkGgkP85Q5Iq', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(331, 'baby.jane.castaÑos@gmail.com', 'NFc1gCfN', '$2y$10$QNviKbRdi1j.jDoS/XvmC.VGcsI1n6uGIUp7GSONSu0zLxOLHaEHO', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(332, 'chaÑina.dejarlo@gmail.com', 'zyZC199J', '$2y$10$.tIcW.iFNpe6H6ewaF1fxOmhZvQ9CBIc4r66HN3vl1tWR5gE9vWcC', 3, 1, 0, NULL, '2024-12-13 13:52:13', '2024-12-13 13:52:13'),
(333, 'rhea.jane.dejarlo@gmail.com', 'vCIRPWvX', '$2y$10$O8ySveCo4jejA2lnkqo2Sel3Qa6gqTORNbBHr/MUnr6X.93g9hg1G', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(334, 'nicole.divino@gmail.com', 'bSmyKCfv', '$2y$10$m2Fa3.T233EFIiVXauxCPOgmnNz.5ZtWgUvrp1hrIrrzD7vg3j/nO', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(335, 'keanna.jean.estrada@gmail.com', 'ggZpqzsY', '$2y$10$UdApu5DSzCt6xr42wIbDUOAQdSYqViJAm1hqfM5dyaRDj0pzJ2o/6', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(336, 'abbygel.millare@gmail.com', 'oKQ4BPz0', '$2y$10$SVkyew0K7jRx0xjCp3hJqeCG6K6z8I/MW8ivgKDg2Mrv6dSEdspDC', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(337, 'sarah.jean.panilaga@gmail.com', 'kJ2uAWWv', '$2y$10$crROTp6pTyNo8jI3Gh4fKeeZ.9zDy1tkAey0wp4p1aiaxYx5CsIru', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(338, 'claer.pardillo@gmail.com', 'pAT7nqAD', '$2y$10$VWyScplXE.iLuyLHFKXypuZAhYejbn83VvF09SDw5RtfoZwizEaue', 3, 1, 0, NULL, '2024-12-13 13:52:14', '2024-12-13 13:52:14'),
(339, 'abeguil.ponlaon@gmail.com', 'x9XXnLgX', '$2y$10$vgqUMsCqJOPQJD3O.hFaP.A4apUpVhyYrXz7mnd0gEU/0wSpRUw9W', 3, 1, 0, NULL, '2024-12-13 13:52:15', '2024-12-13 13:52:15'),
(340, 'julie.mae.rosales@gmail.com', 'km3rGLFz', '$2y$10$wDE1k.X48x1Z7Y2WqLbnsusL/S.Bo4o.wmqfghmWe4kSTD8MeVEbu', 3, 1, 0, NULL, '2024-12-13 13:52:15', '2024-12-13 13:52:15'),
(341, NULL, 'krisha', '$2y$10$mllGKwPT/k3tDdGyl0kHM.33GTvgBttRRl8BkGAN2M0NrU96yv.gO', 2, 1, 0, NULL, '2024-12-13 14:14:20', '2024-12-13 14:14:20'),
(342, 'parents.sausal@gmail.com', 'qTJfw5X3', '$2y$10$GFice7ZoRsbGrNkIafqY0u.gk4MFeRtEwqvgOzkX1Nc0dFQrTorJC', 6, 1, 0, NULL, '2024-12-13 23:24:34', '2024-12-13 23:24:34'),
(344, 'parents.wong@gmail.com', 'CejW705d', '$2y$10$CJ09eHVkLcPxqsF.0Vg3kOFxzL.OS96c2noVV1vXXSXNvD06rpXEq', 6, 1, 0, NULL, '2024-12-14 00:00:32', '2024-12-14 00:00:32'),
(345, 'parents.campos@gmail.com', 'jk8on6Yn', '$2y$10$UXEKD8JlrOhO0vcine0t0.VvMLRncpyMjqtmNXo50hyg/PDB9f7pq', 6, 1, 0, NULL, '2024-12-14 00:14:35', '2024-12-14 00:14:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `eh_id` (`eh_id`);

--
-- Indexes for table `campus_info`
--
ALTER TABLE `campus_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emoji`
--
ALTER TABLE `emoji`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortcode` (`shortcode`);

--
-- Indexes for table `enrollment_history`
--
ALTER TABLE `enrollment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `grade_level_id` (`grade_level_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `enrollment_history_ibfk_4` (`adviser_id`),
  ADD KEY `enrollment_history_ibfk_5` (`academic_year_id`);

--
-- Indexes for table `grade_level`
--
ALTER TABLE `grade_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_records`
--
ALTER TABLE `grade_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `eh_id` (`eh_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `message_emoji`
--
ALTER TABLE `message_emoji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `emoji_id` (`emoji_id`);

--
-- Indexes for table `parent_children`
--
ALTER TABLE `parent_children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adviser_id` (`adviser_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `campus_info`
--
ALTER TABLE `campus_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `emoji`
--
ALTER TABLE `emoji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollment_history`
--
ALTER TABLE `enrollment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `grade_level`
--
ALTER TABLE `grade_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade_records`
--
ALTER TABLE `grade_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `message_emoji`
--
ALTER TABLE `message_emoji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent_children`
--
ALTER TABLE `parent_children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eh_id` FOREIGN KEY (`eh_id`) REFERENCES `enrollment_history` (`id`);

--
-- Constraints for table `enrollment_history`
--
ALTER TABLE `enrollment_history`
  ADD CONSTRAINT `enrollment_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `enrollment_history_ibfk_2` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_level` (`id`),
  ADD CONSTRAINT `enrollment_history_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `enrollment_history_ibfk_4` FOREIGN KEY (`adviser_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `enrollment_history_ibfk_5` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_year` (`id`);

--
-- Constraints for table `grade_records`
--
ALTER TABLE `grade_records`
  ADD CONSTRAINT `grade_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_records_ibfk_2` FOREIGN KEY (`eh_id`) REFERENCES `enrollment_history` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_records_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `message_emoji`
--
ALTER TABLE `message_emoji`
  ADD CONSTRAINT `message_emoji_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_emoji_ibfk_2` FOREIGN KEY (`emoji_id`) REFERENCES `emoji` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parent_children`
--
ALTER TABLE `parent_children`
  ADD CONSTRAINT `parent_children_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
