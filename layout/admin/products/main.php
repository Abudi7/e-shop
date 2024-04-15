<?php
session_start();
  if ((isset($_SESSION['role']) && $_SESSION['role'] !== "admin")) {
    // Redirect securely using header()
    header("Location: ../../template/main.php");
  } else {

require('../../template/headerAdmin.php');
require('../../../config/datasBase.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
?>
<section>
  <div class="container">
    <div class="row mt-4">
      <?php foreach ($products as $product) { ?>
        <div class="col-md-3 m-3">
        <form method="post" action="../cart/cart.php?id=<?= $product['id']?>">
          <div class="card" style="width: 18rem;">
            <div class="card-header" name="name">
            <?= $product['name']; ?>
            </div>
            <img src="../products/products-Image/<?= $product['img'] ?>" class="card-img-top img-fluid" alt="<?= $product['name'] ?>">
            <div class="card-body">
              <p class="card-text d-inline-block text-truncate" style="max-width: 150px;">
                <?= $product['content']; ?>
              </p>
              <p>
              <span class="text-primary" name="price"> <?= $product['price']; ?>$ </span><span class=""><?= $product['created']; ?></span>
              </p>
              <input type="submit" class="btn btn-outline-primary btn-sm" value="Add to Cart" name="addToCart">
            </div>
          </div>
        </div>
        </form>
      <?php } ?>
    </div>
  </div>
</section>
<?php 
?>
<?php } require('../../template/footer.php'); ?>
