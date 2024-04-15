<?php 
require('../../template/headerAdmin.php');
require_once('../../../config/datasBase.php');

$stmt = $db->prepare('SELECT oi.product_id, p.name AS productName, SUM(oi.amount) AS totalSold
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.id
                      GROUP BY oi.product_id, p.name
                      ORDER BY totalSold DESC
                      LIMIT 5;');
$stmt->execute();
$bestSellings = $stmt->fetchAll();
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="bg-primary text-light rounded text-center mt-2">Best-Selling Products</h2>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="table-secondary">
              <th>#</th>
              <th>Product Name</th>
              <th>Total Sold</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($bestSellings as $index => $product) { ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $product['productName'] ?></td>
                <td><?= $product['totalSold'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php 
$stmt = $db->prepare('SELECT o.user_id, u.firstname, u.lastname, COUNT(o.id) AS totalOrders
                      FROM orders o
                      JOIN users u ON o.user_id = u.id
                      GROUP BY o.user_id, u.firstname, u.lastname
                      ORDER BY totalOrders DESC
                      LIMIT 5;');
$stmt->execute();
$topUsers = $stmt->fetchAll();
?>
<div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="bg-primary text-light rounded text-center mt-2">Top Purchasing Users</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Total Orders</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($topUsers as $index => $topUser) { ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $topUser['firstname'] ?></td>
                <td><?= $topUser['lastname'] ?></td>
                <td><?= $topUser['totalOrders'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php
  $stmt = $db->prepare('SELECT o.*, p.name AS productName
                        FROM orders o
                        JOIN order_items oi ON o.id = oi.order_id
                        JOIN products p ON oi.product_id = p.id
                        WHERE o.orderDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 4 WEEK)');
  $stmt->execute();
  $weeks = $stmt->fetchAll();
  ?>
   <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="bg-primary text-light rounded text-center mt-2">Orders in Last Four Weeks</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>Order Date</th>
              <th>User Name</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($weeks as $index => $week) { ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $week['productName'] ?></td>
                <td><?= $week['orderDate'] ?></td>
                <td><?= $week['firstName'] . " ".$week['lastName']  ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php require('../../template/footer.php');?>
