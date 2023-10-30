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

    $sql = "SELECT * FROM carousel_post ORDER BY create_date DESC";
    $statement = $conection->prepare($sql);
    $statement->execute();

    $carousel_posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET["SuccessfullyUpdated"])) {
        $success = "Successfully Updated";
    } else {
        $_GET["SuccessfullyUpdated"] = null;
        $success = "";
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<?php include_once "bce_header.php"; ?>
    <style>
        .body-content .main-body {
            padding: 0px 70px 0px 70px;
            padding-bottom: 1000px;
        }
        .body-content .main-body table thead tr th small {
            font-weight: 200;
            font-size: 12px;
        }
        .body-content .main-body table thead tr th {
            font-size: 13px;
            text-align: center;
        }
        .body-content .main-body table tbody tr td {
            text-align: center;
            font-size: 13px;
        }
        .body-content .main-body table tbody tr td div {
            display:flex;
        }
        .body-content .main-body table tbody tr td div .d-block {
            margin: 10px 10px;
            font-weight: 500;
        }
        .body-content .main-body table tbody tr td div form .d-block {
            margin: 10px 10px;
            font-weight: 500;
        }
    </style>

</head>
<body>

    <div class="container-fluid body-content">
        <div class="row">
            <!-- Sidebar File -->
            <?php include_once "bce_navlink.php"; ?>
            <main class="col-lg-10 col-md-9 main-body">
                <div class="p-2 my-4 sticky-top bg-light">
                    <ul class="list-inline text-center text-sm-start">
                        <li class="list-inline-item my-2 my-sm-0">
                            <a href="bce_index.php?Login=successful" class="btn btn-primary p-2">    
                                <img src="bootstrap-icons-1.9.1/speedometer.svg" alt="" class="img-fluid">
                                Back To Dashboard
                            </a>
                        </li>
                        <li class="list-inline-item my-2 my-sm-0">
                            <a href="createcarouselpost.php" class="btn btn-primary p-2">
                                <img src="bootstrap-icons-1.9.1/plus-circle.svg" alt="" class="img-fluid">
                                Create New Carousel Post
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <?php if($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success; ?>
                            <a class="btn-close" type="button" href="viewblogpost.php" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET["SuccessfullyDeleted"])){?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo "The file has been successfully deleted"; ?>
                            <a href="" class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    <?php } else {
                        $_GET["SuccessfullyDeleted"] = null;
                    } ?>
                </div>
                <div class="mb-4">
                    <div class="text-center p-2">
                        <h4 class="text-uppercase py-2">
                            View Created Carousel Post
                        </h4>
                    </div>
                </div>
                <table class="table table-striped table-hovered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($carousel_posts)) { ?>
                            <?php foreach ($carousel_posts as $i => $carousel_post) { ?>
                                <tr>
                                    <td><?php echo $i+=1; ?></td>
                                    <td>
                                        <a href="<?php echo $carousel_post["image"] ?>" target="_blank" rel="noopener noreferrer">
                                            <img src="<?php echo $carousel_post["image"]; ?>" alt="" height="50" width="50">
                                        </a>
                                    </td>
                                    <td><?php echo $carousel_post["create_date"]; ?></td>
                                    <td>
                                        <div>
                                            <form method="POST" enctype="multipart/form-data" action="deletecarouselpost.php?carousel_id=<?php echo $carousel_post["id"]; ?>">
                                                <input type="hidden" name="carousel_id" value="<?php echo $carousel_post["id"]; ?>">
                                                <button class="btn btn-outline-danger d-block" name="delete" type="submit">Delete</button>
                                            </form>
                                            <a href="updatecarouselpost.php?carousel_id=<?php echo $carousel_post["id"]; ?>" class="d-block btn btn-outline-primary">Edit</a>
                                            <a href="thecarouselpost.php?carousel_id=<?php echo $carousel_post["id"]; ?>" class="btn btn-outline-info d-block">View</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    </div>
    <?php include_once "scripts.php"; ?>
</body>
</html>