<?php //manageListAction.php

require_once "dbcon.php";

if (!isset($_GET['submit'])) {
	echo "Error: you cannot browse directly to this page, please retry";
	//header("location: admin_menu.php");

}else {
	echo "You did it right<br>";
	switch ($_GET['submit']) {
		case 'submitNewAccess':
			echo "you submitted a new access level<br>";
			$access_name = $_GET['new_access_name'];
			$access_value = $_GET['new_access_value'];

			try {
				$sql = "INSERT INTO users_accesslvl (accesslvl_name, accesslvl_value) VALUES (:access_name, :access_value)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':access_name', $access_name);
				$stmt->bindParam(':access_value', $access_value);
				$stmt->execute();
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch
			header('location: /success.php?redirect=access-add');
			break;
		
		case 'submitNewAssignment':
			echo "you submitted a new assignment<br>";
			$assignment = $_GET['new_assignment'];

			try {
				$sql = "INSERT INTO users_assignment (assignment) VALUES (:assignment)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':assignment', $assignment);
				$stmt->execute();
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
			header('location: /success.php?redirect=assignment-add');		
			break;

		case 'editAssignment':
			echo "you edited an assignment<br>";
			
			$assignmentId = $_GET['assignmentId'];
			$assignmentName = $_GET['assignmentName'];

			try {
				$sql = "UPDATE users_assignment SET assignment=:assignmentName WHERE id=:assignmentId";	
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':assignmentId', $assignmentId);
				$stmt->bindParam(':assignmentName', $assignmentName);
				$stmt->execute();
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
			header('location: /success.php?redirect=assignment-edit');
			break;

		case 'editAccess':
			echo "you edited an access group<br>";
			
			$accessId = $_GET['accessId'];
			$accessName = $_GET['accessName'];
			$accessValue = $_GET['accessValue'];

			try {
				$sql = "UPDATE users_accesslvl SET accesslvl_name=:accessName, accesslvl_value=:accessValue WHERE id=:accessId";	
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':accessId', $accessId);
				$stmt->bindParam(':accessName', $accessName);
				$stmt->bindParam(':accessValue', $accessValue);
				$stmt->execute();
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
			header('location: /success.php?redirect=access-edit');
			break;

		case 'delete-assignment':
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if (isset($_GET['assignment-id'])){
					$aid = $_GET['assignment-id'];

					try {
						

						$sql = "DELETE FROM users_assignment WHERE id = :aid ";

						$stmt = $conn->prepare($sql);
						$stmt->bindParam(':aid', $aid);
						
						$stmt->execute();

						
						

						echo "successfully deleted assignment: ".$aid;
						?>
						<script type="text/javascript">
					
							window.location.replace("/success.php?redirect=delete-assignment");
						</script>
				<?php

					}

					catch (Exception $e) {
						echo 'Connection failed: ' . $e->getMessage();
						$conn->rollBack();
					} // end catch
				}else{
					echo "no user selected";
				}
				

		break;

		case 'delete-accesslvl':
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if (isset($_GET['accesslvl-id'])){
					$aid = $_GET['accesslvl-id'];

					try {
						

						$sql = "DELETE FROM users_accesslvl WHERE id = :aid ";

						$stmt = $conn->prepare($sql);
						$stmt->bindParam(':aid', $aid);
						
						$stmt->execute();

						
						

						//echo "successfully deleted access group: ".$aid;
						?>
						<script type="text/javascript">
					
							window.location.replace("/success.php?redirect=delete-accesslvl");
						</script>
				<?php

					}

					catch (Exception $e) {
						echo 'Connection failed: ' . $e->getMessage();
						$conn->rollBack();
					} // end catch
				}else{
					echo "no user selected";
				}
				

		break;


		default:
			echo "i don't know what you did!"; 
			break;
	}
}

?>