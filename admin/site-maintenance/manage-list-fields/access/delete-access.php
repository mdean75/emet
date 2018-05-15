<?php //delete-access.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Delete Access Level";
// shortened page title for mobile devices
$page_title_short = "Delete Access Groups";

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
$sql = "SELECT * FROM users_accesslvl";

$db->query($sql);
$results = $db->resultset();

?>

  
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

<?php }
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