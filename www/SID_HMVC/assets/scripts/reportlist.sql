DROP TABLE IF EXISTS `reportlist`;
CREATE TABLE `reportlist` (
  `reportid` int NOT NULL AUTO_INCREMENT,
  `parentkey` varchar(20) NOT NULL,
  `keyvalue` varchar(20) NOT NULL,
  `reportname` varchar(40) DEFAULT NULL,
  `reportfilename` varchar(60) DEFAULT NULL,  
  `reportmodul` varchar(40) DEFAULT NULL,
  `showfilter` bit(1) NOT NULL DEFAULT(1), 
  `filterblth` bit(1) NOT NULL DEFAULT(0), 
  `filtertanggal` bit(1) NOT NULL DEFAULT(0), 
  `filterentry` bit(1) NOT NULL DEFAULT(0), 
  `filtergroupby` bit(1) NOT NULL DEFAULT(0), 
  `groupentry` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`reportid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
