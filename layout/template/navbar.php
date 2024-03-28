
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <a class="navbar-brand" href="http://localhost/e-shop/e-shop/layout/template/main.php">E-Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav justify-content-end">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="http://localhost/e-shop/e-shop/layout/template/main.php">Home</a>
      </li>
      <li class="nav-item">
        <?php
      //   // Check if the user is logged in and has the role of admin
      //   if (isset($_SESSION['role']) && $_SESSION['role'] === "Role['admin']") {
      //     // Include the product for admin

      //     echo '<a class="nav-link active" aria-current="page" href="http://localhost/e-shop/e-shop/layout/products/product.php">Products</a>';
      //   } 
      //   ?>
       </li>
      <li class="nav-item">
        <?php 
         
          if (isset($_SESSION["firstname"]) != null) {
            echo '<a class="nav-link" href="../login/logout.php">logout</a>';
          } else {
            echo '<a class="nav-link" href="../login/login.php"><i class="fa fa-user"></i></a>';
          }
        ?>
      </li>
      <li class="nav-item"> 
        
      </li>
      <li class="nav-item dropend">
        <?php 
          if (isset($_SESSION["firstname"])) {
            echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
            #echo '<img src="../../image/' . $_SESSION["img"] . '" alt="' . $_SESSION["firstname"] . '" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;">';
            echo $_SESSION["firstname"];
            echo '</a>';
              echo '<ul class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '<li><a class="dropdown-item" href="http://localhost/e-shop/e-shop/layout/users/edit.php?id=' . $_SESSION["id"] . '">Edit</a></li>';
                    echo '<li><a class="dropdown-item" href="http://localhost/e-shop/e-shop/layout/users/profile.php?id=' . $_SESSION["id"] . '">Profile</a></li>';
              echo '</ul>';
          }
        ?>
      </li>
     <!-- Sidebar Right -->
      <li class="nav-item d-flex align-items-center">
          <a class="nav-link position-relative" href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
              <i class="fa fa-cart-plus"></i>
              <span id="notification-number">
                  <?php require_once('../cart/cart.php'); getCountId($db); ?>
              </span>
          </a>
          <div class="modal fade sidebar-right" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="shoppingCartModalLabel">Shopping Cart</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                      <?php 
                        $sql ="SELECT cart.*, products.name, products.img, products.price
                                FROM cart 
                                INNER JOIN products ON cart.product_Id = products.id";
                        $stmt = $db->prepare($sql);
                        $stmt->execute();
                        $viewProducts = $stmt->fetchAll();
                        foreach ($viewProducts as $viewProduct) {
                        ?>
                          <div class="container">
                              <div class="row">
                                  <div class="col-md-3">
                                      <img src="../products/products-Image/<?=$viewProduct['img']; ?>" class="img-thumbnail m-1" style="width: 50px; height: 50px;">
                                  </div>
                                  <div class="col-md-7">
                                      <p><?= $viewProduct['name'] ?></p>
                                      <p><span><?=$viewProduct['amount']?></span> x <span><?=$viewProduct['price']?>$</span></p>
                                  </div> 
                                  <div class="col-md-2">
                                      <form action="../cart/deleteCart.php?id=<?= $viewProduct['id'] ?>" method="post">
                                          <button type="submit" class="link-offset-2 link-underline link-underline-opacity-0 btn" name="deleteCart">
                                              <i class="fa fa-times-circle-o"></i>
                                          </button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                        <?php }?>
                      </div>
                      <p class="border-top m-2">Subtotal: <span style="float: right;"><?= getTotal($db) ?>$</span></p>
                      <div class="modal-footer">
                          <a href="../cart/checkout.php" class="btn btn-primary btn-sm">Checkout</a>
                          <a href="../cart/viewCart.php" class="btn btn-primary btn-sm">View Cart</a>
                      </div>
                  </div>
              </div>
          </div>
      </li>
    </ul>
  </div>
</nav>

