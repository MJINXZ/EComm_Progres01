<?php 

include ("connect.php");
session_start();


/* 
Summary to everything
Added session_start (basically its the one who will contine the session or create a session using the session identifier in short para bitaw magamit nato siya if mag order soon at least ma detect kinsa mag order)
added login and register





*/

/*  Login  validation   */

if(isset($_POST['login'])) {

$email = $_POST['email'];
$password = $_POST["password"];

 if(empty($email)) {
        header("location: login.php?error=email is required");
        exit();
    } else if(empty($password)) {
        header("location:login.php?error=password is required");
        exit();
    } else {

   $stmt = $conn ->prepare("select * from users where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if($stmt_result->num_rows >0){  
        $data = $stmt_result->fetch_assoc();
        if($data['password'] === $password){
             $_SESSION['UID'] = $data['UID'];
             $_SESSION['email'] = $data['email'];
             $_SESSION['userName'] = $data['userName'];
           
               header("Location: index.php");



        }else {
            header("location: login.php?error=incorrect password");
        }

    }else {
        header("location: login.php?error=incorrect email");


    }
}  
      $stmt->close();
      $conn->close();
     

}



/* Register, with confirm password checker + empty checker (problem it resets everything but meh wcyd) */
if(isset($_POST['register'])) {
 


$firstName  = $_POST['First'];
$lastName = $_POST["Last"];
$userName = $_POST['userName'];
$email = $_POST['Email'];
$ContactNum = $_POST['Contact'];
$password = $_POST["Password"];
$CPassword = $_POST["CPassword"];


 if(empty($firstName)) {
        header("location: register.php?error=FirstName is required");
        exit();
    } else if(empty($lastName)) {
        header("location:register.php?error=lastName is required");
        exit();
    } else if(empty($email)) {
        header("location:register.php?error=Email is required");
        exit();
    }else if(empty($ContactNum)) {
        header("location:register.php?error=Contact number is required");
        exit();
    }else if(empty($userName)) {
        header("location:register.php?error=userName is required");
        exit();
    } else if(empty($password)) {
        header("location:register.php?error=Password is required");
        exit();
    } else if(empty($CPassword)) {
        header("location:register.php?error=Confirm password is required");
        exit();
    } 

    if($password != $CPassword){
        header("location:register.php?error=Confirm passowrd does not match");
        exit();

    }

    $stmt = $conn->prepare("insert into users(firstName,lastName, email,userName,ContactNum,password) values(?,?,?,?,?,?)");
    $stmt ->bind_param("ssssss",$firstName,$lastName,$email,$userName,$ContactNum, $password);
    $stmt -> execute();
    header("location: login.php?success=Registered Succesfully");
    $stmt->close();
    $conn->close();


}





?>

