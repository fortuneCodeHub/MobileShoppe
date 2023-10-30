<?php

require_once "dbdetails.php"; 
try {
    $cus_user_id = $_GET["cus_user_id"];
    if (!$cus_user_id) {
        $cus_user_id = null;
        header("Location:product_table.php?id=table");
        exit;
    }
    require_once "dbconnect.php";
    require_once "include/function.req.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uniqid = uniqid("",true);
        if (isset($_POST["delete"])) {
            $cus_user_id = $_POST["cus_user_id"];
            $sql = "DELETE FROM cus_user WHERE cus_user_id = :cus_user_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":cus_user_id", $cus_user_id);
            $statement->execute();
            echo header("Location:customers.php?id=$uniqid");   
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}