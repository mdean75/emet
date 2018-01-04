<?php //delete-user.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

$page_title = "Administration - Delete User";
$page_title_short = "Delete Users";

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

	// retrieve database records to selct box
	$db = new database;
    $db->query("SELECT * FROM users_profile ORDER BY lname, fname ASC");
		
	$results = $db->resultset();
?>
  	
</nav>

<div class="container">
	<div class="col-md-6 col-md-offset-3"> 
			<?php 
      			if ($db->rowcount() > 0) { ?>

		<select class="form-control input-lg align-select-box" name="employee" id="employee">
  			<option value="">Select User To Delete</option>
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

<script>  
 $(document).ready(function(){  
      $('#employee').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.delete-user.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 