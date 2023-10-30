<?php
if (empty($_GET["item_id"]) && empty($_GET["subtotal"]) && empty($_GET["sum"])) {
  header("Location:index.php");
  exit;
} 
session_start();
require_once "dbdetails.php";
try {
  require_once "dbconnect.php";
  require_once "include/function.req.php";
  

  $item_id = $_GET["item_id"] ?? null;
  $item_quantity = $_GET["item_quantity"] ?? null;
  $error = array();
  $cus_user_id = $_SESSION["cus_user_id"];
  $sql = "SELECT * FROM cus_user WHERE cus_user_id = :cus_user_id";
  $statement = $conection->prepare($sql);
  $statement->bindParam(":cus_user_id",$cus_user_id);
  $statement->execute();
  $cus_user_details = $statement->fetch(PDO::FETCH_ASSOC);

  $firstname = $cus_user_details["firstname"];
  $lastname = $cus_user_details["others"];
  $username = $cus_user_details["username"];
  $email = $cus_user_details["email"];

  $order_id=$address=$address2=$country=$state=$zip=$same_address=$save_info = "";
  $firstnameErr=$lastnameErr=$usernameErr=$emailErr=$addressErr=$countryErr=$stateErr=$zipErr=$same_addressErr=$save_infoErr= "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = [1828, 3637, 7472, 7270, 2929, 2824, 9812, 9829, 8282];
    shuffle($number);
    $order_id = $number[0].$number[4].$number[3]. $number[7];
    if (!$_POST["firstname"]) {
      $firstnameErr = "Firstname is required";
      $error[] = $firstnameErr;
    } else {
      $firstname = test_input($_POST["firstname"]);
      if (!preg_match("/^[a-zA-Z' ]*$/", $firstname)) {
        $firstnameErr = "Invalid Firstname";
        $error[] = $firstnameErr;
      }
    }

    // Validate Lastname 
    if (!$_POST["lastname"]) {
      $lastnameErr = "Lastname is required";
      $error[] = $lastnameErr;
    } else {
      $lastname = test_input($_POST["lastname"]);
      if (!preg_match("/^[a-zA-Z' ]*$/", $lastname)) {
        $lastnameErr = "Invalid Lastname";
        $error[] = $lastnameErr;
      }
    }

    // Validate username
    if (!$_POST["username"]) {
      $usernameErr = "Username is required";
      $error[] = $usernameErr;
    } else {
      $username = test_input($_POST["username"]);
    }

    // Validate Email
    if (!$_POST["email"]) {
      $emailErr = "Email is required";
      $error[] = $emailErr;
    } else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email";
        $error[] = $emailErr;
      }
    }

    
    // Validate address 
    if (!$_POST["address"]) {
      $addressErr = "Address is required";
      $error[] = $addressErr;
    } else {
      $address = test_input($_POST["address"]);
    }

    // Validate address2 
    if ($_POST["address2"]) {
      $address2 = test_input($_POST["address2"]);
    }
    // Validate country
    if (!$_POST["country"]) {
      $countryErr = "Country is required";
      $error[] = $countryErr;
    } else {
      $country = test_input($_POST["country"]);
    }
    // Validate State 
    if (!$_POST["state"]) {
      $stateErr = "State is required";
      $error[] = $stateErr;
    } else {
      $state = test_input($_POST["state"]);
    }
    // Validate zip
    if (!$_POST["zip"]) {
      $zipErr = "zip is required";
      $error[] = $zipErr;
    } else {
      $zip = test_input($_POST["zip"]);
    }
    // Validate same_address
    if (!isset($_POST["same_address"])) {
      $same_addressErr = "same_address is required";
      $error[] = $same_addressErr;
    } else {
      $same_address = test_input($_POST["same_address"]);
    }
    // Validate save_info
    if (!isset($_POST["save_info"])) {
      $save_infoErr = "save_info is required";
      $error[] = $save_infoErr;
    } else {
      $save_info = test_input($_POST["save_info"]);
    }
    if (isset($_POST["check_out"])) {
      if ($order_id && $firstname && $lastname && $username && $email && $address && $country && $state && $zip && $same_address && $save_info) {
        if (!empty($_SESSION["shopping_cart"])) {
          $sql = "INSERT INTO billing_details(order_id, cus_user_id, firstname, lastname, username, email, address, address2, country, state, zip, same_address, save_info)
          VALUES(:order_id, :cus_user_id, :firstname, :lastname, :username, :email, :address, :address2, :country, :state, :zip, :same_address, :save_info)";
          $statement = $conection->prepare($sql);
          $statement->bindParam(":order_id", $order_id);
          $statement->bindParam(":cus_user_id", $cus_user_id);
          $statement->bindParam(":firstname", $firstname);
          $statement->bindParam(":lastname", $lastname);
          $statement->bindParam(":username", $username);
          $statement->bindParam(":email", $email);
          $statement->bindParam(":address", $address);
          $statement->bindParam(":address2", $address2);
          $statement->bindParam(":country", $country);
          $statement->bindParam(":state", $state);
          $statement->bindParam(":zip", $zip);
          $statement->bindParam(":same_address", $same_address);
          $statement->bindParam(":save_info", $save_info);
          // $statement->execute();
          if ($statement->execute()) {
            $sql = "SELECT * FROM billing_details WHERE order_id = :order_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":order_id", $order_id);
            $statement->execute();
            $b_detail = $statement->fetch(PDO::FETCH_ASSOC);

            
            if ($b_detail["order_id"]) {
              $order_id = $b_detail["order_id"];
              foreach ($_SESSION["shopping_cart"] as $key => $value) {
                $sql = "INSERT INTO order_table(order_id, cus_user_id, item_name, item_quantity, unit_price, total_price)
                VALUE(:order_id, :cus_user_id, :item_name, :item_quantity, :unit_price, :total_price)";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":order_id", $order_id);
                $statement->bindParam(":cus_user_id", $cus_user_id);  
                $statement->bindParam(":item_name", $value["item_name"]);
                $statement->bindParam(":item_quantity", $value["item_quantity"]);
                $statement->bindParam(":unit_price", $value["item_price"]);
                $total = $value["item_quantity"] * $value["item_price"];
                $statement->bindParam(":total_price", $total);
                $statement->execute();
                unset($_SESSION["wishlist"]);
                unset($_SESSION["shopping_cart"]);
                header("Location:index.php?fish");
              }
            }

          }
        } else {
          $sql = "INSERT INTO billing_details(order_id, cus_user_id, firstname, lastname, username, email, address, address2, country, state, zip, same_address, save_info)
          VALUES(:order_id, :cus_user_id, :firstname, :lastname, :username, :email, :address, :address2, :country, :state, :zip, :same_address, :save_info)";
          $statement = $conection->prepare($sql);
          $statement->bindParam(":order_id", $order_id);
          $statement->bindParam(":cus_user_id", $cus_user_id);
          $statement->bindParam(":firstname", $firstname);
          $statement->bindParam(":lastname", $lastname);
          $statement->bindParam(":username", $username);
          $statement->bindParam(":email", $email);
          $statement->bindParam(":address", $address);
          $statement->bindParam(":address2", $address2);
          $statement->bindParam(":country", $country);
          $statement->bindParam(":state", $state);
          $statement->bindParam(":zip", $zip);
          $statement->bindParam(":same_address", $same_address);
          $statement->bindParam(":save_info", $save_info);
          // $statement->execute();
          if ($statement->execute()) {
            $sql = "SELECT * FROM billing_details WHERE order_id = :order_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":order_id", $order_id);
            $statement->execute();
            $b_detail = $statement->fetch(PDO::FETCH_ASSOC);

            $sql_product = "SELECT * FROM product WHERE item_id = :item_id";
            $statement = $conection->prepare($sql_product);
            $statement->bindParam(":item_id", $item_id);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);
            
            if ($b_detail["order_id"]) {
              $order_id = $b_detail["order_id"];
              
              $sql = "INSERT INTO order_table(order_id, cus_user_id, item_name, item_quantity, unit_price, total_price)
              VALUE(:order_id, :cus_user_id, :item_name, :item_quantity, :unit_price, :total_price)";
              $statement = $conection->prepare($sql);
              $statement->bindParam(":order_id", $order_id);
              $statement->bindParam(":cus_user_id", $cus_user_id);  
              $statement->bindParam(":item_name", $product["item_name"]);
              $statement->bindParam(":item_quantity", $item_quantity);
              $statement->bindParam(":unit_price", $product["item_price"]);
              $total = $item_quantity * $product["item_price"];
              $statement->bindParam(":total_price", $total);
              $statement->execute();
              header("Location:index.php?fish");
              
            }

          }
        }
        
      }
    }


  }	

} catch (PDOException $e) {
  echo $e->getMessage();
}

