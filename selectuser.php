<?php // selectuser.php

//require_once("/resources/class-lib/database.php");
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

if ($db = new database) {
	echo "connected to database <br>";
}else{
	echo "something is not right";
}

$sql = "SELECT DISTINCT FirstName, LastName, Empl_ID FROM Astar.ots_tbllogovertimeworked";
//$db->prepare($sql);
$db->query($sql);
//$db->execute();

$results = $db->resultset();

foreach ($results as $result) {
	echo $result['Empl_ID']. " ".$result['FirstName'].", ".$result['LastName']." ";
	echo strtolower(substr($result['FirstName'], 0, 1).$result['LastName']);
	echo "<br><br>";
}
echo "<b>End of Results!</b>";
?>