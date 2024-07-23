DROP TABLE IF EXISTS `bukubesar`;
CREATE TABLE `bukubesar` (
  `noid` int NOT NULL AUTO_INCREMENT,
  `bulanbuku` smallint DEFAULT NULL,
  `tahunbuku` smallint DEFAULT NULL,
  `rekid` int DEFAULT NULL,
  `saldoawal` decimal(15,2) DEFAULT NULL,
  `mutasidebet` decimal(15,2) DEFAULT NULL,
  `mutasikredit` decimal(15,2) DEFAULT NULL,
  `saldoakhir` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`noid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
