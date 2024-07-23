DROP TABLE IF EXISTS `journaldetil`;
CREATE TABLE `journaldetil` (
  `JournalID` int NOT NULL,
  `IndexValue` tinyint NOT NULL,
  `RekId` int NOT NULL,
  `DebitAcc` bit(1) DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  `Remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`JournalID`,`IndexValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
