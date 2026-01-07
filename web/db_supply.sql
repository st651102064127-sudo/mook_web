-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 07:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_supply`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcementboard`
--

CREATE TABLE `announcementboard` (
  `BoardID` int(10) NOT NULL,
  `BoardName` varchar(255) NOT NULL,
  `BoardDetail` varchar(255) DEFAULT NULL,
  `BoardImg` text DEFAULT NULL,
  `BoardDate` datetime NOT NULL,
  `BoardStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcementboard`
--

INSERT INTO `announcementboard` (`BoardID`, `BoardName`, `BoardDetail`, `BoardImg`, `BoardDate`, `BoardStatus`) VALUES
(1, 'Test1', 'test1............', '1763359012_เว็บพัสดุ.pdf', '2025-11-13 13:00:58', 'Active'),
(2, 'ประชุมเชิงปฏิบัติการ...', 'ประชุมเชิงปฏิบัติการด้านพฤติกรรม', '1764142821_เว็บพัสดุ.pdf', '2025-11-26 14:40:21', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--

CREATE TABLE `auditlog` (
  `AuditID` int(11) NOT NULL,
  `AuditTableName` varchar(100) NOT NULL,
  `AuditRecord` varchar(50) NOT NULL,
  `AuditActionType` varchar(100) NOT NULL,
  `AuditBefore` varchar(255) DEFAULT NULL,
  `AuditUpdate` varchar(255) DEFAULT NULL,
  `AuditEmpID` int(11) NOT NULL,
  `AuditEditDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmpID` int(11) NOT NULL,
  `EmpName` varchar(100) NOT NULL,
  `EmpCod` char(10) NOT NULL,
  `EmpPass` varchar(255) NOT NULL,
  `EmpEmail` varchar(100) NOT NULL,
  `EmpPhone` varchar(20) NOT NULL,
  `EmpPosition` varchar(100) NOT NULL,
  `EmpDepartment` varchar(100) NOT NULL,
  `EmpAgency` varchar(100) NOT NULL,
  `EmpRole` varchar(50) NOT NULL,
  `EmpLastLogin` datetime DEFAULT current_timestamp(),
  `ResetToken` varchar(100) DEFAULT NULL,
  `ResetExpire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmpID`, `EmpName`, `EmpCod`, `EmpPass`, `EmpEmail`, `EmpPhone`, `EmpPosition`, `EmpDepartment`, `EmpAgency`, `EmpRole`, `EmpLastLogin`, `ResetToken`, `ResetExpire`) VALUES
(1, 'พัสภัคค์', '12934', '$2y$10$R2EbHW.pMuVvas9WoZ13R.nIfEOW9jxPLb50iqhwIn3ToI4CZZbd2', 'passapak2427@gmail.com', '0897654321', 'เจ้าหน้าที่พัสดุ', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 'Member', '2025-09-21 13:53:15', NULL, NULL),
(2, 'พัทนันท์', '12345', '$2y$10$tEZxBR3CnJMzmNn4ltZMludb5rkKbmQIuziS7FpT0dKAhOP0kveEC', 'phathanun@gmail.com', '0987654321', 'เจ้าหน้าที่พัสดุ', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 'Member', '2025-11-17 11:20:14', NULL, NULL),
(3, 'พัทนันท์ ขาวสง่า', '12978', '$2y$10$2py4YjEqQuihOAn6goWKguGCndXLmsAjmxDnjCpt6iOJnjusnXHZe', 'phat@gmail.com', '0987654321', 'เจ้าหน้าที่พัสดุ', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 'Member', '2025-11-17 11:19:28', NULL, NULL),
(4, 'สมเกียรติ จันทรา', '12975', '$2y$10$qaosFFIZeaqNt8q6Jy9HIuJJ1N8NcBI7rOt7ibzQu4vQiRyJAYpL.', 'som@gmail.com', '0987654321', 'เจ้าหน้าที่พัสดุ', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 'Member', '2025-11-25 11:44:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `externalnews`
--

CREATE TABLE `externalnews` (
  `ExtNewsID` int(10) NOT NULL,
  `ExtNewsName` varchar(255) NOT NULL,
  `ExtNewsDetail` varchar(255) DEFAULT NULL,
  `ExtNewsFile` varchar(255) DEFAULT NULL,
  `ExtNewsDate` datetime NOT NULL,
  `ExtNewsStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `externalnews`
--

INSERT INTO `externalnews` (`ExtNewsID`, `ExtNewsName`, `ExtNewsDetail`, `ExtNewsFile`, `ExtNewsDate`, `ExtNewsStatus`) VALUES
(1, 'Test', 'Testประชุมเชิงปฏิบัติการ', '1762410750_CRM.pdf', '2025-10-31 05:33:41', 'Active'),
(2, 'ประชุมเชิงปฏิบัติการ...', 'ประชุมเชิงปฏิบัติการ', NULL, '2025-10-31 05:33:41', 'Active'),
(4, 'อบรมบุคลากรด้านความปลอดภัย...', 'อบรมบุคลากรด้านความปลอดภัย', '1762931382_สรุปค่าใช้จ่าย.pdf', '2025-11-06 13:31:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `internalnews`
--

CREATE TABLE `internalnews` (
  `IntNewsID` int(10) NOT NULL,
  `IntNewsName` varchar(255) NOT NULL,
  `IntNewsDetail` varchar(255) DEFAULT NULL,
  `IntNewsFile` varchar(255) DEFAULT NULL,
  `IntNewsDate` datetime NOT NULL,
  `IntNewsStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internalnews`
--

INSERT INTO `internalnews` (`IntNewsID`, `IntNewsName`, `IntNewsDetail`, `IntNewsFile`, `IntNewsDate`, `IntNewsStatus`) VALUES
(1, 'Test', 'test....', '1763357318_รูปภาพ2.jpg', '2025-11-11 13:06:41', 'Active'),
(2, 'อบรมบุคลากรด้านความปลอดภัย...', 'อบรมบุคลากรด้านความปลอดภัยต่างๆ', '1764047390_เว็บพัสดุ.pdf', '2025-11-25 12:09:50', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `noticetype`
--

CREATE TABLE `noticetype` (
  `NoticeTypeID` int(11) NOT NULL,
  `NoticeTypeName` varchar(255) NOT NULL,
  `NoticeTypeStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photoalbum`
--

CREATE TABLE `photoalbum` (
  `AlbumID` int(10) NOT NULL,
  `AlbumName` varchar(100) NOT NULL,
  `AlbumDetail` varchar(255) DEFAULT NULL,
  `AlbumDate` datetime NOT NULL,
  `AlbumImg` varchar(255) DEFAULT NULL,
  `AlbumStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photoalbum`
--

INSERT INTO `photoalbum` (`AlbumID`, `AlbumName`, `AlbumDetail`, `AlbumDate`, `AlbumImg`, `AlbumStatus`) VALUES
(1, 'อบรมบุคลากรด้านความปลอดภัย...', 'album', '2025-11-16 12:38:00', '1763271480_รูปภาพ2.jpg', 'Active'),
(2, 'Test', 'test', '2025-11-16 12:11:56', '', 'Active'),
(3, 'ประชุมเชิงปฏิบัติการ...', 'ประชุมเชิงปฏิบัติการ', '2025-11-16 12:36:59', '1763271419_logo_rmutsb.jpg', 'Active'),
(4, 'Test2', 'test2', '2025-11-16 12:36:45', '1763270576_7.png,1763270576_8.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `procurementcontract`
--

CREATE TABLE `procurementcontract` (
  `ContractID` int(10) NOT NULL,
  `ContractName` varchar(100) NOT NULL,
  `ContractDate` datetime NOT NULL,
  `ContractEndDate` datetime NOT NULL,
  `ContractFile` varchar(255) DEFAULT NULL,
  `ContractDepartment` varchar(50) NOT NULL,
  `ContractAgency` varchar(100) NOT NULL,
  `ContractMethodID` int(10) NOT NULL,
  `ContractStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procurementcontract`
--

INSERT INTO `procurementcontract` (`ContractID`, `ContractName`, `ContractDate`, `ContractEndDate`, `ContractFile`, `ContractDepartment`, `ContractAgency`, `ContractMethodID`, `ContractStatus`) VALUES
(1, 'อบรมบุคลากรด้านความปลอดภัย', '2025-11-15 00:00:00', '2025-11-21 00:00:00', '1763185735_แบบประเมิน.pdf', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `procurementmethod`
--

CREATE TABLE `procurementmethod` (
  `MethodID` int(11) NOT NULL,
  `MethodName` varchar(100) NOT NULL,
  `MethodStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `procurementnotice`
--

CREATE TABLE `procurementnotice` (
  `NoticeID` int(10) NOT NULL,
  `NoticeName` varchar(100) NOT NULL,
  `NoticeStDate` datetime NOT NULL,
  `NoticeEnDate` datetime NOT NULL,
  `NoticeFile` varchar(255) DEFAULT NULL,
  `NoticeDepartment` varchar(50) NOT NULL,
  `NoticeAgency` varchar(100) NOT NULL,
  `NoticeTypeID` int(10) NOT NULL,
  `NoticeMethodID` int(10) NOT NULL,
  `NoticeStatus` char(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `procurementnotice`
--

INSERT INTO `procurementnotice` (`NoticeID`, `NoticeName`, `NoticeStDate`, `NoticeEnDate`, `NoticeFile`, `NoticeDepartment`, `NoticeAgency`, `NoticeTypeID`, `NoticeMethodID`, `NoticeStatus`) VALUES
(1, 'ประชุมเชิงปฏิบัติการ...', '2025-11-14 00:00:00', '2025-11-20 00:00:00', '1763102572_หน้าปก-ปลิว (1).pdf', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 1, 1, 'Active'),
(2, 'อบรมบุคลากรด้านความปลอดภัย', '2025-11-14 00:00:00', '2025-11-17 00:00:00', '1763101050_QR CODE แบบประเมินความพึงพอใจ.pdf', 'กลุ่มงานพัสดุ', 'โรงพยาบาลหล่มสัก', 1, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_number_of_visitors`
--

CREATE TABLE `tb_number_of_visitors` (
  `nov_id` int(11) NOT NULL,
  `nov_user_id` int(11) NOT NULL,
  `nov_date_save` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_number_of_visitors`
--

INSERT INTO `tb_number_of_visitors` (`nov_id`, `nov_user_id`, `nov_date_save`) VALUES
(3, 5, '2022-11-17 14:25:29'),
(4, 5, '2022-11-17 14:25:37'),
(5, 5, '2022-11-17 14:25:43'),
(6, 5, '2022-11-17 15:08:03'),
(7, 5, '2022-11-17 15:10:13'),
(8, 5, '2022-11-17 15:53:21'),
(9, 5, '2022-11-17 16:24:15'),
(10, 5, '2022-11-17 16:38:43'),
(11, 5, '2022-11-17 16:39:57'),
(12, 5, '2022-11-17 16:55:56'),
(13, 5, '2022-11-17 17:03:32'),
(14, 5, '2022-11-17 17:06:41'),
(15, 5, '2022-11-17 17:12:03'),
(16, 5, '2022-11-17 17:12:14'),
(17, 5, '2022-11-17 17:12:59'),
(18, 5, '2022-11-17 17:18:57'),
(19, 10, '2022-11-17 17:27:16'),
(20, 10, '2022-11-17 17:28:32'),
(21, 5, '2022-11-17 17:28:37'),
(22, 5, '2022-11-17 17:30:20'),
(23, 5, '2022-11-17 17:30:25'),
(24, 5, '2022-11-17 17:30:36'),
(25, 5, '2022-11-17 17:30:39'),
(26, 5, '2022-11-17 17:30:49'),
(27, 5, '2022-11-17 17:31:01'),
(28, 5, '2022-11-19 02:12:13'),
(29, 13, '2022-11-19 02:13:39'),
(30, 5, '2022-11-19 11:52:58'),
(31, 15, '2022-11-19 11:55:16'),
(32, 15, '2022-11-19 11:55:42'),
(33, 15, '2022-11-19 11:55:51'),
(34, 15, '2022-11-19 11:58:10'),
(35, 15, '2022-11-19 12:01:12'),
(36, 17, '2022-11-19 12:01:53'),
(37, 17, '2022-11-19 12:02:15'),
(38, 18, '2022-11-19 12:05:17'),
(39, 18, '2022-11-19 12:05:21'),
(40, 18, '2022-11-19 12:06:26'),
(41, 18, '2022-11-19 12:06:34'),
(42, 18, '2022-11-19 12:06:39'),
(43, 18, '2022-11-19 12:09:04'),
(44, 18, '2022-11-19 12:10:08'),
(45, 21, '2022-11-19 12:10:58'),
(46, 18, '2022-11-19 12:13:18'),
(47, 18, '2022-11-19 12:32:10'),
(48, 1, '2022-11-21 13:09:44'),
(49, 1, '2022-11-21 13:10:16'),
(50, 1, '2022-11-21 13:11:41'),
(51, 1, '2022-11-21 13:12:24'),
(52, 1, '2022-11-22 13:49:32'),
(53, 1, '2022-11-22 13:50:37'),
(54, 1, '2022-11-22 13:50:54'),
(55, 22, '2022-11-24 14:00:08'),
(56, 1, '2022-11-25 07:12:12'),
(57, 1, '2022-11-25 07:36:20'),
(58, 1, '2022-11-25 07:36:25'),
(59, 6, '2022-11-25 07:37:09'),
(60, 1, '2022-11-25 07:48:13'),
(61, 1, '2022-11-25 10:58:41'),
(62, 1, '2022-11-25 10:59:03'),
(63, 1, '2025-09-12 07:16:10'),
(64, 1, '2025-09-12 07:20:29'),
(65, 1, '2025-09-13 04:26:26'),
(66, 5, '2025-09-14 03:08:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcementboard`
--
ALTER TABLE `announcementboard`
  ADD PRIMARY KEY (`BoardID`);

--
-- Indexes for table `auditlog`
--
ALTER TABLE `auditlog`
  ADD PRIMARY KEY (`AuditID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmpID`),
  ADD UNIQUE KEY `uniq_empcod` (`EmpCod`);

--
-- Indexes for table `externalnews`
--
ALTER TABLE `externalnews`
  ADD PRIMARY KEY (`ExtNewsID`);

--
-- Indexes for table `internalnews`
--
ALTER TABLE `internalnews`
  ADD PRIMARY KEY (`IntNewsID`);

--
-- Indexes for table `noticetype`
--
ALTER TABLE `noticetype`
  ADD PRIMARY KEY (`NoticeTypeID`);

--
-- Indexes for table `photoalbum`
--
ALTER TABLE `photoalbum`
  ADD PRIMARY KEY (`AlbumID`);

--
-- Indexes for table `procurementcontract`
--
ALTER TABLE `procurementcontract`
  ADD PRIMARY KEY (`ContractID`);

--
-- Indexes for table `procurementmethod`
--
ALTER TABLE `procurementmethod`
  ADD PRIMARY KEY (`MethodID`);

--
-- Indexes for table `procurementnotice`
--
ALTER TABLE `procurementnotice`
  ADD PRIMARY KEY (`NoticeID`),
  ADD KEY `NoticeTypeID` (`NoticeTypeID`,`NoticeMethodID`);

--
-- Indexes for table `tb_number_of_visitors`
--
ALTER TABLE `tb_number_of_visitors`
  ADD PRIMARY KEY (`nov_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcementboard`
--
ALTER TABLE `announcementboard`
  MODIFY `BoardID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `auditlog`
  MODIFY `AuditID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `externalnews`
--
ALTER TABLE `externalnews`
  MODIFY `ExtNewsID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `internalnews`
--
ALTER TABLE `internalnews`
  MODIFY `IntNewsID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `noticetype`
--
ALTER TABLE `noticetype`
  MODIFY `NoticeTypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photoalbum`
--
ALTER TABLE `photoalbum`
  MODIFY `AlbumID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `procurementcontract`
--
ALTER TABLE `procurementcontract`
  MODIFY `ContractID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `procurementmethod`
--
ALTER TABLE `procurementmethod`
  MODIFY `MethodID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procurementnotice`
--
ALTER TABLE `procurementnotice`
  MODIFY `NoticeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_number_of_visitors`
--
ALTER TABLE `tb_number_of_visitors`
  MODIFY `nov_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
