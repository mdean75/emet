<?php //form.delete-assignment.php

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
		$sql = "SELECT users_assignment.id, users_assignment.assignment_name FROM users_assignment WHERE id = :aid ";

		$db->query($sql);
		$db->bind(':aid', $aid);
		$result = $db->resultset();
		foreach ($result as $row) {
			$id 		= $row['id'];
			$assignment = $row['assignment_name'];
		}
		

		
	}
	catch (PDOException $e) {
		echo "Something didn't work ".$e->getMessage();
	}

?>
<div class="container">
	<form class="form-horizontal form" method="POST" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <h4>Confirm: Delete This Assignment?</h4><br><br>
				  <div class="form-group">
				    <label for="assignment-id" class="col-sm-3 control-label">Assignmnt ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="assignment-id" class="form-control" id="assignment-id" value=<?php echo $id; ?> readonly>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="assignment-name" class="col-sm-3 control-label">Assignment Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="assignment-name" class="form-control" id="assignment-name" value="<?php echo $assignment; ?>" >
				    </div>
				  </div>	

				  		    
				  
			</div>

			<div class="step display">
				<h4><strong>Warning: Submitting this form will permanently delete this assignment!</strong></h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level ID</label>
				    <div class="col-sm-8">
				    	<label data-id="assignment-id"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level Name</label>
				    <div class="col-sm-8">
				    	<label data-id="assignment-name"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="delete-assignment">Delete</button>
					
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


