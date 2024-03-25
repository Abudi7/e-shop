<?php 
require('../../config/datasBase.php');
$id = $_REQUEST['id'];
$sql = "DELETE FROM products WHERE id=$id";
$stmt = $db->prepare($sql);
$stmt->execute();
header('Location: product.php');