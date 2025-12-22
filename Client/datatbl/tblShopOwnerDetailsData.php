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
.addbtn {
    background-color: #007bff; 
    color: #FFFFFF;           
    border: none;             
}

.addbtn:hover {
    background-color: #0069d9; 
    color: #FFFFFF;
}
.status-icon-wrapper {
    position: relative;
    display: inline-block;
    cursor: pointer;
    margin-left: 8px; 
    vertical-align: middle;
    color: #dd0e0e;
    font-size: 5px;
}

.tooltip-box::before {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}




.tooltip-line {
    display: block;
    margin-bottom: 4px;
    font-size: 12px;
}

.tooltip-line strong {
    display: inline;
    color: #ffb3b3;
    margin-right: 4px;
}


.hold-tooltip .tooltip-line {
    display: block;
    /* margin-left: 5px; */
    text-align: left;
}

.hold-tooltip strong {
    display: inline-block;
    font-weight: bold;
    color: #ffd166;
}


.status-icon-wrapper i {
    font-size: 14px;
    vertical-align: middle;
}

.tooltip-box {
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 13px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 9999;
    min-width: 220px;
    max-width: 350px;
    white-space: normal;
    text-align: left;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}


.status-icon-wrapper:hover .tooltip-box {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.approval-box-content,
.title-detail {
    overflow: visible !important;
}
.product-img,
.product-img-inner,
.product-img-action-wrap,
.product-cart-wrap {
    overflow: visible !important; 
}

.zoom-hover {
    transition: transform 0.4s ease;
    cursor: pointer;
    position: relative;
    z-index: 10;
}

.zoom-hover:hover {
    transform: scale(1.8);
    z-index: 9999; 
}
.approval-box {
    border: 1px solid #1c222bff; 
    border-radius: 8px;
    padding: 5px;
    margin-top: 20px;
    position: relative;
    background: #ffffff;
}

.approval-box-title {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 0 10px;
    font-weight: 700;
    color: #1a4b95;
    font-size: 16px;
}

.approval-box-content {
    margin-top: 1px;
}

/* .status-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-left: 5px;
} */

/* .tooltip-box {
    display: none;
    position: absolute;
    top: 20px;
    left: 0;
    background: #fff;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    z-index: 999;
    width: 220px;
    font-size: 12px;
} */

.status-icon-wrapper:hover .tooltip-box {
    display: block;
}

.tooltip-line {
    display: block;
    margin-bottom: 3px;
}

#popupBox {
    display: none; 
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    background-color: white;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 8px;
    z-index: 1050;
}

#popupBox ul {
    padding-left: 20px;
}
#popupBox li {
    color: black;
}
#popupBox button {
    margin-top: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
    float:right;
}



#popupOverlay {
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}


</style>
<?php

