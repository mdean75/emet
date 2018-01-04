<?php //overtime-report.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

//User::regenerate_session();

// full title to display on larger screens
$page_title = "Overtime Tracking - Overtime Report";
// shortened page title for mobile devices
$page_title_short = "Overtime Report";

$page_security = 1;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

$db = new database;

/*$sql = "SELECT Empl_ID, Max(DateWorkedOT) 
		  AS MaxOfDateWorkedOT 
		  FROM ots_tbllogovertimeworked 
		  GROUP BY Empl_ID";

$db->query($sql);
$result = $db->resultset();

foreach ($result as $row) {
	echo "Employee id: ".$row['Empl_ID'];
	echo "Last date worked: ".$row['MaxOfDateWorkedOT']."<br>";
}*/

$sql = "SELECT fname, lname, users_assignment.assignment_name, DateLastWorkedOT, ShiftLastWorked 
		FROM users_profile 
		INNER JOIN users_assignment ON users_profile.assignment = users_assignment.id 
		WHERE assignment = '2' OR assignment = '3' OR assignment = '4' 
		GROUP BY assignment, DateLastWorkedOT, ShiftLastWorked, SecondDate, SecondShift, ThirdDate, ThirdShift, lname, fname ASC ";
$db->query($sql);
$get_updated_ot = $db->resultset();


								
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
</head>
<body>
	

<?php

require_once ($_SERVER['DOCUMENT_ROOT']."/page-header.php");


?>
<div class='container-fluid' style='padding-top: 40px;'>
	<div class="row">
          	<div class="col-xs-12">
          		<a href="overtime-pdf.php" class="btn btn-success hidden-print col-xs-12 col-md-2 col-md-push-4" target="_blank" role="button">View PDF Version <span class="glyphicon glyphicon-print"></span><br></a>
          		<a href="overtime-email.php" class="btn btn-success hidden-print col-xs-12 col-md-2 col-md-push-4" target="_blank" role="button">Email report <span class="glyphicon glyphicon-envelope"></span><br></a>
          	</div>

          	<div class="col-xs-12">
          		<div class="ot-space">
	          	
	          	<span class="col-xs-4 col-md-2 col-md-offset-3 ot-report-head">First Name</span> 
	          	<span class="col-xs-4 col-md-2 ot-report-head">Last Name</span> 
	          	<span class="col-xs-4 col-md-2 ot-report-head">Date Worked</span> 
	          	<span class="col-xs-4 col-md-2 ot-report-head hidden-xs">Shift Worked</span>
	          	<br>
	          	<hr class="thick-line">
	          	<br>
	          	</div>


	          	<?php
					$shift_test = '';
					foreach ($get_updated_ot as $results){
						$fname = $results['fname'];
						$lname = $results['lname'];
						$date = $results['DateLastWorkedOT'];

						if ($date !=NULL){
								$date = date('n/j/Y', strtotime($date));
							}else{
								$date = '';
						} // end if .. else

						
						$shift = $results['ShiftLastWorked'];

						switch ($shift) {
							case '1':
								$shift='Day';
								break;
							case '2':
								$shift='Night';
								break;
							case '3':
								$shift='24 Hours';
								break;
							
							default:
								break;
						} // end switch

						

						?>
					
						<?php
						if ($shift_test != $results['assignment_name']){
							$shift_test = $results['assignment_name'];

							?>
							<div class="ot-space">
								<span class="col-xs-4 col-md-2 col-md-offset-2 ot-report-head"><?php echo $shift_test; ?></span> 
								<br>
								<hr class="col-xs-10 col-xs-offset-1">
								<br>
							</div>
							<?php
							echo "<br>";

						?>
						
						
						<?php
							
						}else{
							?>
							<span></span>
							<?php
						} // end if .. else
						
						//echo $shift;
						//print_r($results);
						//echo "<br>";
					
					?>
								<div class="ot-report-row">
								<span class="col-xs-4 col-md-2 col-md-offset-3"><?php echo $fname; ?></span> 
					          	<span class="col-xs-4 col-md-2"><?php echo $lname; ?></span> 
					          	<span class="col-xs-4 col-md-2"><?php echo $date; ?></span> 
					          	<span class="col-xs-4 col-md-2 hidden-xs"><?php echo $shift; ?></span>
					          	<br>
					          </div>
								
								
							<?php } ?>




			</div>
		</div>
	</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>
<!--
<script type="text/javascript">setTimeout("window.close();", 3000);</script>
-->