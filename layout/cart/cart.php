<?php 

if (isset($_POST['addToCart'])) {
  // $userId = $_SESSION['id'];
  // if (!$userId) {
  //   header("Location: ../template/main.php");
  //     // Redirect or display an error message
  //     exit("User not authenticated"); 
  // }
  session_start();
  require('../../config/datasBase.php');
  // add to cart without login via session id 
  $userId = random_int(0,time());

  if (isset($_COOKIE['userId'])) {
    $userId = (int) $_COOKIE['userId'];
  }
  
  if (isset($_SESSION['userId'])) {
    $userId = (int) $_SESSION['userId'];
  }
  
  setcookie('userId',$userId,strtotime ('+30 days'));
  $_SESSION['userId'] = $userId;
  //var_dump($_SESSION); exit();
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
  
  // Retrieve the count of items in the cart
  if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $sql = "SELECT COUNT(id) FROM cart WHERE user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userId]);
    $countCart = $stmt->fetchColumn();
  } else {
    $countCart = 0;
  }


  //var_dump($countCart); exit();
  
  // Redirect securely using header()
  header("Location: ../template/main.php");
  exit();
}

// Count Cart IDs for the same user
function getCountId($db) {
      
      $userId = (int) $_SESSION['userId'];
      //var_dump($userId);
      $sql = "SELECT COUNT(id) FROM cart WHERE user_id = ?";
      $stmt = $db->prepare($sql);
      $stmt->execute([$userId]);
      $countCart = $stmt->fetchColumn();
      //var_dump($countCart); die();
      return $countCart;
   
}



//total price function 
function getTotal($db) {
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

//checkout method for name x mount
function getCheckout($db){
  $sql ="SELECT cart.amount, products.name
          FROM cart 
          INNER JOIN products ON cart.product_Id = products.id";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $checkout = $stmt->fetch();
  
} 
?>


