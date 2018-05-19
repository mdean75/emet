<?php //shift-report-48.php

session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "48 Hour Shift Report";
// shortened page title for mobile devices
$page_title_short = "48 Hour Shift Report";

$page_security = 5;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/functions.php');


if (isset($_GET['submit'])){

	$name = $_GET['name'];
	$email = $_GET['email'];
	$jeffco_1 = $_GET['jeffco_1'];
	$jeffco_2 = $_GET['jeffco_2'];

	$unit_6817_1 = $_GET['unit_6817_1'];
	$unit_6817_2 = $_GET['unit_6817_2'];

	$unit_6827_1 = $_GET['unit_6827_1'];
	$unit_6827_2 = $_GET['unit_6827_2'];

	$unit_6837_1 = $_GET['unit_6837_1'];
	$unit_6837_2 = $_GET['unit_6837_2'];

	$unit_6847_1 = $_GET['unit_6847_1'];
	$unit_6847_2 = $_GET['unit_6847_2'];

	$duties_1 = $_GET['duties_1'];
	$duties_2 = $_GET['duties_2'];
	$other = $_GET['other'];

	$training = $_GET['training'];
	$pr = $_GET['pr'];
	
	// the following fields are not required and might not be set
	if (isset($_GET['oxygen1'])) {
		$oxygen1 = $_GET['oxygen1'];
	}else{
		$oxygen1 = '';
	}
	
	if (isset($_GET['oxygen2'])) {
		$oxygen2 = $_GET['oxygen2'];
	}else{
		$oxygen2 = '';
	}
	
	if (isset($_GET['ot_check'])) {
		$ot_check = $_GET['ot_check'];
	}else{
		$ot_check = '';
	}
	
	if (isset($_GET['supplies_check'])) {
		$supplies_check = $_GET['supplies_check'];
	}else{
		$supplies_check = '';
	}




$message = shiftReportSendMail($name, $email, $jeffco_1, $jeffco_2, $unit_6817_1, $unit_6817_2, $unit_6827_1, $unit_6827_2, $unit_6837_1, $unit_6837_2, $unit_6847_1, $unit_6847_2, $duties_1, $duties_2, $other, $training, $pr, $oxygen1, $oxygen2, $ot_check, $supplies_check);

// set variables for file name
$year = date('Y');
$month = date('M');
$filename = 'files/'.$year.'/'.$month.'-shift-log.txt';

if(!file_exists(dirname($filename))) {
    mkdir(dirname($filename));
    chmod($filename, 776);
}
$file = fopen($filename, "a+");
 fwrite($file, date("n/j/y")."\r\n");
 fwrite($file, $message);
 fwrite($file, "\r\n \r\n");

fclose($file);

header('Location: /manager-menu.php');

}
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




