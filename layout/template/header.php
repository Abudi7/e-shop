<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Online-Shop</title>
</head>
<body>
<?php
// Check if the user is logged in and has the role of admin
if (isset($_SESSION['role']) && $_SESSION['role'] === "Role['admin']") {
    // Include the navbar for admin
    include "navbar.php";
} else {
    // Include the navbar for regular users
    include "navbarUser.php";
}
?>

