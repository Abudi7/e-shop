<?php
  if ((isset($_SESSION['role']) && $_SESSION['role'] !== "Role['admin']")) {
    // Redirect securely using header()
    header("Location: ../../template/main.php");
  } else {
?>
<?php
  require('../../template/headerAdmin.php');
  require('../../../config/datasBase.php');
  $sql = "SELECT * FROM products";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $products = $stmt->fetchAll();
?>
<div class="container">
  <div class="row mt-2">
    <div class="col-md-12">
      <h2 class="bg-primary text-light rounded text-center"> Product Dashboard </h2>
    </div>
  </div>
  <div class="row mb-2 text-end">
    <div class="col-md-12">
      <a class="btn btn-primary" href="addProduct.php" role="button">Add Product</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr class="table-secondary">
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Content</th>
          <th scope="col">Price</th>
          <th scope="col">Created</th>
          <th scope="col">Image</th>
          <th scope="col">Admin</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) { ?>
          <tr>
            <td><?= $product['id']; ?></td>
            <td><?= $product['name']; ?></td>
            <td><span class="d-inline-block text-truncate" style="max-width: 150px;"><?= $product['content']; ?></span></td>
            <td><?= $product['price']; ?>$</td>
            <td><?= $product['created']; ?></td>
            <td><img src="../products/products-Image/<?= $product['img'] ?>" class="card-img-top img-thumbnail rounded" style="width:50px;" alt="<?= $product['name'] ?>"></td>
            <td>
              <span><a type="button" href="deleteProduct.php?id=<?= $product['id']; ?>" name="delete" class="btn btn-outline-secondary btn-sm">Delete</a></span>
              <span><a type="button" name="edit" href="editProduct.php?id=<?= $product['id']; ?>" class="btn btn-outline-secondary btn-sm">Edit</a></span>
            </td>
          </tr>
        <?php }} ?>
      </tbody>
    </table>
  </div>
</div>
<?php require('../../template/footer.php'); ?>



