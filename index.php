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
    $sql = "SELECT * FROM product";
    $statment = $conection->prepare($sql);
    $statment->execute();
    $products = $statment->fetchAll(PDO::FETCH_ASSOC); 

} catch (PDOException $e) {
    echo $e->getMessage();  
}
$connection = null;
?>
<?php include_once "htmlscripts.php";?>
        <!-- Start Header from header.php -->
        <?php include_once "header.php"; ?>
         <!-- End Header -->
        <!-- Start navbar from navbar.php -->
        <?php include_once "navbar.php"; ?>
        <!-- End Navbar -->
        <!-- Start Main -->
        <main id="main">
            <!-- Carousel begins -->
            <?php include_once "carousel1.php"; ?>     
            <!-- End Carousel -->
            <!-- Start Top Sale from topsale.php-->
            <?php include_once "topsale.php"; ?>
            <!-- End Top Sale -->

            <!-- Special Sale  from specialsale.php-->
            <?php include_once "specialsale.php"; ?> 
            <!-- End Special Sale -->

            <!-- Banner ADs Begins from bannerads.php -->
            <?php include_once "bannerads.php"; ?>
            <!-- Banner ADs Ends -->

            <!-- New PhonesSection begins  from phonesection.php-->
            <?php include_once "phonesection.php"; ?>
            <!-- New Phone section ends -->

            <!-- Latests Blogs from latestblogs.php -->
            <?php include_once "latestblogs.php"; ?> 
            <!-- Latests Blogs End -->

        </main>
        <!-- End Main -->
        
        <!-- Scripts file from  scripts.php -->
        <?php include_once "scripts.php";  ?>

        <!-- Footer Begins -->
        <?php include_once "footer.php"; ?>
        <!-- Footer Ends -->

        <!-- Go up button begins from go_up.php-->
        <?php include_once "go_up.php"; ?>
        <!-- Go up button ends -->
</html>