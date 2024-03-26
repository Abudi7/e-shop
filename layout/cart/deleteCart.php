<?php 
require('../../config/datasBase.php');
if (isset($_POST['deleteCart'])) {
    $cartId = $_REQUEST['id'];
    $sql = "DELETE FROM cart WHERE id= $cartId";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Redirect securely using header()
    header("Location: http://localhost/e-shop/e-shop/layout/template/main.php");
    exit(); // Halt execution
    
}
?>