-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 12:48 PM
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
-- Database: `school_system`
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
(23, 221, 34, '2024-11-28', 'P', NULL, '2024-11-28 06:37:50', '2024-11-28 06:37:50');

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
(7, 'Institutional Email', '@zear_developer.com'),
(8, 'Grading', '1');

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
(20, 222, 2, 30, 260, 4, '2024-11-24'),
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
(34, 221, 2, 30, 260, 4, '2024-11-24');

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
(1, 'Kinder Garden', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16', NULL),
(2, 'Grade I', '17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', '1,2,3,4,5'),
(3, 'Grade II', '35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53', '6,7,8,9,10'),
(4, 'Grade III', '54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72', '11,12,13,14,15,16'),
(5, 'Grade IV', '73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88', NULL),
(6, 'Grade V', '89,90,91,92,93,94,95,96,97,98,99,100,101,102,103', NULL),
(7, 'Grade VI', '104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123', NULL);

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
(5, 222, 20, 2, 1, '100.00', '2024-11-28 10:46:54', '2024-11-28 10:46:54');

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
(199, NULL, 219, '132023230013', 'ADTOON', 'CHRISTIAN MARK', 'MAGLINAO', 'M', '2017-12-27', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'MAHAY', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MAGLINAO,JOYCE MARIE CHRISTINE,CLARIDAD,', 'ADTOON, CYREL MARK CASOCOT', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(200, NULL, 220, '212502230070', 'AMORA', 'JAN LUCAS', 'LIBARNES', 'M', '2018-01-17', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'NEW SOCIETY VILLAGE POB. (BGY. 26)', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'LIBARNES,JINGLE,SALAR,', 'AMORA, NICSON JOSE', NULL, NULL, NULL, '2024-11-24 02:04:33'),
(201, 'assets/img/profile/132023230235.jpg', 221, '132023230235', 'CABATINGAN', 'ELIAKYM', 'BUSCANO', 'M', '2018-02-28', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'SAN VICENTE', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BUSCANO,REBECCA,AGUSTIN,', 'CABATINGAN, PAUL LAGRADA', NULL, NULL, NULL, '2024-11-24 02:04:33'),
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
(218, NULL, 238, '132123230004', 'GALSIM', 'CARRA JANINE', 'MUCA', 'F', '2018-10-19', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BANCASI', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'MUCA,REJEAN,LINGA-ON,', 'GALSIM, CARLO FLORIDA', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(219, NULL, 239, '132023230214', 'KHAN', 'HAIFA', 'BURGOS', 'F', '2018-02-23', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Islam', NULL, 'VILLA KANANGA', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'BURGOS,MARITES,SAGON,', 'KHAN, MOHAMMED TABREZ', NULL, NULL, NULL, '2024-11-24 02:04:35'),
(220, NULL, 240, '212502230090', 'LASTIMOSA', 'CELESTINE JHIME', 'CAGAPE', 'F', '2018-06-18', 0, 'Cebuano / Sinugbuanong Binisay', NULL, 'Christianity', NULL, 'BONBON', 'BUTUAN CITY (Capital)', 'AGUSAN DEL NORTE', 'CAGAPE,DIMEMHOR,ARELLANO,', 'LASTIMOSA, JACOB TRILLO', NULL, NULL, NULL, '2024-11-24 02:04:35'),
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
(242, NULL, 265, NULL, 'Ghaizar', 'Paarents', 'atara', 'M', '2024-11-30', 0, '', '', 'ISlam', 'No Data', 'No Data', 'No Data', 'No Data', NULL, NULL, NULL, NULL, '09277294457', '2024-11-30 10:49:43');

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
(4, 'Registrar', '5,6,10,7,12'),
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
(1, NULL, 'COURTEOUS', 'Morning'),
(2, NULL, 'COURTEOUS', 'Afternoon'),
(3, NULL, 'HARMONY', 'Morning'),
(4, NULL, 'HARMONY', 'Afternoon'),
(5, NULL, 'HEADSTART - FAITH', 'Morning'),
(6, NULL, 'HEADSTART - CHARITY', 'Afternoon'),
(7, NULL, 'HOPE', 'Morning'),
(8, NULL, 'HOPE', 'Afternoon'),
(9, NULL, 'KIND', 'Morning'),
(10, NULL, 'KIND', 'Afternoon'),
(11, NULL, 'LOVE', 'Morning'),
(12, NULL, 'LOVE', 'Afternoon'),
(13, NULL, 'LOYAL', 'Morning'),
(14, NULL, 'LOYAL', 'Afternoon'),
(15, NULL, 'PEACE', 'Morning'),
(16, NULL, 'PEACE', 'Afternoon'),
(17, NULL, 'ASPARAGUS', 'Whole Day'),
(18, NULL, 'BEANS', 'Afternoon'),
(19, NULL, 'BROCCOLI', 'Afternoon'),
(20, NULL, 'CABBAGE', 'Afternoon'),
(21, NULL, 'CARROTS', 'Afternoon'),
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
(34, NULL, 'UPO', 'Morning'),
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
(54, NULL, 'APPLE', 'Whole Day'),
(55, NULL, 'APRICOT', 'Whole Day'),
(56, NULL, 'ATIS', 'Whole Day'),
(57, NULL, 'CHERRY', 'Whole Day'),
(58, NULL, 'CHICO', 'Whole Day'),
(59, NULL, 'DALANDAN', 'Whole Day'),
(60, NULL, 'GALILEO SSES', 'Whole Day'),
(61, NULL, 'GRAPES', 'Whole Day'),
(62, NULL, 'GUAVA', 'Whole Day'),
(63, NULL, 'JACKFRUIT', 'Whole Day'),
(64, NULL, 'MANGO', 'Whole Day'),
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
(75, NULL, 'DIAMOND', 'Whole Day'),
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
(86, NULL, 'RUBY', 'Whole Day'),
(87, NULL, 'SAPPHIRE', 'Whole Day'),
(88, NULL, 'TOPAZ', 'Whole Day'),
(89, NULL, 'BANABA', 'Whole Day'),
(90, NULL, 'BANI', 'Whole Day'),
(91, NULL, 'COCONUT', 'Whole Day'),
(92, NULL, 'FALCATA', 'Whole Day'),
(93, NULL, 'FIBONACCI STEC', 'Whole Day'),
(94, NULL, 'HINDANG', 'Whole Day'),
(95, NULL, 'IPIL-IPIL', 'Whole Day'),
(96, NULL, 'LAWAAN', 'Whole Day'),
(97, NULL, 'MAGKUNO', 'Whole Day'),
(98, NULL, 'MANGROVE', 'Whole Day'),
(99, NULL, 'MAPLE', 'Whole Day'),
(100, NULL, 'NARRA', 'Whole Day'),
(101, NULL, 'PILI', 'Whole Day'),
(102, NULL, 'PYTHAGORAS STEC', 'Whole Day'),
(103, NULL, 'YAKAL', 'Whole Day'),
(104, NULL, 'AGONCILLO', 'Whole Day'),
(105, NULL, 'AGUINALDO', 'Whole Day'),
(106, NULL, 'AQUINO', 'Whole Day'),
(107, NULL, 'ARCHIMEDES STEC', 'Whole Day'),
(108, NULL, 'ARISTOTLE STEC', 'Whole Day'),
(109, NULL, 'BALTAZAR', 'Whole Day'),
(110, NULL, 'BONIFACIO', 'Whole Day'),
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
(16, 'Science 1', '');

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
(222, 'akil mark.calo@zear_developer.com', 'tIymlxVq', '$2y$10$2TuU5S2T2qQRJlPx88ZGx.1cJGa/phYEUJMzJcDDuZY8aGNF3tf2S', 3, 1, 0, NULL, '2024-11-24 02:04:33', '2024-11-24 02:04:33'),
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
(260, NULL, 'teacher', '$2y$10$QNMzGh05nj/ijafvDFrOi.CjVgeyCHddXwnbrz.raRH9QOeP536dG', 2, 1, 0, NULL, '2024-11-24 04:18:42', '2024-11-24 04:18:42'),
(261, NULL, 'registrar', '$2y$10$UQ8Yl1EIs7gfDHUejsFIx.twCH6LCpi2rR156aI8g0ox.WelRukQa', 4, 1, 0, NULL, '2024-11-30 00:56:28', '2024-11-30 00:56:28'),
(265, 'paarents.ghaizar', 'parent', '$2y$10$giUEe9BRPLQ6HSOASqB4FewIWtXKAy8riQjZ7bfbXBkYVd3vfv1oS', 6, 1, 0, NULL, '2024-11-30 10:49:43', '2024-11-30 11:16:09');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `campus_info`
--
ALTER TABLE `campus_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emoji`
--
ALTER TABLE `emoji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollment_history`
--
ALTER TABLE `enrollment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `grade_level`
--
ALTER TABLE `grade_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade_records`
--
ALTER TABLE `grade_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_emoji`
--
ALTER TABLE `message_emoji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
