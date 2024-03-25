<?php 
require('../template/header.php');
require('../../config/datasBase.php');

$id = $_REQUEST['id'];
$sql = "SELECT * FROM products where id='".$id."'";
$stmt = $db->prepare($sql);
$stmt->execute();
$product= $stmt->fetch();

// Check if the form is submitted
if (isset($_POST['submit'])) {
  //$id = $_POST['id'];
  $productsName = $_POST['productName'];
  $productsContent = $_POST['productContent'];
  $productsPrice = $_POST['productPrice'];
  $productsUpdate = $_POST['productCreated'];

  $productsImageName = $_FILES['productImage']['name'];
  $tempProductsImage = $_FILES['productImage']['tmp_name']; 

  $targetDirectory = '../products/products-Image/';
  $targetFile =  $targetDirectory . $productsImageName;

  $imageExtension = pathinfo($productsImageName, PATHINFO_EXTENSION);
  $validImage = array('png','jpg','jpeg','svg');

  // Check if the image is valid
  if (in_array($imageExtension, $validImage)) {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($tempProductsImage, $targetFile)) {
      // Prepare and execute the SQL update query
      $sql = "UPDATE products SET name = :name, content = :content, price = :price, created = :created, img = :img WHERE id = :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':name', $productsName);
      $stmt->bindParam(':content', $productsContent);
      $stmt->bindParam(':price', $productsPrice);
      $stmt->bindParam(':created', $productsUpdate);
      $stmt->bindParam(':img', $productsImageName);
      $stmt->bindParam(':id', $id);

      if ($stmt->execute()) {
        // If the update is successful, redirect to product.php
        header('Location: product.php');
        exit; // Stop further execution of the script
      } else {
        echo '<div class="alert alert-danger" role="alert">
                Failed to update the product.
              </div>';
      }
    } else {
      echo '<div class="alert alert-danger" role="alert">
              Failed to upload the image.
            </div>';
    }
  } else {
    echo '<div class="container"><div class="row"><div class="alert alert-danger" role="alert">
           Invalid image file format. Please upload a valid image.
         </div></div></div>';
  }
}
?>
<div class="container">
  <h2 class="bg-primary text-light rounded text-center mt-3"> Update <?= $product['name'] ?> </h2>
  <form  method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="productName" class="form-label">Product Name</label>
      <input type="text" class="form-control" id="productName" name="productName" value="<?= $product['name'] ?>">
    </div>
    <div class="mb-3">
      <label for="productContent" class="form-label">Product Content</label>
      <textarea class="form-control" id="productContent" name="productContent" rows="3"><?= $product['content'] ?></textarea>
    </div>
    <div class="mb-3">
      <label for="productPrice" class="form-label">Product Price</label>
      <input type="number" class="form-control" id="productPrice" name="productPrice" value="<?= $product['price'] ?>" step="0.01">
    </div>
    <div class="mb-3">
      <label for="productImage" class="form-label">Product Image</label>
      <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
      <!-- Display the current image -->
      <img src="../products/products-Image/<?= $product['img'] ?>" class="img-thumbnail mt-2" alt="<?= $product['name'] ?>" style="max-width: 200px;">
    </div>
    <div class="mb-3">
      <label for="productCreated" class="form-label">Created Date</label>
      <input type="date" class="form-control" id="productCreated" name="productCreated" value="<?= $product['created'] ?>">
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Update</button>
  </form>
</div>


<?php require('../template/footer.php'); ?>