<?php
require_once("register.php");

$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

$register = new userSetup;

$register->registerUser($username, $password, $confirm);

?>
