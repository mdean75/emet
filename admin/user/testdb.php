 <?php 

/*require_once ("/resources/dbcon.php");

    			$sql = "SELECT * FROM users_accesslvl";
    			$stmt = $conn->prepare($sql);
		
				$stmt->execute();

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($stmt->rowCount() > 0) { ?>
	
  		<select class="form-control" name="alevel" id="alevel">
  			<option value="">Select Access Level</option>


    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>"><?php echo $row['accesslvl_name']; ?></option>?>
     	  <?php }} 
*/
        ?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <?php 
  //phpinfo(INFO_ENVIRONMENT);
  ?>


        <form action="#" role="form" method="get">
          <input type="text" name="input">
          <input type="submit" name="submit">
          <button onclick="GetComputerName()">TEst</button>
        </form>
        <?php
        if (isset($_GET['input'])) {
          echo $_GET['input']."<br>";
          echo htmlentities($_GET['input'])."<br>";
          echo htmlspecialchars($_GET['input'])."<br>";
          echo filter_var ( $_GET['input'], FILTER_SANITIZE_STRING)."<br>";
          echo filter_var ( $_GET['input'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)."<br>";
          echo strip_tags($_GET['input'])."<br>";


        }
        echo getenv('COMPUTERNAME')."<br>";
echo getenv('USERNAME')."<br>";
echo getenv('PROCESSOR_IDENTIFIER')."<br>";
        ?>
  </body>
</html>
<script>
function GetComputerName()
{
    try
{
    var network = new ActiveXObject('WScript.Network');
    // Show a pop up if it works
    alert(network.computerName);
}
catch (e) { }
}
</script>