<?php
session_start();
if (!isset($_SESSION["UserId"]) && !isset($_SESSION["Username"])) {
    header("Location:login.php?LoginAgain");
    exit;
  }
require_once "dbdetails.php"; 
try {
    $item_id = $_GET["Item_id"];
    if (!$item_id) {
        $item_id = null;
        header("Location:product_table.php?id=table");
        exit;
    }
    require_once "dbconnect.php";
    require_once "include/function.req.php";

    $sql = "SELECT * FROM   product WHERE item_id = :item_id";
    $statement = $conection->prepare($sql);
    $statement->bindParam(":item_id", $item_id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    $item_name=$product["item_name"];
    $item_brand=$product["item_brand"];
    $item_description=$product["item_description"];
    $item_price=$product["item_price"];
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

        // Validate Price field
        if (!$_POST["item_price"]) {
            $item_priceErr = "The price of the product is required<br>";
            $error[] = $item_priceErr;
        } else {
            $item_price = test_input($_POST["item_price"]);
        }
        if (isset($_POST["submit"])) {
            if (empty($error)) {
                $target_file = $product["item_image"];
                if ($file && $fileTmpname) {
                    if (file_exists($product["item_image"])) {
                        unlink($product["item_image"]);
                    }
                    $fileNewname = "IMG.".uniqid("",true).$fileName;
                    $target_file = $targetDir.$fileNewname;
                    move_uploaded_file($fileTmpname, $target_file);
                }
                $sql = "UPDATE product SET item_brand = :item_brand, item_name = :item_name, item_price = :item_price, item_description = :item_description, item_image = :item_image WHERE item_id = :item_id";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":item_brand",$item_brand);
                $statement->bindParam(":item_name", $item_name);
                $statement->bindParam(":item_price", $item_price);
                $statement->bindParam(":item_description", $item_description);
                $statement->bindParam(":item_image", $target_file);
                $statement->bindParam(":item_id", $item_id);
                $statement->execute();
                header("Location:product_table.php?id=table");
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
                <h3 class="fw-bold">Update Product : <?php echo $product["item_name"]; ?></h3>
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
            <?php if($product["item_image"]): ?> 
                <a href="<?php echo $product["item_image"] ?>" target="_blank">
                <img src="<?php echo $product["item_image"]; ?>" alt="" class="image-size2 img-thumbnail"></a>
            <?php endif ?>
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
        <div class="my-3 text-center input-style">
            <button class="btn btn-success" type="submit" name="submit" style="width:100%;">Update</button>
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
