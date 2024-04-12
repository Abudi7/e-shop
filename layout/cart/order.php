<?php
require('../template/header.php');

// Fetch orders data
$stmt = $db->prepare("SELECT o.*, GROUP_CONCAT(p.name SEPARATOR ', ') AS productNames
                      FROM orders o
                      INNER JOIN order_items oi ON o.id = oi.order_id
                      INNER JOIN products p ON oi.product_id = p.id
                      GROUP BY o.id");
$stmt->execute();
$orders = $stmt->fetchAll();

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="bg-primary text-light rounded text-center mt-3">Your Orders</h2>
    </div>
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Order Number</th>
              <th>Order Date</th>
              <th>Total Amount</th>
              <th>Products</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $order) {?>
              <tr>
                <td><a class="text-primary" href="oneOrder.php?id=<?= $order['id'];?>"><?= $order['orderNumber'] ?></a></td>
                <td><?= $order['orderDate'] ?></td>
                <td><?= $order['orderTotal'] ?> $</td>
                <td><?= $order['productNames'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  function printInvoice(orderId) {
    window.print();
  }
</script>

<?php include "../template/footer.php"; ?>