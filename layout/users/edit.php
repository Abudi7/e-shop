<?php 
require("../template/header.php"); 
require('../../config/datasBase.php');
$id = $_REQUEST['id'];
$sql = "SELECT * FROM users WHERE id='".$id."'";
$stmt = $db->prepare($sql);
$stmt->execute();
$user = $stmt->fetch();
?>
<div class="container">
    <h2 class="bg-primary text-light rounded text-center mt-3">Edit <?php echo $_SESSION["firstname"]; ?> Page</h2>
  
  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password,PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    
    // Check if a new image is uploaded
    if ($_FILES['image']['name']) {
      $profileImg = $_FILES['image']['name'];

      // Upload the image to the folder
      $targetDir = '../../image/';
      $targetFile = $targetDir . basename($_FILES["image"]["name"]);
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo "Image uploaded successfully";
      } else {
        echo "Error uploading image.";
        exit();
      }
    } else {
      // If no new image is uploaded, keep the existing image
      $profileImg = $user['img'];
    }

    // Prepare the SQL statement
    $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, address = :address, phone = :phone, img = :profileImg WHERE id = :id";
    $stmt = $db->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':profileImg', $profileImg);
    $stmt->bindParam(':id', $id);

    // Execute the statement
    if ($stmt->execute()) {
      echo "Record updated successfully.";
    } else {
      echo "Error updating record: " . $stmt->errorCode();
    }
  }
  ?>

<form  method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="firstname" name="firstname" required value="<?= $user['firstname'] ?>">
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lastname" name="lastname" required value="<?= $user['lastname'] ?>">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required value="<?= $user['email'] ?>">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required value="<?= $user['password'] ?>">
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" required value="<?= $user['address'] ?>">
  </div>
  <div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" required value="<?= $user['phone'] ?>">
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">Profile Image</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Update User</button>
</form>

</div>
<?php include "../../layout/template/footer.php"; ?>
