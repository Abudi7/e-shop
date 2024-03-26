<?php
session_start();
include "header.php";
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
        <div class="col-md-3 mt-2">
        <form method="post" action="../cart/cart.php?id=<?= $product['id']?>">
          <div class="card" style="width: 18rem;">
            <div class="card-header" name="name">
            <?= $product['name']; ?>
            </div>
            <img src="../products/products-Image/<?= $product['img'] ?>" class="card-img-top img-fluid" alt="<?= $product['name'] ?>">
            <div class="card-body">
              <p class="card-text">
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
//var_dump($_SESSION['cart']); 
?>
<?php include "footer.php"; ?>
