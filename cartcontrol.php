<?php
if (!isset($_SESSION["cus_user_id"])) {
    if(empty($_SESSION["wishlist"])) {

                

        // Select Data from wishlist table 
        

        $cart_id = $_POST["cart_id"];
            $item_array = array(
                "item_id" => $_GET["item_id"],
                "item_price" => $_POST["hidden_item_price"],
                "item_image" => $_POST["hidden_item_image"],
                "item_quantity" => $_POST["hidden_item_quantity"],
                "item_name" => $_POST["hidden_item_name"],
                "item_regdate" => $_POST["hidden_item_regdate"],
                "item_brand" => $_POST["hidden_item_brand"],
                "cart_id" => $cart_id
            );

            //Unset the $_SESSION["shopping_cart"] value for that particular item
            $_SESSION["wishlist"][0] = $item_array;

            // Insert Values into wishlist table
        $sql = "INSERT INTO wishlist(cart_id, item_id, item_quantity)
        VALUES(:cart_id, :item_id, :item_quantity)";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":cart_id", $cart_id);
        $statement->bindParam(":item_id", $item_id);
        $statement->bindParam(":item_quantity", $item_quantity);
        $statement->execute();

            foreach ($_SESSION["shopping_cart"] as $key => $value) {
                if ($value["item_id"] == $item_id) {
                    unset($_SESSION["shopping_cart"]["$key"]);
                }
            }
            // Delete shopping cart item
            $sql = "DELETE FROM cart WHERE item_id = :item_id";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":item_id", $item_id);
    $statement->execute();
            
        } else {
            $item_array_id = array_column($_SESSION["wishlist"], "item_id");
            if (!in_array($item_id, $item_array_id)) {
                

        // // Select data from cart table
        // $sql = "SELECT * FROM wishlist WHERE item_id = :item_id";
        // $statement = $conection->prepare($sql);
        // $statement->bindParam(":item_id", $item_id);
        // $statement->execute();
        // $product_cart = $statement->fetch(PDO::FETCH_ASSOC);
        $cart_id = $_POST["cart_id"];

                $count = count($_SESSION["wishlist"]);
                $item_array = array(
                    "item_id" => $_GET["item_id"],
                    "item_price" => $_POST["hidden_item_price"],
                    "item_image" => $_POST["hidden_item_image"],
                    "item_quantity" => $_POST["hidden_item_quantity"],
                    "item_name" => $_POST["hidden_item_name"],
                    "item_regdate" => $_POST["hidden_item_regdate"],
                    "item_brand" => $_POST["hidden_item_brand"],
                    "cart_id" => $cart_id
                );
                $_SESSION["wishlist"][$count] = $item_array;

                 // Insert Values into cart table
        $sql = "INSERT INTO wishlist(cart_id, item_id, item_quantity)
        VALUES(:cart_id, :item_id, :item_quantity)";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":cart_id", $cart_id);
        $statement->bindParam(":item_id", $item_id);
        $statement->bindParam(":item_quantity", $item_quantity);
        $statement->execute();

                foreach ($_SESSION["shopping_cart"] as $key => $value) {
                    if ($value["item_id"] == $item_id) {
                        unset($_SESSION["shopping_cart"]["$key"]);
                    }
                }
                // Delete shopping cart item
                $sql = "DELETE FROM cart WHERE item_id = :item_id";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":item_id", $item_id);
        $statement->execute();
            } else {
                echo "Item Already Added";
                header("Location:productpage.php");
            }
            
        }
} elseif (isset($_SESSION["cus_user_id"])) {
            if(empty($_SESSION["wishlist"])) {

                

                // Select Data from wishlist table 
                
        
                $cart_id = $_POST["cart_id"];
                    $item_array = array(
                        "item_id" => $_GET["item_id"],
                        "item_price" => $_POST["hidden_item_price"],
                        "item_image" => $_POST["hidden_item_image"],
                        "item_quantity" => $_POST["hidden_item_quantity"],
                        "item_name" => $_POST["hidden_item_name"],
                        "item_regdate" => $_POST["hidden_item_regdate"],
                        "item_brand" => $_POST["hidden_item_brand"],
                        "cart_id" => $cart_id
                    );
        
                    //Unset the $_SESSION["shopping_cart"] value for that particular item
                    $_SESSION["wishlist"][0] = $item_array;
        
                    // Insert Values into wishlist table
                $sql = "INSERT INTO wishlist(cart_id, item_id, item_quantity, cus_user_id)
                VALUES(:cart_id, :item_id, :item_quantity, :cus_user_id)";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":cart_id", $cart_id);
                $statement->bindParam(":item_id", $item_id);
                $statement->bindParam(":item_quantity", $item_quantity);
                $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
                $statement->execute();
        
                    foreach ($_SESSION["shopping_cart"] as $key => $value) {
                        if ($value["item_id"] == $item_id) {
                            unset($_SESSION["shopping_cart"]["$key"]);
                        }
                    }
                    // Delete shopping cart item
                    $sql = "DELETE FROM cart WHERE item_id = :item_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $item_id);
            $statement->execute();
                    
                } else {
                    $item_array_id = array_column($_SESSION["wishlist"], "item_id");
                    if (!in_array($item_id, $item_array_id)) {
                        
        
                // // Select data from cart table
                // $sql = "SELECT * FROM wishlist WHERE item_id = :item_id";
                // $statement = $conection->prepare($sql);
                // $statement->bindParam(":item_id", $item_id);
                // $statement->execute();
                // $product_cart = $statement->fetch(PDO::FETCH_ASSOC);
                $cart_id = $_POST["cart_id"];
        
                        $count = count($_SESSION["wishlist"]);
                        $item_array = array(
                            "item_id" => $_GET["item_id"],
                            "item_price" => $_POST["hidden_item_price"],
                            "item_image" => $_POST["hidden_item_image"],
                            "item_quantity" => $_POST["hidden_item_quantity"],
                            "item_name" => $_POST["hidden_item_name"],
                            "item_regdate" => $_POST["hidden_item_regdate"],
                            "item_brand" => $_POST["hidden_item_brand"],
                            "cart_id" => $cart_id
                        );
                        $_SESSION["wishlist"][$count] = $item_array;
        
                         // Insert Values into cart table
                $sql = "INSERT INTO wishlist(cart_id, item_id, item_quantity, cus_user_id)
                VALUES(:cart_id, :item_id, :item_quantity, :cus_user_id)";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":cart_id", $cart_id);
                $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
                $statement->bindParam(":item_id", $item_id);
                $statement->bindParam(":item_quantity", $item_quantity);
                $statement->execute();
        
                        foreach ($_SESSION["shopping_cart"] as $key => $value) {
                            if ($value["item_id"] == $item_id) {
                                unset($_SESSION["shopping_cart"]["$key"]);
                            }
                        }
                        // Delete shopping cart item
                        $sql = "DELETE FROM cart WHERE item_id = :item_id";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":item_id", $item_id);
                $statement->execute();
                    } else {
                        echo "Item Already Added";
                        header("Location:productpage.php");
                    }
                    
                }


}