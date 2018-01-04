<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// full title to display on larger screens
$page_title = "Shift Log File Browser";
// shortened page title for mobile devices
$page_title_short = "Shift Logs";

$page_security = 5;

utility::checkForLogin($_SERVER['PHP_SELF']);

User::regenerate_session();

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

// declare empty arrays for files and folders
$file_array = array();
$folder_array = array();

// Initialize variables

// path to files directory
$path = '../../files';
// used to set path for folder links, blank if no get param set
$getpath = '';
// used to explode the dir parameter to go back in folder tree, 
// blank if no get param set
$pieces = '';

// GET parameter set for directory
if (isset($_GET['dir'])) {

	$path .= '/'.$_GET['dir'];



	// path to files directory
	//$path = $_SERVER['DOCUMENT_ROOT'].'/files/'.$_GET['dir'];

	// used to set path for folder links
	$getpath = $_GET['dir'].'/';
	// break GET dir into parts so we can strip away the last part of the parameter
	// used to go up a directory
	$pieces = explode('/', $_GET['dir']);
	
	// remove the last element 
	array_pop($pieces);
	// rebuild the GET parameter
	$imp = implode('/', $pieces);

	$count = count($pieces);

}/*else { // no GET parameter set 
	
	
	// must be defined, set to blank
	
}*/
// scan the directory into an array and remove the first (not needed) element
$files = array_slice(scandir($path), 1);

// sort all files/folders into separate arrays for files and folders so 
// we can display all the folders first
foreach ($files as $file ) {
	
	if(is_file($path.'/'.$file)) {
		$file_array[] = $file;
	}else{
		$folder_array[] = $file;
	}
}

// we don't want to perform a sort on an empty array
if (count($file_array > 0)) {
	rsort($file_array);
}

if (count($folder_array > 0)) {
	asort($folder_array);
	array_shift($folder_array);
}


// if the folder array contains '..' set flag to display a folder up link
if (array_search('..', $folder_array)) {
	$display_folder_back = true;
}else {
	$display_folder_back = false;
}

?>


<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		#topspace {
			padding-top: 20px;
		}
	</style>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<body>

<?php 

  require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');
?>

<div class="container">
	<div class="row">
		<div id="topspace">


		<?php
	if (isset($_GET['dir'])) {
		if (!is_null($display_folder_back)) {
			
			?>
			<div class="col-sm-3 ">
			
			<a href="files.php<?php if (count($pieces) != 0){ 
				echo '?dir='.$imp; 
				} ?>"><img class="thumbnail" src="/images/icons/filetype/Go-back-icon.png" alt="folder-image"></a>
			<label class="thumbnail-label"><?php echo "Back"; ?></label>

		</div>
		<?php
			
		}
	}

foreach ($folder_array as $folder) {
	?>
		<div class="col-sm-3 ">
			
			<a href="files.php?dir=<?php echo $getpath.$folder; ?>"><img class="thumbnail" src="/images/icons/filetype/folder.png" alt="folder-image"></a>
			<label class="thumbnail-label"><?php echo $folder; ?></label>

		</div>
		<?php
}

foreach ($file_array as $file) {
	?>
		<div class="col-sm-3 ">
			
			<a href="readfile.php?file=<?php echo $path.'/'.$file; ?>"><img class="thumbnail" src="/images/icons/filetype/text.png" alt="page-image"></a>
			<label class="thumbnail-label"><?php echo $file; ?></label>

		</div>
	</div>
		<?php
}

?>
		

	</div>
	
	
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");

?>

</body>
</html>