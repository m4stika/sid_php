CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`%` 
    SQL SECURITY DEFINER
VIEW `vbukubesar` AS
    SELECT 
        `b`.`noid` AS `noid`,
        `b`.`bulanbuku` AS `bulanbuku`,
        `b`.`tahunbuku` AS `tahunbuku`,
        `b`.`rekid` AS `rekid`,
        `b`.`saldoawal` AS `saldoawal`,
        `b`.`mutasidebet` AS `mutasidebet`,
        `b`.`mutasikredit` AS `mutasikredit`,
        `b`.`saldoakhir` AS `saldoakhir`,
        `p`.`accountno` AS `accountno`,
        `p`.`description` AS `description`,
        `p`.`groupacc` AS `groupacc`,
        `p`.`classacc` AS `classacc`,
        `p`.`debitacc` AS `debitacc`,
        `p`.`levelacc` AS `levelacc`,
        `p`.`balancesheetacc` AS `balancesheetacc`
    FROM
        (`bukubesar` `b`
        JOIN `perkiraan` `p` ON ((`p`.`rekid` = `b`.`rekid`)))