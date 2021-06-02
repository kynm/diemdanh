ALTER TABLE tramvt ADD COLUMN type_payment_id int(11) DEFAULT 1
DROP TABLE IF EXISTS `type_payments`;
CREATE TABLE IF NOT EXISTS `type_payments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type_payment` varchar(64) NOT NULL,
  `GHI_CHU` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `type_payments`
--

INSERT INTO `type_payments` (`ID`, `type_payment`, `GHI_CHU`) VALUES
(1, 'Trả toàn bộ', 'Trả toàn bộ'),
(2, 'Trả một phần', 'Trả một phần');