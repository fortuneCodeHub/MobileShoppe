<?php 
session_start();
// echo "Wishlist Items <br>";
// var_dump($_SESSION["wishlist"]);
// echo "<br>";
// echo "Shopping Cart Items";
// var_dump($_SESSION["shopping_cart"]);
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

    $item_id  = "";
    $item_quantity = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $item_id = $_GET["item_id"];
            $item_quantity = $_POST["hidden_item_quantity"];
        

        if (isset($_POST["save_for_later"])) {

            
            include_once "cartcontrol.php";
        }
        
    }


    

    $sql = "SELECT * FROM product";
    $statment = $conection->prepare($sql);
    $statment->execute();
    $products = $statment->fetchAll(PDO::FETCH_ASSOC);

    
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

            <!-- Sopping Cart Begins -->
            <section id="shopping-cart" class="py-4 px-2">
                <div class="container">
                    <h3 class="p-1 font-size-20">
                        Shopping Cart
                    </h3>

                    <!-- Shopping Cart items -->  
                    <?php if(!empty($_SESSION["shopping_cart"])):?>
                        
                        <div class="row">
                    <?php foreach($_SESSION["shopping_cart"] as $keys => $values): ?>
                        <?php $count = count($_SESSION["shopping_cart"]) ;?>
                        <?php 

$sql = "SELECT * FROM cart WHERE item_id = :item_id";
$stmnt = $conection->prepare($sql);
$stmnt->bindParam(":item_id", $values["item_id"]);
$stmnt->execute();
$pro_cart = $stmnt->fetch(PDO::FETCH_ASSOC);

                        ?>
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
                                                <a href="" class="px-2 font-size-14">20543+ ratings <?php echo $pro_cart["cart_id"]; ?></a>
                                            </div>
                                            <div>
                                                <div class="px-md-0 mx-2 mx-md-0 my-3 my-md-0 pt-md-3 button-cont">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                    <form action="deletecartitem.php?item_id=<?php echo $values["item_id"]; ?>" method="POST" class="me-2">
                                                    <input type="hidden" name="item_id" value="<?php echo $values["item_id"]; ?>">
                                                    <button class="btn btn-outline-danger" type="submit" name="delete" >Delete</button>
                                                    </form> 
                                                    <form action="shoppingcart.php?item_id=<?php echo $values["item_id"]; ?>" method="POST" enctype="multipart/form-data" class="me-2">
                                                    <input type="hidden" name="hidden_item_name" value="<?php echo $values["item_name"]; ?>">
                                                    <input type="hidden" name="hidden_item_price" value="<?php echo $values["item_price"] ?>">
                                                    <input type="hidden" name="hidden_item_image" value="<?php echo $values["item_image"] ?>">
                                                    <input type="hidden" name="hidden_item_quantity" value="<?php echo $pro_cart["item_quantity"]; ?>">
                                                    <input type="hidden" name="hidden_item_regdate" value="<?php echo $values["item_regdate"]; ?>">
                                                    <input type="hidden" name="hidden_item_brand" value="<?php echo $values["item_brand"]; ?>">
                                                    <input type="hidden" name="cart_id" value="<?php echo $pro_cart["cart_id"]; ?> ">
                                                    <button class="btn btn-outline-primary" type="submit" name="save_for_later">Save For Later</button>
                                                    </form>
                                                    <a href="editcart_item.php?item_id=<?php  echo $values["item_id"];?>&cart_id=<?php echo $pro_cart["cart_id"]; ?>" class="btn btn-outline-success">Edit Item</a>
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
                                <?php if($count == 1): ?>
                                    <div class="text-center mt-3">
                                    <?php if(!isset($_SESSION["cus_user_id"]) && !isset($_SESSION["cus_username"])) { ?>
                                    <a href="login2.php?id=<?php echo uniqid("",true); ?>&subtotal=<?php echo $subtotal ?>" class="btn btn-warning text-light" style="width: 100%;" type="button">Proceed To Buy</a>
                                <?php } else{ ?>
                                    <a href="checkoutform.php?id=<?php echo uniqid("",true);?>&subtotal=<?php echo $subtotal ?>" class="btn btn-warning text-light" style="width: 100%;" type="button">Proceed To Buy</a>
                                <?php } ?>
                            </div>
                                <?php endif; ?>
                            </div>
                        </div> 
                        <?php endforeach; ?>
                        <br>
                    </div>
                </div>
                    <?php endif; ?>

                    <?php if(empty($_SESSION["shopping_cart"])): ?>
                        <div style="width:95%;margin:auto;padding: 50px 0px;">
                            <img src="assets/cart-x.svg" alt="" style="width:100%;height:100px;">
                        </div>
                    <?php endif; ?>
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
                    <br>
                    <?php
                    if (!empty($_SESSION["shopping_cart"])) {?>
                        <?php foreach ($_SESSION["shopping_cart"] as $key => $value) { ?>
                            <?php $count = count($_SESSION["shopping_cart"]);?>
                        <?php }?>
                        <?php if($count > 1):?>
                            <div class="text-center mt-3">
                            <?php if(!isset($_SESSION["cus_user_id"]) && !isset($_SESSION["cus_username"])) { ?>
                                    <a href="login2.php?id=<?php echo uniqid("",true); ?>&sum=<?php echo $sum ?>" class="btn btn-danger text-light" style="width: 40%;" type="button">Proceed To Buy</a>
                                <?php } else{ ?>
                                    <a href="checkoutform.php?id=<?php echo uniqid("",true);?>&sum=<?php echo $sum ?>" class="btn btn-danger text-light" style="width: 40%;" type="button">Proceed To Buy</a>
                                <?php } ?>
                            </div>

                            <?php endif; ?>
                    <?php } else {?> 
                        <?php $count = "";?>
                    <?php }?>
                    
                </div>
              
            </div>
        </section>
            <!-- Shopping Cart Ends -->


            

            <?php if(!empty($_SESSION["wishlist"])): ?>
<hr class="container p-0">
<!-- Wishlist Begins -->
<section id="wishlist" class="py-5 px-2">
                <div class="container">
                    <h3 class="p-1 font-size-20">
                        Wishlist
                    </h3>

                    <!-- Wishlist items -->  
                    
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
                                                <a href="" class="px-2 font-size-14">20543+ ratings <?php echo $values["cart_id"];  ?></a>
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
                                                    <input type="hidden" name="cart_id" value="<?php echo $values["cart_id"]; ?> ">
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

$sql = "SELECT * FROM wishlist WHERE item_id = :item_id";
$stmnt = $conection->prepare($sql);
$stmnt->bindParam(":item_id", $values["item_id"]);
$stmnt->execute();
$prod_cart = $stmnt->fetch(PDO::FETCH_ASSOC);

                        ?>
                        <?php 
                        $item_price = $values["item_price"];
                        ?>
                        <?php 
                        $item_quantity = $values["item_quantity"];
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
                                <div class="mt-3 text-center">
                                    <a href="" class="btn btn-warning">Proceed To Buy</a>
                                </div>
                            </div>
                        </div> 
                        <?php endforeach; ?>
                        <br>
                    </div>
                </div>
                    
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
        <?php endif; ?>
            <!-- Wishlist Ends -->


            <!-- New Phone Begins -->
            <?php include_once "phonesection.php"; ?>
            <!-- New Phone Ends -->

    </main>
        <!-- End Main -->
        <?php include_once "scripts.php"; ?>

        <!-- Include footer with footer.php -->
        <?php include_once "footer.php"; ?>

        <!-- Include go up button with go_up.php -->
        <?php include_once "go_up.php"; ?>






</html>
