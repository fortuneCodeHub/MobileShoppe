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
    $carousel_id = $_GET["carousel_id"] ?? null;
    if (isset($carousel_id)) {
        $sql = "SELECT * FROM carousel_post WHERE id = :id";
        $statement = $conection->prepare($sql);
        $statement->bindParam(":id", $carousel_id);
        $statement->execute();

        $carousel_post = $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: viewcarouselpost.php");
    }

   
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<?php 
    // description
    $description_array_group = explode("&or/", $carousel_post["description"]);
    $value_array = "";
    $value_group = [];
    foreach($description_array_group as $key => $value) {
        $value_array = explode("(", $value);
        $value_group[] = $value_array;
    }
    // link_name
    $link_name_array_group = explode("&or/", $carousel_post["link_name"]);
    $link_name_arr = "";
    $link_name_group = [];
    foreach($link_name_array_group as $key => $value) {
        $link_name_arr = explode("(", $value);
        $link_name_group[] = $link_name_arr;
    }
    // link_URL
    $link_URL_array_group = explode("&or/", $carousel_post["link_URL"]);
    $link_URL_arr = "";
    $link_URL_group = [];
    foreach($link_URL_array_group as $key => $value) {
        $link_URL_arr = explode("(", $value);
        $link_URL_group[] = $link_URL_arr;
    }

    $link_group = [];

    $desc_arrangement_group = explode("&&", $carousel_post["desc_arrangement"]);
    $display_content = [];
    foreach ($desc_arrangement_group as $key => $desc_arrangement_item) {
        if (!empty($value_array)) {
            foreach ($value_group as $key => $value_item_array) {
                if (is_array($value_item_array)) {
                    if ($desc_arrangement_item == $value_item_array[0]) {
                        $display_content[$desc_arrangement_item] = $value_item_array[1];
                    }
                }
            }
        }
        if (!empty($link_name_arr)) {
            foreach ($link_name_group as $key => $link_name_item_array) {
                if (is_array($link_name_item_array)) {
                    if ($desc_arrangement_item == $link_name_item_array[0]) {
                        $link_group[] = $link_name_item_array[1];
                        $display_content[$desc_arrangement_item] = $link_group;
                    }
                }
            }
        }
        if (!empty($link_URL_arr)) {
            foreach ($link_URL_group as $key => $link_URL_item_array) {
                if (is_array($link_URL_item_array)) {
                    if ($desc_arrangement_item == $link_URL_item_array[0]) {
                        $link_group[] = $link_URL_item_array[1];
                        $display_content[$desc_arrangement_item] = $link_group;
                        $link_group = null;
                    }
                }
            }
        }
    }
?>
<?php include_once "bce_header.php"; ?>

    <style>
        .body-content .main-body {
            padding: 0px 70px 0px 70px;
            padding-bottom: 1000px;
        }
        .body-content .main-body .main-body-section{
            height: 100vh;
        }
        .cta-link {
            padding:10px 20px;
            color: white;
            background-color: rgb(7, 7, 172);
            text-decoration:none;
            font-size:20px; 
            border-radius:5px; 
        }
        .cta-link:hover {
            background-color: rgb(2, 2, 255);
            color: white;
        }
        .cta-link:focus {
            background-color:rgb(194, 21, 21) ;
            color:white;
        }
        .h1-tag {
            font-weight: 800;
            color:white;
            font-size:50px;
        }
        .h2-tag {
            font-weight: bold;
            color: white;
        }
        .body-content .main-body .main-body-section {
            position:relative;
        }
        .body-content .main-body .main-body-section .main-body-item {
            height: 100%;
            overflow: hidden;
            position: relative;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .body-content .main-body .main-body-section .main-body-item::before {
            content: "";
            position: absolute;
            top:0;
            right:0;
            left:0;
            bottom:0;
            background-color: rgba(0, 0, 0, 0.497);
        }
        .body-content .main-body .main-body-section .main-body-text {
            position: absolute;
            bottom: 20%;
            left: 10%;
        }
        @media (max-width: 900px) {
            .body-content .main-body .main-body-section{
                height: 80vh;
            }
            .body-content .main-body .main-body-section .main-body-text {
                position: absolute;
                bottom: 15%;
                left: 0;
                right: 0;
            }
            .h1-tag {
                font-size: 40px;
            }
        }
    </style>

</head>
<body>

    <div class="container-fluid body-content">
        <div class="row">
            <!-- Sidebar File -->
            <?php include_once "bce_navlink.php"; ?>
            <main class="col-lg-10 col-md-9 main-body">
                <div class="p-2 my-4 bg-light">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="viewcarouselpost.php" class="btn btn-primary p-2" style="text-decoration:none;">    
                                &ShortLeftArrow;
                                Back To Table
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="text-center py-2">
                    <h5>This is how it would look like on the home page</h5>
                </div>
                <section class="bg-light main-body-section">
                    <div class="main-body-item" style="background-image: url(<?php echo $carousel_post["image"]; ?>) ;"></div>
                    <div class="main-body-text p-1 text-lg-start text-center">
                        <?php foreach ($display_content as $key => $value) : ?>
                            <?php 
                            $letters_array = str_split($key, 1);
                            $strings = [];
                            $string = "";
                            $string_name = "";
                            $count = count($letters_array);
                            if ($count >= 6) {
                                foreach ($letters_array as $keys => $values) {
                                    $strings[] = $values;
                                    $count = count($strings);
                                    if ($count >= 6 ) {
                                        break;
                                    }
                                }
                                $string = implode("",$strings);
                            }

                            ?>
                            <?php if ($string == "h1-tag") {?>
                                <div class="mt-2 mb-2 py-2">
                                    <h1 class="h1-tag"><?php echo $value; ?></h1>
                                </div>
                            <?php } elseif ($string == "h2-tag") {?>
                                <div class="mt-2 mb-2 py-2">
                                    <h2 class="h2-tag"><?php echo $value; ?></h2>
                                </div>
                            <?php } elseif ($string == "ph-tag") {?>
                                <p class="p-tag text-white lead pt-2 pb-2">
                                <?php echo nl2br($value); ?>
                                </p>
                            <?php } elseif ($string == "lk-tag") {?>
                                <span>
                                    <a href="<?php if (is_array($value)) {
                                        echo $value[1];
                                    } ?>" class="cta-link"><?php if (is_array($value)) {
                                        echo $value[0];
                                    } ?></a>
                                </span>
                            <?php } ?>
                        <?php endforeach; ?>
                    </div>
                </section>
                <div class="text-end my-4 pe-2">
                    <form method="POST" enctype="multipart/form-data" action="deletecarouselpost.php?carousel_id=<?php echo $carousel_post["id"]; ?>">
                        <input type="hidden" name="carousel_id" value="<?php echo $carousel_post["id"]; ?>">
                        <button class="btn btn-outline-danger" name="delete" type="submit">Delete</button>
                    </form>
                </div>
                
            </main>
        </div>
    </div>

    </div>
    <script src="js/bootstrap.bundle.js"></script>
    <!-- JS Link File -->
    <?php include_once "scripted.php"; ?>
</body>
</html>