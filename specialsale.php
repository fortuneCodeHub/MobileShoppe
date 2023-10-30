<?php
shuffle($products);
// Get all the brand names and putting them under a unique array so no matter how many times a brand name is repeated it will still come under one name
$brand = array_map(function($product){return $product["item_brand"];}, $products);
$unique = array_unique($brand);
sort($unique);
?>
<section id="special-sale" class="px-5">
    <div class="container">
                    <h3 class="font-size-20 fw-bold text-start">
                        Special Sale
                    </h3>
                    <div class="text-sm-end button-group my-3" id="filters">
                        <button class="btn is-checked" data-bs-name="*">All Brand</button>
                        <span>
                        <?php 
                        array_map(function($brand){
                            printf(' <button class="btn" data-bs-name=".%s">%s</button>', $brand, $brand);
                        }, $unique);
                        ?>
                        </span>
                    <div class="grid text-center text-lg-start">
                        <?php foreach ($products as $product):?>
                            <div class="grid-item <?php echo $product["item_brand"];?> border text-center">
                                <div class="item py-5">
                                    <div id="owl-carousel-item-cover" >
                                        <a href="productpage.php?item_id=<?php echo $product["item_id"]; ?>">
                                            <img src="<?php $product_image = $product["item_image"];
                                            if (!$product_image) {
                                                echo "assets/file-image.svg";
                                            } else {
                                                echo $product_image;
                                            } ?>" alt="" class="img-fluid mb-3" id="owl-carousel-item" style="width: 100%;">
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <h4 class="font-size-20"><?php $product_name = $product["item_name"];
                                        if (!$product_name) {
                                            echo "Unknown";
                                        } else {
                                            echo $product_name;
                                        } ?></h4>
                                        <span><i class="bi bi-star"></i></span>
                                        <span><i class="bi bi-star"></i></span>
                                        <span><i class="bi bi-star"></i></span>
                                        <span><i class="bi bi-star"></i></span>
                                        <span><i class="bi bi-star"></i></span>
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold"><?php echo $product["item_price"]; ?></span>
                                        <br>
                                        <?php if (!empty($product["item_discount"])): ?>
                                            <span><del><?php echo $product["old_price"]; ?></del></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                    <a href="productpage.php?item_id=<?php echo $product["item_id"]; ?>" class="btn btn-warning text-light">Add To Cart</a>
                                    </div>
                                </div>  
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
</section>