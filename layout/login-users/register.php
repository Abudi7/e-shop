<?php include "../template/header.php"; ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h2 class="bg-primary  text-light rounded text-center mt-3">User Registration</h2>
    </div>
  </div>
</div>
<?php
include "../../config/datasBase.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $roleUser = "Role['user']";

    // Check if email already exists in the database
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
    $stmt->execute(array($email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        // Display error message if email already exists
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                  <div class="alert alert-danger" role="alert">Email already exists. Please choose a different email.</div>
                  <a class="btn btn-danger" href="http://localhost/e-shop/layout/login/register.php">back to register </a>
                </div>
              </div>';
        exit();  
    }

    // Check if image file already exists in the database
    $fileName = $_FILES['img']['name'];
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM users WHERE img = ?");
    $stmt->execute(array($fileName));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['count'] > 0) {
        // Display error message if image already exists
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="alert alert-danger" role="alert">Image already exists. Please choose a different image.</div>
                    <a class="btn btn-danger" href="http://localhost/e-shop/layout/login/register.php">back to register </a>
                  </div>
              </div>';
        exit();  
    }

    // Validate password length
    if (strlen($password) < 8) {
        // Display error message if password is less than 8 characters
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="alert alert-danger" role="alert">Password should be at least 8 characters long.</div>
                    <a class="btn btn-danger" href="http://localhost/e-shop/layout/login/register.php">back to register </a>
                </div>
              </div>';
        exit();  
    }

    //hashing password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Upload image
    $tmpFileName = $_FILES['img']['tmp_name'];
    $targetFile = '../../image/'. $fileName;
    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); 
    $vaildExension = array('png','jpg','jpeg');
    if (!in_array($fileExtension, $vaildExension)) {
        // Display error message if file extension is not valid
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                  <div class="alert alert-danger" role="alert">Invalid image format. Please upload a PNG, JPG, or JPEG file.</div>
                </div>
              </div>';
        exit();  
    }
      
    if (move_uploaded_file($tmpFileName, $targetFile)) {
        // Store the user in the database
        $sql = "INSERT INTO users (firstname, lastname, email, password, phone, address, img,role) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($firstName, $lastName, $email, $password, $phone, $address, $fileName, $roleUser));
        // Display success message in a Bootstrap alert
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                  <div class="alert alert-success" role="alert">New register created successfully</div>
                </div>
              </div>';
        // Redirect to login page 
        header('Location: login.php');
        exit();  
    } else {
        // Display error message if file upload failed
        echo '<div class="row">
                <div class="col-md-8 offset-md-2">
                  <div class="alert alert-danger" role="alert">Failed to upload image. Please try again later.</div>
                </div>
              </div>';
    }
}
?>
 <div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="firstname">First Name</label>
          <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="lastname">Last Name</label>
          <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" class="form-control" id="address" name="address">
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" class="form-control" id="phone" name="phone">
    </div>
    <div class="form-group">
      <label for="image" class="form-label">Profile Image</label>
      <input type="file" class="form-control" id="img" name="img" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
  </form>
</div>
</div>
<?php include "../template/footer.php"; ?>