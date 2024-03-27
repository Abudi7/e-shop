<?php 

// create a database configeration
define('DATA_SERVER','localhost');
define('DATA_USERNAME','eshop');
define('DATA_DATABASE','onlineshop');
define('DATA_PSSWORD','pw');
define('DATA_CHARSET','utf8');

// Connect mysql with PDO 
$username = DATA_USERNAME;
$password = DATA_PSSWORD;

$dsn = sprintf('mysql:dbname=%s;host=%s;charset=%s;',DATA_DATABASE,DATA_SERVER,DATA_CHARSET);

try {
  $db = new PDO($dsn,$username,$password);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: ".$e->getMessage();
}

?>
