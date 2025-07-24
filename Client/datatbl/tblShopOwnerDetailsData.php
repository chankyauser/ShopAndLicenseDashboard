<style>
.shop-badges.bg-brand {
    background-color: #F2F4F3 !important;
    color: #7E7E7E !important;

}

.title-detail .fi,
h5 {
    color: #253D4E !important;
}

.button-secondary {
    background-color: #EF6324 !important;
    border: none;
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

.icon-action {
    font-size: 1.0rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.icon-action:hover {
    opacity: 0.8;
}

.text-primary {
    color: #007bff;
}

.text-success {
    color: #28a745;
}

.text-warning {
    color: #ca4360ff !important;
}



a[data-tooltip] {
    position: relative;
    cursor: pointer;
}


a[data-tooltip]::after {
    content: attr(data-tooltip);
    position: absolute;
    top: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 3px 5px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 10px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

a[data-tooltip]::before {
    content: "";
    position: absolute;
    top: 115%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

a[data-tooltip]:hover::after,
a[data-tooltip]:hover::before {
    opacity: 1;
    pointer-events: auto;
}
</style>
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
            <div class="card pb-10">
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
                                            <img class="default-img" src="../assets/imgs/shopImage.png" alt=""
                                                width="100%" height="100" />
                                            <?php
                                                }
                                            ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-10">
                            <div class="product-cart-wrap">
                                <div class="product-content-wrap">
                                    <h2><?php echo $shopData["ShopName"]; ?></h2>
                                    <div class="shop-info-row">
                                        <div class="shop-tags">
                                            <span
                                                class="shop-badges bg-brand"><?php echo $shopData["BusinessCatName"]; ?></span>
                                            <span
                                                class="shop-badges bg-brand"><?php echo $shopData["ShopAreaName"]; ?></span>
                                            <span
                                                class="shop-badges bg-brand"><?php echo $shopData["ShopCategory"]; ?></span>
                                        </div>
                                        <div class="d-flex gap-3 mt-auto p-2">
                                            <a data-tooltip="Shop Owner Details" style="margin-right: 12px;"
                                                target="_blank"
                                                onclick="redirectPage(<?php echo $shopData['ShopKeeperMobile']; ?>)">
                                                <!-- <i class="fas fa-user text-primary icon-action"
                                                    onclick="redirectPage(< ?php echo $shopData['ShopKeeperMobile']; ?>)"></i> -->
                                                <svg width="32px" height="32px" viewBox="0 0 1024 1024" class="icon"
                                                    version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M838.4 819.2c0 14.08-11.52 25.6-25.6 25.6h-563.2c-14.08 0-25.6-11.52-25.6-25.6V243.2c0-14.08 11.52-25.6 25.6-25.6h563.2c14.08 0 25.6 11.52 25.6 25.6v576z"
                                                            fill="#F7E6A3"></path>
                                                        <path
                                                            d="M812.8 857.6h-563.2c-21.76 0-38.4-16.64-38.4-38.4V243.2c0-21.76 16.64-38.4 38.4-38.4h563.2c21.76 0 38.4 16.64 38.4 38.4v576c0 21.76-16.64 38.4-38.4 38.4z m-563.2-627.2c-7.68 0-12.8 5.12-12.8 12.8v576c0 7.68 5.12 12.8 12.8 12.8h563.2c7.68 0 12.8-5.12 12.8-12.8V243.2c0-7.68-5.12-12.8-12.8-12.8h-563.2z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M224 512m-76.8 0a76.8 76.8 0 1 0 153.6 0 76.8 76.8 0 1 0-153.6 0Z"
                                                            fill="#E42710"></path>
                                                        <path
                                                            d="M224 601.6c-49.92 0-89.6-39.68-89.6-89.6s39.68-89.6 89.6-89.6 89.6 39.68 89.6 89.6-39.68 89.6-89.6 89.6z m0-153.6c-35.84 0-64 28.16-64 64s28.16 64 64 64 64-28.16 64-64-28.16-64-64-64z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M838.4 512m-76.8 0a76.8 76.8 0 1 0 153.6 0 76.8 76.8 0 1 0-153.6 0Z"
                                                            fill="#E42710"></path>
                                                        <path
                                                            d="M838.4 601.6c-49.92 0-89.6-39.68-89.6-89.6s39.68-89.6 89.6-89.6 89.6 39.68 89.6 89.6-39.68 89.6-89.6 89.6z m0-153.6c-35.84 0-64 28.16-64 64s28.16 64 64 64 64-28.16 64-64-28.16-64-64-64z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M761.6 691.2c0 14.08-11.52 25.6-25.6 25.6h-409.6c-14.08 0-25.6-11.52-25.6-25.6V358.4c0-14.08 11.52-25.6 25.6-25.6h409.6c14.08 0 25.6 11.52 25.6 25.6v332.8z"
                                                            fill="#6FB0BE"></path>
                                                        <path
                                                            d="M736 729.6h-409.6c-21.76 0-38.4-16.64-38.4-38.4V358.4c0-21.76 16.64-38.4 38.4-38.4h409.6c21.76 0 38.4 16.64 38.4 38.4v332.8c0 21.76-16.64 38.4-38.4 38.4z m-409.6-384c-7.68 0-12.8 5.12-12.8 12.8v332.8c0 7.68 5.12 12.8 12.8 12.8h409.6c7.68 0 12.8-5.12 12.8-12.8V358.4c0-7.68-5.12-12.8-12.8-12.8h-409.6z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M531.2 512m-76.8 0a76.8 76.8 0 1 0 153.6 0 76.8 76.8 0 1 0-153.6 0Z"
                                                            fill="#E42710"></path>
                                                        <path
                                                            d="M531.2 601.6c-49.92 0-89.6-39.68-89.6-89.6s39.68-89.6 89.6-89.6 89.6 39.68 89.6 89.6-39.68 89.6-89.6 89.6z m0-153.6c-35.84 0-64 28.16-64 64s28.16 64 64 64 64-28.16 64-64-28.16-64-64-64z"
                                                            fill="#231C1C"></path>
                                                        <path d="M915.2 512h-768l51.2-230.4h665.6z" fill="#E42710">
                                                        </path>
                                                        <path
                                                            d="M915.2 524.8h-768c-3.84 0-7.68-1.28-10.24-5.12-2.56-2.56-3.84-6.4-2.56-10.24l51.2-230.4c1.28-6.4 6.4-10.24 12.8-10.24h665.6c6.4 0 11.52 3.84 12.8 10.24l51.2 230.4c1.28 3.84 0 7.68-2.56 10.24-2.56 3.84-6.4 5.12-10.24 5.12z m-752.64-25.6h736l-46.08-204.8H208.64l-46.08 204.8z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M377.6 512m-76.8 0a76.8 76.8 0 1 0 153.6 0 76.8 76.8 0 1 0-153.6 0Z"
                                                            fill="#FAF1C7"></path>
                                                        <path
                                                            d="M377.6 601.6c-49.92 0-89.6-39.68-89.6-89.6s39.68-89.6 89.6-89.6 89.6 39.68 89.6 89.6-39.68 89.6-89.6 89.6z m0-153.6c-35.84 0-64 28.16-64 64s28.16 64 64 64 64-28.16 64-64-28.16-64-64-64z"
                                                            fill="#231C1C"></path>
                                                        <path
                                                            d="M684.8 512m-76.8 0a76.8 76.8 0 1 0 153.6 0 76.8 76.8 0 1 0-153.6 0Z"
                                                            fill="#FAF1C7"></path>
                                                        <path
                                                            d="M684.8 601.6c-49.92 0-89.6-39.68-89.6-89.6s39.68-89.6 89.6-89.6 89.6 39.68 89.6 89.6-39.68 89.6-89.6 89.6z m0-153.6c-35.84 0-64 28.16-64 64s28.16 64 64 64 64-28.16 64-64-28.16-64-64-64z"
                                                            fill="#231C1C"></path>
                                                        <path d="M454.4 512h-153.6l25.6-230.4h140.8z" fill="#FAF1C7">
                                                        </path>
                                                        <path
                                                            d="M454.4 524.8h-153.6c-3.84 0-7.68-1.28-8.96-3.84-2.56-2.56-3.84-6.4-2.56-10.24l25.6-230.4c1.28-6.4 6.4-11.52 12.8-11.52h140.8c3.84 0 6.4 1.28 8.96 3.84 2.56 2.56 3.84 6.4 3.84 8.96l-12.8 230.4c-1.28 7.68-7.68 12.8-14.08 12.8z m-139.52-25.6h126.72l11.52-204.8h-115.2l-23.04 204.8z"
                                                            fill="#231C1C"></path>
                                                        <path d="M761.6 512h-153.6l-12.8-230.4h140.8z" fill="#FAF1C7">
                                                        </path>
                                                        <path
                                                            d="M761.6 524.8h-153.6c-6.4 0-12.8-5.12-12.8-11.52l-12.8-230.4c0-3.84 1.28-6.4 3.84-8.96 2.56-2.56 6.4-3.84 8.96-3.84h140.8c6.4 0 11.52 5.12 12.8 11.52l25.6 230.4c0 3.84-1.28 7.68-2.56 10.24s-6.4 2.56-10.24 2.56z m-142.08-25.6h126.72l-23.04-204.8h-115.2l11.52 204.8z"
                                                            fill="#231C1C"></path>
                                                    </g>
                                                </svg>
                                            </a>

                                            <a data-tooltip="Update Delivery Status" style="margin-right: 12px;"
                                                onclick="DeliveryStatus(<?php echo $shopData['Shop_Cd']; ?>)">
                                                <!-- <i class="fas fa-truck-loading text-success icon-action"
                                                    onclick="DeliveryStatus(< ?php echo $shopData['Shop_Cd']; ?>)"></i> -->
                                                <svg width="32px" height="32px" viewBox="0 0 32 32"
                                                    xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <defs>
                                                            <style>
                                                            .cls-1 {
                                                                fill: #f2d8c2;
                                                            }

                                                            .cls-2 {
                                                                fill: #568c78;
                                                            }
                                                            </style>
                                                        </defs>
                                                        <title></title>
                                                        <g data-name="Layer 3" id="Layer_3">
                                                            <path class="cls-1"
                                                                d="M26.72,8.38,20.85,2.31A1,1,0,0,0,20.13,2H6A1,1,0,0,0,5,3V29a1,1,0,0,0,1,1H26a1,1,0,0,0,1-1V9.08A1,1,0,0,0,26.72,8.38Z">
                                                            </path>
                                                            <path class="cls-2"
                                                                d="M26.71,8.29l-6-6a1,1,0,0,0-1.09-.21A1,1,0,0,0,19,3V9a1,1,0,0,0,1,1h6a1,1,0,0,0,.92-.62A1,1,0,0,0,26.71,8.29Z">
                                                            </path>
                                                            <path class="cls-2"
                                                                d="M22,18H10a1,1,0,0,1,0-2H22a1,1,0,0,1,0,2Z"></path>
                                                            <path class="cls-2"
                                                                d="M22,14H10a1,1,0,0,1,0-2H22a1,1,0,0,1,0,2Z"></path>
                                                            <path class="cls-2"
                                                                d="M22,22H10a1,1,0,0,1,0-2H22a1,1,0,0,1,0,2Z"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>

                                            <a data-tooltip="View Notice" style="margin-right: 12px;">
                                                <i class="fas fa-eye text-warning icon-action"
                                                    onclick="ShopNoticeDetails(<?php echo $shopData['Shop_Cd']; ?>)"></i>
                                            </a>
                                        </div>

                                    </div>

                                    <h5 class="title-detail"><i class="fi-rs-smartphone"></i>
                                        <?php echo $shopData["ShopKeeperName"];  ?> -
                                        <?php echo $shopData["ShopKeeperMobile"];  ?></h5>
                                    <h6 class="title-detail"><i class="fi-rs-location-alt"></i>
                                        <?php echo $shopData["NodeName"] . " :  "."Ward : ".$shopData["Ward_No"]." - ".$shopData["WardArea"];  ?>
                                    </h6>

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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 80% !important;">
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
<div class="modal fade" id="NoticeDetailModal" tabindex="-1" aria-labelledby="NoticeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl modal-dialog-centered" style="width : 60%">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="NoticeModalLabel">Notice Details</h5>
                <button type="button" class="btn-close p-3 closetrans" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="NoticeModalBody">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => {
        new bootstrap.Tooltip(el);
    });
});

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


