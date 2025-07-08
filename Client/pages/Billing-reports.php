<?php

$db = new DbOperation();
$db2 = new DbOperation();

$userName = $_SESSION['SAL_UserName'];
$appName = $_SESSION['SAL_AppName'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode = $_SESSION['SAL_DevelopmentMode'];
$currentDate = date('Y-m-d');
$fromDate = $currentDate . " " . $_SESSION['StartTime'];
$toDate = $currentDate . " " . $_SESSION['EndTime'];

function IND_money_format($number)
{
    $decimal = (string) ($number - floor($number));
    $money = floor($number);
    $length = strlen($money);
    $delimiter = '';
    $money = strrev($money);

    for ($i = 0; $i < $length; $i++) {
        if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
            $delimiter .= ',';
        }
        $delimiter .= $money[$i];
    }

    $result = strrev($delimiter);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);

    if ($decimal != '0') {
        $result = $result . $decimal;
    }

    return $result;
}
?>


<script type="text/javascript">
function IND_money_format_js(x) {
    return x.toString().split('.')[0].length > 3 ? x.toString().substring(0, x.toString().split('.')[0].length - 3)
        .replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length - 3) : x
        .toString();
}

var colors = ['#C90D41', '#FFA000', '#F42D71', '#118A99', '#11B55C', '#1B0FAD', '#13BFF9', '#CF0E8B', '#F41D40',
    '#AEAB0C', '#E518FA', '#08A6FB', '#D32F2F', '#FFA726', '#AEEA00', '#5C6BC0', '#827717', '#0277BD', '#9E9D24',
    '#BA68C8', '#00B0FF', '#FFCC80', '#F48FB1'
];
</script>
<?php

$query2 = "SELECT
        (SELECT ISNULL(count(*),0) FROM PocketMaster WHERE IsActive = 1) as PocketsTotal,
        (SELECT ISNULL(count(*),0) FROM ShopMaster WHERE IsActive = 1) as ShopsTotal,
        (SELECT 
        count(distinct(td.Shop_Cd))
        FROM TransactionDetails td 
        WHERE td.Shop_Cd is not null
        and TransStatus = 'Done') as ShopLicensee,
        (SELECT ISNULL(count(*),0) FROM ShopMaster WHERE ISNULL(SurveyDate,'') <> '' AND IsActive = 1) as SurveyCompleted,
        (SELECT count(distinct(sm.Pocket_Cd)) FROM ShopMaster sm, PocketMaster pm WHERE sm.Pocket_Cd = pm.Pocket_Cd AND pm.IsCompleted = 1 AND sm.IsActive = 1) as SurveyPockets,
        (SELECT 
        sum(cast (Amount as int))
        FROM TransactionDetails td 
        WHERE td.Shop_Cd is not null
        and TransStatus = 'Done') as RevenueCollected
        ";

$dataSummary2 = $db->ExecutveQuerySingleRowSALData($query2, $electionName, $developmentMode);





$db1 = new DbOperation();

$queryTotal = "SELECT ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )),0) as SurveyAll,
        
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL AND  ISNULL(ShopMaster.ShopStatus,'') = ''   ),0) as SurveyPending,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Permission Denied')),0) as PermissionDenied,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Permanently Closed')),0) as PermanentlyClosed,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Non-Cooperative')),0) as NonCooperative,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)),0) as SurveyDenied,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified'),0) as SurveyDocVerified,
        ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 )  ),0) as SurveyDocInReview,
        ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd NOT IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd )  ),0) as SurveyDocPending,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseApproved,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Rejected' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseRejected,
        ISNULL((SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd)) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL ) AND ( BillGeneratedFlag = 1 AND BillGeneratedDate IS NOT NULL ) ),0) as LicenseGenerated,
        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL),0) as ShopListed";
$surveyTotalData = $db1->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode);

$queryCount = "SELECT (SELECT COUNT(Billing_Cd) 
                        FROM Aurangabad_ShopAndLicense..ShopBilling) AS TotalBillGenerated,

                        (SELECT ISNULL(SUM(BillAmount), 0) 
                        FROM Aurangabad_ShopAndLicense..ShopBilling) AS BillAmount,

                        (SELECT ISNULL(SUM(Amount), 0) 
                        FROM Aurangabad_ShopAndLicense..TransactionDetails 
                        WHERE PaymentStatus = 'SUCCESS') AS CollectedAmount,

                        (SELECT COUNT(Billing_Cd) 
                        FROM Aurangabad_ShopAndLicense..TransactionDetails 
                        WHERE PaymentStatus = 'SUCCESS') AS BillPaidShopCount,

                        (SELECT COUNT(DISTINCT sb.Shop_Cd)
                        FROM Aurangabad_ShopAndLicense..ShopBilling sb
                        INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm 
                            ON sm.Shop_Cd = sb.Shop_Cd 
                            AND YEAR(sm.RenewalDate) = YEAR(GETDATE())
                        LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails td 
                            ON sb.Billing_Cd = td.Billing_Cd
                        WHERE sb.IsLicenseRenewal = 1
                        AND (td.Billing_Cd IS NULL OR td.PaymentStatus <> 'SUCCESS')) AS LicenseRenewalPending,

                        (SELECT COUNT(DISTINCT sb.Shop_Cd)
                        FROM Aurangabad_ShopAndLicense..ShopBilling sb
                        INNER JOIN Aurangabad_ShopAndLicense..TransactionDetails td 
                            ON td.Billing_Cd = sb.Billing_Cd
                        WHERE sb.IsLicenseRenewal = 1 
                        AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())) AS LicenseRenewedShops,

                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                        FROM Aurangabad_ShopAndLicense..ShopBilling sb
                        INNER JOIN Aurangabad_ShopAndLicense..TransactionDetails td 
                            ON td.Billing_Cd = sb.Billing_Cd
                        WHERE sb.IsLicenseRenewal = 1 
                        AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())) AS RenewalBillAmount,

                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                        FROM Aurangabad_ShopAndLicense..ShopBilling sb
                        INNER JOIN Aurangabad_ShopAndLicense..TransactionDetails td 
                            ON td.Billing_Cd = sb.Billing_Cd
                        WHERE sb.IsLicenseRenewal = 1 
                        AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                        AND td.PaymentStatus = 'SUCCESS') AS RenewalPaidAmount,

                        (SELECT ISNULL(SUM(sb.BillAmount), 0)
                        FROM Aurangabad_ShopAndLicense..ShopBilling sb
                        INNER JOIN Aurangabad_ShopAndLicense..TransactionDetails td 
                            ON td.Billing_Cd = sb.Billing_Cd
                        WHERE sb.IsLicenseRenewal = 1 
                        AND YEAR(sb.LicenseStartDate) = YEAR(GETDATE())
                        AND td.PaymentStatus <> 'SUCCESS') AS RenewalUnpaidAmount";
