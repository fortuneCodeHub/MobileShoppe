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
$cus_user_id = $_GET["cus_user_id"];
include_once "dbdetails.php";
try {
    include_once "dbconnect.php";
    $sql = "SELECT * FROM order_table WHERE cus_user_id = :cus_user_id ORDER BY reg_date DESC";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":cus_user_id", $cus_user_id);
    $statement->execute();
    $cus_user_order = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                Customer's Order <span class="fs-6 text-muted">List Throughout from </span>
            </div>
            
            <table class="table table-striped table-hover">
              <tr>
                <th>#</th>
                <th>Order_Id</th>
                <th>Cus_user_id</th>
                <th>Item name</th>
                <th>Item Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Reg Date</th>
              </tr>
              <?php foreach($cus_user_order as $cus_users): ?>
                <tr>
                <td><?php echo $cus_users["order_arr"]; ?></td>
                <td><?php echo $cus_users["order_id"] ?></td>
                <td><?php echo $cus_users["cus_user_id"] ?></td>
                <td><?php echo $cus_users["item_name"] ?></td>
                <td><?php echo $cus_users["item_quantity"] ?></td>
                <td><?php echo $cus_users["unit_price"] ?></td>
                <td><?php echo $cus_users["total_price"] ?></td>
                <td><?php echo $cus_users["reg_date"] ?></td>
              </tr>
              <?php endforeach;?>
            </table>

        </section>
        </main>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>
    </body>
</html>