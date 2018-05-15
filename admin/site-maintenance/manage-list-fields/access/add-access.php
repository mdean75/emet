<?php //add-access.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Add New Access Level";
// shortened page title for mobile devices
$page_title_short = "Add Access Group";

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
	
	<form class="form-horizontal form" method="POST" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-3">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <div class="form-group">
				    <label for="new_access_name" class="col-sm-4 control-label">Access Level Name</label>
				    <div class="col-sm-8">
				      <input type="text" name="new_access_name" class="form-control" id="new_access_name" placeholder="Enter New Access Level">
				      
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="new_access_value" class="col-sm-4 control-label">Access Level Security Value</label>
				    <div class="col-sm-8">
				      <input type="text" name="new_access_value" class="form-control" id="new_access_value" placeholder="Access Level Security Value 0 - 9">
				      
				    </div>
				  </div>

			</div>

			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Access Level Name</label>
				    <div class="col-sm-9">
				    	<label data-id="new_access_name"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Access Level Security</label>
				    <div class="col-sm-9">
				    	<label data-id="new_access_value"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="new-access">Submit ?</button>
			      </div>
			  </div>
			</div>
		</div>
		
	  </div> 
	</form> 
  </div>

<?php }
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>