<?php
session_start();
require_once "functions.php";

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

if (!isset($_SESSION['redirect'])) {
	$_SESSION['redirect'] = '';
}

//ini_set('session.use_only_cookies', 1);
//ini_set('session.cookie_httponly', 1);
//ini_set('session.cookie_secure', 1);

// session was started on oop.login.php and test cookie was set
// this checks if the test cookie is set, if it is not then cookies
// must be disabled and sessions will not work so redirect to oop.login.php
// with a message for the user to enable cookies
if (!isset($_COOKIE['check_login'])) {
	utility::redirect('', 'oop.login.php', 'status-code', '4X88');
	
}//else{ echo $_COOKIE['check_login'];}

if (!isset($_POST['submit'])) {

	// if submit is not set user must have manually typed in url which is not allowed
	// if this is the case, call to static method redirect to send user to login page
	utility::redirect('', 'oop.login.php', 'status-code', '4X91');

}else{
	// submit is set, instantiate user class and pass username and password for authentication
	$user = new User(strtolower(trim($_POST['username'])), trim($_POST['password']), $_SESSION['redirect'] );
	$timestamp = new DateTime;
	error_log($timestamp->format(DateTime::RFC850)." login attempt by ".$_POST['username']." using password: ".$_POST['password'].PHP_EOL,3,"../../logs/authLog.log");
	$user->check_vars();
}


?>