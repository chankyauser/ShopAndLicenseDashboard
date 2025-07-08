<div class="container mt-10 mb-0">
    <div class="card">
        <div class="card-body">
            <!-- <form class="form-horizontal" novalidate> -->
                <div class="row">
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

                    <!-- <div class="col-lg-6 col-sm-12 col-md-6 col-12 text-right"  style="margin-top: 32px;">
                         <div class="form-group">
                            <label for="refesh" ></label>
                            <button type="button" name="refesh" class="btn btn-primary" onclick="setShopLicenseDefaultersFilter(<?php echo $pageNo; ?>)" >Refresh</button>
                        </div>
                    </div> -->
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<div class="container mb-5 mt-10"> 

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
                                                                <a href="javascript:void(0);">
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
                                                        <h6><a class="inactivelink"><?php if(!trim($shopData["ShopAddress_1"])=="."){ echo $shopData["ShopAddress_1"]; }else{ } ?></a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;"><?php echo $shopData["Ward_No"]." - ".$shopData["WardArea"];  ?> </td>
                                
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
                                    <td style="text-align: center;" class="text-danger"  ><?php echo $shopData["ExpiryDate"]; ?> </td>
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
                                        <?php  if($shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved")  && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserType']== 'Admin' ) ){ ?>
                                            
                                            <h6><a href="javascript:void(0);"><?php if(!empty($shopData["TotalBillAmount"]) && $shopData["Billing_Cd"] !=0 ){ ?> <i class="fa-solid fa-indian-rupee-sign"></i><?php echo IND_money_format($shopData["TotalBillAmount"])."/-"; } ?></a></h6>

                                        <?php } ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a title="Call Shop Keeper" class="action-btn" href="tel:<?php echo $shopData["ShopKeeperMobile"];  ?>"><i class="fa-solid fa-phone"></i></a>
                                        <a title="View Location on Google Map" class="action-btn" href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>" target="_blank"><i class="fi-rs-location-alt"></i></a>
                                        <br/>
                                        <?php if($shopData["ShopStatus"] == "Verified" && $shopData["ShopApproval"] == "Approved" && $shopData["Billing_Cd"] != 0 && $shopData["TransStatus"] != 'Done' && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>

                                                <button title="Pay Shop License Fee" aria-label="Pay Shop License Fee" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payShopLicenseFeeModal" onclick="payShopLicenseFeeDetailModal(<?php echo $shopData["Shop_Cd"]; ?>,<?php echo $pageNo; ?>,<?php echo $shopData["Billing_Cd"]; ?>)">Pay</button>

                                        <?php } ?>

                                        <?php if($shopData["ShopStatus"] == "Verified" && ( $shopData["ShopApproval"] == "Verified" || $shopData["ShopApproval"] == "Approved") && $shopData["IsNewCertificateIssued"] == 1 && $shopData["Billing_Cd"] != 0 && ( !empty($shopData["TransStatus"]) && $shopData["TransStatus"] == 'Done' ) && isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) &&  ( $_SESSION['SAL_UserType']== 'Ward Officer' || $_SESSION['SAL_UserName']== 'RAM_B30' ) ){ ?>

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