-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2017 at 04:54 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vnpt_spsm`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_createGroupPara` ()  BEGIN
	DECLARE v_mapara VARCHAR(20);
	DECLARE v_filepara TEXT;
	DECLARE v_mota VARCHAR(100) charset utf8;
	DECLARE v_activepara INT(1);
	DECLARE v_activemodule INT(1);
	DECLARE v_idmodule INT;
	DECLARE v_idpi INT;
	DECLARE v2_idpi INT;
	
	DECLARE v_finished1,v_finished2 INTEGER DEFAULT 0;
	DECLARE cur_para CURSOR 
		FOR SELECT MA_PARAM,FILE_PARAM,MO_TA,ACTIVE_PARAM,ACTIVE_MODULE,ID_MODULE,ID_PI 
		FROM tbl_param ORDER BY ID_PI,ID_MODULE;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished1=1;
	OPEN cur_para;
		paraLoop: LOOP
		FETCH cur_para INTO v_mapara,v_filepara,v_mota,v_activepara,v_activemodule,v_idmodule,v_idpi;
		IF v_finished1 = 1 THEN LEAVE paraLoop; 
		END IF;
				BLOCK2: BEGIN
				DECLARE cur_pi CURSOR FOR SELECT ID_PI FROM tbl_pi a 
				WHERE a.ID_NHOMPI IN (SELECT ID_NHOMPI FROM tbl_pi WHERE ID_PI=v_idpi) 
				AND a.ID_PI <> v_idpi ORDER BY a.ID_PI;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished2 = 1;
				OPEN cur_pi; 
								piLoop: LOOP
					FETCH FROM cur_pi INTO v2_idpi; 
					IF v_finished2 = 1 THEN LEAVE piLoop; 
					END IF;
										IF NOT EXISTS( SELECT 1 FROM tbl_param
						WHERE ID_PI = v2_idpi 
						AND ID_MODULE = v_idmodule ) THEN
												INSERT INTO tbl_param(MA_PARAM,FILE_PARAM,MO_TA,ACTIVE_PARAM,ACTIVE_MODULE,ID_MODULE,ID_PI) 
						VALUES(v_mapara,v_filepara,v_mota,v_activepara,v_activemodule,v_idmodule,v2_idpi); 						
					END IF;	
			
				END LOOP piLoop;
				SET v_finished2 = 0;
				CLOSE cur_pi;
				
		END BLOCK2;
	END LOOP paraLoop;
	CLOSE cur_para;
    END$$

