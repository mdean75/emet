<?php //manage-user-action.php

ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

//require_once "dbcon.php";
require_once "functions.php";

// require Class autoload script
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');


if (!isset($_POST['submit'])) {
	
	echo "Error: you cannot browse directly to this page, please retry";
	utility::redirect('', 'index.php', 'status-code', '4X91');
		
}else {
	// instantiate database class
	$db = new database;

	switch ($_POST['submit']) {
		case 'add-user':
			if (empty($_POST['fname']) || 
				empty($_POST['lname']) || 
				empty($_POST['email']) || 
				empty($_POST['username']) || 
				empty($_POST['alevel']) || 
				empty($_POST['assignment'])){

				utility::redirect('admin/user/', 'add-user.php', 'status-code', '4X41');
					

			}else{
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$user = $_POST['username'];
				$alevel = $_POST['alevel'];
				$assignment = $_POST['assignment'];
				$medic = $_POST['medic'];
				$phone = $_POST['phone'];
				$altphone = $_POST['altphone'];
				$pass = generateRandomString(16);
				$hash_input_password = User::hash_password($pass);
				$length = 64;
				$token = generateRandomString($length).date('timestamp');
				$expire  = time() + (60 * 60 * 24);
				
			}

				
				// this first query is only to determine if username or email has already been used
				// prepare query with question mark placeholders
				$db->query('SELECT COUNT(userid) FROM users_auth WHERE username = ? OR email = ?');
				
				// build array to pass to PDO execute
				$arr = array('user' => $user, 'email' => $email);
				
				// execute query and get result, if value is not = 0, 
				// either the user name or email has already been used
				if ($db->execute_array($arr) != 0) {
					
					utility::redirect('admin/user/', 'add-user.php', 'status-code', '4X42');
					die;
				}

				// use transaction query to insert data into users_auth and users_profile tables
				$db->begin_trans();

			
				try {
					// prepare query for authentication fields
					$db->query("INSERT INTO users_auth (username, password, email, accesslvl, token, tokenExpiration) 
								VALUES (:user, :pass, :email, :accesslvl, :token, :tokenExpiration)");
					// bind values
					$db->bind(':user', $user);
					$db->bind(':pass', $hash_input_password);
					$db->bind(':email', $email);
					$db->bind(':accesslvl', $alevel);
					$db->bind(':token', $token);
					$db->bind(':tokenExpiration', $expire);

					// execute first query
					$db->execute();

					// get insert record id for use in next query
					$last_record = $db->last_id();
					
					// prepare query for profile fields
					$db->query("INSERT INTO users_profile (userid, fname, lname, assignment, medic_num, phone, alt_phone) 
								VALUES (:uid, :fname, :lname, :assignment, :medic_num, :phone, :altphone)");

					// bind values
					$db->bind(':uid', $last_record);
					$db->bind(':fname', $fname);
					$db->bind(':lname', $lname);
					$db->bind(':assignment', $assignment);
					$db->bind(':medic_num', $medic);
					$db->bind(':phone', $phone);
					$db->bind(':altphone', $altphone);
	
					// execute second query
					$db->execute();

					// commit both queries
					$db->commit();

					// send email to user about account creation
					newAccountSendMail($user, $token, $email);
					
					// redirect on successful add
					utility::redirect('', 'success.php', 'redirect', 'user-add');
				
					
				} // end of try statement

				catch (Exception $e) {
					echo 'Connection failed: ' . $e->getMessage();
					$db->rollback();
				} // end catch
 
		break;

		case 'delete-user':
				
				if (isset($_POST['userid'])){
					$id = $_POST['userid'];

					try {
						// use transaction query to delete data from users_auth and users_profile tables
						$db->begin_trans();

						// prepare query for authentication fields
						$db->query("DELETE FROM users_auth WHERE userid = :id ");

						// bind value
						$db->bind(':id', $id);
						
						// execute first query
						$db->execute();
						
						// prepare query for profile fields
						$db->query("DELETE FROM users_profile WHERE userid = :id ");

						// bind value
						$db->bind(':id', $id);

						//execute second query
						$db->execute();

						// commit both queries
						$db->commit();

						// redirect on successful delete
						utility::redirect('', 'success.php', 'redirect', 'user-delete');
						

					}

					catch (Exception $e) {
						echo 'Connection failed: ' . $e->getMessage();
						
						$db->rollback();
					} // end catch
				}else{
					echo "no user selected";
				}
				

		break;

		case 'edit-user':
			if (empty($_POST['fname']) || 
				empty($_POST['lname']) || 
				empty($_POST['email']) || 
				empty($_POST['username']) || 
				empty($_POST['alevel']) || 
				empty($_POST['assignment'])){

				// header redirect back to try again because of empty fields
				utility::redirect('admin/user/', 'edit-user.php', 'status-code', '4X41');
				
			}else{
				$id = $_POST['userid'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$user = $_POST['username'];
				$alevel = $_POST['alevel'];
				$assignment = $_POST['assignment'];
				$medic = $_POST['medic'];
				$phone = $_POST['phone'];
				$altphone = $_POST['altphone'];
				$pass = generateRandomString(16);
				$hash_input_password = User::hash_password($pass);
			}

				// check to 
				//$db = new database;
				$db->query("SELECT COUNT(userid) 
						FROM users_auth 
						WHERE (username = ?
						OR email = ?) 
						AND userid <> ?");
				$arr = array('user' => $user, 'email' => $email, 'userid' => $id);

				if ($db->execute_array($arr) != 0) {
					// header redirect back to try again because of duplicate user or email
					utility::redirect('admin/user/', 'edit-user.php', 'status-code', '4X42');
					die;
				}

				$db->begin_trans();

				try {

					$db->query("UPDATE users_auth SET username=:user, email=:email, accesslvl=:alevel WHERE userid=:id");
				
					$db->bind(':id', $id);
					$db->bind(':user', $user);
					$db->bind(':email', $email);
					$db->bind(':alevel', $alevel);

					$db->execute();

					$db->query("UPDATE users_profile SET fname=:fname, lname=:lname, assignment=:assignment, medic_num=:medic_num, phone=:phone, alt_phone=:altphone WHERE userid=:id");


					$db->bind(':id', $id);
					$db->bind(':fname', $fname);
					$db->bind(':lname', $lname);
					$db->bind(':assignment', $assignment);
					$db->bind(':medic_num', $medic);
					$db->bind(':phone', $phone);
					$db->bind(':altphone', $altphone);

					$db->execute();

					$db->commit();

					utility::redirect('', 'success.php', 'redirect', 'user-edit');
					
				} // end of try statement

				catch (Exception $e) {
					echo 'there was an error with the sql: ' . $e->getMessage();
					$db->rollback();
				} // end catch

		break;
				

		case 'reset-change-password':
			// must start session to use session variables previously set
			session_start();

			$id = $_SESSION['id'];
			$newPassword = $_POST['new-password'];
			$confirmPassword = $_POST['confirm-password'];
			$user = $_SESSION['uname'];
			$email = $_SESSION['email'];

			// passwords dont' match, redirect to retry
			if ($newPassword != $confirmPassword) {
				utility::redirect("", "reset-password-step2.php", "status-code", "4X33");
				die;
				      
			}else{
				// hash password before updating database
				$newPassword = User::hash_password($newPassword);

				
			}
			// use transactions for updates, first query updates the password, if that succeeds then remove the token and token expiration
			$db->begin_trans();

			try {
				// first change the password
				$db->query("UPDATE users_auth SET password = :password WHERE userid = :id");
				$db->bind(':password', $newPassword);
				$db->bind(':id', $id);

				
				$db->execute();
				// then remove the token and token expiration

				$db->query("UPDATE users_auth SET token = NULL, tokenExpiration = NULL WHERE userid = :id");
				$db->bind(':id', $id);
				
				$db->execute();

				$db->commit();

				// after success unset the session variables
				session_unset();
			}

			catch (Exception $e) {
					echo 'there was an error with the sql: ' . $e->getMessage();
					$db->rollback();
				} // end catch

			utility::redirect('', 'success.php', 'redirect', 'change-password');
			

		break;

		case 'forgot-password':
			$email = $_POST['email'];
			$user = $_POST['username'];

			
			$db->query("SELECT COUNT(userid) FROM users_auth WHERE (username = ? AND email = ?) ");
    		$arr = array('username' => $user, 'email' => $email );

    		if ($db->execute_array($arr) != 1) { 

    			// either no results returned or more than 1, either way
    			// this is invalid so redirect and try again
    			utility::redirect('', 'forgot-password.php', 'status-code', '4X31');
    			
    		}else{

    		$db->query("SELECT userid FROM users_auth WHERE (username = :user AND email = :email) ");
    		$db->bind(':user', $user);
    		$db->bind(':email', $email);

    		$row = $db->resultset();
    		    		
    		foreach ($row as $rows) {
    			$uid = $rows['userid'];
    		}
    		
      			try {

					$pass = generateRandomString(16);
					$hash_input_password = User::hash_password($pass);
					$length = 64;
					$token = generateRandomString($length).date('timestamp');
					$expire  = time() + (60 * 60 * 24);

					$db->query("UPDATE users_auth SET password=:password, token=:token, tokenExpiration=:tokenExpiration WHERE userid=:uid");
				
					$db->bind(':password', $hash_input_password);
					$db->bind(':token', $token);
					$db->bind(':tokenExpiration', $expire);
					$db->bind(':uid', $uid);

					$db->execute();

					forgotPasswordSendMail($user, $token, $email);
					utility::redirect('', 'success.php', 'redirect', 'forgot-password');
					
					
				}
				

				catch (Exception $e) {
					echo 'there was an error with the sql: ' . $e->getMessage();
				
				} // end catch

      		}

		break;

		case 'change-password':

			$id = $_GET['db-id'];
			$currentPassword = $_GET['currentPassword'];
			$newPassword = $_GET['newPassword'];
			$confirmPassword = $_GET['confirmPassword'];
			$db_password = $_GET['db-password'];

			if (!password_verify($currentPassword, $db_password)){
				utility::redirect('', 'change-password.php', 'retry', 'wrongpass');
				
			}

				if ($newPassword != $confirmPassword) {
					utility::redirect('', 'change-password.php', 'retry', 'nomatch');
					echo "passwords did not match";
					break;
				}else{
					$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				}
			

			try {
				//  change the password
				$sql = "UPDATE users_auth SET password = :newpass WHERE userid = :id ";
				$db->query($sql);
				$db->bind(':newpass', $newPassword);
				$db->bind(':id', $id);
				$db->execute();
			}
			catch (Exception $e) {
					echo 'there was an error with the sql: ' . $e->getMessage();
				
				} // end catch
				utility::redirect('', 'success.php', 'redirect', 'changePassword');

		break;


		default:
			echo "i don't know what you did!"; 
		break;


	}

}

?>