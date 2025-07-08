

<div class="container mb-0 mt-20">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="row product-grid">
                <?php if(sizeof($shopParwanaDetail)>0){ ?>
                    <ul class="tags-list">
                            <li class="hover-up <?php if($parwanaCd=="All"){ ?> active <?php } ?>  ">
                                <a onclick="setShopParwanaDetail(1,'<?php echo $businessCatCd; ?>','All')">
                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopParwanaDetail[0]["BusinessCatImage"]; ?>" alt="All">
                                All <span class="count"><?php  if( sizeof($BusinessCatTotalCount)>0 ){  echo $BusinessCatTotalCount["FilteredBusinessCatShop"]; }else{ echo "0"; } ?></span></a>
                            </li>
                        <?php 
                            foreach ($shopParwanaDetail as $key => $valueParwana) {
                                $parwana_Cd = $valueParwana["Parwana_Cd"];
                        ?>
                            <li class="hover-up <?php if($parwanaCd == $parwana_Cd){ ?> active <?php } ?> ">
                                <a onclick="setShopParwanaDetail(1,'<?php echo $businessCatCd; ?>','<?php echo $parwana_Cd; ?>')">
                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueParwana["BusinessCatImage"]; ?>" alt="<?php echo $valueParwana["Parwana_Name_Eng"]; ?>">
                                <?php echo $valueParwana["Parwana_Name_Eng"]; ?> <span class="count"><?php echo $valueParwana["ParwanaCatShopCount"]; ?></span></a>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                <?php } ?>

                <?php 
                    foreach ($shopListDetail as $key => $shopData) {
                ?>
                    
                    <div class="col-lg-1-5 col-md-3 col-12 col-sm-6 mt-5 mb-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-cart-wrap mb-15">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?>   >
                                                <?php 
                                                    if (!empty($shopData["ShopOutsideImage1"])) {
                                                ?>
                                                        <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="180" />      
                                                <?php
                                                    }else{
                                                ?>
                                                        <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="100%" height="180" />
                                                <?php
                                                    }
                                                ?>

                                                <?php 
                                                    if (!empty($shopData["ShopOutsideImage2"])) {
                                                ?>
                                                        <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="180" />      
                                                <?php
                                                    }else{
                                                ?>
                                                        <!-- <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt=""  width="100%" height="180" /> -->
                                                <?php
                                                    }
                                                ?>
                                                
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Shop Keeper Detail" class="action-btn" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><i class="fa-solid fa-phone"></i></a>
                                            <a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                            <a aria-label="View Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopQuickViewShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" ){ ?> 
                                                    <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                            <?php }else if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                    <span style="background-color: #0BA8E6;color: #FFFFFF;"><i class="fa-solid fa-magnifying-glass-location"></i><?php echo " In-Review"; ?>
                                                    </span>
                                            <?php }else if($shopData["DocFlag"] == 0 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                    <span style="background-color: #E6490B;color: #FFFFFF;"><i class="fa-solid fa-rectangle-xmark"></i><?php echo " Rejected"; ?>
                                                    </span>
                                            <?php } ?>
                                                    
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="javascript:void(0);"><?php echo $shopData["BusinessCatName"]; ?></a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a href="javascript:void(0);"><?php echo $shopData["ShopAreaName"]; ?></a> &nbsp;&nbsp;&nbsp; --> &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"><?php echo $shopData["ShopCategory"]; ?></a>
                                        </div>
                                        <h2><a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>  title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?> ><?php echo $shopData["ShopName"]; ?></a></h2>
                                   
                                        <!-- <div>
                                            <span class="font-small text-muted"><a href="javascript:void(0);"><?php echo $shopData["PDFullEng"]; ?></a></span>
                                        </div> -->
                                        
                                        <div class="product-card-bottom">
                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>
                                                    <div class="product-price">
                                                        <span><?php if(!empty($shopData["ParwanaAmount"])){ ?> <i class="fa-solid fa-indian-rupee-sign"></i><?php echo IND_money_format($shopData["ParwanaAmount"])."/-"; } ?></span>
                                                    </div>
                                            <?php } ?>
                                            
                                                    <div class="add-cart">
                                                        <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["Billing_Cd"] != 0 && ( empty($shopData["TransStatus"]) || $shopData["TransStatus"] != 'Done' ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>
                                                                <!-- <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Pay </a> -->
                                                                <button title="Pay Shop License Fee" aria-label="Pay Shop License Fee" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="payShopLicenseFeeDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>,<?php echo $shopData["Billing_Cd"]; ?>)">Pay</button>
                                                            <?php } ?>
                                                        <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["IsNewCertificateIssued"] == 1  && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>
                                                                <button title="View Shop License" aria-label="View Shop License" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="viewShopLicenseDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)">View</button>
                                                        <?php } ?>
                                                    </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
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