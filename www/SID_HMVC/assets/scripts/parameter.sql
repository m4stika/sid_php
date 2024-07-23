DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
  `id` INT NOT NULL AUTO_INCREMENT,	
  `company` varchar(40) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(40) NOT NULL,
  `bulanbuku` char(2) NOT NULL,
  `tahunbuku` char(4) NOT NULL,
  `kasir` varchar(40) NOT NULL,
  `kasirtitle` varchar(40) NOT NULL,
  `accounting` varchar(40) NOT NULL,
  `accountingtitle` varchar(40) NOT NULL,
  `pimpinan` varchar(40) NOT NULL,
  `pimpinantitle` varchar(40) NOT NULL,
  PRIMARY KEY (id)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
