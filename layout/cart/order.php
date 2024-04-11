<?php
require('../template/header.php');
$stmt = $db->prepare("SELECT * FROM orders");
$stmt->execute();
$orders = $stmt->fetch();

?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="bg-primary text-light rounded text-center mt-3">Your Orders</h2>
    </div>
    

      <table>
        <thead>
        <tr>id</tr>
        </thead>
        <?php foreach($orders as $order) {?>
        <tbody>
          <tr><?= $order['amount'] ?></tr>
          <tr></tr>
          <tr></tr>
          <tr></tr>
          <tr></tr>
        </tbody>
      </table>

      <?php } ?>
  </div>
</div>

