<?php
   require_once("login.php");
   session_start();
   
   $username = filter_var($_POST["username"], FILTER_SANITIZE_MAGIC_QUOTES);
   $password = filter_var($_POST["password"], FILTER_SANITIZE_MAGIC_QUOTES);
   $remember = $_POST["remember"];

   $login = new login;
   if($login->checkLogin($username, $password, $remember))
      echo "true";
   else 
      echo "false";
?>
