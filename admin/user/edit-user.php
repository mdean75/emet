<?php //edit-user.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - User/Profile Maintenance";
// shortened page title for mobile devices
$page_title_short = "User/Profile Maintenance";

$page_security = 7;

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

	// retrieve database records to selct box
	$db = new database;
    $db->query("SELECT * FROM users_profile");
		
	$results = $db->resultset();
?>

  <div >
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/user-maintenance.php">User Maintenance</a></li>
      <li class="active">Edit User</a></li>
    </ol>
  </div>
</nav>

<div class="container align-select-box">

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
	<div class="col-md-6 col-md-offset-3">
			<?php 
      			if ($db->rowcount() > 0) { ?>
	
  		<select class="form-control input-lg align-select-box" name="employee" id="employee" >
  			<option value="">Select User To Edit</option>
    	  <?php 
    	  	// display fetched results in select box
    	  	foreach ($results as $row) { ?>
      		<option value="<?php echo filter_var($row['userid'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['userid'], FILTER_SANITIZE_NUMBER_INT)." ".filter_var($row['fname'], FILTER_SANITIZE_STRING)." ".filter_var($row['lname'], FILTER_SANITIZE_STRING); ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="row" id="displayRecord">  
             
        </div>
    </div>
	
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>

<!-- ajax to load form after user is selected -->
<script>  
 $(document).ready(function(){  
      $('#employee').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.edit-user.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 