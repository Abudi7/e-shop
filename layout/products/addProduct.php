<?php
require('../template/header.php');
require('../../config/datasBase.php');

if(isset($_POST['submit'])) {
  $productsName = $_POST['productName'];
  $productsContent = $_POST['productContent'];
  $productsPrice = $_POST['productPrice'];
  $productsCreated = $_POST['productCreated'];

  $productsImageName = $_FILES['productImage']['name'];
  $tempProductsImage = $_FILES['productImage']['tmp_name']; 

  $targetDirectory = '../products/products-Image/';
  $targetFile =  $targetDirectory . $productsImageName;

  $imageExtension = pathinfo($productsImageName, PATHINFO_EXTENSION);
  $validImage = array('png','jpg','jpeg','svg');

  // Check if the file already exists
  // if (file_exists($targetFile)) {
  //   $nameImage = pathinfo($productsImageName, PATHINFO_FILENAME);
  //   $newNameImage = $nameImage . '_' . rand(0, 99) . '.' . $imageExtension;
  //   $targetFile =  $targetDirectory . $newNameImage;
  // }

  if (in_array($imageExtension, $validImage)) {
    if (move_uploaded_file($tempProductsImage, $targetFile)) {
      $sql = "INSERT INTO products(name,content,price,created,img) VALUES(?,?,?,?,?)";
      $stmt = $db->prepare($sql);
      $stmt->execute(array($productsName,$productsContent,$productsPrice,$productsCreated,$productsImageName));
      echo '<div class="container"><div class="row"><div class="alert alert-success" role="alert">
              Success you have added a new Product.
            </div></div></div>';
    } else {
      echo '<div class="container"><div class="row"><div class="alert alert-danger" role="alert">
         Failed to upload the image.
      </div></div></div>';
    }
  } else {
    echo '<div class="container"><div class="row"><div class="alert alert-danger" role="alert">
       Invalid image file format. Please upload a valid image.
    </div></div></div>';
  }
}
?>
<div class="container">
<h2 class="bg-primary  text-light rounded text-center mt-3"> Add Product</h2>
  <form action="addProduct.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="productName" class="form-label">Product Name</label>
      <input type="text" class="form-control" id="productName" name="productName" required>
    </div>
    <div class="mb-3">
      <label for="productContent" class="form-label">Product Content</label>
      <textarea class="form-control" id="productContent" name="productContent" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label for="productPrice" class="form-label">Product Price</label>
      <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01">
    </div>
    <div class="mb-3">
      <label for="productImage" class="form-label">Product Image</label>
      <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" required>
    </div>
    <div class="mb-3">
      <label for="productCreated" class="form-label">Created Date</label>
      <input type="date" class="form-control" id="productCreated" name="productCreated" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Add Product</button> <!-- Added name attribute -->
  </form>
</div>

<?php require('../template/footer.php');?>
