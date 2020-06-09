-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3308
-- Thời gian đã tạo: Th6 09, 2020 lúc 10:23 AM
-- Phiên bản máy phục vụ: 5.7.26
-- Phiên bản PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vnpt_mds`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kieu_csht`
--

DROP TABLE IF EXISTS `kieu_csht`;
CREATE TABLE IF NOT EXISTS `kieu_csht` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEN_KIEU_CSHT` varchar(64) NOT NULL,
  `GHI_CHU` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `kieu_csht`
--

INSERT INTO `kieu_csht` (`ID`, `TEN_KIEU_CSHT`, `GHI_CHU`) VALUES
(1, 'Macro truyền thống', 'Macro truyền thống'),
(2, 'Macro Outdoor Cabinet', 'Macro Outdoor Cabinet'),
(3, 'RemoteSector', 'RemoteSector'),
(4, 'SmallCell', 'SmallCell'),
(5, 'IBS tòa nhà', 'IBS tòa nhà'),
(6, 'CSHT không phát sóng di động', 'CSHT không phát sóng di động'),
(7, 'MXU Outdoor', 'MXU Outdoor');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaihinh_csht`
--

DROP TABLE IF EXISTS `loaihinh_csht`;
CREATE TABLE IF NOT EXISTS `loaihinh_csht` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEN_LOAIHINH_CSHT` varchar(64) NOT NULL,
  `GHI_CHU` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loaihinh_csht`
--

INSERT INTO `loaihinh_csht` (`ID`, `TEN_LOAIHINH_CSHT`, `GHI_CHU`) VALUES
(1, 'Đầu tư trên đất VNPT', 'Đầu tư trên đất VNPT'),
(2, 'Đầu tư trên đất thuê', 'Đầu tư trên đất thuê'),
(3, 'Thuê xã hội hóa', 'Thuê xã hội hóa'),
(4, 'Trao đổi hạ tầng Viettel', 'Trao đổi hạ tầng Viettel'),
(5, 'Trao đổi hạ tầng Mobifone', 'Trao đổi hạ tầng Mobifone'),
(6, 'Trao đổi hạ tầng VietnamMobile', 'Trao đổi hạ tầng VietnamMobile'),
(7, 'Trao đổi hạ tầng Gtel', 'Trao đổi hạ tầng Gtel'),
(8, 'Hình thức khác', 'Hình thức khác');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai_csht`
--

DROP TABLE IF EXISTS `trangthai_csht`;
CREATE TABLE IF NOT EXISTS `trangthai_csht` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEN_TRANGTHAI_CSHT` varchar(64) NOT NULL,
  `GHI_CHU` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `trangthai_csht`
--

INSERT INTO `trangthai_csht` (`ID`, `TEN_TRANGTHAI_CSHT`, `GHI_CHU`) VALUES
(1, 'Đang hoạt động', 'Đang hoạt động'),
(2, 'Ngừng hoạt động', 'Ngừng hoạt động nhưng còn thiết bị'),
(3, 'Chấm dứt hoạt động', 'Thanh lý hủy bỏ CSHT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai_hdmd`
--

DROP TABLE IF EXISTS `trangthai_hdmd`;
CREATE TABLE IF NOT EXISTS `trangthai_hdmd` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TEN_TRANGTHAI_HDMD` varchar(64) NOT NULL,
  `GHI_CHU` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `trangthai_hdmd`
--

INSERT INTO `trangthai_hdmd` (`ID`, `TEN_TRANGTHAI_HDMD`, `GHI_CHU`) VALUES
(1, 'Đang hoạt động', 'Đang hoạt động'),
(2, 'Tạm dừng hoạt động', 'Tạm dừng hoạt động'),
(3, 'Thanh lý hợp đồng', 'Thanh lý hợp đồng');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
