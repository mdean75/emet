<?php //add-carrier.php

session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Add New Carrier";
// shortened page title for mobile devices
$page_title_short = "Add Carrier";

$page_security = 7;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');
?>

<!DOCTYPE html>
<html>
<head>
	
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
	
<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');
?>

</nav>

<div class="container">

	<?php
	if (isset($_SESSION['success'])) { ?>
  <br>
      
  <div class="col-sm-6 col-sm-offset-3 text-center alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
    <h2><?php echo $_SESSION['success']; 
    			unset($_SESSION['success']);?> </h2>
  </div>
  <br>
  

  <?php }
  if (isset($_SESSION['error'])) { ?>
  <br>
      
  <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
    <h2><?php echo $_SESSION['error']; 
    			unset($_SESSION['error']);?> </h2>
  </div>
  <br>
  

  <?php }

?>
	
	<form class="form-horizontal form" method="POST" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-3">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <div class="form-group">
				    <label for="new_assignment" class="col-sm-4 control-label">Enter Carrier Name</label>
				    <div class="col-sm-8">
				      <input type="text" name="carrierName" class="form-control" id="carrierName" placeholder="Enter Carrier Name">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="new_assignment" class="col-sm-4 control-label">Enter Carrier Domain</label>
				    <div class="col-sm-8">
				      <input type="text" name="carrierDomain" class="form-control" id="carrierDomain" placeholder="Enter Carrier Domain">
				    </div>
				  </div>

			</div>

			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Carrier Name</label>
				    <div class="col-sm-9">
				    	<label data-id="carrierName"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Carrier Domain</label>
				    <div class="col-sm-9">
				    	<label data-id="carrierDomain"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="add-carrier">Submit</button>
			      </div>
			  </div>
			</div>
		</div>
		
	  </div> 
	</form> 
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>