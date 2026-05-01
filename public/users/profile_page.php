<?php 
session_start();
$pageClass = "profile-page";

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: /login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// PROFILE IMAGE
$profile_img = "https://via.placeholder.com/120";
if(!empty($user['profile'])){
    $profile_img = "../assets/profile_img/" . $user['profile'];
}
?>

<div class="container">

  <!-- LEFT PROFILE CARD -->
  <div class="profile-card">

    <img id="previewImg" src="<?php echo $profile_img; ?>" style="width:120px; border-radius:50%;">

    <h3><?php echo $user['firstName'] . " " . $user['lastName']; ?></h3>
    <p><?php echo $user['emailAddress']; ?></p>

    <!-- UPLOAD BUTTON -->
    <button class ="btn" style="color: black;" type="button" onclick="document.getElementById('fileInput').click()">
        Upload Photo
    </button>

  </div>

  <!-- RIGHT FORM -->
  <div class="profile-form">

    <h2>Profile Settings</h2>

    <form method="POST" action="/E-commerce/app/controllers/profileController.php" enctype="multipart/form-data">

      <!-- hidden file input -->
      <input type="file" id="fileInput" name="profile"
        style="display:none;"
        disabled
        onchange="previewImage(event)">

      <div class="form-grid">

        <div>
          <label>First Name</label>
          <input type="text" name="firstName" value="<?php echo $user['firstName']; ?>" disabled>
        </div>

        <div>
          <label>Last Name</label>
          <input type="text" name="lastName" value="<?php echo $user['lastName']; ?>" disabled>
        </div>

        <div>
          <label>Mobile</label>
          <input type="text" name="contactNumber" value="<?php echo $user['contactNumber']; ?>" disabled>
        </div>

        <div>
          <label>Email</label>
          <input type="email" name="emailAddress" value="<?php echo $user['emailAddress']; ?>" disabled>
        </div>

        <div>
          <label>Street</label>
          <input type="text" name="street" value="<?php echo $user['street']; ?>" disabled>
        </div>

        <div>
          <label>Barangay</label>
          <input type="text" name="barangay" value="<?php echo $user['barangay']; ?>" disabled>
        </div>

        <div>
          <label>City</label>
          <input type="text" name="city" value="<?php echo $user['city']; ?>" disabled>
        </div>

      </div>

      <!-- SINGLE TOGGLE BUTTON (YOUR SAVE BUTTON STYLE) -->
      <div style="margin-top:15px;">

        <button type="button"
                id="toggleBtn"
                class="save-btn"
                onclick="toggleEdit()"
                style="color:black;">
            Edit Profile
        </button>

      </div>

    </form>

  </div>

</div>

<?php include('../admin/includes/footer.php'); ?>

<!-- SCRIPT -->
<script>

let isEditing = false;

function toggleEdit(){

    const inputs = document.querySelectorAll('.profile-form input');
    const fileInput = document.getElementById('fileInput');
    const btn = document.getElementById('toggleBtn');

    if(!isEditing){

        // ENABLE EDIT MODE
        inputs.forEach(input => input.removeAttribute('disabled'));
        fileInput.removeAttribute('disabled');

        btn.innerText = "Save Profile";
        isEditing = true;

    } else {

        // SUBMIT FORM
        document.querySelector('.profile-form form').submit();
    }
}

// IMAGE PREVIEW
function previewImage(event){
    const reader = new FileReader();

    reader.onload = function(){
        document.getElementById("previewImg").src = reader.result;
    }

    reader.readAsDataURL(event.target.files[0]);
}

</script>