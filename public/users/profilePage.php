<?php 
session_start();
$pageClass = "profile-page";

include('../admin/includes/header.php');
include('../admin/includes/topbar.php');
include_once("../../app/config/config.php");

// ======================
// LOGIN CHECK
// ======================
if(!isset($_SESSION['uuid'])){
    header("Location: /E-commerce/public/login");
    exit();
}

// use UUID instead of user_id
$user_uuid = $_SESSION['uuid'];

// ======================
// GET USER BY UUID
// ======================
$query = "SELECT * FROM users WHERE uuid='$user_uuid' LIMIT 1";
$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) == 0){
    echo "User not found.";
    exit();
}

$user = mysqli_fetch_assoc($result);

// ======================
// PROFILE IMAGE
// ======================
$profile_img = "https://via.placeholder.com/120";

if(!empty($user['profile'])){
    $profile_img = "../assets/profile_img/" . $user['profile'];
}
?>

<div class="container">

  <!-- LEFT PROFILE CARD -->
  <div class="profile-card">

    <img id="previewImg"
         src="<?php echo $profile_img; ?>"
         style="width:120px;
                height:120px;
                object-fit:cover;
                border-radius:50%;">

    <h3>
      <?php echo $user['firstName'] . " " . $user['lastName']; ?>
    </h3>

    <p>
      <?php echo $user['emailAddress']; ?>
    </p>

    <!-- UPLOAD BUTTON -->
    <button class="btn"
            id="uploadBtn"
            type="button"
            disabled
            style="color:black;"
            onclick="document.getElementById('fileInput').click()">

        Upload Photo

    </button>

  </div>

  <!-- RIGHT FORM -->
  <div class="profile-form">

    <h2>Profile Settings</h2>

    <form method="POST"
          action="/E-commerce/app/controllers/profileController.php"
          enctype="multipart/form-data">

      <!-- HIDDEN FLAG -->
      <input type="hidden"
             name="saveProfile"
             value="1">

      <!-- FILE INPUT -->
      <input type="file"
             id="fileInput"
             name="profile"
             style="display:none;"
             disabled
             onchange="previewImage(event)">

      <div class="form-grid">

        <div>
          <label>First Name</label>
          <input type="text"
                 name="firstName"
                 value="<?php echo $user['firstName']; ?>"
                 disabled>
        </div>

        <div>
          <label>Last Name</label>
          <input type="text"
                 name="lastName"
                 value="<?php echo $user['lastName']; ?>"
                 disabled>
        </div>

        <div>
          <label>Mobile</label>
          <input type="text"
                 name="contactNumber"
                 value="<?php echo $user['contactNumber']; ?>"
                 disabled>
        </div>

        <div>
          <label>Email</label>
          <input type="email"
                 name="emailAddress"
                 value="<?php echo $user['emailAddress']; ?>"
                 disabled>
        </div>

        <div>
          <label>Street</label>
          <input type="text"
                 name="street"
                 value="<?php echo $user['street']; ?>"
                 disabled>
        </div>

        <div>
          <label>Barangay</label>
          <input type="text"
                 name="barangay"
                 value="<?php echo $user['barangay']; ?>"
                 disabled>
        </div>

        <div>
          <label>City</label>
          <input type="text"
                 name="city"
                 value="<?php echo $user['city']; ?>"
                 disabled>
        </div>

      </div>

      <!-- BUTTON -->
      <div style="margin-top:15px;">

        <button type="button"
                id="toggleBtn"
                class="save-btn"
                style="color:black;"
                onclick="toggleEdit()">

            Edit Profile

        </button>

      </div>

    </form>

  </div>

</div>

<!-- SAVE MODAL -->
<div class="modal fade"
     id="saveModal"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title">
          Confirm Changes
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal">
        </button>

      </div>

      <div class="modal-body">
        Do you want to save the changes to your profile?
      </div>

      <div class="modal-footer">

        <button type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal">
            Cancel
        </button>

        <button type="button"
                class="btn btn-primary"
                onclick="submitProfile()">
            Yes, Save
        </button>

      </div>

    </div>

  </div>

</div>

<?php include('../admin/includes/footer.php'); ?>

<script>

let isEditing = false;
let saveModal;

// PAGE LOAD
document.addEventListener("DOMContentLoaded", function(){

    saveModal = new bootstrap.Modal(
        document.getElementById('saveModal')
    );

});

function toggleEdit(){

    const inputs = document.querySelectorAll('.profile-form input');
    const fileInput = document.getElementById('fileInput');
    const uploadBtn = document.getElementById('uploadBtn');
    const btn = document.getElementById('toggleBtn');

    if(!isEditing){

        // ENABLE INPUTS
        inputs.forEach(input => {

            if(input.type !== "hidden"){
                input.removeAttribute('disabled');
            }

        });

        fileInput.removeAttribute('disabled');
        uploadBtn.removeAttribute('disabled');

        btn.innerText = "Save Profile";

        isEditing = true;

    }else{

        // SHOW SAVE MODAL
        saveModal.show();

    }
}

function submitProfile(){
    document.querySelector('.profile-form form').submit();
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