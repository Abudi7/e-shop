<?php 
session_start();
session_destroy();

header("Location: http://localhost/e-shop/e-shop/layout/template/main.php");