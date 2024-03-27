<?php 
require("../template/header.php"); 
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


    // Prepare the SQL statement
    $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password WHERE id = :id";
    $stmt = $db->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':id', $id);

    // Execute the statement
    if ($stmt->execute()) {
      echo "Record updated successfully.";
      header("Location: ../template/main.php");
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
  <button type="submit" class="btn btn-primary">Update User</button>
</form>

</div>
<?php include "../../layout/template/footer.php"; ?>
