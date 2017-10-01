<?php //user.add.php

// full title to display on larger screens
$page_title = "Administration - Add New User";
// shortened page title for mobile devices
$page_title_short = "Add New User";

$page_security = 7;

?>

<!DOCTYPE html>
<html>
<head>
	
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
	
</head>
<body>
<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/admin-header.php');

utility::restrict_page_access($page_security, '', 'index.php', 'status-code', '3X99');

// retrieve db records for access level list box
$db_accesslvl = new database;

$db_accesslvl->query('SELECT * FROM users_accesslvl');
//$db_accesslvl->bind(':id', 2);
$accesslvl_rows = $db_accesslvl->resultset();
// __________________________________________________________________

// retrived db records for assignment list box
$db_assignment = new database;

$db_assignment->query('SELECT * FROM users_assignment');
//$db_assignment->bind(':id', 2);
$assignment_rows = $db_assignment->resultset();
// __________________________________________________________________

?>

  	<div >
  		<ol class="breadcrumb breadcrumb-nav">
  			<li><a href="/admin-menu.php">Admin Home</a></li>
  			<li><a href="/admin/user-maintenance.php">Admin User Maintenance</a></li>
  			<li class="active">Add New User</a></li>
  		</ol>
  	</div>
  
</nav>

<div class="container" >
	<?php 

      if (isset($_GET['status-code'])){
		if ( ($_GET['status-code'] == "4X42") ) {
			echo '
    	
        		<div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
        		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          		<h2>Error: That username and/or email is assigned to another user!</h2>
        		</div>';	
		}elseif ( ($_GET['status-code'] == "4X41") ) {
			echo '
    	
        		<div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
        		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          		<h2>Error: A required field was left empty, please try again!</h2>
        		</div>';
		}
      
    }
        ?>

	<form class="form-horizontal form" method="POST" action="/resources/manage-user-action.php">
	  <div class="col-md-6 col-md-offset-3">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	
			<br>
			<div class="step">
				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="lname" class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="text" name="email" class="form-control" id="email" placeholder="email">
				    </div>
				  </div>			  
				  
			</div>
			<div class="step">
				  <div class="form-group">
				    <label for="username" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				      <input type="text" name="username" class="form-control" id="username" placeholder="Username">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="alevel" class="col-sm-2 control-label">Access Level</label>
				    <div class="col-sm-10">
	
  		<select class="form-control" name="alevel" id="alevel">
  			<option value="">Select Access Level</option>

    	  <?php 
    	  		// display fetched access levels in select box

    	  		foreach ($accesslvl_rows as $row) { ?>
      		<option value="<?php echo filter_var($row['accesslvl_value'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['accesslvl_name'], FILTER_SANITIZE_STRING); ?></option>?>
     	  <?php } ?>
		</select><br>

				    </div>
				  </div>

				  <div class="form-group">
				    <label for="assignment" class="col-sm-2 control-label">Assignment</label>
				    <div class="col-sm-10">
				      
  		<select class="form-control" name="assignment" id="assignment">
  			<option value="">Select Assignment Level</option>

    	  <?php 
    	  		// display fetched assignments in select box

    	  		foreach ($assignment_rows as $row) { ?>
      		<option value="<?php echo filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['assignment_name'], FILTER_SANITIZE_STRING); ?></option>?>
     	  <?php } ?>
		</select><br>
				    </div>
				  </div>	  	
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="medic" class="col-sm-3 control-label">Medic Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="medic" class="form-control" id="medic" placeholder="Enter Medic Number">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="phone" class="col-sm-3 control-label">Phone Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="altphone" class="col-sm-3 control-label">Altername Phone</label>
				    <div class="col-sm-9">
				      <input type="text" name="altphone" class="form-control" id="altphone" placeholder="altphone">
				    </div>
				  </div>	

				  <div class="form-group">
				    <div class="col-sm-9">
				      <input type="hidden" name="submit" class="form-control" id="submit">
				    </div>
				  </div>				  
				  
			</div>
			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				    	<label data-id="fname"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				    	<label data-id="lname"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				    	<label data-id="email"></label>
				    </div>
				  </div>

				  

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Username</label>
				    <div class="col-sm-9">
				    	<label data-id="username"></label>
				    </div>


				  
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Access Level</label>
				    <div class="col-sm-9">
				    	<label data-id="alevel"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Assignment</label>
				    <div class="col-sm-9">
				    	<label data-id="assignment"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Medic Number</label>
				    <div class="col-sm-9">
				    	<label data-id="medic"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Phone Number</label>
				    <div class="col-sm-9">
				    	<label data-id="phone"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Alternate Phone</label>
				    <div class="col-sm-9">
				    	<label data-id="altphone"></label>
				    </div>
				  </div>			  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn" autofocus="true">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="add-user">Submit</button>
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

