<?php //logout.php
include ("/resources/class-lib/utility.php");

session_start();
session_destroy();

// after logout, call to static method redirect with values set for redirect
Utility::redirect('', 'index.html', 'response', '0C03-logout-success');


?>