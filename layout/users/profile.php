<?php
require('../template/header.php');
$id = $_REQUEST['id'];
$sql = "SELECT * FROM users where id='".$id."'";
$stmt = $db->prepare($sql);
$stmt->execute();
$user = $stmt->fetch();
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <h2 class="bg-primary text-light rounded text-center mt-3">Your Detils</h2>
    </div>
</div>
  <div class="row mt-2">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center"><?= $user['firstname'] ?> <?= $user['lastname'] ?></h5>
          <p class="card-text"><strong>Email:</strong> <?= $user['email'] ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require('../template/footer.php'); ?>
