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

?>
<?php
$item_id = "";
$id = "";

require_once "include/function.req.php";

?>
<?php include_once "htmlscripts.php"; ?>
<body class="bg-light">
<section class="form-input" style="margin-bottom:200px;">
    <div class="log-container">
    <div class="text-center">
    <a href="index.php" class="font-size-25" style="text-decoration: none;color:black;">
        Mobile Shopee
    </a>
    </div>
    <!-- Error Handlers -->
    <?php 
    if (isset($_SESSION["errors"])) {
        if (!empty($_SESSION["errors"])) {
            $_GET["errors"] = $_SESSION["errors"];
            unset($_SESSION["errors"]);
        }
    }
    ?>
    <?php if(isset($_GET["errors"])):?>
        <?php if(!empty($_GET["errors"])): ?>
            <div class="text-center alert alert-danger">
                <?php 
                    $errors = $_GET["errors"];
                    foreach ($errors as $error) {
                        switch ($error) {
                            case 'firstnameNotTaken':
                                echo "Firstname required <br>";
                                break;
                            case 'invalidFirstname':
                                echo "Invalid Firstname <br>";
                                break;
                            case "OtherNamesNotTaken": 
                                echo "Other Names Field is Required <br>";
                                break;
                            case 'invalidOtherNames':
                                echo "invalid Other Names <br>";
                                break;
                            case 'usernameNotTaken':
                                echo "Username Field is Required <br>";
                                break;
                            case 'invalidUsername':
                                echo "Invalid Username <br>";
                                break;
                            case 'EmailNotTaken':
                                echo "Email Field is Required <br>";
                                break;
                            case 'invalidEmail':
                                echo "Invalid Email <br>";
                                break;
                            case 'PasswordNotTaken':
                                echo "Password Field is Required <br>";
                                break;
                            case 'PasswordDontMatch':
                                echo "Password Dont Match <br>";
                                break;
                            case 'UsernameMatch':
                                echo "Username has already been used <br>";
                                break;
                            case 'EmailMatch':
                                echo "Email has already been used <br>";
                                break;
                            default:
                                echo "The errors are empty <br>";
                                break;
                        }   
                    }
                ?>
            </div>
        <?php endif;?>
    <?php endif;?>
    <form action="include/signup.inc2.php" method="POST" enctype="multipart/form-data">
    <?php 
        if (isset($_SESSION["posts"])) {
            $_POST = $_SESSION["posts"];
            unset($_SESSION["posts"]);
        }
    ?>
    <div class="form-floating">
        <input type="text" name="firstname" id="floating-firstname" value="<?=old_value("firstname")?>" class="form-control" placeholder="Firstname">
        <label for="floating-firstname">Firstname</label>
    </div>
    <div class="form-floating">
        <input type="text" name="others" id="floating-others" value="<?=old_value("others")?>" class="form-control" placeholder="Others...">
        <label for="floating-others">Others...</label>
    </div>
    <div class="form-floating">
        <input type="text" name="username" value="<?=old_value("username")?>" id="floating-username" class="form-control" placeholder="Username">
        <label for="floating-username">Username</label>
    </div>
    <div class="form-floating">
        <input type="email" name="email" value="<?=old_value("email")?>" id="floating-input" class="form-control" placeholder="Email Address">
        <label for="floating-input">Email Address</label>
    </div>
    <div class="form-floating">
        <input type="password" name="password" value="<?=old_value("password")?>" id="floating-password" class="form-control" placeholder="Password">
        <label for="floating-password">Password</label>
    </div>
    <div class="form-floating">
        <input type="password" name="rptpassword" value="<?=old_value("rptpassword")?>" id="floating-rptpassword" class="form-control" placeholder="Repeat Password">
        <label for="floating-rptpassword">Repeat Password</label>
    </div>
    <div class="m-2 text-center">
    <label>
        <input type="checkbox" value="remember-me">  Remember me
    </label>
    </div>
    <div>
        <button type="submit" class="btn btn-warning font-size-20" name="signup" style="width:100%;">Signup</button>
    </div>
</form>
<div class="text-center text-muted">Already Have an Account ? <a href="login.php" style="text-decoration: none;">Login</a></div>

    </div>
    <div class="text-center mt-2">
        <p class="text-muted">&copy; 2019 - <?php echo date("Y"); ?></p>
    </div>
</section>
</body>

<?php include_once "scripts.php"; ?>