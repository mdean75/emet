<?php //create_tables.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
//require_once("../included_files/Dbconnection.php");
$db = new database;

/*if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}else{
	echo "Connection to database <strong>".$dbname."</strong> succeeded!<br><br>";
}*/


$database				= "astar";

$tbl_auth 				= "users_auth";
$tbl_profile 			= "users_profile";
$tbl_accesslvl 			= "users_accesslvl";
$tbl_assignment 		= "users_assignment";
$tbl_ots_activity 		= "ots_tblactivity";
$tbl_ots_employees 		= "ots_tblemployees";
$tbl_ots_logotworked 	= "ots_tbllogovertimeworked";
$tbl_ots_test			= "ots_test_tbllogovertimeworked";

$sql0 = "CREATE DATABASE IF NOT EXISTS ".$database." COLLATE utf8_unicode_ci";

$sql1 = "CREATE TABLE IF NOT EXISTS ".$tbl_auth." ( 
		`userid` INT(11) NOT NULL AUTO_INCREMENT , 
		`username` VARCHAR(64) NOT NULL , 
		`password` VARCHAR(128) NOT NULL , 
		`email` VARCHAR(64) NOT NULL , 
		`accesslvl` INT(11) NOT NULL , 
		`token` VARCHAR(100) NULL COMMENT 'token for account creation and password resets' ,
		`tokenExpiration` int(11) DEFAULT NULL ,
		`tokenAttempts` int(10) DEFAULT NULL ,
		`last_login` DATETIME DEFAULT NULL , 
		`last_ip` VARCHAR(32) DEFAULT NULL , 
		`pin` INT(11) DEFAULT NULL , 
		PRIMARY KEY (`userid`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";


$sql2 = "CREATE TABLE IF NOT EXISTS ".$tbl_profile." ( 
		`userid` INT(11) NOT NULL , 
		`fname` VARCHAR(64) NOT NULL , 
		`lname` VARCHAR(64) NOT NULL , 
		`assignment` INT(11) NOT NULL , 
		`medic_num` VARCHAR(16) DEFAULT NULL , 
		`phone` VARCHAR(16) DEFAULT NULL , 
		`alt_phone` VARCHAR(16) DEFAULT NULL , 
		PRIMARY KEY (`userid`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql3 = "CREATE TABLE IF NOT EXISTS ".$tbl_accesslvl." ( 
		`id` INT(11) NOT NULL AUTO_INCREMENT , 
		`accesslvl_name` VARCHAR(32) NOT NULL ,
		`accesslvl_value` INT(11) NOT NULL , 
		PRIMARY KEY (`id`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql4 = "CREATE TABLE IF NOT EXISTS ".$tbl_assignment." (
		`id` INT(11) NOT NULL AUTO_INCREMENT , 
		`assignment_name` VARCHAR(32) NOT NULL, 
		`assignment_value` INT(11) DEFAULT NULL ,
		PRIMARY KEY (`id`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql5 = "CREATE TABLE IF NOT EXISTS ".$tbl_ots_activity." (
		`ID` int(1) NOT NULL AUTO_INCREMENT,
  		`Username` varchar(20) NOT NULL,
  		`ActivityTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  		`Activity` varchar(100) NOT NULL,
  		PRIMARY KEY (`ID`)) 
  		ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql6 = "CREATE TABLE IF NOT EXISTS ".$tbl_ots_employees." (
		`ID` int(11) NOT NULL AUTO_INCREMENT,
  		`FirstName` varchar(30) NOT NULL,
  		`LastName` varchar(30) NOT NULL,
  		`Crew` varchar(10) NOT NULL,
  		`DateLastWorkedOT` date DEFAULT NULL,
  		`ShiftLastWorked` int(11) DEFAULT NULL,
  		`SecondDate` date DEFAULT NULL,
  		`SecondShift` int(11) DEFAULT NULL,
  		`ThirdDate` date DEFAULT NULL,
  		`ThirdShift` int(11) DEFAULT NULL , 
  		PRIMARY KEY (`ID`)) 
  		ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";


$sql7 = "CREATE TABLE IF NOT EXISTS ".$tbl_ots_logotworked." (
		`ID` int(11) NOT NULL AUTO_INCREMENT,
  		`FirstName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  		`LastName` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  		`Empl_ID` int(11) NOT NULL,
  		`DateWorkedOT` date NOT NULL,
  		`ShiftWorkedOT` int(11) NOT NULL,
  		`HoursWorked` int(11) NOT NULL,
  		`OvertimeType` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  		`flagged` varchar(10) DEFAULT NULL,
  		`EnteredBy` varchar(20) DEFAULT NULL,
  		`EnteredTimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  		`notes` varchar(100) DEFAULT NULL,
  		`UpdatedBy` varchar(20) DEFAULT NULL,
  		`UpdatedTimestamp` datetime DEFAULT NULL , 
  		PRIMARY KEY (`ID`)) 
  		ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql8 = "CREATE TABLE IF NOT EXISTS ".$tbl_ots_test." (
		`ID` int(11) NOT NULL AUTO_INCREMENT,
  		`FirstName` varchar(30) NOT NULL,
  		`LastName` varchar(40) NOT NULL,
  		`Empl_ID` int(11) NOT NULL,
  		`DateWorkedOT` date NOT NULL,
  		`ShiftWorkedOT` int(11) NOT NULL,
  		`HoursWorked` int(11) NOT NULL,
  		`OvertimeType` varchar(20) NOT NULL,
  		`flagged` varchar(10) DEFAULT NULL,
  		`EnteredBy` varchar(20) DEFAULT NULL,
  		`EnteredTimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  		`notes` varchar(100) DEFAULT NULL,
  		`UpdatedBy` varchar(20) DEFAULT NULL,
  		`UpdatedTimestamp` datetime DEFAULT NULL , 
  		PRIMARY KEY (`ID`)) 
  		ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";  

$sql9 = "INSERT INTO `users_accesslvl` (`id`, `accesslvl_name`, `accesslvl_value`) VALUES
		(1, 'Administrator', 9),
		(2, 'Sr. Management', 8),
		(3, 'Elevated Manager', 7),
		(4, 'Shift Leader', 5),
		(5, 'Basic User Plus', 3),
		(6, 'Basic User', 1),
		(7, 'Unauthenticated', 0);";

$sql10 = "INSERT INTO `users_assignment` (`id`, `assignment_name`, `assignment_value`) VALUES
(1, 'Administration', NULL),
(2, 'A shift', NULL),
(3, 'B shift', NULL),
(4, 'C shift', NULL),
(5, 'Inactive', NULL);";

$sql11 = "INSERT INTO `users_auth` (`userid`, `username`, `password`, `email`, `accesslvl`, `token`, `tokenExpiration`, `tokenAttempts`, `last_login`, `last_ip`, `pin`) VALUES
(1, 'admin', 'password', 'mdeangelo@njcad.com', 9, NULL, NULL, NULL, '2017-09-30 16:28:00', NULL, NULL);";

$sql12 = "INSERT INTO `users_profile` (`userid`, `fname`, `lname`, `assignment`, `medic_num`, `phone`, `alt_phone`) VALUES
(1, 'admin', 'admin', 1, '', '', '');";		

$db->query($sql0);
if ($db->execute($sql0) == TRUE) {
	echo "<h2>Database ".$database." successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE DATABASE WAS NOT CREATED!!!</strong><br><br>";
	echo "<strong>SCRIPT TEMINATED WITH ERROR!!!</strong><br><br>";
	die;
}

$db->query($sql1);
if ($db->execute($sql1) === TRUE){
	echo "table <strong>".$tbl_auth." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql2);
if ($db->execute($sql2) === TRUE){
	echo "table <strong>".$tbl_profile." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql3);
if ($db->execute($sql3) === TRUE){
	echo "table <strong>".$tbl_accesslvl." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql4);
if ($db->execute($sql4) === TRUE){
	echo "table <strong>".$tbl_assignment." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql5);
if ($db->execute($sql5) === TRUE){
	echo "table <strong>".$tbl_ots_activity." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE <em>".$tbl_ots_activity."</em> WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql6);
if ($db->execute($sql6) === TRUE){
	echo "table <strong>".$tbl_ots_employees." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql7);
if ($db->execute($sql7) === TRUE){
	echo "table <strong>".$tbl_ots_logotworked." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql8);
if ($db->execute($sql8) === TRUE){
	echo "table <strong>".$tbl_ots_test." </strong>successfully created!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql9);
if ($db->execute($sql9) === TRUE){
	echo "Inserted base values to table <strong>".$tbl_accesslvl." </strong>successfully!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql10);
if ($db->execute($sql10) === TRUE){
	echo "Inserted base values to table <strong>".$tbl_assignment." </strong>successfully!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql11);
if ($db->execute($sql11) === TRUE){
	echo "Inserted base values to table <strong>".$tbl_auth." </strong>successfully!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

$db->query($sql12);
if ($db->execute($sql12) === TRUE){
	echo "Inserted base values to table <strong>".$tbl_profile." </strong>successfully!<br>";
}else{
	echo "<strong>ERROR:  SOMETHING WENT WRONG AND THE TABLE WAS NOT CREATED!!!</strong><br><br>";
}

echo "<br><strong>END OF SCRIPT!</strong><br><br>";



?>