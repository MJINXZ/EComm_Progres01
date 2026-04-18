<?php 
session_start();
include_once(__DIR__ . "/../../app/config/config.php");


if(!isset($_SESSION['authUser'])){
    $_SESSION['message'] = "Go login lah";
    $_SESSION['code'] = "warning";
         header("Location: /E-commerce/public/login");
            exit();

} else {

if($_SESSION['userRole'] !== 'admin'){
    $_SESSION['message'] = "no permission ";
    $_SESSION['code'] = "warning";
         header("Location: /E-commerce/public/index");
            exit();

}


}
?>
