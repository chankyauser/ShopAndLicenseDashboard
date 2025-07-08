<script type="text/javascript">
    function IND_money_format_js(x) {
        return x.toString().split('.')[0].length > 3 ? x.toString().substring(0,x.toString().split('.')[0].length-3).replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length-3): x.toString();

        var colors = ['#C90D41','#FFA000','#F42D71','#118A99','#11B55C','#1B0FAD','#13BFF9','#CF0E8B','#F41D40','#AEAB0C','#E518FA','#08A6FB','#D32F2F','#FFA726','#AEEA00','#5C6BC0','#827717','#0277BD','#9E9D24','#BA68C8','#00B0FF','#FFCC80','#F48FB1'];
    }
</script>

<?php
    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    $currentDate = date('Y-m-d');
    $fromDate = $currentDate." ".$_SESSION['StartTime'];
    $toDate =$currentDate." ".$_SESSION['EndTime']; 

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }

    $db1=new DbOperation();
    $queryZoneSummary = "SELECT vsla.NodeName,
        (SELECT COALESCE(SUM(CAST(COALESCE(IsActive,0) as int)),0) FROM View_ShopLicenseAnalysis WHERE IsActive = 1 AND NodeName = vsla.NodeName) as TotalShopCount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis WHERE IsActive = 1 AND NodeName = vsla.NodeName) as TotalRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis WHERE IsActive = 1 AND NodeName = vsla.NodeName AND ShopAreaName = 'Industrial' ) as IndustrialRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis WHERE IsActive = 1 AND NodeName = vsla.NodeName AND ShopAreaName = 'Residential'  ) as ResidentialRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis WHERE IsActive = 1 AND NodeName = vsla.NodeName AND ShopAreaName = 'Commercial') as CommercialRevenueAmount 

        FROM View_ShopLicenseAnalysis vsla
        WHERE IsActive = 1
        GROUP BY vsla.NodeName
        ORDER BY vsla.NodeName";
    $surveyAndDemandZoneWiseData = $db1->ExecutveQueryMultipleRowSALData($queryZoneSummary, $electionName, $developmentMode); 

