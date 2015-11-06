<?php
session_start();
//include system filesize

require_once("config.php");
include_once("system/db.php");
$db = new DB("boschpromo");
include_once "system/view.php";
include_once "system/routing.php";

//----------------

loadPage();




/* 
switch ($array[1]){
	case "": 
		echo "Main Page";
		break;
	case "registration":
		echo "Registration";
		break;
	case "autorisation":
		echo "Autorisation";
		break;
	default:
		echo "Main Page";
		break;
} */



/* echo "<pre>";
var_dump ($_SERVER);
echo "</pre>"; */


?>