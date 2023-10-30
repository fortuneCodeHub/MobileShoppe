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


try {
  require_once "dbconnect.php";
  require_once "test_function.php";

  if (isset($_POST["name"])) {
    if (!empty($_POST["name"])) {
      if (isset($_SESSION["carousel_post"])) {
        $sum = [];
        $sum_end = "";
        $num = "";
        if (!empty($_SESSION["carousel_post"])) {
          foreach ($_SESSION["carousel_post"] as $key => $value) {
            $sum[] = $key;
          }
          $sum_end = end($sum);
          $num = $sum_end + 1;
          if (!in_array($_POST["name"],$_SESSION["carousel_post"])) {
            $_SESSION["carousel_post"][$num] = $_POST["name"];
          } else {
            $_SESSION["carousel_post"][$num] = $_POST["name"].$num;
          }
        } else {
          $count = count($_SESSION["carousel_post"]);
          $_SESSION["carousel_post"][$count] = $_POST["name"];
        }
      } else {
        $_SESSION["carousel_post"][0] = $_POST["name"];
      }
        
    } else {
      echo '$_get is empty';
    }
  } else {
    $_GET["name"] = null;
  }

  if (isset($_GET["delete_id"])) {
    if (isset($_SESSION["carousel_post"])) {
      if (!empty($_SESSION["carousel_post"])) {
        if (!empty($_GET["delete_id"])) {
          unset($_SESSION["carousel_post"][$_GET["delete_id"]]);
          header("Location: createcarouselpost.php?fromdashbrd");
        } elseif ($_GET["delete_id"] == 0) {
          $count = count($_SESSION["carousel_post"]);
          if ($count == 1) {
            unset($_SESSION["carousel_post"][0]);
            header("Location: createcarouselpost.php?fromdashbrd");
          }
        }
      }
    }
    
  } else {
    $_GET["delete_id"] = null;
  }

  $desc_arrangement_array = [];
  $desc_wrd = "";

// description, link_name, link_URL, desc_arrangement	

  $description=$link_name=$link_URL=$desc_arrangement="";
  $descriptionErr=$imageErr="";
  $link_name_array = [];
  $link_URL_array = [];
  $errors = [];
  $numbers = array(2333, 2442, 1279, 3163, 9104, 8324, 8743);


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Image
    $target_dir = "carousel_image_upload/";
    $image_file = $_FILES["image"];
    $image_file_name = $_FILES["image"]["name"];
    $image_file_tmpname = $_FILES["image"]["tmp_name"];

    if ($image_file) {
        if (!empty($image_file_name)) {
            $image_file_group = explode(".", $image_file_name);
            $image_fileExt = end($image_file_group);
            if (!$image_fileExt == "jpg" || !$image_fileExt == "gif" || !$image_fileExt == "png" || !$image_fileExt == "JPG" || !$image_fileExt == "GIF" || !$image_fileExt == "PNG") {
                $imageErr = "Only images are required for the about us image field, not $image_fileExt";
                $errors[] = $imageErr;
            }
        }
    }

    // Geting the link_name and link_URL values
    if (isset($_SESSION["carousel_post"])) {
      if (!empty($_SESSION["carousel_post"])) {
        foreach ($_SESSION["carousel_post"] as $key => $value) {
          $strings = [];
          $string_array = str_split($value, 1);
          $count = count($string_array);
          if ($count >= 6) {
            foreach($string_array as $values) {
              $strings[] = $values;
              $counts = count($strings);
              if ($counts >= 6) {
                break;
              }
            }
            $string = implode("", $strings);
            if ($string == "lk-tag") {
              if (!empty($_POST[$value."_name"]) && !empty($_POST[$value."_URL"])) {
                $link_URL_wrap = test_input($_POST[$value."_URL"]);
                $link_name_wrap = test_input($_POST[$value."_name"]);
                $link_name_array[] = "$value(".$link_name_wrap;
                $link_URL_array[] = "$value(".$link_URL_wrap;
              }
            }
          }
        }
        $link_name = implode("&or/", $link_name_array);
        $link_URL = implode("&or/", $link_URL_array);
      }
    }
    

    // Geting the ph-tag, h1-tag, h2-tag
    if (isset($_SESSION["carousel_post"])) {
      if (!empty($_SESSION["carousel_post"])) {
        $description_array = [];
        $desc_wrap= [];
        foreach ($_SESSION["carousel_post"] as $key => $value) {
          $strings = [];
          $string_array = str_split($value, 1);
          $count = count($string_array);
          if ($count >= 6) {
            foreach($string_array as $values) {
              $strings[] = $values;
              $counts = count($strings);
              if ($counts >= 6) {
                break;
              }
            }
            $string = implode("", $strings);
            if ($string != "lk-tag" && $string != "imgtag") {
              if (!empty($_POST[$value])) {
                $value_wrap = test_input($_POST[$value]);
                $desc_wrap[] = $value_wrap;
                $description_array[] = "$value(".$value_wrap;
              }
            }
          }
        }
        $description = implode("&or/", $description_array);
        $desc_wrd = implode("&", $desc_wrap);
        
      }
    }



    if (isset($_SESSION["carousel_post"])) {
      if (!empty($_SESSION["carousel_post"])) {
        foreach ($_SESSION["carousel_post"] as $key => $value) {
          $desc_arrangement_array[] = $value;
        }
        $desc_arrangement = implode("&&", $desc_arrangement_array);
      }
    }
    if (isset($_POST["submit"])) {
        // Validate $description
        if (empty($desc_wrd)) {
          $descriptionErr = "Content is needed for the blog";
          $errors[] = $descriptionErr;
        }
        if (empty($errors)) {
            $target_file = "";
            $carou_img = "";
            if ($image_file && $image_file_tmpname) {
              shuffle($numbers);
              $image_fileNewname = "CAROU_IMG_".uniqid("", true).$numbers[1]."_".$image_file_name;
              $target_file = $target_dir.$image_fileNewname;
              move_uploaded_file($image_file_tmpname, $target_file);
              $carou_img = 1;
            }
            
            if (!empty($carou_img)) {
              // description, link_name, link_URL, image, desc_arrangement
              $sql = "INSERT INTO carousel_post(description, link_name, link_URL, image, desc_arrangement)
              VALUES(:description, :link_name, :link_URL, :image, :desc_arrangement)";
              $statement = $conection->prepare($sql);
              $statement->bindParam(":description", $description);
              $statement->bindParam(":link_name", $link_name);
              $statement->bindParam(":link_URL", $link_URL);
              $statement->bindParam(":image", $target_file);
              $statement->bindParam(":desc_arrangement", $desc_arrangement);
              $statement->execute();
              unset($_SESSION["carousel_post"]);
              header("Location:viewcarouselpost.php?SuccessfullyCreated");
            } else {
              $errors[] = "Image field is required";
            }

        }
    }

  }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<?php include_once "bce_header.php"; ?>
    <style>
        .main-body {
          padding-bottom: 1000px;
        }
        .main-body form .form-group {
            margin: 10px 0px 10px 0px;
            padding: 10px;
        }
        .main-body form .form-group input {
          width: 80%;
          margin: 15px 0px;
        }
        .main-body form .form-group textarea {
          width: 80%;
          margin: 10px 0px;
        }
        .main-body form .form-group .form-group-a {
            color: black;
            border: 1px solid rgba(0, 0, 0, 0.438);
            padding: 15px 16px 15px 16px;
            display: inline-block;
            position: relative;
        }
        .main-body form .form-group #dropdown-menu {
            width: 300px;
            height: 250px;
            overflow: scroll;
        }
        .main-body form .form-group #dropdown-menu li {
            padding: 10px;
        }
        .main-body form .form-group #dropdown-menu li a {
            font-size: 12px;
            font-weight: bold;
        }
        .main-body form .form-group #dropdown-menu li a img {
            padding: 10px;
            background-color: steelblue;
        }
        .main-body form .form-group .remove-tag {
          margin: 30px 0px;
        }
        .main-body form .form-group .remove-tag .remove-tag-link {
          padding: 10px;
          color-interpolation-filters: linearRGB;
          color: white;
          background-color: red;
          text-decoration: none;
        }
        .main-body form .button-group button {
          width: 60%;
          font-size: 17px;
          font-weight: bold;
        }
        @media (max-width: 1000px) {
          .main-body form .button-group button {
            width: 80%;
          }
        }
        .form-check-group {
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          justify-content: space-evenly;
          margin: 20px 0px;
        }
        .form-check-group span {
          font-size: 13px;
          font-weight: bold;
          text-transform: uppercase;
        }
        .form-check-group span input {
          margin: 0px 5px 0px 0px
        }
    </style>

