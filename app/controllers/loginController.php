<?php

session_start();
include_once("../config/config.php");

function generate_uuid() {
    return sprintf("%04x%04x-%04x-%04x-%04x-%04x%04x%04x",
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x4000) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}





if(isset($_POST['login'])){
$email = $_POST['email'];
$password = $_POST['password'];

$loginQuery = "SELECT id, firstName, lastName, username, emailAddress, role 
               FROM users
               WHERE emailAddress = ? AND password = ? LIMIT 1";

        $stmt = $conn->prepare($loginQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $user_id = $data['id'];
        $fullName = $data['firstName'] . " " . $data['lastName'];
        $username = $data['username'];
        $email = $data['email'];
        $userRole = $data['role'];

        $_SESSION['user_id'] = $user_id;
        $_SESSION['userRole'] = $userRole;
        $_SESSION['authUser'] = [
            'user_id' => $user_id,
            'fullName' => $fullName,
            'username' => $username,
            'email' => $email,
        ];

        $_SESSION['message'] = "Welcome $fullName";
        $_SESSION['code'] = "success";

        if ($userRole === 'admin') {
            header("Location: /E-commerce/public/admin/index.php");
            exit();
        }
         if ($userRole === 'user') {
            header("Location: /E-commerce/public/index");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid username or password";
        $_SESSION['code'] = "error";
        header("Location: /E-commerce/public/login");
exit();
    }
 }else {
        $_SESSION['message'] = "something went wrong";
        $_SESSION['code'] = "error";
       header("Location: /E-commerce/public/login");
exit();
    }
}


if(isset($_POST['register'])){
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$middleName = $_POST['middleName'];
$emailAddress = $_POST['email'];
$contactNumber = $_POST['contact'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$street = $_POST['street'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$role = "user";
$uuid = generate_uuid();


// email validator //
if(!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)){
    $_SESSION['old_firstName'] = $_POST['firstName'];
    $_SESSION['old_lastName'] = $_POST['lastName'];
    $_SESSION['old_middleName'] = $_POST['middleName'];
    $_SESSION['old_email'] = $_POST['email'];
    $_SESSION['old_contact'] = $_POST['contact'];
    $_SESSION['old_username'] = $_POST['username'];
    $_SESSION['old_street'] = $_POST['street'];
    $_SESSION['old_barangay'] = $_POST['barangay'];
    $_SESSION['old_city'] = $_POST['city'];



    $_SESSION['message'] = "Invalid email format";
    $_SESSION['code'] = "error";




    header("Location: /E-commerce/public/register");
    exit();

}

// email dup checker //
$checkEmail = mysqli_query($conn, "SELECT id FROM users WHERE emailAddress 
                            = '$emailAddress' LIMIT 1");

if($checkEmail && mysqli_num_rows($checkEmail) > 0 ) {
    

    $_SESSION['old_firstName'] = $_POST['firstName'];
    $_SESSION['old_lastName'] = $_POST['lastName'];
    $_SESSION['old_middleName'] = $_POST['middleName'];
    $_SESSION['old_email'] = $_POST['email'];
    $_SESSION['old_contact'] = $_POST['contact'];
    $_SESSION['old_username'] = $_POST['username'];
    $_SESSION['old_street'] = $_POST['street'];
    $_SESSION['old_barangay'] = $_POST['barangay'];
    $_SESSION['old_city'] = $_POST['city'];



    $_SESSION['message'] ="Email address already exist";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

// username validator //
$checkUsername = mysqli_query($conn, "SELECT id FROM users WHERE username
                            = '$username' LIMIT 1");
if($checkUsername && mysqli_num_rows($checkUsername) > 0 ) {
     $_SESSION['old_firstName'] = $_POST['firstName'];
    $_SESSION['old_lastName'] = $_POST['lastName'];
    $_SESSION['old_middleName'] = $_POST['middleName'];
    $_SESSION['old_email'] = $_POST['email'];
    $_SESSION['old_contact'] = $_POST['contact'];
    $_SESSION['old_username'] = $_POST['username'];
    $_SESSION['old_street'] = $_POST['street'];
    $_SESSION['old_barangay'] = $_POST['barangay'];
    $_SESSION['old_city'] = $_POST['city'];


    $_SESSION['message'] ="username already exist";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

// password checker
if($password !== $confirmPassword) {

    $_SESSION['old_firstName'] = $_POST['firstName'];
    $_SESSION['old_lastName'] = $_POST['lastName'];
    $_SESSION['old_middleName'] = $_POST['middleName'];
    $_SESSION['old_email'] = $_POST['email'];
    $_SESSION['old_contact'] = $_POST['contact'];
    $_SESSION['old_username'] = $_POST['username'];
    $_SESSION['old_street'] = $_POST['street'];
    $_SESSION['old_barangay'] = $_POST['barangay'];
    $_SESSION['old_city'] = $_POST['city'];

    $_SESSION['message'] ="password does not match";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

//add user or insert user
$query = "INSERT INTO `users`( `uuid`, `firstName`, `lastName`, `middleName`, `emailAddress`, `contactNumber`, `username`
, `password`, `street`, `barangay`, `city`, `role`) 

VALUES ('$uuid', '$firstName', '$lastName', '$middleName', '$emailAddress', '$contactNumber', '$username', '$password',
 '$street', '$barangay', '$city', '$role')";

 if(mysqli_query($conn, $query)){

    unset($_SESSION['old_firstName']);
    unset($_SESSION['old_lastName']);
    unset($_SESSION['old_middleName']);
    unset($_SESSION['old_email']);
    unset($_SESSION['old_contact']);
    unset($_SESSION['old_username']);
    unset($_SESSION['old_street']);
    unset($_SESSION['old_barangay']);
    unset($_SESSION['old_city']);

    $_SESSION['message'] = "Registration Successful. Login now g";
    $_SESSION['code']= "success";
    header("Location: /E-commerce/public/login");
exit();
 }else {
    $_SESSION['message'] ="something went wrong";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

}

?>