$db2 = new DbOperation();
$shopBillingCountData = $db2->ExecutveQuerySingleRowSALData($queryCount, $electionName, $developmentMode);

$queryDemandAreaSummary = "SELECT
                (SELECT COALESCE(SUM(CAST(sb.BillAmount AS FLOAT)), 0)
                FROM Aurangabad_ShopAndLicense..ShopBilling sb
                INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
                INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa ON sm.ShopArea_Cd = sa.ShopArea_Cd
                ) AS TotalBillingAmount,

                (SELECT COALESCE(SUM(CAST(sb.BillAmount AS FLOAT)), 0)
                FROM Aurangabad_ShopAndLicense..ShopBilling sb
                INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
                INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa ON sm.ShopArea_Cd = sa.ShopArea_Cd
                WHERE sa.ShopAreaName = 'Residential'
                ) AS ResidentialBillingAmount,

                (SELECT COALESCE(SUM(CAST(sb.BillAmount AS FLOAT)), 0)
                FROM Aurangabad_ShopAndLicense..ShopBilling sb
                INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
                INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa ON sm.ShopArea_Cd = sa.ShopArea_Cd
                WHERE sa.ShopAreaName = 'Commercial'
                ) AS CommercialBillingAmount,

                (SELECT COALESCE(SUM(CAST(sb.BillAmount AS FLOAT)), 0)
                FROM Aurangabad_ShopAndLicense..ShopBilling sb
                INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sb.Shop_Cd = sm.Shop_Cd
                INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa ON sm.ShopArea_Cd = sa.ShopArea_Cd
                WHERE sa.ShopAreaName = 'Industrial'
                ) AS IndustrialBillingAmount
                ";

$demandBillingSummaryData = $db2->ExecutveQuerySingleRowSALData($queryDemandAreaSummary, $electionName, $developmentMode);

