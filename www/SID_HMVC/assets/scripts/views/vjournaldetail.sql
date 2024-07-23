CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`%` 
    SQL SECURITY DEFINER
VIEW `vjournaldetail` AS
    SELECT 
        `journal`.`JournalID` AS `journalid`,
        `journal`.`JournalNo` AS `journalno`,
        `journal`.`JournalGroup` AS `journalgroup`,
        `journal`.`Bulan` AS `bulan`,
        `journal`.`Tahun` AS `tahun`,
        `journal`.`JournalDate` AS `journaldate`,
        `journal`.`DateofPosting` AS `dateofposting`,
        `journal`.`JournalRemark` AS `journalremark`,
        `journaldetil`.`IndexValue` AS `indexvalue`,
        `journaldetil`.`DebitAcc` AS `debitpos`,
        `journaldetil`.`Amount` AS `amount`,
        `journaldetil`.`Remark` AS `remark`,
        `perkiraan`.`rekid` AS `rekid`,
        `perkiraan`.`accountno` AS `accountno`,
        `perkiraan`.`description` AS `description`,
        `perkiraan`.`debitacc` AS `debitacc`,
        `perkiraan`.`balancesheetacc` AS `balancesheetacc`,
        `perkiraan`.`groupacc` AS `groupacc`,
        `perkiraan`.`keyvalue` AS `keyvalue`,
        `perkiraan`.`parentkey` AS `parentkey`
    FROM
        ((`journal`
        JOIN `journaldetil` ON ((`journal`.`JournalID` = `journaldetil`.`JournalID`)))
        JOIN `perkiraan` ON ((`journaldetil`.`RekId` = `perkiraan`.`rekid`)))