<div class="container" >

	<?php
  if (isset($_SESSION['error'])) { ?>
  <br>
      
  <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
    <h2><?php echo $_SESSION['error']; ?> </h2>
  </div>
  <br>
  <div class="col-sm-6 col-sm-offset-4">
  <h3>Click to return to home page<a href="/home.php"><button class="btn btn-danger">Home</button></a></h3>
</div>

  <?php }else{ 

?>
	<br>
	<form class="form-horizontal form" type="GET" action="">
	  <div class="col-md-6 col-md-offset-3">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	
			<br>
			<div class="step">
				  <div class="form-group">
				    <label for="name" class="col-sm-3 control-label">Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="text" name="email" class="form-control" id="email" placeholder="email">
				    </div>
				  </div>	

				  <div class="form-group">
				    <label for="jeffco_1" class="col-sm-3 control-label">Jeffco Contacted Day 1</label>
				    <div class="col-sm-9">
				      <input type="text" name="jeffco_1" class="form-control" id="jeffco_1" placeholder="Enter dispatcher name">
				    </div>
				  </div>	

				  <div class="form-group">
				    <label for="jeffco_2" class="col-sm-3 control-label">Jeffco Contacted Day 2</label>
				    <div class="col-sm-9">
				      <input type="text" name="jeffco_2" class="form-control" id="jeffco_2" placeholder="Enter dispatcher name">
				    </div>
				  </div>			  
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="unit_6817_1" class="col-sm-3 control-label">6817 Crew Day 1</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6817_1" class="form-control" id="unit_6817_1" placeholder="Enter crew members">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="unit_6817_2" class="col-sm-3 control-label">6817 Crew Day 2</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6817_2" class="form-control" id="unit_6817_2" placeholder="Enter crew members">
				    </div>
				  </div> 		  	
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="unit_6827_1" class="col-sm-3 control-label">6827 Crew Day 1</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6827_1" class="form-control" id="unit_6827_1" placeholder="Enter crew members">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="unit_6827_2" class="col-sm-3 control-label">6827 Crew Day 2</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6827_2" class="form-control" id="unit_6827_2" placeholder="Enter crew members">
				    </div>
				  </div> 		  	
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="unit_6837_1" class="col-sm-3 control-label">6837 Crew Day 1</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6837_1" class="form-control" id="unit_6837_1" placeholder="Enter crew members">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="unit_6837_2" class="col-sm-3 control-label">6837 Crew Day 2</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6837_2" class="form-control" id="unit_6837_2" placeholder="Enter crew members">
				    </div>
				  </div> 		  	
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="unit_6847_1" class="col-sm-3 control-label">6847 Crew Day 1</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6847_1" class="form-control" id="unit_6847_1" placeholder="Enter crew members">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="unit_6847_2" class="col-sm-3 control-label">6847 Crew Day 2</label>
				    <div class="col-sm-9">
				      <input type="text" name="unit_6847_2" class="form-control" id="unit_6847_2" placeholder="Enter crew members">
				    </div>
				  </div> 		  	
			</div>
			
			<div class="step">
				<div class="form-group">
				  <label class="col-sm-5 control-label">Oxygen bottles checked station 1</label>
				     <div class="col-sm-7">
				     <label for="oxygen1_yes">Yes</label>
				      <input type="radio" name="oxygen1" id="oxygen1_yes" value="yes">
				     <label for="oxygen1_no">No</label>
				      <input type="radio" name="oxygen1" id="oxygen1_no" value="no">
				    </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-5 control-label">Oxygen bottles checked station 2</label>
				     <div class="col-sm-7">
				     <label for="oxygen2_yes">Yes</label>
				      <input type="radio" name="oxygen2" id="oxygen2_yes" value="yes">
				     <label for="oxygen2_no">No</label>
				      <input type="radio" name="oxygen2" id="oxygen2_no" value="no">
				    </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-5 control-label">Overtime checked and logged</label>
				     <div class="col-sm-7">
				     <label for="ot_checked_yes">Yes</label>
				      <input type="radio" name="ot_check" id="ot_checked_yes" value="yes">
				     <label for="ot_checked_no">No</label>
				      <input type="radio" name="ot_check" id="ot_checked_no" value="no">
				     <label for="ot_checked_na">N/A</label>
				      <input type="radio" name="ot_check" id="ot_checked_na" value="na">

				    </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-5 control-label">Supplies checked and requested</label>
				     <div class="col-sm-7">
				     <label for="supplies_checked_yes">Yes</label>
				      <input type="radio" name="supplies_check" id="supplies_checked_yes" value="yes">
				     <label for="supplies_checked_no">No</label>
				      <input type="radio" name="supplies_check" id="supplies_checked_no" value="no">
				     <label for="supplies_checked_na">N/A</label>
				      <input type="radio" name="supplies_check" id="supplies_checked_na" value="na">

				    </div>
				</div>



			
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="duties_1" class="col-sm-4 control-label">Extra Duties Station 1</label>
				    <div class="col-sm-8">
				      <input type="text" name="duties_1" class="form-control" id="duties_1" placeholder="Enter extra duties performed">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="duties_2" class="col-sm-4 control-label">Extra Duties Station 2</label>
				    <div class="col-sm-8">
				      <input type="text" name="duties_2" class="form-control" id="duties_2" placeholder="Enter extra duties performed">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="other" class="col-sm-4 control-label">Other Items To Report</label>
				    <div class="col-sm-8">
				      <textarea style="resize: none;" rows="4" name="other" class="form-control" id="other" placeholder="Enter any addition items to report"></textarea>
				      
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="training" class="col-sm-4 control-label">Trainings and/or Meetings Attended</label>
				    <div class="col-sm-8">
				      <input type="text" name="training" class="form-control" id="training" placeholder="Enter Trainging and/or Meeting">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="pr" class="col-sm-4 control-label">PR Events Attended</label>
				    <div class="col-sm-8">
				      <input type="text" name="pr" class="form-control" id="pr" placeholder="Enter PR Events Attended">
				    </div>
				  </div>	

				  				  
				  
			</div>


			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Name</label>
				    <div class="col-sm-9">
				    	<label data-id="name"></label>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				    	<label data-id="email"></label>
				    </div>
				  </div>

				  

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Jeffco Day 1</label>
				    <div class="col-sm-9">
				    	<label data-id="jeffco_1"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Jeffco Day 2</label>
				    <div class="col-sm-9">
				    	<label data-id="jeffco_2"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">6817 Crew Day 1</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6817_1"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">6817 Crew Day 2</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6817_2"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">6827 Crew Day 1</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6827_1"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">6827 Crew Day 2</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6827_2"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">6837 Crew Day 1</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6837_1"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">6837 Crew Day 2</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6837_2"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">6847 Crew Day 1</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6847_1"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">6847 Crew Day 2</label>
				    <div class="col-sm-9">
				    	<label data-id="unit_6847_2"></label>
				    </div>
				  </div>
				  
				  
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Extra Duties Station 1</label>
				    <div class="col-sm-9">
				    	<label data-id="duties_1"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Extra Duties Station 2</label>
				    <div class="col-sm-9">
				    	<label data-id="duties_2"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Other Items To Report</label>
				    <div class="col-sm-9">
				    	<label data-id="other"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Training and/or Meetings Attended</label>
				    <div class="col-sm-9">
				    	<label data-id="training"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">PR Events Attended</label>
				    <div class="col-sm-9">
				    	<label data-id="pr"></label>
				    </div>
				  </div>			  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn" autofocus="true">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="addUser">Submit</button>
			      </div>
			  </div>
			</div>			

		</div>
		
	  </div> 
	</form> 
   </div>
<?php }
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");

?>
   

 </body>
</html>

<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>

