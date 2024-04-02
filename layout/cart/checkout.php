<?php 
require('../template/header.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $city = $_POST['city'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $orderTotal = getTotal($db); // Assuming you have a function to calculate total

    // Insert data into the orders table
    $sql = "INSERT INTO orders (firstName, lastName, email, address, zip, city, cardNumber, expiryDate, cvv, orderTotal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email, $address, $zip, $city, $cardNumber, $expiryDate, $cvv, $orderTotal]);

    // Redirect or display a success message
     header("Location: oreder.php");
}
?>
<!--Billing Address && Your Order -->
<section>
  <div class="container">
    <h2 class="bg-primary  text-light rounded text-center mt-3">Checkout</h2>
    <div class="row">
      <div class="col-md-8">
        <div class="container">
          <h2>Billing Address</h2>
          <form class="row g-3">
            <div class="col-md-6">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" placeholder="John" required>
            </div>
            <div class="col-md-6">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" placeholder="Doe" required>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Email (Optional)</label>
              <input type="email" class="form-control" id="email" placeholder="youremail@example.com">
            </div>
            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="123 Main St" required>
            </div>
            <div class="col-md-6">
              <label for="zip" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zip" placeholder="12345" required>
            </div>
            <div class="col-md-6">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment, studio, or floor">
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-4">
        <div class="container border">
          <h2> Your Order</h2>
          <div class="row">
            <div class="col-md-6 text-start">
              <h6>Product</h6>
            </div>
            <div class="col-md-6 text-end">
              <h6>Subtotal</h6>
            </div>
          </div>
          <hr>
          <!--display the name x mount-->
          <?php 
            $sql ="SELECT cart.amount, products.name ,products.price
                    FROM cart 
                    INNER JOIN products ON cart.product_Id = products.id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $checkouts = $stmt->fetchAll();
            foreach ($checkouts as $checkout) {   
          ?>
          <div class="row">
            <div class="col-md-6 text-start">
                <?= $checkout['name']?> x <?= $checkout['amount']?>
            </div>
            <div class="col-md-6 text-end">
              <?php echo $checkout['amount'] * $checkout['price'] ?> $
            </div>
          </div>
          <?php } ?>
          <hr>
          <div class="row">
            <div class="col-md-6 text-start">
              <p>Total</p>
            </div>
            <div class="col-md-6 text-end">
            <?= getTotal($db) ?>$
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
                <form method="post" action="fakePayment.php"> <!-- This form will post to a PHP file where you'll implement fake payment logic -->
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
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require('../template/footer.php') ?>