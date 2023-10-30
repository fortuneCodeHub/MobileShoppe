<?php 
session_start();
require_once "dbdetails.php";
try {
    require_once "dbconnect.php";
    $item_id = $_GET["item_id"];
    if (isset($item_id)) {
        if ($item_id = $_GET["item_id"]) {
            foreach ($_SESSION["shopping_cart"] as $key => $value) {
                if ($value["item_id"] == $item_id) {
                    unset($_SESSION["shopping_cart"]["$key"]);
                }
            }
        }
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete"])) {
        $item_id = $_POST["item_id"];
        if (!$item_id) {
            $item_id = null;
            header("Location:shoppingcart.php");
            exit;
        }
        $sql = "DELETE FROM cart WHERE item_id = :item_id";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":item_id", $item_id);
        $statement->execute();
        header("Location:shoppingcart.php?DeletedSuccessfully");
    }
}
} catch (PDOException $e) {
    echo $e->getMessage();
}