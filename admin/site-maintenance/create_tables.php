<?php //create_tables.php
echo time()."<br>";
echo $_SERVER['SERVER_NAME']."/index.html";
die;
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
//require_once("../included_files/Dbconnection.php");
$db = new database;

/*if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}else{
	echo "Connection to database <strong>".$dbname."</strong> succeeded!<br><br>";
}*/


$database				= "emet";

$tbl_auth 				= "users_auth";
$tbl_profile 			= "users_profile";
$tbl_accesslvl 			= "users_accesslvl";
$tbl_assignment 		= "users_assignment";
$tbl_ots_activity 		= "ots_tblactivity";
$tbl_ots_employees 		= "ots_tblemployees";
$tbl_ots_logotworked 	= "ots_tbllogovertimeworked";
$tbl_ots_test			= "ots_test_tbllogovertimeworked";

$sql0 = "CREATE DATABASE IF NOT EXISTS ".$database;

$sql1 = "CREATE TABLE IF NOT EXISTS ".$tbl_auth." ( 
		`userid` INT NOT NULL AUTO_INCREMENT , 
		`username` VARCHAR(64) NOT NULL , 
		`password` VARCHAR(128) NOT NULL , 
		`email` VARCHAR(64) NOT NULL , 
		`accesslvl` INT NULL , 
		`last_login` DATETIME on update CURRENT_TIMESTAMP NULL , 
		`last_ip` VARCHAR(32) NULL , 
		`pin` INT NULL , 
		PRIMARY KEY (`userid`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql2 = "CREATE TABLE IF NOT EXISTS ".$tbl_profile." ( 
		`userid` INT NOT NULL AUTO_INCREMENT , 
		`fname` VARCHAR(64) NOT NULL , 
		`lname` VARCHAR(64) NOT NULL , 
		`assignment` INT NOT NULL , 
		`medic_num` VARCHAR(16) NULL , 
		`phone` VARCHAR(16) NULL , 
		`alt_phone` VARCHAR(16) NULL , 
		PRIMARY KEY (`userid`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql3 = "CREATE TABLE IF NOT EXISTS ".$tbl_accesslvl." ( 
		`id` INT NOT NULL AUTO_INCREMENT , 
		`accesslvl` VARCHAR(32) NOT NULL , 
		PRIMARY KEY (`id`)) 
		ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sql4 = "CREATE TABLE IF NOT EXISTS ".$tbl_assignment." (
		`id` INT NOT NULL AUTO_INCREMENT , 
		`assignment` VARCHAR(32) NOT NULL, 
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

echo "<br><strong>END OF SCRIPT!</strong><br><br>";



?>