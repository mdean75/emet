<?php //form.edit-assignment.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

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

		$db = new database;

		$db->query($sql);
		$db->bind(':id', $aid);

		$result = $db->resultset();
		foreach ($result as $row) {
			$id 		= $row['id'];
			$assignment = $row['assignment_name'];		
		}
				
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

?>
<!-- multi-part form validation widget -->
<script type="text/javascript" src="/js/form-widget.js"></script>
<div class="container">
	
	<form class="form-horizontal form" method="POST" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <div class="form-group">
				    <label for="assignmentId" class="col-sm-4 control-label">Assignment ID</label>
				    <div class="col-sm-8">
				      <input type="text" name="assignmentId" class="form-control" id="assignmentId" value="<?php echo filter_var($aid, FILTER_SANITIZE_NUMBER_INT); ?>" readonly>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="assignmentName" class="col-sm-4 control-label">Assignment Name</label>
				    <div class="col-sm-8">
				      <input type="text" name="assignmentName" class="form-control" id="assignmentName" placeholder="Enter New Access Level" value="<?php echo filter_var($assignment, FILTER_SANITIZE_STRING); ?>">
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
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="edit-assignment">Submit</button>
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
