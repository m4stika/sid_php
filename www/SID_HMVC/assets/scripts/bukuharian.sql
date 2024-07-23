DROP TABLE IF EXISTS `bukuharian`;
CREATE TABLE `bukuharian` (
  `noid` int NOT NULL AUTO_INCREMENT,
  `rekid` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `saldoawal` float DEFAULT NULL,
  `mutasidebet` float DEFAULT NULL,
  `mutasikredit` float DEFAULT NULL,
  `saldoakhir` float DEFAULT NULL,
  PRIMARY KEY (`noid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
