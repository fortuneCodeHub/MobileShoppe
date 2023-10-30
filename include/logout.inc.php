<?php 

session_start();
unset($_SESSION["UserId"]);
unset($_SESSION["Usename"]);
header("Location:../index.php");