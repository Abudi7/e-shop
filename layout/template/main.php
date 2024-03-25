<?php
include "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../../config/datasBase.php');
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
?>
<section>
  <div class="container">
    <div class="row mt-4">
      <?php foreach ($products as $product) { ?>
        <div class="col-md-3">
          <div class="card" style="width: 18rem;">
            <div class="card-header">
              <?= $product['name']; ?>
            </div>
            <img src="../products/products-Image/<?= $product['img'] ?>" class="card-img-top img-fluid" alt="<?= $product['name'] ?>">
            <div class="card-body">
              <p class="card-text">
                <?= $product['content']; ?>
              </p>
              <p>
              <span class="text-primary"> <?= $product['price']; ?>$ </span><span class=""><?= $product['created']; ?></span>
              </p>
              <a href="#" class="btn btn-primary"></a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php include "footer.php"; ?>
