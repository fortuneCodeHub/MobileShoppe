<?php 
session_start(); 
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
    header("Location:login.php?LoginAgain");
    exit;
  }
?>
<?php
if(!isset($_GET["id"])) {
    $_GET["id"] = null;
    header("Location:index.php");
    exit;
}
$uniqId = uniqid("",true);
?>
<?php include_once "bce_header.php"; ?>
<div class="container-fluid">
            <div class="row">
        <?php include_once "bce_navlink.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5" style="padding-bottom: 100px;">
                <div class="row g-4">
                        <div class="col-md-6"> 
                            <a href="create_pro.php?id=<?php echo $uniqId; ?>" style="text-decoration:none;">
                            <div class="d-flex shadow bg-primary text-white align-items-center justify-content-between px-1 py-1 create-link">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="" class="img-fluid img-thumbnail create-link-img" >
                            </div>
                            <div class="create-link-div2 px-2">
                            <p class="fs-3">Create a New Product</p>
                            </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="product_table.php?id=table" style="text-decoration: none;">
                        <div class="d-flex shadow bg-success text-white align-items-center justify-content-between px-1 py-1 create-link">
                            <div class="create-link-div">
                            <img src="bootstrap-icons-1.9.1/table.svg" alt="" class="img-fluid img-thumbnail create-link-img" style="width: 100%;">
                            </div>
                            <div class="px-2 create-link-div2">
                            <p class="fs-3">Check Products Table</p>
                            </div>
                            </div>
                        </div>
                        </a>
                        </div>
            </main>
        </div>
    </div>
        <?php include_once "scripts.php"; ?>
    </body>
    <?php include_once "footer.php"; ?>
    <?php include_once "go_up.php"; ?>
</html>