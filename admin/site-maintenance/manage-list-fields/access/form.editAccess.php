<?php //form.editAccess.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_accesslvl WHERE id = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_accesslvl";  
      }  

try {
		$aid = $_POST["ID"];
		$sql = "SELECT users_accesslvl.id, users_accesslvl.accesslvl_name, users_accesslvl.accesslvl_value 
				FROM users_accesslvl 
				WHERE users_accesslvl.id = :id";

		$db = new database;
		
		$db->query($sql);
		$db->bind(':id', $aid);
		$result = $db->resultset();

		foreach ($result as $row) {
			$id = $row['id'];
			$accesslvl_name = $row['accesslvl_name'];
			$accesslvl_value = $row['accesslvl_value'];
		}
				
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
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
				  <div class="form-group">
				    <label for="access_id" class="col-sm-4 control-label">Access Level ID</label>
				    <div class="col-sm-8">
				      <input type="text" name="accessId" class="form-control" id="accessId" placeholder="Enter New Access Level" value="<?php echo $aid; ?>" readonly>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="access_name" class="col-sm-4 control-label">Access Level Name</label>
				    <div class="col-sm-8">
				      <input type="text" name="accessName" class="form-control" id="accessName" placeholder="Enter New Access Level" value="<?php echo $accesslvl_name; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="access_name" class="col-sm-4 control-label">Access Level Security Value</label>
				    <div class="col-sm-8">
				      <input type="number" name="accessValue" class="form-control" id="accessValue" placeholder="Enter New Access Level" value="<?php echo $accesslvl_value; ?>">
				    </div>
				  </div>
				  
			</div>

			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Level ID</label>
				    <div class="col-sm-8">
				    	<label data-id="accessId"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Level Name</label>
				    <div class="col-sm-8">
				    	<label data-id="accessName"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Level Security</label>
				    <div class="col-sm-8">
				    	<label data-id="accessValue"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="edit-access">Submit</button>
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
