<nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <a class="navbar-brand" href="http://localhost/e-shop/layout/template/main.php">E-Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav justify-content-end">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="http://localhost/e-shop/layout/template/main.php">Home</a>
      </li>
      <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="http://localhost/e-shop/layout/products/product.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-cart-plus"></i></a>
      </li>
      <li class="nav-item">
        <?php 
         session_start();
          if (isset($_SESSION["firstname"]) != null) {
            echo '<a class="nav-link" href="http://localhost/e-shop/layout/login-users/logout.php">logout</a>';
          } else {
            echo '<a class="nav-link" href="http://localhost/e-shop/layout/login-users/login.php"><i class="fa fa-user"></i></a>';
          }
        ?>
      </li>
      <li class="nav-item"> 
        
      </li>
      <li class="nav-item dropend">
        <?php 
          if (isset($_SESSION["firstname"])) {
            echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
            echo '<img src="../../image/' . $_SESSION["img"] . '" alt="' . $_SESSION["firstname"] . '" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;">';
            echo $_SESSION["firstname"];
            echo '</a>';
              echo '<ul class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '<li><a class="dropdown-item" href="http://localhost/e-shop/layout/users/edit.php?id=' . $_SESSION["id"] . '">Edit</a></li>';
                    echo '<li><a class="dropdown-item" href="http://localhost/e-shop/layout/users/profile.php?id=' . $_SESSION["id"] . '">Profile</a></li>';
              echo '</ul>';
          }
        ?>
      </li>
    </ul>
  </div>
</nav>

