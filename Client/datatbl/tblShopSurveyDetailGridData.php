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

                    <div class="col-lg-3 col-sm-6 col-md-3 col-12" >
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

                    <div class="col-lg-3 col-sm-6 col-md-3 col-12">
                        <div class="form-group">
                            <label>Shop Document Status</label>
                            <select class="form-control" name="documentStatus" onchange="setShopSurveyDetailFilter(<?php echo $pageNo; ?>)">
                                <option <?php echo $documentStatus == 'All' ? 'selected' : '' ; ?> value="All">All</option>
                                <option <?php echo $documentStatus == 'DocPending' ? 'selected' : '' ; ?> value="DocPending">Document Pending</option>
                                <option <?php echo $documentStatus == 'DocReceived' ? 'selected' : '' ; ?> value="DocReceived">Document Received</option>
                                <option <?php echo $documentStatus == 'DocVerified' ? 'selected' : '' ; ?> value="DocVerified">Document Verified</option>
                                <option <?php echo $documentStatus == 'DocInReview' ? 'selected' : '' ; ?> value="DocInReview">Document In-Review</option>
                                <!-- <option <?php echo $documentStatus == 'DocRejected' ? 'selected' : '' ; ?> value="DocRejected">Document Rejected</option> -->
                                <option <?php echo $documentStatus == 'DocDenied' ? 'selected' : '' ; ?> value="DocDenied">Document Denied</option>
                                <option <?php echo $documentStatus == 'NonCooperative' ? 'selected' : '' ; ?> value="NonCooperative">Non Cooperative</option>
                                <option <?php echo $documentStatus == 'PermissionDenied' ? 'selected' : '' ; ?> value="PermissionDenied">Permission Denied</option>
                                <option <?php echo $documentStatus == 'PermanentlyClosed' ? 'selected' : '' ; ?> value="PermanentlyClosed">Permanently Closed</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-1 col-sm-1 col-md-1 col-12">
                        <input type="hidden" name="pageNo" value="<?php echo $pageNo; ?>">
                        <input type="hidden" name="viewType" value="<?php echo $_SESSION['SAL_View_Type']; ?>">
                        <input type="hidden" name="pageName" value="<?php if(isset($_GET['p'])){ echo $_GET['p']; } ?>" />
                    </div>

                   <!--  <div class="col-md-1 col-12">
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" onclick="setShopSurveyDetailFilter(1)"><i class="fa-solid fa-rotate"></i></button>
                        </div>
                    </div> -->
                    <div class="col-lg-2 col-sm-5 col-md-2 col-12 col-sm-12" style="margin-top: 25px;">
                        <ul class="page-view-area" style="float:right;">
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "GridView"){ ?> active <?php }?>" onclick="setShopSurveyDetailView(<?php echo $pageNo; ?>,'GridView')"><i class="fi-rs-grid"></i></li>
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "ListView"){ ?> active <?php }?>" onclick="setShopSurveyDetailView(<?php echo $pageNo; ?>,'ListView')"><i class="fi-rs-list"></i></li>
                            <li class="page-view-link <?php if(isset($_SESSION['SAL_View_Type']) && $_SESSION['SAL_View_Type'] == "TableView"){ ?> active <?php }?>" onclick="setShopSurveyDetailView(<?php echo $pageNo; ?>,'TableView')"><i class="fa-solid fa-table-list"></i></li>
                        </ul>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="container mb-0 mt-0">
    
    <div class="row product-grid">
        <?php 
            foreach ($shopListDetail as $key => $shopData) {
        ?>
            <div class="col-lg-1-5 col-md-3 col-12 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <a <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( ($documentStatus=="DocVerified" || $documentStatus=="DocReceived") && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)" <?php }else{ ?> href="javascript:void(0);" <?php } ?>  >
                            

                                        <?php 
                                            if (!empty($shopData["ShopOutsideImage1"])) {
                                        ?>
                                                <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage1"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="175" height="150" />      
                                        <?php
                                            }else{
                                        ?>
                                                <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt="" width="175" height="150" />
                                        <?php
                                            }
                                        ?>

                                        <?php 
                                            if (!empty($shopData["ShopOutsideImage2"])) {
                                        ?>
                                                <img class="default-img" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$shopData["ShopOutsideImage2"]; ?>" alt="<?php echo $shopData["ShopName"]; ?>" width="175" height="150" />      
                                        <?php
                                            }else{
                                        ?>
                                                <!-- <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt=""  width="175" height="150" /> -->
                                        <?php
                                            }
                                        ?>
                                    </a>
                                </div>
                                <div class="product-action-1">
                                    <a aria-label="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                    <a aria-label="View Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopQuickViewShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>)"><i class="fi-rs-eye"></i></a>
                                    <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( ($documentStatus=="DocVerified" || $documentStatus=="DocReceived") && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> 
                                        <a title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"><i class="fi-rs-file-check"></i></a>
                                    <?php } ?>
                                </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ($documentStatus=="DocVerified" || $documentStatus=="All" || $documentStatus=="DocReceived") ){ ?> 
                                            <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                    <?php }else if(($shopData["DocFlag"] == 1 || $shopData["DocFlag"] == 0) && $shopData["ShopStatus"] != "Verified" && ($documentStatus=="DocInReview" || $documentStatus=="All" || $documentStatus=="DocReceived")){ ?> 
                                            <span style="background-color: #0BA8E6;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-magnifying-glass-location"></i><?php echo " In-Review"; ?>
                                            </span>
                                    <?php }else if($shopData["DocFlag"] == 0 && $shopData["ShopStatus"] != "Verified" && ($documentStatus=="DocRejected" || $documentStatus=="All" || $documentStatus=="DocReceived")){ ?> 
                                            <span style="background-color: #E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa-solid fa-rectangle-xmark"></i><?php echo " Rejected"; ?>
                                            </span>
                                    <?php }else if($shopData["DocFlag"] == 0 && ($shopData["ShopStatus"] == "" || $shopData["ShopStatus"] == "Pending") && ($documentStatus=="DocPending" || $documentStatus=="All")){ ?> 
                                            <span style="background-color: #E6490B;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="fa fa-exclamation-circle"></i><?php echo " Pending"; ?>
                                            </span>
                                    <?php }else if($shopData["DocFlag"] == 0 && ($documentStatus=="All" || $documentStatus=="DocDenied" || $documentStatus=="NonCooperative" || $documentStatus=="PermissionDenied" || $documentStatus=="PermanentlyClosed")){ ?>
                                            <span style="background-color: <?php echo $shopData["ShopStatusTextColor"]; ?>;color: #FFFFFF;padding: 5px 10px;border-radius: 5px;"><i class="<?php echo $shopData["ShopStatusFaIcon"]; ?>"></i><?php echo " ".$shopData["ShopStatus"]; ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="product-content-wrap">
                                <div class="product-category">
                                    <a href="javascript:void(0);"><?php echo $shopData["ShopAreaName"]; ?></a>
                                </div>
                                <h2>
                                    <?php  if($shopData["DocFlag"] == 1 && $shopData["ShopStatus"] == "Verified" && ( ($documentStatus=="DocVerified" || $documentStatus=="DocReceived") && ( $shopData["ShopApproval"] == "" || $shopData["ShopApproval"] == "Rejected") ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Client' || $_SESSION['SAL_UserType']== 'Admin' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?> 
                                        <a title="Verfify And Approve Shop Detail" aria-label="Verfify And Approve Shop Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewShopDetailModal" onclick="shopVerifyAndApproveShopDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>)"><?php echo $shopData["ShopName"]; ?></a>
                                    <?php }else{ ?>
                                        <?php echo $shopData["ShopName"]; ?>
                                    <?php } ?>
                                </h2>
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
                </div>
            </div>
        <?php
            }
        ?>
                
    </div>

</div>