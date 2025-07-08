

<div class="container mb-0 mt-30">
    <div class="row">
        <div class="col-12 col-xl-9">
            <div class="row product-list">
                <?php 
                    foreach ($shopListDetail as $key => $shopData) {
                ?>
                   
                                <div class="col-12 col-xl-3 col-sm-12">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <div class="product-img-inner">
                                                <a onclick="setShopDetailData(<?php echo $shopData["Shop_Cd"];  ?>)">
                                                    <?php 
                                                        if (!empty($shopData["ShopOutsideImage1"])) {
                                                    ?>
                                                            <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="200" />      
                                                    <?php
                                                        }else if (!empty($shopData["ShopOutsideImage2"])) {
                                                    ?>
                                                            <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="200" />      
                                                    <?php
                                                        }else{
                                                    ?>
                                                            <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="100%" height="200" />
                                                    <?php
                                                        }
                                                    ?>

                                                    
                                                    
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                            <a aria-label="Quick View Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopQuickViewShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="bg-success"><?php echo $shopData["ShopStatus"]; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-9 col-sm-12">
                                    <div class="product-content-wrap">
                                        <h2><a onclick="setShopDetailData(<?php echo $shopData["Shop_Cd"];  ?>)"><?php echo $shopData["ShopName"]; ?></a></h2>
                                        <span class="stock-status out-stock"> <?php echo $shopData["BusinessCatName"]; ?> </span> <span class="stock-status out-stock"> <?php echo $shopData["ShopAreaName"]; ?> </span>  
                        
                                        
                                        <h5 class="title-detail"><a aria-label="Shop Keeper Detail" class="action-btn" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><i class="fi-rs-smartphone"></i></a> <?php echo $shopData["ShopKeeperName"];  ?> - <?php echo $shopData["ShopKeeperMobile"];  ?></h5>
                                        <h6 class="title-detail"><a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a> <?php echo $shopData["ShopAddress_1"];  ?></h6>
                                    </div>
                                </div>
                            
                <?php
                    }
                ?>
                
            </div>

        </div>

        <?php //include 'getShopBusinessCategoryWidget.php'; ?>

    </div>
</div>