DROP TABLE IF EXISTS `kasbank`;
CREATE TABLE kasbank(
	noid int AUTO_INCREMENT NOT NULL,
	kasbanktype tinyint NULL,
	nokasbank varchar(30) NOT NULL,
	cabang varchar(3) NOT NULL,
	rekid int NOT NULL,
	nobukti varchar(30) NULL,
	nomorcek varchar(30) NULL,
	nojurnal varchar(30) NULL,
	tgltransaksi datetime NULL,
	tglentry datetime NULL,
	uraian varchar(250) NULL,
	totaltransaksi float NULL,
	statusverifikasi tinyint NULL,
    PRIMARY KEY (noid)
)