<?php //login.action.php
require_once "functions.php";
session_start();

ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

require_once "../resources/dbcon.php";
/*
This is the code to stop excessive login attempts. At the 3rd attempt and above a captcha must be answered correctly
and after 5 failed attempts the user is denied access using the user agent for identification.

I still need to set up a database table to log denied users with a timestamp. After 5 minutes the user may make 3 further 
attempts before being locked out again.  Then after a 15 minute wait the user agent will be allowed to try again 3 more times before being locked out for 24 hours.
*/

if (($_SESSION['a']) > 5 && $_GET['ua'] == "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063 "){
	echo "You have been blocked!";
	exit;

}
// check if submit button has been clicked to prevent directly accessing this page

if(!isset($_GET['submit'])){

	header('location: ../njcad/login.php?tryingtodebugthis');

	//check if username or password fields are empty(should not happen due to client side validation)
}elseif (empty($_GET['username']) || empty($_GET['password'])) { 

		// reloads login page with alert telling user both fields are required

		header('location: ../njcad/login.php?retry');
				
}else{

	//sets submitted username and password to variables

	$user = $_GET['username'];
	$pass = $_GET['password'];	
	
	//$hash_input_password = password_hash($password, PASSWORD_DEFAULT);

	}

	// PDO prepared stmts
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare('SELECT * FROM users_auth WHERE username = ?');	
		$stmt->execute(array($user));

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		while ($row = $stmt->fetch()) {
				
				$userid = $row['userid'];
			  	$dbpassword = $row['password'];
			    $dbuser = $row['username'];
			    $accesslvl = $row['accesslvl'];
		}// end while

	}// end try
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	} // end catch

	if (empty($dbpassword)){

		header('location: ../login.php?retry');
	}else{// else 1

		if (!password_verify($pass, $dbpassword)){ // user credentials are correct
			// passwords did not match
			header('location: ../login.php?retry');
		}else{// else 2

			if (isset($_GET['captcha_code'])){

				require_once '../securimage/securimage.php';

				$securimage = new Securimage();

				if ($securimage->check($_GET['captcha_code']) == false) {
  					// the code was incorrect
  					// you should handle the error so that the form processor doesn't continue

  					// or you can use the following code if there is no validation or you do not know how
  					echo "The security code entered was incorrect.<br /><br />";
  					echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
 					exit;
				}// end if securimage check
			}// if isset captcha code

						
			unset($_SESSION['a']);		
			$_SESSION['canary'] = time();
			$_SESSION['username'] = $dbuser;
			$_SESSION['userid'] = $userid;
			$_SESSION['accesslvl'] = $accesslvl;
			echo "the user agent string is: ".$_GET['ua'];
			echo "<br>the ip is: ".$_GET['ip'];

			

			header('location: /admin-menu.php');	
		}// else 2
		} // else 1
			
		
	
?>