</head>
<body>


    <div class="container-fluid">
        <div class="row">
          
          <!-- sidebar -->
          <?php include_once "bce_navlink.php"; ?>

          <main class="col-lg-10 col-md-9 main-body">
            <section class="p-5">
              <div class="sticky-top">
                <div class="p-2 mb-2 sticky-top bg-light">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="viewcarouselpost.php" class="btn btn-primary p-2">
                                <img src="bootstrap-icons-1.9.1/table.svg" alt="" class="img-fluid">
                                Back To Table
                            </a>
                        </li>
                    </ul>
                </div>  
              </div>
                <form action="" method="post" enctype="multipart/form-data">
                  <?php if (!empty($errors)) :?>
                    <div class= "alert alert-danger text-dark py-3 px-1">
                      <?php foreach($errors as $error): ?>
                        <?php echo $error. "<br>"; ?>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                    <div class="form-group">
                        <label for="image" class="text-uppercase fw-bold">Upload an Image</label>
                        <input type="file" name="image"  class="form-control">
                    </div>
                    <div class="form-group dropdown">
                      <label><span class="h3 fw-bold">Content</span>
                          <small>Choose how you stack your content on the page</small>
                      </label>
                     
                      <a href="#" class="dropdown-toggle form-group-a" data-bs-toggle="dropdown" id="dropdownIcons"></a>
                            
                                            
                      <ul class="dropdown-menu mx-0 shadow"id="dropdown-menu" aria-labelledby="dropdownIcons">
                        <li>
                          <button class="dropdown-item d-flex gap-2 align-items-center text-uppercase" type="submit" name="name" value="h1-tag">
                          <img src="bootstrap-icons-1.9.1/plus.svg" alt="">
                            H1 TAG (Big Subtitle)
                          </button>
                        </li>
                        <li>
                          <button class="dropdown-item d-flex gap-2 align-items-center text-uppercase" type="submit" name="name" value="h2-tag">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="">
                            H2 TAG (Small Subtitle)
                          </button>
                        </li>
                        <li>
                          <button class="dropdown-item d-flex gap-2 align-items-center text-uppercase" type="submit" name="name" value="ph-tag">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="">
                            Paragraph
                          </button>
                        </li>
                        <li>
                          <button class="dropdown-item d-flex gap-2 align-items-center text-uppercase" type="submit" name="name" value="lk-tag">
                            <img src="bootstrap-icons-1.9.1/plus.svg" alt="">
                            Link
                          </button>
                        </li>
                      </ul>
                    </div>
                    <?php if(isset($_SESSION["carousel_post"])) { ?>
                      <?php if (!empty($_SESSION["carousel_post"])) :?>
                        <?php foreach ($_SESSION["carousel_post"] as $key => $value) :?>
                          <?php
                            $strings = [];
                            $string = "";
                            $string_name = "";
                            $string_array = str_split($value, 1);
                            $count = count($string_array);
                            if ($count >= 6) {
                              foreach ($string_array as $values) {
                                $strings[] = $values;
                                $counts = count($strings);
                                if ($counts >= 6) {
                                  break;
                                }
                              }
                              $string = implode("", $strings);
                             
                            }
                            if ($string == "h1-tag") {
                              $string_name = "H1 TAG (Big Subtitle)";
                            } elseif($string == "h2-tag") {
                              $string_name = "H2 TAG (Small Subtitle)";
                            } elseif ($string == "ph-tag") {
                              $string_name = "Paragraph Tag";
                            } elseif ($string == "lk-tag") {
                              $string_name = "Link";
                            }
                          ?>
                          <?php if($string == "lk-tag") {?>
                            <div class="form-group">
                              <label for="<?php echo $value; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                              <input type="text" name="<?php echo $value; ?>_name" placeholder="Link Name" class="form-control" value="<?=old_value($value."_name")?>">
                              <textarea name="<?php echo $value; ?>_URL" id="<?php echo $value; ?>" cols="10" rows="2" class="form-control" placeholder="Link or URL">
                              <?=old_value($value."_URL")?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="createcarouselpost.php?delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } elseif($string == "ph-tag") { ?>
                            <div class="form-group">
                              <label for="<?php echo $value; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                              <textarea name="<?php echo $value; ?>" id="<?php echo $value; ?>" cols="10" rows="16" class="form-control">
                                  <?=old_value($value)?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="createcarouselpost.php?delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } else { ?>
                            <div class="form-group">
                              <label for="<?php echo $value; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                              <textarea name="<?php echo $value; ?>" id="<?php echo $value; ?>" cols="10" rows="2" class="form-control">
                                  <?=old_value($value)?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="createcarouselpost.php?delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php } ?>
                    <div class="button-group text-center">
                      <button class="btn btn-lg btn-success text-uppercase" name="submit" type="submit">Upload</button>
                    </div>
                </form>
            </section>
          </main>
        </div>
    </div> 

    <script src="js/bootstrap.bundle.js"></script>

    <!-- JS Link File -->
    <!-- <script src="js/bootstrap.bundle.js"></script> -->
    <?php include_once "scripted.php"; ?>

</body>
</html>