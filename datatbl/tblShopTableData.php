<div class="container mb-0 mt-10">

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

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-10">
                                <thead>
                                    <tr>
                                        <!-- <th style="text-align: center;">Sr. No.</th> -->
                                        <th style="text-align: left;">Shop Detail</th>
                                        <th style="text-align: center;">Ward Area</th>
                                        
                                        <th style="text-align: center;">Document Status</th>
                                        <th style="text-align: center;">License Status</th>
                                        <th style="text-align: center;">Billing Date</th>
                                        <th style="text-align: center;">Due Date</th>
                                       <!--  <th style="text-align: center;">Renewal Date</th>
                                        <th style="text-align: center;">Transaction Date</th> -->
                                        <th style="text-align: center;">Payment Status</th>
                                        <th style="text-align: center;">License Amount</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $srNo=0;
                                    foreach ($shopListDetail as $key => $shopData) {
                                        $srNo=$srNo+1;
                                ?>
                                    <tr>
                                        <!-- <td><?php echo $srNo; ?></td> -->
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="product-cart-wrap">

                                                        <div class="product-img-action-wrap" style="cursor: pointer;">
                                                            <div class="product-img product-img-zoom">
                                                                <div class="product-img-inner">
                                                                    <a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?>>
                                                                            <?php 
                                                                                if (!empty($shopData["ShopOutsideImage1"])) {
                                                                            ?>
                                                                                    <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="100" />      
                                                                            <?php
                                                                                }else if (!empty($shopData["ShopOutsideImage2"])) {
                                                                            ?>
                                                                                    <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="100" />      
                                                                            <?php
                                                                                }else{
                                                                            ?>
                                                                                    <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="100%" height="100" />
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                     </a>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="product-cart-wrap">
                                                        <div class="product-content-wrap">
                                                            <h2><a title="View Shop Detail" aria-label="View Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopQuickViewShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)"><?php echo $shopData["ShopName"]; ?></a></h2>
                                                            <span class="shop-badges bg-brand"> <?php echo $shopData["BusinessCatName"]; ?> </span> <span class="shop-badges bg-brand"> <?php echo $shopData["ShopAreaName"]; ?> </span>   <span class="shop-badges bg-brand"> <?php echo $shopData["ShopCategory"]; ?> </span>
                                                            <h5><a title="Call Shop Keeper" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><?php echo $shopData["ShopKeeperName"];  ?> <?php if(!empty($shopData["ShopKeeperMobile"])){ echo "- ".$shopData["ShopKeeperMobile"]; } ?></a></h5>
                                                            <!-- <span class="font-small text-muted"><a href="javascript:void(0);"><?php echo $shopData["PDFullEng"]; ?></a></span> -->
                                                            <h6><a class="inactivelink"><?php if(!trim($shopData["ShopAddress_1"])=="."){ echo $shopData["ShopAddress_1"]; } ?></a></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;"><?php echo $shopData["Ward_No"]." - ".$shopData["WardArea"];  ?> </td>
                                        <td style="text-align: center;">
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" ){ ?> 
                                                        <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                                <?php }else if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                        <span style="background-color: #0BA8E6;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-magnifying-glass-location"></i><?php echo " In-Review"; ?>
                                                        </span>
                                                <?php }else if($shopData["DocFlag"] == 0 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                        <span style="background-color: #E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-rectangle-xmark"></i><?php echo " Rejected"; ?>
                                                        </span>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php if(!empty($shopData["ShopApproval"])){  ?> 
                                                <?php if($shopData["ShopApproval"] != "Rejected" ){  ?>
                                                        <span style="background-color:#008000;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-file-invoice-dollar"></i> <?php echo $shopData["ShopApproval"]; ?></span>
                                                <?php }else if($shopData["ShopApproval"] == "Rejected" ){ ?>  
                                                        <span style="background-color:#E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-circle-xmark"></i> <?php echo $shopData["ShopApproval"]; ?></span>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo $shopData["BillingDate"]; ?> </td>
                                        <td style="text-align: center;"><?php echo $shopData["ExpiryDate"]; ?> </td>
                                        <!-- <td style="text-align: center;"><?php echo $shopData["RenewalDate"]; ?> </td>
                                        <td style="text-align: center;"><?php echo $shopData["TransactionDate"]; ?> </td> -->
                                        <td style="text-align: center;">
                                            <?php if(!empty($shopData["TransStatus"])){ ?> 

                                                <?php if($shopData["TransStatus"]=="Done"){ ?>
                                                            <span style="background-color:#008000;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-file-invoice-dollar"></i> <?php echo " ".$shopData["TransType"]; ?></span> 
                                                <?php }else{  ?>
                                                            <span style="background-color:#E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-file-invoice-dollar"></i> <?php echo " ".$shopData["TransType"]; ?></span>
                                                <?php } ?>

                                            <?php } ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" &&  ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved")  && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>
                                                
                                                <h6><a href="javascript:void(0);"><?php if(!empty($shopData["TotalBillAmount"]) && $shopData["Billing_Cd"] !=0 ){ ?> <i class="fa-solid fa-indian-rupee-sign"></i><?php echo IND_money_format($shopData["TotalBillAmount"])."/-"; } ?></a></h6>

                                            <?php } ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected" ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> 
                                                <a title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"><i class="fi-rs-file-check"></i></a>
                                            <?php } ?>
                                            <a title="Call Shop Keeper" class="action-btn" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><i class="fi-rs-smartphone"></i></a>
                                            <a title="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                            <br/>
                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved" ) && $shopData["Billing_Cd"] != 0 && $shopData["TransStatus"] != 'Done' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>

                                                    <button title="Pay Shop License Fee" aria-label="Pay Shop License Fee" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="payShopLicenseFeeDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>,<?php echo $shopData["Billing_Cd"]; ?>)">Pay</button>

                                            <?php } ?>

                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["IsNewCertificateIssued"] == 1  && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>

                                                    <button title="View Shop License" aria-label="View Shop License" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="viewShopLicenseDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)">View</button>

                                            <?php } ?>
                                        </td>
                                    </tr>

                                   
                               
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>     
                    </div>
                </div>
            </div>
        </div>

</div>