--
-- FILE       : tables.sql
-- PROJECT    : ClimateView - Weather Archiving and Visualization - Advanced SQL Final Project
-- PROGRAMMER : Ben Lorantfy, Grigory Kozyrev, Kevin Li, Michael Dasilva
-- DATE       : April 19, 2015
--

-------------------------------------------------------
--		Transformation sProc
-------------------------------------------------------

-- funnction to convert F to C and inch to mm of rain
-- returns year month
DROP PROCEDURE IF EXISTS transformProc;
DELIMITER //
CREATE PROCEDURE transformProc(tblName VARCHAR(255), StateCode INT, YearMonth INT, PCP Float, CDD Float, HDD Float, TMIN Float, TMAX Float, TAVG Float)
BEGIN
	SET @tableName = tblName;
	SET FOREIGN_KEY_CHECKS = 0;
	-- convert fahrenheit to celsius
	SET @celsiusTMIN = ((TMIN -32)*(5/9));
	SET @celsiusTMAX = ((TMAX -32)*(5/9));
	SET @celsiusTAVG = ((TAVG -32)*(5/9));
	-- convert inches into mm
	SET @mmPCP = PCP *  25.4;	
	
	SET @q = CONCAT('
		INSERT INTO `' , @tableName, '` (
			`StateCode`, `YearMonth`, `PCP`, `CDD`, `HDD`, `TMIN`, `TMAX`, `TAVG`) 
			values  (`' , StateCode, '``' , YearMonth, '``' , @mmPCP, '``' , CDD, '`
			`' , HDD, '``' , @celsiusTMIN, '``' , @celsiusTMAX, '``' , @celsiusTAVGS, '`
		) ENGINE=MyISAM DEFAULT CHARSET=utf8
		');
		PREPARE stmt FROM @q;
		EXECUTE stmt;
	DEALLOCATE PREPARE stmt;

	SET @yearNum = (SELECT LEFT(YearMonth, 4));
	SET @monthNum = (SELECT RIGHT(YearMonth, 2));
	INSERT INTO YearMonth(Year, Month) 
		VALUES (@yearNum, @monthNum);
	

SET FOREIGN_KEY_CHECKS = 1;	
END //
DELIMITER ;




-------------------------------------------------------
--		Create User sProc
-------------------------------------------------------

-- function to create users data table;
-- parameter is userid or table name.
DROP PROCEDURE IF EXISTS createUserTable;
DELIMITER //
CREATE PROCEDURE createUserTable(tblName VARCHAR(255))
BEGIN
    SET @tableName = tblName;
    SET @q = CONCAT('
        CREATE TABLE IF NOT EXISTS `' , @tableName, '` (
		`StateCode` INT(11),
		`YearMonth` INT(11),
		-- Millimeters of precepitation 
		`PCP` FLOAT,
		`CDD` FLOAT,
		`HDD` FLOAT,
		-- Lowest month temperture
		`TMIN` FLOAT,
		-- Maximum month temperture in degrees celcius
		`TMAX` FLOAT,
		-- Average month temperture in degrees celcius
		`TAVG` FLOAT,
		
		-- Foreign keys
		FOREIGN KEY (StateCode) REFERENCES State(StateCode),
		FOREIGN KEY (YearMonth) REFERENCES YearMonth(YearMonth)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    PREPARE stmt FROM @q;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    -- Table is created.
END //
DELIMITER ;