function DeliveryStatus(shopCd) {
    $('#NoticeDetailModal').modal('hide');
    $.ajax({
        url: 'NoticeDeliveryForm.php',
        method: 'POST',
        data: {
            Shop_Cd: shopCd
        },
        success: function(html) {
            $('#NoticeDeliveryStatusModal').modal('show');
            $('#NoticeStatusModalBody').html(html);
        }
    });
}


// function ShopNoticeDetails(Shop_Cd) {
//     $('#NoticeDeliveryStatusModal').modal('hide');
//     $('#NoticeDetailModal').modal('show');
//     $('#NoticeDetailModal').data('shop-cd', Shop_Cd);
//     $.ajax({
//         type: "POST",
//         url: 'ShopNoticeDeliveryDetails.php',
//         data: {
//             shopCd: Shop_Cd
//         },
//         success: function(response) {
//             $('#NoticeModalBody').html(response);
//         },
//         error: function() {
//             $('#NoticeModalBody').html(
//                 '<div class="alert alert-danger">Error retrieving shop notice details.</div>');
//         }
//     });
// }


function editNotice(noticeId) {
    $('#NoticeDetailModal').one('hidden.bs.modal', function() {
        $('#NoticeDeliveryStatusModal .modal-dialog')
            .removeClass('modal-sm modal-lg modal-xl')
            .addClass('modal-lg custom-fullwidth');

        $('#NoticeStatusModalBody').html(
            '<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');


        $('#NoticeDeliveryStatusModal').modal('show');

        $.ajax({
            url: 'NoticeDeliveryForm.php',
            type: 'POST',
            data: {
                Notice_Id: noticeId
            },
            success: function(response) {
                $('#NoticeStatusModalBody').html(response);
            },
            error: function() {
                $('#NoticeStatusModalBody').html(
                    '<div class="alert alert-danger">Failed to load notice data for editing.</div>'
                );
            }
        });
    });

    $('#NoticeDetailModal').modal('hide');
}

