<?php 
session_start();

if (!isset($_SESSION["UserId"])) {
  header("Location: index.php");
}

require_once "test_function.php";
require_once "dbdetails.php";

try {

  // $letter = $goat ?? 2;
  // $x = $letter == 2 ? "Yes i'm correct as always" : "No you are very wrong this time";
  // echo $letter;
  // echo $x;
  // exit;
  require_once "dbconnect.php";

  if (isset($_GET["carousel_id"])) {
    if (!empty($_GET["carousel_id"])) {
      $sql = "SELECT * FROM carousel_post WHERE id = :id";
      $statement = $conection->prepare($sql);
      $statement->bindParam(":id", $_GET["carousel_id"]);
      $statement->execute();

      $carousel_post = $statement->fetch(PDO::FETCH_ASSOC);

      $desc_arr = explode("&&", $carousel_post["desc_arrangement"]);

      // Add new tags
      if (isset($_POST["name"])) {
        if (!empty($_POST["name"])) {
          if (isset($_SESSION["carousel_post_update"])) {
            $sum = [];
            $sum_end = "";
            $num = "";
            if (!empty($_SESSION["carousel_post_update"])) {
              foreach ($_SESSION["carousel_post_update"] as $key => $value) {
                $sum[] = $key;
              }
              $sum_end = end($sum);
              $num = $sum_end + 1;
              if (!in_array($_POST["name"],$_SESSION["carousel_post_update"])) {
                if (!empty($desc_arr)) {
                  $letter_group = "";
                  $string = "";
                  $string_end = "";
                  $string_match = [];
                  $string_match_checked = [];
                  $add_num = "";
                  foreach ($_SESSION["carousel_post_update"] as $keys => $values) {
                    $letter_group = str_split($values, 1);
                    $count_letter_group = count($letter_group);
                    if ($count_letter_group > 6) {
                      $letter_array = [];
                      $letter_end = [];
                      foreach ($letter_group as $l => $letter) {
                        $count_letter_array = count($letter_array);
                        if($count_letter_array < 6) {
                          $letter_array[] = $letter;
                        } elseif ($count_letter_array >= 6) {
                          $letter_end[] = $letter;
                        }
                      }
                      $string = implode("", $letter_array);
                      $string_end = implode("", $letter_end);
                      if ($_POST["name"] == $string) {
                        $string_match[] = $string_end; 
                      }
                    }
                  }
                  
                  foreach ($desc_arr as $d => $desc_item) {
                    $letter_group = str_split($desc_item, 1);
                    $count_letter_group = count($letter_group);
                    if ($count_letter_group >= 6) {
                      $letter_array = [];
                      $letter_end = [];
                      foreach ($letter_group as $l => $letter) {
                        $count_letter_array = count($letter_array);
                        if($count_letter_array < 6) {
                          $letter_array[] = $letter;
                        } elseif ($count_letter_array >= 6) {
                          $letter_end[] = $letter;
                        }
                      }
                      $string = implode("", $letter_array);
                      $string_end = implode("", $letter_end);
                      if ($_POST["name"] == $string) {
                        $string_match[] = $string_end;
                      }
                    }
                  }

                  if ($string_match) {
                    foreach ($string_match as $s => $s_match) {
                      if ($s_match == "") {
                        $s_match = 1;
                      }    
                      $string_match_checked[] = $s_match;
                    }
                  }
                }
                if (!empty($string_match_checked)) {
                  $big_num = max($string_match_checked);
                  $add_num = $big_num + 1;
                  $_SESSION["carousel_post_update"][$num] = $_POST["name"].$add_num;
                } else {
                  $_SESSION["carousel_post_update"][$num] = $_POST["name"];
                }
              } else {
                if (!empty($desc_arr)) {
                  $letter_group = "";
                  $string = "";
                  $string_end = "";
                  $string_match = [];
                  $add_num = "";
                  $string_match_checked = [];
                  foreach ($_SESSION["carousel_post_update"] as $keys => $values) {
                    $letter_group = str_split($values, 1);
                    $count_letter_group = count($letter_group);
                    if ($count_letter_group > 6) {
                      $letter_array = [];
                      $letter_end = [];
                      foreach ($letter_group as $l => $letter) {
                        $count_letter_array = count($letter_array);
                        if($count_letter_array < 6) {
                          $letter_array[] = $letter;
                        } elseif ($count_letter_array >= 6) {
                          $letter_end[] = $letter;
                        }
                      }
                      $string = implode("", $letter_array);
                      $string_end = implode("", $letter_end);
                      if ($_POST["name"] == $string) {
                        $string_match[] = $string_end;
                      }
                    }
                  }
                  
                  foreach ($desc_arr as $d => $desc_item) {
                    $letter_group = str_split($desc_item, 1);
                    $count_letter_group = count($letter_group);
                    if ($count_letter_group >= 6) {
                      $letter_array = [];
                      $letter_end = [];
                      foreach ($letter_group as $l => $letter) {
                        $count_letter_array = count($letter_array);
                        if($count_letter_array < 6) {
                          $letter_array[] = $letter;
                        } elseif ($count_letter_array >= 6) {
                          $letter_end[] = $letter;
                        }
                      }
                      $string = implode("", $letter_array);
                      $string_end = implode("", $letter_end);
                      if ($_POST["name"] == $string) {
                        $string_match[] = $string_end;
                      }
                    }
                  }

                  if ($string_match) {
                    foreach ($string_match as $s => $s_match) {
                      if ($s_match == "") {
                        $s_match = 1;
                      }    
                      $string_match_checked[] = $s_match;
                    }
                  }
                }
                if (!empty($string_match_checked)) {
                  $big_num = max($string_match_checked);
                  $add_num = $big_num + 1;
                  $_SESSION["carousel_post_update"][$num] = $_POST["name"]. $add_num;
                } else {
                  $_SESSION["carousel_post_update"][$num] = $_POST["name"].$num;
                }
              }
            } else {
              if (!empty($desc_arr)) {
                $letter_group = "";
                $string = "";
                $string_end = "";
                $string_match = [];
                $string_match_checked = [];
                $add_num = "";
                foreach ($desc_arr as $d => $desc_item) {
                  $letter_group = str_split($desc_item, 1);
                  $count_letter_group = count($letter_group);
                  if ($count_letter_group >= 6) {
                    $letter_array = [];
                    $letter_end = [];
                    foreach ($letter_group as $l => $letter) {
                      $count_letter_array = count($letter_array);
                      if($count_letter_array < 6) {
                        $letter_array[] = $letter;
                      } elseif ($count_letter_array >= 6) {
                        $letter_end[] = $letter;
                      }
                      
                    }
                    $string = implode("", $letter_array);
                    $string_end = implode("", $letter_end);
                    if ($_POST["name"] == $string) {
                      $string_match[] = $string_end;
                    }
                  }
                }
                if ($string_match) {
                  foreach ($string_match as $s => $s_match) {
                    if ($s_match == "") {
                      $s_match = 1;
                    }    
                    $string_match_checked[] = $s_match;
                  }
                }
              }
              $count = count($_SESSION["carousel_post_update"]);
              if (!empty($string_match_checked)) {
                $big_num = max($string_match_checked);
                $add_num = $big_num + 1;
                $_SESSION["carousel_post_update"][$count] = $_POST["name"].$add_num;
              } else {
                $_SESSION["carousel_post_update"][$count] = $_POST["name"];
              }
            }
          } else {
            if (!empty($desc_arr)) {
              $letter_group = "";
              $string = "";
              $string_end = "";
              $string_match = [];
              $string_match_checked = [];
              $add_num = "";
              foreach ($desc_arr as $d => $desc_item) {
                $letter_group = str_split($desc_item, 1);
                $count_letter_group = count($letter_group);
                if ($count_letter_group >= 6) {
                  $letter_array = [];
                  $letter_end = [];
                  foreach ($letter_group as $l => $letter) {
                    $count_letter_array = count($letter_array);
                    if($count_letter_array < 6) {
                      $letter_array[] = $letter;
                    } elseif ($count_letter_array >= 6) {
                      $letter_end[] = $letter;
                    }
                  }
                  $string = implode("", $letter_array);
                  $string_end = implode("", $letter_end);
                  if ($_POST["name"] == $string) {
                    $string_match[] = $string_end;
                  }
                }
              }
              if ($string_match) {
                foreach ($string_match as $s => $s_match) {
                  if ($s_match == "") {
                    $s_match = 1;
                  }    
                  $string_match_checked[] = $s_match;
                }
              }
            }
            if (!empty($string_match_checked)) {
              $big_num = max($string_match_checked);
              $add_num = $big_num + 1;
              $_SESSION["carousel_post_update"][0] = $_POST["name"].$add_num;
            } else {
              $_SESSION["carousel_post_update"][0] = $_POST["name"]; 
            }
          }
            
        } else {
          echo '$_get is empty';
        }
      } else {
        $_GET["name"] = null;
      }
      // Delete Existing Tags
      if (isset($_GET["delete_id"])) {
        if (isset($_SESSION["carousel_post_update"])) {
          if (!empty($_SESSION["carousel_post_update"])) {
            $carousel_post_id = $carousel_post["id"];
            if (!empty($_GET["delete_id"])) {
              unset($_SESSION["carousel_post_update"][$_GET["delete_id"]]);
              echo header("Location: updatecarouselpost.php?carousel_id=$carousel_post_id");
            } elseif ($_GET["delete_id"] == 0) {
              $count = count($_SESSION["carousel_post_update"]);
              if ($count == 1) {
                unset($_SESSION["carousel_post_update"][0]);
                echo header("Location: updatecarouselpost.php?carousel_id=$carousel_post_id");
              } else {
                echo header("Location: updatecarouselpost.php?carousel_id=$carousel_post_id&CannotDelete0");
              }
            }
          }
        }
          
      } else {
        $_GET["delete_id"] = null;
      }


      $desc_arrangement_array = [];

      $description = $carousel_post["description"];
      $link_name = $carousel_post["link_name"];
      $link_URL = $carousel_post["link_URL"];
      $desc_arrangement= $carousel_post["desc_arrangement"];

      $descriptionErr=$imageErr="";
      $link_name_array = [];
      $link_URL_array = [];
      $description_array = [];
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
        if (!empty($carousel_post["link_name"]) && !empty($carousel_post["link_URL"])) {
          if (isset($_SESSION["carousel_post_update"])) {
            if (!empty($_SESSION["carousel_post_update"])) {

              $link_name_array_group = explode("&or/", $carousel_post["link_name"]);
              $link_URL_array_group = explode("&or/", $carousel_post["link_URL"]);
              
              // Update link_name
              foreach ($link_name_array_group as $key => $value) {
                $link_name_content = "";
                $link_name_content_array = [];
                $link_name_content = explode("(", $value);
                $link_name_content_array[] = $link_name_content;
                foreach($link_name_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty($_POST[$values[0]."_name"])) {
                      $link_name_wrap = test_input($_POST[$values[0]."_name"]);
                      $link_name_array[] = $values[0]."(". $link_name_wrap;
                    } else {
                      $link_name_array[] = $value;
                    }
                  }
                }
              }
              // Update link_URL
              foreach ($link_URL_array_group as $key => $value) {
                $link_URL_content = "";
                $link_URL_content_array = [];
                $link_URL_content = explode("(", $value);
                $link_URL_content_array[] = $link_URL_content;
                foreach($link_URL_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty($_POST[$values[0]."_URL"])) {
                      $link_URL_wrap = test_input($_POST[$values[0]."_URL"]);
                      $link_URL_array[] = $values[0]."(". $link_URL_wrap;
                    } else {
                      $link_URL_array[] = $value;
                    }
                  }
                }
              }

              foreach ($_SESSION["carousel_post_update"] as $keys => $value) {
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
            } else {
              $link_name_array_group = explode("&or/", $carousel_post["link_name"]);
              $link_URL_array_group = explode("&or/", $carousel_post["link_URL"]);
              
              // Update link_name
              foreach ($link_name_array_group as $key => $value) {
                $link_name_content = "";
                $link_name_content_array = [];
                $link_name_content = explode("(", $value);
                $link_name_content_array[] = $link_name_content;
                foreach($link_name_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty($_POST[$values[0]."_name"])) {
                      $link_name_wrap = test_input($_POST[$values[0]."_name"]);
                      $link_name_array[] = $values[0]."(". $link_name_wrap;
                    } else {
                      $link_name_array[] = $value;
                    }
                  }
                }
              }
              // Update link_URL
              foreach ($link_URL_array_group as $key => $value) {
                $link_URL_content = "";
                $link_URL_content_array = [];
                $link_URL_content = explode("(", $value);
                $link_URL_content_array[] = $link_URL_content;
                foreach($link_URL_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty($_POST[$values[0]."_URL"])) {
                      $link_URL_wrap = test_input($_POST[$values[0]."_URL"]);
                      $link_URL_array[] = $values[0]."(". $link_URL_wrap;
                    } else {
                      $link_URL_array[] = $value;
                    }
                  }
                }
              }

              $link_name = implode("&or/", $link_name_array);
              $link_URL = implode("&or/", $link_URL_array);
            }
          } else {
            $link_name_array_group = explode("&or/", $carousel_post["link_name"]);
            $link_URL_array_group = explode("&or/", $carousel_post["link_URL"]);
            
            // Update link_name
            foreach ($link_name_array_group as $key => $value) {
              $link_name_content = "";
              $link_name_content_array = [];
              $link_name_content = explode("(", $value);
              $link_name_content_array[] = $link_name_content;
              foreach($link_name_content_array as $key => $values) {
                if (is_array($values)) {
                  if (!empty($_POST[$values[0]."_name"])) {
                    $link_name_wrap = test_input($_POST[$values[0]."_name"]);
                    $link_name_array[] = $values[0]."(". $link_name_wrap;
                  } else {
                    $link_name_array[] = $value;
                  }
                }
              }
            }
            // Update link_URL
            foreach ($link_URL_array_group as $key => $value) {
              $link_URL_content = "";
              $link_URL_content_array = [];
              $link_URL_content = explode("(", $value);
              $link_URL_content_array[] = $link_URL_content;
              foreach($link_URL_content_array as $key => $values) {
                if (is_array($values)) {
                  if (!empty($_POST[$values[0]."_URL"])) {
                    $link_URL_wrap = test_input($_POST[$values[0]."_URL"]);
                    $link_URL_array[] = $values[0]."(". $link_URL_wrap;
                  } else {
                    $link_URL_array[] = $value;
                  }
                }
              }
            }
            $link_name = implode("&or/", $link_name_array);
            $link_URL = implode("&or/", $link_URL_array);

          }
        } else {
          if (isset($_SESSION["carousel_post_update"])) {
            if (!empty($_SESSION["carousel_post_update"])) {
              foreach ($_SESSION["carousel_post_update"] as $key => $value) {
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
                    if ($_POST[$value."_name"] && $_POST[$value."_URL"]) {
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
        }

        // Geting the ph-tag, h1-tag, h2-tag
        if (!empty($carousel_post["description"])) {
          
          if (isset($_SESSION["carousel_post_update"])) {
            if (!empty($_SESSION["carousel_post_update"])) {

              // Update existing description
              $description_array_group = explode("&or/", $carousel_post["description"]);
              foreach ($description_array_group as $key => $value) {
                $description_array_content = "";
                $description_array_content_array = [];
                $description_array_content = explode("(", $value);
                $description_array_content_array[] = $description_array_content;
                foreach ($description_array_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty([$_POST[$values[0]]])) {
                      $description_wrap = test_input($_POST[$values[0]]);
                      $description_array[] = $values[0]."(". $description_wrap;
                    } else {
                      $description_array[] = $value;
                    }
                  }
                }
              }

              foreach ($_SESSION["carousel_post_update"] as $key => $value) {
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
                      $description_array[] = "$value(".$value_wrap;
                    }
                  }
                }
              }

              $description = implode("&or/", $description_array);
                
            } else {
              // Update Existing Description
              $description_array_group = explode("&or/", $carousel_post["description"]);
              foreach ($description_array_group as $key => $value) {
                $description_array_content = "";
                $description_array_content_array = [];
                $description_array_content = explode("(", $value);
                $description_array_content_array[] = $description_array_content;
                foreach ($description_array_content_array as $key => $values) {
                  if (is_array($values)) {
                    if (!empty([$_POST[$values[0]]])) {
                      $description_wrap = test_input($_POST[$values[0]]);
                      $description_array[] = $values[0]."(". $description_wrap;
                    } else {
                      $description_array[] = $value;
                    }
                  }
                }
              }
              $description = implode("&or/", $description_array);
            }
          } else {
            $description_array_group = explode("&or/", $carousel_post["description"]);
            foreach ($description_array_group as $key => $value) {
              $description_array_content = "";
              $description_array_content_array = [];
              $description_array_content = explode("(", $value);
              $description_array_content_array[] = $description_array_content;
              foreach ($description_array_content_array as $key => $values) {
                if (is_array($values)) {
                  if (!empty([$_POST[$values[0]]])) {
                    $description_wrap = test_input($_POST[$values[0]]);
                    $description_array[] = $values[0]."(". $description_wrap;
                  } else {
                    $description_array[] = $value;
                  }
                }
              }
            }

            $description = implode("&or/", $description_array);
          }

        } else {
          
          if (isset($_SESSION["carousel_post_update"])) {
            if (!empty($_SESSION["carousel_post_update"])) {
              foreach ($_SESSION["carousel_post_update"] as $key => $value) {
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
                      $description_array[] = "$value(".$value_wrap;
                    }
                  }
                }
              }
              $description = implode("&or/", $description_array);
                
            }
          }

        }
        

        // Validate $description
        if (empty($description)) {
          $descriptionErr = "Content is needed for the blog";
          $errors[] = $descriptionErr;
        }


        // Validate $desc_arrangement
        if (isset($_SESSION["carousel_post_update"])) {
          if (!empty($_SESSION["carousel_post_update"])) {
            if (!empty($carousel_post["desc_arrangement"])) {
              $desc_arrangement_group_array = explode("&&", $carousel_post["desc_arrangement"]);
              foreach ($desc_arrangement_group_array as $key => $values) {
                $desc_arrangement_array[] = $values;
              }
            }
            foreach ($_SESSION["carousel_post_update"] as $key => $value) {
              $desc_arrangement_array[] = $value;
            }
            $desc_arrangement = implode("&&", $desc_arrangement_array);
          }
        } else {
          if (!empty($carousel_post["desc_arrangement"])) {
            $desc_arrangement_group_array = explode("&&", $carousel_post["desc_arrangement"]);
            foreach ($desc_arrangement_group_array as $key => $values) {
              $desc_arrangement_array[] = $values;
            }
          }
          $desc_arrangement = implode("&&", $desc_arrangement_array);
        }


        if (isset($_POST["submit"])) {
          if (empty($errors)) {
            $target_file = $carousel_post["image"];
            if ($image_file && $image_file_tmpname) {
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
                shuffle($numbers);
                $image_fileNewname = "CAROU_IMG_".uniqid("", true).$numbers[1]."_".$image_file_name;
                $target_file = $target_dir.$image_fileNewname;
                move_uploaded_file($image_file_tmpname, $target_file);
            }
            $sql = "UPDATE carousel_post SET description = :description, link_name = :link_name, link_URL = :link_URL, image = :image, desc_arrangement = :desc_arrangement WHERE id = :id";

            $statement = $conection->prepare($sql);
            $statement->bindParam(":id", $_GET["carousel_id"]);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":link_name", $link_name);
            $statement->bindParam(":link_URL", $link_URL);
            $statement->bindParam(":image", $target_file);
            $statement->bindParam(":desc_arrangement", $desc_arrangement);
            $statement->execute();
            unset($_SESSION["carousel_post_update"]);
            header("Location: viewcarouselpost.php?SuccessfullyUpdated");
          }
        }

      }
    }

  } else {
    header("Location: viewblogpost.php?SelectItem");
    
  }
    
} catch (PDOException $e) {
  echo $e->getMessage();
}

