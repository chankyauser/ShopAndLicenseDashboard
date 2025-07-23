<div class="container mt-10 mb-0">
    <div class="card">
        <div class="card-body">
            <div class="row" style="margin-top:-10px">
                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Zone</label>
                        <select class="form-control" name="nodeName" id="nodeName"
                            onchange="setShopOwnerDetailFilter(<?php echo "1"; ?>)">
                            <option value="All">All Zone </option>
                            <?php 
                                    foreach ($dataNodeName as $key => $valueNodeName) {
                                        if($nodeName==$valueNodeName["NodeName"]){
                                ?>
                            <option selected value="<?php echo $valueNodeName["NodeName"]; ?>">
                                <?php echo "".$valueNodeName["NodeName"]; ?></option>
                            <?php
                                        }else{
                                 ?>
                            <option value="<?php echo $valueNodeName["NodeName"]; ?>">
                                <?php echo "".$valueNodeName["NodeName"]; ?></option>
                            <?php            
                                        }
                                    }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Ward</label>
                        <select class="form-control" name="nodeCd" id="setNodeAndWardDetailId"
                            onchange="setShopOwnerDetailFilter(<?php echo "1"; ?>)">
                            <option value="All">All Ward </option>
                            <?php 
                                    
                                    foreach ($dataNode as $key => $valueNode) {
                                        if($nodeCd==$valueNode["Node_Cd"]){
                                ?>
                            <option selected value="<?php echo $valueNode["Node_Cd"]; ?>">
                                <?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                            <?php
                                        }else{
                                 ?>
                            <option value="<?php echo $valueNode["Node_Cd"]; ?>">
                                <?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                            <?php            
                                        }
                                    }
                                ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Name</label>
                        <input type="text" class="form-control" name="ShopName" id="ShopName"
                            value="<?php if(isset($_SESSION['SAL_Shop_Name']) && !empty($_SESSION['SAL_Shop_Name']) && $_SESSION['SAL_Shop_Name'] != 'All' && $_SESSION['SAL_Shop_Name'] != 'undefined'){ echo $_SESSION['SAL_Shop_Name']; } ?>"
                            placeholder="Shop name (min 3 letters)" style="border: 1px solid #F01954;"
                            onkeyup="if(this.value.trim().length >= 3 || this.value.trim().length === 0) setShopOwnerDetailFilter(1);">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Owner Name</label>
                        <input type="text" class="form-control" name="OwnerName" id="OwnerName"
                            value="<?php if(isset($_SESSION['SAL_search_Owner_Name']) && !empty($_SESSION['SAL_search_Owner_Name']) && $_SESSION['SAL_search_Owner_Name'] != 'undefined'){ echo $_SESSION['SAL_search_Owner_Name']; } ?>"
                            placeholder="Owner name (min 3 letters)" style="border: 1px solid #F01954;"
                            onkeyup="if(this.value.trim().length >= 3 || this.value.trim().length === 0) setShopOwnerDetailFilter(1);">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Owner Mobile</label>
                        <input type="text" class="form-control" name="OwnerMobile" id="OwnerMobile"
                            placeholder="Search Owner Mobile No..." maxlength="10"
                            value="<?php if(isset($_SESSION['SAL_search_mobile']) && !empty($_SESSION['SAL_search_mobile']) && $_SESSION['SAL_search_mobile'] != 'undefined'){ echo $_SESSION['SAL_search_mobile']; } ?>"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) " onkeyup="
                            setTimeout(function() {
                                if (event.target.value.trim().length >= 10 || event.target.value.trim().length === 0) {
                                    setShopOwnerDetailFilter(1);
                                }
                            }, 100);" style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12" style="margin-top: 2rem;">
                    <div class="form-group">
                        <button class="btn btn-sm btn-danger" id="clearFilter" onclick="clearFilter()">Clear</button>
                    </div>
                </div>

                <div class="col-lg-1 col-sm-1 col-md-1 col-12">
                    <input type="hidden" name="pageNo" value="<?php echo $pageNo; ?>">
                    <input type="hidden" name="pageName" value="<?php if(isset($_GET['p'])){ echo $_GET['p']; } ?>" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-0 mt-10">
    <div class="row">
        <?php 
            foreach ($shopListDetail as $key => $shopData) {
        ?>
        <div class="col-lg-6 mt-0 mb-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-xl-2">
                            <div class="product-cart-wrap">
                                <div class="product-img-action-wrap" style="cursor: pointer;">
                                    <div class="product-img product-img-zoom">
                                        <div class="product-img-inner">
                                            <?php 
                                                if (!empty($shopData["ShopOutsideImage1"])) {
                                            ?>
                                            <img class="default-img" src="<?php echo $shopData["ShopOutsideImage1"]; ?>"
                                                alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />
                                            <?php
                                                }else if (!empty($shopData["ShopOutsideImage2"])) {
                                            ?>
                                            <img class="default-img" src="<?php echo $shopData["ShopOutsideImage2"]; ?>"
                                                alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />
                                            <?php
                                                }else{
                                            ?>
                                            <img class="default-img" src="assets/imgs/shop/product-1-1.jpg" alt=""
                                                width="100%" height="150" />
                                            <?php
                                                }
                                            ?>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- <div class="product-action-1">
                                        <a aria-label="View Location on Google Map" class="action-btn"
                                            href="< ?php echo 'https://www.google.com/maps/search/?api=1&query='.$shopData['Latitude'].','.$shopData['Longitude'].'' ; ?>"
                                            target="_blank"><i class="fi-rs-location-alt"></i></a>
                                        <a aria-label="Quick View Shop Detail" class="action-btn" data-bs-toggle="modal"
                                            data-bs-target="#quickViewShopDetailModal"
                                            onclick="shopQuickViewShopDetailModal(< ?php echo $shopData["Shop_Cd"]; ?>)"><i
                                                class="fi-rs-eye"></i></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-10">
                            <div class="product-cart-wrap">
                               <div class="product-content-wrap">
                                    <h2><?php echo $shopData["ShopName"]; ?></h2>
                                    <!-- <span class="shop-badges bg-brand"> <?php //echo $shopData["BusinessCatName"]; ?></span> 
                                    <span class="shop-badges bg-brand"> <?php //echo $shopData["ShopAreaName"]; ?></span> 
                                    <span class="shop-badges bg-brand"> <?php //echo $shopData["ShopCategory"]; ?></span>
                                    <button class="btn btn-sm" id="ViewNotice" onclick="DeliveryStatus(<?php// echo $shopData['Shop_Cd'];  ?>)">ViewNotice</button> -->
                                    <div class="shop-info-row">
                                        <div class="shop-tags">
                                            <span class="shop-badges bg-brand"><?php echo $shopData["BusinessCatName"]; ?></span> 
                                            <span class="shop-badges bg-brand"><?php echo $shopData["ShopAreaName"]; ?></span> 
                                            <span class="shop-badges bg-brand"><?php echo $shopData["ShopCategory"]; ?></span>
                                        </div>
                                        <i class="fas fa-eye view-notice-icon" onclick="ShopNoticeDetails(<?php echo $shopData['Shop_Cd']; ?>)" title="View Notice"></i>
                                    </div>

                                    <h5 class="title-detail"><i class="fi-rs-smartphone"></i>
                                        <?php echo $shopData["ShopKeeperName"];  ?> -
                                        <?php echo $shopData["ShopKeeperMobile"];  ?></h5>
                                    <h6 class="title-detail"><i class="fi-rs-location-alt"></i>
                                        <?php echo $shopData["NodeName"] . " :  "."Ward : ".$shopData["Ward_No"]." - ".$shopData["WardArea"];  ?>
                                    </h6>
                                    <div class="d-flex gap-2"> <!-- flex container for buttons -->
                                        <button class="btn btn-sm button-secondary" id="redirectShopDetailsPage" onclick="redirectPage(<?php echo $shopData["ShopKeeperMobile"];  ?>)">Shop Owner Details</button>
                                        <button class="btn btn-sm btn-danger" id="shopNoticeUpdate" onclick="DeliveryStatus(<?php echo $shopData['Shop_Cd'];  ?>)">Notice Delivery Status</button>
                                    </div>
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


<!-- Shop Notice Details Modal -->

<div class="modal fade" id="NoticeDeliveryStatusModal" tabindex="-1" aria-labelledby="NoticeDeliveryStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="NoticeDeliveryStatusModalLabel">Notice Delivery Status</h5>
                <button type="button" class="btn-close p-3 closetrans" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body mb-3" id="NoticeStatusModalBody">
            </div>
        </div>
    </div>
</div>

<!-- View Notice Details Modal -->

<div class="modal fade" id="NoticeDetailModal" tabindex="-1" aria-labelledby="NoticeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="NoticeModalLabel">Notice Details</h5>
                <button type="button" class="btn-close p-3 closetrans" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body mb-3" id="NoticeModalBody">
            </div>
        </div>
    </div>
</div>

<style>
   
   /* .modal-dialog {
        max-width: 80% !important;
        margin: 1.75rem auto;
    } */
    .shop-badges.bg-brand {
        background-color: #F2F4F3 !important;
        color:#7E7E7E !important;
      
    }
    .title-detail .fi, h5{
        color:#253D4E !important;
    }
    .button-secondary{
        background-color:#EF6324 !important;
        border:none;
    }
    .shop-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .shop-tags {
        display: flex;
        gap: 8px; 
        flex-wrap: wrap;
    }
    .view-notice-icon {
        font-size: 15px;
        cursor: pointer;
        color: #0066ffff;
        padding: 5px;
        transition: color 0.2s ease;
    }
    #NoticeDetailModal {
        z-index: 1055 !important;
    }

    #NoticeDetailModal + .modal-backdrop {
        z-index: 1050 !important;
        background-color: transparent !important;
    }

    body.modal-open #NoticeDetailModal ~ .modal-backdrop {
        z-index: 1050 !important;
       background-color: transparent !important;
    }

    .modal-lg, .modal-xl {
        max-width: 60% !important;
    }

    .modal-lg.custom-fullwidth {
        max-width: 100% !important; /* adjust as needed */
        width: 100%;
    }
    @media (max-width: 768px) {
        .modal-lg.custom-fullwidth {
            max-width: 95% !important;
            width: 95%;
            margin: auto;
        }

        .modal-content {
            padding: 10px;
        }

        .modal-body {
            overflow-x: auto;
        }
    }

