<?php

session_start();
include_once("../config/config.php");


if(isset($_POST['login'])){
$username = $_POST['username'];
$password = $_POST['password'];

$loginQuery = "SELECT UID, firstName, lastName, username, role 
               FROM users
               WHERE username = ? AND password = ? LIMIT 1";

        $stmt = $conn->prepare($loginQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $user_id = $data['UID'];
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
            header("Location: /E-commerce/public/admin/index.php");
            exit();
        } else {
          header("Location: /E-commerce/public/users/index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid username or password";
        $_SESSION['code'] = "error";
        header("Location: /E-commerce/public/users/login.php");
exit();
    }
 }else {
        $_SESSION['message'] = "something went wrong";
        $_SESSION['code'] = "error";
       header("Location: /E-commerce/public/users/login.php");
exit();
    }
}