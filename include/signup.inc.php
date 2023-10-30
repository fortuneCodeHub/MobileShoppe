<?php 
session_start();
require_once "../dbdetails.php";
try {
    require_once "../dbconnect.php";
    require_once "function.req.php";
    $firstname=$others=$username=$email=$password=$rptpassword= "";
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Validate firstname field
        if(!$_POST["firstname"]) {
            $errors[] = "firstnameNotTaken";
        } else {
            $firstname = test_input($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z' ]*$/", $firstname)) {
                $errors[] = "invalidFirstname";
            }
        }

        // Validate Other names field 
        if(!$_POST["others"]) {
            $errors[] = "OtherNamesNotTaken";
        } else {
            $others = test_input($_POST["others"]);
            if (!preg_match("/^[a-zA-Z' ]*$/", $others)) {
                $errors[] = "invalidOtherNames";
            }
        }

        // Validate username field
        if(!$_POST["username"]) {
            $errors[] = "usernameNotTaken";
        } else {
            $username = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z' ]*$/", $username)) {
                $errors[] = "invalidUsername";
            }
        }

        // Validate Email Fields 
        if (!$_POST["email"]) {
            $errors[] = "EmailNotTaken";
        } else {
            $email = test_input($_POST["email"]);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "invalidEmail";
            }
        }

        // Validate Password
        if (!$_POST["password"]) {
            $errors[] = "PasswordNotTaken";
        } else {
            $password = test_input($_POST["password"]);
        }

        // Validate Password repeat
        $rptpassword = $_POST["rptpassword"];

        if (empty($errors)) {
            if (isset($_POST["signup"])) {
                if ($password  !== $rptpassword) {
                    $errors[] = "PasswordDontMatch";
                } else {
                    if ($password) {
                        $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
                    }
                }
                if ($username && $email) {
                    $sql = "SELECT * FROM cus_user";
                    $statement = $conection->prepare($sql);
                    $statement->execute();
                    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $user) {
                        if ($user["username"] == $username) {
                            $errors[] = "UsernameMatch";
                        }
                        if ($user["email"] == $email) {
                            $errors[] = "EmailMatch";
                        } 
                    }
                }
                if (!empty($errors)) {
                    $_SESSION["errors"] = $errors;
                    $_SESSION["posts"] = $_POST;
                    header("Location:../signup.php");
                } else {
    
                    $sql = "INSERT INTO cus_user(firstname, others, username, email, password)
                    VALUES(:firstname, :others, :username, :email, :password)";
                    $statement = $conection->prepare($sql);
                    $statement->bindParam(":firstname", $firstname);
                    $statement->bindParam(":others", $others);
                    $statement->bindParam(":username", $username);
                    $statement->bindParam(":email", $email);
                    $statement->bindParam(":password", $hashedpwd);
                    $statement->execute();
                    
                    header("Location:../signup.php?UserCreatedSuccessfully");
                }
            }
        } else {
            $_SESSION["posts"] = $_POST;
            if (!isset($_SESSION["errors"])) {
                $_SESSION["errors"] = $errors;
                header("Location:../signup.php");
            } else {
                unset($_SESSION["errors"]);
                $_SESSION["errors"] = $errors;
                header("Location:../signup.php");
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
