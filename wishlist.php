<?php   
// Reminder 
session_start();
require_once "dbdetails.php";
try {
    require_once "dbconnect.php";
    // if (isset($_GET["action"])) {
    //     if ($_GET["action"] == "delete") {
            // foreach ($_SESSION["shopping_cart"] as $key => $value) {
            //     if ($value["item_id"] == $_GET["item_id"]) {
            //         unset($_SESSION["shopping_cart"]["$key"]);
            //         header("Location:shoppingcart.php");
            //     }
            // }
    //     }
    // };

    // "item_price" => $_POST["hidden_item_price"],
    //                 "item_image" => $_POST["hidden_item_image"],
    //                 "item_quantity" => $_POST["hidden_item_quantity"],
    //                 "item_name" => $_POST["hidden_item_name"],
    //                 "item_regdate" => $_POST["hidden_item_regdate"],
    //                 "item_brand" => $_POST["hidden_item_brand"],
    //                 "cart_id" => $cart_id


    if (!isset($_SESSION["wishlist"]) && isset($_SESSION["cus_user_id"])) {
        if(empty($_SESSION["wishlist"])) {

            $sql = "SELECT * FROM wishlist WHERE cus_user_id = :cus_user_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
            $statement->execute();
            $wishlist = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($wishlist as $value) {

                $items_id = $value["item_id"];
                $cart_id = $value["cart_id"];
                $item_quantity = $value["item_quantity"];

                $sql = "SELECT * FROM product WHERE item_id = :item_id";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":item_id", $items_id);
                $statement->execute();
                $product = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($product as $values) {

                    $item_price = $values["item_price"];
                    $item_image = $values["item_image"];
                    $item_name = $values["item_name"];
                    $item_regdate = $values["item_regdate"];
                    $item_brand = $values["item_brand"];

                    $item_array = array(
                        "item_id" => $items_id,
                        "item_price" => $item_price,
                        "item_image" => $item_image,
                        "item_quantity" => $item_quantity,
                        "item_name" => $item_name,
                        "item_regdate" => $item_regdate,
                        "item_brand" => $item_brand,
                        "cart_id" => $cart_id
                    );

                    //Unset the $_SESSION["shopping_cart"] value for that particular item
                    $_SESSION["wishlist"][0] = $item_array;

                }


            }
                
            } else {
                $item_array_id = array_column($_SESSION["wishlist"], "item_id");
                if (!in_array($item_id, $item_array_id)) {

                    $count = count($_SESSION["wishlist"]);
                    $sql = "SELECT * FROM wishlist WHERE cus_user_id = :cus_user_id";
                    $statement = $conection->prepare($sql);
                    $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
                    $statement->execute();
                    $wishlist = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($wishlist as $value) {

                        $items_id = $value["item_id"];
                        $cart_id = $value["cart_id"];
                        $item_quantity = $value["item_quantity"];

                        $sql = "SELECT * FROM product WHERE item_id = :item_id";
                        $statement = $conection->prepare($sql);
                        $statement->bindParam(":item_id", $items_id);
                        $statement->execute();
                        $product = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($product as $values) {

                        $item_price = $values["item_price"];
                        $item_image = $values["item_image"];
                        $item_name = $values["item_name"];
                        $item_regdate = $values["item_regdate"];
                        $item_brand = $values["item_brand"];

                        $item_array = array(
                            "item_id" => $items_id,
                            "item_price" => $item_price,
                            "item_image" => $item_image,
                            "item_quantity" => $item_quantity,
                            "item_name" => $item_name,
                            "item_regdate" => $item_regdate,
                            "item_brand" => $item_brand,
                            "cart_id" => $cart_id
                        );

                       //Unset the $_SESSION["shopping_cart"] value for that particular item
                       $_SESSION["wishlist"][$count] = $item_array;

                }


            }

                
    
                } else {
                    echo "Item Already Added";
                    header("Location:productpage.php");
                }
                
            }
    }

    $item_id  = "";
    $item_quantity = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $item_id = $_GET["item_id"];
            $item_quantity = $_POST["hidden_item_quantity"];

        if (isset($_POST["add_to_cart"])) {

            
            if(empty($_SESSION["shopping_cart"])) {

                

            // Select Data from shopping_cart table 
            


            // Insert Values into shopping_cart table
            $sql = "INSERT INTO cart(item_id, item_quantity)
            VALUES(:item_id, :item_quantity)";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $item_id);
            $statement->bindParam(":item_quantity", $item_quantity);
            $statement->execute();

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
                $_SESSION["shopping_cart"][0] = $item_array;

                

                foreach ($_SESSION["wishlist"] as $key => $value) {
                    if ($value["cart_id"] == $cart_id) {
                        unset($_SESSION["wishlist"]["$key"]);
                    }
                }
                // Delete shopping cart item
                $sql = "DELETE FROM wishlist WHERE cart_id = :cart_id";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":cart_id", $cart_id);
        $statement->execute();
        header("Location:shoppingcart.php");
                
            } else {
                $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                if (!in_array($item_id, $item_array_id)) {
                    


            // Insert Values into cart table
            $sql = "INSERT INTO cart(item_id, item_quantity)
            VALUES(:item_id, :item_quantity)";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $item_id);
            $statement->bindParam(":item_quantity", $item_quantity);
            $statement->execute();
            // // Select data from cart table
            // $sql = "SELECT * FROM shopping_cart WHERE item_id = :item_id";
            // $statement = $conection->prepare($sql);
            // $statement->bindParam(":item_id", $item_id);
            // $statement->execute();
            // $product_cart = $statement->fetch(PDO::FETCH_ASSOC);

                    
            $cart_id = $_POST["cart_id"];
                    $count = count($_SESSION["shopping_cart"]);
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
                    $_SESSION["shopping_cart"][$count] = $item_array;

                     

                    foreach ($_SESSION["wishlist"] as $key => $value) {
                        if ($value["item_id"] == $item_id) {
                            unset($_SESSION["wishlist"]["$key"]);
                        }
                    }
                    // Delete shopping cart item
                    $sql = "DELETE FROM wishlist WHERE item_id = :item_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $item_id);
            $statement->execute();

            header("Location:shoppingcart.php");
                } else {
                    echo "Item Already Added";
                    header("Location:productpage.php");
                }
            }

        }
        
    }


    
} catch (PDOException $e) {
    echo $e->getMessage();
}
$total = [];
$subtotal = "";
?>
<?php include_once "htmlscripts.php"; ?>
        <!-- Start Header -->
        <?php include_once "header.php"; ?>
         <!-- End Header -->
        <!-- Start navbar -->
        <?php include_once "navbar.php"; ?>
        <!-- End Navbar -->
        <!-- Start Main -->
        <main id="main">

            <!-- Wishlist Begins -->
            <section id="wishlist" class="py-4 px-2">
                <div class="container">
                    <h3 class="p-1 font-size-20">
                        Wishlist
                    </h3>

                    <!-- Wishlist items -->
                    <?php if(isset($_SESSION["wishlist"]) && !isset($_SESSION["cus_user_id"])){ ?>  
                    <?php if(!empty($_SESSION["wishlist"])): ?>
                        <div class="row">
                    <?php foreach($_SESSION["wishlist"] as $keys => $values): ?>
                        <div class="col-md-9 border">
                            <div class="row">
                                <div class="col-md-3 py-2 pe-0 pe-md-5 text-center text-md-start">
                                    <img src="<?php $image = $values["item_image"]; 
                                    if ($image) {
                                        echo $values["item_image"];
                                    } else {
                                        echo "assets/file-image.svg";
                                    } ?>" alt="" style="width: 70%;" class="img-fluid">
                                </div>
                                <div class="col-md-9 mt-md-0 mt-2">
                                    <div class="d-flex justify-content-between">
                                        <div  class="text-start">
                                            <h6 class="font-size-20">
                                                <?php echo $values["item_name"]; ?>
                                            </h6>
                                            <p><small><?php echo $values["item_brand"]; ?></small></p>
                                            <div class="d-flex">
                                                <div class="text-warning font-size-14">
                                                    <span><i class="bi bi-star-fill text-warning"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                </div>
                                                <a href="" class="px-2 font-size-14">20543+ ratings</a>
                                            </div>
                                            <div>
                                                <div class="px-md-0 mx-2 mx-md-0 my-3 my-md-0 pt-md-3 button-cont">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                    <form action="deletewishlist.php?item_id=<?php echo $values["item_id"]; ?>" method="POST" class="me-2">
                                                    <input type="hidden" name="item_id" value="<?php echo $values["item_id"]; ?>">
                                                    <button class="btn btn-outline-danger" type="submit" name="delete" >Delete</button>
                                                    </form> 
                                                    <div>
                                                    <form action="wishlist.php?item_id=<?php echo $values["item_id"]; ?>" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="hidden_item_name" value="<?php echo $values["item_name"]; ?>">
                                                    <input type="hidden" name="hidden_item_price" value="<?php echo $values["item_price"] ?>">
                                                    <input type="hidden" name="hidden_item_image" value="<?php echo $values["item_image"] ?>">
                                                    <input type="hidden" name="hidden_item_quantity" value="<?php echo $values["item_quantity"]; ?>">
                                                    <input type="hidden" name="hidden_item_regdate" value="<?php echo $values["item_regdate"]; ?>">
                                                    <input type="hidden" name="hidden_item_brand" value="<?php echo $values["item_brand"]; ?>">
                                                    <input type="hidden" name="cart_id" value="<?php echo $values["cart_id"] ?>" >
                                                    <button class="btn btn-outline-warning" type="submit" name="add_to_cart">Add To Cart</button>
                                                    </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-size-20 text-danger"><?php echo $values["item_price"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 

$sql = "SELECT item_quantity FROM wishlist WHERE cart_id = :cart_id";
$stmnt = $conection->prepare($sql);
$stmnt->bindParam(":cart_id", $values["cart_id"]);
$stmnt->execute();
$pro_cart = $stmnt->fetch(PDO::FETCH_ASSOC);

                        ?>
                        <?php 
                        $item_price = $values["item_price"];
                        ?>
                        <?php 
                        $item_quantity = $pro_cart["item_quantity"];
                        if ($item_price) {
                            $subtotal = $item_price * $item_quantity; 
                            $total[] = $subtotal;  
                        } else {
                            $item_price = null;
                        }
                        ?>
                        <div class="col-md-3 border text-center">
                            <h6 class="text-success mt-2">Your order is elligible for free delivery</h6>
                            <div class="product-det text-center">
                                <p class="font-size-18">Subtotal (<?php echo $item_quantity; ?>) items: <span class="text-danger font-size-20"><?php echo $subtotal; ?></span></p>
                            </div>
                        </div> 
                        <?php endforeach; ?>
                        <br>
                    </div>
                </div>
                <?php endif; ?>
                    <?php } elseif(isset($_SESSION["cus_user_id"])) { ?>
                            <?php
                        $sql = "SELECT * FROM wishlist WHERE cus_user_id = :cus_user_id";
                        $statement = $conection->prepare($sql);
                        $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
                        $statement->execute();
                        $wishlist = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="row">
                    <?php foreach($wishlist as $value): ?>
                        <?php $item_id = $value["item_id"]; ?>
                        <?php 
                        $sql = "SELECT * FROM product WHERE item_id = :item_id";
                        $statement = $conection->prepare($sql);
                        $statement->bindParam(":item_id", $item_id);
                        $statement->execute();
                        $wishlist_items = $statement->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-md-9 border">
                            <div class="row">
                                <div class="col-md-3 py-2 pe-0 pe-md-5 text-center text-md-start">
                                    <img src="<?php $image = $wishlist_items["item_image"]; 
                                    if ($image) {
                                        echo $wishlist_items["item_image"];
                                    } else {
                                        echo "assets/file-image.svg";
                                    } ?>" alt="" style="width: 70%;" class="img-fluid">
                                </div>
                                <div class="col-md-9 mt-md-0 mt-2">
                                    <div class="d-flex justify-content-between">
                                        <div  class="text-start">
                                            <h6 class="font-size-20">
                                                <?php echo $wishlist_items["item_name"]; ?>
                                            </h6>
                                            <p><small><?php echo $wishlist_items["item_brand"]; ?></small></p>
                                            <div class="d-flex">
                                                <div class="text-warning font-size-14">
                                                    <span><i class="bi bi-star-fill text-warning"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                <span><i class="bi bi-star-fill"></i></span>
                                                </div>
                                                <a href="" class="px-2 font-size-14">20543+ ratings</a>
                                            </div>
                                            <div>
                                                <div class="px-md-0 mx-2 mx-md-0 my-3 my-md-0 pt-md-3 button-cont">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                    <form action="deletewishlist.php?item_id=<?php echo $wishlist_items["item_id"]; ?>" method="POST" class="me-2">
                                                    <input type="hidden" name="item_id" value="<?php echo $wishlist_items["item_id"]; ?>">
                                                    <button class="btn btn-outline-danger" type="submit" name="delete" >Delete</button>
                                                    </form> 
                                                    <div>
                                                    <form action="wishlist.php?item_id=<?php echo $wishlist_items["item_id"]; ?>" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="hidden_item_name" value="<?php echo $wishlist_items["item_name"]; ?>">
                                                    <input type="hidden" name="hidden_item_price" value="<?php echo $wishlist_items["item_price"] ?>">
                                                    <input type="hidden" name="hidden_item_image" value="<?php echo $wishlist_items["item_image"] ?>">
                                                    <input type="hidden" name="hidden_item_quantity" value="<?php echo $value["item_quantity"]; ?>">
                                                    <input type="hidden" name="hidden_item_regdate" value="<?php echo $wishlist_items["item_regdate"]; ?>">
                                                    <input type="hidden" name="hidden_item_brand" value="<?php echo $wishlist_items["item_brand"]; ?>">
                                                    <input type="hidden" name="cart_id" value="<?php echo $value["cart_id"] ?>" >
                                                    <button class="btn btn-outline-warning" type="submit" name="add_to_cart">Add To Cart</button>
                                                    </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-size-20 text-danger"><?php echo $wishlist_items["item_price"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 

                        ?>
                        <?php 
                        $item_price = $wishlist_items["item_price"];
                        ?>
                        <?php 
                        $item_quantity = $value["item_quantity"];
                        if ($item_price) {
                            $subtotal = $item_price * $item_quantity; 
                            $total[] = $subtotal;  
                        } else {
                            $item_price = null;
                        }
                        ?>
                        <div class="col-md-3 border text-center">
                            <h6 class="text-success mt-2">Your order is elligible for free delivery</h6>
                            <div class="product-det text-center">
                                <p class="font-size-18">Subtotal (<?php echo $item_quantity; ?>) items: <span class="text-danger font-size-20"><?php echo $subtotal; ?></span></p>
                            </div>
                        </div> 
                        <?php endforeach; ?>
                        <br>
                    </div>
                </div>
                    <?php } ?>
                    <!--  <div style="width:95%;margin:auto;padding: 50px 0px;">
                            <img src="assets/envelope-x-fill.svg" alt="" style="width:100%;height:100px;">
                        </div> -->

                <div class="text-center">
                    <?php 
                    
                    if(!empty($total)) {
                        $sum = 0;
                        foreach ($total as $totalval) {
                            $sum += $totalval;
                        }
                    } else {
                        $total = null;
                        $sum = null;
                    }
                    ?>
                    Total price : <?php echo $sum; ?>
                </div>
              
            </div>
        </section>
            <!-- Wishlist Ends -->

            </main>
        <!-- End Main -->
        <?php include_once "scripts.php"; ?>

        <!-- Include footer with footer.php -->
        <?php include_once "footer.php"; ?>

        <!-- Include go up button with go_up.php -->
        <?php include_once "go_up.php"; ?>






</html>