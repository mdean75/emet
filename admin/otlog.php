<?php //log.php

session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Review Authentication Log";
// shortened page title for mobile devices
$page_title_short = "Authentication Log";

$page_security = 7;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

$logFile = '../../logs/otLog.log';
?>

<!DOCTYPE html>
<html>
<head>
	
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
<?php 

require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');

?>

  
  
</nav>

<div class="container">
	<div class="row row-grid">
		<br>
		
		
		<div><br>
<?php
			echo '<pre>' . file_get_contents($logFile) . '</pre>';

?>
		</div>
	</div>
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>