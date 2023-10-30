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
                    $sql = "SELECT * FROM user";
                    $statement = $conection->prepare($sql);
                    $statement->execute();
                    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $key => $user) {
                        if ($user["username"] == $uid || $user["email"] == $uid) {
                            if (!empty($password)) {
                                $pwdhashed = $user["password"];
                                $checkpwd = password_verify($password, $pwdhashed);
                                if ($checkpwd) {
                                    session_start();
                                    $_SESSION["UserId"] = $user["user_id"];
                                    $_SESSION["Username"] = $user["username"];
                                    header("Location:../bce_index.php?Login=Successful");
                                    unset($_SESSION["posts"]);
                                    exit;
                                } else {
                                    header("Location:../login.php?error=IncorrectLogin");
                                    exit;
                                }
                            } else {
                                header("Location:../login.php?error=EmptyPassword");
                                exit;
                            }
                        }
                    }
                    header("Location:../login.php?error=InvalidItem");
                    exit;
                } else {
                    header("Location:../login.php?error=EmptyUsername");
                    exit;
                }

            } else {
                header("Location:../login.php?error=BothfieldsEmpty");
                exit;
            }
        }
        
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}