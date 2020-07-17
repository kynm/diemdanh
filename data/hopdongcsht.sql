CREATE TABLE `hopdong_csht` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `ID_NHANVIEN` int(11) NOT NULL,
 `MA_CSHT` varchar(20) NOT NULL,
 `NGAYKY` DATE NOT NULL,
 `NGAY_BD` DATE NOT NULL,
 `NGAYKT` DATE NOT NULL,
 `TEN_VT` varchar(20) NOT NULL,
 `DIACHI` varchar(100) NOT NULL,
 `NGUOIDAIDIEN_A` varchar(50) NOT NULL,
 `NGUOIDAIDIEN_B` varchar(50) NOT NULL,
 `MA_HOPDONG` varchar(20) NOT NULL,
 `TEN_HOPDONG` varchar(50) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1423 DEFAULT CHARSET=utf8