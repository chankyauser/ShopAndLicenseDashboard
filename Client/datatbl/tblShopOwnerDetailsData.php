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
                            value="<?php if(isset($_SESSION['SAL_Shop_Name']) && !empty($_SESSION['SAL_Shop_Name'])){ echo $_SESSION['SAL_Shop_Name']; } ?>"
                            placeholder="Search Shop Name..." style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Owner Name</label>
                        <input type="text" class="form-control" name="OwnerName" id="OwnerName"
                            value="<?php if(isset($_SESSION['SAL_search_Owner_Name']) && !empty($_SESSION['SAL_search_Owner_Name'])){ echo $_SESSION['SAL_search_Owner_Name']; } ?>"
                            placeholder="Search Owner Name..." style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Owner Mobile</label>
                        <input type="text" class="form-control" name="OwnerMobile" id="OwnerMobile"
                            placeholder="Search Owner Mobile No..." maxlength="10"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) "
                            style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 col-12" style="margin-top: 2rem;">
                    <div class="form-group">
                        <button class="btn btn-sm btn-danger" id="clearFilter">Clear</button>
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
        <div class="col-lg-3-6 mt-0 mb-10">
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
                        <div class="col-12 col-xl-4">
                            <div class="product-cart-wrap">
                                <div class="product-content-wrap">
                                    <h2><?php echo $shopData["ShopName"]; ?></h2>
                                    <span class="shop-badges bg-brand"> <?php echo $shopData["BusinessCatName"]; ?>
                                    </span> <span class="shop-badges bg-brand"> <?php echo $shopData["ShopAreaName"]; ?>
                                    </span> <span class="shop-badges bg-brand"> <?php echo $shopData["ShopCategory"]; ?>
                                    </span>

                                    <h5 class="title-detail"><i class="fi-rs-smartphone"></i>
                                        <?php echo $shopData["ShopKeeperName"];  ?> -
                                        <?php echo $shopData["ShopKeeperMobile"];  ?></h5>
                                    <h6 class="title-detail"><i class="fi-rs-location-alt"></i>
                                        <?php echo $shopData["NodeName"] . " :  "."Ward : ".$shopData["Ward_No"]." - ".$shopData["WardArea"];  ?>
                                    </h6>

                                     <button class="btn btn-sm btn-danger" id="redirectShopDetailsPage" onclick="redirectPage(<?php echo $shopData["ShopKeeperMobile"];  ?>)">Shop Owner Details</button>
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

<script>
$(document).ready(function() {
    $('#ShopName, #OwnerName').on('keypress input', function(e) {
        let inputVal = $(this).val().trim();

        if (e.which === 13 || inputVal.length === 0) {
            if (inputVal.length >= 3 || inputVal.length === 0) {
                setShopOwnerDetailFilter(1);
            }
        }
    });


    $('#OwnerMobile').on('keypress input', function(e) {
        let inputVal = $(this).val().trim();
        if (e.which === 13 || inputVal.length === 0) {
            if (inputVal.length === 10 && /^[0-9]{10}$/.test(inputVal)) {
                setShopOwnerDetailFilter(1);
            } else if (inputVal.length === 0) {
                setShopOwnerDetailFilter(1);
            }
        }
    });

    $('#clearFilter').on('click', function() {
        $('#nodeName').val('All');
        $('#setNodeAndWardDetailId').val('All');
        $('#ShopName').val('');
        $('#OwnerName').val('');
        $('#OwnerMobile').val('');
        setShopOwnerDetailFilter(1);
    });
});

function redirectPage(ShopKeeperMobile){
    
        
        $.ajax({
            url: 'redirectShopDetailsPage.php', 
            method: 'GET',
            data: { ShopKeeperMobile: ShopKeeperMobile }, 
            success: function(response) {
               window.open('../index.php?p=ShopDetalisListOfOwner', '_blank');
            },
        });
}
</script>