<?php
require_once("../connect/connect_db.php");

class userSetup {
   protected $conn;

   function __construct() {
      $db = new Connection;
      $this->conn = $db->getConnection();
   }

   // Check for duplicate usernames
   function checkUsername($username) {
      if(preg_match('/[^a-z_\-0-9]/i', $username))
      {
         echo "bad username";
         return false;
      }
      $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = :username");
      $stmt->bindParam(":username", $username);
      $stmt->execute();

      if($stmt->rowCount() == 0) {
         return true;
      } else {
         echo "duplicate username";
         return false;
      }
   }

   private function checkPassword($password) {
      if ((strlen($password) < 6)||(strlen($password) > 18))
      {
         return false;
      } else {
         return true;
      }
   }
 
   // Add user to the database
   function registerUser($username, $password, $confirm) {
      if ($this->checkUsername($username))
      {
         // Make sure passwords match
         if (($password == $confirm)&&($this->checkPassword($password)))
         {
            
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO user (username, hash) VALUES (:username, :hash)");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":hash", $hash);
            $stmt->execute();
            echo "success";
            
         } else {
            if ($password != $confirm)
               echo "no match";
            else 
               echo "invalid password";
         }

      }
   }
}

?>