</style>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function redirectPage(ShopKeeperMobile) {
    $.ajax({
        url: 'redirectShopDetailsPage.php',
        method: 'GET',
        data: {
            ShopKeeperMobile: ShopKeeperMobile
        },
        success: function(response) {
            window.open('../index.php?p=ShopDetalisListOfOwner', '_blank');
        },
    });
}


    $('#clearFilter').on('click', function() {
        $('#nodeName').val('All');
        $('#setNodeAndWardDetailId').val('All');
        $('#ShopName').val('');
        $('#OwnerName').val('');
        $('#OwnerMobile').val('');
        setShopOwnerDetailFilter(1);
    });
    $('#NoticeDetailModal').on('hidden.bs.modal', function () {
        // Remove any lingering backdrop
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });

    $('#NoticeDeliveryStatusModal').on('hidden.bs.modal', function () {
        // Remove any lingering backdrop
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
  
});

function DeliveryStatus(shopCd) {
     $('#NoticeDetailModal').modal('hide'); 
    $.ajax({
        url: 'NoticeDeliveryForm.php', 
        method: 'POST',
        data: { Shop_Cd: shopCd },
        success: function (html) {
            $('#NoticeDeliveryStatusModal').modal('show');
            $('#NoticeStatusModalBody').html(html);
        }
    });
}


