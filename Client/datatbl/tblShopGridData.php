

<div class="container mb-0 mt-30">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="row product-grid">
                <?php 
                    foreach ($shopListDetail as $key => $shopData) {
                ?>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a onclick="setShopDetailData(<?php echo $shopData["Shop_Cd"];  ?>)">
                                        <?php 
                                            if (!empty($shopData["ShopOutsideImage1"])) {
                                        ?>
                                                <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="225" height="300" />      
                                        <?php
                                            }else{
                                        ?>
                                                <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="225" height="300" />
                                        <?php
                                            }
                                        ?>

                                        <?php 
                                            if (!empty($shopData["ShopOutsideImage2"])) {
                                        ?>
                                                <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="225" height="300" />      
                                        <?php
                                            }else{
                                        ?>
                                                <!-- <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt=""  width="225" height="300" /> -->
                                        <?php
                                            }
                                        ?>
                                        
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                    <a aria-label="Quick View Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopQuickViewShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)"><i class="fi-rs-eye"></i></a>
                                </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    <span class="bg-success"><?php echo $shopData["ShopStatus"]; ?></span>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="#" class="inactiveLink"><?php echo $shopData["ShopAreaName"]; ?></a>
                                </div>
                                <h2><a onclick="setShopDetailData(<?php echo $shopData["Shop_Cd"];  ?>)"><?php echo $shopData["ShopName"]; ?></a></h2>
                                <!-- <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div>
                                    <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                </div> -->
                                <!-- <div class="product-card-bottom">
                                    <div class="product-price">
                                        <span>$28.85</span>
                                        <span class="old-price">$32.8</span>
                                    </div>
                                    <div class="add-cart">
                                        <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
                
            </div>

        </div>

    </div>
</div>