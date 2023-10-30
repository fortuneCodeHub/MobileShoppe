<?php
    $conection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>