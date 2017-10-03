<?php //delete-access.php

// full title to display on larger screens
$page_title = "Administration - Delete Access Groups";
// shortened page title for mobile devices
$page_title_short = "Delete Access Groups";

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

$db = new database;
$sql = "SELECT * FROM users_accesslvl";

$db->query($sql);
$results = $db->resultset();

?>


<div >
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/site-maintenance.php">Site Maintenance</a></li>
      <li><a href="/admin/site-maintenance/manage-fields.php">Manage List Fields</a></li>
      <li><a href="/admin/site-maintenance/manage-list-fields/list-delete-menu.php">Delete Fields</a></li>
      <li class="active">Delete Access Level</a></li>
    </ol>
  </div>
  
<div class="container">
	<div class="col-md-6 col-md-offset-3"> 
	<?php 
    			
      			if ($db->rowcount() > 0) { ?>

		<select class="form-control input-lg" name="access" id="access">
  			<option value="">Select Access Group To Delete</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['accesslvl_name'], FILTER_SANITIZE_STRING)." - Level: ".filter_var($row['accesslvl_value'], FILTER_SANITIZE_NUMBER_INT); ?></option>?>
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
      $('#access').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.delete-access.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 