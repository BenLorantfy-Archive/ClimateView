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