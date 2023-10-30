<?php 
session_start();
require_once "../dbdetails.php";
try {
    require_once "../dbconnect.php";
    require_once "function.req.php";

    $uid=$password="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uid = test_input($_POST["uid"]);
        $password = test_input($_POST["password"]);

        if (isset($_SESSION["posts"])) {
            unset($_SESSION["posts"]);
            $_SESSION["posts"] = $_POST;
        } else {
            $_SESSION["posts"] = $_POST;
        }
        
        if (isset($_POST["login"])) {
            if (!empty($uid) || !empty($password)) {
                if (!empty($uid)) {
                    $sql = "SELECT * FROM cus_user";
                    $statement = $conection->prepare($sql);
                    $statement->execute();
                    $cus_users = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($cus_users as $user) {
                        if ($user["username"] == $uid || $user["email"]==$uid) {
                            if (!empty($password)) {
                                $pwdhashed = $user["password"];
                                $checkpwd = password_verify($password, $pwdhashed);
                                if ($checkpwd) {
                                    $_SESSION["cus_user_id"] = $user["cus_user_id"];
                                    $_SESSION["cus_username"] = $user["username"];
                                    header("Location:../login2.php?UserLoggedInSuccessfully");
                                    exit;
                                } else {
                                    header("Location:../login2.php?error=IncorrectLogin");
                                    exit;
                                }
                            } else {
                                header("Location:../login2.php?error=EmptyPassword");
                                exit;
                            }
                        }
                    }
                        header("Location:../login2.php?error=InvalidItem");
                        exit;
                } else {
                    header("Location:../login2.php?error=EmptyUsername");
                    exit;
                }

            } else {
                header("Location:../login2.php?error=BothFieldsEmpty");
                exit;                
            }
        }
        
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}