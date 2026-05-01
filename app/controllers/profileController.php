<?php
session_start();
include_once("../config/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: E-commerce/public/login");
    exit();
}

$user_id = $_SESSION['user_id'];

// 🔹 GET CURRENT USER DATA FIRST
$get = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$current = mysqli_fetch_assoc($get);


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : $current['firstName'];
    $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : $current['lastName'];
    $contactNumber = !empty($_POST['contactNumber']) ? $_POST['contactNumber'] : $current['contactNumber'];
    $email = !empty($_POST['emailAddress']) ? $_POST['emailAddress'] : $current['emailAddress'];
    $street = !empty($_POST['street']) ? $_POST['street'] : $current['street'];
    $barangay = !empty($_POST['barangay']) ? $_POST['barangay'] : $current['barangay'];
    $city = !empty($_POST['city']) ? $_POST['city'] : $current['city'];

    // IMAGE UPLOAD
    if(isset($_FILES['profile']) && $_FILES['profile']['name'] != ""){

    $image_name = time() . "_" . $_FILES['profile']['name'];
    $temp_name = $_FILES['profile']['tmp_name'];
    $folder = "../../public/assets/profile_img/" . $image_name;

    move_uploaded_file($temp_name, $folder);

    mysqli_query($conn, "UPDATE users SET profile='$image_name' WHERE id='$user_id'");
}

    // UPDATE USER INFO
    $update_query = "UPDATE users SET 
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

    // ⚠️ ALSO FIX THIS (match your actual file name)
    header("Location: ../../public/users/profile_page.php");
exit();
}