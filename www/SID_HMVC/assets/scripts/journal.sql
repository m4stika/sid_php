DROP TABLE IF EXISTS `journal`;
CREATE TABLE `journal` (
  `JournalID` int NOT NULL AUTO_INCREMENT,
  `Bulan` smallint DEFAULT NULL,
  `Tahun` smallint DEFAULT NULL,
  `JournalGroup` tinyint DEFAULT NULL,
  `AutoNum` int DEFAULT NULL,
  `JournalNo` varchar(10) DEFAULT NULL,
  `JournalDate` datetime DEFAULT NULL,
  `JournalRemark` varchar(180) DEFAULT NULL,
  `DueAmount` float DEFAULT NULL,
  `DateofPosting` datetime DEFAULT NULL,
  `Status` tinyint DEFAULT NULL,
  PRIMARY KEY (`JournalID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
