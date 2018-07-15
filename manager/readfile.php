<?php
session_start();

if (isset($_GET['file'])) {
	$file = $_GET['file'];
}else {
	$file = 'nothing found';
}

// explode the GET parameter to an array so we can extract the month and year
$exp = explode('/', $_GET['file']);

// remove the first 2 array elements which we don't need or want
$exp = array_slice($exp, 2);

// first array element is the year
$year = $exp[0];

// second array element is the filename which begins with the 3 character month.  
// extract the first 3 characters to display the month
$month = substr($exp[1], 0, 3);

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// full title to display on larger screens
$page_title = "Shift Log Report for ".$month.". ".$year;
// shortened page title for mobile devices
$page_title_short = "Shift Log File";

$page_security = 7;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');
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




<div class="container-fluid">
	<div class="row">
		<br>
		<div class="">
			<a href="javascript:window.history.go(-1)"><img src="/images/icons/filetype/Go-back-icon.png" alt="folder-image"></a>
		</div>
    </div>


		<div class="col-md-12"><br>
<?php

//readfile($file);
echo '<pre>' . file_get_contents($file) . '</pre>';


?>

		
	</div>
</div>


</body>
</html>