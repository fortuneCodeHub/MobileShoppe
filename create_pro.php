<?php
session_start();
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
    header("Location:login.php?LoginAgain");
    exit;
  }
require_once "dbdetails.php"; 
try {
    if(!isset($_GET["id"])) {
        $_GET["id"] = null;
        header("Location:index.php");
        exit;
    }
    require_once "dbconnect.php";
    require_once "include/function.req.php";
    $item_name=$item_brand=$item_description=$item_price=$item_discount=$old_price="";
    $item_nameErr=$item_brandErr=$item_priceErr="";
    $error = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Image Details
        $targetDir = "Upload_Img/";
        $file = $_FILES["item_image"];
        $fileName = $_FILES["item_image"]["name"];
        $fileTmpname = $_FILES["item_image"]["tmp_name"];

        // Validate Name field
        if (!$_POST["item_name"]) {
            $item_nameErr = "The name of the product is required<br>";
            $error[] = $item_nameErr;
        } else {
            $item_name = test_input($_POST["item_name"]);
        }

        // Validate Brand field
        if (!$_POST["item_brand"]) {
            $item_brandErr = "The brand of the product is required<br>";
            $error[] = $item_brandErr;
        } else {
            $item_brand = test_input($_POST["item_brand"]);
        }

        // Validate Description
        if ($_POST["item_description"]) {
            $item_description = test_input($_POST["item_description"]);
        }

        // Validate Discount
        if ($_POST["item_discount"]) {
            $item_discount = test_input($_POST["item_discount"]);
        }

        // Validate Price field
        if (!$_POST["item_price"]) {
            $item_priceErr = "The price of the product is required<br>";
            $error[] = $item_priceErr;
        } else {
            $item_price = test_input($_POST["item_price"]);
        }
        if (isset($_POST["submit"])) {
            if (empty($error)) {
                $target_file = "";
                if ($file && $fileTmpname) {
                    $fileNewname = "IMG.".uniqid("",true).$fileName;
                    $target_file = $targetDir.$fileNewname;
                    move_uploaded_file($fileTmpname, $target_file);
                }

                $old_price = $item_price;

                if (!empty($item_discount) && !empty($item_price)) {
                    $discount = $item_discount/100 * $item_price;
                    $item_price = $item_price - $discount;
                }
                $sql = "INSERT INTO product(item_brand, item_name, item_price, item_description, item_image, item_discount, old_price)
                VALUES(:item_brand, :item_name, :item_price, :item_description, :item_image, :item_discount, :old_price)";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":item_brand",$item_brand);
                $statement->bindParam(":item_name", $item_name);
                $statement->bindParam(":item_price", $item_price);
                $statement->bindParam(":item_description", $item_description);
                $statement->bindParam(":item_image", $target_file);
                $statement->bindParam(":item_discount", $item_discount);
                $statement->bindParam(":old_price", $old_price);
                $statement->execute();
                header("Location:bce_product.php?id=product");
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<?php include_once "bce_header.php"; ?>
<div class="container-fluid">
            <div class="row">
        <?php include_once "bce_navlink.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="padding-bottom: 100px;">
            <div class="container py-5">
                <div class="text-center">
                <h3 class="fw-bold">Create Product </h3>
                </div>
            
                <?php if(!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php 
                    foreach ($error as $errors) {
                        echo $errors;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <label for="item_image" class="fs-4 fw-bold mb-2">Product Image</label>
            <br>
            <input type="file" id="item_image" name="item_image">
        </div>
        <div class="form-group">
            <label for="item_name" class="fs-4 fw-bold mb-2">Product Name</label>
            <input type="text" class="form-control input-style" id="item_name" name="item_name" placeholder="Name..." value="<?php echo $item_name; ?>">
        </div>
        <div class="form-group">
            <label for="item_brand" class="fs-4 fw-bold mb-2">Product Brand</label>
            <input type="text" class="form-control input-style" id="item_brand" name="item_brand" placeholder="Brand..." value="<?php echo $item_brand; ?>">
        </div>
        <div class="form-group">
            <label for="item_description" class="fs-4 fw-bold mb-2">Product Description</label>
            <textarea name="item_description" class="form-control" placeholder="Description..."><?php echo $item_description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="item_price" class="fs-4 fw-bold mb-2">Product Price</label>
            <input type="number" class="form-control input-style" id="item_price" name="item_price" placeholder="Price" value="<?php echo $item_price ?>">
        </div>
        <div class="form-group">
            <label for="item_discount" class="fs-4 fw-bold mb-2">Discount</label><small>(optional)</small>
            <input type="number" class="form-control input-style" id="item_discount" name="item_discount" placeholder="discount" value="<?php echo $item_discount ?>">
        </div>
        <div class="my-3 text-center input-style">
            <button class="btn btn-success" type="submit" name="submit" style="width:100%;">Post</button>
        </div>
    </form>
            </div>
            </main>
        </div>
    </div>
        <?php include_once "scripts.php"; ?>
        
    </body>
    <?php include_once "footer.php"; ?>
    <?php include_once "go_up.php"; ?>
</html>
