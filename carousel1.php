<?php 

require_once "dbdetails.php";

try {

    require_once "dbconnect.php";

    $sql = "SELECT * FROM carousel_post";
    $statement = $conection->prepare($sql);
    $statement->execute();
    $carousel_posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $carousel_group = [];
    $carousel_item = [];
    foreach ($carousel_posts as $key => $carousel_post) {
        $carousel_item["id"] = $carousel_post["id"];
        $carousel_item["description"] = $carousel_post["description"];
        $carousel_item["link_name"] = $carousel_post["link_name"];
        $carousel_item["link_URL"] = $carousel_post["link_URL"];
        $carousel_item["image"] = $carousel_post["image"];
        $carousel_item["desc_arrangement"] = $carousel_post["desc_arrangement"];
        $carousel_item["create_date"] = $carousel_post["create_date"];
        $carousel_group[] = $carousel_item;
    }

} catch (PDOException $e) {
    echo $e->getMessage();
} 
?>
<style>
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
</style>
<section>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php if (!empty($carousel_group)) { ?>
                <?php if ($carousel_group[0]) { ?>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
                <?php }?>
                <?php $count = count($carousel_group); ?>
                <?php if ($count > 1) { ?>
                    <?php foreach ($carousel_group as $key => $value) { ?>
                        <?php if ($key == 0) { 
                            continue;
                        }?>
                        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="<?php echo $key; ?>">
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            
            <!-- <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button> -->
        </div>
        <div class="carousel-inner">
            <?php if (!empty($carousel_group)) { ?>
                <?php if ($carousel_group[0]): ?>
                    <?php 
                        // description
                        $description_array_group = explode("&or/", $carousel_group[0]["description"]);
                        $value_array = "";
                        $value_group = [];
                        foreach($description_array_group as $key => $value) {
                            $value_array = explode("(", $value);
                            $value_group[] = $value_array;
                        }
                        // link_name
                        $link_name_array_group = explode("&or/", $carousel_group[0]["link_name"]);
                        $link_name_arr = "";
                        $link_name_group = [];
                        foreach($link_name_array_group as $key => $value) {
                            $link_name_arr = explode("(", $value);
                            $link_name_group[] = $link_name_arr;
                        }
                        // link_URL
                        $link_URL_array_group = explode("&or/", $carousel_group[0]["link_URL"]);
                        $link_URL_arr = "";
                        $link_URL_group = [];
                        foreach($link_URL_array_group as $key => $value) {
                            $link_URL_arr = explode("(", $value);
                            $link_URL_group[] = $link_URL_arr;
                        }

                        $link_group = [];

                        $desc_arrangement_group = explode("&&", $carousel_group[0]["desc_arrangement"]);
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
                    <div class="carousel-item active" style="background-image: url(<?php echo $carousel_group[0]["image"] ?>);" id="carousel">
                        <div class="container">
                            <div class="carousel-txt text-light text-center text-md-start">
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
                                            } ?>" class="cta-link" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen"><?php if (is_array($value)) {
                                                echo $value[0];
                                            } ?></a>
                                        </span>
                                    <?php } ?>
                                <?php endforeach; ?>
                                <!-- <h1 class="text-light">
                                    ETCO <span style="color: rgb(194, 21, 21);">FM</span> 
                                </h1>  
                                <h2>Electrical Technical Company  And <br> Facility Management</h2>
                                <p class="lead h1 py-1">
                                    A Company you can rely on
                                </p>

                                <div class="d-md-flex">
                                    <button type="button" class="btn text-light me-2" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                        Contact Us
                                    </button>
                                    <button class="btn text-light">Hire Us</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $count = count($carousel_group); ?>
                <?php if ($count > 1) { ?>
                    <?php foreach ($carousel_group as $key => $carousel_group_item) { ?>
                        <?php if ($key == 0) { 
                            continue;
                        } ?>
                        <?php 
                            // description
                            $description_array_group = explode("&or/", 
                            $carousel_group_item["description"]);
                            $value_array = "";
                            $value_group = [];
                            foreach($description_array_group as $key => $value) {
                                $value_array = explode("(", $value);
                                $value_group[] = $value_array;
                            }
                            // link_name
                            $link_name_array_group = explode("&or/", 
                            $carousel_group_item["link_name"]);
                            $link_name_arr = "";
                            $link_name_group = [];
                            foreach($link_name_array_group as $key => $value) {
                                $link_name_arr = explode("(", $value);
                                $link_name_group[] = $link_name_arr;
                            }
                            // link_URL
                            $link_URL_array_group = explode("&or/", 
                            $carousel_group_item["link_URL"]);
                            $link_URL_arr = "";
                            $link_URL_group = [];
                            foreach($link_URL_array_group as $key => $value) {
                                $link_URL_arr = explode("(", $value);
                                $link_URL_group[] = $link_URL_arr;
                            }

                            $link_group = [];

                            $desc_arrangement_group = explode("&&", 
                            $carousel_group_item["desc_arrangement"]);
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
                        <div class="carousel-item" style="background-image: url(<?php echo 
                        $carousel_group_item["image"] ?>);" id="carousel">
                            <div class="container">
                                <div class="carousel-txt text-light text-center text-md-start">
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
                                                } ?>" class="cta-link" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen"><?php if (is_array($value)) {
                                                    echo $value[0];
                                                } ?></a>
                                            </span>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                    <!-- <h1 class="text-light">
                                        ETCO <span style="color: rgb(194, 21, 21);">FM</span> 
                                    </h1>  
                                    <h2>Electrical Technical Company  And <br> Facility Management</h2>
                                    <p class="lead h1 py-1">
                                        A Company you can rely on
                                    </p>

                                    <div class="d-md-flex">
                                        <button type="button" class="btn text-light me-2" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                            Contact Us
                                        </button>
                                        <button class="btn text-light">Hire Us</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    

    <div class="modal fade" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Contact Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-modal">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 my-3">
                                    <label for="name" class="mb-2">Name</label>
                                    <input type="text" placeholder="Name" class="form-control" id="form-style" name="name" >
                                    <small style="color:red;font-size:11px;">
                                        <?php 
                                            if (!empty($errors)) {
                                                if (!empty($errors["name"])) {
                                                    echo $errors["name"];
                                                } else {
                                                    $errors["name"] = null;
                                                }
                                            }
                                        ?>
                                    </small>
                                    
                                </div>
                                <div class="col-md-6 my-3">
                                    <label for="email" class="mb-2">Email</label>
                                    <input type="email" placeholder="Email" class="form-control" id="form-style" name="email">
                                    <small style="color:red;font-size:11px;">
                                        <?php 
                                            if (!empty($errors)) {
                                                if (!empty($errors["email"])) {
                                                    echo $errors["email"];
                                                } else {
                                                    $errors["email"] = null;
                                                }
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="col-md-6 my-3">
                                    <label for="phone_number" class="mb-2">Phone Number</label>
                                    <input type="number" placeholder="Phone Number" class="form-control" id="form-style" name="phone_number">
                                    <small style="color:red;font-size:11px;">
                                        <?php 
                                            if (!empty($errors)) {
                                                if (!empty($errors["phone_number"])) {
                                                    echo $errors["phone_number"];
                                                } else {
                                                    $errors["phone_number"] = null;
                                                }
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="col-12 my-3">
                                    <label for="subject" class="mb-2"></label>
                                    <input type="text" placeholder="Subject" class="form-control" id="form-style" name="subject">
                                    <small style="color:red;font-size:11px;">
                                        <?php 
                                            if (!empty($errors)) {
                                                if (!empty($errors["subject"])) {
                                                    echo $errors["subject"];
                                                } else {
                                                    $errors["subject"] = null;
                                                }
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="col-12 my-3">
                                    <label for="message" class="mb-2">Message</label>
                                    <textarea name="message" class="form-control" id="form-style" rows="10" placeholder="MESSAGE...."></textarea>
                                    <small style="color:red;font-size:11px;">
                                        <?php 
                                            if (!empty($errors)) {
                                                if (!empty($errors["message"])) {
                                                    echo $errors["message"];
                                                } else {
                                                    $errors["message"] = null;
                                                }
                                            }
                                        ?>
                                    </small>
                                </div>
                                <div class="my-3 d-flex align-items-center">
                                    <button type="submit" class="btn btn-secondary ms-auto mx-1 submit-btn" name="submit_mess2" >SEND A MESSAGE</button>
                                    <button type="button" class="btn btn-secondary danger-btn mx-1" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


