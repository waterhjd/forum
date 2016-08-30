<?php
session_start();
require_once("login.php");

//If a session exists we are logged in
if($_SESSION["loggedIn"])
{
   echo "true";
}
//If a session doesn't exist but a cookie does we have a returning user 
// that clicked remember me and we should atttempt to relog them by
// creating a new session based on thier cookie contents
else if (isset($_COOKIE["cookiemonster"]))
{
   $login = new login();
   $loginInfo = $_COOKIE["cookiemonster"];
   $username =  $login->cookieLogin($loginInfo);
   echo $username;
   echo "Cookie set for " . $_COOKIE["cookiemonster"];
}
else
{
   echo "false";
}
?>
