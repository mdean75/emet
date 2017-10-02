<?php //form.delete-access.php

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
		$sql = "SELECT users_accesslvl.id, users_accesslvl.accesslvl_name, users_accesslvl.accesslvl_value FROM users_accesslvl WHERE id = :aid ";

		$db = new database;
		
		$db->query($sql);
		$db->bind(':aid', $aid);
		$result = $db->resultset();
		
		foreach ($result as $row) {
			$id = $row['id'];
			$accesslvl_name = $row['accesslvl_name'];
			$accesslvl_value = $row['accesslvl_value'];
		}
		
	}
	catch (PDOException $e) {
		echo "Something didn't work ".$e->getMessage();
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
				  <h4>Confirm: Delete This Access Group?</h4><br><br>
				  <div class="form-group">
				    <label for="accesslvl-id" class="col-sm-3 control-label">Access Group ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="accesslvl-id" class="form-control" id="accesslvl-id" value=<?php echo $id; ?> readonly>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="accesslvl-name" class="col-sm-3 control-label">Access Group Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="accesslvl-name" class="form-control" id="accesslvl-name" value="<?php echo $accesslvl_name; ?>" >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="accesslvl-value" class="col-sm-3 control-label">Access Group Value</label>
				    <div class="col-sm-9">
				      <input type="text" name="accesslvl-value" class="form-control" id="accesslvl-value" value="<?php echo $accesslvl_value; ?>" >
				    </div>
				  </div>	

			</div>

			<div class="step display">
				<h4><strong>Warning: Submitting this form will permanently delete this access group!</strong></h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Group ID</label>
				    <div class="col-sm-8">
				    	<label data-id="accesslvl-id"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Group Name</label>
				    <div class="col-sm-8">
				    	<label data-id="accesslvl-name"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-4 control-label">Access Group Value</label>
				    <div class="col-sm-8">
				    	<label data-id="accesslvl-value"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="delete-access">Delete</button>
					
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
