<?php 

session_start();
include_once("../config/config.php");

if(isset($_POST['logout'])){
    unset($_SESSION['authUser']);
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    session_destroy();
      header("Location: /E-commerce/public/users/index");
            exit(0);
}
?>