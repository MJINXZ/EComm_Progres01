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
$username = $_POST['username'];
$password = $_POST['password'];

$loginQuery = "SELECT id, firstName, lastName, username, role 
               FROM users
               WHERE username = ? AND password = ? LIMIT 1";

        $stmt = $conn->prepare($loginQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $user_id = $data['id'];
        $fullName = $data['firstName'] . " " . $data['lastName'];
        $username = $data['username'];
        $userRole = $data['role'];

        $_SESSION['user_id'] = $user_id;
        $_SESSION['userRole'] = $userRole;
        $_SESSION['authUser'] = [
            'user_id' => $user_id,
            'fullName' => $fullName,
            'username' => $username,
        ];

        $_SESSION['message'] = "Welcome $fullName";
        $_SESSION['code'] = "success";

        if ($userRole === 'admin') {
            header("Location: /E-commerce/public/admin/index");
            exit();
        }
         if ($userRole === 'user') {
            header("Location: /E-commerce/public/users/index");
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
    $_SESSION['message'] = "Invalid email format";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

// email dup checker //
$checkEmail = mysqli_query($conn, "SELECT id FROM users WHERE emailAddress 
                            = '$emailAddress' LIMIT 1");

if($checkEmail && mysqli_num_rows($checkEmail) > 0 ) {
    $_SESSION['message'] ="Email address already exist";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

// username validator //
$checkUsername = mysqli_query($conn, "SELECT id FROM users WHERE username
                            = '$username' LIMIT 1");
if($checkUsername && mysqli_num_rows($checkUsername) > 0 ) {
    $_SESSION['message'] ="username already exist";
    $_SESSION['code'] = "error";
    header("Location: /E-commerce/public/register");
    exit();

}

// password checker
if($password !== $confirmPassword) {
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