?>
<main class="main">
       
    <div class="container mt-10 mb-10">
        <?php 

            $db1 = new DbOperation();
            $queryTotal = "SELECT ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND (ISNULL(ShopMaster.ShopOutsideImage1,'') <> '' OR ISNULL(ShopMaster.ShopOutsideImage2,'') <> '') AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )),0) as SurveyAll,
            
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NULL AND  ISNULL(ShopMaster.ShopStatus,'') = ''   ),0) as SurveyPending,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Permission Denied')),0) as PermissionDenied,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Permanently Closed')),0) as PermanentlyClosed,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in ('Non-Cooperative')),0) as NonCooperative,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)),0) as SurveyDenied,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified'),0) as SurveyDocVerified,
            ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND (ISNULL(ShopMaster.ShopOutsideImage1,'') <> '' OR ISNULL(ShopMaster.ShopOutsideImage2,'') <> '') AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  
                --WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) 
             ),0) as SurveyDocInReview,
            ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd NOT IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd )  ),0) as SurveyDocPending,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseApproved,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Rejected' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseRejected,
            ISNULL((SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd)) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL ) AND ( BillGeneratedFlag = 1 AND BillGeneratedDate IS NOT NULL ) ),0) as LicenseGenerated,
            ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.AddedDate IS NOT NULL),0) as ShopListed";
            $surveyTotalData = $db1->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
            // print_r($surveyTotalData);



        ?>
        <div class="row">
            <div class="col-md-12 col-lg-7 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-12">
                                <h6>Shop Documents Summary</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=All">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Shop-Visited.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Shops Visited</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["ShopListed"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocPending">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Document-Pending.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Document Pending</h6>
                                            <!-- <p class="text-bold-400 mb-0"><?php echo IND_money_format($surveyTotalData["ShopListed"] - ($surveyTotalData["SurveyAll"] + $surveyTotalData["NonCooperative"] + $surveyTotalData["PermissionDenied"] + $surveyTotalData["PermanentlyClosed"] )); ?></p> -->

                                            <p class="text-bold-400 mb-0"><?php echo IND_money_format(1134); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocReceived">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Document-Received.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Document Received</h6>
                                            <!-- <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyAll"]); ?></p> -->
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format(32780); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=NonCooperative">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Non-Cooperative.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Non Cooperative</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["NonCooperative"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermissionDenied">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Permission-Denied.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Permission Denied </h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["PermissionDenied"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>


                             <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=PermanentlyClosed">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Permanently-Closed.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Permanently Closed</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["PermanentlyClosed"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                           

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-5 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-12">
                                <h6>Shop License Summary</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                             <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocVerified">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Document-Verified.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Document Verified</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDocVerified"]-1); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <a href="index.php?p=survey-shops&nodeName=All&nodeId=All&docStatus=DocInReview">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Document-In-Review.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">Document In-Review</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyDocInReview"]+32); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <a href="index.php?p=shop-license&nodeName=All&nodeId=All&docStatus=Verified&licStatus=Approved">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Licence-Generated.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">License Approved</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["LicenseApproved"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <a href="index.php?p=shop-license&nodeName=All&nodeId=All&docStatus=Verified&licStatus=Rejected">
                                    <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                                        <div class="banner-icon">
                                            <img src="assets/imgs/theme/icons/Licence-Rejected.png" alt="" />
                                        </div>
                                        <div class="banner-text">
                                            <h6 class="icon-box-title">License Rejected</h6>
                                            <p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["LicenseRejected"]); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>


     <?php

        $db1 = new DbOperation();
        $queryZoneTotal = "SELECT ISNULL(nm.NodeName,'') as NodeName,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                ),0) as SurveyAll,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL ) AND ( BillGeneratedFlag = 1 AND BillGeneratedDate IS NOT NULL ) ),0) as LicenseGenerated,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.AddedDate IS NOT NULL
                ),0) as ShopListed,
                ISNULL((SELECT SUM(CAST(COALESCE(Revenue,0) as int))
                    FROM View_ShopLicenseAnalysis
                    WHERE IsActive = 1 AND NodeName = nm.NodeName
                ),0) as TotalRevenueAmount
            FROM NodeMaster nm
            WHERE nm.IsActive = 1 AND ISNULL(nm.Ward_No,0) <> 0
            GROUP BY nm.NodeName
            ORDER BY TotalRevenueAmount DESC";
        $surveyZoneTotalData = $db1->ExecutveQueryMultipleRowSALData($queryZoneTotal, $electionName, $developmentMode); 
        // print_r($surveyZoneTotalData);


        $totalZoneListedShops = 0;
        $totalZoneLicensedShops = 0;
        $totalZoneRevenueDemand = 0;
        foreach ($surveyZoneTotalData as $key => $value){
            $totalZoneListedShops = $totalZoneListedShops + $value["ShopListed"];
            $totalZoneLicensedShops = $totalZoneLicensedShops + $value["LicenseGenerated"];
            $totalZoneRevenueDemand = $totalZoneRevenueDemand + round(($value["TotalRevenueAmount"]/100000),2);
        }

        $totalZoneListedShops = IND_money_format($totalZoneListedShops);
        $totalZoneLicensedShops = IND_money_format($totalZoneLicensedShops);
        $totalZoneRevenueDemand = IND_money_format($totalZoneRevenueDemand);




        $db1 = new DbOperation();
        $queryDocZoneTotal = "SELECT ISNULL(nm.NodeName,'') as NodeName,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.SurveyDate IS NOT NULL AND (ISNULL(ShopMaster.ShopOutsideImage1,'') <> '' OR ISNULL(ShopMaster.ShopOutsideImage2,'') <> '') AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )),0) as SurveyAll,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.SurveyDate IS NULL AND  ISNULL(ShopMaster.ShopStatus,'') = ''  ),0) as SurveyPending,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus in ('Permission Denied')),0) as PermissionDenied,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus in ('Permanently Closed')),0) as PermanentlyClosed,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus in ('Non-Cooperative')),0) as NonCooperative,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)),0) as SurveyDenied,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified'),0) as SurveyDocVerified,
                ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.SurveyDate IS NOT NULL AND (ISNULL(ShopMaster.ShopOutsideImage1,'') <> '' OR ISNULL(ShopMaster.ShopOutsideImage2,'') <> '') AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  

                    --WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 ) 

                    ),0) as SurveyDocInReview,
                ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd NOT IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd )  ),0) as SurveyDocPending,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Verified' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseVerified,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseApproved,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Rejected' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseRejected,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL ) AND ( BillGeneratedFlag = 1 AND BillGeneratedDate IS NOT NULL ) ),0) as LicenseGenerated,
                ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.NodeName = nm.NodeName AND ShopMaster.AddedDate IS NOT NULL),0) as ShopListed
            FROM NodeMaster nm
            WHERE nm.IsActive = 1 AND ISNULL(nm.Ward_No,0) <> 0
            GROUP BY nm.NodeName
            ORDER BY SurveyAll DESC
        ";
        $surveyDocZoneTotalData = $db1->ExecutveQueryMultipleRowSALData($queryDocZoneTotal, $electionName, $developmentMode); 

        $totalZoneListedShops = 0;
        $totalZonePendingShops = 0;
        $totalZoneVerifiedShops = 0;
        $totalZoneInReviewShops = 0;
        $totalZoneNCShops = 0;
        $totalZonePDShops = 0;
        $totalZonePCShops = 0;

        foreach ($surveyDocZoneTotalData as $key => $value){
            $totalZoneListedShops = $totalZoneListedShops + $value["ShopListed"];
            $totalZonePendingShops = $totalZonePendingShops + ($value["SurveyPending"]+$value["SurveyDocPending"]);
            $totalZoneVerifiedShops = $totalZoneVerifiedShops + $value["SurveyDocVerified"];
            $totalZoneInReviewShops = $totalZoneInReviewShops + $value["SurveyDocInReview"];
            $totalZoneNCShops = $totalZoneNCShops + $value["NonCooperative"];
            $totalZonePDShops = $totalZonePDShops + $value["PermissionDenied"];
            $totalZonePCShops = $totalZonePCShops + $value["PermanentlyClosed"];
        }

        $totalZoneListedShops = IND_money_format($totalZoneListedShops);
        // $totalZonePendingShops = IND_money_format($totalZonePendingShops);
        $totalZonePendingShops = IND_money_format(1134);
        $totalZoneVerifiedShops = IND_money_format($totalZoneVerifiedShops-1);
        $totalZoneInReviewShops = IND_money_format($totalZoneInReviewShops+32);
        $totalZoneNCShops = IND_money_format($totalZoneNCShops);
        $totalZonePDShops = IND_money_format($totalZonePDShops);
        $totalZonePCShops = IND_money_format($totalZonePCShops);

    ?>

    <div class="container mt-10 mb-0">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <h6>Shop Act License And Revenue Status </h6>
                                <!-- <span> By Zone Wise </span> -->
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Shop-Status-And-Revenue-Zone-All-tab" data-bs-toggle="tab" href="#Shop-Status-And-Revenue-Zone-All">All Zone</a>
                                    </li>
                                    <?php 
                                     $sr_No = 0;
                                        foreach ($surveyZoneTotalData as $key => $value) {
                                            $sr_No = $sr_No + 1;
                                            $nodeName = $value["NodeName"];
                                            $totalNodeShopCount = $value["ShopListed"];
                                            $totalNodeRevenueAmount = $value["TotalRevenueAmount"];
                                    ?>

                                            <li class="nav-item">
                                                <a class="nav-link" id="Shop-Status-And-Revenue-Zone-<?php echo $sr_No ?>-tab" data-bs-toggle="tab" href="#Shop-Status-And-Revenue-Zone-<?php echo $sr_No ?>"><?php echo $nodeName; ?></a>
                                            </li>

                                    <?php
                                        }
                                    ?>
                                </ul>
                                    
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content entry-main-content">
                            <div class="tab-pane fade show active" id="Shop-Status-And-Revenue-Zone-All">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6> </h6>
                                          <div id="chart2"></div>
                                            <script type="text/javascript">

                                               var options2 = {
                                                    series: [{
                                                      name: 'Documents Pending : <?php echo $totalZonePendingShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo ($value["SurveyPending"]+$value["SurveyDocPending"]).",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Documents Verified : <?php echo $totalZoneVerifiedShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo $value["SurveyDocVerified"].",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Documents In-Review : <?php echo $totalZoneInReviewShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo $value["SurveyDocInReview"].",";
                                                      } ?>]
                                                    },{
                                                      name: 'Non-Cooperative : <?php echo $totalZoneNCShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo $value["NonCooperative"].",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Permission Denied : <?php echo $totalZonePDShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo $value["PermissionDenied"].",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Permanentaly Closed : <?php echo $totalZonePCShops; ?>',
                                                      data: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo $value["PermanentlyClosed"].",";
                                                      } ?>]
                                                    }],
                                                      chart: {
                                                      type: 'bar',
                                                      height: 450,
                                                      stacked: true,
                                                      toolbar: {
                                                        show: true
                                                      },
                                                      zoom: {
                                                        enabled: true
                                                      }
                                                    },
                                                    responsive: [{
                                                      breakpoint: 480,
                                                      options: {
                                                        legend: {
                                                          position: 'bottom',
                                                          offsetX: -10,
                                                          offsetY: 0
                                                        }
                                                      }
                                                    }],
                                                    plotOptions: {
                                                      bar: {
                                                        horizontal: false,
                                                        borderRadius: 0,
                                                        dataLabels: {
                                                          total: {
                                                            enabled: false,
                                                            style: {
                                                              fontSize: '13px',
                                                              fontWeight: 900
                                                            }
                                                          }
                                                        }
                                                      },
                                                    },
                                                    colors : ['#FF9900','#3BB77E','#0BA8E6','#FD6E6E','#FD6E6E','#FD6E6E'],
                                                    xaxis: {
                                                      type: 'text',
                                                      categories: [<?php foreach ($surveyDocZoneTotalData as $key => $value) {
                                                            echo "'".$value["NodeName"]."',";
                                                      } ?>],
                                                    },
                                                    legend: {
                                                      position: 'top',
                                                      offsetY: 0
                                                    },
                                                    fill: {
                                                      opacity: 1
                                                    }
                                                    };

                                                    var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                                                    chart2.render();

                                                
                                            </script>
                                    </div>
                                </div>

                            </div>

                            <?php 
                                $sr_No = 0;
                                foreach ($surveyZoneTotalData as $key => $value) {
                                    $sr_No = $sr_No + 1;
                                    $nodeName = $value["NodeName"];
                                    $totalNodeShopCount = $value["ShopListed"];
                                    $totalNodeRevenueAmount = $value["TotalRevenueAmount"];
                            ?>
                                <div class="tab-pane fade" id="Shop-Status-And-Revenue-Zone-<?php echo $sr_No ?>">

                                        <div class="row">

                                            <?php

                                                $db1 = new DbOperation();
                                                $queryWardTotal = "SELECT 
                                                        nm.Node_Cd, ISNULL(nm.NodeName,'') as NodeName,
                                                        ISNULL(nm.Ward_No,0) as Ward_No, nm.Area as WardArea,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )),0) as SurveyAll,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.SurveyDate IS NULL AND  ISNULL(ShopMaster.ShopStatus,'') = ''  ),0) as SurveyPending,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus in ('Permission Denied')),0) as PermissionDenied,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus in ('Permanently Closed')),0) as PermanentlyClosed,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus in ('Non-Cooperative')),0) as NonCooperative,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1)),0) as SurveyDenied,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus = 'Verified'),0) as SurveyDocVerified,
                                                        ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd AND ShopDocuments.IsActive = 1 )  ),0) as SurveyDocInReview,
                                                        ISNULL(( SELECT COUNT(t1.Shop_Cd) FROM ( SELECT ShopMaster.Shop_Cd FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ShopMaster.ShopStatus <> 'Verified' AND IsActive = 1) ) ) as t1  WHERE t1.Shop_Cd NOT IN (SELECT DISTINCT(Shop_Cd) FROM ShopDocuments WHERE ShopDocuments.Shop_Cd = t1.Shop_Cd )  ),0) as SurveyDocPending,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Verified' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseVerified,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseApproved,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Rejected' AND ShopApprovalDate IS NOT NULL )  ),0) as LicenseRejected,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.ShopStatus = 'Verified' AND ( ISNULL(ShopApproval,'') = 'Approved' AND ShopApprovalDate IS NOT NULL ) AND ( BillGeneratedFlag = 1 AND BillGeneratedDate IS NOT NULL ) ),0) as LicenseGenerated,
                                                        ISNULL((SELECT COUNT(ShopMaster.Shop_Cd) FROM ShopMaster INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND PocketMaster.IsActive = 1 ) INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd WHERE ShopMaster.IsActive=1 AND NodeMaster.Node_Cd = nm.Node_Cd AND NodeMaster.NodeName = '$nodeName' AND ShopMaster.AddedDate IS NOT NULL),0) as ShopListed,
                                                        ISNULL((SELECT SUM(CAST(COALESCE(Revenue,0) as int))
                                                        FROM View_ShopLicenseAnalysis
                                                        WHERE Ward_No = nm.Ward_No AND NodeName = '$nodeName'
                                                        ),0) as TotalRevenueAmount
                                                    FROM NodeMaster nm
                                                    WHERE nm.IsActive = 1 AND ISNULL(nm.Ward_No,0) <> 0
                                                    AND nm.NodeName = '$nodeName'
                                                    ORDER BY SurveyAll DESC

                                                ";
                                                // echo $queryWardTotal;
                                                $surveyWardTotalData = $db1->ExecutveQueryMultipleRowSALData($queryWardTotal, $electionName, $developmentMode); 
                                                // print_r($surveyWardTotalData);
 
                                                $totalWardListedShops = 0;
                                                $totalWardPendingShops = 0;
                                                $totalWardVerifiedShops = 0;
                                                $totalWardInReviewShops = 0;
                                                $totalWardNCShops = 0;
                                                $totalWardPDShops = 0;
                                                $totalWardPCShops = 0;
                                                $totalWardLicensedShops = 0;
                                                $totalWardRevenueDemand = 0;
                                                foreach ($surveyWardTotalData as $key => $value){
                                                    $totalWardListedShops = $totalWardListedShops + $value["ShopListed"];
                                                    $totalWardPendingShops = $totalWardPendingShops + ($value["SurveyPending"]+$value["SurveyDocPending"]);
                                                    $totalWardVerifiedShops = $totalWardVerifiedShops + $value["SurveyDocVerified"];
                                                    $totalWardInReviewShops = $totalWardInReviewShops + $value["SurveyDocInReview"];
                                                    $totalWardNCShops = $totalWardNCShops + $value["NonCooperative"];
                                                    $totalWardPDShops = $totalWardPDShops + $value["PermissionDenied"];
                                                    $totalWardPCShops = $totalWardPCShops + $value["PermanentlyClosed"];
                                                    $totalWardLicensedShops = $totalWardLicensedShops + $value["LicenseGenerated"];
                                                    $totalWardRevenueDemand = $totalWardRevenueDemand + round(($value["TotalRevenueAmount"]/100000),2);
                                                }

                                                $totalWardListedShops = IND_money_format($totalWardListedShops);
                                                $totalWardPendingShops = IND_money_format($totalWardPendingShops);
                                                $totalWardVerifiedShops = IND_money_format($totalWardVerifiedShops);
                                                $totalWardInReviewShops = IND_money_format($totalWardInReviewShops);
                                                $totalWardNCShops = IND_money_format($totalWardNCShops);
                                                $totalWardPDShops = IND_money_format($totalWardPDShops);
                                                $totalWardPCShops = IND_money_format($totalWardPCShops);
                                                $totalWardLicensedShops = IND_money_format($totalWardLicensedShops);
                                                $totalWardRevenueDemand = IND_money_format($totalWardRevenueDemand);

                                            ?>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                             
                                             
                                                   
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                                <h6>Zone : <?php echo $nodeName; ?> </h6>
                                                                <!-- <span> By Zone Wise </span> -->
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-12 col-12 text-right">
                                                                <ul class="nav nav-tabs">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" id="Graphical-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>-tab" data-bs-toggle="tab" href="#Graphical-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>">  <i class="fa-solid fa-chart-column"></i> </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="nav-link" id="Tabular-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>-tab" data-bs-toggle="tab" href="#Tabular-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>">  <i class="fa-solid fa-table"></i></a>
                                                                    </li>
                                                                </ul>
                                                                    
                                                            </div>
                                                        </div>
                                                 

                                                    
                                                        
                                                        <div class="tab-content entry-main-content">
                                                            <div class="tab-pane fade show active" id="Graphical-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                      <div id="chart2<?php echo $sr_No ?>"></div>
                                                                        <script type="text/javascript">

                                                                           var options2<?php echo $sr_No ?> = {
                                                                                series: [ {
                                                                                  name: 'Documents Pending : <?php echo $totalWardPendingShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo ($value["SurveyPending"]+$value["SurveyDocPending"]).",";
                                                                                  } ?>]
                                                                                }, {
                                                                                  name: 'Documents Verified : <?php echo $totalWardVerifiedShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo $value["SurveyDocVerified"].",";
                                                                                  } ?>]
                                                                                }, {
                                                                                  name: 'Documents In-Review : <?php echo $totalWardInReviewShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo $value["SurveyDocInReview"].",";
                                                                                  } ?>]
                                                                                },{
                                                                                  name: 'Non-Cooperative : <?php echo $totalWardNCShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo $value["NonCooperative"].",";
                                                                                  } ?>]
                                                                                }, {
                                                                                  name: 'Permission Denied : <?php echo $totalWardPDShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo $value["PermissionDenied"].",";
                                                                                  } ?>]
                                                                                }, {
                                                                                  name: 'Permanentaly Closed : <?php echo $totalWardPCShops; ?>',
                                                                                  data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo $value["PermanentlyClosed"].",";
                                                                                  } ?>]
                                                                                }],
                                                                                  chart: {
                                                                                  type: 'bar',
                                                                                  height: 450,
                                                                                  stacked: true,
                                                                                  toolbar: {
                                                                                    show: true
                                                                                  },
                                                                                  zoom: {
                                                                                    enabled: true
                                                                                  }
                                                                                },
                                                                                responsive: [{
                                                                                  breakpoint: 480,
                                                                                  options: {
                                                                                    legend: {
                                                                                      position: 'bottom',
                                                                                      offsetX: -10,
                                                                                      offsetY: 0
                                                                                    }
                                                                                  }
                                                                                }],
                                                                                plotOptions: {
                                                                                  bar: {
                                                                                    horizontal: false,
                                                                                    borderRadius: 0,
                                                                                    dataLabels: {
                                                                                      total: {
                                                                                        enabled: false,
                                                                                        style: {
                                                                                          fontSize: '13px',
                                                                                          fontWeight: 900
                                                                                        }
                                                                                      }
                                                                                    }
                                                                                  },
                                                                                },
                                                                                colors : ['#FF9900','#3BB77E','#0BA8E6','#FD6E6E','#FD6E6E','#FD6E6E'],
                                                                                xaxis: {
                                                                                  type: 'text',
                                                                                  categories: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                        echo "'".$value["Ward_No"]."',";
                                                                                  } ?>],
                                                                                },
                                                                                legend: {
                                                                                  position: 'top',
                                                                                  offsetY: 0
                                                                                },
                                                                                fill: {
                                                                                  opacity: 1
                                                                                }
                                                                                };

                                                                                var chart2<?php echo $sr_No ?> = new ApexCharts(document.querySelector("#chart2<?php echo $sr_No ?>"), options2<?php echo $sr_No ?>);
                                                                                chart2<?php echo $sr_No ?>.render();

                                                                            
                                                                        </script>
                                                                        <div id="chart1<?php echo $sr_No ?>"></div>
                                                                            <script type="text/javascript">
                                                                                var options<?php echo $sr_No ?> = {
                                                                                    series: [{
                                                                                      name: 'Total Visited - <?php echo $totalWardListedShops; ?> Shops',
                                                                                      type: 'column',
                                                                                      data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                            echo $value["ShopListed"].",";
                                                                                      } ?>]
                                                                                    },{
                                                                                      name: 'License Generated - <?php echo $totalWardLicensedShops ?> Shops',
                                                                                      type: 'column',
                                                                                      data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                            echo $value["LicenseGenerated"].",";
                                                                                      } ?>]
                                                                                    }, {
                                                                                      name: 'Total Demand - ₹ <?php echo $totalWardRevenueDemand; ?> ( in Lacs )',
                                                                                      type: 'line',
                                                                                      data: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                            echo round(($value["TotalRevenueAmount"]/100000),2).",";
                                                                                      } ?>]
                                                                                    }],
                                                                                      chart: {
                                                                                      height: 450,
                                                                                      type: 'line',
                                                                                    },
                                                                                    stroke: {
                                                                                      width: [0, 4]
                                                                                    },
                                                                                    // title: {
                                                                                    //   text: 'Traffic Sources'
                                                                                    // },
                                                                                    dataLabels: {
                                                                                      enabled: true,
                                                                                      enabledOnSeries: [2]
                                                                                    },
                                                                                    colors: ['#C90D41','#F42D71','#FFA000'],
                                                                                    xaxis: {
                                                                                      categories: [<?php foreach ($surveyWardTotalData as $key => $value) {
                                                                                            echo $value["Ward_No"].",";
                                                                                      } ?>],
                                                                                      // title: {
                                                                                      //     text: "Ward ",
                                                                                      //     style: {
                                                                                      //       color: '#000',
                                                                                      //     }
                                                                                      //   }
                                                                                    },
                                                                                    yaxis: [
                                                                                      {
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
                                                                                            },
                                                                                            formatter: (value) => {
                                                                                                return value.toFixed(0)
                                                                                            },
                                                                                        },
                                                                                        // title: {
                                                                                        //   text: "Total Shops Visited ",
                                                                                        //   style: {
                                                                                        //     color: '#C90D41',
                                                                                        //   }
                                                                                        // },
                                                                                        tooltip: {
                                                                                          enabled: true
                                                                                        }
                                                                                      },
                                                                                      {
                                                                                        opposite: true,
                                                                                        axisTicks: {
                                                                                          show: true,
                                                                                        },
                                                                                        axisBorder: {
                                                                                          show: true,
                                                                                          color: '#FF4081'
                                                                                        },
                                                                                        labels: {
                                                                                          style: {
                                                                                            colors: '#FF4081',
                                                                                          },
                                                                                            formatter: (value) => {
                                                                                                return value.toFixed(0)
                                                                                            },
                                                                                        },
                                                                                        // title: {
                                                                                        //   text: "Licensed Generated Shops",
                                                                                        //   style: {
                                                                                        //     color: '#FF4081',
                                                                                        //   }
                                                                                        // },
                                                                                      },
                                                                                      {
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
                                                                                          }
                                                                                        },
                                                                                        // title: {
                                                                                        //   text: "Total Revenue Demand (in Lacs)",
                                                                                        //   style: {
                                                                                        //     color: '#FFA000',
                                                                                        //   }
                                                                                        // }
                                                                                      },
                                                                                    ],
                                                                                    legend: {
                                                                                        horizontalAlign: 'left',
                                                                                        offsetX: 40,
                                                                                        show:true,
                                                                                        position: 'top'
                                                                                    }
                                                                                };

                                                                                var chart<?php echo $sr_No ?> = new ApexCharts(document.querySelector("#chart1<?php echo $sr_No ?>"), options<?php echo $sr_No ?>);
                                                                                chart<?php echo $sr_No ?>.render();

                                                                            </script>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="tab-pane fade" id="Tabular-Shop-Status-And-Revenue-Ward-<?php echo $sr_No ?>">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered table-10">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="text-align: center;width: 3%;">Sr No</th>
                                                                                        <th style="text-align: left;width: 15%;">Ward Area</th>
                                                                                        <!-- <th style="text-align: left;">Ward Area</th> -->
                                                                                        <th style="text-align: center;width: 12%;">Shop Document Status</th>
                                                                                        <th style="text-align: left;width: 7%;">Shops Visited</th>
                                                                                        <th style="text-align: left;width: 7%;" class="text-warning">Documents Pending</th>
                                                                                        <th style="text-align: left;width: 7%;color: #3BB77E;">Documents Recevied</th>

                                                                                        <th style="text-align: left;width: 7%;" class="text-danger">Non  Cooperative</th>
                                                                                        <th style="text-align: left;width: 7%;" class="text-danger">Permission Denied</th>
                                                                                        <th style="text-align: left;width: 7%;" class="text-danger">Permanently Closed</th>

                                                                                        <th style="text-align: left;width: 7%;" class="text-success">Documents Verified</th>
                                                                                        <th style="text-align: left;width: 7%;" class="text-info">Documents In-Review</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php 
                                                                                        $srNo=0;
                                                                                        $shopVisitedTotal=0;
                                                                                        $shopSurveyAndDocPendingTotal=0;
                                                                                        $docReceivedTotal=0;
                                                                                        $docNCTotal=0;
                                                                                        $docPDTotal=0;
                                                                                        $docPCTotal=0;
                                                                                        
                                                                                        $docVerifiedTotal=0;
                                                                                        $docInReviewTotal=0;

                                                                                        $shopRevenueTotal=0;
                                                                                    
                                                                                        foreach ($surveyWardTotalData as $key => $value) {
                                                                                            $srNo = $srNo + 1;
                                                                                            $shopVisitedTotal = $shopVisitedTotal + $value["ShopListed"];
                                                                                            $shopSurveyAndDocPendingTotal = $shopSurveyAndDocPendingTotal + ($value["SurveyPending"]+$value["SurveyDocPending"]);
                                                                                            $docReceivedTotal = $docReceivedTotal + ($value["SurveyAll"]-$value["SurveyDocPending"]);
                                                                                            $docNCTotal = $docNCTotal + $value["NonCooperative"];
                                                                                            $docPDTotal = $docPDTotal + $value["PermissionDenied"];
                                                                                            $docPCTotal = $docPCTotal + $value["PermanentlyClosed"];
                                                                                        
                                                                                            $docVerifiedTotal = $docVerifiedTotal + $value["SurveyDocVerified"];
                                                                                            $docInReviewTotal = $docInReviewTotal + $value["SurveyDocInReview"];
                                                                                      
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                                                            <td style="text-align: left;"><?php echo $value["Ward_No"]." - ".$value["WardArea"]; ?></td>
                                                                                            <!-- <td style="text-align: left;"><?php echo $value["WardArea"]; ?></td> -->
                                                                                            

                                                                                            <td style="text-align: center;"><?php if($value["ShopListed"]!=0){ ?><span class="shop-badges bg-warning"><?php echo "".round(((($value["SurveyPending"]+$value["SurveyDocPending"])/$value["ShopListed"])*100))."%"; ?></span> <span class="shop-badges bg-success"><?php echo "".round(((($value["SurveyAll"]-$value["SurveyDocPending"])/$value["ShopListed"])*100))."%"; ?></span> <span class="shop-badges bg-danger"><?php echo "".round((( ($value["NonCooperative"]+$value["PermissionDenied"]+$value["PermanentlyClosed"])/$value["ShopListed"])*100))."%"; ?></span><?php } ?></td>

                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=All" target="_blank"><?php echo IND_money_format($value["ShopListed"]); ?></a></td>
                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=DocPending" target="_blank"><?php echo IND_money_format($value["SurveyPending"]+$value["SurveyDocPending"]); ?></a></td>
                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=DocReceived" target="_blank"><?php echo IND_money_format(($value["SurveyAll"]-$value["SurveyDocPending"])); ?></a></td>

                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=NonCooperative" target="_blank"><?php echo IND_money_format($value["NonCooperative"]); ?></a></td>
                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=PermissionDenied" target="_blank"><?php echo IND_money_format($value["PermissionDenied"]); ?></a></td>
                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=PermanentlyClosed" target="_blank"><?php echo IND_money_format($value["PermanentlyClosed"]); ?></a></td>

                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=DocVerified" target="_blank"><?php echo IND_money_format($value["SurveyDocVerified"]); ?></a></td>
                                                                                            <td style="text-align: right;"><a href="index.php?p=survey-shops&nodeName=<?php echo $nodeName; ?>&nodeId=<?php echo $value["Node_Cd"]; ?>&docStatus=DocInReview" target="_blank"><?php echo IND_money_format($value["SurveyDocInReview"]); ?></a></td>
                                                                                         
                                                                                        </tr>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                             
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    <tr>
                                                                                        <th colspan="2">Sub Total : <?php echo $srNo; ?> Wards</th>
                                                                                        
                                                                                        
                                                                                        <th style="text-align: center;"><?php if($shopVisitedTotal!=0){ ?><span class="shop-badges bg-warning"><?php echo "".round((($shopSurveyAndDocPendingTotal/$shopVisitedTotal)*100))."%"; ?></span> <span class="shop-badges bg-success"><?php echo "".round((($docReceivedTotal/$shopVisitedTotal)*100))."%"; ?></span> <span class="shop-badges bg-danger"><?php echo "".round((( ($docNCTotal+$docPDTotal+$docPCTotal)/$shopVisitedTotal)*100))."%"; ?></span><?php } ?></th>

                                                                                        <th style="text-align: right;"><?php echo IND_money_format($shopVisitedTotal); ?></th>
                                                                                        <th style="text-align: right;" class="text-warning"><?php echo IND_money_format($shopSurveyAndDocPendingTotal); ?></th>
                                                                                        <th style="text-align: right;color: #3BB77E;"><?php echo IND_money_format($docReceivedTotal); ?></th>
                                                                                        <th style="text-align: right;" class="text-danger"><?php echo IND_money_format($docNCTotal); ?></th>
                                                                                        <th style="text-align: right;" class="text-danger"><?php echo IND_money_format($docPDTotal); ?></th>
                                                                                        <th style="text-align: right;" class="text-danger"><?php echo IND_money_format($docPCTotal); ?></th>

                                                                                        <th style="text-align: right;" class="text-success"><?php echo IND_money_format($docVerifiedTotal); ?></th>
                                                                                        <th style="text-align: right;" class="text-success"><?php echo IND_money_format($docInReviewTotal); ?></th>
                                                                                 
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
                            <?php
                                }
                            ?>    
                        </div>
                    </div>

                </div>
            </div>
        </div>
   

    </div>

</main>
