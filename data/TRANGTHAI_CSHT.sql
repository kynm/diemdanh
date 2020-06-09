CREATE TABLE `TRANGTHAI_CSHT` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `TEN_TRANGTHAI_CSHT` varchar(64) NOT NULL,
 `GHI_CHU` varchar(64) NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

LOCK TABLES `TRANGTHAI_CSHT` WRITE;
INSERT INTO `TRANGTHAI_CSHT` 
VALUES (1,'Đang hoạt động','Đang hoạt động'),
(2,'Ngừng hoạt động','Ngừng hoạt động nhưng còn thiết bị'),
(3,'Chấm dứt hoạt động','Thanh lý hủy bỏ CSHT');
UNLOCK TABLES;

CREATE TABLE `LOAIHINH_CSHT` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `TEN_LOAIHINH_CSHT` varchar(64) NOT NULL,
 `GHI_CHU` varchar(64) NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

LOCK TABLES `LOAIHINH_CSHT` WRITE;
INSERT INTO `LOAIHINH_CSHT` 
VALUES (1,'Đầu tư trên đất VNPT','Đầu tư trên đất VNPT'),
(2,'Đầu tư trên đất thuê','Đầu tư trên đất thuê'),
(3,'Thuê xã hội hóa','Thuê xã hội hóa'),
(4,'Trao đổi hạ tầng Viettel','Trao đổi hạ tầng Viettel'),
(5,'Trao đổi hạ tầng Mobifone','Trao đổi hạ tầng Mobifone'),
(6,'Trao đổi hạ tầng VietnamMobile','Trao đổi hạ tầng VietnamMobile'),
(7,'Trao đổi hạ tầng Gtel','Trao đổi hạ tầng Gtel'),
(8,'Hình thức khác','Hình thức khác');
UNLOCK TABLES;

CREATE TABLE `KIEU_CSHT` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `TEN_KIEU_CSHT` varchar(64) NOT NULL,
 `GHI_CHU` varchar(64) NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

LOCK TABLES `KIEU_CSHT` WRITE;
INSERT INTO `KIEU_CSHT` 
VALUES (1,'Macro truyền thống','Macro truyền thống'),
(2,'Macro Outdoor Cabinet','Macro Outdoor Cabinet'),
(3,'RemoteSector','RemoteSector'),
(4,'SmallCell','SmallCell'),
(5,'IBS tòa nhà','IBS tòa nhà'),
(6,'CSHT không phát sóng di động','CSHT không phát sóng di động'),
(7,'MXU Outdoor','MXU Outdoor');
UNLOCK TABLES;

CREATE TABLE `TRANGTHAI_HDMD` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `TEN_TRANGTHAI_HDMD` varchar(64) NOT NULL,
 `GHI_CHU` varchar(64) NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
LOCK TABLES `TRANGTHAI_HDMD` WRITE;
INSERT INTO `TRANGTHAI_HDMD` 
VALUES (1,'Đang hoạt động','Đang hoạt động'),
(2,'Tạm dừng hoạt động','Tạm dừng hoạt động'),
(3,'Thanh lý hợp đồng','Thanh lý hợp đồng');
UNLOCK TABLES;