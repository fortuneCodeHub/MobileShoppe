<?php
session_start();
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
    header("Location:login.php?LoginAgain");
    exit;
  }
include_once "dbdetails.php";
try {
    include_once "dbconnect.php";
    if(!isset($_GET["id"])) {
        $_GET["id"] = null;
        header("Location:index.php");
        exit;
    }
    $sql = "SELECT  * FROM product";
    $statement = $conection->prepare($sql);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo $e->getMessage();
}
$conection = null;

$uniqId = uniqid(" ",true);

?>
<?php include_once "bce_header.php"; ?>
<div class="container-fluid">
    <div class="row" style="padding-bottom:100px;">
        <?php include_once "bce_navlink.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="py-5 container" style="padding-top:40px;">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Regdate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $i => $product): ?>
                    <tr>
                        <td><?php $sum = 1;
                        $sum += $i;
                        echo $sum;?></td>
                        <td><img src="<?php echo $product["item_image"]; ?>" alt="" width="100px" class="img-fluid img-thumbnail"></td>
                        <td><?php echo $product["item_name"]; ?></td>
                        <td><?php echo $product["item_brand"]; ?></td>
                        <td><?php echo $product["item_price"]; ?></td>
                        <td><?php echo $product["item_description"]; ?></td>
                        <td><?php echo $product["item_regdate"]; ?></td>
                        <td>
                            <div class="d-flex justify-content-between">
                            <a href="update_pro.php?Item_id=<?php echo $product["item_id"]; ?>" class="btn btn-outline-primary me-2">Edit</a>
                            <form action="delete_pro.php?Item_id=<?php echo $product["item_id"]; ?>" method="POST">
                                <input type="hidden" name="item_id" value="<?php echo $product["item_id"]; ?>">
                            <button class="btn btn-outline-danger" name="delete" >Delete</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </main>
    </div>
</div>
<?php include_once "scripts.php"; ?>
    </body>
    <?php include_once "footer.php"; ?>
    <?php include_once "go_up.php"; ?>
</html>