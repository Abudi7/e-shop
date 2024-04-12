<?php 
require("../../config/datasBase.php");
$id = $_REQUEST['id'];
$stmt = $db->prepare("SELECT o.*, GROUP_CONCAT(p.name SEPARATOR ', ') AS productNames
                      FROM orders o
                      INNER JOIN order_items oi ON o.id = oi.order_id
                      INNER JOIN products p ON oi.product_id = p.id
                      WHERE o.id=?");
$stmt->execute([$id]);
$order = $stmt->fetch();
$invoice = rand();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .invoice-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #f9f9f9;
    }
    .invoice-header {
      text-align: center;
    }
    .invoice-number {
      font-size: 24px;
      color: #007bff;
      margin-bottom: 20px;
    }
    .invoice-details {
      margin-bottom: 20px;
    }
    .invoice-product-list {
      margin-bottom: 20px;
    }
    .product-item {
      margin-bottom: 10px;
    }
    .total-amount {
      font-size: 20px;
      font-weight: bold;
    }
  </style>
  <title>Invoice</title>
</head>
<body>
<div class="invoice-container">
  <div class="invoice-header">
    <h1 class="bg-primary text-light rounded text-center">E-shop Invoice</h1>
    <p class="invoice-number">Invoice Number: <?= $invoice ?></p>
  </div>
  <div class="invoice-details">
    <p>Dear <?= $order['firstName'] ?> <?= $order['lastName'] ?>,</p>
    <p>Order Date: <?= $order['orderDate'] ?></p>
    <p>Email: <?= $order['email'] ?></p>
  </div>
  <div class="invoice-product-list">
    <h3>Products:</h3>
    <?php foreach(explode(', ', $order['productNames']) as $productName) { ?>
      <div class="product-item"><?= $productName ?></div>
    <?php } ?>
  </div>
  <div class="total-amount">
    <p>Total: <?= $order['orderTotal'] ?> $</p>
  </div>
</div>
<script>
  window.onload = function() {
    window.print();
  };
</script>
</body>
</html>
