<?php
require_once("login.php");

session_start();
$login = new login();
if($login->logout($_SESSION["loggedIn"]))
   echo "true";
else 
   echo "false";

?>
