<?php 
session_start();

$pageClass = "profile-page";

include('../admin/includes/header.php');
include_once("../../app/config/config.php");

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

    echo "User not found.";
    exit();

}

$user_id = $_GET['id'];

// ======================
// GET USER DATA
// ======================
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){

    echo "User not found.";
    exit();

}

$user = mysqli_fetch_assoc($result);


// PROFILE IMAGE
$profile_img = "https://via.placeholder.com/120";
if(!empty($user['profile'])){
    $profile_img = "../assets/profile_img/" . $user['profile'];
}

?>
<body class="profile-page">

<div class="dashboard-layout">

    <!-- SIDEBAR -->
    <?php include('../admin/includes/sidebar.php'); ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="profile-container">

            <!-- LEFT PROFILE CARD -->
            <div class="profile-card">

                <img 
                    id="previewImg"
                    src="<?php echo $profile_img; ?>"
                    class="profile-image"
                >

                <h3>
                    <?php echo $user['firstName'] . " " . $user['lastName']; ?>
                </h3>

                <p>
                    <?php echo $user['emailAddress']; ?>
                </p>

                <!-- UPLOAD BUTTON -->
                <button 
                    class="upload-btn"
                    type="button"
                    onclick="document.getElementById('fileInput').click()"
                >
                    Upload Photo
                </button>

            </div>

            <!-- RIGHT FORM -->
            <div class="profile-form">

                <h2>Customer Profile</h2>

                            <form 
                    method="POST"
                    action="/E-commerce/app/controllers/adminProfileController.php?id=<?php echo $user_id; ?>"
                    enctype="multipart/form-data"
                >

                    <!-- FILE INPUT -->
                    <input 
                        type="file"
                        id="fileInput"
                        name="profile"
                        style="display:none;"
                        disabled
                        onchange="previewImage(event)"
                    >

                    <div class="form-grid">

                        <!-- FIRST NAME -->
                        <div>
                            <label>First Name</label>
                            <input 
                                type="text"
                                name="firstName"
                                value="<?php echo $user['firstName']; ?>"
                                disabled
                            >
                        </div>

                        <!-- LAST NAME -->
                        <div>
                            <label>Last Name</label>
                            <input 
                                type="text"
                                name="lastName"
                                value="<?php echo $user['lastName']; ?>"
                                disabled
                            >
                        </div>

                        <!-- CONTACT -->
                        <div>
                            <label>Mobile</label>
                            <input 
                                type="text"
                                name="contactNumber"
                                value="<?php echo $user['contactNumber']; ?>"
                                disabled
                            >
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label>Email</label>
                            <input 
                                type="email"
                                name="emailAddress"
                                value="<?php echo $user['emailAddress']; ?>"
                                disabled
                            >
                        </div>

                        <!-- STREET -->
                        <div>
                            <label>Street</label>
                            <input 
                                type="text"
                                name="street"
                                value="<?php echo $user['street']; ?>"
                                disabled
                            >
                        </div>

                        <!-- BARANGAY -->
                        <div>
                            <label>Barangay</label>
                            <input 
                                type="text"
                                name="barangay"
                                value="<?php echo $user['barangay']; ?>"
                                disabled
                            >
                        </div>

                        <!-- CITY -->
                        <div>
                            <label>City</label>
                            <input 
                                type="text"
                                name="city"
                                value="<?php echo $user['city']; ?>"
                                disabled
                            >
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="profile-actions">

                        <button
                            type="button"
                            id="toggleBtn"
                            class="save-btn"
                            onclick="toggleEdit()"
                        >
                            Edit Profile
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- SCRIPT -->
<script>

let isEditing = false;

function toggleEdit(){

    const inputs = document.querySelectorAll('.profile-form input');
    const fileInput = document.getElementById('fileInput');
    const btn = document.getElementById('toggleBtn');

    if(!isEditing){

        // ENABLE INPUTS
        inputs.forEach(input => {

            input.removeAttribute('disabled');

        });

        fileInput.removeAttribute('disabled');

        btn.innerText = "Save Profile";

        isEditing = true;

    } 
    else {

        // SUBMIT FORM
        document.querySelector('.profile-form form').submit();

    }

}

// ======================
// IMAGE PREVIEW
// ======================
function previewImage(event){

    const reader = new FileReader();

    reader.onload = function(){

        document.getElementById("previewImg").src = reader.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

</script>

</body>
</html>