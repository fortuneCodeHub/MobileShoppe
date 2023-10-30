<style>
    #new-phone #anchor-link {
        position: relative;
    }
    #new-phone #anchor-link img {
        height: 200px;
        width: 100%;
    }
    #new-phone #before-link {
        position: absolute;
        width: 40px;
        height: 50px;
        background-color: rgba(15, 228, 15, 0.514);
        font-size: 19px;
        font-weight: 600;
        color: white;
        top: 15px;
        right: 15%;
    }
</style>
<?php shuffle($products); ?>
<section id="new-phone" class="py-5">
                <div class="container">
                    <h3 class="mb-5">New Phones</h3>
                    <div class="owl-carousel text-center">
                        <?php foreach ($products as $product):?>
                        <div class="item bg-light py-3">
                            <div id="owl-carousel-item-cover" >
                                <a href="productpage.php?item_id=<?php echo $product["item_id"]; ?>" id="anchor-link">
                                    <img src="<?php $product_image = $product["item_image"];
                                    if(!$product_image) {
                                        echo "assets/file-image.svg";
                                    } else {
                                        echo $product_image;
                                    }  
                                     ?>" alt="" class="img-fluid mb-3" id="owl-carousel-item">
                                </a>
                                <span id="before-link"><?php echo $product["item_discount"]; ?>%</span>
                            </div>
                            <div class="text-center">
                                <h4><?php $product_name = $product["item_name"];
                                if (!$product_name) {
                                    echo "Unknown";
                                } else {
                                    echo $product_name;
                                } ?></h4>
                                <span><i class="bi bi-star-fill text-warning"></i></span>
                                <span><i class="bi bi-star-fill"></i></span>
                                <span><i class="bi bi-star-fill"></i></span>
                                <span><i class="bi bi-star-fill"></i></span>
                                <span><i class="bi bi-star"></i></span>
                            </div>
                            <div class="py-2">
                                <span class="fw-bold">$<?php echo $product["item_price"]; ?></span>
                                <br>
                                <?php if (!empty($product["item_discount"])): ?>
                                    <span><del><?php echo $product["old_price"]; ?></del></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="productpage.php?item_id=<?php echo $product["item_id"]; ?>" class="btn btn-warning text-light">Add To Cart</a>
                            </div>
                        </div> 
                        <?php endforeach; ?> 
                </div>
            </section>