<?php

/* this file has been sanitized to remove sensitive information, in order to make this work the following variable must be changed to valid information:

			$servername
			$username
			$password
			$dbname
---------------------------------------------------------------------------------
*/
require_once "functions.php";
$servername = "";// enter host name



$username = "";// enter user name for database
$password = "";// enter password for database
$dbname = "";// enter database name

 try{
  
  $conn = new PDO("mysql:host={$servername};dbname={$dbname}",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
 }catch(PDOException $e){
  
  die($e->getMessage());
 }
?>