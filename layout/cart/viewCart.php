<?php 
require('../template/header.php');

// Check if the form is submitted for updating amount
if(isset($_POST['updateAmount'])) {
    $productId = $_POST['productId'];
    $newAmount = $_POST['newAmount'];
    // Update the amount
    $sql = "UPDATE cart SET amount = ? WHERE product_Id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$newAmount, $productId]);
}

$sql = "SELECT cart.*, products.* FROM cart INNER JOIN products ON cart.product_Id = products.id";
$stmt = $db->prepare($sql);
$stmt->execute();
$viewCarts = $stmt->fetchAll();
?>
<div class="container">
    <h2 class="bg-primary text-light rounded text-center mt-3">Shopping Cart</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($viewCarts as $viewCart): ?>
                    <tr>
                        <td><img src='../admin/products/products-Image/<?= $viewCart['img']; ?>' alt='Product Image' style='max-width: 100px;'></td>
                        <td><?= $viewCart['name']; ?></td>   
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="productId" value="<?= $viewCart['id']; ?>">
                                <input type="number" class="form-control" name="newAmount" value="<?= $viewCart['amount']; ?>">
                        </td>
                        <td><?= $viewCart['price']; ?></td>
                        <td><?= $viewCart['amount'] * $viewCart['price']; ?></td>
                        <td>
                            <button type="submit" class="btn btn-primary" name="updateAmount">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="../cart/dRviewCart.php?id=<?= $viewProduct['id'] ?>" method="post">
                                <button type="submit" class="link-offset-2 link-underline link-underline-opacity-0 btn" name="deleteCart">
                                    <i class="fa fa-times-circle-o"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <h2>Total Price = <?php echo getTotal($db) ?> </h2>
    </div>
  </div>
</div>
<?php require('../template/footer.php') ?>
