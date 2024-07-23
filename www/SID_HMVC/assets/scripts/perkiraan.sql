DROP TABLE IF EXISTS `perkiraan`;
CREATE TABLE `perkiraan` (
  `rekid` int NOT NULL AUTO_INCREMENT,
  `parentkey` varchar(20) NOT NULL,
  `keyvalue` varchar(20) NOT NULL,
  `accountno` varchar(20) DEFAULT NULL,
  `description` varchar(60) DEFAULT NULL,
  `groupacc` tinyint DEFAULT NULL,
  `classacc` tinyint DEFAULT NULL,
  `levelacc` tinyint DEFAULT NULL,
  `balancesheetacc` bit(1) DEFAULT NULL,
  `debitacc` bit(1) DEFAULT NULL,
  `openingbalance` float DEFAULT (0),
  `transbalance` float DEFAULT (0),
  `akunanak` varchar(20) DEFAULT NULL,
  `akuninduk` varchar(20) DEFAULT NULL,
  `bankcode` char(3) DEFAULT NULL,
  `balancedue` float DEFAULT(0),
  PRIMARY KEY (`rekid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
