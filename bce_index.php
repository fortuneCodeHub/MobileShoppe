<?php 
session_start(); 
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
  header("Location:login.php?LoginAgain");
  exit;
}
?>
<?php 
$protect= $_GET["Login"] ?? null;
if (!isset($protect)) {
  $protect = null;
  header("Location:index.php");
  exit;
}
include_once "dbdetails.php";
try {
    include_once "dbconnect.php";
    $sql = "SELECT * FROM billing_details  ORDER BY reg_date DESC";
    $statement = $conection->prepare($sql);
    $statement->execute();
    $billing_details = $statement->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<?php 
$b_array = array();
foreach ($billing_details as $values) {
    $b_array_item = array(
        'firstname' => $values["firstname"], 
        'lastname' => $values["lastname"], 
        'email' => $values["email"], 
        'address' => $values["address"], 
        'reg_date' => $values["reg_date"],
        'b_id' => $values["b_id"], 
        'order_id' => $values["order_id"] 
    );
    $b_array[] = $b_array_item;
    $count = count($b_array);
    if ($count > 10) {
        array_pop($b_array);
    }
}

?>
<?php include_once "bce_header.php"; ?>
<style>
    .order-section {
    overflow: scroll;
    height: 700px;
}
</style>
<div class="container-fluid">
        <div class="row"> 
        <?php include_once "bce_navlink.php"; ?>
        <main  class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
        <section>
        <div class="row g-4">
                        <div class="col-xl-3 col-md-6 col"> 
                            <a href="create_pro.php?id=<?php echo uniqid("", true); ?>" style="text-decoration:none;">
                            <div class="d-flex shadow bg-primary text-white align-items-center justify-content-between px-1 py-5 create-link" style="height: 200px;">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="" class="img-fluid img-thumbnail create-link-img" >
                            </div>
                            <div class="create-link-div2 px-2">
                            <p class="fs-3">Create a New Product</p>
                            </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <a href="product_table.php?id=table" style="text-decoration: none;">
                        <div class="d-flex shadow bg-success text-white align-items-center justify-content-between px-1 py-5 create-link" style="height: 200px;">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/table.svg" alt="" class="img-fluid img-thumbnail create-link-img" style="width: 100%;">
                            </div>
                            <div class="px-2 create-link-div2">
                            <p class="fs-3">Check Products Table</p>
                            </div>
                            </div>
                        </a>
                        </div>
                        <div class="col-xl-3 col-md-6"> 
                            <a href="orders.php?id=<?php echo uniqid("",true); ?>" style="text-decoration:none;">
                            <div class="d-flex shadow bg-warning text-white align-items-center justify-content-between px-1 py-5 create-link" style="height: 200px;">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="" class="img-fluid img-thumbnail create-link-img" >
                            </div>
                            <div class="create-link-div2 px-2">
                            <p class="fs-3">Check Orders</p>
                            </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6"> 
                            <a href="customers.php?id=<?php echo uniqid("",true); ?>" style="text-decoration:none;">
                            <div class="d-flex shadow bg-danger text-white align-items-center justify-content-between px-1 py-5 create-link" style="height: 200px;">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="" class="img-fluid img-thumbnail create-link-img" >
                            </div>
                            <div class="create-link-div2 px-2">
                            <p class="fs-3">Check Customers</p>
                            </div>
                            </div>
                            </a>
                        </div>
        </div>
        </section>
        <section class="text-end m-2 py-3">
            <a href="orders.php?id=<?php echo uniqid("",true); ?>" class="text-center btn p-2 text-white" style="background-color: rgb(80, 4, 80); border-radius:5px;">See More Orders</a>
        </section>

        <section class="my-1 py-5 px-5 order-section">
        <?php foreach($b_array as $keys => $values): ?>
    <div class="list-group-item list-group-item-action py-3" aria-current="true">
    <div class="d-flex gap-2 w-100 justify-content-between">
      <div>
        <h6 class="mb-0 fs-4"><?php echo $values["firstname"]. " " .$values["lastname"]; ?></h6>
        <p class="mb-0 opacity-75"><?php echo $values["email"]; ?></p>
        <p class="mb-0 opacity-75">Deliver To:<?php echo $values["address"]; ?></p>
        
      </div>
      <small class="opacity-50 text-nowrap"><?php echo $values["reg_date"]; ?></small>
    </div>
    <div class="py-2 text-end">
        <a href="order_page.php?id=<?php echo uniqid("", true); ?>&b_id=<?php echo $values["b_id"]; ?>&order_id=<?php echo $values["order_id"]; ?>" class="btn p-2 text-white" style="background-color: rgb(80, 4, 80); border-radius:5px;">See More</a>
    </div>
</div>
<?php endforeach; ?>
        </section>
        </main>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>
    </body>
</html>