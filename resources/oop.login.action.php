<?php

require_once "functions.php";

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

session_start();

ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

// session was started on oop.login.php and test cookie was set
// this checks if the test cookie is set, if it is not then cookies
// must be disabled and sessions will not work so redirect to oop.login.php
// with a message for the user to enable cookies
if (!isset($_COOKIE['check_login'])) {
	Utility::redirect('', 'oop.login.php', 'status-code', '4X88');
	
}//else{ echo $_COOKIE['check_login'];}

if (!isset($_POST['submit'])) {

	// if submit is not set user must have manually typed in url which is not allowed
	// if this is the case, call to static method redirect to send user to login page
	Utility::redirect('', 'oop.login.php', 'status-code', '4X91');

}else{
	// submit is set, instantiate user class and pass username and password for authentication
	$user = new User($_POST['username'], $_POST['password']);
}


?>