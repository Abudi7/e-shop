<?php 

require('../../config/datasBase.php');
session_start();

if (isset($_POST['addToCart'])) {
  $userId = $_SESSION['id'];
  if (!$userId) {
    header("Location: http://localhost/e-shop/e-shop/layout/template/main.php");
      // Redirect or display an error message
      exit("User not authenticated"); 
  }
  $productId = $_REQUEST['id'];
  $amount = 1; // Default amount for each product
    
  // Check if the product already exists in the cart
  $sqlCheck = "SELECT id FROM cart WHERE user_id = ? AND product_id = ?";
  $stmtCheck = $db->prepare($sqlCheck);
  $stmtCheck->execute([$userId, $productId]);
  $existingCartItem = $stmtCheck->fetch();

  if ($existingCartItem) {
      // Update the quantity if the product already exists in the cart
      $sqlUpdate = "UPDATE cart SET amount = amount + 1 WHERE id = ?";
      $stmtUpdate = $db->prepare($sqlUpdate);
      $stmtUpdate->execute([$existingCartItem['id']]);
  } else {
      // Insert a new product into the cart if it doesn't exist
      $date = new DateTime();
      $createdTime = $date->format('Y-m-d H:i:s'); 
      
      $sqlInsert = "INSERT INTO cart (product_id, user_id, amount, created) VALUES (?, ?, ?, ?)";
      $stmtInsert = $db->prepare($sqlInsert);
      $stmtInsert->execute([$productId, $userId, $amount, $createdTime]);
  }
  
  // Redirect securely using header()
  header("Location: http://localhost/e-shop/e-shop/layout/template/main.php");
  exit();
}

//count Cart id 
function getCountId() {
  require('../../config/datasBase.php');
  $userId = $_SESSION['id'];
  if($userId) {
    $sql = "SELECT COUNT(id) As countCart FROM cart where user_id = ? ";
    $stmt = $db->Prepare($sql);
    $countCart = $stmt->execute([$userId]);
    $countCart = $stmt->fetchColumn();
    echo $countCart;
  } else {
    echo "0";
  } 
}

//total price function 
function getTotal() {
  require('../../config/datasBase.php');
  $sql ="SELECT cart.amount, products.price
          FROM cart 
          INNER JOIN products ON cart.product_Id = products.id";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $totalCarts = $stmt->fetchAll();
  $result = 0;
  foreach ($totalCarts as $totalCart) {
    $result += ($totalCart['amount'] * $totalCart['price']); 
  }
   return $result;
}
?>


