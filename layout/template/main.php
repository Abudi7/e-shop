<?php
session_start();
include "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('../../config/datasBase.php');
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

// if (isset($_POST['addToCart'])) {
  
//   if (isset($_SESSION['cart'])) {
//       $sessionArrayId = array_column($_SESSION['cart'], 'id');
//       if (!in_array($_GET['id'], $sessionArrayId)) {
//         $sessionArray = array(
//           'id' => $_GET['id'],
//           'name' => $_POST['name'],
//           'price' => $_POST['price'],
//           'quantity' => $_POST['quantity']
//         );
//         $_SESSION['cart'][] = $sessionArray;
//       }
//   } else {
//     $sessionArray = array(
//       'id' => $_GET['id'],
//       'name' => $_POST['name'],
//       'price' => $_POST['price'],
//       'quantity' => $_POST['quantity']
//     );
//     $_SESSION['cart'][] = $sessionArray;
//   }
// }
// ?>
<section>
  <div class="container">
    <div class="row mt-4">
   
      <?php foreach ($products as $product) { ?>
        <div class="col-md-3 mt-2">
        <form method="post" action="main.php?id=<?php //$product['id']?>">
          <div class="card" style="width: 18rem;">
            <div class="card-header" name="name">
            <?= $product['name']; ?>
            </div>
            <img src="../products/products-Image/<?= $product['img'] ?>" class="card-img-top img-fluid" alt="<?= $product['name'] ?>">
            <div class="card-body">
              <p class="card-text">
                <?= $product['content']; ?>
              </p>
              <input type="hidden" name="name" value="">
              <input type="hidden" name="price" value="<?= $product['price']; ?>">
              <input type="number" name="quantity" value="1" class="form-control">
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
