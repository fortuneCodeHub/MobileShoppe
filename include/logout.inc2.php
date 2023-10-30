<?php 

session_start();
unset($_SESSION["cus_user_id"]);
unset($_SESSION["cus_username"]);
header("Location:../index.php");