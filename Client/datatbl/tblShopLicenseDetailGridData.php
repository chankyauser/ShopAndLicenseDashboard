<div class="container mt-10 mb-0">
    <div class="card">
        <div class="card-body">
            <!-- <form class="form-horizontal" novalidate> -->
                <div class="row" style="margin-top:-10px">

                    <div class="col-lg-3 col-sm-6 col-md-3 col-12">
                        <div class="form-group">
                            <label>Zone</label>
                            <select class="form-control" name="nodeName" onchange="setNodeAndWardList(this.value)">
                                <option value="All">All Zone </option>
                                <?php 
                                    foreach ($dataNodeName as $key => $valueNodeName) {
                                        if($nodeName==$valueNodeName["NodeName"]){
                                ?>
                                            <option selected value="<?php echo $valueNodeName["NodeName"]; ?>"><?php echo "".$valueNodeName["NodeName"]; ?></option>
                                <?php
                                        }else{
                                 ?>
                                            <option value="<?php echo $valueNodeName["NodeName"]; ?>"><?php echo "".$valueNodeName["NodeName"]; ?></option>
                                <?php            
                                        }
                                    }
                                ?>  
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-3 col-12">
                        <div class="form-group">
                            <label>Ward</label>
                            <select class="form-control" name="nodeCd" id="setNodeAndWardDetailId" onchange="setNodeAndWardId(this.value)">
                                <option value="All">All Ward </option>
                                <?php 
                                    foreach ($dataNode as $key => $valueNode) {
                                        if($nodeCd==$valueNode["Node_Cd"]){
                                ?>
                                            <option selected value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                                <?php
                                        }else{
                                 ?>
                                            <option value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                                <?php            
                                        }
                                    }
                                ?>  
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-lg-2 col-sm-6 col-md-2 col-12">
                        <div class="form-group">
                            <label>Document Status</label>
                            <select class="form-control" name="documentStatus">
                                <option <?php echo $documentStatus == 'Verified' ? 'selected' : '' ; ?> value="Verified">Verified</option>
                            </select>
                        </div>
                    </div> -->
                    <input type="hidden" name="documentStatus" value="<?php echo "Verified"; ?>">

                    <div class="col-lg-2 col-sm-6 col-md-2 col-12">
                        <div class="form-group">
                            <label>License Status</label>
                            <!-- onchange="setHideApproveAndGenerateLicenseProcess(this.value)" -->
                            <select class="form-control" name="licenseStatus" id="selectLicenseId" onchange="setShopLicenseDetailFilter(<?php echo $pageNo; ?>)">
                                <option <?php echo $licenseStatus == 'All' ? 'selected' : '' ; ?> value="All">All</option>
                                <!-- <option <?php echo $licenseStatus == 'Verified' ? 'selected' : '' ; ?> value="Verified">Verified</option> -->
                                <option <?php echo $licenseStatus == 'Approved' ? 'selected' : '' ; ?> value="Approved">Approved</option>
                                <option <?php echo $licenseStatus == 'Rejected' ? 'selected' : '' ; ?> value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-6 col-md-2 col-12">
                        <div class="form-group">
                            <label>Transaction Status</label>
                            <select class="form-control" name="transactionStatus" id="selectTransactionStatusId"  onchange="setShopLicenseDetailFilter(<?php echo $pageNo; ?>)">
                                <option <?php echo $transactionStatus == 'All' ? 'selected' : '' ; ?> value="All">All</option>
                                <option <?php echo $transactionStatus == 'Paid' ? 'selected' : '' ; ?> value="Paid">Paid</option>
                                <option <?php echo $transactionStatus == 'Unpaid' ? 'selected' : '' ; ?> value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-lg-1 col-sm-1 col-md-1 col-12"> -->
                        <input type="hidden" name="pageNo" value="<?php echo $pageNo; ?>">
                        <input type="hidden" name="viewType" value="<?php echo $_SESSION['SAL_View_Type']; ?>">
                        <input type="hidden" name="pageName" value="<?php if(isset($_GET['p'])){ echo $_GET['p']; } ?>" />
                    <!-- </div> -->

                    <!-- <div class="col-md-1 col-12" style="margin-top: 35px;">
                        <div class="form-group">
                             <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <button class="btn btn-sm btn-primary" onclick="setShopLicenseDetailFilter(<?php echo $pageNo; ?>)">Refresh</button>
                        </div>
                    </div> -->
                    <div class="col-lg-2 col-sm-5 col-md-2 col-12 col-sm-12" style="margin-top: 25px;">
                        <ul class="page-view-area" style="float:right;">
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "GridView"){ ?> active <?php }?>" onclick="setShopLicenseDetailView(<?php echo $pageNo; ?>,'GridView')"><i class="fi-rs-grid"></i></li>
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){ ?> active <?php }?>" onclick="setShopLicenseDetailView(<?php echo $pageNo; ?>,'ListView')"><i class="fi-rs-list"></i></li>
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "TableView"){ ?> active <?php }?>" onclick="setShopLicenseDetailView(<?php echo $pageNo; ?>,'TableView')"><i class="fa-solid fa-table-list"></i></li>
                            <?php if( $licenseStatus == 'Verified' && $total_count["FilteredShop"] > 0 ){ ?> 
                                <li id="setApproveAndGenerateLicenseId" class="page-view-link " title="Approve & Generate Shop Licenses" style="background-color: #008000 !important;" onclick="setApproveShopLicenseList(<?php echo $pageNo; ?>,'TableView')"><i class="fa-solid fa-id-card"></i></li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="container mb-0 mt-10">
    
    <div class="row product-grid">
        <?php 
            foreach ($shopListDetail as $key => $shopData) {
        ?>
            <div class="col-lg-1-5 col-md-3 col-12 col-sm-6 mt-5 mb-10">
                <div class="card">
                    <div class="card-body">
                        <div class="product-cart-wrap mb-15">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified"  && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected")  ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?>   >
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
                                    <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified" || $documentStatus=="All") ){ ?> 
                                            <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                    <?php }else if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] != "Verified" && ($documentStatus=="InReview" || $documentStatus=="All")){ ?> 
                                            <span style="background-color: #0BA8E6;color: #FFFFFF;"><i class="fa-solid fa-magnifying-glass-location"></i><?php echo " In-Review"; ?>
                                            </span>
                                    <?php }else if($shopData["DocFlag"] == 0 && $shopData["ShopStatus"] != "Verified" && ($documentStatus=="Rejected" || $documentStatus=="All")){ ?> 
                                            <span style="background-color: #E6490B;color: #FFFFFF;"><i class="fa-solid fa-rectangle-xmark"></i><?php echo " Rejected"; ?>
                                            </span>
                                    <?php } ?>
                                            
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="javascript:void(0);"><?php echo $shopData["BusinessCatName"]; ?></a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a href="javascript:void(0);"><?php echo $shopData["ShopAreaName"]; ?></a> &nbsp;&nbsp;&nbsp; --> &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"><?php echo $shopData["ShopCategory"]; ?></a>
                                </div>
                                <h2><a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified"  && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected")  ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>  title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"  <?php }else{ ?> href="javascript:void(0);" <?php } ?> ><?php echo $shopData["ShopName"]; ?></a></h2>
                           
                                <!-- <div>
                                    <span class="font-small text-muted"><a href="javascript:void(0);"><?php echo $shopData["PDFullEng"]; ?></a></span>
                                </div> -->
                                
                                <div class="product-card-bottom">
                                    <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified"  || ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved")) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>
                                            <div class="product-price">
                                                <span><?php if(!empty($shopData["ParwanaAmount"])){ ?> <i class="fa-solid fa-indian-rupee-sign"></i><?php echo IND_money_format($shopData["ParwanaAmount"])."/-"; } ?></span>
                                            </div>
                                    <?php } ?>
                                    
                                            <div class="add-cart">
                                                <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified"  || ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved")) && $shopData["Billing_Cd"] != 0 && ( empty($shopData["TransStatus"]) || $shopData["TransStatus"] != 'Done' ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>
                                                        <!-- <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Pay </a> -->
                                                        <!-- <button title="Pay Shop License Fee" aria-label="Pay Shop License Fee" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="payShopLicenseFeeDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>,<?php echo $shopData["Billing_Cd"]; ?>)">Pay</button> -->
                                                    <?php } ?>
                                                <?php if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="Verified"  || ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved")) && $shopData["IsNewCertificateIssued"] == 1 && $shopData["Billing_Cd"] != 0 && ( !empty($shopData["TransStatus"]) && $shopData["TransStatus"] == 'Done' ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>
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