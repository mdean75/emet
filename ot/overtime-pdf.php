<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// full title to display on larger screens
$page_title = "Overtime Tracking - Overtime Report";
// shortened page title for mobile devices
$page_title_short = "Overtime Report";

$page_security = 1;

// retrieve most recent overtime date and shift worked for each employee

$sql = "SELECT fname, lname, users_assignment.assignment_name, DateLastWorkedOT, ShiftLastWorked 
		FROM users_profile 
		INNER JOIN users_assignment ON users_profile.assignment = users_assignment.id 
		WHERE assignment = '2' OR assignment = '3' OR assignment = '4' 
		GROUP BY assignment, DateLastWorkedOT, ShiftLastWorked, SecondDate, SecondShift, ThirdDate, ThirdShift, lname, fname ASC ";

$db = new database;

$db->query($sql);
$get_updated_ot = $db->resultset();

$pdf=new PDF();
$pdf->createOvertimeReport($get_updated_ot);
$pdf->getReport();