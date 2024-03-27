<?php 
require('../template/header.php');

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
              <label for="address2" class="form-label">Address 2 (Optional)</label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="col-md-6">
              <label for="zip" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zip" placeholder="12345" required>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require('../template/footer.php') ?>