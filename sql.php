<?php

$sql = "CREATE DATABASE IF NOT EXISTS new_database_test2 COLLATE utf8_unicode_ci";
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$sql1 = "DROP DATABASE new_database_test2";
$db = new database;

$db->query($sql1);
$db->execute();

?>