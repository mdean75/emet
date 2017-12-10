<?php //manageListAction.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$db = new database;

if (!isset($_POST['submit'])) {
	echo "Error: you cannot browse directly to this page, please retry";
	utility::js_redirect('', 'admin-menu.php', 'status-code', 'error');

}else {
	
	switch ($_POST['submit']) {
		case 'new-access':

			if (isset($_POST['new_access_name'])){
			
				$access_name = ucfirst(strtolower(trim($_POST['new_access_name'])));
				$access_value = trim($_POST['new_access_value']);

				try {
					
					$sql = "INSERT INTO users_accesslvl (accesslvl_name, accesslvl_value) VALUES (:access_name, :access_value)";
					$db->query($sql);
					$db->bind(':access_name', $access_name);
					$db->bind(':access_value', $access_value);
					$db->execute();

					utility::redirect('', 'success.php', 'redirect', 'access-add');
				}
				catch (Exception $e) {
					echo 'Database query failed: ' . $e->getMessage();
				} // end catch
			}else{
					echo "ERROR!";
			}
			
			break;
		
		case 'new-assignment':
			if (isset($_POST['new_assignment'])){
				$assignment = ucfirst(strtolower(trim($_POST['new_assignment'])));

				try {
					$sql = "INSERT INTO users_assignment (assignment_name) VALUES (:assignment)";
					$db->query($sql);
					$db->bind(':assignment', $assignment);
					$db->execute();

					utility::redirect('', 'success.php', 'redirect', 'assignment-add');
					
				}
				catch (Exception $e) {
					echo 'Database query failed: ' . $e->getMessage();
				} // end catch	
			}else{
					echo "ERROR!";
			}
						
			break;

		case 'edit-assignment':
			if (isset($_POST['assignmentId'])){

				$assignmentId = $_POST['assignmentId'];
				$assignmentName = ucfirst(strtolower(trim($_POST['assignmentName'])));

				try {
					$sql = "UPDATE users_assignment SET assignment_name = :assignmentName WHERE id=:assignmentId";	
					$db->query($sql);
					$db->bind(':assignmentId', $assignmentId);
					$db->bind(':assignmentName', $assignmentName);
					$db->execute();
					
					utility::redirect('', 'success.php', 'redirect', 'assignment-edit');
				}
				catch (Exception $e) {
					echo 'Database query failed: ' . $e->getMessage();
				} // end catch	

			}else{
					echo "no user selected";
			}
			
			break;

		case 'edit-access':
			if (isset($_POST['accessId'])){
				$accessId		= $_POST['accessId'];
				$accessName 	= ucfirst(strtolower(trim($_POST['accessName'])));
				$accessValue	= trim($_POST['accessValue']);

				try {
					$sql = "UPDATE users_accesslvl SET accesslvl_name=:accessName, accesslvl_value=:accessValue WHERE id=:accessId";
					
					$db->query($sql);
					
					$db->bind(':accessId', $accessId);
					$db->bind(':accessName', $accessName);
					$db->bind(':accessValue', $accessValue);
					$db->execute();
					
					utility::redirect('', 'success.php', 'redirect', 'access-edit');
				}
				catch (Exception $e) {
					echo 'Database query failed: ' . $e->getMessage();
				} // end catch	
			}else{
					echo "no user selected";
			}

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
						
						utility::redirect('', 'success.php', 'redirect', 'delete-assignment');
					
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

						utility::redirect('', 'success.php', 'redirect', 'delete-accesslvl');
						
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
			print_r($_POST);
			break;
	}
}

?>