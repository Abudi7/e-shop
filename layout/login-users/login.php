<?php include "../template/header.php"; ?>
<div class="container">
  <h2 class="bg-primary  text-light rounded text-center mt-3">E-Shop Login Page</h2>
 
  <?php
  //check if the user logged in 
  // if (isset($_SESSION['id'])) {
  //   //redirect to login page
  //   header("Location: http://localhost/e-shop/layout/login/login.php");
  //   exit();
  // }

  require("../../config/datasBase.php");

  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT id,firstname,lastname,email,password,phone,address,img,role FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $userExists = $stmt->fetch();
    
    $paswordHash = $userExists['password'];
    $checkPassword = password_verify($password, $paswordHash);

    if ($checkPassword === true) {

      $_SESSION['firstname'] = $userExists['firstname'];
      $_SESSION['id'] = $userExists['id'];
      $_SESSION['img'] = $userExists['img'];
      $_SESSION['role'] = $userExists['role'];
      
      // Redirect securely using header()
      header("Location: http://localhost/e-shop/e-shop/layout/template/main.php");
      exit(); // Halt execution
    } else {
      echo "Login is not success";
    }
  }
  ?>
  <form action="login.php" method="POST">
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"
        placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Remember me</label>
    </div>
    <div class="form-group form-text">
      <p><a href="register.php" class="link-offset-2 link-underline link-underline-opacity-0">create an acount</a> </p>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php include "../template/footer.php"; ?>