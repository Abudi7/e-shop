<?php
 ob_start();// Start output buffering
include "../template/header.php";
?>


<div class="container">
    <h2 class="bg-primary text-light rounded text-center mt-3">E-Shop Login Page</h2>

    <?php
    // Check if the user is already logged in, if yes, redirect to main.php
    if (isset($_SESSION['id'])) {
        header("Location: ../template/main.php");
        exit();
    }

    if (isset($_POST['submit'])) {
        
        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userExists = $stmt->fetch();
        if ($userExists) {
            // Verify password
            $passwordHash = $userExists['password'];
            if (password_verify($password, $passwordHash)) {
                // Password is correct, set session variables
                $_SESSION['firstname'] = $userExists['firstname'];
                $_SESSION['id'] = $userExists['id'];
                $_SESSION['role'] = $userExists['role'];

                if ($userExists['role'] === "admin") {
                  header('Location: ../admin/products/product.php');
                  exit();
                }else{
                // Redirect to main.php
                header('Location: ../template/main.php');
                exit();
              }
            } else {
                echo '<div class="alert alert-danger" role="alert">Incorrect password.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">User does not exist.</div>';
        }
    }
    ?>
    <form  action="" name="submit" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
        </div>
        <div class="form-group form-text">
            <p><a href="register.php" class="link-offset-2 link-underline link-underline-opacity-0">create an account</a></p>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php include "../template/footer.php"; ?>