function shortRoleName($roleName) {
   
    $roleName = trim(preg_replace('/\s+/', ' ', $roleName));
    $words = explode(" ", $roleName);
    if (count($words) == 1) {
        return $words[0];
    }
    $shortParts = [];
    foreach ($words as $w) {
        $shortParts[] = substr($w, 0, 3);
    }

    return implode(" ", $shortParts);
}
?>
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
                            placeholder="Please Enter Shop name " style="border: 1px solid #F01954;">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Shop Owner Name</label>
                        <input type="text" class="form-control" name="OwnerName" id="OwnerName"
                            value="<?php if(isset($_SESSION['SAL_search_Owner_Name']) && !empty($_SESSION['SAL_search_Owner_Name']) && $_SESSION['SAL_search_Owner_Name'] != 'undefined'){ echo $_SESSION['SAL_search_Owner_Name']; } ?>"
                            placeholder="Please Enter Owner name " style="border: 1px solid #F01954;">
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
                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                </div>
                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Role Name</label>
                        <select class="form-control" name="roleCd" id="setShopdetailroleCd"
                            onchange="setShopOwnerDetailFilter(<?php echo "1"; ?>)">
                            <?php
                            $electionName = $_SESSION['SAL_ElectionName'];
                            $developmentMode = $_SESSION['SAL_DevelopmentMode'];
                            $loggedRoleName = isset($_SESSION['SAL_RoleName']) ? $_SESSION['SAL_RoleName'] : '';
                            $loggedRoleId = isset($_SESSION['SAL_RoleId']) ? $_SESSION['SAL_RoleId'] : '';
                            // echo $loggedRoleId;exit;
                            
                            $statusQuery = "SELECT 
                                                            aas.Approval_Stage_Id,
                                                            aas.Role_Id,
                                                            dm.DValue AS Role_Name
                                                        FROM Application_Approval_Stages as aas
                                                        LEFT JOIN DropDownMaster AS dm ON aas.Role_Id = dm.DropDown_Cd 
                                                        
														";

                            $db = new DbOperation();
                            $statusData = $db->ExecutveQueryMultipleRowSALData($statusQuery, $electionName, $developmentMode);

                            $loggedApprovalStageId = '';
                            if (!empty($statusData)) {
                                foreach ($statusData as $role) {
                                    if (trim($loggedRoleId) == trim($role['Role_Id'])) {
                                        $loggedApprovalStageId = $role['Approval_Stage_Id'];
                                        break;
                                    }
                                }
                            }


                            $selectedRole = '';
                            if (
                                isset($_SESSION['SAL_search_Role_Name']) && !empty($_SESSION['SAL_search_Role_Name']) &&
                                isset($_SESSION['SAL_approval_stage_id']) && !empty($_SESSION['SAL_approval_stage_id'])
                            ) {

                                $selectedRole = $_SESSION['SAL_approval_stage_id'] . '~' . $_SESSION['SAL_search_Role_Name'];
                            } else {

                                $selectedRole = $loggedApprovalStageId . '~' . $loggedRoleId;

                                $_SESSION['SAL_search_Role_Name'] = $loggedRoleId;
                                $_SESSION['SAL_approval_stage_id'] = $loggedApprovalStageId;
                            }

                            if (!empty($statusData)) {
                                foreach ($statusData as $role) {
                                    $optionValue = $role['Approval_Stage_Id'] . '~' . $role['Role_Id'];
                                    $selected = ($optionValue == $selectedRole) ? 'selected' : '';
                                    echo '<option value="' . $optionValue . '" ' . $selected . '>' . $role['Role_Name'] . '</option>';
                                }
                            }

                            ?>
                            
                        </select>
                    </div>
                </div>
                 <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status" onchange="setShopOwnerDetailFilter(1)">
                                <?php
                                $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

                                if (!empty($filter) && $filter !== 'All') {
                                    $_SESSION['SAL_approval_status'] = 'All';
                                    $searchStatus = 'All';
                                }
                                if (!isset($_SESSION['SAL_approval_status']) || $_SESSION['SAL_approval_status'] == 'All') {
                                    $searchStatus = 'All';
                                } else {
                                    $searchStatus = $_SESSION['SAL_approval_status'];
                                }
                                ?>
                            <option value="All" <?= ($searchStatus == 'All' ? 'selected' : '') ?>>All</option>
                            <option value="" <?= ($searchStatus == '' ? 'selected' : '') ?>>Pending</option>
                            <option value="Approved" <?= ($searchStatus == 'Approved' ? 'selected' : '') ?>>Approved</option>
                            <option value="Rejected" <?= ($searchStatus == 'Rejected' ? 'selected' : '') ?>>Rejected</option>
                            <option value="Hold" <?= ($searchStatus == 'Hold' ? 'selected' : '') ?>>Hold</option>
                        </select>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-md-3 col-12">
                    <div class="form-group">
                        <label>Filter Status</label>
                        <select class="form-control" name="filter" id="filter" onchange="setShopOwnerDetailFilter(1)">
                            <option value="All" <?= ($filter == 'All' ? 'selected' : '') ?>>All</option>
                            <option value="total-bills" <?= ($filter == 'total-bills' ? 'selected' : '') ?>>Total Bill Shops</option>
                            <option value="paid-bills" <?= ($filter == 'paid-bills' ? 'selected' : '') ?>>Paid Bill Shops</option>
                            <option value="bill-amount" <?= ($filter == 'bill-amount' ? 'selected' : '') ?>>Total Bill Amount Shops</option>
                            <option value="collected-amount" <?= ($filter == 'collected-amount' ? 'selected' : '') ?>>Collected Amount Shops</option>
                            <option value="pending-amount" <?= ($filter == 'pending-amount' ? 'selected' : '') ?>>Pending Amount Shops</option>
                            <option value="renewal-shops" <?= ($filter == 'renewal-shops' ? 'selected' : '') ?>>Renewal Shops</option>
                            <option value="pending-renewal-shops" <?= ($filter == 'pending-renewal-shops' ? 'selected' : '') ?>>Pending Renewal Shops</option>
                        </select>

                    </div>
                </div>
                <div class="col-lg-1 col-sm-1 col-md-1 col-1">
                    <div id="setShopDetailLoader" style="display:none;margin-top: 2rem;">
                            <img src="assets/imgs/theme/load.gif" alt=""  height="50" width="50" />
                    </div>
                </div>
                <div class="col-lg-5 col-md-3 col-sm-3 col-" style="margin-top: 2rem;">
                    <div class="form-group d-flex justify-content-end gap-3">
                        <button class="btn btn-sm btn-danger" id="clearFilter" onclick="clearFilter()">Clear</button>
                        <button class="btn btn-sm addbtn" id="addNewShop">
                            <i class="fa fa-plus"></i> Add
                        </button>
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
            $shopCd = $shopData["Shop_Cd"];
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
                                                    <img class="default-img zoom-hover" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=" . $shopData["ShopOutsideImage1"]; ?>"
                                                        alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />
                                                    <?php
                                                } else if (!empty($shopData["ShopOutsideImage2"])) {
                                                    ?>
                                                        <img class="default-img zoom-hover" src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=" . $shopData["ShopOutsideImage2"]; ?>"
                                                            alt="<?php echo $shopData["ShopName"]; ?>" width="100%" height="150" />
                                                    <?php
                                                } else {
                                                    ?>
                                                        <img class="default-img zoom-hover" src="../assets/imgs/shopImage.png" alt=""
                                                            width="100%" height="150" />
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
                                        <div class="d-flex justify-content-between align-items-center p-2">
                                            <!-- Shop Title -->
                                            <h2 class="mb-0"><?php echo $shopData["ShopName"]; ?></h2>

                                            <!-- Icons Section -->
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Shop Owner Details Icon -->
                                                <a data-tooltip="Shop Owner Details"
                                                    onclick="redirectPage(<?php echo $shopData['ShopKeeperMobile']; ?>)"
                                                    target="_blank" class="d-inline-flex align-items-center"
                                                    style="cursor: pointer;">
                                                    <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M29.7003 20.1701C27.8749 20.1701 26.4003 18.6955 26.4003 16.8701C26.4003 18.6955 24.9257 20.1701 23.1003 20.1701C21.2749 20.1701 19.8003 18.6955 19.8003 16.8701C19.8003 18.6955 18.3257 20.1701 16.5003 20.1701C14.6749 20.1701 13.2003 18.6955 13.2003 16.8701C13.2003 18.6955 11.7257 20.1701 9.90031 20.1701C8.07491 20.1701 6.60031 18.6955 6.60031 16.8701C6.60031 18.6955 5.1257 20.1701 3.30031 20.1701C2.99499 20.1701 2.70267 20.1181 2.42334 20.0402V32.9998H30.5773V20.0337C30.2979 20.1117 30.0056 20.1701 29.7003 20.1701Z" fill="#F2D8C1"/>
                                                        <path d="M25.7176 18.8706V26.9127H7.28174V18.8576C7.64552 19.3513 8.15871 19.7345 8.74985 19.9489C9.10713 20.0853 9.4904 20.1633 9.89965 20.1633C11.6341 20.1633 13.0502 18.8316 13.1867 17.1296C13.1932 17.0387 13.1997 16.9477 13.1997 16.8633C13.1997 16.9542 13.2061 17.0452 13.2126 17.1296C13.3491 18.8251 14.7652 20.1633 16.4997 20.1633C18.2341 20.1633 19.6502 18.8316 19.7867 17.1296C19.7932 17.0387 19.7997 16.9477 19.7997 16.8633C19.7997 16.9542 19.8061 17.0452 19.8126 17.1296C19.9491 18.8251 21.3652 20.1633 23.0997 20.1633C23.5024 20.1633 23.8922 20.0853 24.2495 19.9489C24.6977 19.7865 25.1004 19.5202 25.4317 19.1954C25.5357 19.0914 25.6331 18.9875 25.7176 18.8706Z" fill="white"/>
                                                        <path d="M24.2495 19.9502V25.4458H8.75635V19.9502C9.11363 20.0866 9.4969 20.1645 9.90615 20.1645C11.6406 20.1645 13.0567 18.8328 13.1932 17.1309H13.2191C13.3556 18.8263 14.7717 20.1645 16.5062 20.1645C18.2406 20.1645 19.6567 18.8328 19.7932 17.1309H19.8191C19.9556 18.8263 21.3717 20.1645 23.1062 20.1645C23.5089 20.1645 23.8922 20.0866 24.2495 19.9502Z" fill="#578C7C"/>
                                                        <path d="M29.2001 0H3.80051C3.04047 0 2.42334 0.617126 2.42334 1.37717V5.86594H30.5773V1.37717C30.5773 0.617126 29.9601 0 29.2001 0Z" fill="#F2D8C1"/>
                                                        <path opacity="0.2" d="M30.5766 20.0399V20.7739C30.2973 20.8584 30.005 20.8973 29.6997 20.8973C27.8808 20.8973 26.3997 19.4162 26.3997 17.5973C26.3997 18.3509 26.1463 19.046 25.7176 19.6046C25.3473 20.0918 24.8406 20.4686 24.256 20.683C23.8987 20.8194 23.5089 20.8973 23.0997 20.8973C21.2808 20.8973 19.7997 19.4162 19.7997 17.5973C19.7997 19.4162 18.3316 20.8973 16.5062 20.8973C14.6743 20.8973 13.2062 19.4162 13.2062 17.5973C13.2062 19.4162 11.7251 20.8973 9.90617 20.8973C9.50341 20.8973 9.11365 20.8194 8.75636 20.683C8.16522 20.4686 7.65853 20.0918 7.28825 19.5981C6.85951 19.0395 6.60617 18.3444 6.60617 17.5973C6.60617 19.4162 5.12507 20.8973 3.30617 20.8973C2.99436 20.8973 2.70853 20.8584 2.4292 20.7804V20.0399C2.70853 20.1243 3.00735 20.1633 3.30617 20.1633C4.21562 20.1633 5.04062 19.793 5.63825 19.1954C6.23589 18.6042 6.60617 17.7792 6.60617 16.8633C6.60617 17.6103 6.85302 18.3054 7.28825 18.8576C7.65203 19.3513 8.16522 19.7345 8.75636 19.9489C9.11365 20.0853 9.49692 20.1633 9.90617 20.1633C11.6406 20.1633 13.0568 18.8316 13.1932 17.1296C13.1997 17.0387 13.2062 16.9477 13.2062 16.8633C13.2062 16.9542 13.2127 17.0452 13.2192 17.1296C13.3556 18.8251 14.7717 20.1633 16.5062 20.1633C18.2406 20.1633 19.6568 18.8316 19.7932 17.1296C19.7997 17.0387 19.8062 16.9477 19.8062 16.8633C19.8062 16.9542 19.8127 17.0452 19.8192 17.1296C19.9556 18.8251 21.3717 20.1633 23.1062 20.1633C23.5089 20.1633 23.8987 20.0853 24.256 19.9489C24.7042 19.7865 25.107 19.5202 25.4383 19.1954C25.5422 19.0914 25.6396 18.9875 25.7176 18.8706C26.1528 18.3184 26.4062 17.6168 26.4062 16.8633C26.4062 18.6822 27.8873 20.1633 29.7062 20.1633C30.005 20.1633 30.2973 20.1243 30.5766 20.0399Z" fill="#334A5E"/>
                                                        <path d="M6.6 13.2457H0L2.42303 5.86621H8.05512L6.6 13.2457Z" fill="#FF7058"/>
                                                        <path d="M13.1996 13.2457H6.59961L8.05473 5.86621H13.6868L13.1996 13.2457Z" fill="#F2F2F2"/>
                                                        <path d="M19.8002 13.2457H13.2002L13.6874 5.86621H19.313L19.8002 13.2457Z" fill="#FF7058"/>
                                                        <path d="M32.9999 13.2457H26.3999L24.9448 5.86621H30.5769L32.9999 13.2457Z" fill="#FF7058"/>
                                                        <path d="M26.4002 13.2457H19.8002L19.313 5.86621H24.9451L26.4002 13.2457Z" fill="#F2F2F2"/>
                                                        <path d="M0 16.8699C0 18.6953 1.47461 20.1699 3.3 20.1699C5.12539 20.1699 6.6 18.6953 6.6 16.8699V13.2451H0V16.8699Z" fill="#F1543F"/>
                                                        <path d="M13.2002 16.8699C13.2002 18.6953 14.6748 20.1699 16.5002 20.1699C18.3256 20.1699 19.8002 18.6953 19.8002 16.8699V13.2451H13.2002V16.8699Z" fill="#F1543F"/>
                                                        <path d="M26.4004 13.2451V16.8699C26.4004 18.6953 27.875 20.1699 29.7004 20.1699C31.5258 20.1699 33.0004 18.6953 33.0004 16.8699V13.2451H26.4004Z" fill="#F1543F"/>
                                                        <path d="M6.59961 16.8699C6.59961 18.6953 8.07422 20.1699 9.89961 20.1699C11.725 20.1699 13.1996 18.6953 13.1996 16.8699V13.2451H6.59961V16.8699Z" fill="#CDD6E0"/>
                                                        <path d="M19.7998 13.2451V16.8699C19.7998 18.6953 21.2744 20.1699 23.0998 20.1699C24.9252 20.1699 26.3998 18.6953 26.3998 16.8699V13.2451H19.7998Z" fill="#CDD6E0"/>
                                                    </svg>
                                                </a>

                                            

                                                <!-- Update Delivery Status Icon -->
                                                <a data-tooltip="Update Delivery Status"
                                                    onclick="DeliveryStatus(<?php echo $shopData['Shop_Cd']; ?>)"
                                                    class="d-inline-flex align-items-center" style="cursor: pointer;">
                                                    <svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M24.2587 7.85325L17.7026 1.07377C17.5988 0.964874 17.474 0.878072 17.3359 0.818575C17.1977 0.759078 17.0489 0.728113 16.8984 0.727539H1.11688C0.820667 0.727539 0.536584 0.84521 0.327128 1.05467C0.117671 1.26412 0 1.54821 0 1.84442V30.8834C0 31.1796 0.117671 31.4637 0.327128 31.6731C0.536584 31.8826 0.820667 32.0003 1.11688 32.0003H23.4545C23.7508 32.0003 24.0348 31.8826 24.2443 31.6731C24.4538 31.4637 24.5714 31.1796 24.5714 30.8834V8.63507C24.5732 8.34365 24.461 8.06308 24.2587 7.85325Z" fill="#F2D8C2"/>
                                                    <path d="M24.2474 7.75266L17.5461 1.05136C17.389 0.896387 17.1896 0.791404 16.9729 0.749661C16.7563 0.707919 16.5321 0.731287 16.3287 0.816817C16.1247 0.900606 15.9501 1.04289 15.8269 1.22575C15.7037 1.40861 15.6373 1.62385 15.6362 1.84435V8.54565C15.6362 8.84186 15.7539 9.12595 15.9634 9.3354C16.1728 9.54486 16.4569 9.66253 16.7531 9.66253H23.4544C23.6749 9.66143 23.8902 9.59509 24.073 9.47186C24.2559 9.34863 24.3982 9.17403 24.4819 8.97007C24.5675 8.76667 24.5908 8.54249 24.5491 8.32583C24.5074 8.10917 24.4024 7.90972 24.2474 7.75266Z" fill="#568C78"/>
                                                    <path d="M18.9868 18.597H5.58417C5.28795 18.597 5.00387 18.4794 4.79441 18.2699C4.58496 18.0605 4.46729 17.7764 4.46729 17.4802C4.46729 17.1839 4.58496 16.8999 4.79441 16.6904C5.00387 16.481 5.28795 16.3633 5.58417 16.3633H18.9868C19.283 16.3633 19.5671 16.481 19.7765 16.6904C19.986 16.8999 20.1036 17.1839 20.1036 17.4802C20.1036 17.7764 19.986 18.0605 19.7765 18.2699C19.5671 18.4794 19.283 18.597 18.9868 18.597Z" fill="#568C78"/>
                                                    <path d="M18.9868 14.1293H5.58417C5.28795 14.1293 5.00387 14.0116 4.79441 13.8021C4.58496 13.5927 4.46729 13.3086 4.46729 13.0124C4.46729 12.7162 4.58496 12.4321 4.79441 12.2226C5.00387 12.0132 5.28795 11.8955 5.58417 11.8955H18.9868C19.283 11.8955 19.5671 12.0132 19.7765 12.2226C19.986 12.4321 20.1036 12.7162 20.1036 13.0124C20.1036 13.3086 19.986 13.5927 19.7765 13.8021C19.5671 14.0116 19.283 14.1293 18.9868 14.1293Z" fill="#568C78"/>
                                                    <path d="M18.9868 23.0658H5.58417C5.28795 23.0658 5.00387 22.9481 4.79441 22.7387C4.58496 22.5292 4.46729 22.2451 4.46729 21.9489C4.46729 21.6527 4.58496 21.3686 4.79441 21.1592C5.00387 20.9497 5.28795 20.832 5.58417 20.832H18.9868C19.283 20.832 19.5671 20.9497 19.7765 21.1592C19.986 21.3686 20.1036 21.6527 20.1036 21.9489C20.1036 22.2451 19.986 22.5292 19.7765 22.7387C19.5671 22.9481 19.283 23.0658 18.9868 23.0658Z" fill="#568C78"/>
                                                    </svg>
                                                </a>

                                                <!-- View Notice Icon -->
                                                <a data-tooltip="View Notice"
                                                    onclick="ShopNoticeDetails(<?php echo $shopData['Shop_Cd']; ?>)"
                                                    class="d-inline-flex align-items-center" style="cursor: pointer;">
                                                    <svg width="36" height="39" viewBox="0 0 36 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect x="2" y="6" width="21" height="28" fill="#F2D7C2"/>
                                                        <circle cx="25.5" cy="28.5" r="10.5" fill="#FEFEFE"/>
                                                        <path d="M4.13303 33.4021C3.68705 33.4021 3.32459 33.0397 3.32459 32.5943V7.70998C3.32459 7.26459 3.68705 6.90227 4.13303 6.90227H21.4241C21.8701 6.90227 22.2326 7.26452 22.2326 7.70998V18.4691C23.0011 18.2131 23.807 18.0432 24.6426 17.9713V7.70998C24.6426 5.93541 23.1988 4.49223 21.4241 4.49223H7.81268V3.21775C7.81268 2.77229 8.17507 2.41004 8.62104 2.41004H25.9123C26.3582 2.41004 26.7206 2.77229 26.7206 3.21775V17.9931C27.5584 18.0861 28.3635 18.285 29.1306 18.5633V3.21775C29.1306 1.44324 27.6869 0 25.9123 0H8.62104C6.84639 0 5.40264 1.44324 5.40264 3.21775V4.49223H4.13303C2.35838 4.49223 0.914551 5.93548 0.914551 7.70998V32.5943C0.914551 34.3688 2.35838 35.8122 4.13303 35.8122H18.0022C17.308 35.0985 16.7136 34.2888 16.2416 33.4021H4.13303Z" fill="#F2D7C2" stroke="#FF8F8F" stroke-width="0.000359998"/>
                                                        <path d="M8.23151 13.8836H15.1862C15.8524 13.8836 16.3912 13.344 16.3912 12.6787C16.3912 12.0131 15.8524 11.4736 15.1862 11.4736H8.23151C7.56572 11.4736 7.02686 12.0132 7.02686 12.6787C7.02686 13.344 7.56564 13.8836 8.23151 13.8836Z" fill="#578C7C" stroke="#FF8F8F" stroke-width="0.000359998"/>
                                                        <path d="M18.5316 18.0283C18.5316 17.3628 17.9929 16.8232 17.3266 16.8232H8.23151C7.56572 16.8232 7.02686 17.3628 7.02686 18.0283C7.02686 18.6938 7.56564 19.2333 8.23151 19.2333H17.3266C17.9929 19.2333 18.5316 18.6938 18.5316 18.0283Z" fill="#578C7C" stroke="#FF8F8F" stroke-width="0.000359998"/>
                                                        <path d="M17.1162 22.1719H8.23151C7.56572 22.1719 7.02686 22.7114 7.02686 23.3768C7.02686 24.0422 7.56564 24.5818 8.23151 24.5818H15.7617C16.1063 23.715 16.5654 22.9079 17.1162 22.1719Z" fill="#578C7C" stroke="#FF8F8F" stroke-width="0.000359998"/>
                                                        <path d="M8.23151 27.5206C7.56572 27.5206 7.02686 28.0602 7.02686 28.7255C7.02686 29.391 7.56564 29.9305 8.23151 29.9305H15.1227C15.0568 29.4516 15.0098 28.9655 15.0098 28.4682C15.0098 28.1482 15.0298 27.8334 15.0581 27.5205H8.23151V27.5206Z" fill="#578C7C" stroke="#FF8F8F" stroke-width="0.000359998"/>
                                                        <path d="M25.5534 25.9795C23.4849 25.9795 21.6535 27.6935 20.9312 28.4689C21.6535 29.2439 23.4849 30.9573 25.5534 30.9573C27.6304 30.9573 29.4566 29.2444 30.1757 28.4696C29.4544 27.6947 27.6234 25.9795 25.5534 25.9795ZM25.5534 30.2764C24.5556 30.2764 23.7461 29.467 23.7461 28.4689C23.7461 27.47 24.5556 26.6615 25.5534 26.6615C26.5513 26.6615 27.3608 27.4699 27.3608 28.4689C27.3608 29.467 26.5513 30.2764 25.5534 30.2764Z" fill="#F1543F"/>
                                                        <path d="M25.5532 20.9375C21.3935 20.9375 18.022 24.3089 18.022 28.4686C18.022 32.6274 21.3935 35.9999 25.5532 35.9999C29.713 35.9999 33.0844 32.6274 33.0844 28.4686C33.0844 24.3089 29.713 20.9375 25.5532 20.9375ZM25.5532 32.1618C22.3031 32.1618 19.7635 28.9764 19.6566 28.841C19.486 28.6222 19.486 28.3151 19.6566 28.0969C19.7636 27.961 22.3032 24.7743 25.5532 24.7743C28.8032 24.7743 31.3428 27.961 31.4499 28.0969C31.6204 28.3151 31.6204 28.6223 31.4499 28.841C31.3428 28.9765 28.8032 32.1618 25.5532 32.1618Z" fill="#F1543F"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="shop-info-row">
                                            <div class="shop-tags">
                                                <span
                                                    class="shop-badges bg-brand"><?php echo $shopData["BusinessCatName"]; ?></span>
                                                <span
                                                    class="shop-badges bg-brand"><?php echo $shopData["ShopAreaName"]; ?></span>
                                                <span
                                                    class="shop-badges bg-brand"><?php echo $shopData["ShopCategory"]; ?></span>
                                            </div>
                                        </div>

                                        <h5 class="title-detail"><i class="fi-rs-smartphone"></i>
                                            <?php echo $shopData["ShopKeeperName"]; ?> -
                                            <?php echo $shopData["ShopKeeperMobile"]; ?></h5>
                                        <h6 class="title-detail"><i class="fi-rs-location-alt"></i>
                                            <?php echo $shopData["NodeName"] . " :  " . "Ward : " . $shopData["Ward_No"] . " - " . $shopData["WardArea"]; ?>
                                        </h6>
                                        <div class="approval-box">
                                        <div class="approval-box-title">Approval Status</div>
                                        <div class="approval-box-content">
                                            <h6 class="title-detail">
                                                <?php
                                                $electionName = $_SESSION['SAL_ElectionName'];
                                                $developmentMode = $_SESSION['SAL_DevelopmentMode'];

                                                $statusQuery = "SELECT 
                                                                    ad.Status,
                                                                    dm.DValue AS Role_Name,
                                                                    dms.DValue AS ApprovalRole_Name,  
                                                                    aas.Approval_Stage_Id, 
                                                                    ad.Updated_By as Updated_By,
                                                                    lm.User_Type aS User_Type,
                                                                    COALESCE(dmm.Dvalue, '') AS Rejection_Reason,
                                                                    COALESCE(ad.Rejection_Remark, '') AS Rejection_Remark,
                                                                    COALESCE(ad.Hold_Remark, '') AS Hold_Remark,
                                                                    COALESCE(um.Remarks, '') AS ExecutiveName,  
                                                                    ISNULL(CONVERT(VARCHAR(19), ad.Updated_Date, 120), '') AS Updated_Date
                                                                FROM Application_Approval_stages aas
                                                                LEFT JOIN Application_Approval_details AS ad ON aas.Approval_Stage_Id = ad.Approval_Stage_Id AND ad.Shop_Cd=$shopCd
                                                                LEFT JOIN Survey_Entry_Data..User_Master AS um ON um.User_Id = ad.Updated_By 
                                                                LEFT JOIN LoginMaster AS lm ON lm.User_Cd=ad.Updated_By
                                                                LEFT JOIN DropDownMaster AS dmm ON ad.Rejection_Reason = dmm.DropDown_Cd AND dmm.DTitle = 'RejectionReasons'
                                                                LEFT JOIN DropDownMaster AS dm ON aas.Role_Id = dm.DropDown_Cd AND dm.DTitle = 'ApprovalRoles'
                                                                LEFT JOIN DropDownMaster AS dms ON lm.Role_Id = dms.DropDown_Cd AND dms.DTitle = 'ApprovalRoles'
                                                                LEFT JOIN Survey_Entry_Data..Executive_Master AS em ON lm.Executive_Cd = em.Executive_Cd  AND lm.User_Cd=ad.Updated_By
                                                                --  WHERE ad.Shop_Cd=$shopCd
                                                                ORDER BY aas.Approval_Stage_Id ASC";


                                                $db = new DbOperation();
                                                $statusData = $db->ExecutveQueryMultipleRowSALData($statusQuery, $electionName, $developmentMode);
                                                // print_r($statusData);
                                            
                                                if (!empty($statusData)) {
                                                    $firstLine = true;
                                                    foreach ($statusData as $row) {
                                                        $status = htmlspecialchars($row['Status'] ?? '');
                                                        $Role_Name = htmlspecialchars($row['Role_Name'] ?? '');
                                                        $ApprovalRole_Name = htmlspecialchars($row['ApprovalRole_Name'] ?? '');
                                                        $UserType = htmlspecialchars($row['User_Type'] ?? '');
                                                        $ExecutiveName = htmlspecialchars(ucwords(strtolower($row['ExecutiveName'] ?? '')));
                                                        $RejectionReason = htmlspecialchars($row['Rejection_Reason'] ?? '');
                                                        $RejectionRemark = htmlspecialchars($row['Rejection_Remark'] ?? '');
                                                        $HoldRemark = htmlspecialchars($row['Hold_Remark'] ?? '');
                                                        $Updated_By = htmlspecialchars($row['Updated_By'] ?? 0);
                                                        $updatedDate = !empty($row['Updated_Date']) ? date("d-m-Y h:i A", strtotime($row['Updated_Date'])) : '';
                                                        $rawRoleName = $ApprovalRole_Name ?: $UserType;

                                                        
                                                        $displayName = shortRoleName($rawRoleName);

                                                        if (empty($status)) {
                                                            $status = 'Pending';
                                                        }
                                                        switch (strtolower($status)) {
                                                            case 'rejected':
                                                                $text_color = 'red';
                                                                $color = '#ffdddd';
                                                                $icon = '<i class="fa fa-eye" id="eyebtn_icon"></i>';
                                                                break;
                                                            case 'hold':
                                                                $text_color = '#fd7e14';
                                                                $color = '#fff1d7';
                                                                $icon = '<i class="fa fa-eye" id="eyebtn_icon"></i>';
                                                                break;
                                                            case 'pending':
                                                                $text_color = 'black';
                                                                $color = '#d8eaee';
                                                                $icon = '<i class="fa fa-eye" id="eyebtn_icon"></i>';
                                                                break;
                                                            case 'approved':
                                                                $text_color = 'green';
                                                                $color = '#daecd3';
                                                                $icon = '<i class="fa fa-eye" id="eyebtn_icon"></i>';
                                                                break;
                                                            default:
                                                                $text_color = 'gray';
                                                                $color = '';
                                                                $icon = '';
                                                        }
                                                        $updatedDateDisplay = $updatedDate ? " ({$updatedDate})" : "";
                                                        // if ($firstLine) {
                                                        echo "{$Role_Name} :";
                                                        echo "<span class='badge badge-primary m-1' style='background-color:{$color}; color:{$text_color} !important; font-size: 12px;font-weight:600'>";
                                                        echo "{$status}";
                                                        echo "</span>";

                                                        if (strtolower($status) == 'rejected' && (!empty($RejectionReason) || !empty($RejectionRemark))) {
                                                            echo "<span class='status-icon-wrapper'>";
                                                            echo $icon;
                                                            echo "<span class='tooltip-box rejection-tooltip'>";
                                                            if (!empty($RejectionReason)) {
                                                                echo "<span class='tooltip-line'><strong>Reason:</strong> {$RejectionReason}</span>";
                                                            }
                                                            if (!empty($RejectionRemark)) {
                                                                echo "<span class='tooltip-line'><strong>Remark:</strong> {$RejectionRemark}</span>";
                                                            }
                                                            echo "</span></span>";
                                                        } elseif (strtolower($status) == 'hold' && (!empty($RejectionReason) || !empty($HoldRemark))) {
                                                            echo "<span class='status-icon-wrapper'>";
                                                            echo $icon;
                                                            echo "<span class='tooltip-box hold-tooltip'>";
                                                            if (!empty($RejectionReason)) {
                                                                echo "<span class='tooltip-line'><strong>Reason:</strong> {$RejectionReason}</span>";
                                                            }
                                                            if (!empty($HoldRemark)) {
                                                                echo "<span class='tooltip-line'><strong>Remark:</strong> {$HoldRemark}</span>";
                                                            }
                                                            echo "</span></span>";
                                                        }

                                                        if (!empty($Updated_By)) {
                                                            echo " by {$ExecutiveName} ({$displayName}) {$updatedDateDisplay}<br>";
                                                        } else {
                                                            echo "<br>";
                                                        }



                                                    }
                                                } else {
                                                    echo "Approval is <span style='font-weight:600;color:black;'>Pending</span>";
                                                }
                                                ?>
                                            </h6>
                                        </div>
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

<div id="modal-container"></div>
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


<div id="popupOverlay"></div>
<div id="popupBox">
    <h5>Required Documents</h5>
    <div class="modal-body">
        <?php   
            $electionName = $_SESSION['SAL_ElectionName'];
            $developmentMode = $_SESSION['SAL_DevelopmentMode']; 
            $sql = "SELECT DocumentName FROM ShopDocumentMaster WHERE IsActive = 1 AND IsCompulsory=1 ORDER BY DocumentType";
            $dbdoc1 = new DbOperation();
            $docType = $dbdoc1->ExecutveQueryMultipleRowSALData($sql, $electionName, $developmentMode);
            
            foreach($docType as $key => $doc) {
        ?>
        <ul>
            <li><?php echo $doc['DocumentName']; ?></li>
        </ul>
        <?php
            }
        ?>
    </div>
    <button id="proceedToShopModal">Proceed</button>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let debounceTimer;
     let debounceTimer1;
$(document).ready(function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => {
        new bootstrap.Tooltip(el);
    });
    
        // var myModal = new bootstrap.Modal(document.getElementById('ShopModal'), {
        //     backdrop: 'static', 
        //     keyboard: false      
        // });

        // $(document).on('click', '#addNewShop', function (e) {
        //     e.preventDefault();
        //     e.stopPropagation();

        //     $('#ShopModal').find('form').each(function () {
        //         this.reset();
        //     });

        //     $('#ShopModal').find('select').each(function () {
        //         $(this).val(null).trigger('change');
        //     });
        //     clearInterval(otpTimeInterval);  
        //     $('#otpTimerCount').hide();
        //     $('#countdown_text').text('30 sec');
        //     $('#otpvalue').hide();

        //     myModal.show();
        // });

        var myModal = new bootstrap.Modal(document.getElementById('ShopModal'), {
            backdrop: 'static',
            keyboard: false
        });
        $(document).on('click', '#addNewShop', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $('#popupBox').fadeIn();
            $('#popupOverlay').fadeIn();
        });

        $(document).on('click', '#proceedToShopModal', function () {
           
            $('#popupBox').fadeOut();
            $('#popupOverlay').fadeOut();

           
            $('#ShopModal').find('form').each(function () { this.reset(); });

            $('#ShopModal').find('select').each(function () {
                $(this).val(null).trigger('change');
            });

            clearInterval(otpTimeInterval);
            $('#otpTimerCount').hide();
            $('#countdown_text').text('30 sec');
            $('#otpvalue').hide();

            myModal.show();
        });

     
        $(document).on('click', '#popupOverlay', function () {
            $('#popupBox').fadeOut();
            $('#popupOverlay').fadeOut();
        });

        
        $('#ShopModal').on('hidden.bs.modal', function () {
            clearInterval(otpTimeInterval);
            $('#otpTimerCount').hide();
            $('#countdown_text').text('30 sec');
            $('#otpvalue').hide();

         
            $('#ShopModal').find('form').each(function () {
                this.reset();
            });

           
        });

        $(document).on('keyup', '#OwnerName', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                console.log("Fetching data for OwnerName: " + $('#OwnerName').val()); 
                setShopOwnerDetailFilter(1);  
            }, 600);
        });

        $(document).on('keyup', '#ShopName', function () {
            clearTimeout(debounceTimer1);
            debounceTimer1 = setTimeout(function () {
                console.log("Fetching data for ShopName: " + $('#ShopName').val()); 
                setShopOwnerDetailFilter(1);  
            }, 600);
        });

        var roleName=$('#setShopdetailroleCd').val();
        var Status=$('#status').val();

        if(roleName !="" || Status !=""){
            setShopOwnerDetailFilter(1);  
        }

        const urlParams = new URLSearchParams(window.location.search);
        const urlFilter = urlParams.get('filter');
        if (urlFilter) {
            $('#filter').val(urlFilter);
        }
        
        if (urlFilter && urlFilter !== 'All') {
            $('#status').val('All');
        }

});
$(document).on('change', '#filter', function() {
    const filterValue = $(this).val();
    $('#status').val('All');
    updateURLParameter('filter', filterValue);
  
    setShopOwnerDetailFilter(1);
});

