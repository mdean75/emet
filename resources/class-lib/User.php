<?php

Class User {
	private $user; // user submitted user name from login form
	private $pass; // user submitted password from login form

	private $userid; 		// fetched userid from database
	private $dbpassword;	// fetched password from database
	private $dbuser;		// fetched username from database
	private $accesslvl;		// fetched access level from database
	
	// construct method receives user entered username and password and assigns to class variables
	public function __construct($user, $pass) {
		$this->user = $user;
		$this->pass = $pass;

		$this->check_vars();
	} // end of constructor method

	// static method to hash password before storing in db
	static function hash_password($pass) {
		
		return password_hash($pass, PASSWORD_DEFAULT);
	}

	// static method to check if there is a user session and regenerate ID
	static function regenerate_session () {
		if (!isset($_SESSION['last_activity_time'])){
			utility::redirect('', 'oop.login.php', 'status-code', '3X31');

		}elseif ($_SESSION['last_activity_time'] < time() - 300) {
			session_regenerate_id(true);
			$_SESSION['last_activity_time'] = time();
		}
	}
	
		// method to check that username and password are not empty
	public function check_vars() {
		
		if (empty($this->user) || empty($this->pass)) { 

			// call to static redirect method and passing in get variable and value
			//self:
			Utility::redirect('', 'oop.login.php', 'status-code', '4X32');
				
		}else{
			// if both variables are set, continue to login
			$this->login();  

		} // end else
			
	} // end method check_vars

	// this method instantiates database class and controls the authentication process
	public function login() {

		$db = new database;
		
		// search database for a record matching the user entered username
		$db->query('SELECT * FROM users_auth WHERE username = :username');
		$db->bind(':username', $this->user);

		// no user by that name in the database
		if (empty($db->resultset())){
			utility::redirect('', 'oop.login.php', 'status-code', '4X31' );
			
		}else {
			$rows = $db->resultset();
			$count = count($rows);
			//echo $count;
			
			// there should only be 1 record matching the username supplied, if more or less
			// something is amiss
			if ($count = 1){
				foreach ($rows as $row) {
				
				$this->userid = $row['userid'];
				$this->dbpassword = $row['password'];
				$this->dbuser = $row['username'];
				$this->accesslvl = $row['accesslvl'];
				
			
				} // end foreach
			// the else porttion should never run as we have checked for empty results above
			// and there should not be multiple users with same username in the database
			// note: the insert and update user pages check for duplicate name and email so 
			// this would be an error or something else going on such as database corruption
			} else {
				utility::redirect('', 'index.html', 'status-code', '5X99' );

			}// end if ... else count results
		} // end if ... else empty resultset
		echo $this->dbuser;
				
		// we have return a valid username and retrieved the following data to prepare for 
		// authentication:
		//					database stored username
		//					database stored hashed password
		//					database stored userid
		//					database stored access level - used to set session variable after success
		$this->authenticate();

	} // end method login

	public function authenticate() {
		
			// user credentials are incorrect, passwords did not match, pause script
			// to increase time cost if attacker, then redirect to retry
			if (!password_verify($this->pass, $this->dbpassword)){ 
				sleep(3);
				
				Utility::redirect('', 'oop.login.php', 'status-code', '4X33');
				
			}else{ // else 
				// after multiple failed attempts the captcha code is set
				// code to process captcha
				if (isset($_POST['captcha_code'])){

					require_once '../securimage/securimage.php';

					$securimage = new Securimage();

					if ($securimage->check($_POST['captcha_code']) == false) {
  					// the code was incorrect
  					// you should handle the error so that the form processor doesn't continue

  					// or you can use the following code if there is no validation or you do not know how
  					echo "The security code entered was incorrect.<br /><br />";
  					//User::login_redirect('retry', 'invalid_captcha');
  					Utility::redirect('', 'oop.login.php', 'status-code', '4X34');
  					//echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
 					exit;
					}// end if securimage check
				}// if isset captcha code

				echo "Success!";

				// user credentials are good, set session variables
				$this->set_session();
				
			}// else 

	} // end function authenticate

	public function set_session() {
		
		$_SESSION['last_activity_time'] = time();
		$_SESSION['username'] = filter_var($this->dbuser, FILTER_SANITIZE_STRING);
		$_SESSION['userid'] = filter_var($this->userid, FILTER_SANITIZE_STRING);
		$_SESSION['accesslvl'] = filter_var($this->accesslvl, FILTER_SANITIZE_NUMBER_INT);

		
		Utility::redirect('', 'admin-menu.php', 'status-code', '3X01');
	}
	
} // end class


?>

		

		
	