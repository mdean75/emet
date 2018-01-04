<?php //admin_access.add.php

require_once "../../../../../resources/dbcon.php";

$page_title = "Administration - Add New Access Level";
$page_title_short = "Add Access Level";

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../../../css/main.css">

    <link rel="stylesheet" href="../../../../css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../../../../bootstrap/js/bootstrap.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script src="../../../../js/jquery-ui.min.js"></script>
    <script src="../../../../js/jquery.validate.js"></script>

     	
    
	<title><?php echo $page_title; ?></title>

</head>
<body style="min-height: 100vh;">
<?php
require_once "../../../../adminHeader.php";
?>

  <div >
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="../../../../adminMenu.php">Admin Home</a></li>
      <li><a href="../../../siteMaintenance.php">Site Maintenance</a></li>
      <li><a href="../../manageFields.php">Manage List Fields</a></li>
      <li><a href="../listEditMenu.php">Edit Fields</a></li>
      <li class="active">Edit Access Level</a></li>
    </ol>
  </div>
</nav>

<div class="container" style="margin-bottom: 15px;">
	<div class="col-md-6 col-md-offset-3">
	<?php 
    			$sql = "SELECT * FROM users_profile";
    			$stmt = $conn->prepare($sql);
		
				$stmt->execute();

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($stmt->rowCount() > 0) { ?>
	
  		<select class="form-control input-lg" name="empl_list" id="empl_list">
  			<option value="">Select Access To Edit</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['userid']; ?>"><?php echo $row['userid']." ".$row['fname']." ".$row['lname']; ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="row" id="displayRecord">  
             
        </div>
    </div>
	
</div>



</body>
</html>

<script>  
 $(document).ready(function(){  
      $('#empl_list').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.editUser.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 


<script type="text/javascript">
	$(document).ready(function(){
		var current = 1;
		
		widget      = $(".step");
		btnnext     = $(".next");
		btnback     = $(".back"); 
		btnsubmit   = $(".submit");

		// Init buttons and UI
		widget.not(':eq(0)').hide();
		hideButtons(current);
		setProgress(current);

		// Next button click action
		btnnext.click(function(){
			if(current < widget.length){
				// Check validation
				if($(".form").valid()){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

		// Back button click action
		btnback.click(function(){
			if(current > 1){
				current = current - 2;
				if(current < widget.length){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

	    $('.form').validate({ // initialize plugin
			ignore:":not(:visible)",			
			rules: {
				fname     : "required",
				lname     : "required",
				email    : {required : true, email:true},
				username : "required",
				alevel : "required",
				assignment : "required",
				
				rpassword: { required : true, equalTo: "#password"},
			},
	    });

	});

	// Change progress bar action
	setProgress = function(currstep){
		var percent = parseFloat(100 / widget.length) * currstep;
		percent = percent.toFixed();
		$(".progress-bar").css("width",percent+"%").html(percent+"%");		
	}

	// Hide buttons according to the current step
	hideButtons = function(current){
		var limit = parseInt(widget.length); 

		$(".action").hide();

		if(current < limit) btnnext.show();
		if(current > 1) btnback.show();
		if (current == limit) { 
			// Show entered values
			$(".display label:not(.control-label)").each(function(){
				console.log($(this).parent().find("label:not(.control-label)").html($("#" + $(this).data("id")).val()));	
			});
			btnnext.hide(); 
			btnsubmit.show();
		}
	}
</script>
