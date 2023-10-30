<?php 
session_start();

require_once "dbdetails.php";
try {
    require_once "dbconnect.php";


    $item_id = $_GET["item_id"]; 
    if(!$item_id) {
        $item_id = null;
        header("Location:index.php");
        exit;
    }
        $sql = "SELECT * FROM product WHERE item_id = :item_id";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":item_id", $item_id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

    $cart_id = $_GET["cart_id"];    
    $sql = "SELECT * FROM cart WHERE cart_id = :cart_id";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":cart_id", $cart_id);
    $statement->execute();
    $product_cart = $statement->fetch(PDO::FETCH_ASSOC);
    

    
    $item_quantity = $product_cart["item_quantity"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $item_quantity = $_POST["hidden_item_quantity"];
        if (isset($_POST["add_to_cart"])) {
            $sql = "UPDATE cart SET item_quantity = :item_quantity WHERE cart_id = :cart_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_quantity", $item_quantity);
            $statement->bindParam(":cart_id", $cart_id);
            $statement->execute();
            // $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            // $count = count($_SESSION["shopping_cart"]);
            // ;

            // if(empty($_SESSION["shopping_cart"])) {
            //     $item_array = array(
            //         "item_id" => $_GET["item_id"],
            //         "item_price" => $_POST["hidden_item_price"],
            //         "item_image" => $_POST["hidden_item_image"],
            //         "item_quantity" => $_POST["hidden_item_quantity"],
            //         "item_name" => $_POST["hidden_item_name"],
            //         "item_regdate" => $_POST["hidden_item_regdate"],
            //         "item_brand" => $_POST["hidden_item_brand"],
            //         "cart_id" => $cart_id
            //     );
            //     $_SESSION["shopping_cart"][0] = $item_array;
            // } else {
            //     $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            //     if (!in_array($item_id, $item_array_id)) {
            //         $count = count($_SESSION["shopping_cart"]);
            //         $item_array = array(
            //             "item_id" => $_GET["item_id"],
            //             "item_price" => $_POST["hidden_item_price"],
            //             "item_image" => $_POST["hidden_item_image"],
            //             "item_quantity" => $_POST["hidden_item_quantity"],
            //             "item_name" => $_POST["hidden_item_name"],
            //             "item_regdate" => $_POST["hidden_item_regdate"],
            //             "item_brand" => $_POST["hidden_item_brand"],
            //             "cart_id" => $cart_id
            //         );
            //         $_SESSION["shopping_cart"][$count] = $item_array;
            //     } else {
            //         echo "Item Already Added";
            //         header("Location:productpage.php");
            //     }
                
            // }

            header("Location:shoppingcart.php");
        }
    }

    



} catch (PDOException $e) {
    echo $e->getMessage();  
}
$connection = null;
?>
<?php include_once "htmlscripts.php"; ?>
        <!-- Start Header  from header.php -->
        <?php include_once "header.php"; ?>
        <!-- End Header -->
        <!-- Start navbar from navbar.php -->
        <?php include_once "navbar.php"; ?>
        <!-- End Navbar -->
        <!-- Start Main -->
        <main id="main">
            
            <form action="" method="POST" enctype="multipart/form-data">
            <!-- Product Details Begins -->
            <section id="product-details" class="p-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <img src="<?php $product_image1 = $product["item_image"];
                            if(!$product_image1) {
                                echo "assets/file-image.svg";
                            } else {
                                echo $product_image1;
                            } ?>" alt="" class="img-fluid product-img">
                            <div class="row py-4 g-3">
                                <!-- Add to Cart Ability -->
                                <div class="col-12">
                                    <button class="btn btn-warning text-light" type="submit" style="width: 100%;" name="add_to_cart">Update Item</button>
                                </div>
                                <!-- Add to cart Ability -->
                            </div>
                        </div>
                        <div class="col-md-6 py-5">
                            <h5 class="font-size-20"><?php if($product["item_name"]){
                                echo $product["item_name"];
                            } else {
                                echo "Unknown";
                            } ?></h5>
                            <small>by <?php echo $product["item_brand"]; ?></small>
                            <div class="d-flex">
                                <div class="text-warning font-size-14">
                                    <span><i class="bi bi-star text-warning"></i></span>
                                <span><i class="bi bi-star"></i></span>
                                <span><i class="bi bi-star"></i></span>
                                <span><i class="bi bi-star"></i></span>
                                <span><i class="bi bi-star"></i></span>
                                </div>
                                <a href="" class="px-2 font-size-14">20534 ratings | 1000+ answered questions/</a>
                            </div>
                            <hr class="m-0">
                            <!-- Product Price Begins -->
                            <?php 
                            $product_price = $product["item_price"];
                            $discount = 10 * $product_price/100;
                            $product_price += $discount;
                            $deal_price = $product_price - $discount;
                            if (!$product_price) {
                                $deal_price = null;
                                $discount = null;
                            }
                            ?>
                            <table class="my-3">
                                <thead>
                                    <tr class="font-size-14">
                                        <td class="p-1">M.R.P</td>
                                        <td class="p-1"><del>$<?php echo $product_price; ?></del></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-size-14">
                                        <td class="p-1">
                                            Deal Price
                                        </td>
                                        <td class="font-size-20 text-danger p-1">
                                            $<span><?php echo $deal_price; ?></span>
                                            <small class="text-dark">&nbsp;&nbsp; inclusive of all taxes
                                            </small>
                                        </td>
                                    </tr>
                                    <tr class="font-size-14">
                                        <td class="p-1">Discount</td>
                                        <td class="text-success font-size-18">$<?php echo $discount; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Product Price Ends -->

                            <!-- Policy -->
                            <div id="policy">
                                <div class="d-flex align-items-center justify-content-between p-4">
                                    <div class="text-center">
                                        <div class="text-center">
                                            <img src="bootstrap-icons-1.9.1/repeat.svg" alt="" class="img-fluid border rounded-pill p-2" width="50">
                                        </div>
                                        <a href="" class="font-size-12" style="text-decoration: none;">10 Days <br>Replacement</a>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-center">
                                            <img src="bootstrap-icons-1.9.1/truck.svg" alt="" class="img-fluid border rounded-pill p-2" width="50">
                                        </div>
                                        <a href="" class="font-size-12" style="text-decoration: none;">Daily Tuition <br>Delivered</a>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-center">
                                            <img src="bootstrap-icons-1.9.1/check-all.svg" alt="" class="img-fluid border rounded-pill p-2" width="50">
                                        </div>
                                        <a href="" class="font-size-12" style="text-decoration: none;">1 Year <br>Warranty</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Policy Ends -->
                            <hr>
                            <!-- Order Details Begins -->
                            <div class="d-flex flex-column text-dark" id="order-details">
                                <small>Delivery by: Mar 29 - Apr 1</small>
                                <small>Sold by <a href="#">Daily Electronics</a> 4.5 out of 5 | 18,198 daily ratings</small>
                                <small><img src="bootstrap-icons-1.9.1/geo-alt-fill.svg" alt="">&nbsp;&nbsp;Deliver to Customer -  424201</small>
                            </div>
                            <!-- Order Details Ends  -->

                            <div class="row py-3 g-4">
                                <div class="col-xxl-6 order-md-first col-12 order-last">
                                    <!-- Color -->

                                    <div class="d-sm-flex align-items-center justify-content-between py-0 py-sm-2">
                                        <h4 class="font-size-18">Color</h4>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="rounded-pill  mx-md-2" style="padding: 20px; background-color: rgb(196, 157, 86);">
                                                <button class="btn font-size-14"></button>
                                            </div>
                                            <div class="rounded-pill  mx-md-2" style="padding: 20px; background-color: rgb(53, 73, 73)">
                                                <button class="btn font-size-14"></button>
                                            </div>
                                            <div class="rounded-pill  mx-md-2" style="padding: 20px; background-color: rgb(70, 136, 136)">
                                                <button  class="btn font-size-14"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Color -->
                                </div>
                                <div class="col-xxl-6 col-12">
                                    <div class="qty d-flex">
                                        <h6>Qty</h6>
                                        <div class="d-flex px-4">
                                            <button class="qty-up border bg-light btn btn-light" data-id="<?php uniqid("", true); ?>" type="button">
                                                <img src="bootstrap-icons-1.9.1/chevron-up.svg" alt="">
                                            </button>
                                            <input name="hidden_item_quantity" type="text" class="qty__input border px-2 w-100 bg-light" data-id="<?php uniqid("", true); ?>" value="<?php echo $item_quantity; ?>" placeholder="1" style="display: block;">
                                            <button class="qty-down border bg-light btn btn-light" data-id="<?php uniqid("", true); ?>" type="button">
                                                <img src="bootstrap-icons-1.9.1/chevron-down.svg" alt="">
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Size Begins -->
                            <div class="size my-3">
                                <h4>Size</h4>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="border">
                                        <button class="btn btn-default p-0 font-size-14">4GB RAM</button>
                                    </div>
                                    <div class="border">
                                        <button class="btn btn-default p-0 font-size-14">6GB RAM</button>
                                    </div>
                                    <div class="border">
                                        <button class="btn btn-default p-0 font-size-14">8GB RAM</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </form>
            

        </main>
        <!-- End Main -->
        
        <!-- Script section from scripts.php -->
        <?php include_once "scripts.php"; ?>
    
    </body>    
    <!-- Footer Begins from footer.php -->
    <?php include_once "footer.php"; ?>
    <!-- Footer ends -->

    <!-- Go up begins from go_up.php -->
    <?php include_once "go_up.php"; ?>
</html>