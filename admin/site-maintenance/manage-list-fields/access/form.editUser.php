<?php //user.edit.form.php

require_once "../../../../../resources/dbcon.php";
/*
$page_title = "Administration - Edit/Update User Profile";
$page_title_short = "Edit/Update User";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/

if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_auth WHERE userid = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_auth";  
      }  

try {
		$uid = $_POST["ID"];
		$sql = "SELECT users_auth.userid, users_auth.email, users_auth.username, users_auth.accesslvl, users_profile.fname, users_profile.lname, users_profile.assignment, users_profile.medic_num, users_profile.phone, users_profile.alt_phone 
				FROM users_auth 
				INNER JOIN users_profile on users_profile.userid = users_auth.userid 
				WHERE users_profile.userid = :id";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $uid);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$id = $result['userid'];
		$uname = $result['username'];
		$email = $result['email'];
		$accesslvl = $result['accesslvl'];
		$fname = $result['fname'];
		$lname = $result['lname'];
		$assignment = $result['assignment'];
		$medic_num = $result['medic_num'];
		$phone = $result['phone'];
		$alt_phone = $result['alt_phone'];
		
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<base href="http://localhost/njcad/">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="css/style.css">

   
    <script src="bootstrap/js/bootstrap.min.js"></script>
    	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    	<script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.validate.js"></script>

     	
    
	
	</head>
<body>

<div class="container">
	
<form class="form-horizontal form" type="get" action="user.edit.action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	
			<br>
			<div class="step">
				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">User ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="userid" class="form-control" id="fname" placeholder="User ID" readonly value=<?php echo $id; ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" value=<?php echo $fname; ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="lname" class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" value=<?php echo $lname; ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="text" name="email" class="form-control" id="email" placeholder="email" value=<?php echo $email; ?>  >
				    </div>
				  </div>			  
				  
			</div>
			<div class="step">
				  <div class="form-group">
				    <label for="username" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				      <input type="text" name="username" class="form-control" id="username" placeholder="Username" value=<?php echo $uname; ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="alevel" class="col-sm-2 control-label">Access Level</label>
				    <div class="col-sm-10">

				    	<?php 
    			$sql = "SELECT * FROM users_accesslvl";
    			$stmt = $conn->prepare($sql);
		
				$stmt->execute();

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($stmt->rowCount() > 0) { ?>
	
  		<select class="form-control" name="alevel" id="alevel">
  			<option >Select Access Level</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>" <?php if ($accesslvl == $row['id']) echo "selected='selected'" ?>"  ><?php echo $row['id']." ".$row['accesslvl']; ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>


				<!--      <select class="form-control" name="alevel" id="alevel" value=<?php echo $accesslvl; ?> >
				      	<option value="">Select</option>
				      	<option value="0">No Access</option>
				      	<option value="1">User Level</option>
				      	<option value="2">Supervisor Level</option>
				      	<option value="6">Special Permissions</option>
				      	<option value="9">Administration</option>
				      	
				      </select>-->
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="assignment" class="col-sm-2 control-label">Assignment</label>
				    <div class="col-sm-10">
				    	<?php 
    			$sql = "SELECT * FROM users_assignment";
    			$stmt = $conn->prepare($sql);
		
				$stmt->execute();

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($stmt->rowCount() > 0) { ?>
	
  		<select class="form-control" name="assignment" id="assignment">
  			<option >Select Assignment</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>" <?php if ($assignment == $row['id']) echo "selected='selected'" ?>"  ><?php echo $row['id']." ".$row['assignment']; ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>



				    <!--
				      <select class="form-control" name="assignment" id="assignment" value=<?php echo $assignment; ?> >
				      	<option value="">Select</option>
				      	<option value="1">Administration</option>
				      	<option value="2">A Crew</option>
				      	<option value="3">B Crew</option>
				      	<option value="4">C Crew</option>
				      </select>

				      -->
				    </div>
				  </div>

				  		  	
			</div>

			<div class="step">
				  <div class="form-group">
				    <label for="medic" class="col-sm-3 control-label">Medic Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="medic" class="form-control" id="medic" placeholder="Enter Medic Number" value=<?php echo $medic_num; ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="phone" class="col-sm-3 control-label">Phone Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value=<?php echo $phone; ?>  >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="altphone" class="col-sm-3 control-label">Altername Phone</label>
				    <div class="col-sm-9">
				      <input type="text" name="altphone" class="form-control" id="altphone" placeholder="altphone" value=<?php echo $alt_phone; ?> >
				    </div>
				  </div>	
				  <input type="hidden" name="test" value="?">		  
				  
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
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<input type="submit" class="action btn-hot text-capitalize submit btn" value="Submit !"></input>
			      </div>
			  </div>
			</div>			

		</div>
		</div><br><br><br>
	  </div> 
	</form> 
	</div>
<?php } ?>
 

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
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-19096935-1', 'auto'); ga('send', 'pageview');
</script>