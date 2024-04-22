<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if user is not logged in
if (isset($_SESSION['userId'])&& $_SESSION['userIsLoggedIn'] === false) {
  //set the session True
  $_SESSION['userIsLoggedIn'] = true;
  //Redirect to login page
  header("Location: ../login/login.php");
  exit("User is not logged in");
}
require('../../config/datasBase.php');


//$userId = $_SESSION['userId'];
$userTableId = $_SESSION['id'];
//var_dump($userId); exit();

// Fetch user data
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userTableId]);
$userData = $stmt->fetch();

// Check if the form is submitted
if (isset($_POST['checkout'])) {
  // Gather form data
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $zip = $_POST['zip'];
  $city = $_POST['city'];
  
  // Validate and sanitize form data
  // For simplicity, you can use htmlspecialchars for basic sanitization
  $firstName = htmlspecialchars($firstName);
  $lastName = htmlspecialchars($lastName);
  $email = htmlspecialchars($email);
  $address = htmlspecialchars($address);
  $zip = htmlspecialchars($zip);
  $city = htmlspecialchars($city);
 
  // Fetch user data
  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute([$userTableId]);
  $userData = $stmt->fetch();
  
  // Fetch total order amount
  require_once('cart.php'); // Assuming getTotal() function is in this file
  $orderTotal = getTotal($db);
   // Fetch the next available invoice number from the database
  $stmt = $db->query("SELECT MAX(invoice) AS maxInvoice FROM orders");
  $maxInvoice = $stmt->fetchColumn();

  // Check if this is the first order
  if ($maxInvoice === null) {
      // If it's the first order, start with 845101
      $invoice = "845101";
  } else {
      // Extract the numeric part of the max invoice number
      $numericPart = substr($maxInvoice, 4); // Extract the XX part
      $nextNumericPart = intval($numericPart) + 1; // Increment by 1

      // Combine the prefix '8451' with the next numeric part
      $invoice = "8451" . str_pad($nextNumericPart, 2, '0', STR_PAD_LEFT);
  }

  // Ensure the invoice number is 8 digits by padding with leading zeros if necessary
  $invoice = str_pad($invoice, 8, '0', STR_PAD_LEFT);


  $orderDate = new DateTime();
  
  // Insert data into the orders table
  $sql = "INSERT INTO orders (firstName, lastName, email, address, zip, city, orderDate, invoice ,orderTotal, user_id)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->execute([$firstName, $lastName, $email, $address, $zip, $city, $orderDate->format('Y-m-d H:i:s'),  $invoice,$orderTotal, $userTableId]);

  // Get the ID of the inserted order
  $orderId = $db->lastInsertId();

   // Fetch amount and product id from cart
   $sql = "SELECT cart.amount, products.id, products.name
            FROM cart
            INNER JOIN products ON cart.product_Id = products.id";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $checkouts = $stmt->fetchAll();
  // Insert data into the order_items table for each product in the cart
  foreach ($checkouts as $checkout) {
  $productId = $checkout['id'];
  $amount = $checkout['amount'];

  // Insert data into the order_items table
  $sql = "INSERT INTO order_items (order_id, product_id, amount)
      VALUES (?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->execute(array($orderId, $productId, $amount));
  }
    //delete cart courp
    $stmt = $db->prepare("DELETE FROM cart");
    $stmt->execute();

    // Send Email 
    $emailSubject = 'Order Confirmation';
    $emailBody = "Dear $firstName $lastName,\n\n";
    $emailBody .= "Thank you for your order!\n\nYour Order number is : $orderNumber \n \n";
    $emailBody .= "Your order details:\n";
    foreach ($checkouts as $checkout) {
        $productName = $checkout['name'];
        $amount = $checkout['amount'];
        $emailBody .= "- Product: $productName (ID: $productName), Quantity: $amount\n";
    }
    $emailBody .= "\nTotal Amount: $orderTotal $\n\n";
    $emailBody .= "Your order will be processed shortly.\n\n";
    $emailBody .= "Regards,\nYour Company";

    // Set additional headers
    $headers = "From: e-shop@abud-alshalal.com\r\n";
    $headers .= "Reply-To: yourcompany@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    $mailSent = mail($email, $emailSubject, $emailBody, $headers);

    // Redirect to order confirmation page
    header('Location: order.php');
    exit; 
    }

require('../template/header.php');
?>


<!-- Billing Address & Your Order -->
<section>
  <div class="container">
    <h2 class="bg-primary text-light rounded text-center mt-3">Checkout</h2>
    <div class="row">
      <div class="col-md-8">
        <div class="container">
          <h2>Billing Address</h2>
          <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="col-md-6">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $userData['firstname'] ?>" required>
            </div>
            <div class="col-md-6">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $userData['lastname'] ?>" required>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email (Optional)</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email'] ?>">
            </div>
            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="123 Main St" required>
            </div>
            <div class="col-md-6">
              <label for="zip" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zip" name="zip" placeholder="12345" required>
            </div>
            <div class="col-md-6">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
            </div>
          </div>
        </div>
        <!-- Your Order -->
        <div class="col-md-4">
          <div class="container border">
            <h2>Your Order</h2>
            <div class="row">
              <div class="col-md-6 text-start">
                <h6>Product</h6>
              </div>
              <div class="col-md-6 text-end">
                <h6>Subtotal</h6>
              </div>
            </div>
            <hr>
            <!-- Display the items in the cart -->
            <?php
            $sql = "SELECT cart.amount, products.name, products.price
                            FROM cart
                            INNER JOIN products ON cart.product_Id = products.id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $checkouts = $stmt->fetchAll();
            foreach ($checkouts as $checkout) {
              ?>
                <div class="row">
                  <div class="col-md-6 text-start">
                    <?= $checkout['name'] ?>
                    x
                    <?= $checkout['amount'] ?>
                  </div>
                  <div class="col-md-6 text-end">
                    <?php echo $checkout['amount'] * $checkout['price'] ?>
                    $
                  </div>
                </div>
            <?php } ?>
            <hr>
            <!-- Calculate and display the total -->
            <div class="row">
              <div class="col-md-6 text-start">
                <p>Total</p>
              </div>
              <div class="col-md-6 text-end">
                <?= getTotal($db) ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6 text-start">
                <p>Shipping</p>
              </div>
              <div class="col-md-6 text-end">
                <p>Free shipping</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6 text-start">
                <p>Total</p>
              </div>
              <div class="col-md-6 text-end">
                <?= getTotal($db) ?>$
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h2>Payment</h2>

                <div class="mb-3">
                  <label for="cardNumber" class="form-label">Card Number</label>
                  <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="mb-3">
                  <label for="expiryDate" class="form-label">Expiry Date</label>
                  <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                </div>
                <div class="mb-3">
                  <label for="cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" name="checkout" class="btn btn-primary">Place Order</button>
    </form>
  </div>
</section>


<?php require('../template/footer.php') ?>

