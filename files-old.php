<?php
// full title to display on larger screens
$page_title = "Shift Log File Browser";
// shortened page title for mobile devices
$page_title_short = "Shift Logs";
//$path = __DIR__;
if (isset($_GET['dir'])) {
	$dir = 'files/'.$_GET['dir'].'/';
	$path = $_SERVER['DOCUMENT_ROOT'].'/files/'.$_GET['dir'];
}else {
	$dir = 'files/';
	$path = $_SERVER['DOCUMENT_ROOT'].'/files';
}
//echo "basename: ".basename($dir)."<br>";
echo $path;
//echo $dir;
//echo dirname(__FILE__);
echo "<br>";
//$dir = basename($dir);
//echo $dir;
$files = array_slice(scandir($path), 2);

echo $dir;
print_r($files);
//var_dump($files);
//
echo "<br>";
foreach ($files as $file ) {
	
	if(is_file($dir.$file)) {
		?>
		<a href="<?php echo $dir.$file; ?>">file: <?php echo $file; ?></a>
		<br>
		<?php
	}else{
		?>
		<a href="files.php?dir=<?php echo $file; ?>">dir: <?php echo $file; ?></a>
		<br>
		<?php
	}




	
}


?>


<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>Syd*
<body>

<?php 

  require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');


?>

</body>
</html>