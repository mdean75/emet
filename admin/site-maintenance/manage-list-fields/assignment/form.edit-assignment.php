<?php //admin_assignment.edit.php

require_once "../../../../resources/dbcon.php";

if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_assignment WHERE id = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_assignment";  
      }  

try {
		$aid = $_POST["ID"];
		$sql = "SELECT users_assignment.id, users_assignment.assignment_name 
				FROM users_assignment 
				WHERE users_assignment.id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $aid);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$id = $result['id'];
		$assignment = $result['assignment_name'];
				
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">

    <link rel="stylesheet" href="/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/jquery.validate.js"></script>

</head>
<body>


  

<div class="container">
	
	<form class="form-horizontal form" type="get" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <div class="form-group">
				    <label for="assignment_id" class="col-sm-4 control-label">Assignment ID</label>
				    <div class="col-sm-8">
				      <input type="text" name="assignmentId" class="form-control" id="assignmentId" value="<?php echo $aid; ?>" readonly>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="assignment_name" class="col-sm-4 control-label">Assignment Name</label>
				    <div class="col-sm-8">
				      <input type="text" name="assignmentName" class="form-control" id="assignmentName" placeholder="Enter New Access Level" value="<?php echo $assignment; ?>">
				    </div>
				  </div>
				  
			</div>

			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level ID</label>
				    <div class="col-sm-8">
				    	<label data-id="assignmentId"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level Name</label>
				    <div class="col-sm-8">
				    	<label data-id="assignmentName"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="editAssignment">Submit</button>
			      </div>
			  </div>
			</div>
		</div>
		
	  </div> 
	</form> 
  </div>
<?php } ?>
</body>
</html>

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
				assignment_id    : "required",
				assignment_name     : "required",
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
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-19096935-1', 'auto'); ga('send', 'pageview');
</script>