function ShopNoticeDetails(Shop_Cd) {
    $('#NoticeDeliveryStatusModal').modal('hide');
    $('#NoticeDetailModal .modal-dialog')
            .removeClass('modal-sm modal-lg modal-xl')
            .addClass('modal-lg custom-fullwidth');
    $('#NoticeDetailModal').data('shop-cd', Shop_Cd);
        
    $('#NoticeStatusModalBody').html('<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');
    $('#NoticeModalBody').html('<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');
    $('#NoticeDetailModal').modal('show'); 
    
    $.ajax({
        type: "POST",
        url: 'ShopNoticeDeliveryDetails.php',
        data: { shopCd: Shop_Cd },
        success: function(response) {
            $('#NoticeModalBody').html(response); 
        },
        error: function() {
            $('#NoticeModalBody').html('<div class="alert alert-danger">Error retrieving shop notice details.</div>');
        }
    });
}
// function editNotice(noticeId) {
//     $('#NoticeDetailModal').modal('hide');
  
//     $('#NoticeStatusModalBody').html('<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');
//     $('#NoticeDeliveryStatusModal').modal('show');
 
//     $.ajax({
//         url: 'NoticeDeliveryForm.php',
//         type: 'POST',
//         data: { Notice_Id: noticeId },
//         success: function(response) {
//             $('#NoticeStatusModalBody').html(response);
//         },
//         error: function() {
//             $('#NoticeStatusModalBody').html('<div class="alert alert-danger">Failed to load notice data for editing.</div>');
//         }
//     });
// }


function editNotice(noticeId) {
    $('#NoticeDetailModal').one('hidden.bs.modal', function() {
        $('#NoticeDeliveryStatusModal .modal-dialog')
            .removeClass('modal-sm modal-lg modal-xl')
            .addClass('modal-lg custom-fullwidth');
        $('#NoticeStatusModalBody').html('<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');

        $('#NoticeDeliveryStatusModal').modal('show');

        $.ajax({
            url: 'NoticeDeliveryForm.php',
            type: 'POST',
            data: { Notice_Id: noticeId },
            success: function(response) {
                $('#NoticeStatusModalBody').html(response);
            },
            error: function() {
                $('#NoticeStatusModalBody').html('<div class="alert alert-danger">Failed to load notice data for editing.</div>');
            }
        });
    });
    $('#NoticeDetailModal').modal('hide');
}
function refreshNoticeDetails() {
    if ($('#NoticeDetailModal').hasClass('show')) {
        var shopCd = $('#NoticeDetailModal').data('shop-cd');
        if (shopCd) {
            ShopNoticeDetails(shopCd);
        }
    }
}

</script>