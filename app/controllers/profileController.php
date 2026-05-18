<?php

session_start();

include_once("../config/config.php");

if (!isset($_SESSION['user_id'])) {

    header("Location: /login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

// GET CURRENT USER DATA
$get = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$current = mysqli_fetch_assoc($get);

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // USER INFO
    $firstName = !empty($_POST['firstName'])
        ? $_POST['firstName']
        : $current['firstName'];

    $lastName = !empty($_POST['lastName'])
        ? $_POST['lastName']
        : $current['lastName'];

    $contactNumber = !empty($_POST['contactNumber'])
        ? $_POST['contactNumber']
        : $current['contactNumber'];

    $email = !empty($_POST['emailAddress'])
        ? $_POST['emailAddress']
        : $current['emailAddress'];

    $street = !empty($_POST['street'])
        ? $_POST['street']
        : $current['street'];

    $barangay = !empty($_POST['barangay'])
        ? $_POST['barangay']
        : $current['barangay'];

    $city = !empty($_POST['city'])
        ? $_POST['city']
        : $current['city'];

    // PROFILE IMAGE
    $profile_sql = "";

    if(isset($_FILES['profile']) && $_FILES['profile']['name'] != ""){

        $image_name = time() . "_" . $_FILES['profile']['name'];

        $temp_name = $_FILES['profile']['tmp_name'];

        $folder = "../../public/assets/profile_img/" . $image_name;

        if(move_uploaded_file($temp_name, $folder)){

            $profile_sql = ", profile='$image_name'";

        }

    }

    // UPDATE QUERY
    $update_query = "UPDATE users SET

        firstName='$firstName',
        lastName='$lastName',
        contactNumber='$contactNumber',
        emailAddress='$email',
        street='$street',
        barangay='$barangay',
        city='$city'
        $profile_sql

        WHERE id='$user_id'
    ";

    // EXECUTE
    if(mysqli_query($conn, $update_query)){

        header("Location: ../../public/users/profilePage.php");
        exit();

    }else{

        die("Update Failed: " . mysqli_error($conn));

    }

}
?>