$connection = null;

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
            height: 500px;
            overflow: scroll;
        }
        .main-body form .form-group #dropdown-menu li {
            padding: 10px;
        }
        .main-body form .form-group #dropdown-menu li button {
            font-size: 12px;
            font-weight: bold;
        }
        .main-body form .form-group #dropdown-menu li button img {
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
                    <?php if(isset($_GET["CannotDelete0"])) :?>
                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?php echo "You cannot delete the first input until you have deleted the remaining"; ?>
                        <a type="button" href="projectdashbrd.php" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                      </div>
                    <?php endif; ?>

                    <div class="text-center" style="width: 60%;margin:auto;">
                        <img src="<?php echo $carousel_post["image"]; ?>" alt="" height="500" style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="image" class="text-uppercase fw-bold">Upload An Image</label>
                        <input type="file" name="image" class="form-control">
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
                    <?php if(isset($_SESSION["carousel_post_update"])) { ?>
                      <?php if (!empty($_SESSION["carousel_post_update"])) :?>
                        <?php foreach ($_SESSION["carousel_post_update"] as $key => $value) :?>
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
                            if ($string == "ul-tag") {
                              $string_name = "Underline";
                            } elseif ($string == "h1-tag") {
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
                              <input type="text" name="<?php echo $value; ?>_name" placeholder="Link Name" class="form-control" value="
                              <?php 
                               if (empty($_POST[$value."_name"])) {
                                 $_POST[$value."_name"] = null;
                               } else {
                                echo $_POST[$value."_name"];
                               }
                              ?>
                              " >
                              <textarea name="<?php echo $value; ?>_URL" id="<?php echo $value; ?>" cols="10" rows="2" class="form-control" placeholder="Link or URL">
                              <?php 
                              if (empty($_POST[$value."_URL"])) {
                                $_POST[$value."_URL"] = null;
                              } else {
                                echo $_POST[$value."_URL"];
                              }
                              ?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="updatecarouselpost.php?carousel_id=<?php echo $carousel_post["id"] ; ?>&delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } elseif($string == "ph-tag") { ?>
                            <div class="form-group">
                              <label for="<?php echo $value; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                              <textarea name="<?php echo $value; ?>" id="<?php echo $value; ?>" cols="10" rows="16" class="form-control">
                              <?php 
                              if (empty($_POST[$value])) {
                                $_POST[$value] = null;
                              } else {
                                echo $_POST[$value];
                              }
                              ?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="updatecarouselpost.php?carousel_id=<?php echo $carousel_post["id"] ; ?>&delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } else { ?>
                            <div class="form-group">
                              <label for="<?php echo $value; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                              <textarea name="<?php echo $value; ?>" id="<?php echo $value; ?>" cols="10" rows="2" class="form-control">
                              <?php 
                              if (empty($_POST[$value])) {
                                $_POST[$value] = null;
                              } else {
                                echo $_POST[$value];
                              }
                              ?>
                              </textarea>
                              <div class="remove-tag">
                                <a href="updatecarouselpost.php?carousel_id=<?php echo $carousel_post["id"] ; ?>&delete_id=<?php echo $key; ?>" class="remove-tag-link">
                                  <img src="bootstrap-icons-1.9.1/x-lg.svg" alt="">
                                  Remove tag
                                </a>
                              </div>
                            </div>
                          <?php } ?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php } ?>

                    <div class="form-group">

                    </div>

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
                        if ($string == "ul-tag") {
                            $string_name = "Underline";
                        } elseif ($string == "h1-tag") {
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
                          <label for="<?php echo $key; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                          <input type="text" name="<?php echo $key; ?>_name" placeholder="Link Name" class="form-control" value="<?php 
                          if (is_array($value)) {
                            echo $value[0];
                          }?>">
                          <textarea name="<?php echo $key; ?>_URL" id="<?php echo $key; ?>" cols="10" rows="2" class="form-control" placeholder="Link or URL">
                            <?php if(is_array($value)){
                              echo $value[1];
                            } ?>
                          </textarea>
                        </div>
                      <?php } elseif($string == "ph-tag") { ?>
                        <div class="form-group">
                          <label for="<?php echo $key; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                          <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="10" rows="20" class="form-control">
                            <?php echo $value; ?>
                          </textarea>
                        </div>
                      <?php } else { ?>
                        <div class="form-group">
                          <label for="<?php echo $key; ?>" class="text-uppercase fw-bold"><?php echo $string_name; ?></label>
                          <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="10" rows="2" class="form-control"><?php echo $value; ?></textarea>
                        </div>
                      <?php } ?>

                    <?php endforeach; ?>

                    
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
    <?php include_once "scripted.php"; ?>

</body>
</html>