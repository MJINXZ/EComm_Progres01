<?php
session_start();
include_once("../config/config.php");

// ======================
// CHECK ADMIN LOGIN
// ======================
if(!isset($_SESSION['authUser'])){

    header("Location: /E-commerce/public/login");
    exit();

}

if($_SESSION['userRole'] !== 'admin'){

    header("Location: /E-commerce/public/index");
    exit();

}

// ======================
// CHECK CUSTOMER ID
// ======================
if(!isset($_GET['id'])){

    die("Invalid user.");

}

$user_id = $_GET['id'];

// ======================
// GET CURRENT USER DATA
// ======================
$get = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");

if(mysqli_num_rows($get) == 0){

    die("User not found.");

}

$current = mysqli_fetch_assoc($get);

// ======================
// UPDATE PROFILE
// ======================
if($_SERVER['REQUEST_METHOD'] === 'POST'){

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

    // ======================
    // IMAGE UPLOAD
    // ======================
    if(isset($_FILES['profile']) && $_FILES['profile']['name'] != ""){

        $image_name = time() . "_" . $_FILES['profile']['name'];

        $temp_name = $_FILES['profile']['tmp_name'];

        $folder = "../../public/assets/profile_img/" . $image_name;

        move_uploaded_file($temp_name, $folder);

        mysqli_query(
            $conn,
            "UPDATE users 
             SET profile='$image_name' 
             WHERE id='$user_id'"
        );

    }

    // ======================
    // UPDATE USER INFO
    // ======================
    $update_query = "
        UPDATE users SET 

        firstName='$firstName',
        lastName='$lastName',
        contactNumber='$contactNumber',
        emailAddress='$email',
        street='$street',
        barangay='$barangay',
        city='$city'

        WHERE id='$user_id'
    ";

    mysqli_query($conn, $update_query);

    $_SESSION['message'] = "Customer profile updated";
    $_SESSION['code'] = "success";

    // ======================
    // REDIRECT BACK
    // ======================
    header("Location: /E-commerce/public/admin/userProfile.php?id=$user_id");
    exit();

}
?>