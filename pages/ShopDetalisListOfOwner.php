<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<?php
// echo "<pre>"; print_r($_SERVER);exit;
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$ShopMobileNo = $_SESSION['SAL_ShopKeeperMobile'];
$currentDate = new DateTime();
$startYear = (int)$currentDate->format("Y");
$endDate = $currentDate->modify('+1 year');
$endYear = (int)$endDate->format("Y");
$FinYear = $startYear . '-' . substr($endYear, -2);
$queryShopOwnerShopList = "SELECT  
                                ISNULL(sm.Shop_Cd , '') AS Shop_Cd,
                                ISNULL(sm.ShopOwnerAadharNo, '') AS ShopOwnerAadharNo,
                                ISNULL(sm.ShopOwnerPinCode, '') AS ShopOwnerPinCode,
                                ISNULL(bcm.BusinessCatName, '') AS BusinessCatName,
                                ISNULL(CASE
                                    WHEN sm.ShopKeeperName = '.....' OR NULLIF(sm.ShopKeeperName, '') IS NULL THEN ShopOwnerName
                                    ELSE ShopKeeperName
                                END,'') AS ShopKeeperName,
                                ISNULL(NULLIF(sm.ShopKeeperMobile, ''), ShopOwnerMobile) AS ShopKeeperMobile,
                                ISNULL(NULLIF(sm.ShopEmailAddress, ''), ShopOwnerEmail) AS ShopEmailAddress,
                                ISNULL(sm.ShopOwnerAddress, '') AS ShopOwnerAddress,
                                ISNULL(sm.FirstName, '') AS FirstName,
                                ISNULL(sm.MiddleName, '') AS MiddleName,
                                ISNULL(sm.LastName, '') AS LastName,
                                ISNULL(sm.ShopName, '') AS ShopName,
                                ISNULL(pm.Parwana_Name_Eng, '') AS BusinessDetails,
                                ISNULL(pd.Amount,'') as Amount,
                                ISNULL(sm.ShopLength,0) as ShopLength,
                                ISNULL(sm.ShopWidth,0) as ShopWidth,
                                ISNULL(sm.ShopHeight,0) as ShopHeight,
                                ISNULL(CONCAT(sm.ShopAddress_1, 
                                            CASE 
                                                WHEN sm.ShopAddress_2 IS NOT NULL AND sm.ShopAddress_2 != '' 
                                                    THEN CONCAT(', ', ShopAddress_2)
                                            ELSE ''END), '') AS ShopAddress,
                                ISNULL(sm.ShopCategory, '') AS ShopCategory,
                                ISNULL(sm.IsCertificateIssued, '') AS IsCertificateIssued,
                                ISNULL(CONVERT(VARCHAR,sm.BusinessStartDate,23),'') as BusinessStartDate,
                                ISNULL(CONVERT(VARCHAR,sm.RenewalDate,23),'') as RenewalDate,
                                ISNULL(sm.ShopOutsideImage1, '') AS ShopOutsideImage1,
                                ISNULL(sm.ShopOwnStatus, '') AS ShopOwnStatus,
                                ISNULL(sm.BusinessCat_Cd, '') AS BusinessCat_Cd,
                                ISNULL(sm.ShopNameMar, '') AS ShopNameMar,
                                ISNULL(sb.Billing_Cd, 0) AS Billing_Cd
                            FROM ShopMaster sm
                            LEFT JOIN ParwanaDetails AS pd ON (pd.ParwanaDetCd = sm.ParwanaDetCd)
                            LEFT JOIN ParwanaMaster AS pm ON (pm.Parwana_Cd = pd.Parwana_Cd)
                            LEFT JOIN BusinessCategoryMaster AS bcm ON (bcm.BusinessCat_Cd=sm.BusinessCat_Cd)
                            LEFT JOIN ShopBilling AS sb ON (sb.Shop_Cd = sm.Shop_Cd) AND sb.FinYear = '$FinYear' AND sb.IsActive  = 1
                            WHERE (sm.ShopKeeperMobile='$ShopMobileNo' OR sm.ShopOwnerMobile = '$ShopMobileNo') AND sm.IsActive = 1
                            ORDER BY sm.Shop_Cd DESC";

$db2 = new DbOperation();
$shopDetailList = $db2->ExecutveQueryMultipleRowSALData($queryShopOwnerShopList, $electionName, $developmentMode);


$queryShopApprovalHistory = "SELECT 
                                sm.Shop_Cd,
                                ad.Status,
                                dm.DValue AS Role_Name, 
                                dms.DValue AS ApprovalRole_Name,
                                aas.Approval_Stage_Id, 
                                ad.Updated_By,
                                lm.User_Type AS User_Type,
                                COALESCE(em.ExecutiveName, '') AS ExecutiveName, 
                                COALESCE(dmm.Dvalue, '') AS Rejection_Reason,
                                COALESCE(ad.Rejection_Remark, '') AS Rejection_Remark,
                                COALESCE(ad.Hold_Remark, '') AS Hold_Remark, 
                                ISNULL(CONVERT(VARCHAR(19), ad.Updated_Date, 120), '') AS Updated_Date
                            FROM ShopMaster sm
                            CROSS JOIN Application_Approval_Stages aas
                            LEFT JOIN Application_Approval_Details AS ad 
                                ON aas.Approval_Stage_Id = ad.Approval_Stage_Id 
                                AND ad.Shop_Cd = sm.Shop_Cd
                            LEFT JOIN Survey_Entry_Data..User_Master AS um 
                                ON um.User_Id = ad.Updated_By
                            LEFT JOIN LoginMaster AS lm ON lm.User_Cd = ad.Updated_By
                            LEFT JOIN DropDownMaster AS dm 
                                ON aas.Role_Id = dm.DropDown_Cd 
                                AND dm.DTitle = 'ApprovalRoles'
                            LEFT JOIN DropDownMaster AS dms ON lm.Role_Id = dms.DropDown_Cd AND dms.DTitle = 'ApprovalRoles'
                            LEFT JOIN DropDownMaster AS dmm ON ad.Rejection_Reason = dmm.DropDown_Cd AND dmm.DTitle = 'RejectionReasons'
                            LEFT JOIN Survey_Entry_Data..Executive_Master AS em 
                                ON em.Executive_Cd = lm.Executive_Cd
                            WHERE sm.Shop_Cd IN (
                                SELECT Shop_Cd 
                                FROM ShopMaster 
                                WHERE ShopKeeperMobile = '$ShopMobileNo' 
                                OR ShopOwnerMobile = '$ShopMobileNo'
                            )
                            ORDER BY aas.Approval_Stage_Id ASC
                            ";
// echo $queryShopApprovalHistory;
$db3 = new DbOperation();
$approvalHistoryList = $db3->ExecutveQueryMultipleRowSALData($queryShopApprovalHistory, $electionName, $developmentMode);


$approvalHistoryByShop = [];
foreach ($approvalHistoryList as $history) {
    $shopCd = $history['Shop_Cd'];
    if (!isset($approvalHistoryByShop[$shopCd])) {
        $approvalHistoryByShop[$shopCd] = [];
    }
    $approvalHistoryByShop[$shopCd][] = $history;
}


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
<style>
.custom-product-image {
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-width: 100%;
    height: auto;
}

.custom-product-image:hover {
    transform: scale(1.1);

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

}

.custom-product-image {
    border: 2px solid #f0f0f0;

    padding: 5px;

}
.custom-btn {
    background-color: #3085D6;
    border: 1px solid transparent; 
    color: white; 
}