$(document).on('change', '#status', function() {
    setShopOwnerDetailFilter(1);
});


function updateURLParameter(param, value) {
    const url = new URL(window.location.href);
    
    if (value && value !== 'All') {
        url.searchParams.set(param, value);
    } else {
        url.searchParams.delete(param);
    }
    
  
    window.history.pushState({}, '', url);
}

// $(document).on('keyup', '#OwnerName', function () {
//     clearTimeout(debounceTimer);
//     debounceTimer = setTimeout(function () {
//         setShopOwnerDetailFilter(1);
//     }, 600);
// });

// $(document).on('keyup', '#ShopName', function () {
//     clearTimeout(debounceTimer1);
//     debounceTimer1 = setTimeout(function () {
//         setShopOwnerDetailFilter(1);
//     }, 600);
// });

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



function refreshNoticeDetails() {
    if ($('#NoticeDetailModal').hasClass('show')) {
        var shopCd = $('#NoticeDetailModal').data('shop-cd');

        if (shopCd) {
            $('#NoticeModalBody').html(
                '<div class="text-center p-5"><div class="spinner-border text-danger"></div></div>');
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
    // $('#setShopdetailroleCd').val('');

    $('#filter').val('All');
    $('#status').val('All');
    
    // Clear URL parameters
    const url = new URL(window.location.href);
    url.searchParams.delete('filter');
    window.history.pushState({}, '', url);
    setShopOwnerDetailFilter(1);
}

function setShopOwnerDetailFilter(pageNo){
   
    var loader = document.getElementById("setShopDetailLoader");
 
  
 var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
               
                alert("Your browser broke!");
                return false;
            }
        }
    }
    var loader = document.getElementById("setShopDetailLoader");
    loader.style.display = "block";
    
   
        ajaxRequest.onreadystatechange = function() {
            
            if (ajaxRequest.readyState == 4) {
               
                    loader.style.display = "none";
                    if (ajaxRequest.readyState == 4) {
                    
                        var ajaxDisplay = document.getElementById('showPageDetails');
                        ajaxDisplay.innerHTML = ajaxRequest.responseText;

                        if ($(".categories-button-active").hasClass("open")) {
                            $(".categories-button-active").removeClass("open");
                            $(".categories-dropdown-active-large").removeClass("open");
                        }

                        $('html, body').animate({
                            scrollTop: $("#showPageDetails").offset().top - 200
                        }, 500);


                        var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                        for (var i = 0; i < tempDivZoomContainer.length; i++) {
                            tempDivZoomContainer[i].style.height = "0px";
                            tempDivZoomContainer[i].style.width = "0px";
                        }

                        var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                        for (var i = 0; i < tempDivZoomWindow.length; i++) {
                            tempDivZoomWindow[i].style.height = "0px";
                            tempDivZoomWindow[i].style.width = "0px";
                        }


                        var dataList10Paging = $('.table-10').DataTable({
                            responsive: true,
                            columnDefs: [
                                {
                                    orderable: false,
                                    targets: 0,
                                }
                            ],
                            oLanguage: {
                                sLengthMenu: "_MENU_",
                                sSearch: ""
                            },
                           
                            searching: false,
                            order: [[0, "asc"]],
                            bInfo: false,
                            lengthChange: false,
                            ordering: false,
                            info: false,
                            pageLength: 10,
                            paging:false,
                            iDisplayLength: 10
                        });
                    } 
                 
            }
        }
   
      

    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('nodeName')[0].value;
    var nodeCd = document.getElementById('setNodeAndWardDetailId').value;
    var ShopName = document.getElementsByName('ShopName')[0].value;
    var OwnerName = document.getElementsByName('OwnerName')[0].value;
    var OwnerMobile = document.getElementsByName('OwnerMobile')[0].value;
    var select = document.getElementById('setShopdetailroleCd');
    var status = document.getElementById('status').value;
    var dropdownFilter = document.getElementById('filter').value;
    var filter = dropdownFilter || "";
   
    var value = select.value; 
    

    if(value !== "") {
        var parts = value.split("~"); 
        var approvalStageId = parts[0];
        var roleId = parts[1];
    }
   
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeName="+nodeName+"&nodeCd="+nodeCd+"&ShopName="+ShopName+"&OwnerName="+OwnerName+"&OwnerMobile="+OwnerMobile+"&roleCd="+ roleId +"&ApprovalStageId="+ approvalStageId +"&Status="+ status +"&filter="+ filter;
    
   
    ajaxRequest.open("POST", "setShopOwnerDetailFilter.php" + queryString, true);
    ajaxRequest.send(null);
   

}


</script>