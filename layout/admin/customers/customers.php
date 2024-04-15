<?php 
require('../../../config/datasBase.php');
require_once('../../template/headerAdmin.php');
$stmt = $db->prepare('SELECT * FROM users');
$stmt->execute();
$customers = $stmt->fetchAll();
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="bg-primary text-light rounded text-center mt-2">Customers Dashboard</h2>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="table-secondary">
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Role</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($customers as $index => $customer) { ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $customer['firstname'] ?></td>
                <td><?= $customer['lastname'] ?></td>
                <td><?= $customer['email'] ?></td>
                <td><?= $customer['role'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require('../../template/footer.php');?>