.custom-btn:hover {
    background-color: #256bb5;
    border-color: #256bb5;    
    color: white;           
}
.custom-product-image:focus {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.product-img-zoom {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    height: auto;
}

.product-img-inner {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top:20px;
    height: 15rem !important;
}

.nav-tabs {
    border-bottom: none !important;
    border-top: none !important;
    background-color: transparent !important;
}

.nav-tabs .nav-link {
    background-color: white;
    color: #C90D41;
    border: 1px solid #C90D41;
    transition: none;
    /* disable transitions if you want */
}

.nav-tabs .nav-link:hover {
    background-color: white !important;
    /* force white on hover */
    color: #C90D41 !important;
    /* force text color on hover */
}

.nav-tabs .nav-link.active {
    background-color: #C90D41;
    color: white;
    border-color: #C90D41;
}

.nav-item {
    border-bottom: none !important;
}

.nav-tabs .nav-link:hover {
    color: #C90D41;
    text-decoration: none;
}

.custom-tab {
    min-width: 100px;
    text-align: center;
    height: 40px;
    margin-left: 10px;
}

.btntoggle {
    background-color: transparent !important;
    border: none;
    padding: 0;
    cursor: pointer;
}

.btntoggle .fa-solid {
    color: black;
    font-size: 1rem;
}


tbody td {
    padding-left: 10px;
}


tbody tr:nth-child(n+5):nth-child(-n+6) td {
    padding-left: 40px;
}

.table td {
    padding-left: 20px;
}

.btn.btntoggle .icon-down,
.btn.btntoggle .icon-up {
    color: red;
}


a[data-tooltip] {
    position: relative;
    cursor: pointer;
}


a[data-tooltip]::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 13px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

a[data-tooltip]::before {
    content: "";
    position: absolute;
    bottom: 115%;
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
.badge.msg {
    display: block;
    white-space: normal;
    word-break: break-word;
    max-width: 200px;
    font-size: 13px;
    /* border: 1px solid black; */
    /* background-color: #e3e1cd; */
     background-color: #ffe4bc;
    color:#000000;
    align-items: center;
    margin: 0 auto;
}
.status-text {
    font-family: inherit; 
    font-size: 15px;
}
 #EditShopModal h4,.shop-dimension{
    color:#000;
    font-weight: 600;
  }
  /* .highlight-text {
    background-color: #faf6d8; 
    padding: 4px 6px;
} */


.zoomable {
  cursor: zoom-in;
  transition: all 0.3s ease;
  display: block;
  margin: 0 auto;
}


.zoomable.zoomed {
  transform: scale(1.8);
  cursor: zoom-out;
  z-index: 1000;
  position: relative;
}


.pdf-zoomable {
  cursor: zoom-in;
  transition: all 0.3s ease;
  width: 80%;
  height: 200px;
}

.pdf-zoomable.zoomed {
  cursor: zoom-out;
  width: 100%;
  height: 600px;
  z-index: 1000;
  position: relative;
}

#zoomPDF{
    height:600px;
}
#shopkeeper_address {
        resize: vertical;
        max-height: 150px;
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
</style>
<div class="container mb-0 mt-0">
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="row">
                <?php if (sizeof($shopDetailList) > 0) {
                    foreach ($shopDetailList as $shopData) { ?>
                <div class="col-lg-3-6 mt-0 mb-10">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Shop Image -->
                                <div class="col-12 col-xl-2">
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap" style="cursor: pointer;">
                                            <div class="product-img product-img-zoom">
                                                <div class="product-img-inner">
                                                    <!-- Display the Shop Image if available -->
                                                    <?php

                                                        if (!empty($shopData['ShopOutsideImage1'])) {
                                                            // $shopImageUrl = "$shopData['ShopOutsideImage1'];
                                                            ?>
                                                        <!-- <img src="<?php //echo "https://csmcshoplicenses.com/image-proxy.php?url=" . $shopData['ShopOutsideImage1']; ?>"
                                                                                                            alt="Shop Image" class="img-fluid custom-product-image"> -->
                                                        <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=" . $shopData['ShopOutsideImage1']; ?>" alt="Shop Image" class="img-fluid custom-product-image">
                                                    <?php } else { ?>
                                                        <img src="./assets/imgs/shopImage.png" alt="Default Image" class="img-fluid custom-product-image">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Details -->
                                <div class="col-12 col-xl-5">
                                    <span class="badge badge-pill badge-primary"> </span>
                                    <div class="product-content-wrap">
                                        <h5 class="card-title">
                                            <?= $shopData['ShopName']; ?>
                                        </h5>
                                        <p class="card-text">Address : <?= $shopData['ShopAddress']; ?> -
                                            <?= $shopData['ShopOwnerPinCode'] ?>
                                        </p>
                                        <p class="card-text">Shopkeeper / ShopOwner:
                                            <?php echo $shopData['ShopKeeperName']; ?>
                                        </p>
                                        <p class="card-text">Mobile : <?php echo $shopData['ShopKeeperMobile']; ?>
                                        </p>
                                        <p class="card-text">Email : <?php echo $shopData['ShopEmailAddress']; ?></p>
                                        <p class="card-text">Shop Area (Length, Height, Width)(in meters):
                                            <?php if ($shopData['ShopLength'] != 0 && $shopData['ShopWidth'] != 0 && $shopData['ShopHeight'] != 0) {
                                                        echo $shopData['ShopLength'] . ',' . $shopData['ShopHeight'] . ',' . $shopData['ShopWidth'];
                                                    }
                                                    ?>
                                        </p>
                                        <div class="approval-box">
                                        <div class="approval-box-title">Approval Status</div>
                                        <div class="approval-box-content">
                                            <p class="card-text status-text" style="margin-bottom: 5px;">
                                            <?php if (!empty($approvalHistoryByShop[$shopData['Shop_Cd']])) { ?>
                                                    <?php
                                                    $first = true;
                                                    foreach ($approvalHistoryByShop[$shopData['Shop_Cd']] as $approval) {
                                                        $status = htmlspecialchars($approval['Status'] ?? '');
                                                        $ExecutiveName = htmlspecialchars(ucwords(strtolower($approval['ExecutiveName'] ?? '')));
                                                        $roleName = htmlspecialchars($approval['Role_Name'] ?? '');
                                                        $ApprovalRole_Name = htmlspecialchars($approval['ApprovalRole_Name'] ?? '');
                                                        $UserType = htmlspecialchars($approval['User_Type'] ?? '');
                                                        $RejectionReason = htmlspecialchars($approval['Rejection_Reason'] ?? '');
                                                        $RejectionRemark = htmlspecialchars($approval['Rejection_Remark'] ?? '');
                                                        $HoldRemark = htmlspecialchars($approval['Hold_Remark'] ?? '');
                                                        $Updated_By = htmlspecialchars($approval['Updated_By'] ?? '');
                                                        $updatedDate = !empty($approval['Updated_Date']) ? date("d-m-Y h:i A", strtotime($approval['Updated_Date'])) : '';
                                                        $rawRoleName = $ApprovalRole_Name ?: $UserType;
                                                         
                                                        $displayName = shortRoleName($rawRoleName);

                                                        if (empty($status)) {
                                                            $status = 'Pending';
                                                        }
                                                        switch (strtolower($status)) {
                                                            case 'rejected':
                                                                $text_color = 'red';
                                                                $color = '#ffdddd';
                                                                break;
                                                            case 'hold':
                                                                $text_color = '#fd7e14';
                                                                $color = '#fff1d7';
                                                                break;
                                                            case 'pending':
                                                                $text_color = 'black';
                                                                $color = '#e0e4e5';
                                                                break;
                                                            case 'approved':
                                                                $text_color = 'green';
                                                                $color = '#daecd3';
                                                                break;
                                                            default:
                                                                $text_color = 'gray';
                                                                $color = 'red';
                                                        }
                                                        $updatedDateDisplay = $updatedDate ? " ({$updatedDate})" : "";
                                                        // if ($first) {
                                                        //     echo "Status: ";
                                                        //     $first = false;
                                                        // } else {
                                                        //     echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
                                                        // }
                                                        ?>
                                                        <strong style="color:#1974bc"><?= $roleName; ?> </strong> :
                                                        <span class='badge badge-primary m-1'
                                                            style="background-color:<?= $color; ?>;color:<?= $text_color; ?>;font-size: 13px;font-weight:800!important"><?= $status; ?></span>
                                                        <?php if (!empty($Updated_By)) { ?>
                                                            by <?= $ExecutiveName; ?> (<?= $displayName; ?>)
                                                        <?php } else { ?>
                                            
                                                        <?php } ?>
                                            
                                                        <?= $updatedDateDisplay; ?>
                                                        <?php if (strtolower($status) === 'rejected') { ?>
                                                            <?php if (!empty($RejectionReason)) { ?>
                                                                <br><span style='color:#b30000;'>Reason:</span> <?= $RejectionReason; ?>
                                                            <?php } ?>
                                                            <?php if (!empty($RejectionRemark)) { ?>
                                                                <br><span style='color:#b30000;'>Remark:</span> <?= $RejectionRemark; ?>
                                                            <?php } ?>
                                                        <?php } elseif (strtolower($status) === 'hold') { ?>
                                                            <?php if (!empty($RejectionReason)) { ?>
                                                                <br><span style='color:#b30000;'>Hold Reason:</span> <?= $RejectionReason; ?>
                                                            <?php } ?>
                                                            <?php if (!empty($HoldRemark)) { ?>
                                                                <br><span style='color:#b30000;'>Remark:</span> <?= $HoldRemark; ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <br>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php } else { ?>
                                                    Status: <span style="font-weight:600;color:black;">Pending</span>
                                                <?php } ?>
                                            </p>
                                        </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Shop Ownership Status -->
                                <div class="col-12 col-xl-3">
                                    <div class="product-cart-wrap">
                                        <div class="product-content-wrap" style=" margin-top: 30px;">
                                            <p>Shop Category : <?php echo $shopData['ShopCategory']; ?></p>
                                            <p>Business Category : <?php echo $shopData['BusinessCatName']; ?></p>
                                            <p>Business Details : <?php echo $shopData['BusinessDetails']; ?></p>
                                            <p>Fees Applicable :
                                                <?= isset($shopData['Amount']) && !empty($shopData['Amount']) ? '₹ ' . $shopData['Amount'] : '₹ 0'; ?>
                                            </p>
                                            <!-- <p>Business Name: <? // echo $shopData['ShopName']; ?></p> -->
                                            <p>Shop Own Status : <?php echo $shopData['ShopOwnStatus']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-2">
                                    <div class="product-action-1" style="margin-top: 35px;">
                                        <button type="button" id="edit-btn"
                                            class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2"
                                            onclick="redirectToEditPage(<?php echo $shopData['Shop_Cd']; ?>)">View
                                            Info And Documents 
                                        </button>
                                        <button type="button" id="notice-btn"
                                            class="btn custom-btn btn-sm  mr-1 m-2"
                                            onclick="ShopNoticeDetails(<?php echo $shopData['Shop_Cd']; ?>)">
                                            Shop Notice
                                        </button>
                                    </div>
                                    <button type="button" id="license-btn"
                                        class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2 <?php echo ($shopData['Billing_Cd'] != 0 && $shopData['Billing_Cd'] != '') ? 'd-none' : ''; ?>"
                                        onclick="applyforlicense(<?php echo $shopData['Shop_Cd']; ?>, '')">
                                        Generate License </button>

                                    <?php
                                        $currentDate = strtotime(date('Y-m-d'));
                                        $renewalDate = strtotime(date('Y-m-d', strtotime($shopData['RenewalDate'])));
                                        $plus30Date = strtotime('+30 days', $currentDate);

                                        if ($renewalDate >= $currentDate && $renewalDate <= $plus30Date) {
                                        ?>
                                            <button type="button" id="renew-btn"
                                                class="btn btn-primary shadow btn-sm sharp edit-btn mr-1 m-2"
                                                onclick="applyforlicense(<?php echo $shopData['Shop_Cd']; ?>, '<?php echo $shopData['RenewalDate'] ?>')">
                                                Renew License
                                            </button>
                                    
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 mt-2">
                                    <div class="total-amt" id="total-amt-<?= $shopData['Shop_Cd']; ?>"></div>
                                    <div class="billing-content" id="billing-content-<?= $shopData['Shop_Cd']; ?>">
                                        <div>
                                            <table class="table table-bordered" id="BillingDetails">
                                                <thead></thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                } else { ?>
                <p>No shops found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Shop Notice Details Modal -->
<div class="modal fade" id="NoticeDetailModal" tabindex="-1" aria-labelledby="NoticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2 m-2">
                <h5 class="modal-title" id="NoticeModalLabel">Notice Details</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="NoticeModalBody">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditShopModal" tabindex="-1" aria-labelledby="EditShopModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width: 70vw;">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center" style="margin-top:20px">
        <h4 class="modal-title" id="EditShopModalLabel" style="color:#e32222">Shop Application Form</h4>
        <div class="ms-auto d-flex align-items-center me-3">
            <button type="button" class="btn btn-primary me-2" id="editButton" style="padding:5px">
                <i class="fa fa-edit me-1"></i> Edit
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

      </div>
      <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
        <div class="container-fluid">
          <section id="application-details-section" class="mb-4">
            <h4 class="mb-3 border-bottom heading pb-2"> <span class="highlight-text">Application Details</span></h4>
                <form id="application-form">
                                    <input type="hidden" class="form-control" id="shop_cd" name="shop_cd">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="title">Title <span class="required">*</span></label>
                                                <select class="select2 form-control" name="title" id="shopkeeper_title">
                                                    <option value="">--Select--</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                            <span id="shopkeeper_title-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="first-name">First Name <span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopkeeper_firstname"
                                                    name="firstname" placeholder="Enter your First Name"
                                                    oninput="this.value=this.value.replace(/[^a-zA-Z\d\s]|(?<=\S)\s{2,}/g, '').replace(/\s{2,}/g, ' ').trim(); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                                                    onkeyup="getFullName()">
                                            </div>
                                            <span id="shopkeeper_firstname-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="parentname">Father's Name/Husband Name</label>
                                                <input type="text" class="form-control" id="shopkeeper_parentname"
                                                    name="parentname" placeholder="Enter your Father's Name"
                                                    oninput="this.value=this.value.replace(/[^a-zA-Z\d\s]|(?<=\S)\s{2,}/g, '').replace(/\s{2,}/g, ' ').trim(); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                                                    onkeyup="getFullName()">
                                            </div>
                                            <span id="shopkeeper_parentname-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="surname">SurName <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopkeeper_surname"
                                                    name="surname" placeholder="Enter your SurName"
                                                    oninput="this.value=this.value.replace(/[^a-zA-Z\d\s]|(?<=\S)\s{2,}/g, '').replace(/\s{2,}/g, ' ').trim(); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                                                    onkeyup="getFullName()">
                                            </div>
                                            <span id="shopkeeper_surname-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fullname">Full Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopkeeper_fullname"
                                                    name="fullname" placeholder="Enter your Full Name" readonly>
                                            </div>
                                            <span id="shopkeeper_fullname-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mobile" class="mr-2">Mobile <span
                                                        class="required">*</span></label>
                                                <div class="d-flex flex-wrap align-items-center gap-2">
                                                   
                                                    <input type="text" class="form-control me-2 mb-2"
                                                        id="shopkeeper_mobile" name="mobile"
                                                        placeholder="Enter your Mobile"
                                                        oninput="this.value = this.value.replace(/[^\d]/g, '').slice(0, 10);">
                                                    <span id="shopkeeper_mobile-error"
                                                        class="text-danger error-below-form-fields"></span>
                                                    <!-- Get OTP Button -->
                                                    <button type="button" class="btn btn-primary btn-sm mb-2"
                                                        id="verifyOtpBtn" onclick="showOtpInput()"
                                                        style="display: none; font-size: 10px;">
                                                        Get OTP
                                                    </button>

                                                    <!-- OTP Input -->
                                                    <input type="text" class="form-control me-2 mb-2" id="otpvalue"
                                                        name="otpvalue" placeholder="Enter your OTP"
                                                        oninput="this.value = this.value.replace(/[^\d]/g, '').slice(0, 4);"
                                                        onkeyup="validateMobileNo()"
                                                        style="display: none; width: 120px;">

                                                    <!-- Resend OTP -->
                                                    <p class="mb-2 text-danger" id="resendOTP"
                                                        style="cursor: pointer; display: none;"
                                                        onclick="showOtpInput()">
                                                        Resend OTP
                                                    </p>

                                                    <p id="otpTimerCount"
                                                        style="color: red; font-size: 12px; display:none">OTP expires in
                                                        <span id="countdown_text">00:30</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email">Email <span class="required">*</span></label>
                                                <input type="email" class="form-control" id="shopkeeper_email"
                                                    name="email" placeholder="Enter your Email"
                                                    onblur="validateEmailInput(this)">
                                            </div>
                                            <span id="shopkeeper_email-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="aadharno">Aadhar No</label>
                                                <input type="text" class="form-control" id="shopkeeper_aadharno"
                                                    name="aadharno" placeholder="Enter your Aadhar No"
                                                    oninput="this.value = this.value.replace(/[^\d]/g, '').slice(0, 12);">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address For Correspondance <span
                                                        class="required">*</span></label>
                                                <textarea class="form-control" id="shopkeeper_address"
                                                    name="address" rows="8"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pincode">Pincode <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopkeeper_pincode"
                                                    name="pincode" placeholder="Enter your Pincode"
                                                    oninput="this.value = this.value.replace(/[^\d]/g, '').slice(0, 6);">
                                            </div>
                                            <span id="shopkeeper_pincode-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                    </div>
                    </form>
          </section>

 
          <section id="shop-details-section" class="mb-4">
            <h4 class="mb-3 border-bottom pb-2"><span class="highlight-text">Shop Details</span></h4>
           <form id="shop-details-form" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shopcategory">Shop Category<span
                                                        class="required">*</span></label>
                                                <select class="select2 form-control" id="shopcategory"
                                                    name="shopcategory">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                            <span id="shopcategory-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="businesscategory">Business Category<span
                                                        class="required">*</span></label>
                                                <select class="select2 form-control" id="businesscategory"
                                                    name="businesscategory">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                            <span id="businesscategory-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="nameofbusiness">Name Of Business <span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="nameofbusiness"
                                                    name="nameofbusiness" placeholder="Enter your Name of Business"
                                                    oninput="this.value=this.value.replace(/[^a-zA-Z\d\s]|(?<=\S)\s{2,}/g, '').replace(/\s{2,}/g, ' ')">
                                            </div>
                                            <span id="nameofbusiness-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="businessdetails">Business Details <span
                                                        class="required">*</span></label>
                                                <select class="select2 form-control" name="businessdetails"
                                                    id="businessdetails" onchange="getAmount()">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                            <span id="businessdetails-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="spacetype">Space Type <span
                                                        class="required">*</span></label>
                                                <select class="select2 form-control" id="spacetype" name="spacetype">
                                                    <option value="">--Select--</option>

                                                </select>
                                            </div>
                                            <span id="spacetype-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shopownstatus">Shop Own Status</label>
                                                <select class="select2 form-control" id="shopownstatus"
                                                    name="shopownstatus">
                                                    <option value="">--Select--</option>
                                                    <option value="Rented">Rent</option>
                                                    <option value="own">Own</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="estdate">Estimate Date to Start New Business <span
                                                        class="required">*</span></label>
                                                <input type="Date" class="form-control" id="estimatedate"
                                                    name="estimatedate">
                                            </div>
                                            <span id="estimatedate-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ShopOwnPeriod">Shop Own Period (in months)<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="ShopOwnPeriod"
                                                    name="ShopOwnPeriod" readonly>
                                            </div>
                                            <span id="ShopOwnPeriod-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                    </div>

                                    <!-- <br> -->

                                    <h5 class="m-2 shop-dimension">Shop Dimension</h5>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="length">Length (in Meters)<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="shoplength" name="length"
                                                    oninput="this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                            <span id="shoplength-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="width">Width (in Meters)<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopwidth" name="width"
                                                    oninput="this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                            <span id="shopwidth-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="height">Height (in Meters)<span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="shopheight" name="height"
                                                    oninput="this.value = this.value.replace(/\D/g, '')">
                                            </div>
                                            <span id="shopheight-error"
                                                class="text-danger error-below-form-fields"></span>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="zoneno">Zone No</label>
                                                <select class="select2 form-control" id="zoneno" name="zoneno">
                                                    <option value="">--Select--</option>
                                              <?php
                                            // session_start();
                                            $electionName = $_SESSION['SAL_ElectionName'];
                                            $developmentMode = $_SESSION['SAL_DevelopmentMode'];
                                            $sql1 = " SELECT DISTINCT(NodeName) as NodeName FROM NodeMaster WHERE IsActive = 1;";
                                            $db3 = new DbOperation();
                                            $zone = $db3->ExecutveQueryMultipleRowSALData($sql1, $electionName, $developmentMode);
                                            if ($zone) {
                                                foreach ($zone as $node) {
                                                    echo "<option value='" . htmlspecialchars($node['NodeName']) . "'>" . htmlspecialchars($node['NodeName']) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span id="zoneno-error" class="text-danger error-below-form-fields"></span>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="wardno">Ward No</label>
                                        <select class="select2 form-control" id="wardno" name="wardno">
                                        </select>
                                    </div>
                                    <span id="wardno-error" class="text-danger error-below-form-fields"></span>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="area">Area <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="shoparea" name="area"
                                            oninput="this.value=this.value.replace(/[^a-zA-Z\d\s]|(?<=\S)\s{2,}/g, '').replace(/\s{2,}/g, ' ').trim(); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">
                                    </div>
                                    <span id="shoparea-error" class="text-danger error-below-form-fields"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Shop Address For Correspondance <span
                                                class="required">*</span></label>
                                        <textarea class="form-control" id="shopaddress" name="address"></textarea>
                                    </div>
                                    <span id="shopaddress-error" class="text-danger error-below-form-fields"></span>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="shopfees"> Fees Applicable <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="shopfees" name="shopfees"
                                            readonly></b>
                                    </div>
                                </div>
                            </div>
                            <h6 class="m-2" style="font-size:20px">Images</h6>
                            <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="innerimage1"> Inner Image 1 <span id="innerimage1-star"
                                                class="required">*</span></label>
                                        <input type="file" class="form-control" id="innerimage1" name="innerimage1"></b>
                                    </div>
                                    <span id="innerimage1-link" class="file-link"></span>
                                    <span id="innerimage1-error" class="text-danger error-below-form-fields"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="innerimage2">Inner Image 2</label>
                                        <input type="file" class="form-control" id="innerimage2" name="innerimage2"></b>
                                    </div>
                                    <span id="innerimage2-error" class="text-danger error-below-form-fields"></span>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="outerimage1">Outer Image 1 <span id="outerimage1-star"
                                                class="required">*</span></label>
                                        <input type="file" class="form-control" id="outerimage1" name="outerimage1"></b>
                                    </div>
                                    <span id="outerimage1-link" class="file-link"></span>
                                    <span id="outerimage1-error" class="text-danger error-below-form-fields"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="outerimage2"> Outer Image 2 </label>
                                        <input type="file" class="form-control" id="outerimage2" name="outerimage2"></b>
                                    </div>
                                    <span id="outerimage2-error" class="text-danger error-below-form-fields"></span>
                                </div>
                            </div>
                        </form>
                    </section>

                    <section id="shop-documents-section" class="mb-4">
                        <h4 class="mb-3 border-bottom pb-2"><span class="highlight-text">Shop Documents</span></h4>
                        <?php
                        $DocFormatSpan = '';
                        $electionName = $_SESSION['SAL_ElectionName'];
                        $developmentMode = $_SESSION['SAL_DevelopmentMode'];
                        $sql = "SELECT Document_Cd,DocumentName,DocumentNameMar, DocumentType,IsCompulsory FROM ShopDocumentMaster WHERE IsActive = 1 ORDER BY DocumentType";
                        $dbdoc = new DbOperation();
                        $docType = $dbdoc->ExecutveQueryMultipleRowSALData($sql, $electionName, $developmentMode);

                        $sqlReason = "SELECT DropDown_Cd, DValue 
                      FROM DropDownMaster 
                      WHERE DTitle = 'DocumentRejectionReason' 
                      AND IsActive = 1 
                      ORDER BY SerialNo";
                        $rejectReasons = $dbdoc->ExecutveQueryMultipleRowSALData($sqlReason, $electionName, $developmentMode);
                        ?>

                        <form id="shopDocForm">
                            <div class="row">
                                <?php foreach ($docType as $key => $doc) { ?>
                                    <input type="hidden" name="is_compulsory[]" value="<?= $doc['IsCompulsory'] ?>">
                                    <input type="hidden" name="document_type[]" value="<?= $doc['DocumentType'] ?>">
                                    <input type="hidden" name="document_cd[]" value="<?= $doc['Document_Cd'] ?>">
                                    <?php
                                    if ($doc['DocumentType'] == 'image') {
                                        $accept = 'image/jpeg, image/png, image/jpg';
                                        $imgExt = '.jpg, .jpeg, .png';
                                    } else {
                                        $accept = 'application/pdf';
                                        $imgExt = '.pdf';
                                    }
                                    ?>

                                    <input type="hidden" name="ShopDocDet_Cd[]"
                                        id="ShopDocDet_Cd_<?= $doc['Document_Cd'] ?>">

                                    <?php if ($DocFormatSpan != $doc['DocumentType']) { ?>
                                        <div class="alert alert-info" role="alert">
                                            Note: Upload below file only <?= $imgExt ?> upto 2MB
                                        </div>
                                    <?php }
                                    $DocFormatSpan = $doc['DocumentType']; ?>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group p-3 border rounded shadow-sm bg-light">
                                            <div class="row align-items-start">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold mb-2">
                                                        <?= $doc['DocumentName'] ?>
                                                        <?php if ($doc['IsCompulsory'] == 1) { ?>
                                                            <span class="text-danger">*</span>
                                                        <?php } ?>
                                                        (<?= $doc['DocumentNameMar'] ?>)
                                                    </label>

                                                    <input type="file" class="form-control mb-3"
                                                        id="file_<?= $doc['Document_Cd'] ?>" name="file[]"
                                                        accept="<?= $accept ?>"
                                                        onchange="previewFile(event, '<?= $doc['Document_Cd'] ?>')">

                                                    <select id="approval_status_<?= $doc['Document_Cd'] ?>"
                                                        name="approval_status[]" class="form-select approval-status mb-3"
                                                        onchange="toggleReasonFields('<?= $doc['Document_Cd'] ?>', this.value)">
                                                        <option value="">-- Select Status --</option>
                                                        <option value="Verified">Verified</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>

                                                    <div class="reason-field mb-3 d-none"
                                                        id="reason_container_<?= $doc['Document_Cd'] ?>">
                                                        <label for="reason_<?= $doc['Document_Cd'] ?>"
                                                            class="form-label">Rejection Reason</label>
                                                        <select id="reason_<?= $doc['Document_Cd'] ?>"
                                                            name="reject_reason[<?= $doc['Document_Cd'] ?>]"
                                                            class="form-select reason-dropdown">
                                                            <option value="">Select Reason</option>
                                                            <?php foreach ($rejectReasons as $reason) { ?>
                                                                <option value="<?= $reason['DropDown_Cd'] ?>">
                                                                    <?= $reason['DValue'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="remark-field d-none"
                                                        id="remark_container_<?= $doc['Document_Cd'] ?>">
                                                        <label for="remark_<?= $doc['Document_Cd'] ?>"
                                                            class="form-label">Reason / Remark</label>
                                                        <textarea id="remark_<?= $doc['Document_Cd'] ?>"
                                                            name="remark[<?= $doc['Document_Cd'] ?>]" class="form-control"
                                                            rows="2"
                                                            placeholder="Enter reason for rejection or hold"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="preview_container_<?= $doc['Document_Cd'] ?>"
                                                        class="border rounded p-2 bg-white file-preview">
                                                        <p class="fw-bold mb-2 text-primary">Preview:</p>
                                                        <div id="file_preview_<?= $doc['Document_Cd'] ?>"
                                                            class="text-center">
                                                            <p class="text-muted mb-0"></p>
                                                        </div>
                                                        <a href="#" id="FileTag_<?= $doc['Document_Cd'] ?>"
                                                            class="btn btn-outline-info btn-sm mt-2 d-none" target="_blank">
                                                            <i class="fa fa-file"></i> View File
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    </section>

                    <section id="verification-details-section" class="mb-4">
                        <h4 class="mb-3 border-bottom pb-2"><span class="highlight-text">Verification Details</span>
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table">
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th>Reason</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody id="verification-table-body">
                                    <tr>
                                        <td colspan="6" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>


                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-secondary" id="closeBtn" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-success" id="approveBtn">
                            Approve and Save
                        </button>
                    </div>

                    <div id="form-messages" class="mt-3">
                        <div id="FormMsgSuccess" class="alert alert-success d-none"></div>
                        <div id="FormMsgFailed" class="alert alert-danger d-none"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fileZoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="zoomImage" src="" class="img-fluid d-none" style="max-height:80vh;" />
                <embed id="zoomPDF" src="" type="application/pdf" class="d-none" width="100%" height="100%" />
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => {
        new bootstrap.Tooltip(el);
    });
    getBillDetails();
    $(document).on("click", ".toggle-details", function() {
        const index = $(this).data("index");
        const shopCd = $(this).data("shop");
        const detailsRow = $("#bill-details-" + shopCd + "-" + index);
        const button = $(this);
        const buttonText = button.siblings(".button-text");
        const iconDown = button.find(".icon-down");
        const iconUp = button.find(".icon-up");

        detailsRow.toggleClass("d-none");

        if (detailsRow.hasClass("d-none")) {
            buttonText.text("View More");
            iconDown.show();
            iconUp.hide();
        } else {
            buttonText.text("View Less");
            iconDown.hide();
            iconUp.show();
        }
    });
    
});
$(document).on('change', '.approval-status', function() {
    const val = $(this).val();
    const docCd = $(this).attr('id').replace('approval_status_', ''); 

    const reasonContainer = $('#reason_container_' + docCd);
    const remarkContainer = $('#remark_container_' + docCd);
    const reasonField = $('#reason_' + docCd);
    const remarkField = $('#remark_' + docCd);

  
    reasonContainer.addClass('d-none');
    remarkContainer.addClass('d-none');

  
    reasonField.prop('disabled', true);
    remarkField.prop('disabled', true);

    if (val === 'Rejected') {
       
        reasonContainer.removeClass('d-none').show(); 
        remarkContainer.removeClass('d-none').show();

        reasonField.prop('disabled', false);
        remarkField.prop('disabled', false);
    } 
    else {
        reasonField.val('');
        remarkField.val('');
    }
});

$(document).ready(function() {
    // $(".approval-status").on("change", function() {
    //     let id = $(this).attr("id").split("_")[2]; 
    //     let remarkContainer = $("#remark_container_" + id);

    //     if ($(this).val() === "Rejected" || $(this).val() === "Hold") {
    //     remarkContainer.removeClass("d-none");
    //     } else {
    //     remarkContainer.addClass("d-none");
    //     }
    // });
    $('#approveBtn').click(function() {
       
        $('#FormMsgSuccess, #FormMsgFailed').stop(true,true).fadeOut().addClass('d-none');

       
        // if (!validateForm('application-form') || !validateForm('shop-details-form') || !validateForm('shopDocForm')) {
        //     $('#FormMsgFailed').removeClass('d-none').text('Please fix errors in the forms before approving.').fadeIn();
        //     return;
        // }
        if (!validateForm('application-form') || !validateForm('shop-details-form') || !validateForm('shopDocForm')) {
            $('#FormMsgFailed').removeClass('d-none').text('Provided All Mandatory Fields Are Filled Correctly.').fadeIn();

           
           setTimeout(function() {
                var $firstError = $('.text-danger:visible').first();
                if ($firstError.length) {
                    var $modalBody = $('#EditShopModal .modal-body'); 
                    $modalBody.animate({
                        scrollTop: $modalBody.scrollTop() + $firstError.offset().top - $modalBody.offset().top - 20
                    }, 500);
                }
            }, 50);

            return;
        }

        $.when(
            submitApplicationFormView('application-form'),
            submitShopDetailsView('shop-details-form'),
            submitDocumentFormView('shopDocForm'),
            // submitVerificationDetailsView()
        )
        .done(function() {
           
            $('#FormMsgSuccess').removeClass('d-none').html('All Data Updated Successfully').fadeIn();

           
            setTimeout(function() {
                $('#FormMsgSuccess').fadeOut(function() {
                    $(this).addClass('d-none');
                });
            }, 3000);
            $('#approveBtn').hide();
            $('#closeBtn').hide();
            location.reload(true);
        })
        .fail(function(errMsg) {
            $('#FormMsgFailed').removeClass('d-none').text(errMsg || 'Please fix the errors in the forms before approving.').fadeIn();

            setTimeout(function() {
                $('#FormMsgFailed').fadeOut(function() {
                    $(this).addClass('d-none');
                });
            }, 5000);
           
        });
    });




});
function validateForm(form_id) {
    let hasError = false;

    if (form_id === 'application-form') {
        const fields = [
            { id: 'shopkeeper_title', errorId: 'shopkeeper_title-error', message: 'Title is required' },
            { id: 'shopkeeper_firstname', errorId: 'shopkeeper_firstname-error', message: 'First Name is required' },
            { id: 'shopkeeper_surname', errorId: 'shopkeeper_surname-error', message: 'Surname is required' },
            { id: 'shopkeeper_mobile', errorId: 'shopkeeper_mobile-error', message: 'Mobile Number is required' },
            { id: 'shopkeeper_email', errorId: 'shopkeeper_email-error', message: 'Email is required' },
            { id: 'shopkeeper_pincode', errorId: 'shopkeeper_pincode-error', message: 'Pincode is required' },
            { id: 'shopkeeper_address', errorId: 'shopkeeper_address-error', message: 'Address is required' }
        ];

        fields.forEach(f => {
            const value = $('#' + f.id).val();
            if (!value) {
                $('#' + f.errorId).text(f.message);
                hasError = true;
            } else {
                $('#' + f.errorId).text('');
                if (f.id === 'shopkeeper_mobile' && !/^[0-9]{10}$/.test(value)) {
                    $('#' + f.errorId).text('Mobile Number must be 10 digits');
                    hasError = true;
                }
                if (f.id === 'shopkeeper_pincode' && !/^[0-9]{6}$/.test(value)) {
                    $('#' + f.errorId).text('Pincode must be 6 digits');
                    hasError = true;
                }
            }
        });

        const aadhar = $('#shopkeeper_aadhar_no').val();
        if (aadhar && aadhar.length !== 12) {
            $('#shopkeeper_aadharno-error').text('Aadhar Number must be 12 digits');
            hasError = true;
        }

        if ($('#verifyOtpBtn').is(':visible')) {
            $('#shopkeeper_mobile-error').text('Please Verify Mobile No');
            hasError = true;
        }
    }

    else if (form_id === 'shop-details-form') {
        const fields = [
            { id: 'shopcategory', errorId: 'shopcategory-error', message: 'Shop Category is required' },
            { id: 'businesscategory', errorId: 'businesscategory-error', message: 'Business Category is required' },
            { id: 'businessdetails', errorId: 'businessdetails-error', message: 'Business Details is required' },
            { id: 'nameofbusiness', errorId: 'nameofbusiness-error', message: 'Business Name is required' },
            { id: 'estimatedate', errorId: 'estimatedate-error', message: 'Estimate Date is required' },
            { id: 'spacetype', errorId: 'spacetype-error', message: 'Space Type is required' },
            { id: 'shopownstatus', errorId: 'shopownstatus-error', message: 'Shop Own Status is required' },
            { id: 'shoplength', errorId: 'shoplength-error', message: 'Shop Length is required' },
            { id: 'shopheight', errorId: 'shopheight-error', message: 'Shop Height is required' },
            { id: 'shopwidth', errorId: 'shopwidth-error', message: 'Shop Width is required' },
            { id: 'shopaddress', errorId: 'shopaddress-error', message: 'Shop Address is required' },
            { id: 'shoparea', errorId: 'shoparea-error', message: 'Shop Area is required' }
        ];

        if (EditShopOwnerNumber != 1) {
            fields.push(
                { id: 'innerimage1', errorId: 'innerimage1-error', message: 'Inner Image 1 is required', linkId: 'innerimage1-link' },
                { id: 'outerimage1', errorId: 'outerimage1-error', message: 'Outer Image 1 is required', linkId: 'outerimage1-link' }
            );
        }

        fields.forEach(f => {
            const value = $('#' + f.id).val();
            const hasLink = f.linkId ? $('#' + f.linkId + ' a').length > 0 : false;

            if ((!value || value === 0) && !hasLink) {
                $('#' + f.errorId).text(f.message);
                hasError = true;
            } else {
                $('#' + f.errorId).text('');
            }
        });

        const zoneno = $('#zoneno').val();
        const wardno = $('#wardno').val();
        if (zoneno && zoneno !== '0' && !wardno) {
            $('#wardno-error').text('Ward No is required');
            hasError = true;
        }
    }else if (form_id === 'shopDocForm') {
        
        $('.approval-status').each(function() {
            const status = $(this).val();
            const docCd = $(this).attr('id').split('_')[2];

            const reasonField = $('#reason_' + docCd);
            const remarkField = $('#remark_' + docCd);

            reasonField.next('.text-danger').remove();
            remarkField.next('.text-danger').remove();

           
            if (status === 'Rejected') {
                if (!reasonField.val()) {
                    reasonField.after('<span class="text-danger">Please select a rejection reason.</span>');
                    hasError = true;
                }
                if (!remarkField.val()) {
                    remarkField.after('<span class="text-danger">Please enter a remark.</span>');
                    hasError = true;
                }
            }

            if (status === 'Hold') {
                if (!remarkField.val()) {
                    remarkField.after('<span class="text-danger">Please enter a remark.</span>');
                    hasError = true;
                }
            }
        });
    }


    return !hasError;
}

// function submitApplicationFormView(form_id) {
//     return $.ajax({
//         url: 'action/save_ApplicationForm.php',
//         type: 'POST',
//         data: $('#' + form_id).serialize(),
//         dataType: 'json'
//     }).then(function(data) {
//         if (data.status === 'success') {
//             if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
//             return; 
//         } else {
//             return $.Deferred().reject(data.message);
//         }
//     });
// }



// function submitShopDetailsView(form_id) {
//     let formElement = document.getElementById(form_id);
//     let formData = new FormData(formElement);
//     formData.append('shop_cd', $('#shop_cd').val());

//     return $.ajax({
//         url: 'action/save_ShopDetails.php',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         dataType: 'json'
//     }).then(function(data) {
//         if (data.status === 'success') {
//             if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
//             return; 
//         } else {
//             return $.Deferred().reject(data.message);
//         }
//     });
// }

// function submitDocumentFormView(form_id) {
//     let formElement = document.getElementById(form_id);
//     let formData = new FormData(formElement);
//     formData.append('Shop_Cd', $('#shop_cd').val());
 
//     return $.ajax({
//         url: './action/saveShopDocDetails.php',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         dataType: 'json'
//     }).then(function(data) {
//         if (data.status === 200) {
//             if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
//             return; 
//         } else {
//             return $.Deferred().reject(data.message);
//         }
//     });
// }
function submitApplicationFormView(form_id) {
    var formData = {};
    $('#' + form_id).find('input, select, textarea').each(function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        if (name && value !== undefined) {
            formData[name] = value;
        }
    });
    
    return $.ajax({
        url: 'action/save_ApplicationForm.php',
        type: 'POST',
        data: formData,
        dataType: 'json'
    }).then(function(data) {
        if (data.status === 'success') {
            if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
            return; 
        } else {
            return $.Deferred().reject(data.message);
        }
    });
}

function submitShopDetailsView(form_id) {
    let formElement = document.getElementById(form_id);
    let formData = new FormData(formElement);
    
   
    $('#' + form_id).find('input[readonly], textarea[readonly], select[disabled]').each(function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        if (name && !formData.has(name)) {
            formData.append(name, value);
        }
    });
    
    formData.append('shop_cd', $('#shop_cd').val());

    return $.ajax({
        url: 'action/save_ShopDetails.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'
    }).then(function(data) {
        if (data.status === 'success') {
            if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
            return; 
        } else {
            return $.Deferred().reject(data.message);
        }
    });
}

function submitDocumentFormView(form_id) {
    let formElement = document.getElementById(form_id);
    let formData = new FormData(formElement);

    $('#' + form_id).find('input[readonly], textarea[readonly], select[disabled]').each(function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        if (name && !formData.has(name)) {
            formData.append(name, value);
        }
    });
    
    formData.append('Shop_Cd', $('#shop_cd').val());
 
    return $.ajax({
        url: './action/updateShopDetails.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'
    }).then(function(data) {
        if (data.status === 200) {
            if (data.Shop_Cd) $('#shop_cd').val(data.Shop_Cd);
            return; 
        } else {
            return $.Deferred().reject(data.message);
        }
    });
}
// function submitVerificationDetailsView() {
//    let shop_cd=$('#shop_cd').val();
//     return $.ajax({
//         url: 'action/saveVerificationDetails.php',
//         type: 'POST',
//         dataType: 'json',
//         data:collectVerificationDetails(shop_cd),
//         success: function(response) {
//             if (response.status === 'success') {
//                 console.log('Verification details saved successfully');
//             } else {
//                 console.error(response.message || 'Error saving verification details');
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error('Error:', error);
//         }
//     });
// }

function collectVerificationDetails(shop_cd) {
    var details = [];

    $('#verification-table-body tr').each(function() {
        var row = $(this);
        var status = row.find('.status-dropdown').val();
        var reason = row.find('.reason-dropdown').val();
        var remark = row.find('.remark-input').val();
        var approvalStageId = row.data('approval-stage-id'); 

      
        if (approvalStageId && status) {
            details.push({
                Approval_Stage_Id: approvalStageId,
                Status: status,
                Rejection_Reason: reason,
                Remark: remark
            });
        }
    });

    return {
        Shop_Cd: shop_cd,
        VerificationDetails: JSON.stringify(details)
    };
}

function getBillDetails() {

    $("[id^=billing-content-]").each(function() {
        var paidAmt = 0;
        var unpaidAmt = 0;
        var totalAmt = 0;
        const billingContent = $(this);
        const shopCd = this.id.replace("billing-content-", "");
        billingContent.html('<div>Loading billing details...</div>');


        $.ajax({
            url: 'action/get-billing-details.php',
            method: 'POST',
            data: {
                Shop_Cd: shopCd
            },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    let hasSuccessPayment = data.some(item => item.PaymentStatus?.toLowerCase() ===
                        "success");
                    let tableHtml = `<table class="table table-bordered">
                                <thead style="background-color:#FFEBEB;text-align:center">
                                    <tr>
                                        <th> Sr. No. </th>`; 
                     if (hasSuccessPayment) {                    
                            tableHtml += ` <th style="max-width: 300px;"> Download </th> `;
                    } 
                         tableHtml += `  <th> Bill Number </th>
                                        <th> License Period </th>
                                        <th> Amount </th>
                                        <th> Status </th>`;
                    if (hasSuccessPayment) {
                        tableHtml += `<th>Transaction Number </th>
                                            <th> Payment Mode </th>
                                            <th>Transaction Date </th>`;
                    }

                    tableHtml += `<th class="text-center">Action</th> </tr>
                                </thead>
                                <tbody>`;
                    $.each(data, function(index, item) {
                        let statusText = '';
                        totalAmt += parseFloat(item.BillAmount) || 0;
                        const startDate = formatDate(item.LicenseStartDate);
                        const endDate = formatDate(item.LicenseEndDate);
                        const BillingDate = formatDate(item.BillingDate);
                        if (item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "pending") {
                            statusText =
                                '<span class="badge bg-warning">InProgress</span>';
                        } else if (item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "confirm") {
                            statusText =
                                '<span class="badge bg-success">Paid</span>';
                        } else if (item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "hold") {
                            statusText =
                                '<span class="badge bg-secondary">Hold</span>';
                        } else if (item.PaymentStatus.toLowerCase() === "failed") {
                            statusText =
                                '<span class="badge bg-danger">Failed</span>';
                        }else if (item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "") {
                            statusText =
                                '<span class="badge bg-warning">InProgress</span>';       
                        } else {
                            unpaidAmt = unpaidAmt + parseFloat(item.BillAmount);
                            statusText =
                                '<span class="badge bg-primary">Pending</span>';
                        }

                        let actionBtn = '';
                        if (item.PaymentStatus.toLowerCase() === "success") {
                            actionBtn = '';
                        } else {
                            actionBtn =
                                `<button class="btn btn-sm btn-success" onclick="paymentGateway(${item.Billing_Cd}, ${item.BillAmount}, ${shopCd})">Pay Now</button>`;
                        }
                        

                        tableHtml += `<tr class="bill-row text-center" data-index="${index}">
                                                    <td> ${index + 1} </td>`;
                        if(hasSuccessPayment) {
                            if (item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "confirm") {
                                    tableHtml += `      <td> 
                                                            <div style="display: flex; align-items: center;">
                                                                <a href="./action/licence_generate.php?billing_id=${item.Billing_Cd}"   data-tooltip="Download the License Invoice" style="margin-right: 12px;" target="_blank">
                                                                <span class ="badge bg-warning" style="font-size: 14px;"> License </span>
                                                                </a>`;
                        
                                tableHtml += ` <a href="./action/reciept.php?Transaction_Cd=${item.Transaction_Cd}" data-bs-toggle="tooltip" data-tooltip="Download the Payment Receipt" style="margin-right: 12px;" target="_blank">
                                                                    <span class ="badge bg-info" style="font-size: 14px;"> Receipt </span>
                                                                </a>`;
                            }else if(item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "hold"){
                                tableHtml += `      <td> 
                                                            <div class="badge bg-warning msg" style="max-width: 300px; word-wrap: break-word; white-space: normal;">
                                                                <span style="color:#C90D41";>Your application is currently on hold due to this reason : ${item.HoldReason}</span>`;
                        
                            }else if(item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === ""){
                               tableHtml += `<td style="max-width: 300px; white-space: normal; word-break: break-word;">
                                            <span class="badge msg" style="display: block;">
                                                Your Application is currently being processed. 
                                                Once completed, your receipt and license will be generated
                                            </span>`;

                            }else if(item.PaymentStatus.toLowerCase() === "success" && item.ConfirmationStatus.toLowerCase() === "pending"){
                            
                                tableHtml += `<td style="max-width: 300px; white-space: normal; word-break: break-word;">
                                            <span class="badge msg" style="display: block;">
                                                Your Application is currently being processed. 
                                                Once completed, your receipt and license will be generated
                                            </span>`;

                            }else{
                                tableHtml += `<td> `;
                            }
                        }
                        tableHtml += `              </div>
                                                    </td>
                                                    <td>${item.BillNo}</td>
                                                    <td>${startDate} to ${endDate}</td>
                                                    <td style="color: #C90D41; font-weight:700" >₹ ${item.BillAmount}</td>
                                                    <td>${statusText}</td>
                                                    `;
                        if (hasSuccessPayment) {
                            var TransDateTime = formatDateWithTimeIST(item.TranDateTime);
                            paidAmt += parseFloat(item.BillAmount) || 0;
                            tableHtml += `<td>${item.TransNumber}</td> `;
                            tableHtml += `<td>${item.paymentMode}</td> `;
                            tableHtml += `<td>${TransDateTime}</td> `;
                        }

                        tableHtml += `<td class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                                            <div class="d-flex align-items-center">
                                                                ${actionBtn}
                                                            </div>
                                                            <div class="toggle-details d-flex align-items-center gap-2" data-index="${index}" data-shop="${shopCd}">
                                                                <span class="button-text" style="color:red;">View More</span>
                                                                <button class="btn btntoggle p-0 m-0" style="background-color: transparent; border: none; cursor: pointer;">
                                                                    <i class="fa-solid fa-angle-down icon-down" style="color: #C90D41;"></i>
                                                                    <i class="fa-solid fa-angle-up icon-up" style="display: none; color: #C90D41;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>`;

                        tableHtml += `<tr class="details-row d-none" id="bill-details-${shopCd}-${index}">
                            <td colspan="10">
                                <div class="card shadow-sm mt-2">
                                    <div class="card-body p-2">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tbody>
                                                <tr><td><strong>Bill Number</strong></td><td>${item.BillNo}</td></tr>
                                                <tr><td><strong>License Period </strong></td><td> ${startDate} to ${endDate}</td></tr>
                                                <tr><td><strong>Bill Generation Date</strong></td><td>${BillingDate}</td></tr>
                                                <tr><td><strong>Bill Amount</strong></td><td>₹ ${item.BillAmount}</td></tr>
                                                <tr><td><strong>Net Amount</strong></td><td>₹ ${item.BillAmount}</td></tr>
                                                <tr><td><strong style="color:#C90D41;">Final Amount</strong></td><td style="color:#C90D41;">₹ ${item.BillAmount}</td></tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    });

                    tableHtml += `</tbody></table>`;
                    billingContent.html(tableHtml);
                } else {
                    // billingContent.html('<div>No billing records found.</div>');
                    billingContent.html('');
                }

                var amtHtml = `<div class="d-flex justify-content-end gap-2 m-2">`;
                if (totalAmt) {
                    amtHtml +=
                        `<span class="badge bg-info text-center" style ="font-size: 14px;">Total Amount: ₹ ${totalAmt}</span>`;
                }

                if (paidAmt) {
                    amtHtml +=
                        ` <span class="badge bg-success text-center" style ="font-size: 14px;">Paid Amount: ₹ ${paidAmt}</span>`;
                }

                if (unpaidAmt) {
                    amtHtml +=
                        `<span class="badge bg-danger text-center" style ="font-size: 14px;">Unpaid Amount: ₹ ${unpaidAmt}</span>`;
                }



                amtHtml += ` </div>`;

                $(`#total-amt-${shopCd}`).html(amtHtml);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                billingContent.html('<div>Failed to load billing data.</div>');
            }
        });
    });
}

<?php $currentDate = date('d F Y'); ?>
function applyforlicense(shopCd, renewDate) {
    var currentDate = new Date();
    var renewFlag = 0;
    var options = {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    };

    var StartDate = <?php echo json_encode($currentDate); ?>;
    var nextYearDate = new Date(currentDate);
    nextYearDate.setFullYear(nextYearDate.getFullYear() + 1);
    nextYearDate.setDate(nextYearDate.getDate() - 1);
    var EndDate = nextYearDate.toLocaleDateString('en-GB', options);

    if (renewDate) {
        renewFlag = 1;
        var dateObj = new Date(renewDate);
        StartDate = dateObj.toLocaleDateString('en-GB', options);
        var nextYearDate = new Date(StartDate);
        nextYearDate.setFullYear(nextYearDate.getFullYear() + 1);
        nextYearDate.setDate(nextYearDate.getDate() - 1);
        EndDate = nextYearDate.toLocaleDateString('en-GB', options);
    }

    Swal.fire({
        html: `Once the payment is completed, your license will be valid from <strong>${StartDate}</strong> to <strong>${EndDate}</strong>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm'

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: 'action/License_bill_generation.php',
                data: {
                    shopCd: shopCd,
                    renewflag: renewFlag
                },
                success: function(response) {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status == 'success') {
                        LicenseGenerationMail(data.Billing_Id, renewFlag);
                        paymentGateway(data.Billing_Id, data.Amount, data.ShopCd);
                    }
                },
                error: function() {
                    alert('Error occurred during License Bill Generation.');
                }
            });
        }
    });
}

function formatDate(dateStr) {
    const date = new Date(dateStr);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function formatDateWithTimeIST(dateStr) {
    const date = new Date(dateStr);
    const options = {
        timeZone: 'Asia/Kolkata',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    };

    return date.toLocaleString('en-IN', options).replace(',', '');
}


function paymentGateway(Billing_id, Amount, shopCd) {
    $.ajax({
        type: "POST",
        url: 'action/generateTransaction.php',
        data: {
            billing_id: Billing_id,
            amount: Amount,
            shopCd: shopCd
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Payment processing',
                text: 'Opening payment window...',
                icon: 'info',
                showConfirmButton: false,
            });
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.statusCode === 200) {
                window.open(data.data);
            } else if (data.statusCode === 204) {
                Swal.fire({
                    title: 'Payment Already Made',
                    text: `${data.message}`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            } else if (data.statusCode === 500) {
                Swal.fire({
                    title: 'Opps, Something went wrong!',
                    text: `${data.message}`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function() {
            alert('Error occurred during License Bill Generation.');
        }
    });
}

function ShopNoticeDetails(Shop_Cd){
    // alert(Shop_Cd);
     $.ajax({
        type: "POST",
        url: 'getShopNoticeDetails.php',
        data: {
            shopCd: Shop_Cd
        },
        success: function(response) {
            $('#NoticeModalBody').html(response); 
            $('#NoticeDetailModal').modal('show'); 
        },
        error: function() {
            alert('Error retrieving shop notice details.');
        }
    });
}

function LicenseGenerationMail(Billing_Cd, RenewalFlag) {
    $.ajax({
        url: "mail_files/sendApplicationMail.php",
        type: "POST",
        data: {
            Billing_Cd: Billing_Cd,
            operation: 'licenseApplication'
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert("Error sending email: " + error);
        }
    });
}


</script>