?>

<?php include_once "htmlscripts.php"; ?>
<style>
  .go-back {
    text-decoration: none;
    color: black;
  }
</style>
<main class="mb-5">
    <div class="checkout-container">
    <div class="py-5 text-center">
      <a href="index.php" class="go-back">&LeftArrow; Back</a>
      <h2>Checkout form</h2>
      <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
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
    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <?php if(isset($_GET["id"])){ ?>
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">
          <?php 
            if (!empty($_SESSION["shopping_cart"])) {
              foreach ($_SESSION["shopping_cart"] as $key => $value) {
                  $count = count($_SESSION["shopping_cart"]);
              }
            } else {
                $count = "";
            }
            echo $count;
          ?>
          </span>
          <?php } elseif ($_GET["item_quantity"]) {?>
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill">
            <?php 
              echo $item_quantity;
            ?>
            </span>
          <?php } ?>
        </h4>
        <ul class="list-group mb-3">
          <?php if(!isset($_GET["UserCreatedSuccessfully"])) { ?>
          <?php if(isset($_GET["item_id"])){ ?>
            <?php
            $sql = "SELECT * FROM product WHERE item_id = :item_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $_GET["item_id"]);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);  
            ?>
            <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $product["item_name"]; ?></h6>
              <?php include_once "include/function.req.php"; ?>
              <small class="text-muted"><?php echo shorten($product["item_name"], 2) ?></small>
            </div>
            <span class="text-danger">$<?php echo $product["item_price"]; ?></span>
          </li>
          <?php } elseif(isset($_GET["id"])) {?>
          <?php if(!empty($_SESSION["shopping_cart"])):  ?>
            <?php foreach($_SESSION["shopping_cart"] as $key => $values): ?>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $values["item_name"]; ?></h6>
              <?php include_once "include/function.req.php"; ?>
              <small class="text-muted"><?php echo shorten($values["item_name"], 2) ?></small>
            </div>
            <span class="text-danger">$<?php echo $values["item_price"]; ?></span>
          </li>
          <?php endforeach; ?>
          <?php endif; ?>
          <?php } ?>
          <?php } else { ?>
            <?php if(!empty($_GET["item_id"])){ ?>
            <?php
            $sql = "SELECT * FROM product WHERE item_id = :item_id";
            $statement = $conection->prepare($sql);
            $statement->bindParam(":item_id", $_GET["item_id"]);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);  
            ?>
            <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $product["item_name"]; ?></h6>
              <?php include_once "include/function.req.php"; ?>
              <small class="text-muted"><?php echo shorten($product["item_name"], 2) ?></small>
            </div>
            <span class="text-danger">$<?php echo $product["item_price"]; ?></span>
          </li>
          <?php } elseif(!empty($_GET["id"])) {?>
          <?php if(!empty($_SESSION["shopping_cart"])):  ?>
            <?php foreach($_SESSION["shopping_cart"] as $key => $values): ?>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $values["item_name"]; ?></h6>
              <?php include_once "include/function.req.php"; ?>
              <small class="text-muted"><?php echo shorten($values["item_name"], 2) ?></small>
            </div>
            <span class="text-danger">$<?php echo $values["item_price"]; ?></span>
          </li>
          <?php endforeach; ?>
          <?php endif; ?>
          <?php } ?>
          <?php } ?>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong class="text-success">$<?php
            if (!empty($_GET["sum"])) {
              echo $_GET["sum"];
            } elseif (!empty($_GET["item_id"])) {
              $sql = "SELECT * FROM product WHERE item_id = :item_id";
              $statement = $conection->prepare($sql);
              $statement->bindParam(":item_id", $_GET["item_id"]);
              $statement->execute();
              $product = $statement->fetch(PDO::FETCH_ASSOC);  
              // if (!$product["item_quantity"]) {
              //   $sql = "SELECT * FROM cart WHERE item_id = :item_id";
              //   $statement = $conection->prepare($sql);
              //   $statement->bindParam(":item_id", $_GET["item_id"]);
              //   $statement->execute();
              //   $products = $statement->fetch(PDO::FETCH_ASSOC);
              //   $total = $product["item_price"] * $products["item_quantity"];
              // } else {
                $total = $product["item_price"] * $item_quantity;
              // }
              echo $total;
            }elseif (!empty($_GET["subtotal"])) {
              echo $_GET["subtotal"];
            } elseif (empty($_GET["sum"])) {
              $_GET["sum"] = null;
            } elseif (empty($_GET["subtotal"])) {
              $_GET["subtotal"] = null;
            }
            ?></strong>
          </li>
        </ul>

        <!-- <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </form> -->
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" name="firstname" value="<?php echo $cus_user_details["firstname"]; ?>">
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lastName" name="lastname" value="<?php echo $cus_user_details["others"]; ?>">
            </div>

            <div class="col-12">
              <label for="username" class="form-label">Username</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $cus_user_details["username"]; ?>" >
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?php echo $cus_user_details["email"]; ?>" >
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" >
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2</label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" name="country">
                <option value="">Choose...</option>
                <option>United States</option>
              </select>
            </div>

            <div class="col-md-4">
              <label for="state" class="form-label">State</label>
              <select class="form-select" id="state" name="state" >
                <option value="">Choose...</option>
                <option>California</option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input type="text" class="form-control" id="zip" placeholder="" name="zip">
            </div>
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address" name="same_address" value="Shipping address is the same as my billing address">
            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info" name="save_info" value="Save this information for next time" >
            <label class="form-check-label" for="save-info">Save this information for next time</label>
          </div>

          <hr class="my-4">

          <!-- <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" required>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

          <hr class="my-4"> -->

          <button class="w-100 btn btn-primary btn-lg" type="submit" name="check_out">Continue to checkout</button>
        </form>
      </div>
    </div>
    </div>
  </main>

<?php include_once "scripts.php"; ?>
</body>
</html>