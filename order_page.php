<?php 
session_start(); 
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
  header("Location:login.php?LoginAgain");
  exit;
}
?>
<?php 
$protect= $_GET["id"] ?? null;
if (!isset($protect)) {
  $protect = null;
  header("Location:index.php");
  exit;
}
include_once "dbdetails.php";
try {
    include_once "dbconnect.php";
    $sql = "SELECT * FROM billing_details WHERE b_id = :b_id";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":b_id", $_GET["b_id"]);
    $statement->execute();
    $billing_detail = $statement->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM order_table WHERE order_id = :order_id";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":order_id", $_GET["order_id"]);
    $statement->execute();
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);


    $total_amount = array();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<?php include_once "bce_header.php"; ?>
<div class="container-fluid">
        <div class="row"> 
        <?php include_once "bce_navlink.php"; ?>
        <main  class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <section class="my-5 py-5 px-5">
            <div class="text-center fs-2 py-3 fw-bold">
                Order for <?php echo $billing_detail["username"]. " On " . $billing_detail["reg_date"]; ?>
                <br>
                <small>Customer's Details - <?php echo $billing_detail["order_id"] ?></small>
            </div>
            <p><label for="" class="fs-4">Firstname:</label><?php echo "    ". $billing_detail["firstname"] ?>
            </p>
            <p><label for="" class="fs-4">Lastname:</label><?php echo "    ". $billing_detail["lastname"] ?></p>
            <p><label for="" class="fs-4">Username:</label><?php echo "    ".$billing_detail["username"] ?></p>
            <p><label for="" class="fs-4">Email:</label><?php echo "   ".$billing_detail["email"] ?></p>
            <p><label for="" class="fs-4">Address:</label>
                <?php echo "   ".$billing_detail["address"] ?></p>
            <p> <label class="fs-4">Address 2:<small class="text-muted">optional</small>: </label>
                <?php $address2 = $billing_detail["address2"];
            if ($address2) {
                echo "    ".$address2;
            } else {
                echo "     NIL";
            } ?></p>
            <p><label for="" class="fs-4">Country:</label><?php echo "    ". $billing_detail["country"] ?></p>
            <p><label for="" class="fs-4">State:</label><?php echo "     ". $billing_detail["state"] ?></p>
            <p><label for="" class="fs-4">Zip:</label><?php echo "       ". $billing_detail["zip"] ?></p>
            <p><label for="" class="fs-4">Same Address:</label><?php echo "    ". $billing_detail["same_address"]; ?></p>
            <p><label for="" class="fs-4">Save information</label><?php echo ":     ". $billing_detail["save_info"]; ?></p>
        </section>

        <section class="py-5 px-3">
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
                        <?php $total_amount[] = $order["total_price"] ?>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <div class="text-end py-4 px-2">
                <h4> <span class="text-white p-2 me-2" style="background-color: rgb(80, 4, 80); border-radius:5px;">Total</span>
                <span>
                <?php 
                $sum = 0;
                if (!empty($total_amount)) {
                    foreach ($total_amount as $total_amounts) {
                        $sum += $total_amounts;
                    }
                    echo $sum;
                } else {
                    $total_amount = null;
                }
                ?>
                </span></h4>
            </div>
        </section>
        </main>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>
    </body>
</html>