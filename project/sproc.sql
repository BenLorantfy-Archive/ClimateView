-- funnction to convert F to C and inch to mm of rain
-- returns year month
DROP PROCEDURE IF EXISTS transformProc;
DELIMITER //
CREATE PROCEDURE transformProc(StateCode INT, YearMonth INT, PCP Float, CDD Float, HDP Float, TMIN Float, TMAX Float, TAVG Float)
BEGIN


	SET @celsiusTMIN = ((TMIN -32)*(5/9));
	SET @celsiusTMAX = ((TMAX -32)*(5/9));
	SET @celsiusTAVG = ((TAVG -32)*(5/9));

	insert into user0data(StateCode, YearMonth, PCP, CDD, HDP, TMIN, TMAX, TAVG) 
		values (StateCode, YearMonthID, PCP, CDD, HDP, @celsiusTMIN, @celsiusTMAX, @celsiusTAVGS);

	SET @yearNum = (SELECT LEFT(YearMonth, 4) from user0data);
	SET @monthNum = (SELECT RIGHT(YearMonth, 2) from user0data);
	INSERT INTO YearMonth(Year, Month) 
		VALUES (yearNum, monthNum);
	
END //
DELIMITER ;
-- todo
-- insert data



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
    -- and you're done. Table is created.
    -- process it here if you like (INSERT etc)
END //

