<?php

// include this file on any page that requires a Class and the required Class will
// be included without needing to concern about folder structure
spl_autoload_register(function($load_class) {
  require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/class-lib/'.$load_class.'.php');
});

?>