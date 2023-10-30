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
    $sql = "SELECT * FROM cus_user ORDER BY reg_date DESC";
    $statement = $conection->prepare($sql);
    $statement->execute();
    $cus_user = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                Customers List
            </div>
            <table class="table table-striped table-hover">
              <tr>
                <th>Cus_Id</th>
                <th>Firstname</th>
                <th>Others</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
              <?php foreach($cus_user as $cus_users): ?>
                <tr>
                <td><?php echo $cus_users["cus_user_id"]; ?></td>
                <td><?php echo $cus_users["firstname"] ?></td>
                <td><?php echo $cus_users["others"] ?></td>
                <td><?php echo $cus_users["username"] ?></td>
                <td><?php echo $cus_users["email"] ?></td>
                <td>
                  <div class="d-flex align-items-center justify-content-between">
                    <form action="delcus_user.php?cus_user_id=<?php echo $cus_users["cus_user_id"]; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="cus_user_id" value="<?php echo $cus_users["cus_user_id"]; ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                    <a href="cus_orders.php?id=<?php echo uniqid("",true); ?>&cus_user_id=<?php echo $cus_users["cus_user_id"]; ?>" class="btn text-white" style="background-color: rgb(80, 4, 80); border-radius:5px;">See More</a>
                  </div>
                </td>
              </tr>
              <?php endforeach;?>
            </table>
        </section>
        </main>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>
    </body>
</html>