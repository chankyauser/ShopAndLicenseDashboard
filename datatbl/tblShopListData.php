<style type="text/css">
/*     embed.docimg{
        transition: 0.4s ease;
        transform-origin: 30% 30%;

    }
    embed.docimg:hover{
        z-index: 9999999990909090990909;
        transform: scale(5.2); 
    }*/
</style>

<div class="container mb-0 mt-0">
    <div class="row">
        <div class="col-12 col-xl-12">
            
                    <div class="row">
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
                            <div class="col-lg-3-6 mt-0 mb-10">
                                
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-12 col-xl-2">  
                                                <div class="product-cart-wrap">
                                                    <div class="product-img-action-wrap" style="cursor: pointer;">
                                                        <div class="product-img product-img-zoom">
                                                            <div class="product-img-inner">
                                                                <a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?> >
                                                                    <?php 
                                                                        if (!empty($shopData["ShopOutsideImage1"])) {
                                                                    ?>
                                                                            <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />      
                                                                    <?php
                                                                        }else if (!empty($shopData["ShopOutsideImage2"])) {
                                                                    ?>
                                                                            <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />      
                                                                    <?php
                                                                        }else{
                                                                    ?>
                                                                            <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="100%" height="150" />
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
                                                            <!-- <span class="bg-success"><?php echo $shopData["ShopStatus"]; ?></span> -->
                                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" ){ ?> 
                                                                    <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                                            <?php }else if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                                    <span style="background-color: #0BA8E6;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-magnifying-glass-location"></i><?php echo " In-Review"; ?>
                                                                    </span>
                                                            <?php }else if($shopData["DocFlag"] == 0 && $shopData["ShopStatus"] != "Verified" ){ ?> 
                                                                    <span style="background-color: #E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-rectangle-xmark"></i><?php echo " Rejected"; ?>
                                                                    </span>
                                                            <?php } ?>
                                                            &nbsp;&nbsp;
                                                            <?php if(!empty($shopData["ShopApproval"])){ ?> 
                                                                <?php if($shopData["ShopApproval"] != "Rejected" ){  ?>
                                                                        <span style="background-color:#008000;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-file-invoice-dollar"></i> <?php echo $shopData["ShopApproval"]; ?></span>
                                                                <?php }else if($shopData["ShopApproval"] == "Rejected" ){ ?>  
                                                                        <span style="background-color:#E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-circle-xmark"></i> <?php echo $shopData["ShopApproval"]; ?></span>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-4"> 
                                                <div class="product-cart-wrap">
                                                    <div class="product-content-wrap">
                                                        <h2><a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected" ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?> ><?php echo $shopData["ShopName"]; ?></a></h2>
                                                        <span class="shop-badges bg-brand"> <?php echo $shopData["BusinessCatName"]; ?> </span> <span class="shop-badges bg-brand"> <?php echo $shopData["ShopAreaName"]; ?> </span>    <span class="shop-badges bg-brand"> <?php echo $shopData["ShopCategory"]; ?> </span>
                                        
                                                        
                                                        <h5 class="title-detail"><i class="fi-rs-smartphone"></i><?php echo $shopData["ShopKeeperName"];  ?> - <?php echo $shopData["ShopKeeperMobile"];  ?></h5>
                                                        <h6 class="title-detail"><i class="fi-rs-location-alt"></i><?php echo "Ward : ".$shopData["Ward_No"]." - ".$shopData["WardArea"];  ?></h6>

                                                        <h6 class="title-detail"><?php if(!empty($shopData["PDetNameEng"])){ ?> <i class="fa-solid fa-id-card"></i> <?php echo "License Type : ".$shopData["PDetNameEng"];  ?> <?php } ?></h6>

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-5">
                                                <div class="row">
                                                    <?php 
                                                        $shop_Cd = $shopData["Shop_Cd"];
                                                        $query2 = "SELECT ISNULL(sd.ShopDocDet_Cd,0) as ShopDocDet_Cd,
                                                            ISNULL(sd.Shop_Cd,0) as Shop_Cd, 
                                                            ISNULL(sd.Document_Cd,0) as Document_Cd,
                                                            ISNULL(sd.FileURL,'') as FileURL,
                                                            ISNULL(sd.IsVerified,0) as IsVerified,
                                                            ISNULL(sd.QC_Flag,0) as QC_Flag,
                                                            ISNULL(sd.IsActive,0) as IsActive,
                                                            ISNULL(CONVERT(VARCHAR,sd.QC_UpdatedDate,100),'') as QC_UpdatedDate,
                                                            ISNULL(um.Remarks,'') as QC_UpdatedByUserFullName,
                                                            ISNULL(sdm.DocumentName,'') as DocumentName,
                                                            ISNULL(sdm.DocumentNameMar,'') as DocumentNameMar,
                                                            ISNULL(sdm.DocumentType,'') as DocumentType,
                                                            ISNULL(sdm.IsCompulsory,0) as IsCompulsory 
                                                        FROM ShopDocuments sd
                                                        INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd = sd.Document_Cd 
                                                        LEFT JOIN Survey_Entry_Data..User_Master um on um.UserName = sd.QC_UpdatedByUser
                                                        WHERE sd.Shop_Cd = $shop_Cd AND sd.IsActive = 1 AND ISNULL(sd.QC_Flag,0) <> 0;";
                                                    $db2=new DbOperation();
                                                    $shopDocumentsList = $db2->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

                                                        foreach ($shopDocumentsList as $key => $valueDoc) {
                                                            if($valueDoc["DocumentType"]=="image" || $valueDoc["DocumentType"]=="pdf"){
                                                    ?> 
                                                            <div class="col-lg-1-6 col-md-2 col-12 col-sm-6">
                                                                <embed <?php if($valueDoc["DocumentType"]=='image'){ ?> <?php }else if($valueDoc["DocumentType"]=='pdf'){ ?> type="application/pdf" <?php } ?> class="rounded docimg"   title="<?php echo $valueDoc["DocumentName"]; ?>" src="<?php echo $valueDoc["FileURL"]; ?>" width="100%" height="150" data-bs-toggle="modal" data-bs-target="#showModalImageUrl" onclick="setShowImageUrlModal('<?php echo $valueDoc["FileURL"]; ?>','<?php echo $valueDoc["DocumentType"]; ?>');" ></embed>
                                                            </div>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-12 col-xl-1">
                                                <div class="product-cart-wrap">
                                                    <div class="product-content-wrap" style="float: right;margin-top: 5px;">

                                                        <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>
                                                            
                                                            <h1><a href="javascript:void(0);"><?php if(!empty($shopData["TotalBillAmount"]) && $shopData["TotalBillAmount"] !=0 && $shopData["Billing_Cd"] !=0 ){ ?> <i class="fa-solid fa-indian-rupee-sign"></i><?php echo IND_money_format($shopData["TotalBillAmount"])."/-"; } ?></a></h1>
                                                            </br>
                                                        <?php } ?>
                                                            
                                                        <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" &&  ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?> 
                                                                <a title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"><i class="fi-rs-file-check"></i></a>
                                                            <?php } ?>

                                                            <a aria-label="Shop Keeper Detail" class="action-btn" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><i class="fi-rs-smartphone"></i></a>
                                                            <a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>

                                                            <br/>
                                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["Billing_Cd"] != 0 && $shopData["TransStatus"] != 'Done' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>

                                                                    <button title="Pay Shop License Fee" aria-label="Pay Shop License Fee" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="payShopLicenseFeeDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>,<?php echo $shopData["Billing_Cd"]; ?>)">Pay</button>

                                                            <?php } ?>

                                                            <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["IsNewCertificateIssued"] == 1  && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>

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