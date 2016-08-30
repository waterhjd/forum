<?php

require_once("../connect/connect_db.php");

class login {
   protected $conn;

   public function __construct(){
      $db = new Connection;
      $this->conn = $db->getConnection(); 
   }

   // Check username and password are correct and exist in database
   function isValidUser($username, $password) {
      
      $stmt = $this->conn->prepare("SELECT hash FROM user WHERE username = :username");
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $hash = $row['hash'];
      if (password_verify($password, $hash))
      {
         //echo "Password is valid";
         return true;
      } else {
         //echo "Password is invalid";
         return false;
      }
   }
   
   // Check If the session exists in the database
   // If not the cookie is expired or the cookie is a fake
   function isValidCookie($session) {
      $stmt = $this->conn->prepare("SELECT username FROM user WHERE session = :session");
      $stmt->bindParam(':session', $session);
      $stmt->execute();

      //Fetch As Associative Array 
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row['username'];
   }

   // Update existing session or create a new one
   function newSession($username, $session) {
      $stmt = $this->conn->prepare("UPDATE user SET session=:session WHERE username = :username");
      $stmt->bindParam(':session', $session);
      $stmt->bindParam(':username', $username);
      if ($stmt->execute()){
         return true;
      } else {
         return false;
      }
   }
   // Log in using existing cookie
   function cookieLogin($session)
   {
      $username = $this->isValidCookie($session);
      echo $loginInfo;
      if(isset($username))
      {
         $_SESSION["loggedIn"] = $username;
         return true;
      }
      return false;
   }
   
   //check to see if login is valid
   function checkLogin($username, $password, $remember) {   
      if(($username != "") && ($password != ""))
      {
         // Validate the user
         if ($this->isValidUser($username, $password))
         {
            //If we should remember the user
            if ($remember)
            {
               $cookie =  password_hash($username.mt_rand(), PASSWORD_DEFAULT); 
               $content = $_COOKIE["cookiemonster"];
               setcookie ('cookiemonster', $cookie, time()+60*60*24*6004, "/");
            } else {
               // If we want to be unremembered we'll set our cookie to null in database and 
               // delete our cookie
               setcookie('cookiemonster', '', time()-3600, '/');
               unset($_COOKIE['cookiemonster']);
               $cookie = NULL;
            }
            $this->newSession($username, $cookie); 

            // Create a browser session 
            $_SESSION["loggedIn"] = $username;
            return true;
         }
         
      }
      
      return false;
   }

   //Logout user 
   function logout($username) {
      // Set database session to NULL
      $this->newSession($username, NULL);
      //Expire cookie
      if(isset($_COOKIE["cookiemonster"]))
      {
         setcookie('cookiemonster', '', time()-3600, '/');
         //Unset cookie
         unset($_COOKIE['cookiemonster']);
      }
      //unset session
      if(isset($_SESSION["loggedIn"]))
      {
         session_destroy();
         return true;
      }
      return false;
   }
    
   function __destruct() {
      $this->conn = NULL;
   }
   
}

?>
