-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2018 at 05:10 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vnpt_mds`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities_log`
--

CREATE TABLE `activities_log` (
  `activity_log_id` int(11) NOT NULL,
  `activity_type` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities_log`
--

INSERT INTO `activities_log` (`activity_log_id`, `activity_type`, `description`, `user_id`, `create_at`) VALUES
(1, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Điều hòa LG Inverter... vào trạm TEST', 1, 1517366972),
(2, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Nguyễn Đình Châu 1', 1, 1517372138),
(3, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Cisco ASR 1013 Router vào trạm TEST', 1, 1517372449),
(4, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Điều hòa LG Inverter... vào trạm TEST', 1, 1517372477),
(5, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Điều hòa LG Inverter... vào trạm NT000', 1, 1517372610),
(6, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng SMO-T2-2018', 1, 1517389037),
(7, 'maintenance-do', 'Đợt bảo dưỡng TKY01-Q4 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1517389618),
(8, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Switch Cisco 24 port', 1, 1517447890),
(9, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Switch Cisco 48 port', 1, 1517447936),
(10, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Máy nổ Samsung 10kW', 1, 1517448864),
(11, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Tủ rec Huawei', 1, 1517454234),
(12, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Nhà trạm thông minh', 1, 1517454352),
(13, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị VIENTHONG', 1, 1517457640),
(14, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Tủ BTS Huawei', 1, 1517457788),
(15, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Ống dẫn sóng 2G', 1, 1517468069),
(16, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Ống dẫn sóng 3G', 1, 1517468085),
(17, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị BTS Huawei 3G', 1, 1517468347),
(18, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị BTS Huawei 3G', 1, 1517468583),
(19, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị BTS ZTE BS8800 2G', 1, 1517468649),
(20, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Tủ nguồn DC ZTE', 1, 1517474331),
(21, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TKY-T2', 1, 1517478419),
(22, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Switch Cisco 48 port', 1, 1517541358),
(23, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Máy nổ Samsung 100kW', 1, 1517542514),
(24, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Switch Cisco 24 port xx', 1, 1517542543),
(26, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng AN-HOA_T2-2018, Ng Đi Ti Ci li làm nhóm trưởng.', 1, 1517794240),
(27, 'maintenance-do', 'Đợt bảo dưỡng AN-HOA_T2-2018 đang được thực hiện bởi Ng Đi Ti Ci li', 2, 1517794420),
(28, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TKY T2-2018, OMC làm nhóm trưởng.', 1, 1517816590),
(29, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng Tam-Thanh_T2-2018, Lê Duy Trung  làm nhóm trưởng.', 1, 1517816628),
(30, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TEST_T2-2018, Trần Ngọc Nam làm nhóm trưởng.', 1, 1517816666),
(31, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng Tam-An_T2-2018, Ng Đi Ti Ci li làm nhóm trưởng.', 1, 1517816709),
(32, 'maintenance-do', 'Đợt bảo dưỡng Tam-Phu-Q1 đang được thực hiện bởi Ng Đi Ti Ci li', 2, 1517818438),
(33, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng Tam-Phu-Q1, Ng Đi Ti Ci li làm nhóm trưởng.', 1, 1517819059),
(34, 'maintenance-do', '<b>Chậm tiến độ!!!</b> <br>Đợt bảo dưỡng Tam-Phu-Q1 đang được thực hiện bởi Ng Đi Ti Ci li', 2, 1517819101),
(35, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng NT-001_T2-2018, Nguyễn Đình Châu làm nhóm trưởng.', 1, 1517881200),
(36, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng Tam-Loc_QNM_Q1, Nguyễn Đình Châu làm nhóm trưởng.', 1, 1517902246),
(37, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng NT000-T22018, Nguyễn Đình Châu làm nhóm trưởng.', 1, 1517902309),
(38, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Máy nổ Samsung 10kW vào trạm NT000', 1, 1517902357),
(39, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị BTS Huawei 3G vào trạm NT000', 1, 1517902384),
(40, 'maintenance-do', 'Đợt bảo dưỡng NT000-T22018 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1517902515),
(41, 'maintenance-do', 'Đợt bảo dưỡng NT000-T22018 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1517902524),
(42, 'maintenance-do', '<b>Chậm tiến độ!!!</b> <br>Đợt bảo dưỡng NT000-T22018 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1517970404),
(43, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Máy nổ Samsung 100kW vào trạm TKY-001', 1, 1519887008),
(44, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ống dẫn sóng 2G vào trạm TKY-001', 1, 1519887231),
(45, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ống dẫn sóng 2G vào trạm TKY-001', 1, 1519887633),
(46, 'maintenance-do', '<b>Chậm tiến độ!!!</b> <br>Đợt bảo dưỡng SMO-T2-2018 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1520913020),
(47, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TESTTTTTTTTTTTTT, Trần Như Hoàng làm nhóm trưởng.', 1, 1520927666),
(48, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Switch Cisco 48 port', 1, 1521426616),
(49, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị ABC', 1, 1521426972),
(50, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Máy nổ Samsung 100kW', 1, 1521427075),
(51, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Tủ nguồn DC ZTE vào trạm TEST', 1, 1521428298),
(52, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Nhà trạm thông minh v2', 1, 1521441713),
(53, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Tủ rec Huawei', 1, 1521450517),
(54, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1521451257),
(55, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ống dẫn sóng 3G vào trạm TKY-001', 1, 1521511634),
(56, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ống dẫn sóng 3G vào trạm AN-HOA_QNM', 1, 1521513617),
(57, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ống dẫn sóng 3G vào trạm AN-HOA_QNM', 1, 1521513744),
(58, 'maintenance-finish', 'Nguyễn Đình Châu đã kết thúc đợt bảo dưỡng SMO-T2-2018', 1, 1521518739),
(59, 'maintenance-do', '<b>Thực hiện sớm so với kế hoạch!</b> <br>Đợt bảo dưỡng NT-001_T3-2018 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1521519245),
(60, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị TEST', 1, 1521600976),
(61, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị TESTTTT', 1, 1521601407),
(62, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Te văn Tét', 1, 1521614557),
(63, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Tủ nguồn DC ZTE vào trạm TKY-001', 1, 1521685930),
(64, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Tủ rec Huawei vào trạm TKY-001', 1, 1521685964),
(65, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng BO-PHUPHONG-t3, Nguyễn Đình Châu làm nhóm trưởng.', 1, 1521711488),
(66, 'maintenance-do', '<b>Thực hiện sớm so với kế hoạch!</b> <br>Đợt bảo dưỡng BO-PHUPHONG-t3 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1521711585),
(67, 'maintenance-finish', 'Nguyễn Đình Châu đã kết thúc đợt bảo dưỡng BO-PHUPHONG-t3', 1, 1521711685),
(68, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị Đơn vị TEST', 1, 1521712626),
(69, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1521712671),
(70, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tét văn Te', 1, 1521712791),
(71, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị HELLO', 1, 1521713003),
(72, 'maintenance-finish', 'Nguyễn Đình Châu đã kết thúc đợt bảo dưỡng NT-001_T3-2018', 1, 1521794574),
(73, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị Đơn vị TEST', 1, 1521794642),
(74, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị Đơn vị TEST', 1, 1522029199),
(75, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1522029487),
(76, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị Đơn vị TEST', 1, 1522029609),
(77, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1522029655),
(78, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ắc quy GS N200 vào trạm TEST', 1, 1522029700),
(79, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Test ', 1, 1522029869),
(80, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị test123', 1, 1522029920),
(81, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ắc quy GS N200 vào trạm TKY-001', 1, 1522029992),
(82, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1522031212),
(83, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Test ', 1, 1522032922),
(84, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Test ', 1, 1522035929),
(85, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TamPhuocT3, Tét văn Te làm nhóm trưởng.', 1, 1522054022),
(86, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Ắc quy GS N200 vào trạm VHX-Tam-Phuoc_QNM', 1, 1522054065),
(87, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Điều hòa LG Inverter... vào trạm VHX-Tam-Phuoc_QNM', 1, 1522054120),
(88, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Máy nổ Samsung 10kW vào trạm VHX-Tam-Phuoc_QNM', 1, 1522054365),
(89, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TamThanht4, Lưu Văn Tùng làm nhóm trưởng.', 1, 1522117492),
(90, 'maintenance-do', '<b>Thực hiện sớm so với kế hoạch!</b> <br>Đợt bảo dưỡng TamThanht4 đang được thực hiện bởi Lưu Văn Tùng', 22, 1522117582),
(91, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng TamLoc T4, Nguyễn Đình Châu làm nhóm trưởng.', 1, 1522117813),
(92, 'maintenance-do', '<b>Thực hiện sớm so với kế hoạch!</b> <br>Đợt bảo dưỡng TamLoc T4 đang được thực hiện bởi Nguyễn Đình Châu', 1, 1522117876),
(93, 'maintenance-finish', 'Nguyễn Đình Châu đã kết thúc đợt bảo dưỡng TamLoc T4', 1, 1522118109),
(95, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị TEST', 1, 1522147066),
(96, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tài khoản root', 1, 1523497343),
(98, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tài khoản GDTT 1', 1, 1523504229),
(99, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tài khoản GDTT 2', 1, 1523504281),
(100, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tài khoản GDTT 4', 1, 1523505036),
(101, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Tài khoản GDTT 2', 1, 1523505156),
(102, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Trưởng đài TKY-PN', 1, 1523505275),
(103, 'user-add', 'Nguyễn Đình Châu đã thêm nhân viên Trưởng đài Núi Thành', 1, 1523506962),
(104, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị Đơn vị TEST', 1, 1523521234),
(105, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1523521260),
(106, 'unit-add', 'Nguyễn Đình Châu đã thêm đơn vị TEST', 1, 1523521287),
(107, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Máy nổ Samsung 100kW vào trạm TEST', 1, 1523522927),
(108, 'device-add', 'Nguyễn Đình Châu đã thêm nhóm thiết bị TEST', 1, 1523523218),
(109, 'device-add', 'Nguyễn Đình Châu đã thêm loại thiết bị Test device', 1, 1523523268),
(110, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Test device vào trạm TEST', 1, 1523523435),
(111, 'maintenance-do', '<b>Chậm tiến độ!!!</b> <br>Đợt bảo dưỡng TamPhuocT3 đang được thực hiện bởi Tét văn Te', 90, 1523584360),
(112, 'device-add', 'Nguyễn Đình Châu đã thêm thiết bị Switch Cisco 48 port vào trạm SMO', 1, 1524216061),
(113, 'maintenance-create', 'Nguyễn Đình Châu đã tạo đợt bảo dưỡng SMO-T5-2018, Nguyễn Thành làm nhóm trưởng.', 1, 1524217318),
(114, 'maintenance-finish', 'Tét văn Te đã kết thúc đợt bảo dưỡng TamPhuocT3', 90, 1524218131);

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_type` varchar(32) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_type`, `activity_name`, `class`) VALUES
('device-add', 'Thêm thiết bị', 'fa fa-tablet'),
('device-remove', 'Xóa thiết bị', 'fa fa-tablet'),
('maintenance-create', 'Lên kế hoạch ', 'fa fa-list-ol'),
('maintenance-do', 'Thực hiện đợt bảo dưỡng', 'fa fa-wrench'),
('maintenance-finish', 'Hoàn thành đợt bảo dưỡng', 'fa fa-check-square-o'),
('unit-add', 'Thêm đơn vị', 'fa fa-university'),
('unit-remove', 'Xóa đơn vị', 'fa fa-university'),
('user-add', 'Thêm nhân viên', 'fa fa-user-plus'),
('user-remove', 'Xóa nhân viên', 'fa fa-user-times');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Administrator', 1, NULL),
('Administrator', 2, 1523503658),
('Administrator', 12, 1522745048),
('Administrator', 13, NULL),
('Administrator', 89, NULL),
('Administrator', 90, NULL),
('Administrator', 92, NULL),
('Administrator', 98, NULL),
('create-daivt', 12, 1522745043),
('create-dbd', 100, 1523505896),
('create-tbitram', 100, 1523505896),
('create-tramvt', 100, 1523505896),
('Role xxx', 93, NULL),
('Role xxx', 101, NULL),
('Root', 94, 1523497429),
('Viewer', 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Administrator', 1, 'Quản trị hệ thống', NULL, NULL, NULL, 1522804322),
('create-daivt', 2, NULL, NULL, NULL, NULL, 1522661824),
('create-dbd', 2, NULL, NULL, NULL, NULL, 1522912122),
('create-dexuatnoidung', 2, NULL, NULL, NULL, NULL, NULL),
('create-donvi', 2, NULL, NULL, NULL, NULL, NULL),
('create-loaitb', 2, NULL, NULL, NULL, NULL, NULL),
('create-nhanvien', 2, NULL, NULL, NULL, NULL, NULL),
('create-nhomtb', 2, NULL, NULL, NULL, NULL, NULL),
('create-noidungbaotri', 2, NULL, NULL, NULL, NULL, NULL),
('create-tbitram', 2, NULL, NULL, NULL, NULL, NULL),
('create-thietbi', 2, NULL, NULL, NULL, NULL, NULL),
('create-tramvt', 2, NULL, NULL, NULL, NULL, NULL),
('create-user', 2, NULL, NULL, NULL, NULL, 1522912146),
('delete-daivt', 2, NULL, NULL, NULL, NULL, NULL),
('delete-dbd', 2, NULL, NULL, NULL, NULL, 1522912162),
('delete-dexuatnoidung', 2, NULL, NULL, NULL, NULL, NULL),
('delete-donvi', 2, NULL, NULL, NULL, NULL, NULL),
('delete-loaitb', 2, NULL, NULL, NULL, NULL, NULL),
('delete-nhanvien', 2, NULL, NULL, NULL, NULL, NULL),
('delete-nhomtb', 2, NULL, NULL, NULL, NULL, NULL),
('delete-noidungbaotri', 2, NULL, NULL, NULL, NULL, NULL),
('delete-tbitram', 2, NULL, NULL, NULL, NULL, NULL),
('delete-thietbi', 2, NULL, NULL, NULL, NULL, NULL),
('delete-tramvt', 2, NULL, NULL, NULL, NULL, NULL),
('delete-user', 2, NULL, NULL, NULL, NULL, NULL),
('edit-daivt', 2, NULL, NULL, NULL, NULL, NULL),
('edit-dbd', 2, NULL, NULL, NULL, NULL, NULL),
('edit-dexuatnoidung', 2, NULL, NULL, NULL, NULL, NULL),
('edit-donvi', 2, NULL, NULL, NULL, NULL, NULL),
('edit-loaitb', 2, NULL, NULL, NULL, NULL, NULL),
('edit-nhanvien', 2, NULL, NULL, NULL, NULL, NULL),
('edit-nhomtb', 2, NULL, NULL, NULL, NULL, NULL),
('edit-noidungbaotri', 2, NULL, NULL, NULL, NULL, NULL),
('edit-tbitram', 2, NULL, NULL, NULL, NULL, NULL),
('edit-thietbi', 2, NULL, NULL, NULL, NULL, NULL),
('edit-tramvt', 2, NULL, NULL, NULL, NULL, NULL),
('edit-user', 2, NULL, NULL, NULL, NULL, NULL),
('Role xxx', 1, 'Vai trò X', NULL, NULL, NULL, 1522804346),
('Root', 1, 'Vai trò tối cao', NULL, NULL, 1523414541, 1523414541),
('Viewer', 1, ':)))\r\n', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Administrator', 'create-daivt'),
('Administrator', 'create-dbd'),
('Administrator', 'create-dexuatnoidung'),
('Administrator', 'create-donvi'),
('Administrator', 'create-loaitb'),
('Administrator', 'create-nhanvien'),
('Administrator', 'create-nhomtb'),
('Administrator', 'create-noidungbaotri'),
('Administrator', 'create-tbitram'),
('Administrator', 'create-thietbi'),
('Administrator', 'create-tramvt'),
('Administrator', 'create-user'),
('Administrator', 'delete-daivt'),
('Administrator', 'delete-dbd'),
('Administrator', 'delete-dexuatnoidung'),
('Administrator', 'delete-donvi'),
('Administrator', 'delete-loaitb'),
('Administrator', 'delete-nhanvien'),
('Administrator', 'delete-nhomtb'),
('Administrator', 'delete-noidungbaotri'),
('Administrator', 'delete-tbitram'),
('Administrator', 'delete-thietbi'),
('Administrator', 'delete-tramvt'),
('Administrator', 'delete-user'),
('Administrator', 'edit-daivt'),
('Administrator', 'edit-dbd'),
('Administrator', 'edit-dexuatnoidung'),
('Administrator', 'edit-donvi'),
('Administrator', 'edit-loaitb'),
('Administrator', 'edit-nhanvien'),
('Administrator', 'edit-nhomtb'),
('Administrator', 'edit-noidungbaotri'),
('Administrator', 'edit-tbitram'),
('Administrator', 'edit-thietbi'),
('Administrator', 'edit-tramvt'),
('Administrator', 'edit-user'),
('Role xxx', 'create-dbd'),
('Role xxx', 'create-dexuatnoidung'),
('Role xxx', 'create-tbitram'),
('Role xxx', 'create-thietbi'),
('Role xxx', 'create-tramvt'),
('Root', 'Administrator'),
('Root', 'create-daivt'),
('Root', 'create-dbd'),
('Root', 'create-dexuatnoidung'),
('Root', 'create-donvi'),
('Root', 'create-loaitb'),
('Root', 'create-nhanvien'),
('Root', 'create-nhomtb'),
('Root', 'create-noidungbaotri'),
('Root', 'create-tbitram'),
('Root', 'create-thietbi'),
('Root', 'create-tramvt'),
('Root', 'create-user'),
('Root', 'delete-daivt'),
('Root', 'delete-dbd'),
('Root', 'delete-dexuatnoidung'),
('Root', 'delete-donvi'),
('Root', 'delete-loaitb'),
('Root', 'delete-nhanvien'),
('Root', 'delete-nhomtb'),
('Root', 'delete-noidungbaotri'),
('Root', 'delete-tbitram'),
('Root', 'delete-thietbi'),
('Root', 'delete-tramvt'),
('Root', 'delete-user'),
('Root', 'edit-daivt'),
('Root', 'edit-dbd'),
('Root', 'edit-dexuatnoidung'),
('Root', 'edit-donvi'),
('Root', 'edit-loaitb'),
('Root', 'edit-nhanvien'),
('Root', 'edit-nhomtb'),
('Root', 'edit-noidungbaotri'),
('Root', 'edit-tbitram'),
('Root', 'edit-thietbi'),
('Root', 'edit-tramvt'),
('Root', 'edit-user');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `baocao`
--

CREATE TABLE `baocao` (
  `ID_DOTBD` int(11) NOT NULL,
  `KETQUA` varchar(32) NOT NULL,
  `GHICHU` varchar(255) DEFAULT NULL,
  `ANH1` varchar(255) DEFAULT NULL,
  `ANH2` varchar(255) DEFAULT NULL,
  `ANH3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `baocao`
--

INSERT INTO `baocao` (`ID_DOTBD`, `KETQUA`, `GHICHU`, `ANH1`, `ANH2`, `ANH3`) VALUES
(5, 'Đạt', 'Hoàn thành xuất sắc', 'uploads/AN-HOA-Q4_1.jpg', NULL, NULL),
(7, 'Đạt', '', 'uploads/Tam-Loc_QNM_Q1_1.jpg', NULL, NULL),
(10, 'Chưa đạt', 'Đợt bảo dưỡng chưa hoàn thành', 'uploads/SMO-T2-2018_1.png', NULL, NULL),
(21, 'Đạt', '', 'uploads/NT-001_T3-2018_1.png', 'uploads/NT-001_T3-2018_2.jpg', 'uploads/NT-001_T3-2018_3.jpg'),
(26, 'Đạt', '', 'uploads/TamPhuocT3_1.png', 'uploads/TamPhuocT3_2.png', 'uploads/TamPhuocT3_3.png'),
(28, 'Đạt', '', 'uploads/TamLoc T4_1.png', 'uploads/TamLoc T4_2.jpg', 'uploads/TamLoc T4_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chontbidieuchuyen`
--

CREATE TABLE `chontbidieuchuyen` (
  `ID_THIETBI` int(11) NOT NULL,
  `ID_TRAM_NGUON` int(11) DEFAULT NULL,
  `ID_TRAM_DICH` int(11) DEFAULT NULL,
  `NGAY_CHUYEN` date DEFAULT NULL,
  `LY_DO` varchar(255) DEFAULT NULL,
  `IS_SELECTED` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chucvu`
--

CREATE TABLE `chucvu` (
  `id` int(11) NOT NULL,
  `ten_chucvu` varchar(64) NOT NULL,
  `cap` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chucvu`
--

INSERT INTO `chucvu` (`id`, `ten_chucvu`, `cap`) VALUES
(1, 'IT', 1),
(2, 'OMC', 1),
(3, 'Phòng kỹ thuật', 1),
(4, 'Giám đốc Trung tâm', 2),
(5, 'P. GĐ Trung tâm', 2),
(6, 'OMC Trung tâm', 2),
(7, 'Trưởng đài', 3),
(8, 'OMC Đài', 3),
(9, 'Quản lý trạm', 4),
(10, 'Tổ trưởng', 3),
(11, 'Nhân viên', 5);

-- --------------------------------------------------------

--
-- Table structure for table `chukybaoduong`
--

CREATE TABLE `chukybaoduong` (
  `id` int(11) NOT NULL,
  `alias` varchar(32) NOT NULL,
  `value` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chukybaoduong`
--

INSERT INTO `chukybaoduong` (`id`, `alias`, `value`) VALUES
(1, '7 ngày', '7 days'),
(2, '15 ngày', '15 days'),
(3, '1 tháng', '1 month'),
(4, '2 tháng', '2 months'),
(5, '3 tháng', '3 months'),
(6, '6 tháng', '6 months'),
(7, '12 tháng', '12 months'),
(8, '18 tháng', '18 months');

-- --------------------------------------------------------

--
-- Table structure for table `daivt`
--

CREATE TABLE `daivt` (
  `ID_DAI` int(11) NOT NULL,
  `MA_DAIVT` varchar(10) NOT NULL,
  `TEN_DAIVT` varchar(100) DEFAULT NULL,
  `DIA_CHI` varchar(100) DEFAULT NULL,
  `SO_DT` varchar(20) DEFAULT NULL,
  `ID_DONVI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `daivt`
--

INSERT INTO `daivt` (`ID_DAI`, `MA_DAIVT`, `TEN_DAIVT`, `DIA_CHI`, `SO_DT`, `ID_DONVI`) VALUES
(1, 'TKY', 'Đài Viễn thông Tam Kỳ-Phú Ninh', 'Trần Hưng Đạo', '', 4),
(3, 'NTH', 'Đài viễn thông Núi Thành', 'Núi Thành', '', 4),
(4, 'TPC', 'Đài viễn thông Tiên Phước-Trà My', 'Tiên Phước', '', 4),
(12, 'HAN', 'Đài viễn thông Hội An', 'Hội An', '', 6),
(13, 'DBN', 'Đài viễn thông Điện Bàn', 'Điện Bàn', '', 6),
(14, 'TBH', 'Đài viễn thông Thăng Bình', 'Thăng Bình', '', 5),
(15, 'DXN', 'Đài viễn thông Duy Xuyên', 'Duy Xuyên', '', 5),
(16, 'QSN', 'Đài viễn thông Quế Sơn', 'Quế Sơn', '', 5),
(17, 'HDC', 'Đài viễn thông Hiệp Đức-Phước Sơn', 'Tân An, Hiệp Đức', '', 5),
(19, 'DLC', 'Đài viễn thông Đại Lộc', 'Ái Nghĩa, Đại Lộc', '', 7),
(20, '3GG', 'Đài viễn thông Tam Giang', 'Thạnh Mỹ, Nam Giang', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `dexuatnoidung`
--

CREATE TABLE `dexuatnoidung` (
  `ID_LOAITB` int(11) NOT NULL,
  `LANBD` int(11) DEFAULT NULL,
  `CHUKYBAODUONG` int(11) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dexuatnoidung`
--

INSERT INTO `dexuatnoidung` (`ID_LOAITB`, `LANBD`, `CHUKYBAODUONG`, `MA_NOIDUNG`) VALUES
(1, 1, 1, '111'),
(1, 1, 1, '119'),
(1, 2, 2, '112'),
(1, 3, 4, '111'),
(1, 3, 4, '113'),
(1, 4, 6, '111'),
(1, 4, 6, '112'),
(1, 4, 6, '113'),
(1, 4, 6, '114'),
(1, 4, 6, '115'),
(1, 5, 7, '111'),
(1, 5, 7, '112'),
(1, 5, 7, '113'),
(1, 6, 8, '113'),
(1, 6, 8, '114'),
(1, 6, 8, '115'),
(1, 6, 8, '116'),
(1, 6, 8, '117'),
(1, 6, 8, '118'),
(2, 1, 1, '411'),
(2, 1, 1, '412'),
(2, 1, 1, '413'),
(2, 1, 1, '414'),
(2, 1, 1, '415'),
(2, 2, 3, '411'),
(2, 2, 3, '412'),
(2, 2, 3, '413'),
(2, 2, 3, '414'),
(2, 2, 3, '415'),
(2, 3, 5, '411'),
(2, 3, 5, '412'),
(2, 3, 5, '413'),
(2, 3, 5, '414'),
(2, 3, 5, '415'),
(2, 4, 7, '411'),
(2, 4, 7, '412'),
(2, 4, 7, '413'),
(2, 4, 7, '414'),
(2, 4, 7, '415'),
(6, 1, 1, '121'),
(6, 1, 1, '122'),
(6, 2, 3, '122'),
(6, 2, 3, '123'),
(6, 2, 3, '124'),
(6, 3, 5, '121'),
(6, 3, 5, '122'),
(6, 3, 5, '123'),
(6, 3, 5, '124'),
(6, 3, 5, '125'),
(6, 4, 6, '121'),
(6, 4, 6, '122'),
(6, 4, 6, '123'),
(6, 4, 6, '124'),
(6, 4, 6, '125'),
(6, 5, 7, '121'),
(6, 5, 7, '122'),
(6, 5, 7, '123'),
(6, 5, 7, '124'),
(6, 5, 7, '125'),
(6, 6, 8, '121'),
(6, 6, 8, '122'),
(6, 6, 8, '123'),
(6, 6, 8, '124'),
(6, 6, 8, '125'),
(7, 1, 1, '131'),
(7, 1, 1, '132'),
(7, 2, 2, '133'),
(7, 2, 2, '134'),
(7, 2, 2, '135'),
(7, 3, 3, '132'),
(7, 3, 3, '133'),
(7, 3, 3, '134'),
(7, 4, 5, '131'),
(7, 4, 5, '132'),
(7, 4, 5, '133'),
(7, 4, 5, '134'),
(7, 4, 5, '135'),
(7, 5, 6, '131'),
(7, 5, 6, '132'),
(7, 5, 6, '133'),
(7, 5, 6, '134'),
(7, 5, 6, '135'),
(7, 6, 7, '131'),
(7, 6, 7, '132'),
(7, 6, 7, '133'),
(7, 6, 7, '134'),
(7, 6, 7, '135'),
(7, 7, 8, '131'),
(7, 7, 8, '132'),
(7, 7, 8, '133'),
(7, 7, 8, '134'),
(7, 7, 8, '135'),
(9, 1, 1, '511'),
(9, 1, 1, '512'),
(9, 2, 2, '511'),
(9, 2, 2, '512'),
(9, 2, 2, '513'),
(10, 1, 1, '521'),
(10, 1, 1, '522'),
(10, 1, 1, '523'),
(10, 1, 1, '524'),
(10, 2, 2, '523'),
(10, 2, 2, '524'),
(10, 2, 2, '525'),
(10, 3, 3, '521'),
(10, 3, 3, '525'),
(10, 4, 4, '521'),
(10, 4, 4, '522'),
(10, 4, 4, '523'),
(10, 4, 4, '524'),
(10, 4, 4, '525'),
(10, 5, 5, '521'),
(10, 5, 5, '522'),
(10, 5, 5, '523'),
(10, 5, 5, '524'),
(10, 5, 5, '525'),
(10, 6, 6, '521'),
(10, 6, 6, '522'),
(10, 6, 6, '523'),
(10, 7, 7, '521'),
(10, 7, 7, '522'),
(10, 7, 7, '523'),
(10, 7, 7, '524'),
(10, 7, 7, '525'),
(10, 8, 8, '521'),
(10, 8, 8, '522'),
(10, 8, 8, '523'),
(10, 8, 8, '524'),
(10, 8, 8, '525'),
(11, 1, 2, '531'),
(11, 1, 2, '532'),
(11, 1, 2, '533'),
(11, 2, 3, '534'),
(11, 2, 3, '535'),
(11, 3, 4, '531'),
(11, 3, 4, '532'),
(11, 3, 4, '533'),
(11, 3, 4, '534'),
(11, 3, 4, '535'),
(11, 4, 5, '531'),
(11, 4, 5, '532'),
(11, 4, 5, '533'),
(11, 5, 7, '531'),
(11, 5, 7, '532'),
(11, 5, 7, '533'),
(11, 5, 7, '534'),
(11, 5, 7, '535'),
(11, 6, 8, '531'),
(11, 6, 8, '532'),
(11, 6, 8, '533'),
(11, 6, 8, '534'),
(11, 6, 8, '535'),
(17, 1, 1, '1711'),
(17, 2, 2, '1711'),
(17, 2, 2, '1712'),
(17, 3, 3, '1712'),
(17, 4, 4, '1711'),
(17, 4, 4, '1712'),
(21, 1, 3, '2111'),
(21, 2, 5, '2112'),
(21, 3, 6, '2111'),
(21, 3, 6, '2112'),
(21, 4, 7, '2111'),
(21, 4, 7, '2112'),
(21, 4, 7, '2113'),
(21, 5, 8, '2112'),
(21, 5, 8, '2113'),
(21, 5, 8, '2114'),
(23, 1, 1, '2311'),
(23, 2, 2, '2312'),
(23, 3, 3, '2313'),
(23, 4, 4, '2311'),
(23, 4, 4, '2312'),
(23, 5, 5, '2312'),
(23, 5, 5, '2313'),
(23, 6, 6, '2311'),
(23, 6, 6, '2313'),
(23, 7, 7, '2311'),
(23, 7, 7, '2312'),
(23, 7, 7, '2313');

-- --------------------------------------------------------

--
-- Table structure for table `dieuchuyenthietbi`
--

CREATE TABLE `dieuchuyenthietbi` (
  `ID` int(11) NOT NULL,
  `ID_THIETBI` int(11) NOT NULL,
  `NGAY_CHUYEN` date NOT NULL,
  `ID_TRAM_NGUON` int(11) NOT NULL,
  `ID_TRAM_DICH` int(11) NOT NULL,
  `LY_DO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dieuchuyenthietbi`
--

INSERT INTO `dieuchuyenthietbi` (`ID`, `ID_THIETBI`, `NGAY_CHUYEN`, `ID_TRAM_NGUON`, `ID_TRAM_DICH`, `LY_DO`) VALUES
(1, 21, '2018-03-22', 4, 1, 'Chuyển chơi'),
(2, 22, '2018-03-22', 4, 1, 'Chuyển chơi'),
(3, 9, '2018-03-23', 3, 1, 'Vui thì mình chuyển'),
(4, 9, '2018-03-23', 1, 3, 'Chơi chán rồi về'),
(5, 7, '2018-03-26', 3, 21, 'HEY HEY'),
(6, 21, '2018-03-26', 1, 21, 'HEY HEY'),
(7, 22, '2018-03-27', 1, 22, 'AAAA'),
(8, 28, '2018-03-27', 1, 22, 'AAAA'),
(9, 2, '2018-03-30', 2, 1, 'Chuyển chơi'),
(10, 2, '2018-03-31', 2, 1, 'Chuyển hay');

-- --------------------------------------------------------

--
-- Table structure for table `donvi`
--

CREATE TABLE `donvi` (
  `ID_DONVI` int(11) NOT NULL,
  `MA_DONVI` varchar(30) NOT NULL,
  `TEN_DONVI` varchar(100) DEFAULT NULL,
  `DIA_CHI` varchar(100) DEFAULT NULL,
  `SO_DT` varchar(20) DEFAULT NULL,
  `CAP_TREN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `donvi`
--

INSERT INTO `donvi` (`ID_DONVI`, `MA_DONVI`, `TEN_DONVI`, `DIA_CHI`, `SO_DT`, `CAP_TREN`) VALUES
(1, 'QNM', 'VNPT Quảng Nam', '2 Phan Bội Châu, Tam Kỳ', '0235.3812119', 1),
(2, 'CNTT', 'Trung tâm CNTT', '2 Phan Bội Châu, Tam Kỳ', '0510.3812119', 1),
(3, 'DHTT', 'Trung tâm ĐHTT', '2 Phan Bội Châu, Tam Kỳ', '', 1),
(4, 'TTVT1', 'Trung tâm Viễn thông 1', '4 Trần Hưng Đạo, Tam Kỳ', '', 1),
(5, 'TTVT2', 'Trung tâm Viễn thông 2', 'Nam Phước, Duy Xuyên', '', 1),
(6, 'TTVT3', 'Trung tâm Viễn thông 3', 'Hội An', '', 1),
(7, 'TTVT4', 'Trung tâm Viễn thông 4', 'Ái Nghĩa, Đại Lộc', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dotbaoduong`
--

CREATE TABLE `dotbaoduong` (
  `ID_DOTBD` int(11) NOT NULL,
  `MA_DOTBD` varchar(32) NOT NULL,
  `NGAY_DUKIEN` date DEFAULT NULL,
  `NGAY_BD` date NOT NULL,
  `ID_TRAMVT` int(11) NOT NULL,
  `TRANGTHAI` varchar(32) NOT NULL DEFAULT 'Kế hoạch',
  `TRUONG_NHOM` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dotbaoduong`
--

INSERT INTO `dotbaoduong` (`ID_DOTBD`, `MA_DOTBD`, `NGAY_DUKIEN`, `NGAY_BD`, `ID_TRAMVT`, `TRANGTHAI`, `TRUONG_NHOM`) VALUES
(5, 'AN-HOA-Q4', '2017-12-31', '2017-12-31', 4, 'Kết thúc', 7),
(7, 'Tam-Loc_QNM_Q1', '2018-02-01', '2018-02-01', 8, 'Kết thúc', 7),
(10, 'SMO-T2-2018', '2018-02-03', '2018-02-03', 3, 'Kết thúc', 7),
(16, 'TKY T2-2018', '2018-02-07', '2018-02-07', 1, 'Kế hoạch', 5),
(21, 'NT-001_T3-2018', '2018-03-26', '2018-03-26', 2, 'Kết thúc', 7),
(26, 'TamPhuocT3', '2018-03-31', '2018-04-13', 21, 'Kết thúc', 110),
(27, 'TamThanht4', '2018-03-31', '2018-03-31', 23, 'Đang thực hiện', 18),
(28, 'TamLoc T4', '2018-04-01', '2018-04-01', 8, 'Kết thúc', 7),
(29, 'SMO-T5-2018', '2018-05-01', '2018-05-01', 3, 'Kế hoạch', 6);

-- --------------------------------------------------------

--
-- Table structure for table `lencongviec`
--

CREATE TABLE `lencongviec` (
  `ID_DOTBD` int(11) NOT NULL,
  `ID_THIETBI` int(11) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL,
  `IS_SUGGESTED` tinyint(4) NOT NULL DEFAULT '0',
  `IS_SELECTED` tinyint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lencongviec`
--

INSERT INTO `lencongviec` (`ID_DOTBD`, `ID_THIETBI`, `MA_NOIDUNG`, `IS_SUGGESTED`, `IS_SELECTED`) VALUES
(23, 18, '121', 1, 1),
(23, 18, '122', 1, 1),
(23, 18, '123', 1, 1),
(23, 18, '124', 1, 1),
(23, 18, '125', 1, 1),
(23, 19, '541', 0, 1),
(23, 19, '542', 0, 1),
(23, 19, '543', 0, 1),
(23, 19, '544', 0, 0),
(23, 19, '545', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `ID_NHANVIEN` int(10) UNSIGNED NOT NULL,
  `MA_NHANVIEN` varchar(10) NOT NULL,
  `TEN_NHANVIEN` varchar(100) NOT NULL,
  `CHUC_VU` int(11) DEFAULT '11',
  `DIEN_THOAI` varchar(15) NOT NULL,
  `ID_DONVI` int(11) NOT NULL,
  `ID_DAI` int(11) DEFAULT NULL,
  `SMS_ALARM` tinyint(1) NOT NULL DEFAULT '0',
  `GHI_CHU` varchar(200) DEFAULT NULL,
  `USER_NAME` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`ID_NHANVIEN`, `MA_NHANVIEN`, `TEN_NHANVIEN`, `CHUC_VU`, `DIEN_THOAI`, `ID_DONVI`, `ID_DAI`, `SMS_ALARM`, `GHI_CHU`, `USER_NAME`) VALUES
(1, 'TKY004', 'Phan Thành Long ', 9, '0911017999 ', 4, 1, 1, '', 'longpt.qnm@vnpt.vn'),
(5, 'QNM002', 'OMC', 2, '0914136999', 1, NULL, 0, '', 'omc'),
(6, 'QNM000', 'Nguyễn Thành', 1, '0914136999', 1, NULL, 0, '', 'nguyenthanh'),
(7, 'QNM001', 'Nguyễn Đình Châu', 1, '0945226904', 2, NULL, 0, '', 'admin'),
(8, 'TT1001', 'Trần Như Hoàng', 4, '0913407000 ', 4, NULL, 0, '', 'hoangtn.qnm@vnpt.vn'),
(10, 'TKY002', 'Trần Ngọc Nam', 9, '0935637637', 4, NULL, 0, '', 'namtn.qnm@vnpt.vn'),
(11, 'NTH002', 'Nguyễn Văn Tiến', 9, '0914353474', 4, 3, 1, '', 'tiennv.qnm@vnpt.vn'),
(12, 'DBN002', 'Dương Văn Sẵn', 9, '0914020447', 6, 13, 1, '', 'sandv.qnm@vnpt.vn'),
(13, 'HAN002', 'Lê Duy Trung', 9, '0914273305', 6, 12, 1, '', 'trungld.qnm@vnpt.vn'),
(14, 'TT3001', 'Phạm Thị Phương Thảo', 4, '0914135555', 6, NULL, 0, '', 'thaoptp.qnm@vnpt.vn'),
(15, 'TT3002', 'Lê Trọng Hiệp', 5, '0914223905', 6, NULL, 0, '', 'hieplt.qnm@vnpt.vn'),
(18, 'DBN001', 'Lưu Văn Tùng', 7, '0914228111', 6, 13, 0, '', 'tunglv.qnm@vnpt.vn'),
(19, 'HAN001', 'Lê Văn Đạo', 7, '0914022269', 6, 12, 0, '', 'daolv.qnm@vnpt.vn'),
(20, 'TKY001', 'Lương Hồng Ân', 7, '0914146555', 4, 1, 0, '', 'anlh.qnm@vnpt.vn'),
(21, 'NTH001', 'Phan Như Lĩnh', 7, '0913480696', 4, 3, 0, '', 'linhpn.qnm@vnpt.vn'),
(23, 'TKY005', 'Nguyễn Đức Long', 9, '0914152444', 4, 1, 1, '', 'longnd.qnm@vnpt.vn'),
(24, 'TT3005', 'Trần Hà Phương', 10, '0945256555', 6, NULL, 0, 'Tạm khai thác', 'phuongth.qnm@vnpt.vn'),
(25, 'TT2001', 'Nguyễn Văn Bổn', 4, '0913480434', 5, NULL, 0, '', 'bonnv.qnm@vnpt.vn'),
(26, 'TT2002', 'Trần Đình Phúc', 5, '0914228027', 5, NULL, 0, '', 'phuctd.qnm@vnpt.vn'),
(27, 'TT4001', 'Huỳnh Đức Tiến', 4, '0945295252', 7, NULL, 0, '', 'tienhd.qnm@vnpt.vn'),
(28, 'TT4002', 'Nguyễn Thanh Nhàn', 5, '0914223772', 7, NULL, 0, '', 'nhannt.qnm@vnpt.vn'),
(29, 'TKY006', 'Huỳnh Thanh Tùng', 9, '0914136566', 4, 1, 1, '', 'tunght.qnm@vnpt.vn'),
(31, 'NTH004', 'Trương Công Xuất', 9, '0914152077', 4, 3, 1, '', 'xuattc.qnm@vnpt.vn'),
(32, 'NTH005', 'Hồ Bảo Phương', 9, '0914146786', 4, 3, 1, '', 'phuonghb.qnm@vnpt.vn'),
(33, 'NTH006', 'Phan Hoài Bảo', 9, '0913407060', 4, 3, 1, '', 'baoph.qnm@vnpt.vn'),
(35, 'NTH008', 'Võ Văn Lắm', 9, '0914285756 ', 4, 3, 1, '', 'lamvv.qnm@vnpt.vn'),
(36, 'PNH002', 'Nguyễn Đức An', 9, '0914941025', 4, 1, 1, '', 'annd.qnm@vnpt.vn'),
(37, 'PNH003', 'Nguyễn Việt Hùng', 9, '0914855549', 4, 1, 1, '', 'hungnv.qnm@vnpt.vn'),
(38, 'PNH004', 'Hồ Văn Quảng', 9, '0914035569', 4, 1, 1, '', 'quanghv.qnm@vnpt.vn'),
(40, 'BTM002', 'Triệu Viết Hòa', 9, '0949222464', 4, 4, 0, '', 'hoatv.qnm@vnpt.vn'),
(41, 'BTM003', 'Hồ Thái Sơn', 9, '0914781900', 4, 4, 1, '', 'sonht.qnm@vnpt.vn'),
(43, 'NTM002', 'Nguyễn Đăng Tâm', 9, '0915992717', 4, 4, 1, '', 'tamnd.qnm@vnpt.vn'),
(45, 'TPC002', 'Trần Ngọc Vũ', 9, '0942308080', 4, 4, 1, '', 'vutn.qnm@vnpt.vn'),
(46, 'TPC003', 'Nguyễn Quốc Toàn', 9, '0916301444', 4, 4, 1, '', 'toannq.qnm@vnpt.vn'),
(48, 'DXN002', 'Vũ Tiến Quang', 9, '0914228438', 5, 15, 1, '', 'quangvt.qnm@vnpt.vn'),
(49, 'DXN003', 'Trần Lợi', 9, '0948737118', 5, 15, 1, '', 'loit.qnm@vnpt.vn'),
(52, 'HDC002', 'Phạm Văn Trai', 9, '0914335777', 5, 17, 1, '', 'traipv.qnm@vnpt.vn'),
(56, 'PSN002', 'Phạm Xuân Hiếu', 9, '0914790019', 5, 17, 1, '', 'hieupx.qnm@vnpt.vn'),
(57, 'PSN003', 'Nguyễn Khắc Huy', 9, '0914333227', 5, 17, 1, '', 'huynk.qnm@vnpt.vn'),
(58, 'PSN004', 'Đặng Minh Tuấn', 9, '0948739456', 5, 17, 1, '', 'tuandm.qnm@vnpt.vn'),
(59, 'QSN001', 'Võ Văn Lộc', 7, '0913406369', 5, 16, 0, '', 'locvv.qnm@vnpt.vn'),
(60, 'QSN002', 'Vũ Đình Trọng', 9, '0915567447', 5, 16, 1, '', 'trongvd.qnm@vnpt.vn'),
(61, 'QSN003', 'Nguyễn Hữu Hùng', 9, '0914152559', 5, 16, 1, '', 'hungnh.qnm@vnpt.vn'),
(62, 'QSN004', 'Huỳnh Hồng Sương', 9, '0916103040', 5, 16, 1, '', 'suonghh.qnm@vnpt.vn'),
(64, 'TBH002', 'Trần Ngọc Nhân', 9, '0913190914', 5, 14, 1, '', 'nhantn.qnm@vnpt.vn'),
(65, 'TBH003', 'Phan Thanh Hòa', 9, '0914747117', 5, 14, 1, '', 'hoapt.qnm@vnpt.vn'),
(66, 'TBH004', 'Nguyễn Văn Phước', 9, ' 0914758914', 5, 14, 1, '', 'phuocnv.qnm@vnpt.vn'),
(67, 'TBH005', 'Phan Nhật Tiên', 9, '0914781800', 5, 14, 1, '', 'tienpn.qnm@vnpt.vn'),
(68, 'DB004', 'Hồ Viết Dũng', 9, '0914456758', 6, 13, 1, '', 'dunghv.qnm@vnpt.vn'),
(69, 'DBN005', 'Nguyễn Trọng Thương', 9, '0914781758', 6, 13, 1, '', 'thuongnt.qnm@vnpt.vn'),
(70, 'DBN006', 'Nguyễn Như Thành', 9, '0919438810', 6, 13, 1, '', 'thanhnn.qnm@vnpt.vn'),
(71, 'DBN007', 'Lê Văn Khánh', 9, '0913484709', 6, 13, 1, '', 'khanhlv.qnm@vnpt.vn'),
(74, 'DBN009', 'Trần Văn Hưng', 9, '0919433503', 6, 13, 1, '', 'hungtv.qnm@vnpt.vn'),
(75, 'DBN010', 'Nguyễn Văn Quốc', 9, '0914717645', 6, 13, 1, '', 'quocnv.qnm@vnpt.vn'),
(76, 'DBN011', 'Trần Duy Hải', 9, '0915515252', 6, 13, 1, '', 'haitd.qnm@vnpt.vn'),
(77, 'HAN003', 'Lê Thành Việt', 9, '0913419922', 6, 12, 1, '', 'vietlt.qnm@vnpt.vn'),
(78, 'HAN004', 'Lê Chí Cường', 9, '0917618748', 6, 12, 1, '', 'cuonglc.qnm@vnpt.vn'),
(80, 'DGG002', 'Đinh Công Thức', 9, '0914024488', 7, 20, 1, '', 'thucdc.qnm@vnpt.vn'),
(82, 'DLC002', 'Lê Trung Đình', 9, '0942010141', 7, 19, 1, '', 'dinhlt.qnm@vnpt.vn'),
(83, 'DLC003', 'Lê Đắc Sang', 9, '0914781818', 7, 19, 1, '', 'sangld.qnm@vnpt.vn'),
(86, 'NGG002', 'Nguyễn Bá Trọng', 9, '0943544433', 7, 20, 1, '', 'trongnb.qnm@vnpt.vn'),
(87, 'NGG003', 'Bhnước Anh Tuấn	', 9, '0917666007', 7, 20, 1, '', 'tuanba.qnm@vnpt.vn'),
(88, 'NGG004', 'Lê Văn Thương', 9, '0941379123', 7, 20, 1, '', 'thuonglv.qnm@vnpt.vn'),
(93, 'DHTT001', 'Nguyễn Công Chánh', 11, '0914040080', 1, NULL, 0, '', 'chanhnc.qnm@vnpt.vn'),
(94, 'DHTT002', 'Lê Công Cường', 11, '0913480588', 1, NULL, 0, '', 'cuonglc.qnm@vnpt.vn'),
(95, 'DHTT003', 'Phạm Viết Dũng', 11, ' 0915136014', 1, NULL, 0, '', 'dungpv.qnm@vnpt.vn'),
(96, 'DHTT004', 'Nguyễn Thu Hiền', 11, '0914049094', 1, NULL, 0, '', 'hiennt.qnm@vnpt.vn'),
(97, 'DHTT005', 'Trương Ngọc Phú', 11, '0914049044', 1, NULL, 0, '', 'phutn.qnm@vnpt.vn'),
(98, 'DHTT006', 'Trần Thanh Sơn', 11, '0914637959 ', 1, NULL, 0, '', 'sontt.qnm@vnpt.vn'),
(99, 'DHTT007', 'Phạm Thị Mỹ Sen', 11, '0914049059', 1, NULL, 0, '', 'senptm.qnm@vnpt.vn'),
(100, 'DHTT008', 'Dư Mạnh Thực', 11, '0914065888', 1, NULL, 0, '', 'thucdm.qnm@vnpt.vn'),
(101, 'DHTT009', 'Nguyễn Văn Thao', 11, '0943111168', 1, NULL, 0, '', 'thaonv.qnm@vnpt.vn'),
(102, 'DHTT010', 'Huỳnh Đạo Thiện', 7, '0917467555', 1, NULL, 0, '', 'thienhd.qnm@vnpt.vn'),
(103, 'DHTT011', 'Trương Duy Tuấn', 11, '0918973232', 1, NULL, 0, '', 'tuantd.qnm@vnpt.vn'),
(104, 'DHTT012', 'Huỳnh Ngọc Việt', 11, '0942007089', 1, NULL, 0, '', 'viethn.qnm@vnpt.vn'),
(105, 'PNH005', 'Lê Tấn Triều', 9, '0914947557', 4, 1, 1, '', 'trieult.qnm@vnpt.vn'),
(106, 'TKY007', 'Trần Tân Thiên', 9, ' 0949321125', 4, 1, 1, '', 'thientt.qnm@vnpt.vn'),
(107, '111', 'Ng Đi Ti Ci li', 7, '0911354345', 4, 3, 0, '', 'noname'),
(108, 'CNTT111', 'Nguyễn Đình Châu 1', 1, '0915365078', 2, NULL, 0, '', 'ndchau1.qnm@vnpt.vn'),
(110, 'CNTT0TEST', 'Tét văn Te', 1, '0911222333', 2, NULL, 0, '', 'testvante'),
(111, 'CNTT11123', 'Test ', 9, '0915151515', 1, NULL, 0, '', 'test11123'),
(112, 'ROOT', 'Tài khoản root', 1, '0945226904', 2, NULL, 0, '', 'root'),
(113, 'GDTT1', 'Tài khoản GDTT 1', 4, '0911 111 111', 4, NULL, 0, '', 'gdtt1'),
(117, 'GDTT4', 'Tài khoản GDTT 4', 4, '0914 444 444', 7, NULL, 0, '', 'gdtt4'),
(118, 'GDTT2', 'Tài khoản GDTT 2', 4, '0912 222 222', 5, NULL, 0, '', 'gdtt2'),
(119, 'td1-tky', 'Trưởng đài TKY-PN', 7, '0911 112 112', 4, 1, 0, '', 'td1tky'),
(120, 'td1nt', 'Trưởng đài Núi Thành', 7, '0911 113 113', 4, 3, 0, '', 'td1nt');

-- --------------------------------------------------------

--
-- Table structure for table `nhomtbi`
--

CREATE TABLE `nhomtbi` (
  `ID_NHOM` int(11) NOT NULL,
  `MA_NHOM` varchar(32) NOT NULL,
  `TEN_NHOM` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhomtbi`
--

INSERT INTO `nhomtbi` (`ID_NHOM`, `MA_NHOM`, `TEN_NHOM`) VALUES
(1, 'NGUON', 'Nhóm các thiết bị nguồn'),
(3, 'PTRO', 'Nhóm thiết bị phụ trợ'),
(4, 'MANG', 'Nhóm thiết bị về mạng'),
(5, 'VIENTHONG', 'Nhóm các thiết bị viễn thông'),
(6, 'TEST', 'Nhóm thiết bị test');

-- --------------------------------------------------------

--
-- Table structure for table `noidungbaotri`
--

CREATE TABLE `noidungbaotri` (
  `MA_NOIDUNG` varchar(32) NOT NULL,
  `ID_THIETBI` int(11) DEFAULT NULL,
  `NOIDUNG` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noidungbaotri`
--

INSERT INTO `noidungbaotri` (`MA_NOIDUNG`, `ID_THIETBI`, `NOIDUNG`) VALUES
('111', 1, 'Nội dung bảo dưỡng số 1 dành cho Ắc quy GS N200'),
('112', 1, 'Nội dung bảo dưỡng số 2 dành cho Ắc quy GS N200'),
('113', 1, 'Nội dung bảo dưỡng số 3 dành cho Ắc quy GS N200'),
('114', 1, 'Nội dung bảo dưỡng số 4 dành cho Ắc quy GS N200'),
('115', 1, 'Nội dung bảo dưỡng số 5 dành cho Ắc quy GS N200'),
('116', 1, '116'),
('117', 1, '117'),
('118', 1, '118'),
('119', 1, '119'),
('121', 6, 'Nội dung bảo dưỡng số 1 dành cho Máy nổ Samsung 10kW'),
('122', 6, 'Nội dung bảo dưỡng số 2 dành cho Máy nổ Samsung 10kW'),
('123', 6, 'Nội dung bảo dưỡng số 3 dành cho Máy nổ Samsung 10kW'),
('124', 6, 'Nội dung bảo dưỡng số 4 dành cho Máy nổ Samsung 10kW'),
('125', 6, 'Nội dung bảo dưỡng số 5 dành cho Máy nổ Samsung 10kW'),
('126', 6, 'Nội dung số 126'),
('131', 7, 'Nội dung bảo dưỡng số 1 dành cho Tủ rec Huawei'),
('132', 7, 'Nội dung bảo dưỡng số 2 dành cho Tủ rec Huawei'),
('133', 7, 'Nội dung bảo dưỡng số 3 dành cho Tủ rec Huawei'),
('134', 7, 'Nội dung bảo dưỡng số 4 dành cho Tủ rec Huawei'),
('135', 7, 'Nội dung bảo dưỡng số 5 dành cho Tủ rec Huawei'),
('141', 15, 'Nội dung bảo dưỡng số 1 dành cho Tủ nguồn DC ZTE'),
('142', 15, 'Nội dung bảo dưỡng số 2 dành cho Tủ nguồn DC ZTE'),
('143', 15, 'Nội dung bảo dưỡng số 3 dành cho Tủ nguồn DC ZTE'),
('144', 15, 'Nội dung bảo dưỡng số 4 dành cho Tủ nguồn DC ZTE'),
('145', 15, 'Nội dung bảo dưỡng số 5 dành cho Tủ nguồn DC ZTE'),
('1711', 17, 'Nội dung 1711 cho máy nổ'),
('1712', 17, 'Nội dung 1712 cho máy nổ'),
('2111', 21, '2111'),
('2112', 21, '2112'),
('2113', 21, 'Nội dung số 2113 nội dung đoạn test các thứ abc xyz nội dung test abc'),
('2114', 21, 'Nội dung số 2114 nội dung đoạn test các thứ abc xyz nội dung test abc Nội dung số 2114 nội dung đoạn test các thứ abc xyz nội dung test abc'),
('2311', 23, 'Nội dung 2311 cho test'),
('2312', 23, 'Nội dung 2312 cho test'),
('2313', 23, 'Nội dung 2313 cho test'),
('311', 3, 'Nội dung bảo dưỡng số 1 dành cho Điều hòa LG Inverter...'),
('312', 3, 'Nội dung bảo dưỡng số 2 dành cho Điều hòa LG Inverter...'),
('313', 3, 'Nội dung bảo dưỡng số 3 dành cho Điều hòa LG Inverter...'),
('314', 3, 'Nội dung bảo dưỡng số 4 dành cho Điều hòa LG Inverter...'),
('315', 3, 'Nội dung bảo dưỡng số 5 dành cho Điều hòa LG Inverter...'),
('316', 3, '316316131231231231'),
('321', 8, 'Nội dung bảo dưỡng số 1 dành cho Nhà trạm thông minh'),
('322', 8, 'Nội dung bảo dưỡng số 2 dành cho Nhà trạm thông minh'),
('323', 8, 'Nội dung bảo dưỡng số 3 dành cho Nhà trạm thông minh'),
('324', 8, 'Nội dung bảo dưỡng số 4 dành cho Nhà trạm thông minh'),
('325', 8, 'Nội dung bảo dưỡng số 5 dành cho Nhà trạm thông minh'),
('411', 2, 'Nội dung bảo dưỡng số 1 dành cho Cisco ASR 1013 Router'),
('4112', 2, '4112'),
('412', 2, 'Nội dung bảo dưỡng số 2 dành cho Cisco ASR 1013 Router'),
('413', 2, 'Nội dung bảo dưỡng số 3 dành cho Cisco ASR 1013 Router'),
('414', 2, 'Nội dung bảo dưỡng số 4 dành cho Cisco ASR 1013 Router'),
('415', 2, 'Nội dung bảo dưỡng số 5 dành cho Cisco ASR 1013 Router'),
('416', 2, '416'),
('417', 2, '417'),
('421', 4, 'Nội dung bảo dưỡng số 1 dành cho Switch Cisco 24 port'),
('422', 4, 'Nội dung bảo dưỡng số 2 dành cho Switch Cisco 24 port'),
('423', 4, 'Nội dung bảo dưỡng số 3 dành cho Switch Cisco 24 port'),
('424', 4, 'Nội dung bảo dưỡng số 4 dành cho Switch Cisco 24 port'),
('425', 4, 'Nội dung bảo dưỡng số 5 dành cho Switch Cisco 24 port'),
('431', 5, 'Nội dung bảo dưỡng số 1 dành cho Switch Cisco 48 port'),
('432', 5, 'Nội dung bảo dưỡng số 2 dành cho Switch Cisco 48 port'),
('433', 5, 'Nội dung bảo dưỡng số 3 dành cho Switch Cisco 48 port'),
('434', 5, 'Nội dung bảo dưỡng số 4 dành cho Switch Cisco 48 port'),
('435', 5, 'Nội dung bảo dưỡng số 5 dành cho Switch Cisco 48 port'),
('511', 9, 'Nội dung bảo dưỡng số 1 dành cho Tủ BTS Huawei'),
('512', 9, 'Nội dung bảo dưỡng số 2 dành cho Tủ BTS Huawei'),
('513', 9, 'Nội dung bảo dưỡng số 3 dành cho Tủ BTS Huawei'),
('514', 9, 'Nội dung bảo dưỡng số 4 dành cho Tủ BTS Huawei'),
('515', 9, 'Nội dung bảo dưỡng số 5 dành cho Tủ BTS Huawei'),
('516', 9, 'Số 6'),
('521', 10, 'Nội dung bảo dưỡng số 1 dành cho Ống dẫn sóng 2G'),
('522', 10, 'Nội dung bảo dưỡng số 2 dành cho Ống dẫn sóng 2G'),
('523', 10, 'Nội dung bảo dưỡng số 3 dành cho Ống dẫn sóng 2G'),
('524', 10, 'Nội dung bảo dưỡng số 4 dành cho Ống dẫn sóng 2G'),
('525', 10, 'Nội dung bảo dưỡng số 5 dành cho Ống dẫn sóng 2G'),
('531', 11, 'Nội dung bảo dưỡng số 1 dành cho Ống dẫn sóng 3G'),
('532', 11, 'Nội dung bảo dưỡng số 2 dành cho Ống dẫn sóng 3G'),
('533', 11, 'Nội dung bảo dưỡng số 3 dành cho Ống dẫn sóng 3G'),
('534', 11, 'Nội dung bảo dưỡng số 4 dành cho Ống dẫn sóng 3G'),
('535', 11, 'Nội dung bảo dưỡng số 5 dành cho Ống dẫn sóng 3G'),
('541', 12, 'Nội dung bảo dưỡng số 1 dành cho BTS Huawei 3G'),
('542', 12, 'Nội dung bảo dưỡng số 2 dành cho BTS Huawei 3G'),
('543', 12, 'Nội dung bảo dưỡng số 3 dành cho BTS Huawei 3G'),
('544', 12, 'Nội dung bảo dưỡng số 4 dành cho BTS Huawei 3G'),
('545', 12, 'Nội dung bảo dưỡng số 5 dành cho BTS Huawei 3G'),
('551', 14, 'Nội dung bảo dưỡng số 1 dành cho BTS ZTE BS8800 2G'),
('552', 14, 'Nội dung bảo dưỡng số 2 dành cho BTS ZTE BS8800 2G'),
('553', 14, 'Nội dung bảo dưỡng số 3 dành cho BTS ZTE BS8800 2G'),
('554', 14, 'Nội dung bảo dưỡng số 4 dành cho BTS ZTE BS8800 2G'),
('555', 14, 'Nội dung bảo dưỡng số 5 dành cho BTS ZTE BS8800 2G');

-- --------------------------------------------------------

--
-- Table structure for table `noidungcongviec`
--

CREATE TABLE `noidungcongviec` (
  `ID_DOTBD` int(11) NOT NULL,
  `ID_THIETBI` int(11) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL,
  `GHICHU` text,
  `TRANGTHAI` varchar(32) DEFAULT NULL,
  `ID_NHANVIEN` int(10) UNSIGNED NOT NULL,
  `KETQUA` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noidungcongviec`
--

INSERT INTO `noidungcongviec` (`ID_DOTBD`, `ID_THIETBI`, `MA_NOIDUNG`, `GHICHU`, `TRANGTHAI`, `ID_NHANVIEN`, `KETQUA`) VALUES
(10, 5, '111', '', 'Hoàn thành', 7, 'Đạt'),
(10, 5, '112', '', 'Hoàn thành', 7, 'Đạt'),
(10, 5, '113', '', 'Hoàn thành', 7, 'Đạt'),
(10, 6, '111', '', 'Hoàn thành', 6, 'Đạt'),
(10, 6, '112', '', 'Hoàn thành', 6, 'Đạt'),
(10, 6, '113', NULL, 'Chưa hoàn thành', 41, 'Chưa đạt'),
(10, 7, '411', NULL, 'Chưa hoàn thành', 41, 'Chưa đạt'),
(10, 7, '412', '', 'Hoàn thành', 6, 'Đạt'),
(10, 7, '413', '', 'Hoàn thành', 6, 'Đạt'),
(10, 7, '414', '', 'Hoàn thành', 7, 'Đạt'),
(10, 7, '415', NULL, 'Chưa hoàn thành', 8, 'Chưa đạt'),
(10, 9, '411', NULL, 'Chưa hoàn thành', 8, 'Chưa đạt'),
(10, 9, '412', NULL, 'Chưa hoàn thành', 8, 'Chưa đạt'),
(10, 9, '413', NULL, 'Chưa hoàn thành', 8, 'Chưa đạt'),
(10, 9, '414', NULL, 'Chưa hoàn thành', 8, 'Chưa đạt'),
(10, 9, '416', NULL, 'Chưa hoàn thành', 103, 'Chưa đạt'),
(10, 9, '417', NULL, 'Chưa hoàn thành', 103, 'Chưa đạt'),
(16, 10, '411', NULL, 'Kế hoạch', 7, NULL),
(16, 10, '412', NULL, 'Kế hoạch', 6, NULL),
(16, 10, '413', NULL, 'Kế hoạch', 6, NULL),
(16, 10, '414', NULL, 'Kế hoạch', 19, NULL),
(16, 10, '415', NULL, 'Kế hoạch', 19, NULL),
(16, 21, '521', NULL, 'Kế hoạch', 10, NULL),
(16, 21, '522', NULL, 'Kế hoạch', 8, NULL),
(16, 21, '523', NULL, 'Kế hoạch', 8, NULL),
(16, 21, '524', NULL, 'Kế hoạch', 8, NULL),
(16, 21, '525', NULL, 'Kế hoạch', 8, NULL),
(21, 2, '411', '^^', 'Hoàn thành', 7, 'Đạt'),
(21, 2, '412', '', 'Hoàn thành', 7, 'Đạt'),
(21, 2, '413', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 2, '414', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 2, '415', 'good :))', 'Hoàn thành', 7, 'Đạt'),
(21, 3, '411', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 3, '412', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 3, '413', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 3, '414', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 3, '415', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 4, '311', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 4, '312', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 4, '313', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 4, '314', NULL, 'Hoàn thành', 7, 'Đạt'),
(21, 4, '315', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 7, '4112', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 7, '416', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 7, '417', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 21, '521', NULL, 'Chưa hoàn thành', 14, 'Chưa đạt'),
(26, 21, '522', NULL, 'Chưa hoàn thành', 14, 'Chưa đạt'),
(26, 21, '523', NULL, 'Chưa hoàn thành', 14, 'Chưa đạt'),
(26, 21, '524', NULL, 'Chưa hoàn thành', 14, 'Chưa đạt'),
(26, 21, '525', NULL, 'Chưa hoàn thành', 14, 'Chưa đạt'),
(26, 29, '112', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 31, '121', NULL, 'Hoàn thành', 7, 'Đạt'),
(26, 31, '122', NULL, 'Hoàn thành', 107, 'Đạt'),
(26, 31, '123', NULL, 'Hoàn thành', 107, 'Đạt'),
(26, 31, '124', NULL, 'Hoàn thành', 107, 'Đạt'),
(26, 31, '125', NULL, 'Hoàn thành', 107, 'Đạt'),
(27, 23, '141', 'Hello', 'Hoàn thành', 8, 'Chưa đạt'),
(27, 23, '142', 'abcdef', 'Hoàn thành', 8, 'Chưa đạt'),
(27, 23, '143', NULL, 'Chưa hoàn thành', 83, 'Chưa đạt'),
(27, 23, '144', NULL, 'Chưa hoàn thành', 83, 'Chưa đạt'),
(27, 23, '145', NULL, 'Chưa hoàn thành', 83, 'Chưa đạt'),
(28, 11, '111', NULL, 'Hoàn thành', 7, 'Đạt'),
(28, 11, '112', NULL, 'Hoàn thành', 7, 'Đạt'),
(28, 11, '113', 'điện áp ổn định, cần châm dầu....', 'Hoàn thành', 18, 'Đạt'),
(29, 5, '111', NULL, 'Kế hoạch', 70, NULL),
(29, 5, '112', NULL, 'Kế hoạch', 70, NULL),
(29, 5, '113', NULL, 'Kế hoạch', 70, NULL),
(29, 6, '111', NULL, 'Kế hoạch', 70, NULL),
(29, 6, '112', NULL, 'Kế hoạch', 70, NULL),
(29, 6, '113', NULL, 'Kế hoạch', 70, NULL),
(29, 9, '411', NULL, 'Kế hoạch', 7, NULL),
(29, 9, '412', NULL, 'Kế hoạch', 7, NULL),
(29, 9, '413', NULL, 'Kế hoạch', 7, NULL),
(29, 9, '414', NULL, 'Kế hoạch', 7, NULL),
(29, 9, '415', NULL, 'Kế hoạch', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(15) NOT NULL,
  `decription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `decription`) VALUES
(1, 'Administrators', 'Can do any thing in web app'),
(2, 'vtt', 'Can add or update some devices'),
(3, 'qlytrungtam', 'Quản lý trung tâm'),
(4, 'qlydai', 'Quản lý đài'),
(5, 'qlytram', 'Quản lý trạm'),
(6, 'nhanvien', 'Nhân viên');

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `ID_THIETBI` int(11) NOT NULL,
  `MA_THIETBI` varchar(32) NOT NULL,
  `TEN_THIETBI` varchar(255) NOT NULL,
  `ID_NHOMTB` int(11) DEFAULT NULL,
  `HANGSX` varchar(255) DEFAULT NULL,
  `THONGSOKT` text NOT NULL,
  `PHUKIEN` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thietbi`
--

INSERT INTO `thietbi` (`ID_THIETBI`, `MA_THIETBI`, `TEN_THIETBI`, `ID_NHOMTB`, `HANGSX`, `THONGSOKT`, `PHUKIEN`) VALUES
(1, 'ACQ GS N200', 'Ắc quy GS N200', 1, 'GS', 'Nguồn abc\r\nncasndans', ''),
(2, 'CISCO1013', 'Cisco ASR 1013 Router', 4, 'Cisco', 'Router abc xyzzzz', 'Cáp, dây nguồn'),
(3, 'DH LG', 'Điều hòa LG Inverter...', 3, 'LG', 'Điều hòa abc xyzznsdfkasdm\r\nBBANANANANAN\r\nÂNNNAMMA', 'Nguồn dfasdfnsndn\r\nNÂNNDB\r\nABADSNDNSA'),
(4, 'CISCOSWT24', 'Switch Cisco 24 port', 4, 'Cisco', 'Switch 24 port', 'Khoong...'),
(5, 'CISCOSWT48', 'Switch Cisco 48 port', 4, 'Cisco', 'Test', ''),
(6, 'SAMSUNGNO', 'Máy nổ Samsung 10kW', 1, 'Samsung', 'Công suất 10kWh', ''),
(7, 'HUAWEIREC', 'Tủ rec Huawei', 1, 'Huawei', 'Thông số kỹ thuật 1\r\nThông số kỹ thuật 2\r\nThông số kỹ thuật 3\r\nThông số kỹ thuật 4', 'Phụ kiện 1\r\nPhụ kiện 2\r\nPhụ kiện 3'),
(8, 'VNPT_SPSM', 'Nhà trạm thông minh', 3, 'CNTT-VNPT', 'Thông số kỹ thuật 1\r\nThông số kỹ thuật 2\r\nThông số kỹ thuật 3\r\nThông số kỹ thuật 4\r\n', 'phụ kiện n'),
(9, 'HUAWEIBTS', 'Tủ BTS Huawei', 5, 'Huawei', 'Tủ BTS test', ''),
(10, 'Feeder2G', 'Ống dẫn sóng 2G', 5, 'xxx', '240 m Feeder 7/8\" 2G', '72 bộ clamp kẹp cáp feeder 7/8\" (kẹp 3)'),
(11, 'Feeder3G', 'Ống dẫn sóng 3G', 5, 'xxx', '240 m Feeder 7/8\" 2G', 'bộ clamp kẹp cáp Feeder 7/8\" (kẹp 3)'),
(12, 'BTS3900', 'BTS Huawei 3G', 5, 'Huawei', 'Test', ''),
(14, 'BTS BS8800', 'BTS ZTE BS8800 2G', 5, 'ZTE', 'Test', ''),
(15, 'DC ZXD3200', 'Tủ nguồn DC ZTE', 1, 'ZTE', 'Tủ nguồn ZTE', ''),
(16, 'CISCOSWT481', 'Switch Cisco 48 port', 4, 'Cisco', 'téttss', ''),
(17, 'SAMSUNGNO100KW', 'Máy nổ Samsung 100kW', 1, 'Samsung', 'KHHHjsdfkasdjkhakjshdk\r\njdkfashf', ''),
(18, 'CISCOSWT24xx', 'Switch Cisco 24 port xx', 4, 'Cisco', '24 port xxxxxx', ''),
(19, 'Cisco', 'Switch Cisco 48 port', NULL, 'Cisco', 'AAAAA', ''),
(20, 'SAMSUNGNO100KW', 'Máy nổ Samsung 100kW', 1, 'Samsung', 'Tesst\r\nTesst\r\nTesst\r\nTesst\r\nTesst\r\n', 'Tesst\r\nTesst\r\nTesst\r\nTesst\r\nTesst\r\n'),
(21, 'VNPT_SPSMv2', 'Nhà trạm thông minh v2', 3, 'CNTT-VNPT', 'ABBCBCHB<ASBC<NBAMNCBKABSCBKASBV', ''),
(22, 'HUAWEIREC222', 'Tủ rec Huawei', 5, 'Huawei', 'Thông số kỹ thuật cannot be blank.\r\nPhụ kiện \r\nThông số kỹ thuật cannot be blank.\r\nPhụ kiện \r\nThông số kỹ thuật cannot be blank.\r\nPhụ kiện \r\n', ''),
(23, 'TESTDV', 'Test device', 6, 'TESTTTT', 'TEST', 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `thietbitram`
--

CREATE TABLE `thietbitram` (
  `ID_THIETBI` int(11) NOT NULL,
  `ID_LOAITB` int(11) DEFAULT NULL,
  `ID_TRAM` int(11) DEFAULT NULL,
  `SERIAL_MAC` varchar(255) NOT NULL,
  `NGAYSX` date NOT NULL,
  `NGAYSD` date NOT NULL,
  `LANBD` int(11) DEFAULT NULL,
  `LANBAODUONGTRUOC` date DEFAULT NULL,
  `LANBAODUONGTIEP` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thietbitram`
--

INSERT INTO `thietbitram` (`ID_THIETBI`, `ID_LOAITB`, `ID_TRAM`, `SERIAL_MAC`, `NGAYSX`, `NGAYSD`, `LANBD`, `LANBAODUONGTRUOC`, `LANBAODUONGTIEP`) VALUES
(2, 2, 1, '1231ad12121', '2017-05-10', '2017-10-01', 5, '2018-03-23', '2018-10-01'),
(3, 2, 2, '312312efs', '2017-05-10', '2017-10-10', 5, '2018-03-23', '2018-10-10'),
(4, 3, 2, '24451211NBBBB', '2017-05-10', '2017-10-01', 3, '2018-03-23', NULL),
(5, 1, 3, '1231212113213', '2017-05-10', '2017-10-01', 5, '2018-03-20', '2018-10-01'),
(6, 1, 3, '12312124564', '2017-05-10', '2017-10-10', 5, '2018-03-20', '2018-10-10'),
(7, 2, 21, '1231212456411', '2017-05-10', '2017-10-10', 6, '2018-04-20', '2018-10-10'),
(8, 1, 4, '12312124564123', '2018-01-01', '2018-01-01', 4, '2018-01-10', '2018-07-01'),
(9, 2, 3, '123weqwe123', '2018-01-01', '2018-01-01', 3, '2018-01-10', '2018-04-01'),
(10, 2, 1, '12312eqwe', '2018-01-01', '2018-01-01', 3, '2018-01-07', '2018-04-01'),
(11, 1, 8, '1112531253512351', '2018-01-01', '2018-01-01', 5, '2018-03-27', '2019-01-01'),
(18, 6, 6, '13213264646', '2018-01-01', '2018-01-10', 3, '2018-01-30', '2018-04-10'),
(19, 12, 6, '11111', '2018-01-01', '2018-01-10', 1, '2018-01-30', NULL),
(21, 10, 21, '132465465465', '2017-03-01', '2017-04-01', 7, NULL, '2018-04-01'),
(22, 10, 22, '1231231', '2017-03-01', '2017-04-01', 7, NULL, '2018-04-01'),
(23, 15, 23, '135525411311231', '2017-03-14', '2017-07-19', NULL, '2018-03-01', NULL),
(25, 11, 25, '1234654', '2018-01-05', '2018-02-01', 4, '2018-03-22', '2018-05-01'),
(26, 11, 4, '1355254113444', '2018-02-01', '2018-02-01', 3, '2018-03-01', '2018-04-01'),
(28, 1, 22, '1123123', '2018-02-01', '2018-02-01', 3, '2018-02-16', '2018-04-01'),
(29, 1, 21, '11231312315423534534', '2018-03-14', '2018-03-15', 3, '2018-04-20', '2018-05-15'),
(30, 3, 21, 'ABCHRU5723H2384', '2017-12-20', '2018-02-21', NULL, '2018-03-01', NULL),
(31, 6, 21, 'HAH443HH3H3HJ3J3J3', '2018-01-01', '2018-01-30', 4, '2018-04-20', '2018-07-30'),
(34, 16, 3, '12313edaedqweqweqweq', '2018-01-01', '2018-03-01', NULL, '2018-04-15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tramvt`
--

CREATE TABLE `tramvt` (
  `ID_TRAM` int(11) NOT NULL,
  `MA_TRAM` varchar(32) NOT NULL,
  `DIADIEM` varchar(255) DEFAULT NULL,
  `KINH_DO` float DEFAULT NULL,
  `VI_DO` float DEFAULT NULL,
  `ID_DAI` int(11) DEFAULT NULL,
  `ID_NHANVIEN` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tramvt`
--

INSERT INTO `tramvt` (`ID_TRAM`, `MA_TRAM`, `DIADIEM`, `KINH_DO`, `VI_DO`, `ID_DAI`, `ID_NHANVIEN`) VALUES
(1, 'TKY-001', 'Tam Kỳ', NULL, NULL, 1, 6),
(2, 'NT-001', 'Núi Thành', NULL, NULL, 3, 5),
(3, 'SMO', 'Suối Mơ - Đại Lộc - Quảng Nam', NULL, NULL, 19, 83),
(4, 'AN-HOA_QNM', 'An Hòa, Núi Thành', NULL, NULL, 3, 23),
(5, 'TKY-002', 'TKY test', NULL, NULL, 1, 5),
(6, 'NT000', 'NT test', NULL, NULL, 3, 7),
(8, 'Tam-Loc_QNM', 'Tam Lộc - Phú Ninh', NULL, NULL, 1, 105),
(13, 'Tam-Thang_QNM', 'Tam Thăng - Tam Kỳ', NULL, NULL, 1, 37),
(15, 'Tam-Phu_QNM', 'Tam Phú - Tam Kỳ', NULL, NULL, 1, 1),
(18, 'BDVHX-Tam-An_QNM', 'Tam An - Phú Ninh', NULL, NULL, 1, 105),
(20, 'Thon8-Tam-Loc_QNM', 'Thôn 8 Tam lộc - Phú Ninh', NULL, NULL, 1, 105),
(21, 'VHX-Tam-Phuoc_QNM', 'Tam Phước - Phú Ninh', NULL, NULL, 1, 105),
(22, 'BT-Tam-Thanh_QNM', 'Bãi Tắm Tam Thanh - Tam Kỳ', NULL, NULL, 1, 37),
(23, 'New-Tam-Thanh_QNM', 'BĐ Tam Thanh (New) - Tam Kỳ', NULL, NULL, 1, 37),
(25, 'NODEBO_THON-PHU-PHONG-AN-PHU_QNM', 'Trạm Phú Phong, An Phú (3G) - Tam Kỳ', NULL, NULL, 1, 1),
(27, 'Tam-Phu4_QNM', 'Tam Phú 4 - Tam Kỳ', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dist/img/default_picture.png',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `access_token`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'IE0xJNokPy6bTDIXnLWadMvvCneUAto_', 'uGB7E0DTPhSfyQpVaVaGcTuI7umlteNl', '$2y$13$0z3c9DRdl1xCAT.5qHWL.eBmhXWp9pbiivdgMwRwP4agmQU4FzMpC', NULL, 'admin@vnpt.vn', 'dist/img/1_ava.jpg', 10, 1506495817, 1523868939),
(2, 'noname', 'DAM4bdWzv8p8VTtreMYizS9qOir3TYro', '', '$2y$13$PW7OY5Bn6V0gZWCCS6WzleqO92L0cQT.0/oaYfzB7YNy6v6tOyey6', NULL, 'noname@gmail.com', 'dist/img/2_ava.jpg', 10, 1506498107, 1523868939),
(3, 'dinhchau2603', 'VxbOn48HqdzmzxGjzHzCsHxW_qxkD4l8', 'JJEJ8_4qxauIvqy8xMHYUf8swwCKpXOb', '$2y$13$IeUCU8CxXrfFguAeLwRxUe1aVXYsbhuKoydUX2lbhtcahWT0NDfui', NULL, 'dinhchau2603@gmail.com', 'dist/img/default_picture.png', 10, 1506498107, 1523868939),
(4, 'user02', '8-BKSr0a3CvXbcWXHWFCUyhSupXS02kH', 'Cj9STRuuy1idcdTTaq4eBrNQGsGuN1jM', '$2y$13$vhThpvJJZqHtTZNZVBzjueZVkHru8Mp21iWPhjQ.6MLdyBPipXskW', NULL, 'user02@gmail.com', 'dist/img/default_picture.png', 10, 1507177087, 1523868939),
(5, 'demo', 'AWUISzVD6pfPxMMxKaLI1YGVk9_KQNQ0', 'wx8O7XjCqVnKz_rSwktSLNp0uweKOTiF', '$2y$13$5TmXJdAnrtRREZxNSASJsO08Q.TjmHFU3ecq3n7AThLehwEtZANiC', NULL, 'demo12345@gmail.com', 'dist/img/default_picture.png', 10, 1507521569, 1523868939),
(11, 'longpt.qnm@vnpt.vn', '_fzgKfmGKHGo5IdmTEQuKuM7JndKkaSg', 'M6R0i8bgguLf4_LQCLTt9JvzFucQRX31', '$2y$13$0GKmmr.fjfoH4HJPIdiQbO20rSBjH5atl5MnTAzhVu16YCkdLUecK', NULL, 'longpt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341426, 1523868939),
(12, 'omc', '9MnTrvM_ZFJYWNvJ_2aHszbf9qpr-yS_', 'UCiLlIDEzpiIZz6kNWKpTuKfT_R1ZEEu', '$2y$13$MeSisz2PsNd1YC5qnyQn/uXj6r21GU848qxq9KKcnt2kRKSx4u9Gu', NULL, 'omc', 'dist/img/default_picture.png', 10, 1514341426, 1523868939),
(13, 'nguyenthanh', 'yAoSfefqpzc_unlJCcoS0IN1gKTpy0nA', 'cruH-iObwNuTy1CmLdHdtKFLmKSW38Ts', '$2y$13$xP0p3noXmnsdDcv6JklQFeVdnDar4czpZtwc8yy7P7MLRdHS41d8q', NULL, 'nguyenthanh', 'dist/img/default_picture.png', 10, 1514341427, 1523868939),
(15, 'hoangtn.qnm@vnpt.vn', 'hc6TS3erUIpB2L185gYukUCzboRuPKf2', '-k8nsjAx7LYONSAoTXA8Li0rgIilCHYU', '$2y$13$MeRr6sAMkiUdlOyYhFvqPuL.EjUKHHcNnC8DRPwyTrTAqgkKHQCGa', NULL, 'hoangtn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341789, 1523868939),
(16, 'namtn.qnm@vnpt.vn', 'flO3w6QYkvska4H_HrbmcBycayXbNHZt', 'XFjjD3K74S8e5knKUTGU3NQG_te-SGzd', '$2y$13$FsyipprAN.beZ2u9QzsY5.6CrOTBPpTBVBwwCsIEGOfioyS16q9OC', NULL, 'namtn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341789, 1523868939),
(17, 'tiennv.qnm@vnpt.vn', 'U6sprjoLxstwKcanq7eXimqxmDbR2UN-', 'X4Zpo1YezUhHI8CmyqppK-W0JvZe222m', '$2y$13$gUjvyss0OwA.DIYszwFw0.xJ4vwJti7HhUQohviJtSC1jM3RZFm4e', NULL, 'tiennv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341790, 1523868939),
(18, 'sandv.qnm@vnpt.vn', 'ib0HrGMaP8C5sXc7uDPE57MxiWdSkqWg', '9KE0gj-N9E7TDZHdX4QbqVpNufgjf3tk', '$2y$13$uhW199F4yIhDoyBKU0BoS.5Kia8QoD7iuKRqMXKqvnoS7Vez.g78G', NULL, 'sandv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341790, 1523868939),
(19, 'trungld.qnm@vnpt.vn', 'i0d-AGG_6q1Ne6Blr-JlEuTPOsyRaJ31', 'ezifPUIvpMcrkFPsu21oVR0wXSc4fX1d', '$2y$13$kJ18/Z9msAkp06iBdU3mmOFcYXfqHcOKAokXaNnoKY1o.2fyBKdd6', NULL, 'trungld.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341790, 1523868939),
(20, 'thaoptp.qnm@vnpt.vn', 'm65T5PQEUDVZ7qvkh9WtYogAxQPIbmWP', 'kILuPIcBRXt4n2lDJjKQkinNEZZ1Iyp7', '$2y$13$lqW2zjz7yNB2HEwdrWlEJee2Kt4HWzWQXT5l7cbTFF.QXtoIAr/UW', NULL, 'thaoptp.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341791, 1523868939),
(21, 'hieplt.qnm@vnpt.vn', 'U_fuCLdWN-5DtfW6Ob1dJPZfVLXNCVuB', 'zvPslG3zeNXWk95Ir9-kSpAkX_rcR9yN', '$2y$13$qwuJe4V..rT/BPu6AxREdOpJxIe4.jis9yfMb4l.qpbejGUCccJJi', NULL, 'hieplt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341791, 1523868939),
(22, 'tunglv.qnm@vnpt.vn', '_9QhLP5BGInnFl9aW1fZZBmmtsnSuKTz', 'nyiR6KWmEOTJHDfKKQM2l26PW7NyqJTp', '$2y$13$f1tuD4RbZFrfPhSQtdFBIO8B/23zoaeTC/klMf32j6qymyAZD92ee', NULL, 'tunglv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341792, 1523868939),
(23, 'daolv.qnm@vnpt.vn', 'DP6z5XfuFus13-1W_23aoba5FO1pgC82', 'Q4e_Rzt-bFNJrue7ET-BHB2arnNGxmeu', '$2y$13$0js85GPCez4G4qoxOh.kWOQjWd9BLmnfL.tGsQh4IkZOKh0I5Zkhy', NULL, 'daolv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341792, 1523868939),
(25, 'anlh.qnm@vnpt.vn', 'PlIFAJnp2A6E_JYSEs7eWQPXui5wD0ky', 'Q2qYKRX3iBQFY2q9wgG40M5fzeCsLcQ8', '$2y$13$a2a0U3NlONbveX7tVsKZhex8BANE62.jxRDkMD1O9YJAS62Dsl3je', NULL, 'anlh.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341869, 1523868939),
(26, 'linhpn.qnm@vnpt.vn', 'MTUz3iWg6LsS3PdxdqgX61o9HmXabT6Z', 'mDaK7osnU0PMVL6-zn0RhPVKDYDJbDok', '$2y$13$gDISLeBPUQ/.hrEZLsN/ROYTKdsZtizxAw02ynBcr2n3bPmerKBja', NULL, 'linhpn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341870, 1523868939),
(27, 'longnd.qnm@vnpt.vn', 'N0bO2MR5A7_oH2mKXjzVG17bYKSg1Rkj', '0ttkx22BKmIFqPKYxHxbXW3mkt5-5pHa', '$2y$13$s1GPD6ynfNQMxg7C8f0rY.uRpaYX.iGnWseS9RzrYSXs6tOG7SCEu', NULL, 'longnd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341870, 1523868939),
(28, 'phuongth.qnm@vnpt.vn', 'EHopTl9ED4H46lYvSgXnC9Wq-r14ySJJ', 'pH89SIfK3zmPvyNjSEHDmuY6KTNGpS0d', '$2y$13$nv2bfrrEek8.1Ha5AVL4X.Wqr/XfQvja4ElmmoolCws4XfzWjiUqG', NULL, 'phuongth.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341871, 1523868940),
(29, 'bonnv.qnm@vnpt.vn', 'GvQtnDgTnTL18wSreTbRN2BLvEwZmorO', 'q7ExVLsFQI6R6ErMbjL2ayopbOeV9o9M', '$2y$13$ySeEuMtI8Uwhs/40zgq.he7fuIag2yCX62PoDiLmW60oNtew0AMPW', NULL, 'bonnv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341871, 1523868940),
(30, 'phuctd.qnm@vnpt.vn', 'o1mJ4K_MKPNNvnjCYINaOC1fiyu8X7R6', 'HBV-Xh7n5PfXVSSsn0ssbgqxyPVH23Os', '$2y$13$qERh//6hsDACCyiz7EeOculAmVD13PeiFK/BUe3hP6V.I/iEA7XrW', NULL, 'phuctd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341872, 1523868940),
(31, 'tienhd.qnm@vnpt.vn', 'cqdUPTCtvEEZMc4G9WMCbUw_nqkQ0jNR', 'hvoU4DdZXvOsZUrDiuXh_h0M4wMzVwv0', '$2y$13$7vDhMDTAy/zsiudQkbiNCOnI6LrxbVyU2qupRp/hmTKFMe7S4fhO6', NULL, 'tienhd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341872, 1523868940),
(32, 'nhannt.qnm@vnpt.vn', 'BVJlGaU6N0PASWBqJFjpi4dHxXE3QXmt', '2ohcOgxoOUXEW8HaEMDYJN6kqFxMAtq2', '$2y$13$T9KyP7TZnUnXgHSteiWVKOO5csO4u808bTsYFLO6LRUmt6apEqBW2', NULL, 'nhannt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341873, 1523868940),
(33, 'tunght.qnm@vnpt.vn', 'teCDULbBHlw9pUm0gI7CeFIKHVwCrJiC', 'CPGbdbXEPcAQUvK0m1n-jsrBnkPLIeFE', '$2y$13$ByCldGePSFkKXhkyFaooseBK9CG5kYZqf63BNAYysqrtxk0fncrRi', NULL, 'tunght.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341873, 1523868940),
(34, 'xuattc.qnm@vnpt.vn', 'NZUXORP0HjdsKxeA01kuzVSczWTPtk_i', 'tYwfrS_HHCaSHb25uE1w-DMrLmKFFNMF', '$2y$13$bCAyPFuhI07IKS9.nGFnT..xl/PQPZp4a7yJlSaJY93udQ988/PuS', NULL, 'xuattc.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341873, 1523868940),
(35, 'phuonghb.qnm@vnpt.vn', 'CyE5hDRpAzqYpkvkq5E93GlmkGMk4Wjj', '_3jcSPG1JckdiAwsbLYZjZUMd1X4KMtC', '$2y$13$S.b7YP3O4t60ns2B0TFnHurglTk43mVSDIb0vegHN9JEd9pQA1LJa', NULL, 'phuonghb.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341874, 1523868940),
(36, 'baoph.qnm@vnpt.vn', '-9rwty9tPqgZ_t-KcGfC-mYKd6JpUS1K', 'smRt0aT0iZojx53dblUFztH-hARbvp_J', '$2y$13$kij5AFdujbwtjVSMVxDm..JVlHM14y2XzZT3ehxXj5KdxfQRmROLq', NULL, 'baoph.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341874, 1523868940),
(37, 'lamvv.qnm@vnpt.vn', 'xorneF3-xFSBIRICwqiweqtDIEP-voza', 'WrCAUD2kHtcH0a0PQsju3PaOww9R9fTi', '$2y$13$RVgGFj6E/EQHX4RDBZ5UeOikNVl9eNRwfLZ47B/r3ASvI3u8NMdtq', NULL, 'lamvv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341875, 1523868940),
(38, 'annd.qnm@vnpt.vn', 'dhVWCROWUOSWOUzEMYujsWrSXeZ03iv4', 'krMkP9C03EMt8aUCtvzHE69xD-C1gQ3i', '$2y$13$P77ggIZCC9RrAI1hdKPVMuoFT5Y2sV4mHKm2s4V2rdgU5pT60R7k2', NULL, 'annd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341875, 1523868940),
(39, 'hungnv.qnm@vnpt.vn', 'TTD-OyBSxvIuZUIZuLrVu3HjCGKkBzqu', '6f5zskBS0g7Og1hOWyFyAMhJEyHHvi-c', '$2y$13$r3ky4balODbqCBXbqZdJBuHw..QE8SCpI6gXtozkg0bl0pwq2KrGu', NULL, 'hungnv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341876, 1523868940),
(40, 'quanghv.qnm@vnpt.vn', 'J6HccyG_nTk677l9SnLPP1hGu2mFdU8k', 'K3s5CzymLwQfO16u0JOatiMN7kGiXle9', '$2y$13$jU44Ky6DlVj/hgFxTjEGZ..gUMkb0bUa6K7blZimk5fTNx/3nWY5e', NULL, 'quanghv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341876, 1523868940),
(41, 'hoatv.qnm@vnpt.vn', 'z6uX0zhOggsnhZJS3bWYVPcbV4MKQNsC', 's9nh6NyDvrADOAq6GELI7p_K3gb6s5AU', '$2y$13$PyZB0ywt5YbsGN0Sod3pvuEwq6wXRt68MVzfUfpG3iJCxVQHMMPlG', NULL, 'hoatv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341876, 1523868940),
(42, 'sonht.qnm@vnpt.vn', 'eWXxJdNrnuBdUJnezLUH376QiB24Swob', '5bWTx_eDFvY8kRovZ1HWXcRhrdG51wG7', '$2y$13$qYwrafloG3F/dFkDefLpGu3Bd1956NPafyeHM1CwmdWFGy4fQczNy', NULL, 'sonht.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341877, 1523868940),
(43, 'tamnd.qnm@vnpt.vn', 'U_wPFZsnRSYpc3bdrzNpLisUv98bW9xW', 'ba3yUfszihfALyTOAbjzFD6JfMRDb5wq', '$2y$13$RbUl791zS.Ext87TXKELQuGMV9mAXaakWt2pqO6aHZ1O3amglDfPG', NULL, 'tamnd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341877, 1523868940),
(44, 'vutn.qnm@vnpt.vn', 'QtjgDYAZ__7smqPw5Zfh_y-YCuTgxxuq', 'DpWKMNRxLUZVZWXHrtOiCNYP3HwKb1pz', '$2y$13$HzU6HXtSS.SFs.Gp2t1wbu0a2VGdAvF3lFvYl1zhMlASJWSJBzpO.', NULL, 'vutn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341878, 1523868940),
(45, 'toannq.qnm@vnpt.vn', 'XYtHZaTIj4fH8PYQxKBvj1bK4bwhMG5j', '0kwx4Ey9QIzkaDSUjvri0YuPtqmM5i3A', '$2y$13$oNM5doRvgKkPGPGAFI1Akeb0AxTsAITUKJSyQhm0eoNonQaErf2hK', NULL, 'toannq.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341878, 1523868940),
(46, 'quangvt.qnm@vnpt.vn', 'QGrBj3Q_qgV_zkZdEQAMq9IPkzX93-E9', 'PqgTAv111dB37qfoSfyKSOEdCnqBTXdu', '$2y$13$rwHLOxdN/M8mYhlK7CWQ7.pNGP5rMznLvAzto4nrCrnqMs0yv9miW', NULL, 'quangvt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341879, 1523868940),
(47, 'loit.qnm@vnpt.vn', 'ITOhFukfsNMucwV_AAG2o7TcCnhFFYvp', 'Wq5jbeCg66_DhE7t1K_UORpSSxcuv2FL', '$2y$13$JQXxesY48eJz0siTS8RCF.JGnATF.dF0zKunWroXggWgj6mECqvja', NULL, 'loit.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341879, 1523868940),
(48, 'traipv.qnm@vnpt.vn', 'Lc-708GKkW6EhnXa12kGE_DwkowGX5Ht', 'jAX2slivlvLnoy0FKBH0FLu-ct7wlpu3', '$2y$13$KW0x6PBxPuStqYR4DNdqk.3.UZvGOLtIuSo0a5iS8naYilLMZ8W5C', NULL, 'traipv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341879, 1523868940),
(49, 'hieupx.qnm@vnpt.vn', 'YwCaf5ULkgkNFVCR1nnbtWnE4-q6a7DU', 'Vj1pwdufRZ6NK33LtJcdYK5tdtQNcLFG', '$2y$13$giH8LCSSdB8gIBsDHrYrf.0rlOLl91lmJFqzYBsfOSb1wJghL0Hbu', NULL, 'hieupx.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341880, 1523868940),
(50, 'huynk.qnm@vnpt.vn', 'c88C6YgSi7T5MiNnuKLfulRvocZ7jIPL', 'sePFwgSgWKCSc1uC0_iewYI1aK2ZK1QA', '$2y$13$X0RCVa2rg1gPEl3aKr2tkeHLPHWtXNjwoADMYzh24FonD.D5t.4RS', NULL, 'huynk.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341880, 1523868940),
(51, 'tuandm.qnm@vnpt.vn', '1psCOg79yGMg5CUcnEdJvNmU8feorhma', 'WUoTlhqtlFM7r9AUTB-EMUo4tV-M9RJE', '$2y$13$WRWY5sAI2YPH3bseHchx2uRE1gCiptf3fi2upUNtI0d.zAqPf2Q12', NULL, 'tuandm.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341881, 1523868940),
(52, 'locvv.qnm@vnpt.vn', 'Mn0LQYpC5Yirx4syLDa0cpL3SpAuuihD', 'vrMnesc3UbAQSmivCdXdxkSjbYT1Q5GV', '$2y$13$XoWph3R6em2BSPagv8J8KOHwiV4tPo5AVsLJd2mfySgmi1KI5LGHm', NULL, 'locvv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341881, 1523868940),
(53, 'trongvd.qnm@vnpt.vn', 'jTh40Pt_ehIDgylFYnNtEAR8Bc3JLL1X', 'XDH9RCDiLUjUmzlZbfCVOUsGxOtfKO8O', '$2y$13$iQVLeiv6Qpj8Li4jW6c3E.kUcIQncR0Z6shV4y2wz83KHwLmSlEnW', NULL, 'trongvd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341882, 1523868940),
(54, 'hungnh.qnm@vnpt.vn', 'r1Du4Z7EwkfLethpn8UesHaJoNmC5r3c', 'M0EwTpkbO9tL9DN-Bpqkjto8aQGKaBCb', '$2y$13$VpULVt7XWgFwdOdWs3OHVO1d9FSK9xZ9goRo4mAfkeLuNGeT84uVG', NULL, 'hungnh.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341882, 1523868940),
(55, 'suonghh.qnm@vnpt.vn', 'gtWhoWXJiNHrF6abSGLy9xdDRgmG9e2p', 'yd2v9kR1GHJ2qP_PlhaTOGK88j-C7wso', '$2y$13$DozVehP3ZuvZXJ8OiOri0ejeIFRtJiSrrPtSNzl4UqPgBfy7QsNU6', NULL, 'suonghh.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341882, 1523868940),
(56, 'nhantn.qnm@vnpt.vn', 'ZbiEA-QF-UvP-l1E4JtyOCu1mQVFw1jP', '4lWcFsd_qSbQmsr1WjHk7FrCTdngTGsp', '$2y$13$GSGd65RcTYTBX1jw.RYMv.dHDK/.VP/sB0K8D5NI9qDZGtg7EZJuO', NULL, 'nhantn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341883, 1523868940),
(57, 'hoapt.qnm@vnpt.vn', 'vcRei7fOWTaanPAAmPV_BUARQBVQm2gD', 'puplB82GV-WVy2kFXGTTcsEPWlOMGpY_', '$2y$13$RyJUFjcf1cLcf8TGf4Wp2.CkFTHZOt9VL4NVNG42d2rqUeNcczVTm', NULL, 'hoapt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341883, 1523868940),
(58, 'phuocnv.qnm@vnpt.vn', 'yXfsDOIuxTZY2Q33rXCNb8LgSw6fSZsX', 'KwyckVggEBOtRppm4PXVT02ozbex7N1_', '$2y$13$61vWcjgROC00Yg9XCgCAZuaLBeiV8l4e7fBFrZOiEgdwj6kFjgihi', NULL, 'phuocnv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341884, 1523868940),
(59, 'tienpn.qnm@vnpt.vn', 'PgenGpRwY1YVKwoPxoFo1lOZMMscKaDN', '-g2-_k87thpRkx0_QgG0l5VyTuHQMyOv', '$2y$13$l5DSgGbJGcw92F6/.HL8bOzjgar7Os5R0E3I321LufKtkSxD3cWJ2', NULL, 'tienpn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341884, 1523868940),
(60, 'dunghv.qnm@vnpt.vn', '2H2hkWtj8doASe9EFxmLMK5EbF-rd50m', 'FJSN4n27jlHv-Ahqm1TFPbqbnxoTxFr1', '$2y$13$wSUyYXxtqZlVzCu7sU3KBOTgyLA96e20SPY69AHTpa/5304kWWVNy', NULL, 'dunghv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341885, 1523868941),
(61, 'thuongnt.qnm@vnpt.vn', 'pXi5FcFTwRcwj4qNeNjd69iO6HFgCUU1', 'eapGlKQS6-UjgHFF7RZ-Vsyvk3lS9kpc', '$2y$13$zhu5/vZQst9UQa52hNhZCemCtBWHo4zcow1p6jqRmmQ1uQ71J9M62', NULL, 'thuongnt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341885, 1523868941),
(62, 'thanhnn.qnm@vnpt.vn', '-lVmSUpumnwXFhVGERTuIjmMBoq5GO3f', '8oouz9DzelbxvBF1RG0brD2DjfDwAAMu', '$2y$13$NnroueN9WtB0Ur8gSJv9tekNml/PzJqSC3J7fYp45yJLrZ.eSdIbO', NULL, 'thanhnn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341885, 1523868941),
(63, 'khanhlv.qnm@vnpt.vn', 'b-wHTEPh4TMJHes9GUDujqJSYtB7wH5h', 'Sw2ybevbudV6GdU0GPsB0shX8vhiL1Z6', '$2y$13$pDerHGRaEK.WnxpaxAC9Ruk97Q49zW9GVKUrthyjVrf56bMLZgN4a', NULL, 'khanhlv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341886, 1523868941),
(64, 'hungtv.qnm@vnpt.vn', 'VcottdBxkJJjYOQm5tdywJUpG1wXyMbN', 'WkZ7o_jYuM-ma9DCFlILnNnT7Wq4J8yQ', '$2y$13$dw2QdIilai04BuRkpNNIKezvlP2qMfq3HTnS2dieNkZqPdbuUdYfq', NULL, 'hungtv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341886, 1523868941),
(65, 'quocnv.qnm@vnpt.vn', 'RyUqM4BlXm5bKgpq7gY__J2gEPlMMGts', 'xSXvO4c6Xo6ZfVmIpT_ivFKU5FgxhEql', '$2y$13$Uedq.YVj9YVkKJX79MBPquQczH6OObuv8J7O9Lx.JIFTzrO2CuhXS', NULL, 'quocnv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341887, 1523868941),
(66, 'haitd.qnm@vnpt.vn', 'gkTz9r94U3tjI6wUczneiHMcyw8Zm739', '15PklJRvYr4oCGRFYFN_xJlD-fmrIU-d', '$2y$13$kQ2P55HQ22kABApZSx6Ijeru6e3szZl6nZLqkbeNy62qZtSQSI3yW', NULL, 'haitd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341887, 1523868941),
(67, 'vietlt.qnm@vnpt.vn', 'qD6SUaUpwxMJ24L8LoxUc61MpRnd4TrZ', 'n0uFvVACxH2VEWg6s-JUtGka5bb1k08m', '$2y$13$oem/.Hwk9Z/IUVihVkuuR.3t0xz/pugKWuFrSm3wv2jIZd44h9PaS', NULL, 'vietlt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341888, 1523868941),
(68, 'cuonglc.qnm@vnpt.vn', '1MHqTFDzwzei__tflBBDpCImyqE9wEUl', 'WHorjyPQWOADGK_tr0F68bL29eQWARXM', '$2y$13$nnC7bDn6G3LDE.hJA6b4secIcSjwYQVA7qLFKMyhM/s8Wu7jTdIT2', NULL, 'cuonglc.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341888, 1523868941),
(69, 'thucdc.qnm@vnpt.vn', 'B0xXPLVrhhQgnkM-X0ar9F1wHwR-96M7', 'n24CtBc31ugLsmUAcn3ZTCzRbaenifIl', '$2y$13$iMvLDBzoaD9jCAQvHuh6cOAYECpnYVjTDuSdN2MPjMKsMs0rVuYDu', NULL, 'thucdc.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341889, 1523868941),
(70, 'dinhlt.qnm@vnpt.vn', 'yZAYP1H3XXgc7eUsAelvGGbASNHZ4QYE', '68Wgav49s-8-ZZXt4f5LFJnNrFB_YrcD', '$2y$13$Z.4SkTmhnaW8ktfJlWH.z.fN.4k6UsrGp0AiyaFxrn/iORqxflOTG', NULL, 'dinhlt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341889, 1523868941),
(71, 'sangld.qnm@vnpt.vn', 'jr1hqSFM0ETU057JFfmvBydAPjUm8snF', 'buF6EhCokgndoaivJQe0trfeik5PxtlI', '$2y$13$9Qve5/ABeChgbtXGxsHax.wy3q30nlrp6eNcFcq5GJoX28USSjN.2', NULL, 'sangld.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341889, 1523868941),
(72, 'trongnb.qnm@vnpt.vn', 'lTKmOtoNQodj4GwyDBbpihMGJCHTxHly', 'FNxMzGlAmgPdTPQaJk--dNlZPHuvwydx', '$2y$13$l2.Yhh749XuEimrhQDyF1.6C6Kbm8C1wUqvn5tq7.Lp9IN1bs4zQq', NULL, 'trongnb.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341890, 1523868941),
(73, 'tuanba.qnm@vnpt.vn', 'QXl-8nES_vQQMX4hX1R5ZnZEFoutL3QO', 'gR3liyzXOR6HxKyEmGGSZGYBPHg-IAq3', '$2y$13$q9kFGNGaY64kHCQDk4N6Ye2.hSwljE8b47UgaGf6pNxIvT.WywwVu', NULL, 'tuanba.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341890, 1523868941),
(74, 'thuonglv.qnm@vnpt.vn', 'HyJNGRfSxGfQtTcUs8cwZyJvkBhK09JE', '5vgiHJGvPNXrGABuXRQQghm715sk47I4', '$2y$13$AlYwvpdtZ81ufP8.prCExulq4ZF5MEcq.Wulfl3KTJk8qMcNixb36', NULL, 'thuonglv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341891, 1523868941),
(75, 'chanhnc.qnm@vnpt.vn', 'Gm5Dok1FRiOwEhwvhHvJ1kP6fm_QNaZU', 'AS_Hhhkl1lUIv0YRrp7iAhnhQ6B4_KIJ', '$2y$13$ielICaOXOKWkQefPfbxg5ekh.p10tL5e.EZZFwqe4VTeoU7n7i8OW', NULL, 'chanhnc.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341891, 1523868941),
(76, 'dungpv.qnm@vnpt.vn', 'C8-S_QtD7FvFmXiotzKVbvbS5x0_m-iU', 'LcKSyV3dTZv3jVmBYNZ4Ch6zi-by2ljw', '$2y$13$r0rYNQaFcfGZZU06RAbkHOavtuLpJkV5fvbJojmq3t5GVGl.BeD7m', NULL, 'dungpv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341892, 1523868941),
(77, 'hiennt.qnm@vnpt.vn', 'gnCFDSk--MNp1mBr3UbBhLWEp1j247ht', 'bGTG1fbTGDqtgq3pS5nVk3snAJao9XQG', '$2y$13$SeBpzBtY5xLFwlUVBGE0cO7UkkvTA9KbZmpR016xdWLWHVKKZpTli', NULL, 'hiennt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341892, 1523868941),
(78, 'phutn.qnm@vnpt.vn', '30YVU3TCA4Pm8Gql2LqhRUoqSKRj0WWd', 'Lv5GyYuKb_iGpEKeXpXzddOH9-rq0boY', '$2y$13$rbAQ6je9zo/FOuDwytK0TuSbSrGNatLG59saNLgVwfq21JBlolxGy', NULL, 'phutn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341893, 1523868941),
(79, 'sontt.qnm@vnpt.vn', 'XMUc6PMAY3r0AsmsV8MS6cC9-wkCJA7z', 'dVoM25d5-4YuEDsfvRvHffE35eWLykFI', '$2y$13$sx/.COCvaLx5SsWxFWrSjeF6RQwFge/kWU/a9Lfvk6o3JvCVBRvMu', NULL, 'sontt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341893, 1523868941),
(80, 'senptm.qnm@vnpt.vn', '7QzCT0kIe1H3ieSAMMfa28IULd5GJmN9', '4vr70nzCZ4YnY0mJ505rWf98G7rxD1dx', '$2y$13$FC7d5ySQPpdymyBeg7i6QOf8lF/SPLJ8SyMTNQ3FhRV5zKJih.GVy', NULL, 'senptm.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341894, 1523868941),
(81, 'thucdm.qnm@vnpt.vn', 'WeOFs4XHDNk90WQanOvPPY4P9-4rsE3q', 'RV0KIo3dVTSOxdvAW6Wup2f3zKZ5CbnR', '$2y$13$1e6dbf0CbnkbTLBJ6GTQTeK7cn4gJ7WmIyLzk4..iwUU/URq04Goi', NULL, 'thucdm.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341894, 1523868941),
(82, 'thaonv.qnm@vnpt.vn', '_7szhOWXjc79Q0z3hMpYfkn_T3KFIyGs', 'a3vgD8DIqdAYIYpEYEBiF0KclobNrEqj', '$2y$13$PHk36QhGagwOEcWNLbkBEe9SvTsTk/YWFskZoE9xrlW8da8xX9aFK', NULL, 'thaonv.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341895, 1523868941),
(83, 'thienhd.qnm@vnpt.vn', 'cdc7vhNpTp6NjQn72E8PcbOOMFuL7w5i', 'pruqe_o4ytMeS0AEKasPe1wc3Ir2ylz2', '$2y$13$zXmpOzGf1bm/DXJ/MYJhMe3lMbUBV4YbX.fd/AY3s5h/k1rtOp5pW', NULL, 'thienhd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341895, 1523868941),
(84, 'tuantd.qnm@vnpt.vn', '49OKGmphWOdpk6kkmvIwQl2aFKUJIHJ4', 'LEvmpVzs5NgeWM2Rmtr0i0pEBuv61Q51', '$2y$13$iAPGKy1M4sHOGiWuhfKpS.wedbRI9UyfmEwfz.aiojm.uFSL01.uq', NULL, 'tuantd.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341895, 1523868941),
(85, 'viethn.qnm@vnpt.vn', 'EnSxxwFB8GT4R_Gg7jTPALmlGKrBmLcQ', 'MigAw2527OTSsJD-NDgkvPfi8PYWQiiG', '$2y$13$N/nUVPz6ukaFFElAqi3VFO3WcZElLJbP.hrCTq1k/XM8LCgns8xDC', NULL, 'viethn.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341896, 1523868941),
(86, 'trieult.qnm@vnpt.vn', 'H7f_9Z_GIQWWN8pi2mzlmUtfMBWcq8g5', 'uquBa2NUlao_uSylJLAFJlXBdl4ftQqL', '$2y$13$5Ebfphi8msz8.1wmSM0sbeMhboJeyHyJ7QD1WkqkjI95/K2OlRXb.', NULL, 'trieult.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341896, 1523868941),
(87, 'thientt.qnm@vnpt.vn', 'BUrCkll7Pe24K_xN9rMO_ESv3uSj0_I0', 'yo_Wa4hF6JNJIhvu-CzOzXuiaEsU3LxV', '$2y$13$vZBKz14nvAPdXiLgh/V2Duy/L2weUKg56h8SLuRQUCQ2.B9OeEVOC', NULL, 'thientt.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1514341897, 1523868941),
(88, 'ndchau1.qnm@vnpt.vn', 'iDUNmUj2G5ofthMEMbPlpJDjxKk-53eQ', 'ynwYneZRnou-oFndF4nrAuWcJba-WO_w', '$2y$13$LXH8TIa5kKXLXwINLfYWsubj8TphpYcISoNZo.qUtIDKZNzZhlA6i', NULL, 'ndchau1.qnm@vnpt.vn', 'dist/img/default_picture.png', 10, 1517372124, 1523868941),
(89, 'tvtest.qnm', 'HIgSwGWaUED_8ZfMvluRCMR2KSwr9uTU', 'SX6B1hbWwxnDgEIBX-McSjka-paBdI0x', '$2y$13$9CU4qsG/GeIhs55X6OWetuJW2QR5rJrtyn7DQ1wsp05oiF8qs2kv2', NULL, 'tvtest.qnm', 'dist/img/default_picture.png', 10, 1521614557, 1523868941),
(90, 'testvante', 'ZHE1HrsNLTIW-2eNwtbGPBzcEmt240um', 'VXZQfngaIDnHUZr52mKD0TfbQSmpxPS3', '$2y$13$Rpyy/TjbkXZF7yVpCJmE3ODnMbLptaFUXTmiEUrPgzCT9hcd8OZQy', NULL, 'testvante', 'dist/img/90_ava.png', 10, 1521712791, 1523868941),
(91, 'test111', '39mKjTxX5b0k5-lpgK4PCL0rplI3X-7a', 'eUo7Ci8r5_HUGuMtB_gxBx9uRSxNQa_D', '$2y$13$oL/lwD8PzE3ePMeFxeohquGr3aDpPgLy7DskBmc8nN3nweAyezwR2', NULL, 'test111', 'dist/img/default_picture.png', 10, 1522029868, 1523868942),
(92, 'test11123', '_BtLoFXkkDWD7E6w0SH5dxyYHNY1b3OT', '-EyYYbGI6HWyYs-xZfEe_5-0oToA5wsF', '$2y$13$bPIDETFfyE4QGDVm3uR7luWZQI/QLoFaelMwAPZRIIkWO5G2vxBrK', NULL, 'test11123', 'dist/img/default_picture.png', 10, 1522032922, 1523868942),
(93, 'testvante111', 'W4C2in21u1u0cmvugeFeSHDjNupJBcYn', 'S2kWonTsw2EdcoPc8rkXjBuH2tlc2tol', '$2y$13$wmiSMdclgTuqZnYCgBcAce43UqVsv/OMfeE0Gxmas/j/bKFoI3kI.', NULL, 'testvante111', 'dist/img/default_picture.png', 10, 1522035929, 1523868942),
(94, 'root', '8xZUIupRnQvCSl4--zZW_IMT56Pwhi03', 'v9cD32v-YUDn7Ruvg-EMUjXj0-mx0Wcy', '$2y$13$h0zCa71MUIR0r5Y8PbbEwOCxN6QP4NCyPF0GELgIx84m1Xzb4OEzC', NULL, 'root', 'dist/img/default_picture.png', 10, 1523497343, 1523868942),
(96, 'gdtt1', 'LB0UDJxHEWw4xNRfGNJmGDKtSveZVciX', 'cF6jEZhnwbWtfWEsJKftXZHB-XRe4md0', '$2y$13$xarAEXQijwVTrVUwRJWR/epNE.Gd1aQvbLWkl92IVv6k3NcIa8ymm', NULL, 'gdtt1', 'dist/img/default_picture.png', 10, 1523504229, 1523868942),
(98, 'gdtt4', 's0fj_2GQhbdDFxAtZltwKZzOpF28hT6z', '2axJNQGbebBwM15CGnC6HEtLi4rFpffL', '$2y$13$iXfSNgb9lv/ud.lJ9/VEQONFrAkTe9K/exewEKZFAHkJYSTBZzCJ6', NULL, 'gdtt4', 'dist/img/default_picture.png', 10, 1523505036, 1523868942),
(99, 'gdtt2', '8ihaqyEx1XPi6uXUc10_lIw5hSYKcQ16', 'zkQsAVKWq4q58SR1Zn4wib0eNsFqUgrc', '$2y$13$myi3jjfZnfY3OftV5XzMX.vTow9aux3oV/jCpzUZFQlr.Yfd0qhpC', NULL, 'gdtt2', 'dist/img/default_picture.png', 10, 1523505156, 1523868942),
(100, 'td1tky', 'En6_y-kMXGAFIFJ7yvLE2re0I6X31b3w', 'jeViuV-YI37Z_7CSLUCPN7gUtWWw3grA', '$2y$13$RRPMDG61bjmoljmDBJnCSuRce7xxwJdBI4PMkFaQAXfP6q5Qnya7.', NULL, 'td1tky', 'dist/img/default_picture.png', 10, 1523505275, 1523868942),
(101, 'td1nt', 'lvwT5mfz0IRihyIBSyxtwq7G5UXic2m7', 'chpI7cgKYv4p_vRQAkxV7Ca_Witqj2wV', '$2y$13$YwhbodgMVSO55Wd8ffpj2ugMwtobtLCokUV49amOXTNsNlYxdcC76', NULL, 'td1nt', 'dist/img/default_picture.png', 10, 1523506962, 1523868942);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities_log`
--
ALTER TABLE `activities_log`
  ADD PRIMARY KEY (`activity_log_id`),
  ADD KEY `activity_type` (`activity_type`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_type`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `baocao`
--
ALTER TABLE `baocao`
  ADD PRIMARY KEY (`ID_DOTBD`);

--
-- Indexes for table `chontbidieuchuyen`
--
ALTER TABLE `chontbidieuchuyen`
  ADD PRIMARY KEY (`ID_THIETBI`);

--
-- Indexes for table `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chukybaoduong`
--
ALTER TABLE `chukybaoduong`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daivt`
--
ALTER TABLE `daivt`
  ADD PRIMARY KEY (`ID_DAI`),
  ADD UNIQUE KEY `UQ_DAI` (`MA_DAIVT`),
  ADD KEY `FK_DAIDONVI` (`ID_DONVI`);

--
-- Indexes for table `dexuatnoidung`
--
ALTER TABLE `dexuatnoidung`
  ADD PRIMARY KEY (`ID_LOAITB`,`CHUKYBAODUONG`,`MA_NOIDUNG`),
  ADD KEY `FK_ND_DX` (`MA_NOIDUNG`),
  ADD KEY `CHUKYBAODUONG` (`CHUKYBAODUONG`);

--
-- Indexes for table `dieuchuyenthietbi`
--
ALTER TABLE `dieuchuyenthietbi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `donvi`
--
ALTER TABLE `donvi`
  ADD PRIMARY KEY (`ID_DONVI`),
  ADD UNIQUE KEY `DONVI_UQ` (`MA_DONVI`),
  ADD KEY `DONVI_FK` (`CAP_TREN`);

--
-- Indexes for table `dotbaoduong`
--
ALTER TABLE `dotbaoduong`
  ADD PRIMARY KEY (`ID_DOTBD`),
  ADD KEY `FK_TRUONGNHOM` (`TRUONG_NHOM`),
  ADD KEY `FK_TRAM_BD` (`ID_TRAMVT`);

--
-- Indexes for table `lencongviec`
--
ALTER TABLE `lencongviec`
  ADD PRIMARY KEY (`ID_DOTBD`,`ID_THIETBI`,`MA_NOIDUNG`),
  ADD KEY `fk_manoidung` (`MA_NOIDUNG`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`ID_NHANVIEN`),
  ADD UNIQUE KEY `UNIQUE` (`MA_NHANVIEN`),
  ADD KEY `FK_NVDONVI` (`ID_DONVI`),
  ADD KEY `FK_NVDAI` (`ID_DAI`),
  ADD KEY `CHUC_VU` (`CHUC_VU`);

--
-- Indexes for table `nhomtbi`
--
ALTER TABLE `nhomtbi`
  ADD PRIMARY KEY (`ID_NHOM`);

--
-- Indexes for table `noidungbaotri`
--
ALTER TABLE `noidungbaotri`
  ADD PRIMARY KEY (`MA_NOIDUNG`),
  ADD KEY `FK_TBI_ND` (`ID_THIETBI`);

--
-- Indexes for table `noidungcongviec`
--
ALTER TABLE `noidungcongviec`
  ADD PRIMARY KEY (`ID_DOTBD`,`ID_THIETBI`,`MA_NOIDUNG`,`ID_NHANVIEN`),
  ADD KEY `fk_cv_tbi` (`ID_THIETBI`),
  ADD KEY `fk_cv_nd` (`MA_NOIDUNG`),
  ADD KEY `fk_cv_nv` (`ID_NHANVIEN`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`ID_THIETBI`),
  ADD KEY `FK_NHOMTBI` (`ID_NHOMTB`);

--
-- Indexes for table `thietbitram`
--
ALTER TABLE `thietbitram`
  ADD PRIMARY KEY (`ID_THIETBI`),
  ADD UNIQUE KEY `SERIAL_MAC` (`SERIAL_MAC`),
  ADD KEY `FK_THIETBI-TRAM` (`ID_TRAM`),
  ADD KEY `FK_LOAITBI` (`ID_LOAITB`);

--
-- Indexes for table `tramvt`
--
ALTER TABLE `tramvt`
  ADD PRIMARY KEY (`ID_TRAM`),
  ADD KEY `FK_TRAM-DAI` (`ID_DAI`),
  ADD KEY `FK_TRAM-NHANVIEN` (`ID_NHANVIEN`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities_log`
--
ALTER TABLE `activities_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `chucvu`
--
ALTER TABLE `chucvu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chukybaoduong`
--
ALTER TABLE `chukybaoduong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `daivt`
--
ALTER TABLE `daivt`
  MODIFY `ID_DAI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dieuchuyenthietbi`
--
ALTER TABLE `dieuchuyenthietbi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donvi`
--
ALTER TABLE `donvi`
  MODIFY `ID_DONVI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dotbaoduong`
--
ALTER TABLE `dotbaoduong`
  MODIFY `ID_DOTBD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `ID_NHANVIEN` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `nhomtbi`
--
ALTER TABLE `nhomtbi`
  MODIFY `ID_NHOM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `ID_THIETBI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `thietbitram`
--
ALTER TABLE `thietbitram`
  MODIFY `ID_THIETBI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tramvt`
--
ALTER TABLE `tramvt`
  MODIFY `ID_TRAM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities_log`
--
ALTER TABLE `activities_log`
  ADD CONSTRAINT `fk_log_activ` FOREIGN KEY (`activity_type`) REFERENCES `activity` (`activity_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `baocao`
--
ALTER TABLE `baocao`
  ADD CONSTRAINT `FK_IDDOTBD` FOREIGN KEY (`ID_DOTBD`) REFERENCES `dotbaoduong` (`ID_DOTBD`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `daivt`
--
ALTER TABLE `daivt`
  ADD CONSTRAINT `FK_DAI_DONVI` FOREIGN KEY (`ID_DONVI`) REFERENCES `donvi` (`ID_DONVI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dexuatnoidung`
--
ALTER TABLE `dexuatnoidung`
  ADD CONSTRAINT `FK_CHUKY_DEXUAT` FOREIGN KEY (`CHUKYBAODUONG`) REFERENCES `chukybaoduong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LOAITB_DEXUAT` FOREIGN KEY (`ID_LOAITB`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_NOIDUNG_DEXUAT` FOREIGN KEY (`MA_NOIDUNG`) REFERENCES `noidungbaotri` (`MA_NOIDUNG`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dotbaoduong`
--
ALTER TABLE `dotbaoduong`
  ADD CONSTRAINT `FK_TRAM_BD` FOREIGN KEY (`ID_TRAMVT`) REFERENCES `tramvt` (`ID_TRAM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRUONGNHOM` FOREIGN KEY (`TRUONG_NHOM`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lencongviec`
--
ALTER TABLE `lencongviec`
  ADD CONSTRAINT `fk_manoidung` FOREIGN KEY (`MA_NOIDUNG`) REFERENCES `noidungbaotri` (`MA_NOIDUNG`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_NVDAI` FOREIGN KEY (`ID_DAI`) REFERENCES `daivt` (`ID_DAI`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chucvu` FOREIGN KEY (`CHUC_VU`) REFERENCES `chucvu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nvdonvi` FOREIGN KEY (`ID_DONVI`) REFERENCES `donvi` (`ID_DONVI`);

--
-- Constraints for table `noidungbaotri`
--
ALTER TABLE `noidungbaotri`
  ADD CONSTRAINT `FK_TBI_ND` FOREIGN KEY (`ID_THIETBI`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `noidungcongviec`
--
ALTER TABLE `noidungcongviec`
  ADD CONSTRAINT `fk_cv_dbd` FOREIGN KEY (`ID_DOTBD`) REFERENCES `dotbaoduong` (`ID_DOTBD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cv_nd` FOREIGN KEY (`MA_NOIDUNG`) REFERENCES `noidungbaotri` (`MA_NOIDUNG`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cv_nv` FOREIGN KEY (`ID_NHANVIEN`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cv_tbi` FOREIGN KEY (`ID_THIETBI`) REFERENCES `thietbitram` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `FK_NHOMTBI` FOREIGN KEY (`ID_NHOMTB`) REFERENCES `nhomtbi` (`ID_NHOM`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `thietbitram`
--
ALTER TABLE `thietbitram`
  ADD CONSTRAINT `FK_LOAITBI` FOREIGN KEY (`ID_LOAITB`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_THIETBI-TRAM` FOREIGN KEY (`ID_TRAM`) REFERENCES `tramvt` (`ID_TRAM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tramvt`
--
ALTER TABLE `tramvt`
  ADD CONSTRAINT `FK_TRAM-DAI` FOREIGN KEY (`ID_DAI`) REFERENCES `daivt` (`ID_DAI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRAM-NHANVIEN` FOREIGN KEY (`ID_NHANVIEN`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
