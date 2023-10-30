<?php 
session_start();

if (!isset($_SESSION["UserId"])) {
    header("Location: index.php");
}

// $protect= $_GET["id"] ?? null;
// if (!isset($protect)) {
//   $protect = null;
//   header("Location:index.php");
//   exit;
// }

require_once "dbdetails.php";
require_once "shorten.php";

try {

    require_once "dbconnect.php";

    $carouselId = $_GET["carousel_id"] ?? null;
    if (isset($carouselId)) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $carousel_id = $_POST["carousel_id"];
            if (isset($_POST["delete"])) {
                $sql = "SELECT * FROM carousel_post WHERE id = :id";
                $statement = $conection->prepare($sql);
                $statement->bindParam(":id", $carousel_id);
                $statement->execute();

                $carousel_post = $statement->fetch(PDO::FETCH_ASSOC);
                if (!empty($carousel_post)) {
                    $img_delete = "";
                    if(file_exists($carousel_post["image"])) {
                        unlink($carousel_post["image"]);
                        $img_delete = 1;
                    } 
                    if (!empty($img_delete)) {
                        $sql = "DELETE FROM carousel_post WHERE id = :id";
                        $statement = $conection->prepare($sql);
                        $statement->bindParam(":id", $carouselId);
                        $statement->execute();
                        header("Location: viewcarouselpost.php?SuccessfullyDeleted");
                    }
                }
            }
        }
    } else {
        header("Location: viewcarouselpost.php");
    }
    

} catch (PDOException $e) {
    echo $e->getMessage();
}