<?php
$sql = "SELECT * FROM order_table WHERE cus_user_id = :cus_user_id";
$statement = $conection->prepare($sql);
$statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<nav class="navbar navbar-expand-lg p-2 navbar-style navbar-dark sticky-top">
            <div class="container">
                <a href="index.php" class="navbar-brand nav-fonts font-weight-600 font-size-20">Mobile Shopee</a>
                <button class="navbar-toggler" id="navbar-toggler-icon-style" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                    <span class="navbar-toggler-icon "></span>
                </button>
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item ">
                            <a href="index.php" class="nav-link nav-fonts  font-size-18 " id="nav-link-style">
                                On Sale
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#special-sale" class="nav-link" id="nav-link-style">
                                Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="products.php?id=<?php echo uniqid("", true); ?>" class="nav-link" id="nav-link-style">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#latest-blogs" class="nav-link" id="nav-link-style">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item dropdown px-sm-2">
                            <a href="#" class="nav-link  h5 dropdown-toggle" style="color: white;" id="dropdownmenu" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <ul class="dropdown-menu navbar-style dropdown-menu-dark dropdown-menu-macos mx-0 border-0 shadow" aria-labelledby="dropdownmenu">
                                <?php if(!isset($_SESSION["cus_user_id"]) && !isset($_SESSION["cus_username"])){ ?>
                                <li><a href="login2.php?id=<?php echo uniqid("",true); ?>&NewLogin" class="dropdown-item" id="nav-link-style">Login</a></li>
                                <li><a href="signup.php?id=<?php echo uniqid("",true); ?>&NewSignup" class="dropdown-item" id="nav-link-style">Signup</a></li>
                                <?php } else { ?>
                                <li><a href="include/logout.inc2.php" class="dropdown-item" id="nav-link-style">Logout</a></li>
                                <li><a href="#" data-bs-target="#modals" data-bs-toggle="modal" type="button" class="dropdown-item" id="nav-link-style">Orders</a></li>
                                <li><a href="#" class="dropdown-divider"></a></li>
                                <li><a href="" class="dropdown-item my-1" id="nav-link-style">Profile</a></li>
                                <?php } ?>
                                
                            </ul>
                        </li>
                    </ul>
                    <form action="" class="font-size-14">
                        <a href="shoppingcart.php" class="py-2 rounded-pill bg-dark text-decoration">
                            <span class="font-size-18 px-2 text-light"><i class="bi bi-cart3"></i></span>
                            <span class="px-3 py-2 rounded-pill text-dark bg-light">
                            <?php 
                            if (!empty($_SESSION["shopping_cart"])) {
                                foreach ($_SESSION["shopping_cart"] as $key => $value) {
                                    $count = count($_SESSION["shopping_cart"]);
                                }
                            } else {
                                $count = "";
                            }
                            echo $count;
                            ?>
                            </span>
                        </a>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="modals" tabindex="-1" aria-labelledby="modallabel">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modallabel">Orders By <?php echo $_SESSION["cus_username"]; ?></h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Item Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $i => $order): ?>
                    <tr>
                        <td><?php $sum = 1;
                        $sum += $i;
                        echo $sum;?></td>
                        <td><?php echo $order["item_name"]; ?></td>
                        <td><?php echo $order["item_quantity"]; ?></td>
                        <td><?php echo $order["unit_price"]; ?></td>
                        <td><?php echo $order["total_price"]; ?></td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger p-2" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>