DELIMITER ;

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
(2, 'PHN', 'Trạm Viễn thông Phú Ninh', 'Phú Thịnh, Phú Ninh', '', 4),
(3, 'NTH', 'Đài viễn thông Núi Thành', 'Núi Thành', '', 4),
(4, 'TPC', 'Đài viễn thông Tiên Phước-Trả My', 'Tiên Phước', '', 4),
(5, 'BTM', 'Trạm viễn thông Bắc Trà My', 'Bắc Trà My', '', 4),
(6, 'NTM', 'Trạm viễn thông Nam Trà My', 'Tắc Pỏ', '', 4),
(7, 'OMC', 'OMC', 'QNM', '', 1),
(8, 'OMC_TT1', 'OMC Trung tâm 1', 'Tam Kỳ', '0000', 4),
(9, 'OMC_TT2', 'OMC Trung tâm 2', 'Duy Xuyên', '', 5),
(10, 'OMC_TT3', 'OMC Trung tâm 3', 'Hội An', NULL, 6),
(11, 'OMC_TT4', 'OMC Trung tâm 4', 'Đại Lộc', '', 7),
(12, 'HAN', 'Đài viễn thông Hội An', 'Hội An', '', 6),
(13, 'DBN', 'Đài viễn thông Điện Bàn', 'Điện Bàn', '', 6),
(14, 'TBH', 'Đài viễn thông Thăng Bình', 'Thăng Bình', '', 5),
(15, 'DXN', 'Đài viễn thông Duy Xuyên', 'Duy Xuyên', '', 5),
(16, 'QSN', 'Đài viễn thông Quế Sơn', 'Quế Sơn', '', 5),
(17, 'HDC', 'Đài viễn thông Hiệp Đức-Phước Sơn', 'Tân An, Hiệp Đức', '', 5),
(18, 'PSN', 'Trạm viễn thông Phước Sơn', 'Khâm Đức, Phước Sơn', '', 5),
(19, 'DLC', 'Đài viễn thông Đại Lộc', 'Ái Nghĩa, Đại Lộc', '', 7),
(20, '3GG', 'Đài viễn thông Tam Giang', 'Thạnh Mỹ, Nam Giang', '', 7),
(21, 'NSN', 'Trạm viễn thông Nông Sơn', 'Nông Sơn', '', 5),
(22, 'DGG', 'Trạm viễn thông Đông Giang', 'Đông Giang', '', 7),
(23, 'TGG', 'Trạm viễn thông Tây Giang', 'Tây Giang', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `dexuatnoidung`
--

CREATE TABLE `dexuatnoidung` (
  `ID_LOAITB` int(11) NOT NULL,
  `LAN_BD` varchar(32) NOT NULL,
  `CHUKYBAODUONG` varchar(32) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dexuatnoidung`
--

INSERT INTO `dexuatnoidung` (`ID_LOAITB`, `LAN_BD`, `CHUKYBAODUONG`, `MA_NOIDUNG`) VALUES
(1, '1', '7 days', '101'),
(1, '1', '7 days', '102'),
(1, '2', '15 days', '102'),
(1, '2', '15 days', '103'),
(2, '1', '10 days', '202'),
(2, '2', '1 month', '202'),
(2, '2', '1 month', '203'),
(3, '1', '1 month', '301'),
(3, '2', '3 months', '301'),
(3, '2', '3 months', '302');

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
(1, 'QNM', 'VNPT Quảng Nam', '2 Phan Bội Châu, Tam Kỳ', '0510.3812119', 1),
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
  `NGAY_BD` date NOT NULL,
  `ID_TRAMVT` int(11) DEFAULT NULL,
  `TRANGTHAI` varchar(32) NOT NULL DEFAULT 'Kế hoạch',
  `TRUONG_NHOM` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dotbaoduong`
--

INSERT INTO `dotbaoduong` (`ID_DOTBD`, `MA_DOTBD`, `NGAY_BD`, `ID_TRAMVT`, `TRANGTHAI`, `TRUONG_NHOM`) VALUES
(1, 'TKY01-Q4', '2017-11-10', 1, 'Kế hoạch', 16),
(3, 'NT001-Q4', '2017-11-15', 2, 'Kết thúc', 20);

-- --------------------------------------------------------

--
-- Table structure for table `kehoachbdtb`
--

CREATE TABLE `kehoachbdtb` (
  `ID_DOTBD` int(11) NOT NULL,
  `ID_THIETBI` int(11) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL,
  `ID_NHANVIEN` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kehoachbdtb`
--

INSERT INTO `kehoachbdtb` (`ID_DOTBD`, `ID_THIETBI`, `MA_NOIDUNG`, `ID_NHANVIEN`) VALUES
(1, 2, '202', 8),
(1, 1, '102', 10),
(1, 1, '103', 13),
(1, 2, '203', 15),
(1, 2, '201', 18),
(1, 1, '101', 20);

-- --------------------------------------------------------

--
-- Table structure for table `ketqua`
--

CREATE TABLE `ketqua` (
  `ID_DOTBD` int(11) NOT NULL,
  `KETQUA` varchar(32) NOT NULL,
  `GHICHU` varchar(255) DEFAULT NULL,
  `ANH1` varchar(255) DEFAULT NULL,
  `ANH2` varchar(255) DEFAULT NULL,
  `ANH3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `ID_NHANVIEN` int(10) UNSIGNED NOT NULL,
  `MA_NHANVIEN` varchar(10) NOT NULL,
  `TEN_NHANVIEN` varchar(100) NOT NULL,
  `CHUC_VU` varchar(50) DEFAULT NULL,
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
(1, 'TKY004', 'Phan Thành Long ', 'Quản lý trạm', '0911017999 ', 4, 1, 1, '', 'longpt.qnm@vnpt.vn'),
(2, 'TT1003', 'Dương Văn Phong', 'Tổ trưởng', '0914146990', 4, 8, 0, '', ''),
(4, 'TKY003', 'Trần Vĩnh Linh', 'Quản lý trạm', '0914340696', 4, 1, 0, '', ''),
(5, 'QNM002', 'OMC', 'OMC', '0914136999', 1, 7, 0, '', 'omc'),
(6, 'QNM000', 'Nguyễn Thành', 'IT', '0914136999', 1, 7, 0, '', 'nguyenthanh'),
(7, 'QNM001', 'Quản trị', 'Quản trị hệ thống', '000000000', 1, 7, 0, '', 'admin'),
(8, 'TT1001', 'Trần Như Hoàng', 'Giám đốc Trung tâm', '0913407000 ', 4, 8, 0, '', 'hoangtn.qnm@vnpt.vn'),
(9, 'TT1002', 'Lương Hồng Ân', 'P. GĐ Trung tâm', '0914146555 ', 4, 8, 0, 'OMC TT1', ''),
(10, 'TKY002', 'Trần Ngọc Nam', 'Quản lý trạm', '0935637637', 4, 2, 0, '', 'namtn.qnm@vnpt.vn'),
(11, 'NTH002', 'Nguyễn Văn Tiến', 'Quản lý trạm', '0914353474', 4, 3, 1, '', 'tiennv.qnm@vnpt.vn'),
(12, 'DBN002', 'Dương Văn Sẵn', 'Quản lý trạm', '0914020447', 6, 13, 1, '', 'sandv.qnm@vnpt.vn'),
(13, 'HAN002', 'Lê Duy Trung', 'Quản lý trạm', '0914273305', 6, 12, 1, '', 'trungld.qnm@vnpt.vn'),
(14, 'TT3001', 'Phạm Thị Phương Thảo', 'Giám đốc Trung tâm', '0914135555', 6, 10, 0, '', 'thaoptp.qnm@vnpt.vn'),
(15, 'TT3002', 'Lê Trọng Hiệp', 'P. GĐ Trung tâm', '0914223905', 6, 10, 0, '', 'hieplt.qnm@vnpt.vn'),
(16, 'TT3003', 'Lê Hữu Chung', 'Tổ trưởng', '0914061155', 6, 10, 0, '', ''),
(17, 'TT3004', 'Lê Duy Trung ', 'Tổ trưởng', '0917986715', 6, 10, 0, '', ''),
(18, 'DBN001', 'Lưu Văn Tùng', 'Trưởng đài', '0914228111', 6, 13, 0, '', 'tunglv.qnm@vnpt.vn'),
(19, 'HAN001', 'Lê Văn Đạo', 'Trưởng đài', '0914022269', 6, 12, 0, '', 'daolv.qnm@vnpt.vn'),
(20, 'TKY001', 'Lương Hồng Ân', 'Trưởng đài', '0914146555', 4, 1, 0, '', 'anlh.qnm@vnpt.vn'),
(21, 'NTH001', 'Phan Như Lĩnh', 'Trưởng đài', '0913480696', 4, 3, 0, '', 'linhpn.qnm@vnpt.vn'),
(22, 'TT1004', 'Lê Trung Nguyên', 'Tổ trưởng', '0913474033', 4, 8, 0, '', ''),
(23, 'TKY005', 'Nguyễn Đức Long', 'Quản lý trạm', '0914152444', 4, 1, 1, '', 'longnd.qnm@vnpt.vn'),
(24, 'TT3005', 'Trần Hà Phương', 'Tổ trưởng', '0945256555', 6, 10, 0, 'Tạm khai thác', 'phuongth.qnm@vnpt.vn'),
(25, 'TT2001', 'Nguyễn Văn Bổn', 'Giám đốc Trung tâm', '0913480434', 5, 9, 0, '', 'bonnv.qnm@vnpt.vn'),
(26, 'TT2002', 'Trần Đình Phúc', 'P. GĐ Trung tâm', '0914228027', 5, 9, 0, '', 'phuctd.qnm@vnpt.vn'),
(27, 'TT4001', 'Huỳnh Đức Tiến', 'Giám đốc Trung tâm', '0945295252', 7, 11, 0, '', 'tienhd.qnm@vnpt.vn'),
(28, 'TT4002', 'Nguyễn Thanh Nhàn', 'P. GĐ Trung tâm', '0914223772', 7, 11, 0, '', 'nhannt.qnm@vnpt.vn'),
(29, 'TKY006', 'Huỳnh Thanh Tùng', 'Quản lý trạm', '0914136566', 4, 1, 1, '', 'tunght.qnm@vnpt.vn'),
(30, 'NTH003', 'Giám sát trạm', 'Quản lý trạm', '000000000', 4, 3, 0, '', ''),
(31, 'NTH004', 'Trương Công Xuất', 'Quản lý trạm', '0914152077', 4, 3, 1, '', 'xuattc.qnm@vnpt.vn'),
(32, 'NTH005', 'Hồ Bảo Phương', 'Quản lý trạm', '0914146786', 4, 3, 1, '', 'phuonghb.qnm@vnpt.vn'),
(33, 'NTH006', 'Phan Hoài Bảo', 'Quản lý trạm', '0913407060', 4, 3, 1, '', 'baoph.qnm@vnpt.vn'),
(34, 'NTH007', 'Giám sát trạm', 'Quản lý trạm', '000000000', 4, 3, 0, '', ''),
(35, 'NTH008', 'Võ Văn Lắm', 'Quản lý trạm', '0914285756 ', 4, 3, 1, '', 'lamvv.qnm@vnpt.vn'),
(36, 'PNH002', 'Nguyễn Đức An', 'Quản lý trạm', '0914941025', 4, 1, 1, '', 'annd.qnm@vnpt.vn'),
(37, 'PNH003', 'Nguyễn Việt Hùng', 'Quản lý trạm', '0914855549', 4, 1, 1, '', 'hungnv.qnm@vnpt.vn'),
(38, 'PNH004', 'Hồ Văn Quảng', 'Quản lý trạm', '0914035569', 4, 1, 1, '', 'quanghv.qnm@vnpt.vn'),
(39, 'BTM001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 4, 4, 0, '', ''),
(40, 'BTM002', 'Triệu Viết Hòa', 'Quản lý trạm', '0949222464', 4, 4, 0, '', 'hoatv.qnm@vnpt.vn'),
(41, 'BTM003', 'Hồ Thái Sơn', 'Quản lý trạm', '0914781900', 4, 4, 1, '', 'sonht.qnm@vnpt.vn'),
(42, 'NTM001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 4, 4, 0, '', ''),
(43, 'NTM002', 'Nguyễn Đăng Tâm', 'Quản lý trạm', '0915992717', 4, 4, 1, '', 'tamnd.qnm@vnpt.vn'),
(44, 'TPC001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 4, 4, 0, '', ''),
(45, 'TPC002', 'Trần Ngọc Vũ', 'Quản lý trạm', '0942308080', 4, 4, 1, '', 'vutn.qnm@vnpt.vn'),
(46, 'TPC003', 'Nguyễn Quốc Toàn', 'Quản lý trạm', '0916301444', 4, 4, 1, '', 'toannq.qnm@vnpt.vn'),
(47, 'DXN001', 'Bùi Minh Huy', 'Trưởng đài', '0914001000', 5, 15, 0, '', ''),
(48, 'DXN002', 'Vũ Tiến Quang', 'Quản lý trạm', '0914228438', 5, 15, 1, '', 'quangvt.qnm@vnpt.vn'),
(49, 'DXN003', 'Trần Lợi', 'Quản lý trạm', '0948737118', 5, 15, 1, '', 'loit.qnm@vnpt.vn'),
(50, 'DXN004', 'Giám sát trạm', 'Quản lý trạm', '000000000', 5, 15, 0, '', ''),
(51, 'HDC001', 'Trưởng đài', 'Trưởng đài', '000000000', 5, 17, 0, '', ''),
(52, 'HDC002', 'Phạm Văn Trai', 'Quản lý trạm', '0914335777', 5, 17, 1, '', 'traipv.qnm@vnpt.vn'),
(53, 'NSN001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 5, 16, 0, '', ''),
(54, 'NSN002', 'Giám sát trạm Đèo Le', 'Quản lý trạm', '000000000', 5, 16, 0, '', ''),
(55, 'PSN001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 5, 17, 0, '', ''),
(56, 'PSN002', 'Phạm Xuân Hiếu', 'Quản lý trạm', '0914790019', 5, 17, 1, '', 'hieupx.qnm@vnpt.vn'),
(57, 'PSN003', 'Nguyễn Khắc Huy', 'Quản lý trạm', '0914333227', 5, 17, 1, '', 'huynk.qnm@vnpt.vn'),
(58, 'PSN004', 'Đặng Minh Tuấn', 'Quản lý trạm', '0948739456', 5, 17, 1, '', 'tuandm.qnm@vnpt.vn'),
(59, 'QSN001', 'Võ Văn Lộc', 'Trưởng đài', '0913406369', 5, 16, 0, '', 'locvv.qnm@vnpt.vn'),
(60, 'QSN002', 'Vũ Đình Trọng', 'Quản lý trạm', '0915567447', 5, 16, 1, '', 'trongvd.qnm@vnpt.vn'),
(61, 'QSN003', 'Nguyễn Hữu Hùng', 'Quản lý trạm', '0914152559', 5, 16, 1, '', 'hungnh.qnm@vnpt.vn'),
(62, 'QSN004', 'Huỳnh Hồng Sương', 'Quản lý trạm', '0916103040', 5, 16, 1, '', 'suonghh.qnm@vnpt.vn'),
(63, 'TBH001', 'Trần Đình Phúc', 'Trưởng đài', '0914228027', 5, 14, 0, '', ''),
(64, 'TBH002', 'Trần Ngọc Nhân', 'Quản lý trạm', '0913190914', 5, 14, 1, '', 'nhantn.qnm@vnpt.vn'),
(65, 'TBH003', 'Phan Thanh Hòa', 'Quản lý trạm', '0914747117', 5, 14, 1, '', 'hoapt.qnm@vnpt.vn'),
(66, 'TBH004', 'Nguyễn Văn Phước', 'Quản lý trạm', ' 0914758914', 5, 14, 1, '', 'phuocnv.qnm@vnpt.vn'),
(67, 'TBH005', 'Phan Nhật Tiên', 'Quản lý trạm', '0914781800', 5, 14, 1, '', 'tienpn.qnm@vnpt.vn'),
(68, 'DB004', 'Hồ Viết Dũng', 'Quản lý trạm', '0914456758', 6, 13, 1, '', 'dunghv.qnm@vnpt.vn'),
(69, 'DBN005', 'Nguyễn Trọng Thương', 'Quản lý trạm', '0914781758', 6, 13, 1, '', 'thuongnt.qnm@vnpt.vn'),
(70, 'DBN006', 'Nguyễn Như Thành', 'Quản lý trạm', '0919438810', 6, 13, 1, '', 'thanhnn.qnm@vnpt.vn'),
(71, 'DBN007', 'Lê Văn Khánh', 'Quản lý trạm', '0913484709', 6, 13, 1, '', 'khanhlv.qnm@vnpt.vn'),
(73, 'DBN008', 'Quản lý trạm', 'Quản lý trạm', '000000000', 6, 13, 0, '', ''),
(74, 'DBN009', 'Trần Văn Hưng', 'Quản lý trạm', '0919433503', 6, 13, 1, '', 'hungtv.qnm@vnpt.vn'),
(75, 'DBN010', 'Nguyễn Văn Quốc', 'Quản lý trạm', '0914717645', 6, 13, 1, '', 'quocnv.qnm@vnpt.vn'),
(76, 'DBN011', 'Trần Duy Hải', 'Quản lý trạm', '0915515252', 6, 13, 1, '', 'haitd.qnm@vnpt.vn'),
(77, 'HAN003', 'Lê Thành Việt', 'Quản lý trạm', '0913419922', 6, 12, 1, '', 'vietlt.qnm@vnpt.vn'),
(78, 'HAN004', 'Lê Chí Cường', 'Quản lý trạm', '0917618748', 6, 12, 1, '', 'cuonglc.qnm@vnpt.vn'),
(79, 'DGG001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 7, 20, 0, '', ''),
(80, 'DGG002', 'Đinh Công Thức', 'Quản lý trạm', '0914024488', 7, 20, 1, '', 'thucdc.qnm@vnpt.vn'),
(81, 'DLC001', 'Trưởng đài', 'Trưởng đài', '000000000', 7, 19, 0, '', ''),
(82, 'DLC002', 'Lê Trung Đình', 'Quản lý trạm', '0942010141', 7, 19, 1, '', 'dinhlt.qnm@vnpt.vn'),
(83, 'DLC003', 'Lê Đắc Sang', 'Quản lý trạm', '0914781818', 7, 19, 1, '', 'sangld.qnm@vnpt.vn'),
(84, 'DLC004', 'Quản lý trạm', 'Quản lý trạm', '000000000', 7, 19, 0, '', ''),
(85, 'NGG001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 7, 20, 0, '', ''),
(86, 'NGG002', 'Nguyễn Bá Trọng', 'Quản lý trạm', '0943544433', 7, 20, 1, '', 'trongnb.qnm@vnpt.vn'),
(87, 'NGG003', 'Bhnước Anh Tuấn	', 'Quản lý trạm', '0917666007', 7, 20, 1, '', 'tuanba.qnm@vnpt.vn'),
(88, 'NGG004', 'Lê Văn Thương', 'Quản lý trạm', '0941379123', 7, 20, 1, '', 'thuonglv.qnm@vnpt.vn'),
(89, 'NGG005', 'Quản lý trạm xxx', 'Quản lý trạm', '000000000', 7, 20, 1, '', ''),
(90, 'NGG006', 'Quản lý trạm', 'Quản lý trạm', '000000000', 7, 20, 0, '', ''),
(91, 'NGG007', 'Quản lý trạm', 'Quản lý trạm', '000000000', 7, 20, 0, '', ''),
(92, 'PNH001', 'Trưởng trạm', 'Trưởng trạm', '000000000', 4, 1, 0, '', ''),
(93, 'DHTT001', 'Nguyễn Công Chánh', 'Nhân viên', '0914040080', 1, 7, 0, '', 'chanhnc.qnm@vnpt.vn'),
(94, 'DHTT002', 'Lê Công Cường', 'Nhân viên', '0913480588', 1, 7, 0, '', 'cuonglc.qnm@vnpt.vn'),
(95, 'DHTT003', 'Phạm Viết Dũng', 'Nhân viên', ' 0915136014', 1, 7, 0, '', 'dungpv.qnm@vnpt.vn'),
(96, 'DHTT004', 'Nguyễn Thu Hiền', 'Nhân viên', '0914049094', 1, 7, 0, '', 'hiennt.qnm@vnpt.vn'),
(97, 'DHTT005', 'Trương Ngọc Phú', 'Nhân viên', '0914049044', 1, 7, 0, '', 'phutn.qnm@vnpt.vn'),
(98, 'DHTT006', 'Trần Thanh Sơn', 'Nhân viên', '0914637959 ', 1, 7, 0, '', 'sontt.qnm@vnpt.vn'),
(99, 'DHTT007', 'Phạm Thị Mỹ Sen', 'Nhân viên', '0914049059', 1, 7, 0, '', 'senptm.qnm@vnpt.vn'),
(100, 'DHTT008', 'Dư Mạnh Thực', 'Nhân viên', '0914065888', 1, 7, 0, '', 'thucdm.qnm@vnpt.vn'),
(101, 'DHTT009', 'Nguyễn Văn Thao', 'Nhân viên', '0943111168', 1, 7, 0, '', 'thaonv.qnm@vnpt.vn'),
(102, 'DHTT010', 'Huỳnh Đạo Thiện', 'Trưởng đài', '0917467555', 1, 7, 0, '', 'thienhd.qnm@vnpt.vn'),
(103, 'DHTT011', 'Trương Duy Tuấn', 'Nhân viên', '0918973232', 1, 7, 0, '', 'tuantd.qnm@vnpt.vn'),
(104, 'DHTT012', 'Huỳnh Ngọc Việt', 'Nhân viên', '0942007089', 1, 7, 0, '', 'viethn.qnm@vnpt.vn'),
(105, 'PNH005', 'Lê Tấn Triều', 'Quản lý trạm', '0914947557', 4, 1, 1, '', 'trieult.qnm@vnpt.vn'),
(106, 'TKY007', 'Trần Tân Thiên', 'Quản lý trạm', ' 0949321125', 4, 1, 1, '', 'thientt.qnm@vnpt.vn');

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
(4, 'MANG', 'Nhóm thiết bị về mạng');

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
('101', 1, 'Mã 101 abc abc abc acbaa abc abc abc acbaa abc abc abc acbaa '),
('102', 1, 'Mã 102 abc abc abc acbaa abc abc abc acbaa abc abc abc acbaa abc abc abc acbaa abc abc abc acbaa '),
('103', 1, 'Mã 103'),
('104', 1, 'Mã 104'),
('201', 2, 'Mã 201'),
('202', 2, 'Mã 202'),
('203', 2, 'Mã 203 abc abc abc acbaa abc abc abc acbaa abc abc abc acbaa '),
('301', 3, 'Mã 301'),
('302', 3, 'Mã 302');

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
(2, 'Operators', 'Can add or update some devices'),
(3, 'Viewers', 'Only view info');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userlog`
--

CREATE TABLE `tbl_userlog` (
  `ID_USERLOG` int(11) NOT NULL,
  `DATE_LOG` date NOT NULL,
  `ACTION_LOG` varchar(100) NOT NULL,
  `USER_ACC` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'DH LG', 'Điều hòa LG Inverter...', 3, 'LG', 'Điều hòa abc xyzznsdfkasdm', 'Nguồn dfasdfnsndn');

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
(1, 1, 1, '1231212', '2017-05-10', '2017-10-10', 1, '2017-10-20', NULL),
(2, 2, 1, '1231ad12121', '2017-05-10', '2017-10-01', 2, '2017-10-20', NULL),
(3, 2, 2, '312312efs', '2017-05-10', '2017-10-10', 1, '2017-10-20', NULL),
(4, 3, 2, '24451211NBBBB', '2017-05-10', '2017-10-01', 2, '2017-10-25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thuchienbd`
--

CREATE TABLE `thuchienbd` (
  `ID_DOTBD` int(11) NOT NULL,
  `ID_THIETBI` int(11) NOT NULL,
  `MA_NOIDUNG` varchar(32) NOT NULL,
  `NOIDUNGMORONG` varchar(255) DEFAULT NULL,
  `KETQUA` varchar(32) DEFAULT 'Chưa hoàn thành',
  `GHICHU` varchar(255) DEFAULT NULL,
  `ID_NHANVIEN` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thuchienbd`
--

INSERT INTO `thuchienbd` (`ID_DOTBD`, `ID_THIETBI`, `MA_NOIDUNG`, `NOIDUNGMORONG`, `KETQUA`, `GHICHU`, `ID_NHANVIEN`) VALUES
(3, 3, '201', 'Không phát sinh', 'Đạt', '12', 9),
(3, 3, '202', NULL, 'Chưa đạt', 'Chưa đạt', 11),
(3, 3, '203', NULL, 'Chưa đạt', '123', 17),
(3, 4, '301', NULL, 'Đạt', NULL, 6),
(3, 4, '302', NULL, 'Đạt', NULL, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tramvt`
--

CREATE TABLE `tramvt` (
  `ID_TRAM` int(11) NOT NULL,
  `MA_TRAM` varchar(32) NOT NULL,
  `DIADIEM` varchar(255) DEFAULT NULL,
  `ID_DAIVT` int(11) DEFAULT NULL,
  `ID_NHANVIEN` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tramvt`
--

INSERT INTO `tramvt` (`ID_TRAM`, `MA_TRAM`, `DIADIEM`, `ID_DAIVT`, `ID_NHANVIEN`) VALUES
(1, 'TKY-001', 'Tam Kỳ', 1, 6),
(2, 'NT-001', 'Núi Thành', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `role`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'uGB7E0DTPhSfyQpVaVaGcTuI7umlteNl', '$2y$13$G4DAdK2cuMree4HEFvtpiOLm5/rvYkazpowx.5cFMqByWtw9w/eA.', NULL, 1, 'anlh.qnm@vnpt.vn', 10, 1506495817, 1512980189),
(2, 'noname', '', '$2y$13$IeUCU8CxXrfFguAeLwRxUe1aVXYsbhuKoydUX2lbhtcahWT0NDfui', NULL, NULL, 'noname@gmail.com', 10, 1506498107, 1507692371),
(3, 'dinhchau2603', 'JJEJ8_4qxauIvqy8xMHYUf8swwCKpXOb', '$2y$13$IeUCU8CxXrfFguAeLwRxUe1aVXYsbhuKoydUX2lbhtcahWT0NDfui', NULL, 1, 'dinhchau2603@gmail.com', 10, 1506498107, 1508723075),
(4, 'user02', 'Cj9STRuuy1idcdTTaq4eBrNQGsGuN1jM', '$2y$13$vhThpvJJZqHtTZNZVBzjueZVkHru8Mp21iWPhjQ.6MLdyBPipXskW', NULL, NULL, 'user02@gmail.com', 10, 1507177087, 1507520411),
(5, 'demo', 'wx8O7XjCqVnKz_rSwktSLNp0uweKOTiF', '$2y$13$5TmXJdAnrtRREZxNSASJsO08Q.TjmHFU3ecq3n7AThLehwEtZANiC', NULL, 2, 'demo12345@gmail.com', 10, 1507521569, 1508723036);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `auth_key` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `auth_key`, `superuser`, `status`, `create_at`, `lastvisit_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', 'c651162140fe82c1b04894fa81a6295a', 1, 1, '2016-08-01 02:05:36', '2017-08-21 02:57:47'),
(2, 'nguyenthanh', '21232f297a57a5a743894a0e4a801fc3', 'nguyenthanh99@gmail.com', 'f7fe7ae041948a1f4a85eda225803a24', 1, 1, '2016-07-31 21:23:29', '2017-10-15 06:29:51'),
(3, 'omc', 'e96db5ef49b13af51a1b8964c3b582ea', 'omc.qnm@vnpt.vn', '0cb292ea5177d3d7a6f15359ff9ea440', 0, 1, '2016-11-16 01:44:35', '2017-08-21 22:58:07'),
(4, 'linhtv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'linhtv.qnm@vnpt.vn', 'ff78561370e345f9bdf768dc5535e42b', 0, 1, '2017-08-09 20:10:04', '2017-08-15 23:43:58'),
(5, 'sandv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'sandv.qnm@vnpt.vn', 'c26b37ae01b0066d4cc5a1a2aa9fcb4d', 2, 1, '2017-08-16 08:18:40', '2017-08-16 08:18:40'),
(6, 'trungld.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'trungld.qnm@vnpt.vn', '9de159a60c7d6e2d001ec3a34cb3efb1', 2, 1, '2017-08-16 08:19:35', '2017-08-16 08:19:35'),
(7, 'thaoptp.qnm@vnpt.vn', '57364962a488c85443c34c0d7008ccf1', 'thaoptp.qnm@vnpt.vn', '8b1003f68bbc2adb3ed3f15879ab0f96', 0, 1, '2017-08-16 08:20:05', '2017-08-30 03:36:50'),
(8, 'hieplt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hieplt.qnm@vnpt.vn', 'cd4f22399e327619dde394f9a0cdba96', 0, 1, '2017-08-16 08:20:28', '2017-08-16 08:20:28'),
(9, 'tunglv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tunglv.qnm@vnpt.vn', 'ccd74711230cd51d7e2ca0adb0325d70', 0, 1, '2017-08-16 08:21:11', '2017-08-16 08:21:11'),
(10, 'daolv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'daolv.qnm@vnpt.vn', 'c0760109f0e8f88e937d5741a3a4136d', 0, 1, '2017-08-16 08:21:34', '2017-08-16 08:21:34'),
(11, 'longpt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'longpt.qnm@vnpt.vn', '06bf2cf17f68db24b71b1ef88709c6c9', 2, 1, '2017-08-16 08:24:28', '2017-08-16 08:24:28'),
(12, 'hoangtn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hoangtn.qnm@vnpt.vn', '21c415f6adcae7dfa6560a8e35b58c8d', 0, 1, '2017-08-16 08:24:57', '2017-08-16 08:24:57'),
(13, 'namtn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'namtn.qnm@vnpt.vn', 'ced4609b6102082c952e6923ebf9f2ec', 2, 1, '2017-08-16 08:25:34', '2017-08-16 08:25:34'),
(14, 'tiennv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tiennv.qnm@vnpt.vn', '07bfeb236f0336d1e9774843918fe379', 2, 1, '2017-08-16 08:26:00', '2017-08-16 08:26:00'),
(15, 'anlh.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'anlh.qnm@vnpt.vn', '0f8cec05d14758a48ea6f6c270670507', 0, 1, '2017-08-16 08:26:32', '2017-08-16 08:26:32'),
(16, 'linhpn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'linhpn.qnm@vnpt.vn', '95b6ce4496f3c7deec968a882622c74f', 0, 1, '2017-08-16 08:26:59', '2017-08-16 08:26:59'),
(17, 'longnd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'longnd.qnm@vnpt.vn', 'f631ace6f70565eae390d17172defac7', 2, 1, '2017-08-16 08:27:34', '2017-08-16 08:27:34'),
(18, 'phuongth.qnm@vnpt.vn', '83d92293702de7731cba17d1d280ff28', 'phuongth.qnm@vnpt.vn', '2951406cc16373c9f5c4c8cd320e13f4', 0, 1, '2017-08-17 00:13:54', '2017-08-20 04:41:47'),
(19, 'hoapt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hoapt.qnm@vnpt.vn', 'b7aa47c5c8e660d16b2589d0eb2e0a5b', 2, 1, '2017-10-10 08:42:32', '2017-10-10 08:42:32'),
(20, 'phuocnv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'phuocnv.qnm@vnpt.vn', 'efc576639c951700d8229ae051e7ac9a', 2, 1, '2017-10-10 08:43:25', '2017-10-10 08:43:25'),
(21, 'nhantn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'nhantn.qnm@vnpt.vn', '3b4d69eee428ddc378cce04456ceca77', 2, 1, '2017-10-10 08:44:13', '2017-10-10 08:44:13'),
(22, 'tienpn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tienpn.qnm@vnpt.vn', 'dcf666319761bdd62acaf6ac7f6238f1', 2, 1, '2017-10-10 08:45:21', '2017-10-10 08:45:21'),
(23, 'trongvd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'trongvd.qnm@vnpt.vn', '2dcdaa2c092bd2461bfba637356df345', 2, 1, '2017-10-10 08:46:24', '2017-10-10 08:46:24'),
(24, 'thanhht.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thanhht.qnm@vnpt.vn', 'cb3279ce7b20a52881d23b3faaecb589', 2, 1, '2017-10-10 08:47:09', '2017-10-10 08:47:09'),
(25, 'hungnh.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hungnh.qnm@vnpt.vn', '9e213a1482a16858ae4b3439a9c58cbd', 0, 1, '2017-10-10 08:47:45', '2017-10-10 08:47:45'),
(26, 'suonghh.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'suonghh.qnm@vnpt.vn', 'f79741249a5cb6f5f175588f3c447a8d', 2, 1, '2017-10-10 08:48:35', '2017-10-10 08:48:35'),
(27, 'annd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'annd.qnm@vnpt.vn', '3510a0b817ad2621f8d5c45dc11874ea', 2, 1, '2017-10-10 08:49:21', '2017-10-10 08:49:21'),
(28, 'hungnv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hungnv.qnm@vnpt.vn', 'f0529f2e5ba0693e1c6c668bf4d94b52', 2, 1, '2017-10-10 08:50:20', '2017-10-10 08:50:20'),
(29, 'quanghv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'quanghv.qnm@vnpt.vn', '4bfbf5cc2365794f59cf143c59e970e9', 2, 1, '2017-10-10 08:50:51', '2017-10-10 08:50:51'),
(30, 'chanhnc.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'chanhnc.qnm@vnpt.vn', 'd2f78e68669230251ef713287878a463', 0, 1, '2017-10-10 08:53:29', '2017-10-10 08:53:29'),
(31, 'cuonglc.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'cuonglc.qnm@vnpt.vn', 'cb4f108e4df0d95ff112ba6cb9058f08', 0, 1, '2017-10-10 08:54:10', '2017-10-10 08:54:10'),
(32, 'dungpv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'dungpv.qnm@vnpt.vn', 'e9e206fea30a6540b7ed345574e831ef', 0, 1, '2017-10-10 08:54:40', '2017-10-10 08:54:40'),
(33, 'hiennt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hiennt.qnm@vnpt.vn', 'c3cc76e051a49e7153da46437c5aa751', 0, 1, '2017-10-10 08:55:13', '2017-10-10 08:55:13'),
(34, 'phutn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'phutn.qnm@vnpt.vn', '2a5596dd97cb1e7091950dc6fa534c30', 0, 1, '2017-10-10 08:55:48', '2017-10-10 08:55:48'),
(35, 'sontt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'sontt.qnm@vnpt.vn', '03446384b9fcb85478c7d7554214e4ee', 0, 1, '2017-10-10 08:56:28', '2017-10-10 08:56:28'),
(36, 'senptm.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'senptm.qnm@vnpt.vn', 'be4da0999e36976b6e1e81e480bd2140', 0, 1, '2017-10-10 08:57:01', '2017-10-10 08:57:01'),
(37, 'thucdm.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thucdm.qnm@vnpt.vn', 'a1dbaa2fd8fc85165bddd30f9b76b57f', 0, 1, '2017-10-10 08:57:33', '2017-10-10 08:57:33'),
(38, 'thaonv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thaonv.qnm@vnpt.vn', 'd8e147c9741ee252c6782d75ed41215f', 0, 1, '2017-10-10 08:58:10', '2017-10-10 08:58:10'),
(39, 'thienhd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thienhd.qnm@vnpt.vn', 'a963a8ca484e61497353d1522aafa265', 0, 1, '2017-10-10 08:58:46', '2017-10-10 08:58:46'),
(40, 'tuantd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tuantd.qnm@vnpt.vn', 'd44f2e6815ce1265501365c4d3e4e56e', 0, 1, '2017-10-10 08:59:24', '2017-10-10 08:59:24'),
(41, 'vietnh.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'vietnh.qnm@vnpt.vn', 'a357fee6f5973bc280a0bc5cc3308c90', 0, 1, '2017-10-10 08:59:55', '2017-10-10 08:59:55'),
(42, 'thucdc.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thucdc.qnm@vnpt.vn', '3a8bf2b15d2c61b2c7a419db2bc985ce', 2, 1, '2017-10-11 02:44:45', '2017-10-11 02:44:45'),
(43, 'trongnb.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'trongnb.qnm@vnpt.vn', '84875698033840a2b66c0050c9919c29', 2, 1, '2017-10-11 02:45:28', '2017-10-11 02:45:28'),
(44, 'tuanba.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tuanba.qnm@vnpt.vn', 'b8484050bb4a0eb49acc95fa6da13f7e', 2, 1, '2017-10-11 02:46:00', '2017-10-11 02:46:00'),
(45, 'thuonglv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thuonglv.qnm@vnpt.vn', 'ffecb1c987c3261b748540575516657a', 2, 1, '2017-10-11 03:11:35', '2017-10-11 03:11:35'),
(46, 'dinhlt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'dinhlt.qnm@vnpt.vn', 'e5c0ae3366f5d26afce226f88d77907b', 2, 1, '2017-10-11 03:22:04', '2017-10-11 03:22:04'),
(47, 'sangld.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'sangld.qnm@vnpt.vn', '19f5ea07200af3c286b3cdafc19b5c23', 2, 1, '2017-10-11 03:22:34', '2017-10-11 03:22:34'),
(48, 'vietlt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'vietlt.qnm@vnpt.vn', '5ab05cd62bc3187dc51424f5257e1461', 2, 1, '2017-10-11 03:24:35', '2017-10-11 03:24:35'),
(49, 'dunghv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'dunghv.qnm@vnpt.vn', 'f2b4f257256f44f86ddf290028ab9949', 2, 1, '2017-10-11 03:26:34', '2017-10-11 03:26:34'),
(50, 'thuongnt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thuongnt.qnm@vnpt.vn', '24fdd20a2cb607bf2190c0d189012ae1', 2, 1, '2017-10-11 03:27:03', '2017-10-11 03:27:03'),
(51, 'thanhnn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thanhnn.qnm@vnpt.vn', '9b0ec752b3c747a7c26e85280c27cf32', 2, 1, '2017-10-11 03:27:35', '2017-10-11 03:27:35'),
(52, 'khanhlv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'khanhlv.qnm@vnpt.vn', '035055eb04ac38d3d951e5e8bd7d15c3', 2, 1, '2017-10-11 03:29:07', '2017-10-11 03:29:07'),
(53, 'hungtv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hungtv.qnm@vnpt.vn', '17bcdde1799372560a614b857661deb0', 2, 1, '2017-10-11 03:33:03', '2017-10-11 03:33:03'),
(54, 'quocnv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'quocnv.qnm@vnpt.vn', '0d71492e31cd0f10eae6a0fd2aedac0f', 2, 1, '2017-10-11 03:33:26', '2017-10-11 03:33:26'),
(55, 'haitd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'haitd.qnm@vnpt.vn', '36a441716ad00743022c01bb8812259c', 2, 1, '2017-10-11 03:33:52', '2017-10-11 03:33:52'),
(56, 'xuattc.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'xuattc.qnm@vnpt.vn', '96e6ae4178f8bf579cf0c8b47a5cccab', 2, 1, '2017-10-12 07:15:06', '2017-10-12 07:15:06'),
(57, 'phuonghb.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'phuonghb.qnm@vnpt.vn', '579be9b7722e4a61c173f5170822abfa', 2, 1, '2017-10-12 07:15:49', '2017-10-12 07:15:49'),
(58, 'baoph.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'baoph.qnm@vnpt.vn', 'ebcb99e093be41c31d4d7ff0e169b6b4', 2, 1, '2017-10-12 07:16:43', '2017-10-12 07:16:43'),
(59, 'lamvv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'lamvv.qnm@vnpt.vn', '33f753db8e16c3a93d5dd4397f98cf2e', 2, 1, '2017-10-12 07:17:17', '2017-10-12 07:17:17'),
(60, 'traipv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'traipv.qnm@vnpt.vn', '8de4ea1078c7f614350648f8182f6720', 2, 1, '2017-10-13 06:39:06', '2017-10-13 06:39:06'),
(61, 'hieupv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hieupv.qnm@vnpt.vn', '70754258f34a116749030059702e1850', 2, 1, '2017-10-13 06:39:39', '2017-10-13 06:39:39'),
(62, 'huynk.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'huynk.qnm@vnpt.vn', 'baf7575ece1f934a8c95a2fb4cbda208', 2, 1, '2017-10-13 06:40:30', '2017-10-13 06:40:30'),
(63, 'tuandm.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tuandm.qnm@vnpt.vn', 'ab21f31fe135fa968b48a7575627711c', 2, 1, '2017-10-13 06:41:02', '2017-10-13 06:41:02'),
(64, 'quangvt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'quangvt.qnm@vnpt.vn', '5b8f5e0bcb654bab56dcbff3166ede23', 2, 1, '2017-10-13 06:41:48', '2017-10-13 06:41:48'),
(65, 'loit.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'loit.qnm@vnpt.vn', 'bcf4ffc5c3e92a3c9f5a27679bae0d18', 2, 1, '2017-10-13 06:42:27', '2017-10-13 06:42:27'),
(66, 'trieult.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'trieult.qnm@vnpt.vn', '276acc13f34e17126eea979c350d988c', 2, 1, '2017-10-13 06:43:12', '2017-10-13 06:43:12'),
(67, 'thientt.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'thientt.qnm@vnpt.vn', 'c6953233eba830f821592fc90f4757b4', 2, 1, '2017-10-13 06:44:09', '2017-10-13 06:44:09'),
(68, 'piclient.qnm@vnpt.vn', '740d5b8e02e86c0845d54f55c5e87f7a', 'piclient.qnm@vnpt.vn', '069768fc272beb14be4c3719b589b6d6', 0, 1, '2017-10-15 06:02:05', '2017-10-15 06:02:05'),
(69, 'vutn.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'vutn.qnm@vnpt.vn', 'dba65b6f64f2f3006f45104ee8cdebc1', 2, 1, '2017-10-15 08:08:50', '2017-10-15 08:08:50'),
(70, 'toannq.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'toannq.qnm@vnpt.vn', '671cfbe4b57e35066f6511454f79253c', 2, 1, '2017-10-15 08:09:23', '2017-10-15 08:09:23'),
(71, 'sonht.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'sonht.qnm@vnpt.vn', 'b7fd3e5df86b14378b09c709c1da76d2', 2, 1, '2017-10-15 08:10:04', '2017-10-15 08:10:04'),
(72, 'hoatv.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'hoatv.qnm@vnpt.vn', '4b6b8421cba6b6cfdb115979eea13dba', 2, 1, '2017-10-15 08:10:35', '2017-10-15 08:10:35'),
(73, 'tamnd.qnm@vnpt.vn', 'e99a18c428cb38d5f260853678922e03', 'tamnd.qnm@vnpt.vn', '9f0b744e4cc7d7e77d67252cb57d1f9a', 2, 1, '2017-10-15 08:11:10', '2017-10-15 08:11:10');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`ID_LOAITB`,`LAN_BD`,`MA_NOIDUNG`),
  ADD KEY `FK_ND_DX` (`MA_NOIDUNG`);

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
-- Indexes for table `kehoachbdtb`
--
ALTER TABLE `kehoachbdtb`
  ADD PRIMARY KEY (`ID_DOTBD`,`ID_THIETBI`,`MA_NOIDUNG`),
  ADD KEY `ID_BAOTRI` (`ID_DOTBD`),
  ADD KEY `ID_NHANVIEN_BD` (`ID_NHANVIEN`),
  ADD KEY `FK_THIETBIBD` (`ID_THIETBI`),
  ADD KEY `MA_NOIDUNG` (`MA_NOIDUNG`);

--
-- Indexes for table `ketqua`
--
ALTER TABLE `ketqua`
  ADD PRIMARY KEY (`ID_DOTBD`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`ID_NHANVIEN`),
  ADD UNIQUE KEY `UNIQUE` (`MA_NHANVIEN`),
  ADD KEY `FK_NVDONVI` (`ID_DONVI`),
  ADD KEY `FK_NVDAI` (`ID_DAI`);

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
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_userlog`
--
ALTER TABLE `tbl_userlog`
  ADD PRIMARY KEY (`ID_USERLOG`);

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
  ADD KEY `FK_THIETBI-TRAM` (`ID_TRAM`),
  ADD KEY `FK_LOAITBI` (`ID_LOAITB`);

--
-- Indexes for table `thuchienbd`
--
ALTER TABLE `thuchienbd`
  ADD PRIMARY KEY (`ID_DOTBD`,`ID_THIETBI`,`MA_NOIDUNG`),
  ADD KEY `FK_NV-THBD` (`ID_NHANVIEN`),
  ADD KEY `FK_THIEBI_BD` (`ID_THIETBI`),
  ADD KEY `FK_MAND_BD` (`MA_NOIDUNG`);

--
-- Indexes for table `tramvt`
--
ALTER TABLE `tramvt`
  ADD PRIMARY KEY (`ID_TRAM`),
  ADD KEY `FK_TRAM-DAI` (`ID_DAIVT`),
  ADD KEY `FK_TRAM-NHANVIEN` (`ID_NHANVIEN`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `fk_role` (`role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username` (`username`),
  ADD UNIQUE KEY `user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daivt`
--
ALTER TABLE `daivt`
  MODIFY `ID_DAI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `dotbaoduong`
--
ALTER TABLE `dotbaoduong`
  MODIFY `ID_DOTBD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `ID_NHANVIEN` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT for table `nhomtbi`
--
ALTER TABLE `nhomtbi`
  MODIFY `ID_NHOM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_userlog`
--
ALTER TABLE `tbl_userlog`
  MODIFY `ID_USERLOG` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `ID_THIETBI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `thietbitram`
--
ALTER TABLE `thietbitram`
  MODIFY `ID_THIETBI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tramvt`
--
ALTER TABLE `tramvt`
  MODIFY `ID_TRAM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `daivt`
--
ALTER TABLE `daivt`
  ADD CONSTRAINT `FK_DAIVT` FOREIGN KEY (`ID_DONVI`) REFERENCES `donvi` (`ID_DONVI`);

--
-- Constraints for table `dexuatnoidung`
--
ALTER TABLE `dexuatnoidung`
  ADD CONSTRAINT `FK_ND_DX` FOREIGN KEY (`MA_NOIDUNG`) REFERENCES `noidungbaotri` (`MA_NOIDUNG`),
  ADD CONSTRAINT `FK_TBINOIDUNG` FOREIGN KEY (`ID_LOAITB`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donvi`
--
ALTER TABLE `donvi`
  ADD CONSTRAINT `FK_DONVI` FOREIGN KEY (`CAP_TREN`) REFERENCES `donvi` (`ID_DONVI`);

--
-- Constraints for table `dotbaoduong`
--
ALTER TABLE `dotbaoduong`
  ADD CONSTRAINT `FK_TRAM_BD` FOREIGN KEY (`ID_TRAMVT`) REFERENCES `tramvt` (`ID_TRAM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRUONGNHOM` FOREIGN KEY (`TRUONG_NHOM`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kehoachbdtb`
--
ALTER TABLE `kehoachbdtb`
  ADD CONSTRAINT `FK_THIETBIBD` FOREIGN KEY (`ID_THIETBI`) REFERENCES `thietbitram` (`ID_THIETBI`),
  ADD CONSTRAINT `ID_DOTBD` FOREIGN KEY (`ID_DOTBD`) REFERENCES `dotbaoduong` (`ID_DOTBD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_NHANVIEN_BD` FOREIGN KEY (`ID_NHANVIEN`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ketqua`
--
ALTER TABLE `ketqua`
  ADD CONSTRAINT `FK_IDDOTBD` FOREIGN KEY (`ID_DOTBD`) REFERENCES `dotbaoduong` (`ID_DOTBD`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `FK_NVDAI` FOREIGN KEY (`ID_DAI`) REFERENCES `daivt` (`ID_DAI`),
  ADD CONSTRAINT `FK_NVDONVI` FOREIGN KEY (`ID_DONVI`) REFERENCES `donvi` (`ID_DONVI`);

--
-- Constraints for table `noidungbaotri`
--
ALTER TABLE `noidungbaotri`
  ADD CONSTRAINT `FK_TBI_ND` FOREIGN KEY (`ID_THIETBI`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `FK_NHOMTBI` FOREIGN KEY (`ID_NHOMTB`) REFERENCES `nhomtbi` (`ID_NHOM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thietbitram`
--
ALTER TABLE `thietbitram`
  ADD CONSTRAINT `FK_LOAITBI` FOREIGN KEY (`ID_LOAITB`) REFERENCES `thietbi` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_THIETBI-TRAM` FOREIGN KEY (`ID_TRAM`) REFERENCES `tramvt` (`ID_TRAM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thuchienbd`
--
ALTER TABLE `thuchienbd`
  ADD CONSTRAINT `FK_DOT_THBD` FOREIGN KEY (`ID_DOTBD`) REFERENCES `dotbaoduong` (`ID_DOTBD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MAND_BD` FOREIGN KEY (`MA_NOIDUNG`) REFERENCES `noidungbaotri` (`MA_NOIDUNG`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_NV-THBD` FOREIGN KEY (`ID_NHANVIEN`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_THIEBI_BD` FOREIGN KEY (`ID_THIETBI`) REFERENCES `thietbitram` (`ID_THIETBI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tramvt`
--
ALTER TABLE `tramvt`
  ADD CONSTRAINT `FK_TRAM-DAI` FOREIGN KEY (`ID_DAIVT`) REFERENCES `daivt` (`ID_DAI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRAM-NHANVIEN` FOREIGN KEY (`ID_NHANVIEN`) REFERENCES `nhanvien` (`ID_NHANVIEN`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
