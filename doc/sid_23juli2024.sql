-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: sid
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bukubesar`
--

DROP TABLE IF EXISTS `bukubesar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bukubesar`
--

LOCK TABLES `bukubesar` WRITE;
/*!40000 ALTER TABLE `bukubesar` DISABLE KEYS */;
INSERT INTO `bukubesar` VALUES (1,10,2023,1,0.00,0.00,0.00,0.00),(2,10,2023,14,0.00,15200000.00,0.00,15200000.00),(3,10,2023,11,0.00,15200000.00,0.00,15200000.00),(4,10,2023,9,0.00,15200000.00,0.00,15200000.00),(5,10,2023,2,0.00,15200000.00,0.00,15200000.00),(6,10,2023,18,0.00,12000000.00,0.00,12000000.00),(7,10,2023,17,0.00,12000000.00,0.00,12000000.00),(8,10,2023,16,0.00,12000000.00,0.00,12000000.00),(9,10,2023,8,0.00,12000000.00,0.00,12000000.00),(10,10,2023,25,0.00,0.00,3200000.00,3200000.00),(11,10,2023,23,0.00,0.00,3200000.00,3200000.00),(12,10,2023,22,0.00,0.00,3200000.00,3200000.00),(13,10,2023,6,0.00,0.00,3200000.00,3200000.00);
/*!40000 ALTER TABLE `bukubesar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bukuharian`
--

DROP TABLE IF EXISTS `bukuharian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bukuharian` (
  `noid` int NOT NULL AUTO_INCREMENT,
  `rekid` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `saldoawal` float DEFAULT NULL,
  `mutasidebet` float DEFAULT NULL,
  `mutasikredit` float DEFAULT NULL,
  `saldoakhir` float DEFAULT NULL,
  PRIMARY KEY (`noid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bukuharian`
--

LOCK TABLES `bukuharian` WRITE;
/*!40000 ALTER TABLE `bukuharian` DISABLE KEYS */;
INSERT INTO `bukuharian` VALUES (1,12,'2023-12-03 00:00:00',0,0,0,0),(2,13,'2023-12-03 00:00:00',0,0,0,0),(3,14,'2023-12-03 00:00:00',0,0,0,0),(4,15,'2023-12-03 00:00:00',0,0,0,0),(5,12,'2023-10-04 00:00:00',0,0,0,0),(6,13,'2023-10-04 00:00:00',0,0,0,0),(7,14,'2023-10-04 00:00:00',0,0,0,0),(8,15,'2023-10-04 00:00:00',0,0,0,0);
/*!40000 ALTER TABLE `bukuharian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('18a0a8c257dd5071ecaa48086a48ddca6036e662','172.21.0.1',1704112813,_binary '__ci_last_regenerate|i:1704112813;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('1f20805cf25524f5a05284dde5518e7d17719cb4','172.18.0.1',1703825982,_binary '__ci_last_regenerate|i:1703825977;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('41ffa6682f598eb4bb2319ef2371b4cbdd7055b4','172.18.0.1',1703388083,_binary '__ci_last_regenerate|i:1703388073;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('6e02c9c03eee93a43a5caf257927b350dcf12298','172.18.0.1',1703567645,_binary '__ci_last_regenerate|i:1703567591;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('a7942cef9686ca4f8256c2e107915dd297b4adfa','172.18.0.1',1703776216,_binary '__ci_last_regenerate|i:1703776204;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('b3f4771c9a9274102ee7d8a455fd345f21ca021f','172.21.0.1',1704247968,_binary '__ci_last_regenerate|i:1704247968;'),('ba4b2ebc2f535d4427d36632b666ce0fbb4f29eb','172.21.0.1',1704081940,_binary '__ci_last_regenerate|i:1704081924;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('bc34dfd0a25256d0abd10515b77e2720fe94a74d','172.21.0.1',1704081924,_binary '__ci_last_regenerate|i:1704081924;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('d29598a67349d6337986c7e5fdbb6a9ac8dd88e4','172.21.0.1',1704170282,_binary '__ci_last_regenerate|i:1704170277;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('d2b9a87b22151e15705b4f53850e82324286e664','172.21.0.1',1704112813,_binary '__ci_last_regenerate|i:1704112813;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('dc1f5cb230b6a40d7a076a6bd5eb53e4d591ee3d','172.18.0.1',1703776204,_binary '__ci_last_regenerate|i:1703776204;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;'),('e2051875dc3fed26fb6b71942cd486b23c3d108f','172.18.0.1',1702600759,_binary '__ci_last_regenerate|i:1702600715;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:7:\"Sawargi\";bulanbuku|s:2:\"10\";tahunbuku|s:4:\"2023\";kasir|s:4:\"nita\";accounting|s:4:\"desi\";pimpinan|s:7:\"mastika\";new_expiration|i:2592000;');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal`
--

LOCK TABLES `journal` WRITE;
/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
INSERT INTO `journal` VALUES (1,10,2023,1,1,'GJ-000001','2023-12-05 00:00:00','pembayaran gaji karyawan',12000000,'2023-12-05 00:00:00',4),(2,10,2023,1,2,'GJ-000002','2023-12-05 00:00:00','Pendapatan jasa',3200000,'2023-12-05 00:00:00',4),(3,10,2023,4,1,'CB-000001','2023-10-04 00:00:00','pengisian dana kas #2',8200000,'2023-12-07 00:00:00',0);
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journaldetil`
--

DROP TABLE IF EXISTS `journaldetil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journaldetil` (
  `JournalID` int NOT NULL,
  `IndexValue` tinyint NOT NULL,
  `RekId` int NOT NULL,
  `DebitAcc` bit(1) DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  `Remark` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`JournalID`,`IndexValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journaldetil`
--

LOCK TABLES `journaldetil` WRITE;
/*!40000 ALTER TABLE `journaldetil` DISABLE KEYS */;
INSERT INTO `journaldetil` VALUES (1,1,14,_binary '\0',12000000,'bayar gaji'),(1,2,18,_binary '',12000000,'bayar gaji'),(2,1,14,_binary '',3200000,'pendapatan jasa kunsultan'),(2,2,25,_binary '\0',3200000,'pendapatan jasa kunsultan'),(3,1,12,_binary '',8200000,'pengisian dana kas'),(3,2,13,_binary '',3200000,'penerimaan dari pimpinan cabang'),(3,3,12,_binary '',5000000,'penerimaan dari pusat');
/*!40000 ALTER TABLE `journaldetil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kasbank`
--

DROP TABLE IF EXISTS `kasbank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kasbank` (
  `noid` int NOT NULL AUTO_INCREMENT,
  `kasbanktype` tinyint DEFAULT NULL,
  `nokasbank` varchar(30) NOT NULL,
  `cabang` varchar(3) NOT NULL,
  `rekid` int NOT NULL,
  `nobukti` varchar(30) DEFAULT NULL,
  `nomorcek` varchar(30) DEFAULT NULL,
  `nojurnal` varchar(30) DEFAULT NULL,
  `tgltransaksi` datetime DEFAULT NULL,
  `tglentry` datetime DEFAULT NULL,
  `uraian` varchar(250) DEFAULT NULL,
  `totaltransaksi` float DEFAULT NULL,
  `statusverifikasi` tinyint DEFAULT NULL,
  PRIMARY KEY (`noid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kasbank`
--

LOCK TABLES `kasbank` WRITE;
/*!40000 ALTER TABLE `kasbank` DISABLE KEYS */;
INSERT INTO `kasbank` VALUES (1,2,'20231204/000001/BI','',14,'-','-','0001/-I/20231204','2023-12-03 00:00:00','2023-12-03 00:00:00','bayar gaji karyawan dan pimpinan',20000000,3),(2,0,'20231207/000002/KI','',12,'-','-','0001/-I/20231207','2023-10-04 00:00:00','2023-10-04 00:00:00','pengisian dana kas',8200000,4),(3,3,'20231213/000003/BO','',14,'-','-','0001/-O/20231213','2023-12-01 00:00:00','2023-12-01 00:00:00','Biaya administrasi',290000,2);
/*!40000 ALTER TABLE `kasbank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameter`
--

DROP TABLE IF EXISTS `parameter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parameter` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameter`
--

LOCK TABLES `parameter` WRITE;
/*!40000 ALTER TABLE `parameter` DISABLE KEYS */;
INSERT INTO `parameter` VALUES (1,'Sawargi','Jalan Pemalang Raya No 22','semarang','10','2023','nita','kasir','desi','accounting','mastika','pimpinan');
/*!40000 ALTER TABLE `parameter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemesanan`
--

DROP TABLE IF EXISTS `pemesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pemesanan` (
  `Noid` int NOT NULL AUTO_INCREMENT,
  `NoPesanan` varchar(15) DEFAULT NULL,
  `TglPesanan` datetime DEFAULT NULL,
  `JenisPesanan` tinyint DEFAULT NULL,
  `NamaPemesan` varchar(30) DEFAULT NULL,
  `AlamatPemesan` varchar(50) DEFAULT NULL,
  `RTRWPemesan` varchar(15) DEFAULT NULL,
  `KelurahanPemesan` varchar(20) DEFAULT NULL,
  `KecamatanPemesan` varchar(20) DEFAULT NULL,
  `KabupatenPemesan` varchar(20) DEFAULT NULL,
  `TelpRumahPemesan` varchar(15) DEFAULT NULL,
  `TelpKantorPemesan` varchar(15) DEFAULT NULL,
  `HP1Pemesan` varchar(15) DEFAULT NULL,
  `HP2Pemesan` varchar(15) DEFAULT NULL,
  `NamaPasangan` varchar(30) DEFAULT NULL,
  `AlamatPasangan` varchar(50) DEFAULT NULL,
  `RTRWPasangan` varchar(15) DEFAULT NULL,
  `KelurahanPasangan` varchar(20) DEFAULT NULL,
  `KecamatanPasangan` varchar(20) DEFAULT NULL,
  `KabupatenPasangan` varchar(20) DEFAULT NULL,
  `TelpRumahPasangan` varchar(15) DEFAULT NULL,
  `TelpKantorPasangan` varchar(15) DEFAULT NULL,
  `HP1Pasangan` varchar(15) DEFAULT NULL,
  `HP2Pasangan` varchar(15) DEFAULT NULL,
  `NoKavling` int DEFAULT NULL,
  `RedesignBangunan` bit(1) DEFAULT NULL,
  `TambahKwalitas` bit(1) DEFAULT NULL,
  `PekerjaanTambah` bit(1) DEFAULT NULL,
  `PolaPembayaran` tinyint DEFAULT NULL,
  `HargaJual` decimal(12,2) DEFAULT NULL,
  `Diskon` decimal(12,2) DEFAULT NULL,
  `BookingFee` decimal(12,2) DEFAULT NULL,
  `HargaKLT` decimal(12,2) DEFAULT NULL,
  `HargaSudut` decimal(12,2) DEFAULT NULL,
  `HargaHadapJalan` decimal(12,2) DEFAULT NULL,
  `HargaFasum` decimal(12,2) DEFAULT NULL,
  `HargaRedesign` decimal(12,2) DEFAULT NULL,
  `HargaTambahKwalitas` decimal(12,2) DEFAULT NULL,
  `HargaPekerjaanTambah` decimal(12,2) DEFAULT NULL,
  `TotalHarga` decimal(12,2) DEFAULT NULL,
  `TotalUangMuka` decimal(12,2) DEFAULT NULL,
  `LunasUangMuka` decimal(12,2) DEFAULT NULL,
  `BayarUangMukaKe` tinyint DEFAULT NULL,
  `TglBayarUangMuka` datetime DEFAULT NULL,
  `TotalAngsuran` decimal(12,2) DEFAULT NULL,
  `LamaAngsuran` tinyint DEFAULT NULL,
  `NilaiAngsuran` decimal(12,2) DEFAULT NULL,
  `LunasAngsuran` decimal(12,2) DEFAULT NULL,
  `BayarAngsuranKe` tinyint DEFAULT NULL,
  `TglBayarAngsuran` datetime DEFAULT NULL,
  `Lunas` bit(1) DEFAULT NULL,
  `StatusTransaksi` tinyint DEFAULT NULL,
  `PlafonKpr` decimal(12,2) DEFAULT NULL,
  `RealisasiKPR` decimal(12,2) DEFAULT NULL,
  `RetensiKPR` decimal(12,2) DEFAULT NULL,
  `TglAkadKredit` datetime DEFAULT NULL,
  `AccBankKPR` int DEFAULT NULL,
  `AccBankRetensi` int DEFAULT NULL,
  `HargaKLTMtr` decimal(10,2) DEFAULT NULL,
  `BookingFeeByr` decimal(10,2) DEFAULT NULL,
  `HargaSudutByr` decimal(10,2) DEFAULT NULL,
  `HargaHadapJalanByr` decimal(10,2) DEFAULT NULL,
  `HargaKLTbyr` decimal(10,2) DEFAULT NULL,
  `HargaFasumByr` decimal(10,2) DEFAULT NULL,
  `HargaRedesignByr` decimal(10,2) DEFAULT NULL,
  `HargaTambahKwByr` decimal(10,2) DEFAULT NULL,
  `HargaKerjaTambahByr` decimal(10,2) DEFAULT NULL,
  `TotalHargaByr` decimal(12,2) DEFAULT NULL,
  `BookingFeeONP` decimal(12,2) DEFAULT NULL,
  `UangMukaONP` decimal(12,2) DEFAULT NULL,
  `HargaSudutONP` decimal(12,2) DEFAULT NULL,
  `HargaHadapJalanONP` decimal(12,2) DEFAULT NULL,
  `HargaKLTONP` decimal(12,2) DEFAULT NULL,
  `HargaFasumONP` decimal(12,2) DEFAULT NULL,
  `HargaRedesignONP` decimal(12,2) DEFAULT NULL,
  `HargaTambahKwONP` decimal(12,2) DEFAULT NULL,
  `HargaKerjaTambahONP` decimal(12,2) DEFAULT NULL,
  `TotalHargaONP` decimal(12,2) DEFAULT NULL,
  `HPP` decimal(12,2) DEFAULT NULL,
  `IDMarketing` int DEFAULT NULL,
  `InsentifMarketing` decimal(7,4) DEFAULT NULL,
  `InsentifMarketingRP` decimal(10,2) DEFAULT NULL,
  `ProsesAkadKB` tinyint DEFAULT NULL,
  `TotBayarInsentif` decimal(12,2) DEFAULT NULL,
  `TerakhirByrInsentif` datetime DEFAULT NULL,
  `InsentifAdmin` decimal(7,4) DEFAULT NULL,
  `InsentifAdminRP` decimal(12,2) DEFAULT NULL,
  `TotBayarInsentifAdmin` decimal(12,2) DEFAULT NULL,
  `TerakhirByrInsentifAdmin` datetime DEFAULT NULL,
  PRIMARY KEY (`Noid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemesanan`
--

LOCK TABLES `pemesanan` WRITE;
/*!40000 ALTER TABLE `pemesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pemesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perkiraan`
--

DROP TABLE IF EXISTS `perkiraan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `balancedue` float DEFAULT (0),
  PRIMARY KEY (`rekid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perkiraan`
--

LOCK TABLES `perkiraan` WRITE;
/*!40000 ALTER TABLE `perkiraan` DISABLE KEYS */;
INSERT INTO `perkiraan` VALUES (1,'-1','0','000-000','Root',0,0,0,NULL,NULL,0,0,NULL,NULL,NULL,0),(2,'0','100','100-000','ASSET',0,0,2,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(3,'0','200','200-000','KEWAJIBAN',1,0,2,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(5,'0','300','300-000','EKUITAS',2,0,2,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0),(6,'0','400','400-000','PENDAPATAN',3,0,2,_binary '\0',_binary '\0',0,0,NULL,NULL,NULL,0),(7,'0','500','500-000','HARGA POKOK',4,0,2,_binary '\0',_binary '\0',0,0,NULL,NULL,NULL,0),(8,'0','600','600-000','BEBAN',5,0,2,_binary '\0',_binary '',0,0,NULL,NULL,NULL,0),(9,'100','10001','110-000','ASSET LANCAR',0,0,3,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(10,'10001','1000101','111-000','KAS',0,0,4,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(11,'10001','1000102','112-000','BANK',0,0,4,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(12,'1000101','100010101','111-001','Kas Ditangan',0,2,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(13,'1000101','100010102','111-002','Kas Kecil',0,2,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(14,'1000102','100010201','112-001','Bank BNI',0,2,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(15,'1000102','100010202','112-002','Bank BRI',0,2,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(16,'600','60001','610-000','BEBAN UMUM',5,0,3,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(17,'60001','6000101','611-000','BEBAN PERUSAHAAN',5,0,4,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(18,'6000101','600010101','611-001','Biaya Gaji',5,1,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(19,'6000101','600010102','611-002','Biaya Kendaraan',5,1,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(20,'6000101','600010103','611-003','Biaya BBM',5,1,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(21,'6000101','600010104','611-004','Biaya Telpon',5,1,5,_binary '',_binary '',0,0,NULL,NULL,NULL,0),(22,'400','40001','410-000','PENDAPATAN',3,0,3,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0),(23,'40001','4000101','411-000','PENDAPATAN OPERASI',3,0,4,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0),(24,'4000101','400010101','411-001','Penjualan Barang',3,1,5,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0),(25,'4000101','400010102','411-002','Pendapatan Jasa',3,1,5,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0),(26,'4000101','400010103','411-009','Pendapatan Lainnya',3,1,5,_binary '',_binary '\0',0,0,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `perkiraan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportlist`
--

DROP TABLE IF EXISTS `reportlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportlist` (
  `reportid` int NOT NULL AUTO_INCREMENT,
  `parentkey` varchar(20) NOT NULL,
  `keyvalue` varchar(20) NOT NULL,
  `reportname` varchar(40) DEFAULT NULL,
  `reportfilename` varchar(60) DEFAULT NULL,
  `reportmodul` varchar(40) DEFAULT NULL,
  `showfilter` bit(1) NOT NULL DEFAULT (1),
  `filterblth` bit(1) NOT NULL DEFAULT (0),
  `filtertanggal` bit(1) NOT NULL DEFAULT (0),
  `filterentry` bit(1) NOT NULL DEFAULT (0),
  `filtergroupby` bit(1) NOT NULL DEFAULT (0),
  `groupentry` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`reportid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportlist`
--

LOCK TABLES `reportlist` WRITE;
/*!40000 ALTER TABLE `reportlist` DISABLE KEYS */;
INSERT INTO `reportlist` VALUES (1,'-1','1','KASBANK','KASBANK','2',_binary '',_binary '\0',_binary '\0',_binary '\0',_binary '\0',NULL),(2,'1','11','Informasi Buku Harian','Kb_infobukuharian','2',_binary '',_binary '\0',_binary '',_binary '',_binary '\0',''),(3,'1','12','Rekapitulasi Buku Harian','Kb_bukuharian','2',_binary '',_binary '\0',_binary '',_binary '',_binary '\0',NULL),(4,'1','13','Rekapitulasi kasbank','Kb_rekapitulasikasbank','2',_binary '',_binary '\0',_binary '',_binary '',_binary '\0',NULL),(5,'1','14','Rekapitulasi per kode akun','Kb_rekapitulasikodeakun','2',_binary '',_binary '\0',_binary '',_binary '',_binary '\0',NULL),(8,'-1','2','ACCOUNTING','ACCOUNTING','3',_binary '',_binary '\0',_binary '\0',_binary '\0',_binary '\0',NULL),(9,'2','21','Buku Besar','Gl_bukubesar','3',_binary '',_binary '',_binary '\0',_binary '',_binary '\0',NULL),(10,'2','22','Neraca Saldo','Gl_neracasaldo','3',_binary '',_binary '',_binary '\0',_binary '\0',_binary '',NULL),(11,'2','23','Neraca Lajur','Gl_neracalajur','3',_binary '',_binary '',_binary '\0',_binary '\0',_binary '',NULL),(12,'2','24','Neraca Simple','Gl_neracasimple','3',_binary '',_binary '',_binary '\0',_binary '\0',_binary '',NULL),(13,'2','25','Laba (Rugi)','Gl_labarugi','3',_binary '',_binary '',_binary '\0',_binary '\0',_binary '',NULL),(14,'1','15','Bukti Transaksi','Kb_buktitransaksi','2',_binary '',_binary '\0',_binary '\0',_binary '',_binary '\0','kasbank');
/*!40000 ALTER TABLE `reportlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rinciankasbank`
--

DROP TABLE IF EXISTS `rinciankasbank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rinciankasbank` (
  `idkasbank` int NOT NULL,
  `indexvalue` smallint NOT NULL,
  `rekid` int NOT NULL,
  `accno` varchar(10) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idkasbank`,`indexvalue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rinciankasbank`
--

LOCK TABLES `rinciankasbank` WRITE;
/*!40000 ALTER TABLE `rinciankasbank` DISABLE KEYS */;
INSERT INTO `rinciankasbank` VALUES (1,1,18,'611-001',12000000,'Gaji karyawan'),(1,2,18,'611-001',8000000,'Gaji pimpinan'),(2,1,13,'111-002',3200000,'penerimaan dari pimpinan cabang'),(2,2,12,'111-001',5000000,'penerimaan dari pusat'),(3,1,19,'611-002',50000,'beli bensin'),(3,2,21,'611-004',240000,'bayar telpon');
/*!40000 ALTER TABLE `rinciankasbank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `UserName` varchar(20) DEFAULT NULL,
  `namalengkap` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kota` varchar(40) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `ChangePassAtLogon` bit(1) DEFAULT NULL,
  `PassNeverExpires` bit(1) DEFAULT NULL,
  `CanotChangePass` bit(1) DEFAULT NULL,
  `UserLock` bit(1) DEFAULT NULL,
  `approve` tinyint DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (0,'mastika','Mastika','m4stika@gmail.com','denpasar','denpasar',NULL,'a5d517300208fa198bbd',NULL,NULL,NULL,NULL,1),(1,'admin','administrator',NULL,NULL,NULL,'User admin','admin',NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vbukubesar`
--

DROP TABLE IF EXISTS `vbukubesar`;
/*!50001 DROP VIEW IF EXISTS `vbukubesar`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vbukubesar` AS SELECT 
 1 AS `noid`,
 1 AS `bulanbuku`,
 1 AS `tahunbuku`,
 1 AS `rekid`,
 1 AS `saldoawal`,
 1 AS `mutasidebet`,
 1 AS `mutasikredit`,
 1 AS `saldoakhir`,
 1 AS `accountno`,
 1 AS `description`,
 1 AS `groupacc`,
 1 AS `classacc`,
 1 AS `debitacc`,
 1 AS `levelacc`,
 1 AS `balancesheetacc`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vjournaldetail`
--

DROP TABLE IF EXISTS `vjournaldetail`;
/*!50001 DROP VIEW IF EXISTS `vjournaldetail`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vjournaldetail` AS SELECT 
 1 AS `journalid`,
 1 AS `journalno`,
 1 AS `journalgroup`,
 1 AS `bulan`,
 1 AS `tahun`,
 1 AS `journaldate`,
 1 AS `dateofposting`,
 1 AS `journalremark`,
 1 AS `indexvalue`,
 1 AS `debitpos`,
 1 AS `amount`,
 1 AS `remark`,
 1 AS `rekid`,
 1 AS `accountno`,
 1 AS `description`,
 1 AS `debitacc`,
 1 AS `balancesheetacc`,
 1 AS `groupacc`,
 1 AS `classacc`,
 1 AS `keyvalue`,
 1 AS `parentkey`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vkasbank`
--

DROP TABLE IF EXISTS `vkasbank`;
/*!50001 DROP VIEW IF EXISTS `vkasbank`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vkasbank` AS SELECT 
 1 AS `noid`,
 1 AS `kasbanktype`,
 1 AS `kasbanktype1`,
 1 AS `nokasbank`,
 1 AS `cabang`,
 1 AS `rekid`,
 1 AS `accountno`,
 1 AS `description`,
 1 AS `parentkey`,
 1 AS `keyvalue`,
 1 AS `nobukti`,
 1 AS `nomorcek`,
 1 AS `nojurnal`,
 1 AS `tgltransaksi`,
 1 AS `tglentry`,
 1 AS `uraian`,
 1 AS `totaltransaksi`,
 1 AS `statusverifikasi`,
 1 AS `statusverifikasi1`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vpemesanan`
--

DROP TABLE IF EXISTS `vpemesanan`;
/*!50001 DROP VIEW IF EXISTS `vpemesanan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vpemesanan` AS SELECT 
 1 AS `noid`,
 1 AS `nopesanan`,
 1 AS `TglPesanan`,
 1 AS `JenisPesanan`,
 1 AS `namapemesan`,
 1 AS `AlamatPemesan`,
 1 AS `RTRWPemesan`,
 1 AS `KelurahanPemesan`,
 1 AS `KecamatanPemesan`,
 1 AS `KabupatenPemesan`,
 1 AS `TelpRumahPemesan`,
 1 AS `TelpKantorPemesan`,
 1 AS `HP1Pemesan`,
 1 AS `typerumah`,
 1 AS `NamaPasangan`,
 1 AS `AlamatPasangan`,
 1 AS `RTRWPasangan`,
 1 AS `KelurahanPasangan`,
 1 AS `KecamatanPasangan`,
 1 AS `KabupatenPasangan`,
 1 AS `TelpRumahPasangan`,
 1 AS `TelpKantorPasangan`,
 1 AS `HP1Pasangan`,
 1 AS `HP2Pasangan`,
 1 AS `NoKavling`,
 1 AS `RedesignBangunan`,
 1 AS `TambahKwalitas`,
 1 AS `PekerjaanTambah`,
 1 AS `PolaPembayaran`,
 1 AS `hargajual`,
 1 AS `Diskon`,
 1 AS `BookingFee`,
 1 AS `HargaKLT`,
 1 AS `HargaSudut`,
 1 AS `HargaHadapJalan`,
 1 AS `HargaFasum`,
 1 AS `HargaRedesign`,
 1 AS `HargaTambahKwalitas`,
 1 AS `HargaPekerjaanTambah`,
 1 AS `TotalHarga`,
 1 AS `TotalUangMuka`,
 1 AS `LunasUangMuka`,
 1 AS `BayarUangMukaKe`,
 1 AS `TglBayarUangMuka`,
 1 AS `TotalAngsuran`,
 1 AS `LamaAngsuran`,
 1 AS `NilaiAngsuran`,
 1 AS `LunasAngsuran`,
 1 AS `BayarAngsuranKe`,
 1 AS `TglBayarAngsuran`,
 1 AS `Lunas`,
 1 AS `StatusTransaksi`,
 1 AS `PlafonKpr`,
 1 AS `RealisasiKPR`,
 1 AS `RetensiKPR`,
 1 AS `TglAkadKredit`,
 1 AS `AccBankKPR`,
 1 AS `AccBankRetensi`,
 1 AS `HargaKLTMtr`,
 1 AS `BookingFeeByr`,
 1 AS `HargaSudutByr`,
 1 AS `HargaHadapJalanByr`,
 1 AS `HargaKLTbyr`,
 1 AS `HargaFasumByr`,
 1 AS `HargaRedesignByr`,
 1 AS `HargaTambahKwByr`,
 1 AS `HargaKerjaTambahByr`,
 1 AS `TotalHargaByr`,
 1 AS `BookingFeeONP`,
 1 AS `UangMukaONP`,
 1 AS `HargaSudutONP`,
 1 AS `HargaHadapJalanONP`,
 1 AS `HargaKLTONP`,
 1 AS `HargaFasumONP`,
 1 AS `HargaRedesignONP`,
 1 AS `HargaTambahKwONP`,
 1 AS `HargaKerjaTambahONP`,
 1 AS `TotalHargaONP`,
 1 AS `HPP`,
 1 AS `IDMarketing`,
 1 AS `InsentifMarketing`,
 1 AS `InsentifMarketingRP`,
 1 AS `ProsesAkadKB`,
 1 AS `TotBayarInsentif`,
 1 AS `TerakhirByrInsentif`,
 1 AS `InsentifAdmin`,
 1 AS `InsentifAdminRP`,
 1 AS `TotBayarInsentifAdmin`,
 1 AS `TerakhirByrInsentifAdmin`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vrinciankasbank`
--

DROP TABLE IF EXISTS `vrinciankasbank`;
/*!50001 DROP VIEW IF EXISTS `vrinciankasbank`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vrinciankasbank` AS SELECT 
 1 AS `idkasbank`,
 1 AS `indexvalue`,
 1 AS `rekid`,
 1 AS `accno`,
 1 AS `amount`,
 1 AS `remark`,
 1 AS `accountno`,
 1 AS `description`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vbukubesar`
--

/*!50001 DROP VIEW IF EXISTS `vbukubesar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vbukubesar` AS select `b`.`noid` AS `noid`,`b`.`bulanbuku` AS `bulanbuku`,`b`.`tahunbuku` AS `tahunbuku`,`b`.`rekid` AS `rekid`,`b`.`saldoawal` AS `saldoawal`,`b`.`mutasidebet` AS `mutasidebet`,`b`.`mutasikredit` AS `mutasikredit`,`b`.`saldoakhir` AS `saldoakhir`,`p`.`accountno` AS `accountno`,`p`.`description` AS `description`,`p`.`groupacc` AS `groupacc`,`p`.`classacc` AS `classacc`,`p`.`debitacc` AS `debitacc`,`p`.`levelacc` AS `levelacc`,`p`.`balancesheetacc` AS `balancesheetacc` from (`bukubesar` `b` join `perkiraan` `p` on((`p`.`rekid` = `b`.`rekid`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vjournaldetail`
--

/*!50001 DROP VIEW IF EXISTS `vjournaldetail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vjournaldetail` AS select `journal`.`JournalID` AS `journalid`,`journal`.`JournalNo` AS `journalno`,`journal`.`JournalGroup` AS `journalgroup`,`journal`.`Bulan` AS `bulan`,`journal`.`Tahun` AS `tahun`,`journal`.`JournalDate` AS `journaldate`,`journal`.`DateofPosting` AS `dateofposting`,`journal`.`JournalRemark` AS `journalremark`,`journaldetil`.`IndexValue` AS `indexvalue`,`journaldetil`.`DebitAcc` AS `debitpos`,`journaldetil`.`Amount` AS `amount`,`journaldetil`.`Remark` AS `remark`,`perkiraan`.`rekid` AS `rekid`,`perkiraan`.`accountno` AS `accountno`,`perkiraan`.`description` AS `description`,`perkiraan`.`debitacc` AS `debitacc`,`perkiraan`.`balancesheetacc` AS `balancesheetacc`,`perkiraan`.`groupacc` AS `groupacc`,`perkiraan`.`classacc` AS `classacc`,`perkiraan`.`keyvalue` AS `keyvalue`,`perkiraan`.`parentkey` AS `parentkey` from ((`journal` join `journaldetil` on((`journal`.`JournalID` = `journaldetil`.`JournalID`))) join `perkiraan` on((`journaldetil`.`RekId` = `perkiraan`.`rekid`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vkasbank`
--

/*!50001 DROP VIEW IF EXISTS `vkasbank`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vkasbank` AS select `k`.`noid` AS `noid`,`k`.`kasbanktype` AS `kasbanktype`,`k`.`kasbanktype` AS `kasbanktype1`,`k`.`nokasbank` AS `nokasbank`,`k`.`cabang` AS `cabang`,`k`.`rekid` AS `rekid`,`p`.`accountno` AS `accountno`,`p`.`description` AS `description`,`p`.`parentkey` AS `parentkey`,`p`.`keyvalue` AS `keyvalue`,`k`.`nobukti` AS `nobukti`,`k`.`nomorcek` AS `nomorcek`,`k`.`nojurnal` AS `nojurnal`,`k`.`tgltransaksi` AS `tgltransaksi`,`k`.`tglentry` AS `tglentry`,`k`.`uraian` AS `uraian`,`k`.`totaltransaksi` AS `totaltransaksi`,`k`.`statusverifikasi` AS `statusverifikasi`,`k`.`statusverifikasi` AS `statusverifikasi1` from (`kasbank` `k` join `perkiraan` `p` on((`p`.`rekid` = `k`.`rekid`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vpemesanan`
--

/*!50001 DROP VIEW IF EXISTS `vpemesanan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vpemesanan` AS select `pemesanan`.`Noid` AS `noid`,`pemesanan`.`NoPesanan` AS `nopesanan`,`pemesanan`.`TglPesanan` AS `TglPesanan`,`pemesanan`.`JenisPesanan` AS `JenisPesanan`,`pemesanan`.`NamaPemesan` AS `namapemesan`,`pemesanan`.`AlamatPemesan` AS `AlamatPemesan`,`pemesanan`.`RTRWPemesan` AS `RTRWPemesan`,`pemesanan`.`KelurahanPemesan` AS `KelurahanPemesan`,`pemesanan`.`KecamatanPemesan` AS `KecamatanPemesan`,`pemesanan`.`KabupatenPemesan` AS `KabupatenPemesan`,`pemesanan`.`TelpRumahPemesan` AS `TelpRumahPemesan`,`pemesanan`.`TelpKantorPemesan` AS `TelpKantorPemesan`,`pemesanan`.`HP1Pemesan` AS `HP1Pemesan`,`pemesanan`.`HP2Pemesan` AS `typerumah`,`pemesanan`.`NamaPasangan` AS `NamaPasangan`,`pemesanan`.`AlamatPasangan` AS `AlamatPasangan`,`pemesanan`.`RTRWPasangan` AS `RTRWPasangan`,`pemesanan`.`KelurahanPasangan` AS `KelurahanPasangan`,`pemesanan`.`KecamatanPasangan` AS `KecamatanPasangan`,`pemesanan`.`KabupatenPasangan` AS `KabupatenPasangan`,`pemesanan`.`TelpRumahPasangan` AS `TelpRumahPasangan`,`pemesanan`.`TelpKantorPasangan` AS `TelpKantorPasangan`,`pemesanan`.`HP1Pasangan` AS `HP1Pasangan`,`pemesanan`.`HP2Pasangan` AS `HP2Pasangan`,`pemesanan`.`NoKavling` AS `NoKavling`,`pemesanan`.`RedesignBangunan` AS `RedesignBangunan`,`pemesanan`.`TambahKwalitas` AS `TambahKwalitas`,`pemesanan`.`PekerjaanTambah` AS `PekerjaanTambah`,`pemesanan`.`PolaPembayaran` AS `PolaPembayaran`,`pemesanan`.`HargaJual` AS `hargajual`,`pemesanan`.`Diskon` AS `Diskon`,`pemesanan`.`BookingFee` AS `BookingFee`,`pemesanan`.`HargaKLT` AS `HargaKLT`,`pemesanan`.`HargaSudut` AS `HargaSudut`,`pemesanan`.`HargaHadapJalan` AS `HargaHadapJalan`,`pemesanan`.`HargaFasum` AS `HargaFasum`,`pemesanan`.`HargaRedesign` AS `HargaRedesign`,`pemesanan`.`HargaTambahKwalitas` AS `HargaTambahKwalitas`,`pemesanan`.`HargaPekerjaanTambah` AS `HargaPekerjaanTambah`,`pemesanan`.`TotalHarga` AS `TotalHarga`,`pemesanan`.`TotalUangMuka` AS `TotalUangMuka`,`pemesanan`.`LunasUangMuka` AS `LunasUangMuka`,`pemesanan`.`BayarUangMukaKe` AS `BayarUangMukaKe`,`pemesanan`.`TglBayarUangMuka` AS `TglBayarUangMuka`,`pemesanan`.`TotalAngsuran` AS `TotalAngsuran`,`pemesanan`.`LamaAngsuran` AS `LamaAngsuran`,`pemesanan`.`NilaiAngsuran` AS `NilaiAngsuran`,`pemesanan`.`LunasAngsuran` AS `LunasAngsuran`,`pemesanan`.`BayarAngsuranKe` AS `BayarAngsuranKe`,`pemesanan`.`TglBayarAngsuran` AS `TglBayarAngsuran`,`pemesanan`.`Lunas` AS `Lunas`,`pemesanan`.`StatusTransaksi` AS `StatusTransaksi`,`pemesanan`.`PlafonKpr` AS `PlafonKpr`,`pemesanan`.`RealisasiKPR` AS `RealisasiKPR`,`pemesanan`.`RetensiKPR` AS `RetensiKPR`,`pemesanan`.`TglAkadKredit` AS `TglAkadKredit`,`pemesanan`.`AccBankKPR` AS `AccBankKPR`,`pemesanan`.`AccBankRetensi` AS `AccBankRetensi`,`pemesanan`.`HargaKLTMtr` AS `HargaKLTMtr`,`pemesanan`.`BookingFeeByr` AS `BookingFeeByr`,`pemesanan`.`HargaSudutByr` AS `HargaSudutByr`,`pemesanan`.`HargaHadapJalanByr` AS `HargaHadapJalanByr`,`pemesanan`.`HargaKLTbyr` AS `HargaKLTbyr`,`pemesanan`.`HargaFasumByr` AS `HargaFasumByr`,`pemesanan`.`HargaRedesignByr` AS `HargaRedesignByr`,`pemesanan`.`HargaTambahKwByr` AS `HargaTambahKwByr`,`pemesanan`.`HargaKerjaTambahByr` AS `HargaKerjaTambahByr`,`pemesanan`.`TotalHargaByr` AS `TotalHargaByr`,`pemesanan`.`BookingFeeONP` AS `BookingFeeONP`,`pemesanan`.`UangMukaONP` AS `UangMukaONP`,`pemesanan`.`HargaSudutONP` AS `HargaSudutONP`,`pemesanan`.`HargaHadapJalanONP` AS `HargaHadapJalanONP`,`pemesanan`.`HargaKLTONP` AS `HargaKLTONP`,`pemesanan`.`HargaFasumONP` AS `HargaFasumONP`,`pemesanan`.`HargaRedesignONP` AS `HargaRedesignONP`,`pemesanan`.`HargaTambahKwONP` AS `HargaTambahKwONP`,`pemesanan`.`HargaKerjaTambahONP` AS `HargaKerjaTambahONP`,`pemesanan`.`TotalHargaONP` AS `TotalHargaONP`,`pemesanan`.`HPP` AS `HPP`,`pemesanan`.`IDMarketing` AS `IDMarketing`,`pemesanan`.`InsentifMarketing` AS `InsentifMarketing`,`pemesanan`.`InsentifMarketingRP` AS `InsentifMarketingRP`,`pemesanan`.`ProsesAkadKB` AS `ProsesAkadKB`,`pemesanan`.`TotBayarInsentif` AS `TotBayarInsentif`,`pemesanan`.`TerakhirByrInsentif` AS `TerakhirByrInsentif`,`pemesanan`.`InsentifAdmin` AS `InsentifAdmin`,`pemesanan`.`InsentifAdminRP` AS `InsentifAdminRP`,`pemesanan`.`TotBayarInsentifAdmin` AS `TotBayarInsentifAdmin`,`pemesanan`.`TerakhirByrInsentifAdmin` AS `TerakhirByrInsentifAdmin` from `pemesanan` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vrinciankasbank`
--

/*!50001 DROP VIEW IF EXISTS `vrinciankasbank`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vrinciankasbank` AS select `r`.`idkasbank` AS `idkasbank`,`r`.`indexvalue` AS `indexvalue`,`r`.`rekid` AS `rekid`,`r`.`accno` AS `accno`,`r`.`amount` AS `amount`,`r`.`remark` AS `remark`,`p`.`accountno` AS `accountno`,`p`.`description` AS `description` from ((`rinciankasbank` `r` join `kasbank` `k` on((`k`.`noid` = `r`.`idkasbank`))) join `perkiraan` `p` on((`p`.`rekid` = `r`.`rekid`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-23  5:04:12