// function refreshNoticeDetails() {
//     if ($('#NoticeDetailModal').hasClass('show')) {
//         var shopCd = $('#NoticeDetailModal').data('shop-cd');

//         if (shopCd) {
//             ShopNoticeDetails(shopCd);
//         }
//     }
// }

function refreshNoticeDetails() {
    if ($('#NoticeDetailModal').hasClass('show')) {
        var shopCd = $('#NoticeDetailModal').data('shop-cd');

        if (shopCd) {
            // Show a loading indicator before making the request
            $('#NoticeModalBody').html(
                '<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');

            // Call ShopNoticeDetails to refresh content
            ShopNoticeDetails(shopCd);
        }
    }
}

function ShopNoticeDetails(Shop_Cd) {
    $('#NoticeDetailModal').data('shop-cd', Shop_Cd);

    $('#NoticeDetailModal').modal('show');

    $.ajax({
        type: "POST",
        url: 'ShopNoticeDeliveryDetails.php',
        data: {
            shopCd: Shop_Cd
        },
        success: function(response) {
            // if ($('#NoticeDetailModal').hasClass('show')) {
            $('#NoticeModalBody').html(response);
            // }
        },
        error: function() {
            if ($('#NoticeDetailModal').hasClass('show')) {
                $('#NoticeModalBody').html(
                    '<div class="alert alert-danger">Error retrieving shop notice details.</div>');
            }
        }
    });
}


function clearFilter() {
    $('#nodeName').val('All');
    $('#setNodeAndWardDetailId').val('All');
    $('#ShopName').val('');
    $('#OwnerName').val('');
    $('#OwnerMobile').val('');
    setShopOwnerDetailFilter(1);
}
</script>