-- Adminer 4.8.1 MySQL 5.5.5-10.6.8-MariaDB-1:10.6.8+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('097952b3a4fa1369ff6d324bec5751b44f1b58a2',	'172.30.0.1',	1701664347,	'__ci_last_regenerate|i:1701664347;'),
('56dbb9397b1fc6dfcfe4c6215c438f4ac24b0390',	'172.30.0.1',	1701667791,	'__ci_last_regenerate|i:1701667791;'),
('57b352977dbc1f2cc19dd810b19ca86187c34aef',	'172.30.0.1',	1701663953,	'__ci_last_regenerate|i:1701663953;'),
('7336902f2851f7feb769af54b9114c8fc768b1e2',	'172.30.0.1',	1701667477,	'__ci_last_regenerate|i:1701667477;'),
('905a2f22b686544f60fefacab439a6faccaacc70',	'172.30.0.1',	1701663431,	'__ci_last_regenerate|i:1701663431;'),
('9ac91f3b519c39d7669e1fdfb73f8aff517ced2a',	'172.20.0.1',	1701655687,	'__ci_last_regenerate|i:1701655687;'),
('9e6cc6f348883a7febcae112c07e6269bb6f3cb5',	'172.20.0.1',	1701662902,	'__ci_last_regenerate|i:1701662902;'),
('a7b1e413a96670ade857a0f1977e1157ccf16315',	'172.30.0.1',	1701668295,	'__ci_last_regenerate|i:1701668295;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:3:\"KDA\";bulanbuku|s:0:\"\";tahunbuku|s:0:\"\";kasir|s:0:\"\";accounting|s:0:\"\";pimpinan|s:0:\"\";new_expiration|i:2592000;'),
('adcf02e2a5d7224711c8493c461ad83c39616f18',	'172.20.0.1',	1701656873,	'__ci_last_regenerate|i:1701656873;'),
('b902026b432ba660c6eb982ddf00bb6ecafc57aa',	'172.30.0.1',	1701664661,	'__ci_last_regenerate|i:1701664661;'),
('c36001930c033cd45f0c4ec540f5cad6e57e8d8b',	'172.30.0.1',	1701666210,	'__ci_last_regenerate|i:1701666210;'),
('c7ae85301c4b6bfde25dbf2439bba933538e7656',	'172.30.0.1',	1701668703,	'__ci_last_regenerate|i:1701668703;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:3:\"KDA\";bulanbuku|s:0:\"\";tahunbuku|s:0:\"\";kasir|s:0:\"\";accounting|s:0:\"\";pimpinan|s:0:\"\";new_expiration|i:2592000;'),
('ec08c402aa061627b8515bf26db296e390a7bb47',	'172.30.0.1',	1701668703,	'__ci_last_regenerate|i:1701668703;sess_expiration|i:2592000;username|s:5:\"admin\";password|s:5:\"admin\";company|s:3:\"KDA\";bulanbuku|s:0:\"\";tahunbuku|s:0:\"\";kasir|s:0:\"\";accounting|s:0:\"\";pimpinan|s:0:\"\";new_expiration|i:2592000;'),
('f6f544c7ad511ca021213935ba958a5eb5c85e66',	'172.30.0.1',	1701665676,	'__ci_last_regenerate|i:1701665676;');

DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
  `company` varchar(40) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `bulanbuku` char(2) NOT NULL,
  `tahunbuku` char(4) NOT NULL,
  `kasir` varchar(40) NOT NULL,
  `accounting` varchar(40) NOT NULL,
  `pimpinan` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `parameter` (`company`, `alamat`, `bulanbuku`, `tahunbuku`, `kasir`, `accounting`, `pimpinan`) VALUES
('KDA',	'Jalan Nusakambangan',	'',	'',	'',	'',	'');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
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
  `approve` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`UserID`, `UserName`, `namalengkap`, `email`, `alamat`, `kota`, `Description`, `Password`, `ChangePassAtLogon`, `PassNeverExpires`, `CanotChangePass`, `UserLock`, `approve`) VALUES
(0,	'mastika',	'Mastika',	'm4stika@gmail.com',	'denpasar',	'denpasar',	NULL,	'a5d517300208fa198bbd',	NULL,	NULL,	NULL,	NULL,	1),
(1,	'admin',	'administrator',	NULL,	NULL,	NULL,	'User admin',	'admin',	NULL,	NULL,	NULL,	NULL,	1);

-- 2023-12-04 06:00:08
