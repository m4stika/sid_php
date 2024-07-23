DROP TABLE IF EXISTS `rinciankasbank`;
CREATE TABLE rinciankasbank(
	idkasbank int NOT NULL,
	indexvalue smallint NOT NULL,
	rekid int NOT NULL,
	accno varchar(10) NULL,
	amount float NULL,
	remark varchar(100) NULL,
PRIMARY KEY (idkasbank, indexvalue)
)
