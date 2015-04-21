--
-- FILE       : tables.sql
-- PROJECT    : ClimateView - Weather Archiving and Visualization - Advanced SQL Final Project
-- PROGRAMMER : Ben Lorantfy, Grigory Kozyrev, Kevin Li, Michael Dasilva
-- DATE       : April 19, 2015
--

-- 
-- Drop the database if it already exists
-- 
DROP DATABASE IF EXISTS ClimateView;

--
-- Create database and use it
--
CREATE DATABASE ClimateView;
USE ClimateView;

--
-- Create StateTable
-- Stores the state names that map to the state codes
--
CREATE TABLE State(
	StateCode INT PRIMARY KEY,
	
	-- name of item (e.g. Harness, Reflector, etc.)
	Name VARCHAR(300)
);

--
-- Create user table
-- Creates the user table containing unique usernames and passwords
--
CREATE TABLE User(
	UserID INT AUTO_INCREMENT PRIMARY KEY,
	
	--
	-- User credentials
	--
	Username VARCHAR(255),
	Password VARCHAR(255)
);

--
-- Create YearMonth table
-- Stores year,month pairs of any dates used in user data
-- Year,month pairs are unique
--
CREATE TABLE YearMonth(
	YearMonth INT AUTO_INCREMENT PRIMARY KEY,
	
	-- Year data was taken
	Year INT,
	
	-- Month data was taken
	Month INT
);

--
-- Create log table
-- Logs each ETL
--
CREATE TABLE Log(
	UserID INT,
	
	-- Time ETL started
	AttemptTime DATETIME,
	
	-- Time ETL finished
	CompletionTime DATETIME,
	
	-- ETL date range
	LowerYearMonth INT,
	UpperYearMonth INT,
	
	-- Foreign keys
	FOREIGN KEY (LowerYearMonth) REFERENCES YearMonth(YearMonth),
	FOREIGN KEY (UpperYearMonth) REFERENCES YearMonth(YearMonth)
);

--
-- Create a user's data table
-- Each user's table is created dynamically when
-- they load data
-- Data is recorded on a monthly basis
-- This table is an example table useful for testing
--
CREATE TABLE User0Data(
	-- State data was collected in
	StateCode INT,
	
	-- YearMonth that data was collected in
	YearMonth INT,
	
	-- Millimeters of precepitation 
	PCP FLOAT,
	
	CDD FLOAT,
	HDD FLOAT,
	
	-- Lowest month temperture
	TMIN FLOAT,
	
	-- Maximum month temperture in degrees celcius
	TMAX FLOAT,
	
	-- Average month temperture in degrees celcius
	TAVG FLOAT,
	
	-- Foreign keys
	FOREIGN KEY (StateCode) REFERENCES State(StateCode),
	FOREIGN KEY (YearMonth) REFERENCES YearMonth(YearMonth)
);

-- Test User
INSERT INTO User(Username,Password) VALUES ("ben","$2y$10$DU3uoyhM9VsekGRL9HB0zOwVNQbMHrjD9IL0n/BzwTElQBROY7NBi");