<?php
session_start();
require_once "dbdetails.php";
try {
    require_once "dbconnect.php";
    // $sql_product_table = "CREATE TABLE product (
    //     item_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //     item_brand VARCHAR(200) NOT NULL,
    //     item_name VARCHAR(200) NOT NULL,
    //     item_price DOUBLE(10,2) NOT NULL,
    //     item_image VARCHAR(200) NOT NULL,
    //     item_regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // )";
    // $conection->exec($sql_product_table);
    // $sql_cart_table = "CREATE TABLE cart(
    //     cart_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    //     user_id INT(11) NOT NULL,
    //     item_id INT(11) NOT NULL
    // )";
    // $conection->exec($sql_cart_table);
    // $sql_user_table = "CREATE TABLE user(
    //     user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    //     firstname VARCHAR(200) NOT NULL,
    //     lastname VARCHAR(200) NOT NULL,
    //     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    // )";
    // $conection->exec($sql_user_table);
    // $sql_wishlist_table = "CREATE TABLE wishlist(
    //     cart_id INT(11) NOT NULL,
    //     user_id INT(11) NOT NULL,
    //     item_id INT(11) NOT NULL
    // )";
    // $conection->exec($sql_wishlist_table);
    // echo "Database created successfully";
    
    // Fetch Data from the product table
    $search = $_GET["search"] ?? null;
    if ($search) {
        $sql = "SELECT * FROM product WHERE item_name LIKE :item_name";
        $statement = $conection->prepare($sql);
        $statement->bindValue(":item_name", "%$search%");
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC); 
        if (empty($products)) {
            $Empty = "No <b>$search</b> found";
        }
    } else {
        $sql = "SELECT * FROM product";
        $statement = $conection->prepare($sql);
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

} catch (PDOException $e) {
    echo $e->getMessage();  
}
$connection = null;
?>
<style>
    .contain {
    width: 50%;
    margin: auto;
}
</style>
<?php include_once "htmlscripts.php";?>
        <!-- Start Header from header.php -->
        <?php include_once "header.php"; ?>
         <!-- End Header -->
        <!-- Start navbar from navbar.php -->
        <?php include_once "navbar.php"; ?>
        <!-- End Navbar -->

        <section class="my-1 py-5 px-5 order-section">
        <div class="contain">
            <form action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search" style="font-style: italic;">
                    <button class="btn btn-warning" type="submit">Search</button>
                </div>
            </form>
        <div class="list-group">
        <?php if(!empty($products)){ ?>
            <?php foreach($products as $product): ?>
    <a href="productpage.php?item_id=<?php echo $product["item_id"]; ?>" class="list-group-item list-group-item-action py-3" aria-current="true">
    <div class="row g-4">
        <div class="col-md-3">
            <img src="<?php echo $product["item_image"]; ?>" alt="" class="img-fluid img-thumbnail" style="width: 100%; margin:auto;">
        </div>
        <div class="col-md-9">
        <div class="d-flex gap-2 w-100 justify-content-between">
      <div>
        <h6 class="mb-0 fs-4"><?php echo $product["item_name"]; ?></h6>
        <p class="mb-0 opacity-75"><?php echo $product["item_brand"]; ?></p>
        
      </div>
      <small class="opacity-50 text-nowrap"><?php echo $product["item_regdate"]; ?></small>
    </div>
        </div>
    </div>
        </a>
<?php endforeach; ?>
        <?php } else { ?>
            <div class="text-center">
            <?php echo $Empty; ?>
            </div>
        <?php } ?>
        </div>
        </div>
        </section>

        <?php include_once "scripts.php" ?>
        <footer>
        <?php include_once "footer.php" ?>
        <?php include_once "go_up.php" ?>
        </footer>