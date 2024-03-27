<?php 
session_start();
session_destroy();

header("Location: ../template/main.php");