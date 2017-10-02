<?php //manageListAction.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$db = new database;

if (!isset($_POST['submit'])) {
	echo "Error: you cannot browse directly to this page, please retry";
	utility::js_redirect('', 'admin-menu.php', 'status-code', 'error');

}else {
	
	switch ($_POST['submit']) {
		case 'new-access':
			echo "you submitted a new access level<br>";
			$access_name = $_POST['new_access_name'];
			$access_value = $_POST['new_access_value'];

			try {
				
				$sql = "INSERT INTO users_accesslvl (accesslvl_name, accesslvl_value) VALUES (:access_name, :access_value)";
				$db->query($sql);
				$db->bind(':access_name', $access_name);
				$db->bind(':access_value', $access_value);
				$db->execute();

				header('location: /success.php?redirect=access-add');
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch
			
			break;
		
		case 'new-assignment':
			echo "you submitted a new assignment<br>";
			$assignment = $_POST['new_assignment'];

			try {
				$sql = "INSERT INTO users_assignment (assignment_name) VALUES (:assignment)";
				$db->query($sql);
				$db->bind(':assignment', $assignment);
				$db->execute();

				header('location: /success.php?redirect=assignment-add');
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
					
			break;

		case 'edit-assignment':
			
			$assignmentId = $_POST['assignmentId'];
			$assignmentName = $_POST['assignmentName'];

			try {
				$sql = "UPDATE users_assignment SET assignment_name = :assignmentName WHERE id=:assignmentId";	
				$db->query($sql);
				$db->bind(':assignmentId', $assignmentId);
				$db->bind(':assignmentName', $assignmentName);
				$db->execute();
				
				utility::redirect('', 'success', 'redirect', 'assignment-edit');
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
			break;

		case 'edit-access':
			
			$accessId		= $_POST['accessId'];
			$accessName 	= $_POST['accessName'];
			$accessValue	= $_POST['accessValue'];

			try {
				$sql = "UPDATE users_accesslvl SET accesslvl_name=:accessName, accesslvl_value=:accessValue WHERE id=:accessId";
				
				$db->query($sql);
				
				$db->bind(':accessId', $accessId);
				$db->bind(':accessName', $accessName);
				$db->bind(':accessValue', $accessValue);
				$db->execute();
				
				utility::redirect('', 'success', 'redirect', 'access-edit');
			}
			catch (Exception $e) {
				echo 'Database query failed: ' . $e->getMessage();
			} // end catch	
			
			break;

		case 'delete-assignment':
				
				if (isset($_POST['assignment-id'])){
					$aid = $_POST['assignment-id'];

					try {
						
						$sql = "DELETE FROM users_assignment WHERE id = :aid ";

						$db->query($sql);
						$db->bind(':aid', $aid);
						
						$db->execute();

						echo "successfully deleted assignment: ".$aid;
						
						utility::redirect('', 'success', 'redirect', 'delete-assignment');
					
					}

					catch (Exception $e) {
						echo 'Connection failed: ' . $e->getMessage();
						$db->rollback();
					} // end catch
				}else{
					echo "no user selected";
				}
				

		break;

		case 'delete-access':
			
				if (isset($_POST['accesslvl-id'])){
					$aid = $_POST['accesslvl-id'];

					try {
						
						$sql = "DELETE FROM users_accesslvl WHERE id = :aid ";

						$db->query($sql);
						$db->bind(':aid', $aid);
						
						$db->execute();

						utility::redirect('', 'success', 'redirect', 'delete-accesslvl');
						
					}

					catch (Exception $e) {
						echo 'Connection failed: ' . $e->getMessage();
						$db->rollback();
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