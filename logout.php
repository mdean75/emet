<?php //logout.php
session_start();
include ($_SERVER['DOCUMENT_ROOT']."/resources/class-lib/utility.php");


session_unset();
session_destroy();

// after logout, call to static method redirect with values set for redirect
utility::redirect('', 'index.php', 'response', '0C03-logout-success');


?>