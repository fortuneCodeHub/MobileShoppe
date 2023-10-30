<?php
session_start();
if (empty($_GET)) {
    header("location:index.php");
    exit; 
}

if (isset($_GET["id"])) {
    $_SESSION["id"] = $_GET["id"];
}
if (isset($_GET["item_id"])) {
    $_SESSION["item_id"] = $_GET["item_id"];
} 
if (isset($_GET["subtotal"])) {
    $_SESSION["subtotal"] = $_GET["subtotal"];
} 
if (isset($_GET["sum"])) {
    $_SESSION["sum"] = $_GET["sum"];
} 
$item_id = "";
$id = "";
$sum = "";
$subtotal = "";
if(isset($_GET["UserLoggedInSuccessfully"])){
    $item_id = $_SESSION["item_id"];
    $id = $_SESSION["id"];
    $sum = $_SESSION["sum"];
    $subtotal = $_SESSION["subtotal"];
    echo header("Location:checkoutform.php?UserCreatedSuccessfully&item_id=$item_id&id=$id&sum=$sum&subtotal=$subtotal");
}
?>
<?php 
require_once "dbdetails.php";
try {
    require_once "dbconnect.php";
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<?php include_once "htmlscripts.php"; ?> 
<body class="bg-light">
<section class="form-input">
    <div class="log-container">
    <div class="text-center">
    <a href="index.php" class="font-size-25" style="text-decoration: none;color:black;">
        Mobile Shopee
    </a>
    </div>
    <form action="include/login.inc2.php" method="POST" enctype="multipart/form-data">
        <?php if (isset($_GET["error"])) {
            if(!empty($_GET["error"])) { ?>

            <div class="text-center alert alert-danger" data-bs-close="alert">
                <?php 
                switch ($_GET["error"]) {
                    case 'BothFieldsEmpty':
                        echo "Both fields are required please enter an information if you choose to login";
                        break;
                    case 'EmptyUsername':
                        echo "Username or Email required";
                        break;
                    case 'InvalidItem':
                        echo "The Username or Email you inputed is not correct pls try again";
                        break;
                    case 'EmptyPassword':
                        echo "Please the Password is required";
                        break;
                    case 'IncorrectLogin':
                        echo "Please your Password is incorrect";
                        break;
                    default:
                        echo "There is no error";
                        break;
                }
                ?>
            </div>

        <?php    }
        } ?>
        <?php 
            if (isset($_SESSION["posts"])) {
                $_POST = $_SESSION["posts"];
            }
        ?>
        <div class="form-floating">
            <input type="text" name="uid" id="floating-input" class="form-control" placeholder="Email Address">
            <label for="floating-input">Username/Email...</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" id="floating-password" class="form-control" placeholder="Password">
            <label for="floating-password">Password</label>
        </div>
        <div class="m-2 text-center">
        <label>
            <input type="checkbox" value="remember-me">  Remember me
        </label>
        </div>
        <div>
            <button type="submit" class="btn btn-warning font-size-20" name="login" style="width:100%;">LogIn</button>
        </div>
    </form>
     <?php if(!isset($_GET["NewLogin"])): ?>
     <div class="text-center mt-2">
         <a href="signup.php?id=<?php echo uniqid("",true); ?>" type="button" class="btn btn-success" style="width: 100%;">Sign Up</a>
     </div>
     <?php endif; ?>
    </div>
    <div class="text-center mt-2">
        <p class="text-muted">&copy; 2019 - <?php echo date("Y"); ?></p>
    </div>
</section>
</body>
<?php include_once "scripts.php"; ?>