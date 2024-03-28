<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">E-Shop Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <?php 
                        session_start(); // Start the session
                        if (isset($_SESSION["firstname"])) {
                          echo '<a class="nav-link" href="../login/logout.php">Logout</a>';
                        } else {
                          echo '<a class="nav-link" href="../login/login.php"><i class="fa fa-user"></i>Login</a>';
                        }
                      ?>
                    </li>
                    <li class="nav-item"> 
                      
                    </li>
                    <li class="nav-item dropend">
                      <?php 
                          if (isset($_SESSION["firstname"])) {
                              echo '<a class="nav-link" href="http://localhost/e-shop/e-shop/layout/users/profile.php?id=' . $_SESSION["id"] . '">';
                              echo "Admin " . $_SESSION["firstname"];
                              echo '</a>';
                          }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="bg-dark text-white"  style="width: 250px;">
            <div class="sidebar-heading p-3">Admin Dashboard</div>
            <div class="list-group list-group-flush">
                <a href="../products/main.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-home"></i> Home</a>
                <a href="../products/product.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-cube"></i> Products</a>
                <a href="../coustmor/coustmor.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-users"></i> Customers</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-shopping-cart"></i> Orders</a>
            </div>
        </div>




  