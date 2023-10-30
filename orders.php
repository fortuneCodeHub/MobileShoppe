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
    $sql = "SELECT * FROM billing_details ORDER BY reg_date DESC";
    $statement = $conection->prepare($sql);
    $statement->execute();
    $billing_details = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                Orders
            </div>
        <div class="list-group">
  <?php foreach($billing_details as $billing_detail): ?>
    <div class="list-group-item list-group-item-action py-3" aria-current="true">
    <div class="d-flex gap-2 w-100 justify-content-between">
      <div>
        <h6 class="mb-0 fs-4"><?php echo $billing_detail["firstname"]. " " .$billing_detail["lastname"]; ?></h6>
        <p class="mb-0 opacity-75"><?php echo $billing_detail["email"]; ?></p>
        <p class="mb-0 opacity-75">Deliver To:<?php echo $billing_detail["address"]; ?></p>
        
      </div>
      <small class="opacity-50 text-nowrap"><?php echo $billing_detail["reg_date"]; ?></small>
    </div>
    <div class="py-2 text-end">
        <a href="order_page.php?id=<?php echo uniqid("", true); ?>&b_id=<?php echo $billing_detail["b_id"]; ?>&order_id=<?php echo $billing_detail["order_id"]; ?>" class="btn p-2 text-white" style="background-color: rgb(252, 115, 252) ;">See More</a>
    </div>
</div>
<br>
<?php endforeach; ?>
</div>
        </section>
        </main>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>
    </body>
</html>