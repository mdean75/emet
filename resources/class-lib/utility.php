<?php //utility.php

Class utility {

	// method to redirect page 
	// requires 4 values passed in as follows:
	// first is path of target
	// second is the script or page name
	// third is the name of the get variable
	// fourth is the value of the get variable

	// for root folder $path should be passed in null string ''
	// all other should have proper values passed
	// while technically valid $get and $value will also accept null string
	// however url will look odd and will not be able to process action
	// based on get variable or value

	public static function checkForLogin($redirect) {
		if (empty($_SESSION)) {
			$_SESSION['redirect'] = $redirect;
			header('location: /oop.login.php');
			die;
			//utility::redirect('', 'oop.login.php', 'status-code', '3X31');
		}
	}

	public static function redirect($path, $script, $get, $value) {

		header ('location: /'.$path.$script.'?'.$get.'='.$value);
		die;
	}

	// this method works the same as static method redirect, however
	// instead of a redirect it refreshes after 5 seconds.  This method
	// should be used after displaying an error message 
	public static function refresh_redirect($path, $script, $get, $value) {

		header('refresh:5; url=/'.$path.$script.'?'.$get.'='.$value);
	}

	// this method uses javascript to redirect after a short delay
	// this method of redirect must be used when part of the page has displayed
	// for example, when an error message is display prior to redirecting
	public static function js_redirect($path, $script, $get, $value) {
		echo '
			<script type="text/javascript">';
		

    	echo 'setTimeout(function(){';
    	echo '	window.location.href = "/'.$path.$script.'?'.$get.'='.$value.'";';	
    	echo '}, 5000);';

		echo '</script>';
		
	}

	// this method checks if user has priveledges to view a given page
	// $page_security variable is set on each page to determine what accesslvl
	// is required to view the page, lower values have lower priveledges (ie. guest is 0 and admin is 9).
	// Requires 5 values: $page_security + the four redirect values.

	// If user does not have required priveledges, a message is displayed and the rest of the page load 
	// is stopped.  After 5 seconds the page is refreshed by call to static method refresh_redirect
	public static function restrict_page_access($page_security, $path, $script, $get, $value) {
		if (isset($_SESSION['accesslvl'])) {
			if ($_SESSION['accesslvl'] < $page_security) {
				$_SESSION['error'] = "Error: You do not have the required permissions!";
				
        		 
        		self::refresh_redirect($path, $script, $get, $value);
        		//self::js_redirect($path, $script, $get, $value);
        		
				//die;
			} 
			
		} else{
			self::redirect('', 'oop.login.php', 'status-code', 'no-session');
		}
	} // end method restrict_page_access
}

?>