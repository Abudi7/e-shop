<?php include "../template/header.php"; ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h2 class="bg-primary  text-light rounded text-center mt-3">User Registration</h2>
    </div>
  </div>
</div>
<?php
$message = ""; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roleUser = "Role['user']";

    // Check if any field is empty
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email is in the correct format
        $message = 'Invalid email format.';
    } else {
        // Check if email already exists in the database
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
        $stmt->execute(array($email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['count'] > 0) {
            $message = 'Email already exists. Please choose a different email.';
        } elseif (strlen($password) < 8) {
            // Validate password length
            $message = 'Password should be at least 8 characters long.';
        } else {
            // Validate password using regex
            $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9$"\!\#]+)/';
            if (!preg_match($regex, $password)) {
                // Display error message if password does not meet criteria
                $message = 'Password should contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
            } else {
                // Hash the password
                $password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user data into the database
                $sql = "INSERT INTO users (firstname, lastname, email, password,role) VALUES (?, ?, ?, ?,?)";
                $stmt = $db->prepare($sql);
                $stmt->execute(array($firstName, $lastName, $email, $password, $roleUser));

                // Display success message
                $message = 'New register created successfully';
                // Redirect to login page 
                header('Location: login.php');
                exit();
            }
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php if (!empty($message)) : ?>
                <div class="alert alert-danger" role="alert"><?= $message ?></div>
            <?php endif; ?>
        </div>
    </div>
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
                    <small id="passwordHelp" class="form-text text-muted">Password should contain at least one uppercase letter, one lowercase letter, one number, and one special character.</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php include "../template/footer.php"; ?>