?>
<main class="main">
    <div class="container mt-10 mb-10">
        <div class="row">
            <div class="d-flex justify-content-end">
                <a href="index.php?p=collection-report" class="btn btn-primary me-2"
                    style="background-color: transparent !important; color: #F01954 !important; border-color : #F01954 !important">Collection
                    Report</a>
                <a href="index.php?p=pending-report" class="btn btn-primary"
                    style="background-color: transparent !important; color: #F01954 !important; border-color : #F01954 !important">Pending
                    Report</a>
            </div>
            <div class="row d-flex align-items-stretch">
                <div class="col-md-12 col-lg-7 col-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6>Welcome
                                <?php if (isset($_SESSION['SAL_FullName'])) {
                                    echo $_SESSION['SAL_FullName'] . " !";
                                } ?>
                            </h6>
                            <!-- <span> Shop Billing Summary </span> -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=All">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Shop-Visited.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Total Bill Generate</h6>
                                                <p class="text-bold-700 mb-0">
                                                    <?php echo $shopBillingCountData["TotalBillGenerated"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermissionDenied">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permission-Denied.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Bill Paid</h6>
                                                <p class="text-bold-700 mb-0">
                                                    <?php echo $shopBillingCountData["BillPaidShopCount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermissionDenied">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permission-Denied.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">License Renewal Pending</h6>
                                                <p class="text-bold-700 mb-0">
                                                    <?php echo $shopBillingCountData["LicenseRenewalPending"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermanentlyClosed">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permanently-Closed.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">License Renewed Shops</h6>
                                                <p class="text-bold-700 mb-0">
                                                    <?php echo $shopBillingCountData["LicenseRenewedShops"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <?php if($shopBillingCountData["LicenseRenewedShops"] != 0) { ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermanentlyClosed">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permanently-Closed.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Renew Bill</h6>
                                                <p class="text-bold-700 mb-0"> &#8377;
                                                    <?php echo $shopBillingCountData["RenewalBillAmount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermanentlyClosed">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permanently-Closed.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Renew Receipt</h6>
                                                <p class="text-bold-700 mb-0"> &#8377;
                                                    <?php echo $shopBillingCountData["RenewalPaidAmount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermanentlyClosed">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Permanently-Closed.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Renew Pending </h6>
                                                <p class="text-bold-700 mb-0"> &#8377;
                                                    <?php echo $shopBillingCountData["RenewalUnpaidAmount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocPending">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Document-Pending.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Demand</h6>
                                                <p class="text-bold-400 mb-0"> &#8377;
                                                    <?php echo $shopBillingCountData["BillAmount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocReceived">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Document-Received.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Receipt</h6>
                                                <p class="text-bold-700 mb-0"> &#8377;
                                                    <?php echo $shopBillingCountData["CollectedAmount"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=NonCooperative">
                                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                            <div class="banner-icon">
                                                <img src="assets/imgs/theme/icons/Non-Cooperative.png" alt="" />
                                            </div>
                                            <div class="banner-text">
                                                <h6 class="icon-box-title">Pending</h6>
                                                <p class="text-bold-700 mb-0"> &#8377;
                                                    <?php echo ($shopBillingCountData["BillAmount"] - $shopBillingCountData["CollectedAmount"]); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5 col-12">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6>Total Demand : <i class="fa-solid fa-indian-rupee-sign"></i>
                                <?php echo IND_money_format($demandBillingSummaryData["TotalBillingAmount"]) . "/-"; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="chartTotalDemand" style="height: 187px;"></div>
                                    <script type="text/javascript">
                                    var optionsTotalDemand = {
                                        series: [<?php echo $demandBillingSummaryData["ResidentialBillingAmount"]; ?>,
                                            <?php echo $demandBillingSummaryData["CommercialBillingAmount"]; ?>,
                                            <?php echo $demandBillingSummaryData["IndustrialBillingAmount"]; ?>
                                        ],
                                        chart: {
                                            height: "100%",
                                            type: 'donut',
                                            dropShadow: {
                                                enabled: true,
                                                color: '#111',
                                                top: -1,
                                                left: 3,
                                                blur: 3,
                                                opacity: 0.2
                                            }
                                        },
                                        plotOptions: {
                                            pie: {
                                                startAngle: -90,
                                                endAngle: 90,
                                                offsetY: 10
                                            }
                                        },
                                        grid: {
                                            padding: {
                                                bottom: -180
                                            }
                                        },
                                        colors: colors,
                                        legend: {
                                            formatter: function(val, opts) {
                                                return val + " - ₹" + IND_money_format_js(opts.w.globals.series[opts
                                                    .seriesIndex]) + "/-"
                                            }
                                        },
                                        labels: ["Residential", "Commercial", "Industrial"],
                                        responsive: [{
                                            breakpoint: 480,
                                            options: {
                                                legend: {
                                                    position: 'top'
                                                }
                                            }
                                        }]
                                    };


                                    var chartTotalDemand = new ApexCharts(document.querySelector("#chartTotalDemand"),
                                        optionsTotalDemand);
                                    chartTotalDemand.render();
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php


    $queryCatSummary = "SELECT ISNULL(pm.Category, '') AS Category,
                                        ISNULL(SUM(sb.BillAmount), 0) AS Amount,
                                        ISNULL(COUNT(sb.Billing_Cd), 0) AS Count
                                    FROM Aurangabad_ShopAndLicense..ParwanaMaster pm
                                    INNER JOIN Aurangabad_ShopAndLicense..ParwanaDetails pd 
                                        ON pd.Parwana_Cd = pm.Parwana_Cd AND pd.IsActive = 1
                                    INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm 
                                        ON sm.ParwanaDetCd = pd.ParwanaDetCd AND sm.IsActive = 1
                                    INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb 
                                        ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                                    WHERE pm.IsActive = 1
                                    GROUP BY pm.Category";



    $surveyCategoryWiseData = $db1->ExecutveQueryMultipleRowSALData($queryCatSummary, $electionName, $developmentMode);

    $querynatureBus = "SELECT
                            bcm.BusinessCat_Cd,
                            bcm.BusinessCatName,
                            COUNT(sm.Shop_Cd) AS ShopCount,
                            COUNT(sb.Shop_Cd) AS BilledShopCount,
                            ISNULL(SUM(sb.BillAmount), 0) AS BillAmount
                        FROM Aurangabad_ShopAndLicense..ShopMaster sm
                        INNER JOIN Aurangabad_ShopAndLicense..ParwanaDetails pd ON pd.ParwanaDetCd = sm.ParwanaDetCd
                        INNER JOIN Aurangabad_ShopAndLicense..ParwanaMaster pm ON pd.Parwana_Cd = pm.Parwana_Cd
                        INNER JOIN Aurangabad_ShopAndLicense..BusinessCategoryMaster bcm ON bcm.BusinessCat_Cd = pm.BusinessCat_Cd
                        INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb
                            ON sm.Shop_Cd = sb.Shop_Cd AND sb.IsActive = 1
                        WHERE sm.IsActive = 1
                        GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName
                        ORDER BY BillAmount DESC;";
    $natureBusData = $db2->ExecutveQueryMultipleRowSALData($querynatureBus, $electionName, $developmentMode);

    $totalBilledShops = 0;

    foreach ($natureBusData as $row) {
        $totalBilledShops += $row['BilledShopCount'];
    }

    ?>

    <div class="container mt-0 mb-0">
        <style type="text/css">
        .pie-chart-height {
            height: 367px;
        }
        </style>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9 col-md-10 col-sm-9 col-12">
                                <h6>Shop Billing Status : Categories
                                </h6>
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Status-Category-tab"
                                            data-bs-toggle="tab" href="#Graphical-Shop-Status-Category"><i
                                                class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Status-Category-tab" data-bs-toggle="tab"
                                            href="#Tabular-Shop-Status-Category"><i class="fa-solid fa-table"></i></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content entry-main-content">
                            <div class="tab-pane fade show active" id="Graphical-Shop-Status-Category">
                                <div class="pie-chart-height" id="chartCatPieChart"></div>
                                <?php
                                $series = [];
                                $labels = [];

                                foreach ($surveyCategoryWiseData as $item) {
                                    $series[] = (int) $item['Count'];
                                    $labels[] = "'" . addslashes($item['Category']) . "'";
                                }

                                ?>
                                <script type="text/javascript">
                                var colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'];
                                var optionsCatPieChart = {
                                    series: [<?= implode(',', $series); ?>],
                                    chart: {
                                        height: '100%',
                                        type: 'pie',
                                    },
                                    labels: [<?= implode(',', $labels); ?>],
                                    colors: colors,
                                    plotOptions: {
                                        pie: {
                                            dataLabels: {
                                                style: {
                                                    fontSize: '13px',
                                                    fontWeight: 900
                                                }
                                            }
                                        }
                                    },
                                    legend: {
                                        show: true,
                                        position: 'right',
                                        formatter: function(val, opts) {
                                            return val + " - " + IND_money_format_js(opts.w.globals.series[opts
                                                .seriesIndex]);
                                        }
                                    },
                                    responsive: [{
                                        breakpoint: 480,
                                        options: {
                                            legend: {
                                                position: 'top'
                                            }
                                        }
                                    }]
                                };

                                var chartCatPieChart = new ApexCharts(document.querySelector("#chartCatPieChart"),
                                    optionsCatPieChart);
                                chartCatPieChart.render();
                                </script>
                            </div>
                            <div class="tab-pane fade" id="Tabular-Shop-Status-Category">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-4">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Sr No</th>
                                                <th>Category</th>
                                                <th style="text-align: right;">Shops</th>
                                                <th style="text-align: right;">Demand</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $srNo = 0;
                                            $CatShopTotal = 0;
                                            $CatRevenueTotal = 0;
                                            foreach ($surveyCategoryWiseData as $key => $value) {
                                                $srNo = $srNo + 1;
                                                $CatShopTotal = $CatShopTotal + $value["Count"];
                                                $CatRevenueTotal = $CatRevenueTotal + $value["Amount"];
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                <td><?php echo $value["Category"]; ?></td>
                                                <td style="text-align: right;">
                                                    <?php echo $value["Count"]; ?>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php echo "₹ " . IND_money_format($value["Amount"]) . "/-"; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th style="text-align: right;"><?php echo $CatShopTotal; ?>
                                                </th>
                                                <th style="text-align: right;">
                                                    <?php echo "₹ " . IND_money_format($CatRevenueTotal) . "/-"; ?>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9 col-md-10 col-sm-9 col-12">
                                <h6>Shop Status : Nature of Business -
                                    <?php echo IND_money_format($totalBilledShops); ?>
                                </h6>
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Status-Sub-Category-tab"
                                            data-bs-toggle="tab" href="#Graphical-Shop-Status-Sub-Category"><i
                                                class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Status-Sub-Category-tab"
                                            data-bs-toggle="tab" href="#Tabular-Shop-Status-Sub-Category"><i
                                                class="fa-solid fa-table"></i></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content entry-main-content">
                            <div class="tab-pane fade show active" id="Graphical-Shop-Status-Sub-Category">
                                <div class="pie-chart-height" id="chartSubCatPieChart"></div>
                                <script type="text/javascript">
                                var optionsSubCatPieChart = {
                                    series: [
                                        <?php foreach ($natureBusData as $key => $value) {
                                                echo $value["BilledShopCount"] . ",";
                                            } ?>
                                    ],
                                    chart: {
                                        height: '100%',
                                        type: 'pie',
                                    },
                                    plotOptions: {
                                        dataLabels: {
                                            style: {
                                                fontSize: '13px',
                                                fontWeight: 900
                                            }
                                        }
                                    },
                                    colors: colors,
                                    legend: {
                                        show: true,
                                        position: 'right',

                                        formatter: function(val, opts) {
                                            return val + " - " + IND_money_format_js(opts.w.globals.series[opts
                                                .seriesIndex])
                                        }
                                    },
                                    labels: [
                                        <?php foreach ($natureBusData as $key => $value) {
                                                echo "'" . $value["BusinessCatName"] . "', ";
                                            } ?>
                                    ],
                                    responsive: [{
                                        breakpoint: 480,
                                        options: {
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    }]
                                };

                                var chartSubCatPieChart = new ApexCharts(document.querySelector("#chartSubCatPieChart"),
                                    optionsSubCatPieChart);
                                chartSubCatPieChart.render();
                                </script>
                            </div>
                            <div class="tab-pane fade" id="Tabular-Shop-Status-Sub-Category">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-4">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Sr No</th>
                                                <th>Nature of Business</th>
                                                <th style="text-align: right;">Shops</th>
                                                <th style="text-align: right;">Bill Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $srNo = 0;
                                            $SubCatShopTotal = 0;
                                            $BillAmountTotal = 0;
                                            foreach ($natureBusData as $key => $value) {
                                                $srNo = $srNo + 1;
                                                $SubCatShopTotal = $SubCatShopTotal + $value["BilledShopCount"];
                                                $BillAmountTotal = $BillAmountTotal + $value["BillAmount"];
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                <td><?php echo $value["BusinessCatName"]; ?></td>
                                                <td style="text-align: right;">
                                                    <?php echo IND_money_format($value["BilledShopCount"]); ?>
                                                </td>

                                                <td style="text-align: right;">
                                                    <?php echo "₹ " . IND_money_format($value["BillAmount"]) . "/-"; ?>
                                                </td>

                                            </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th style="text-align: right;">
                                                    <?php echo IND_money_format($SubCatShopTotal); ?>
                                                </th>

                                                </th>
                                                <th style="text-align: right;">
                                                    <?php echo "₹ " . IND_money_format($BillAmountTotal) . "/-"; ?>
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>




        </div>

    </div>


    <div class="container mt-10 mb-0">
        <div class="row">


            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <?php
                $queryZoneSummary = "SELECT NM.NodeName AS NodeName,
                                            COUNT(DISTINCT SB.Shop_Cd) AS Total_Billed_Shops,
                                            
                                            SUM(CASE 
                                                    WHEN TD.paymentStatus = 'SUCCESS' THEN TD.Amount 
                                                    ELSE 0 
                                                END) AS Total_Collected_Amount,
                                            
                                            ISNULL(SUM(SB.BillAmount), 0) AS Total_BillAmount,

                                            SUM(CASE 
                                                    WHEN SA.ShopAreaName = 'Residential' THEN ISNULL(SB.BillAmount, 0)
                                                    ELSE 0 
                                                END) AS ResidentialBillingAmount,

                                            SUM(CASE 
                                                    WHEN SA.ShopAreaName = 'Commercial' THEN ISNULL(SB.BillAmount, 0)
                                                    ELSE 0 
                                                END) AS CommercialBillingAmount,

                                            SUM(CASE 
                                                    WHEN SA.ShopAreaName = 'Industrial' THEN ISNULL(SB.BillAmount, 0)
                                                    ELSE 0 
                                                END) AS IndustrialBillingAmount

                                        FROM Aurangabad_ShopAndLicense..NodeMaster NM 
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopMaster SM 
                                            ON NM.Ward_No = SM.Ward_No AND SM.IsActive = 1
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopBilling SB 
                                            ON SM.Shop_Cd = SB.Shop_Cd AND SB.IsActive = 1
                                        LEFT JOIN Aurangabad_ShopAndLicense..TransactionDetails TD 
                                            ON SB.Billing_Cd = TD.Billing_Cd
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster SA 
                                            ON SM.ShopArea_Cd = SA.ShopArea_Cd

                                        WHERE NM.IsActive = 1

                                        GROUP BY NM.NodeName
                                        ORDER BY NM.NodeName";
                $surveyAndDemandZoneWiseData = $db1->ExecutveQueryMultipleRowSALData($queryZoneSummary, $electionName, $developmentMode);


                $totalZoneListedShops = 0;
                $totalZoneBillCollected = 0;
                $totalZoneBillDemand = 0;
                foreach ($surveyAndDemandZoneWiseData as $value) {
                    $totalZoneListedShops += $value["Total_Billed_Shops"];
                    $totalZoneBillCollected += $value["Total_Collected_Amount"];
                    $totalZoneBillDemand += $value["Total_BillAmount"];
                }

                $totalZoneListedShops = IND_money_format($totalZoneListedShops);
                $totalZoneBillCollected = IND_money_format($totalZoneBillCollected);
                $totalZoneBillDemand = IND_money_format($totalZoneBillDemand);
                
                ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                <h6>Demand Status </h6>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Revenue-Zone-tab"
                                            data-bs-toggle="tab" href="#Graphical-Shop-Revenue-Zone"><i
                                                class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Revenue-Zone-tab" data-bs-toggle="tab"
                                            href="#Tabular-Shop-Revenue-Zone"><i class="fa-solid fa-table"></i></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content entry-main-content">
                                    <div class="tab-pane fade show active" id="Graphical-Shop-Revenue-Zone">
                                        <div id="chart1"></div>
                                        <script type="text/javascript">
                                        <?php //echo $totalZoneListedShops; ?>
                                        var options = {
                                            series: [{
                                                name: 'Billed Shop - <?php echo $totalZoneListedShops; ?> Shops',
                                                type: 'column',
                                                data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                        echo $value["Total_Billed_Shops"] . ",";
                                                    } ?>]
                                            }, {
                                                name: 'Demand Collected - ₹ <?php echo $totalZoneBillCollected; ?>',
                                                type: 'column',
                                                data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                        echo $value["Total_Collected_Amount"] . ",";
                                                    } ?>]
                                            }, {
                                                name: 'Total Demand - ₹ <?php echo $totalZoneBillDemand; ?>',
                                                type: 'line',
                                                data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                        echo $value["Total_BillAmount"] . ",";
                                                    } ?>]
                                            }],
                                            chart: {
                                                height: 450,
                                                type: 'line',
                                                stacked: false
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                width: [1, 1, 4]
                                            },
                                            colors: ['#C90D41', '#F42D71', '#FFA000'],
                                            // colors : colors,
                                            xaxis: {
                                                categories: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                        echo "'" . $value["NodeName"] . "',";
                                                    } ?>],
                                            },
                                            yaxis: [{
                                                    axisTicks: {
                                                        show: true,
                                                    },
                                                    axisBorder: {
                                                        show: true,
                                                        color: '#C90D41'
                                                    },
                                                    labels: {
                                                        style: {
                                                            colors: '#C90D41',
                                                        }
                                                    },
                                                    title: {
                                                        text: "Shops Visited",
                                                        style: {
                                                            color: '#C90D41',
                                                        }
                                                    },
                                                    tooltip: {
                                                        enabled: true
                                                    }
                                                },
                                                {
                                                    seriesName: 'Demand Collected',
                                                    opposite: true,
                                                    axisTicks: {
                                                        show: true,
                                                    },
                                                    axisBorder: {
                                                        show: true,
                                                        color: '#F42D71'
                                                    },
                                                    labels: {
                                                        style: {
                                                            colors: '#F42D71',
                                                        }
                                                    },
                                                    title: {
                                                        text: "Demand Collected",
                                                        style: {
                                                            color: '#F42D71',
                                                        }
                                                    },
                                                },
                                                {
                                                    seriesName: 'Total Demand',
                                                    opposite: true,
                                                    axisTicks: {
                                                        show: true,
                                                    },
                                                    axisBorder: {
                                                        show: true,
                                                        color: '#FFA000'
                                                    },
                                                    labels: {
                                                        style: {
                                                            colors: '#FFA000',
                                                        },
                                                    },
                                                    title: {
                                                        text: "Total Demand",
                                                        style: {
                                                            color: '#FFA000',
                                                        }
                                                    }
                                                },
                                            ],
                                            tooltip: {
                                                fixed: {
                                                    enabled: true,
                                                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                                                    offsetY: 30,
                                                    offsetX: 60
                                                },
                                            },
                                            legend: {
                                                horizontalAlign: 'left',
                                                offsetX: 40,
                                                show: true,
                                                position: 'top'
                                            }
                                        };

                                        var chart = new ApexCharts(document.querySelector("#chart1"), options);
                                        chart.render();
                                        </script>

                                    </div>
                                    <div class="tab-pane fade" id="Tabular-Shop-Revenue-Zone">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-6">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">Sr No</th>
                                                                <th style="text-align: left;">Zone</th>
                                                                <th style="text-align: right;">Billed Shop</th>
                                                                <th style="text-align: right;">Demand Collected</th>
                                                                <th style="text-align: right;">Total Demand </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $srNo = 0;
                                                            $TotalShopCount = 0;
                                                            $CollectedBillAmount = 0;
                                                            $TotalBillAmount = 0;
                                                            foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                                $srNo = $srNo + 1;
                                                                $TotalShopCount = $TotalShopCount + $value["Total_Billed_Shops"];
                                                                $CollectedBillAmount = $CollectedBillAmount + $value["Total_Collected_Amount"];
                                                                $TotalBillAmount = $TotalBillAmount + $value["Total_BillAmount"];
                                                                ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo $srNo; ?>
                                                                </td>
                                                                <td><?php echo $value["NodeName"]; ?></td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["Total_Billed_Shops"]); ?>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["Total_Collected_Amount"]); ?>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["Total_BillAmount"]); ?>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                            }
                                                            ?>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Total</th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($TotalShopCount); ?>
                                                                </th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($CollectedBillAmount); ?>
                                                                </th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($TotalBillAmount); ?>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-6">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">Sr No</th>
                                                                <th style="text-align: left;">Zone</th>
                                                                <th style="text-align: right;">Residential Demand</th>
                                                                <th style="text-align: right;">Commercial Demand</th>
                                                                <th style="text-align: right;">Industrial Demand</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $srNo = 0;
                                                            $TotalResidentialBillingAmount = 0;
                                                            $TotalCommercialBillingAmount = 0;
                                                            $TotalIndustrialBillingAmount = 0;
                                                            foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                                $srNo = $srNo + 1;
                                                                $TotalResidentialBillingAmount = $TotalResidentialBillingAmount + $value["ResidentialBillingAmount"];
                                                                $TotalCommercialBillingAmount = $TotalCommercialBillingAmount + $value["CommercialBillingAmount"];
                                                                $TotalIndustrialBillingAmount = $TotalIndustrialBillingAmount + $value["IndustrialBillingAmount"];
                                                                ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo $srNo; ?>
                                                                </td>
                                                                <td><?php echo $value["NodeName"]; ?></td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["ResidentialBillingAmount"]); ?>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["CommercialBillingAmount"]); ?>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <?php echo IND_money_format($value["IndustrialBillingAmount"]); ?>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                            }
                                                            ?>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Total</th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($TotalResidentialBillingAmount); ?>
                                                                </th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($TotalCommercialBillingAmount); ?>
                                                                </th>
                                                                <th style="text-align: right;">
                                                                    <?php echo IND_money_format($TotalIndustrialBillingAmount); ?>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>

    <div class="container mt-10 mb-0">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <?php
                    $sr_No = 0;
                    foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                        $sr_No = $sr_No + 1;
                        $nodeName = $value["NodeName"];
                        ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($sr_No == 1) { ?> active <?php } ?>"
                            id="SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab"
                            href="#SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>"><?php echo $nodeName; ?></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>

            </div>
        </div>

        <div class="tab-content entry-main-content">


            <?php
            $sr_No = 0;
            foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                $sr_No = $sr_No + 1;
                $nodeName = $value["NodeName"];
                $totalNodeShopBilled = $value["Total_Billed_Shops"];
                $totalNodeCollectedAmount = $value["Total_Collected_Amount"];


                // $nodeQue = "SELECT nm.NodeName, sm.Ward_No,   
                //             ISNULL((SELECT COUNT(sb.Billing_Cd) FROM Aurangabad_ShopAndLicense..ShopAreaMaster sa INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sm.ShopArea_Cd = sa.ShopArea_Cd INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1 WHERE sa.IsActive = 1 AND sa.ShopAreaName = 'Residential'), 0) as Residential,
                //             ISNULL((SELECT COUNT(sb.Billing_Cd) FROM Aurangabad_ShopAndLicense..ShopAreaMaster sa INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sm.ShopArea_Cd = sa.ShopArea_Cd INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1 WHERE sa.IsActive = 1 AND sa.ShopAreaName = 'Industrial'), 0) as Industrial,
                //             ISNULL((SELECT COUNT(sb.Billing_Cd) FROM Aurangabad_ShopAndLicense..ShopAreaMaster sa INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sm.ShopArea_Cd = sa.ShopArea_Cd INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1 WHERE sa.IsActive = 1 AND sa.ShopAreaName = 'Commercial'), 0) as Commercial,
                //             ISNULL(COUNT(sb.Billing_Cd), 0) as Total
                //             FROM Aurangabad_ShopAndLicense..NodeMaster nm
                //             INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm ON sm.Ward_No = nm.Ward_No AND sm.IsActive = 1
                //             INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                //             WHERE nm.IsActive = 1 AND nm.NodeName = '$nodeName'
                //             GROUP BY nm.NodeName, sm.Ward_No";

                $nodeQue = "SELECT 
                            nm.NodeName, 
                            sm.Ward_No,
                            COUNT(CASE WHEN sa.ShopAreaName = 'Residential' THEN sb.Billing_Cd END) AS Residential,
                            COUNT(CASE WHEN sa.ShopAreaName = 'Industrial' THEN sb.Billing_Cd END) AS Industrial,
                            COUNT(CASE WHEN sa.ShopAreaName = 'Commercial' THEN sb.Billing_Cd END) AS Commercial,
                            COUNT(sb.Billing_Cd) AS Total
                        FROM Aurangabad_ShopAndLicense..NodeMaster nm
                        INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm 
                            ON sm.Ward_No = nm.Ward_No AND sm.IsActive = 1
                        INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa 
                            ON sm.ShopArea_Cd = sa.ShopArea_Cd AND sa.IsActive = 1
                        INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb 
                            ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                        WHERE nm.IsActive = 1 AND nm.NodeName = '$nodeName'
                        GROUP BY nm.NodeName, sm.Ward_No";

                // $nodeQue = "SELECT 
                //             COALESCE(sa.ShopArea_Cd, 0) as ShopArea_Cd,
                //             COALESCE(sa.ShopAreaName, '') as ShopAreaName,
                //             COALESCE(COUNT(CASE WHEN nm.NodeName = '$nodeName'  THEN spm.Shop_Cd END), 0) AS Shops
                //             FROM 
                //             Aurangabad_ShopAndLicense..ShopAreaMaster sa
                //             LEFT JOIN Aurangabad_ShopAndLicense..ShopMaster spm 
                //             ON spm.ShopArea_Cd = sa.ShopArea_Cd
                //             LEFT JOIN Aurangabad_ShopAndLicense..NodeMaster nm 
                //             ON spm.Ward_No = nm.Ward_No
                //             LEFT JOIN Aurangabad_ShopAndLicense..ShopBilling sb 
                //             ON spm.Shop_Cd = sb.Shop_Cd
                //             GROUP BY 
                //             sa.ShopArea_Cd, sa.ShopAreaName
                //             ORDER BY 
                //             sa.ShopAreaName";
                
                $nodeData = $db2->ExecutveQueryMultipleRowSALData($nodeQue, $electionName, $developmentMode);

                // $nodeWiseRevenueQue = "SELECT 
                //                 COALESCE(sa.ShopArea_Cd, 0) as ShopArea_Cd,
                //                 COALESCE(sa.ShopAreaName, '') as ShopAreaName,
                //                 COALESCE(COUNT(CASE WHEN nm.NodeName = '$nodeName'  THEN sb.Shop_Cd END), 0) AS Shops,
                //                 COALESCE(SUM(CASE WHEN nm.NodeName = '$nodeName'  THEN sb.BillAmount END), 0) AS Amount,
                //                 COALESCE(SUM(CASE 
                //                                 WHEN nm.NodeName = '$nodeName' AND td.PaymentStatus = 'success' 
                //                                 THEN sb.BillAmount 
                //                             END), 0) AS CollectedAmount
                //                 FROM 
                //                     Aurangabad_ShopAndLicense..ShopAreaMaster sa
                //                 INNER JOIN Aurangabad_ShopAndLicense..ShopMaster spm 
                //                     ON spm.ShopArea_Cd = sa.ShopArea_Cd
                //                 INNER JOIN Aurangabad_ShopAndLicense..NodeMaster nm 
                //                     ON spm.Ward_No = nm.Ward_No
                //                 INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb 
                //                     ON spm.Shop_Cd = sb.Shop_Cd
                //                 INNER JOIN Aurangabad_ShopAndLicense..TransactionDetails td
                //                     ON td.Billing_Cd = sb.Billing_Cd
                //                 GROUP BY 
                //                     sa.ShopArea_Cd, sa.ShopAreaName
                //                 ORDER BY 
                //                     sa.ShopAreaName";

                $nodeWiseRevenueQue = " SELECT nm.NodeName, sm.Ward_No,
                                            SUM(CASE WHEN sa.ShopAreaName = 'Residential' THEN sb.BillAmount ELSE 0 END) AS Residential,
                                            SUM(CASE WHEN sa.ShopAreaName = 'Industrial' THEN sb.BillAmount ELSE 0 END) AS Industrial,
                                            SUM(CASE WHEN sa.ShopAreaName = 'Commercial' THEN sb.BillAmount ELSE 0 END) AS Commercial,
                                            SUM(sb.BillAmount) AS Total
                                        FROM Aurangabad_ShopAndLicense..NodeMaster nm
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopMaster sm 
                                            ON sm.Ward_No = nm.Ward_No AND sm.IsActive = 1
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopAreaMaster sa 
                                            ON sm.ShopArea_Cd = sa.ShopArea_Cd AND sa.IsActive = 1
                                        INNER JOIN Aurangabad_ShopAndLicense..ShopBilling sb 
                                            ON sb.Shop_Cd = sm.Shop_Cd AND sb.IsActive = 1
                                        WHERE nm.IsActive = 1 AND nm.NodeName = '$nodeName'
                                        GROUP BY nm.NodeName, sm.Ward_No";

                $nodeWiseRevenueData = $db2->ExecutveQueryMultipleRowSALData($nodeWiseRevenueQue, $electionName, $developmentMode);
                // print_r($nodeWiseRevenueData);
            
                $TotalNodeBillAmount = 0;

                // foreach ($nodeWiseRevenueData as $value) {
                //     $TotalNodeBillAmount = $TotalNodeBillAmount + $value['Amount'];
                // }
                ?>



            <div class="tab-pane fade <?php if ($sr_No == 1) { ?> show active <?php } ?>"
                id="SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                        <h6>Shop Status : <?php echo $nodeName; ?> -
                                            <?php echo "" . IND_money_format(count($nodeData)) . " Shops"; ?>
                                        </h6>
                                        <!-- <span> By Ward Wise </span> -->
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                    id="Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>-tab"
                                                    data-bs-toggle="tab"
                                                    href="#Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>"><i
                                                        class="fa-solid fa-chart-pie"></i></a>
                                            </li>
                                            <li>
                                                <a class="nav-link"
                                                    id="Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>-tab"
                                                    data-bs-toggle="tab"
                                                    href="#Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>"><i
                                                        class="fa-solid fa-table"></i></a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="tab-content entry-main-content">
                                            <div class="tab-pane fade show active"
                                                id="Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>">
                                                <div style="height: 420px;"
                                                    id="chartWardShopStatus<?php echo $sr_No; ?>"></div>

                                                <script>
                                                var optionsWardShopStatus = {
                                                    series: [{
                                                            name: 'Residential',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => $d['Residential'], $nodeData)); ?>
                                                            ]

                                                        },
                                                        {
                                                            name: 'Commercial',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => $d['Commercial'], $nodeData)); ?>
                                                            ]
                                                        },
                                                        {
                                                            name: 'Industrial',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => ($d['Industrial']), $nodeData)); ?>
                                                            ]
                                                        }
                                                    ],
                                                    chart: {
                                                        type: 'bar',
                                                        height: '400px',
                                                        stacked: false,
                                                        toolbar: {
                                                            show: false
                                                        }
                                                    },
                                                    colors: ['#2196f3', '#ff6d00', '#6200ea'],
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: false,
                                                            borderRadius: 4,
                                                            columnWidth: '30%',
                                                            dataLabels: {
                                                                position: 'top'
                                                            }
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: true,
                                                        formatter: function(val) {
                                                            return val.toLocaleString('en-IN');
                                                        },
                                                        offsetY: -20,
                                                        style: {
                                                            fontSize: '12px',
                                                            colors: ["#304758"]
                                                        }
                                                    },
                                                    xaxis: {
                                                        categories: [
                                                            <?php echo implode(', ', array_map(fn($d) => '"Ward No. ' . $d['Ward_No'] . '"', $nodeData)); ?>
                                                        ],
                                                        position: 'bottom',
                                                        labels: {
                                                            offsetY: 0
                                                        },
                                                        axisBorder: {
                                                            show: true
                                                        },
                                                        axisTicks: {
                                                            show: true
                                                        }
                                                    },
                                                    yaxis: {
                                                        title: {
                                                            text: 'Ward_No'
                                                        },
                                                        labels: {
                                                            formatter: function(val) {
                                                                return val.toLocaleString('en-IN');
                                                            }
                                                        }
                                                    },
                                                    legend: {
                                                        position: 'top',
                                                        offsetY: 10
                                                    },
                                                    fill: {
                                                        opacity: 1
                                                    },
                                                    tooltip: {
                                                        y: {
                                                            formatter: function(val) {
                                                                return val.toLocaleString('en-IN');
                                                            }
                                                        }
                                                    }
                                                };

                                                var chartWardRevenueStatus = new ApexCharts(document.querySelector(
                                                        "#chartWardShopStatus<?php echo $sr_No; ?>"),
                                                    optionsWardShopStatus);
                                                chartWardRevenueStatus.render();
                                                </script>
                                            </div>
                                            <div class="tab-pane fade"
                                                id="Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-6">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr.No</th>
                                                                <th>Ward No</th>
                                                                <th>Residential</th>
                                                                <th>Commercial</th>
                                                                <th>Industrial</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                 $RTotal = 0;
                                                                 $CTotal = 0;
                                                                 $ITotal = 0;
                                                                 $GrandTotal = 0;
                                                                ?>
                                                            <?php
                                                                foreach ($nodeData as $key => $val) {
                                                                    $RTotal +=  $val['Residential'];
                                                                    $CTotal +=  $val['Commercial'];
                                                                    $ITotal +=  $val['Industrial'];
                                                                    $GrandTotal += $val['Total'];
                                                            ?>
                                                            <tr>
                                                                <td> <?= $key + 1 ?> </td>
                                                                <td><?= $val['Ward_No']; ?></td>
                                                                <td> <?= $val['Residential']; ?> </td>
                                                                <td> <?= $val['Commercial']; ?> </td>
                                                                <td><?= $val['Industrial']; ?> </td>
                                                                <td><?php echo $val['Total']; ?></td>
                                                            </tr>
                                                            <?php
                                                                }
                                                                ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Sub Total</th>
                                                                <th> <input type="hidden" value="<?php echo $RTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($RTotal); ?>
                                                                </th>
                                                                <th> <input type="hidden" value="<?php echo $CTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($CTotal); ?>
                                                                </th>
                                                                <th> <input type="hidden" value="<?php echo $ITotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($ITotal); ?>
                                                                </th>
                                                                <th> <input type="hidden"
                                                                        value="<?php echo $GrandTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($GrandTotal); ?>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                        <h6>Demand Status : <?php echo $nodeName; ?> -
                                            <?php echo "" . IND_money_format(count($nodeData)) . " Shops"; ?></h6>
                                        <!-- <span> By Ward Wise </span> -->
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                    id="Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>-tab"
                                                    data-bs-toggle="tab"
                                                    href="#Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>"><i
                                                        class="fa-solid fa-chart-pie"></i></a>
                                            </li>
                                            <li>
                                                <a class="nav-link"
                                                    id="Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>-tab"
                                                    data-bs-toggle="tab"
                                                    href="#Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>"><i
                                                        class="fa-solid fa-table"></i></a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="tab-content entry-main-content">
                                            <div class="tab-pane fade show active"
                                                id="Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>">
                                                <div style="height: 420px;"
                                                    id="chartWardRevenueStatus<?php echo $sr_No; ?>"></div>

                                                <script>
                                                var optionsWardShopStatus = {
                                                    series: [{
                                                            name: 'Residential',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => $d['Residential'], $nodeWiseRevenueData)); ?>
                                                            ]

                                                        },
                                                        {
                                                            name: 'Commercial',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => $d['Commercial'], $nodeWiseRevenueData)); ?>
                                                            ]
                                                        },
                                                        {
                                                            name: 'Industrial',
                                                            data: [
                                                                <?php echo implode(', ', array_map(fn($d) => ($d['Industrial']), $nodeWiseRevenueData)); ?>
                                                            ]
                                                        }
                                                    ],
                                                    chart: {
                                                        type: 'bar',
                                                        height: '400px',
                                                        stacked: false,
                                                        toolbar: {
                                                            show: false
                                                        }
                                                    },
                                                    colors: ['#2196f3', '#ff6d00', '#6200ea'],
                                                    plotOptions: {
                                                        bar: {
                                                            horizontal: false,
                                                            borderRadius: 4,
                                                            columnWidth: '30%',
                                                            dataLabels: {
                                                                position: 'top'
                                                            }
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: true,
                                                        formatter: function(val) {
                                                            return '₹' + val.toLocaleString('en-IN');
                                                        },
                                                        offsetY: -20,
                                                        style: {
                                                            fontSize: '12px',
                                                            colors: ["#304758"]
                                                        }
                                                    },
                                                    xaxis: {
                                                        categories: [
                                                            <?php echo implode(', ', array_map(fn($d) => '"Ward No. ' . $d['Ward_No'] . '"', $nodeWiseRevenueData)); ?>
                                                        ],
                                                        position: 'bottom',
                                                        labels: {
                                                            offsetY: 0
                                                        },
                                                        axisBorder: {
                                                            show: true
                                                        },
                                                        axisTicks: {
                                                            show: true
                                                        }
                                                    },
                                                    yaxis: {
                                                        title: {
                                                            text: 'Ward_No'
                                                        },
                                                        labels: {
                                                            formatter: function(val) {
                                                                return val.toLocaleString('en-IN');
                                                            }
                                                        }
                                                    },
                                                    legend: {
                                                        position: 'top',
                                                        offsetY: 10
                                                    },
                                                    fill: {
                                                        opacity: 1
                                                    },
                                                    tooltip: {
                                                        y: {
                                                            formatter: function(val) {
                                                                return '₹ ' + val.toLocaleString('en-IN');
                                                            }
                                                        }
                                                    }
                                                };


                                                var chartWardRevenueStatus = new ApexCharts(document.querySelector(
                                                        "#chartWardRevenueStatus<?php echo $sr_No; ?>"),
                                                    optionsWardShopStatus);
                                                chartWardRevenueStatus.render();
                                                </script>



                                            </div>
                                            <div class="tab-pane fade"
                                                id="Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-6">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr.No</th>
                                                                <th>Ward No</th>
                                                                <th>Residential</th>
                                                                <th>Commercial</th>
                                                                <th>Industrial</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $srNo = 0;
                                                                $RTotal = 0;
                                                                 $CTotal = 0;
                                                                 $ITotal = 0;
                                                                 $GrandTotal = 0;
                                                                foreach ($nodeWiseRevenueData as $key => $val) {
                                                                    $RTotal +=  $val['Residential'];
                                                                    $CTotal +=  $val['Commercial'];
                                                                    $ITotal +=  $val['Industrial'];
                                                                    $GrandTotal += $val['Total'];

                                                                    ?>
                                                            <tr>
                                                                <td> <?= $key + 1 ?> </td>
                                                                <td><?= $val['Ward_No']; ?></td>
                                                                <td> <?= $val['Residential']; ?> </td>
                                                                <td> <?= $val['Commercial']; ?> </td>
                                                                <td><?= $val['Industrial']; ?> </td>
                                                                <td><?php echo $val['Total']; ?></td>
                                                            </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Sub Total</th>
                                                                <th> <input type="hidden" value="<?php echo $RTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($RTotal); ?>
                                                                </th>
                                                                <th> <input type="hidden" value="<?php echo $CTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($CTotal); ?>
                                                                </th>
                                                                <th> <input type="hidden" value="<?php echo $ITotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($ITotal); ?>
                                                                </th>
                                                                <th> <input type="hidden"
                                                                        value="<?php echo $GrandTotal; ?>"
                                                                        id="TotalShopCount"><?php echo IND_money_format($GrandTotal); ?>
                                                                </th>

                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
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


</main>