<?php //admin_access.add.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Delete Assignment";
// shortened page title for mobile devices
$page_title_short = "Delete Assignment";

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

$db = new database;
$sql = "SELECT * FROM users_assignment ORDER BY assignment_name ASC";

$db->query($sql);
$results = $db->resultset();

?>

</nav>

<div class="container">
	<div class="col-md-6 col-md-offset-3"> 
	<?php 
    			
      			if ($db->rowcount() > 0) { ?>

		<select class="form-control input-lg" name="assignment" id="assignment">
  			<option value="">Select Assignment To Delete</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['assignment_name'], FILTER_SANITIZE_STRING); ?></option>?>
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
      $('#assignment').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.delete-assignment.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 
