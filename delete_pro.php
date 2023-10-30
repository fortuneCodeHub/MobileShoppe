<?php 
require_once "dbdetails.php"; 
try {
    $item_id = $_GET["Item_id"];
    if (!$item_id) {
        $item_id = null;
        header("Location:product_table.php?id=table");
        exit;
    }
    require_once "dbconnect.php";
    require_once "include/function.req.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["delete"])) {
            $item_id = $_POST["item_id"];
            $sql = "DELETE FROM product WHERE item_id = :item_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $item_id);
            $statement->execute();
            header("Location:product_table.php?id=table");   
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}