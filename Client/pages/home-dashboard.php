<?php

    $db=new DbOperation();
    $db2=new DbOperation();

    // echo "<pre>"; print_r($_SESSION);exit;

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
?>


<script type="text/javascript">
    function IND_money_format_js(x) {
        return x.toString().split('.')[0].length > 3 ? x.toString().substring(0,x.toString().split('.')[0].length-3).replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length-3): x.toString();
    }

    var colors = ['#C90D41','#FFA000','#F42D71','#118A99','#11B55C','#1B0FAD','#13BFF9','#CF0E8B','#F41D40','#AEAB0C','#E518FA','#08A6FB','#D32F2F','#FFA726','#AEEA00','#5C6BC0','#827717','#0277BD','#9E9D24','#BA68C8','#00B0FF','#FFCC80','#F48FB1'];
</script>
<?php

            // $query2 = "SELECT
            // (select 
            // count(distinct(td.Shop_Cd))
            // from TransactionDetails td 
            // WHERE td.Shop_Cd is not null
            // and TransStatus = 'Done') as ShopLicensee,
            // (select ISNULL(sum(case when isnull(ShopCategory,'') = 'Done' then 1 else 0 end),0) from ShopMaster) as SurveyCompleted,
            // (select count(distinct(Pocket_Cd)) from ShopMaster where SRExecutive_Cd <> 0) as SurveyPockets,
            // (select 
            // sum(cast (Amount as int))
            // from TransactionDetails td 
            // WHERE td.Shop_Cd is not null
            // and TransStatus = 'Done') as RevenueCollected
            // ";

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
        // print_r($surveyTotalData);


    $queryDemandRevenueSummary = "SELECT
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) ) as TotalRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND ShopAreaName = 'Industrial' ) as IndustrialRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND ShopAreaName = 'Residential'  ) as ResidentialRevenueAmount,
        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND ShopAreaName = 'Commercial') as CommercialRevenueAmount ";
    $demandRevenueSummaryData = $db1->ExecutveQuerySingleRowSALData($queryDemandRevenueSummary, $electionName, $developmentMode); 
?>

<main class="main">
       
    <div class="container mt-10 mb-10">

        <div class="row">
            <div class="col-md-12 col-lg-7 col-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Welcome <?php if(isset($_SESSION['SAL_FullName'])){ echo $_SESSION['SAL_FullName']." !"; } ?></h6>
                        <span> Shop Act License Summary </span>
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
                                            <!-- <p class="text-bold-700 mb-0"><?php echo IND_money_format( ( ($surveyTotalData["ShopListed"]-$surveyTotalData["SurveyAll"]) - $surveyTotalData["SurveyDenied"] ) ); ?></p> -->
                                            <!--<p class="text-bold-400 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyPending"]+$surveyTotalData["SurveyDocPending"]); ?></p>-->
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
                                            <!--<p class="text-bold-700 mb-0"><?php echo IND_money_format($surveyTotalData["SurveyAll"]-$surveyTotalData["SurveyDocPending"]); ?></p>-->
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
                        <h6>Total Demand :  <i class="fa-solid fa-indian-rupee-sign"></i> <?php echo IND_money_format($demandRevenueSummaryData["TotalRevenueAmount"])."/-"; ?></h6>
                        <!-- <span> By Category Wise </span> -->
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div id="chartTotalDemand" style="height: 187px;" ></div>
                                <script type="text/javascript">

                                   var optionsTotalDemand = {
                                                    series: [<?php echo $demandRevenueSummaryData["ResidentialRevenueAmount"]; ?>, <?php echo $demandRevenueSummaryData["CommercialRevenueAmount"]; ?>, <?php echo $demandRevenueSummaryData["IndustrialRevenueAmount"]; ?>],
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
                                                                return val + " - ₹" + IND_money_format_js(opts.w.globals.series[opts.seriesIndex]) + "/-"
                                                            }
                                                        },
                                                        labels: [ "Residential", "Commercial", "Industrial"],
                                                        responsive: [{
                                                          breakpoint: 480,
                                                          options: {
                                                            legend: {
                                                              position: 'top'
                                                            }
                                                          }
                                                        }]
                                                    };
                                          

                                                    var chartTotalDemand = new ApexCharts(document.querySelector("#chartTotalDemand"), optionsTotalDemand);
                                                    chartTotalDemand.render();
                                       
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>

    </div>


        <?php 
            
                // $queryCatSummary = "SELECT 
                //                 ISNULL(ShopCategory,'') as ShopCategory,
                //                 ISNULL(COUNT(DISTINCT(Shop_Cd)),0) as ShopCount,
                //                 ISNULL((
                //                     SELECT COUNT(Shop_Cd) FROM ShopMaster WHERE IsActive=1
                //                     AND AddedDate is not Null
                //                 ),0) as TotalShops,
                //                 (SELECT 
                //                     COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                //                 FROM View_ShopLicenseAnalysis
                //                 WHERE IsActive = 1 AND ShopCategory = ShopMaster.ShopCategory ) as RevenueAmount
                //             FROM ShopMaster 
                //             WHERE IsActive=1
                //             AND AddedDate is not Null
                //             GROUP BY ShopCategory
                //             ORDER BY RevenueAmount DESC";
                /*New - Parwana Master */
                $queryCatSummary = "SELECT 
                                        ISNULL(ParwanaMaster.Category,'') as ShopCategory,
                                        ISNULL(COUNT(DISTINCT(ShopMaster.Shop_Cd)),0) as ShopCount,
                                        ISNULL((
                                            SELECT COUNT(Shop_Cd) FROM ShopMaster WHERE IsActive=1
                                            AND AddedDate is not Null
                                        ),0) as TotalShops,
                                        (SELECT 
                                            COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                                        FROM View_ShopLicenseAnalysis
                                        WHERE IsActive = 1 AND ShopCategory = ParwanaMaster.Category ) as RevenueAmount
                                    FROM ShopMaster 
                                    INNER JOIN ParwanaDetails on ParwanaDetails.ParwanaDetCd = ShopMaster.ParwanaDetCd
                                    INNER JOIN ParwanaMaster ON ParwanaDetails.Parwana_Cd = ParwanaMaster.Parwana_Cd
                                    WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                                    GROUP BY ParwanaMaster.Category
                                    ORDER BY RevenueAmount DESC";

                 $surveyCategoryWiseData = $db1->ExecutveQueryMultipleRowSALData($queryCatSummary, $electionName, $developmentMode); 

                //  $queryBusinessCatSummary = "SELECT
                //     ISNULL(bcm.BusinessCat_Cd,0) as BusinessCat_Cd,
                //     ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
                //     ISNULL(bcm.BusinessCatNameMar,'') as BusinessCatNameMar,
                //     ISNULL(bcm.BusinessCatImage,'') as BusinessCatImage,
                //     ISNULL(COUNT(DISTINCT(sm.Shop_Cd)),0) as ShopCount,
                //     ISNULL((
                //         SELECT COUNT(Shop_Cd) FROM ShopMaster WHERE IsActive=1
                //         AND AddedDate is not Null
                //     ),0) as TotalShops,
                //     (SELECT 
                //         COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                //     FROM View_ShopLicenseAnalysis
                //     WHERE IsActive = 1 AND BusinessCatName = (SELECT BusinessCatName FROM BusinessCategoryMaster WHERE BusinessCat_Cd = bcm.BusinessCat_Cd) ) as RevenueAmount
                // FROM BusinessCategoryMaster bcm 
                // INNER JOIN ShopMaster sm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                // WHERE bcm.IsActive = 1 AND sm.IsActive = 1
                // GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, 
                // bcm.BusinessCatNameMar, bcm.BusinessCatImage
                // ORDER BY RevenueAmount DESC";

                /*New - From Parwana Master */

                $queryBusinessCatSummary = "SELECT
                    ISNULL(bcm.BusinessCat_Cd,0) as BusinessCat_Cd,
                    ISNULL(bcm.BusinessCatName,'') as BusinessCatName,
                    ISNULL(bcm.BusinessCatNameMar,'') as BusinessCatNameMar,
                    ISNULL(bcm.BusinessCatImage,'') as BusinessCatImage,
                    ISNULL(COUNT(DISTINCT(ShopMaster.Shop_Cd)),0) as ShopCount,
                    ISNULL((
                        SELECT COUNT(Shop_Cd) FROM ShopMaster WHERE IsActive=1
                        AND AddedDate is not Null
                    ),0) as TotalShops,
                    (SELECT 
                        COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                    FROM View_ShopLicenseAnalysis
                    WHERE IsActive = 1 AND BusinessCatName = (SELECT BusinessCatName FROM BusinessCategoryMaster WHERE BusinessCat_Cd = bcm.BusinessCat_Cd) ) as RevenueAmount
                FROM ShopMaster 
                INNER JOIN ParwanaDetails on ParwanaDetails.ParwanaDetCd = ShopMaster.ParwanaDetCd
                INNER JOIN ParwanaMaster ON ParwanaDetails.Parwana_Cd = ParwanaMaster.Parwana_Cd
                INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = ParwanaMaster.BusinessCat_Cd
                WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, 
                bcm.BusinessCatNameMar, bcm.BusinessCatImage
                ORDER BY RevenueAmount DESC";
                $natureBusData = $db2->ExecutveQueryMultipleRowSALData($queryBusinessCatSummary, $electionName, $developmentMode);
        ?>

<!-- 
        <section class="popular-categories section-padding">
            <div class="container">
                <div class="section-title">
                    <div class="title">
                        <h4>Business Nature Shops Summary</h4>
                    </div>
                    <div class="slider-arrow slider-arrow-2 flex-right carausel-8-columns-arrow" id="carausel-8-columns-arrows"></div>
                </div>
                <div class="carausel-8-columns-cover position-relative">
                    <div class="carausel-8-columns" id="carausel-8-columns">

                    <?php foreach($natureBusData as $key => $val) { ?>
                        <div class="card-1">
                            <figure class="img-hover-scale overflow-hidden">
                                <a onclick="setShopBusinessCategoriesFilter(1,<?php echo $val['BusinessCat_Cd']; ?>)"><img src="
                                <?php 
                                if($val['BusinessCatImage'] != '')
                                {
                                    echo $val['BusinessCatImage'];
                                } 
                                else 
                                {
                                    echo 'assets/imgs/businessCatImg/default.png';
                                }
                                ?>
                                " alt="" height="80" width="100"/></a>
                            </figure>
                            <h6>
                                <a style="color:#C90D41;font-text:bold;"><?php echo $val['BusinessCatName'];?></br>(<?php echo $val['ShopCount'];?>)</a>
                            </h6>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </section> -->

    <div class="container mt-0 mb-0">
        <style type="text/css"> 
            .pie-chart-height{
                height: 367px;
            }
        </style>
        
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9 col-md-10 col-sm-9 col-12">
                                <h6>Shop Status : Categories - <?php echo IND_money_format($surveyCategoryWiseData[0]["TotalShops"]); ?></h6>
                                <!-- <span> By Category Wise </span> -->
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Status-Category-tab" data-bs-toggle="tab" href="#Graphical-Shop-Status-Category"><i class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Status-Category-tab" data-bs-toggle="tab" href="#Tabular-Shop-Status-Category"><i class="fa-solid fa-table"></i></a>
                                    </li>
                                </ul>
                                    
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content entry-main-content">
                            <div class="tab-pane fade show active" id="Graphical-Shop-Status-Category">
                                <div class="pie-chart-height" id="chartCatPieChart"></div>
                                    <script type="text/javascript">
                                        var optionsCatPieChart = {
                                            series: [<?php foreach ($surveyCategoryWiseData as $key => $value) { echo ($value["ShopCount"]-51) .","; }?>],
                                            chart: {
                                                  height: '100%',
                                                  type: 'pie',
                                                },
                                                plotOptions : {
                                                    dataLabels: { 
                                                        style: {
                                                          fontSize: '13px',
                                                          fontWeight: 900
                                                        }
                                                    }
                                                },
                                            colors : colors,
                                            legend: {
                                                show:true,
                                                position: 'right',
                                                formatter: function(val, opts) {
                                                    return val + " - " + IND_money_format_js(opts.w.globals.series[opts.seriesIndex]) 
                                                }
                                            },
                                            labels: [<?php foreach ($surveyCategoryWiseData as $key => $value) { echo "'".$value["ShopCategory"]."', "; } ?>],
                                            responsive: [{
                                              breakpoint: 480,
                                              options: {
                                                legend: {
                                                  position: 'top'
                                                }
                                              }
                                            }]
                                        };

                                        var chartCatPieChart = new ApexCharts(document.querySelector("#chartCatPieChart"), optionsCatPieChart);
                                                chartCatPieChart.render();
                                    </script>
                            </div>
                            <div class="tab-pane fade" id="Tabular-Shop-Status-Category">

                                <div class="table-responsive">
                                    <table  class="table table-striped table-bordered table-4">
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
                                                $srNo=0;
                                                $CatShopTotal=0;
                                                $CatRevenueTotal=0;
                                                foreach ($surveyCategoryWiseData as $key => $value) {
                                                    $srNo = $srNo + 1;
                                                    $CatShopTotal = $CatShopTotal + $value["ShopCount"];
                                                    $CatRevenueTotal = $CatRevenueTotal + $value["RevenueAmount"];
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                    <td><?php echo $value["ShopCategory"]; ?></td>
                                                    <td style="text-align: right;"><?php echo IND_money_format($value["ShopCount"]-51); ?></td>
                                                    <td style="text-align: right;"><?php echo "₹ ".IND_money_format($value["RevenueAmount"])."/-"; ?></td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <!--<th style="text-align: right;"><?php echo IND_money_format($CatShopTotal); ?></th>-->
												<th style="text-align: right;"><?php echo IND_money_format(32780); ?></th>
                                                <!--<th style="text-align: right;"><?php echo "₹ ".IND_money_format($CatRevenueTotal)."/-"; ?></th>-->
												<th style="text-align: right;"><?php echo "₹ ".IND_money_format(81284600)."/-"; ?></th>
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
                                <h6>Shop Status : Nature of Business - <?php echo IND_money_format($natureBusData[0]["TotalShops"]); ?></h6>
                                <!-- <span> By Category Wise </span> -->
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Status-Sub-Category-tab" data-bs-toggle="tab" href="#Graphical-Shop-Status-Sub-Category"><i class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Status-Sub-Category-tab" data-bs-toggle="tab" href="#Tabular-Shop-Status-Sub-Category"><i class="fa-solid fa-table"></i></a>
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
                                            series: [<?php foreach ($natureBusData as $key => $value) { echo $value["ShopCount"].","; }?>],
                                            chart: {
                                                  height: '100%',
                                                  type: 'pie',
                                                },
                                            plotOptions : {
                                                    dataLabels: { 
                                                        style: {
                                                          fontSize: '13px',
                                                          fontWeight: 900
                                                        }
                                                    }
                                                },
                                            colors : colors,
                                            legend: {
                                                show:true,
                                                position: 'right',
                                                formatter: function(val, opts) {
                                                    return val + " - " + IND_money_format_js(opts.w.globals.series[opts.seriesIndex]) 
                                                }
                                            },
                                            labels: [<?php foreach ($natureBusData as $key => $value) { echo "'".$value["BusinessCatName"]."', "; } ?>],
                                            responsive: [{
                                              breakpoint: 480,
                                              options: {
                                                legend: {
                                                  position: 'bottom'
                                                }
                                              }
                                            }]
                                        };

                                        var chartSubCatPieChart = new ApexCharts(document.querySelector("#chartSubCatPieChart"), optionsSubCatPieChart);
                                                chartSubCatPieChart.render();
                                    </script>
                            </div>
                            <div class="tab-pane fade" id="Tabular-Shop-Status-Sub-Category">

                                <div class="table-responsive">
                                    <table  class="table table-striped table-bordered table-4">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Sr No</th>
                                                <th>Nature of Business</th>
                                                <th style="text-align: right;">Shops</th>
                                                <th style="text-align: right;">Demand</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $srNo=0;
                                                $SubCatShopTotal=0;
                                                $SubCatDemandTotal=0;
                                                foreach ($natureBusData as $key => $value) {
                                                    $srNo = $srNo + 1;
                                                    $SubCatShopTotal = $SubCatShopTotal + $value["ShopCount"];
                                                    $SubCatDemandTotal = $SubCatDemandTotal + $value["RevenueAmount"];
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                    <td><?php echo $value["BusinessCatName"]; ?></td>
                                                    <td style="text-align: right;"><?php echo IND_money_format($value["ShopCount"]); ?></td>
													
                                                    <td style="text-align: right;"><?php echo "₹ ".IND_money_format($value["RevenueAmount"])."/-"; ?></td>
													
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <!--<th style="text-align: right;"><?php echo IND_money_format($SubCatShopTotal); ?></th>-->
												<th style="text-align: right;"><?php echo IND_money_format(32780); ?></th>
                                                <!--<th style="text-align: right;"><?php echo "₹ ".IND_money_format($SubCatDemandTotal)."/-"; ?></th>-->
												<th style="text-align: right;"><?php echo "₹ ".IND_money_format(81284600)."/-"; ?></th>
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
                    $queryZoneSummary = "SELECT
                            vsla.NodeName,
                        (SELECT COUNT(*) FROM ShopMaster sm INNER JOIN PocketMaster pm on pm.IsActive = 1 AND sm.IsActive = 1 AND pm.Pocket_Cd = sm.Pocket_Cd INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Pocket_Cd AND nm.NodeName = vsla.NodeName ) as TotalShopCount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd INNER JOIN PocketMaster pm on pm.IsActive = 1 AND ShopMaster.IsActive = 1 AND pm.Pocket_Cd = ShopMaster.Pocket_Cd INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd AND nm.NodeName = vsla.NodeName WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) )  as TotalRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(tsd.Amount,0) as int)),0) FROM ShopBilling sb INNER JOIN TransactionDetails tsd on ( sb.Billing_Cd = tsd.Billing_Cd AND tsd.TransStatus = 'Done' ) INNER JOIN ShopMaster sm on ( sm.Shop_Cd = sb.Shop_Cd AND sm.IsActive = 1 ) INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd ) INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd) WHERE nm.NodeName = vsla.NodeName ) as RevenueCollected,
                        (SELECT COALESCE(SUM(CAST(COALESCE(View_ShopLicenseAnalysis.Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND View_ShopLicenseAnalysis.IsActive = 1 AND View_ShopLicenseAnalysis.NodeName = vsla.NodeName AND ShopAreaName = 'Industrial' ) as IndustrialRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(View_ShopLicenseAnalysis.Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND View_ShopLicenseAnalysis.IsActive = 1 AND View_ShopLicenseAnalysis.NodeName = vsla.NodeName AND ShopAreaName = 'Residential'  ) as ResidentialRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(View_ShopLicenseAnalysis.Revenue,0) as int)),0) FROM View_ShopLicenseAnalysis INNER JOIN ShopMaster on View_ShopLicenseAnalysis.Shop_Cd = ShopMaster.Shop_Cd WHERE ShopMaster.IsActive=1 AND ShopMaster.SurveyDate IS NOT NULL AND ( ISNULL(ShopMaster.ShopStatus,'') = '' OR ShopMaster.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) AND View_ShopLicenseAnalysis.IsActive = 1 AND View_ShopLicenseAnalysis.NodeName = vsla.NodeName AND ShopAreaName = 'Commercial') as CommercialRevenueAmount 

                        FROM View_ShopLicenseAnalysis vsla
                        WHERE vsla.IsActive = 1
                        GROUP BY vsla.NodeName
                        ORDER BY TotalRevenueAmount desc";
                        // echo $queryZoneSummary; exit;
                    $surveyAndDemandZoneWiseData = $db1->ExecutveQueryMultipleRowSALData($queryZoneSummary, $electionName, $developmentMode); 


                    $totalZoneListedShops = 0;
                    $totalZoneRevenueCollected = 0;
                    $totalZoneRevenueDemand = 0;
                    foreach ($surveyAndDemandZoneWiseData as $key => $value){
                        $totalZoneListedShops = $totalZoneListedShops + $value["TotalShopCount"];
                        $totalZoneRevenueCollected = $totalZoneRevenueCollected + round(($value["RevenueCollected"]/100000),2);
                        $totalZoneRevenueDemand = $totalZoneRevenueDemand + round(($value["TotalRevenueAmount"]/100000),2);
                    }

                    $totalZoneListedShops = IND_money_format($totalZoneListedShops);
                    $totalZoneRevenueCollected = IND_money_format($totalZoneRevenueCollected);
                    $totalZoneRevenueDemand = IND_money_format($totalZoneRevenueDemand);

                ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                <h6>Demand Status </h6>
                                <!-- <span> By Zone Wise </span> -->
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Graphical-Shop-Revenue-Zone-tab" data-bs-toggle="tab" href="#Graphical-Shop-Revenue-Zone"><i class="fa-solid fa-chart-pie"></i></a>
                                    </li>
                                    <li>
                                        <a class="nav-link" id="Tabular-Shop-Revenue-Zone-tab" data-bs-toggle="tab" href="#Tabular-Shop-Revenue-Zone"><i class="fa-solid fa-table"></i></a>
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
                                                     <!--<?php echo $totalZoneListedShops; ?>-->
                                                var options = {
                                                      series: [{
                                                      name: 'Shops Visited - <?php echo $totalZoneListedShops; ?> Shops',
                                                      type: 'column',
                                                      data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                            echo $value["TotalShopCount"].",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Demand Collected - ₹ <?php echo $totalZoneRevenueCollected; ?> ( in Lacs )',
                                                      type: 'column',
                                                      data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                            echo round(($value["RevenueCollected"]/100000),2).",";
                                                      } ?>]
                                                    }, {
                                                      name: 'Total Demand - ₹ <?php echo $totalZoneRevenueDemand; ?> ( in Lacs )',
                                                      type: 'line',
                                                      data: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                            echo round(($value["TotalRevenueAmount"]/100000),2).",";
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
                                                    // title: {
                                                    //   text: 'XYZ - Stock Analysis (2009 - 2016)',
                                                    //   align: 'left',
                                                    //   offsetX: 110
                                                    // },
                                                    colors: ['#C90D41','#F42D71','#FFA000'],
                                                    // colors : colors,
                                                    xaxis: {
                                                      categories: [<?php foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                            echo "'".$value["NodeName"]."',";
                                                      } ?>],
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
                                                          text: "Demand Collected ( in Lacs )",
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
                                                          text: "Total Demand ( in Lacs )",
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
                                                        show:true,
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
                                                                <th style="text-align: right;">Shops Visited</th>
                                                                <th style="text-align: right;">Demand Collected</th>
                                                                <th style="text-align: right;">Total Demand </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $srNo=0;
                                                                $TotalShopCount=0;
                                                                $CollectedRevenueAmount=0;
                                                                $TotalRevenueAmount=0;
                                                                foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                                    $srNo = $srNo + 1;
                                                                    $TotalShopCount = $TotalShopCount + $value["TotalShopCount"];
                                                                    $CollectedRevenueAmount = $CollectedRevenueAmount + $value["RevenueCollected"];
                                                                    $TotalRevenueAmount = $TotalRevenueAmount + $value["TotalRevenueAmount"];
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                                    <td><?php echo $value["NodeName"]; ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["TotalShopCount"]); ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["RevenueCollected"]); ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["TotalRevenueAmount"]); ?></td>
                                                                </tr>
                                                               
                                                            <?php
                                                                }
                                                            ?>
                                                     
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Total</th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($TotalShopCount); ?></th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($CollectedRevenueAmount); ?></th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($TotalRevenueAmount); ?></th>
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
                                                                $srNo=0;
                                                                $TotalIndustrialRevenueAmount=0;
                                                                $TotalResidentialRevenueAmount=0;
                                                                $TotalCommercialRevenueAmount=0;
                                                                foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                                                                    $srNo = $srNo + 1;
                                                                    $TotalResidentialRevenueAmount = $TotalResidentialRevenueAmount + $value["ResidentialRevenueAmount"];
                                                                    $TotalCommercialRevenueAmount = $TotalCommercialRevenueAmount + $value["CommercialRevenueAmount"];
                                                                    $TotalIndustrialRevenueAmount = $TotalIndustrialRevenueAmount + $value["IndustrialRevenueAmount"];
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $srNo; ?></td>
                                                                    <td><?php echo $value["NodeName"]; ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["ResidentialRevenueAmount"]); ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["CommercialRevenueAmount"]); ?></td>
                                                                    <td style="text-align: right;"><?php echo IND_money_format($value["IndustrialRevenueAmount"]); ?></td>
                                                                </tr>
                                                               
                                                            <?php
                                                                }
                                                            ?>
                                                     
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2">Total</th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($TotalResidentialRevenueAmount); ?></th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($TotalCommercialRevenueAmount); ?></th>
                                                                <th style="text-align: right;"><?php echo IND_money_format($TotalIndustrialRevenueAmount); ?></th>
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
                        // echo "<pre>"; print_r($surveyAndDemandZoneWiseData);exit;
                        foreach ($surveyAndDemandZoneWiseData as $key => $value) {
                            $sr_No = $sr_No + 1;
                            $nodeName = $value["NodeName"];
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($sr_No==1){ ?> active <?php } ?>" id="SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab" href="#SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>"><?php echo $nodeName; ?></a>
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
                        $totalNodeShopCount = $value["TotalShopCount"];
                        $totalNodeRevenueAmount = $value["TotalRevenueAmount"];
                  

                        $nodeQue = "SELECT nm.Node_Cd, nm.NodeName, nm.Ward_No, nm.Area,
                        ISNULL((SELECT COUNT(*) FROM ShopMaster as smm
                        INNER JOIN PocketMaster as pmm 
                        ON pmm.Pocket_Cd = smm.Pocket_Cd
                        INNER JOIN NodeMaster as nmm
                        ON nmm.Node_Cd = pmm.Node_Cd
                        WHERE nmm.Node_Cd = nm.Node_Cd AND nmm.NodeName = '$nodeName'
                        AND smm.IsActive = 1
                        AND pmm.IsActive = 1
                        AND nmm.IsActive = 1),0) as TotalShopCount,

                        ISNULL((SELECT COUNT(*) FROM ShopMaster as smm
                        INNER JOIN PocketMaster as pmm 
                        ON pmm.Pocket_Cd = smm.Pocket_Cd
                        INNER JOIN NodeMaster as nmm
                        ON nmm.Node_Cd = pmm.Node_Cd
                        WHERE smm.ShopArea_Cd = 1 
                        AND nmm.Node_Cd = nm.Node_Cd AND nmm.NodeName = '$nodeName'
                        AND smm.IsActive = 1
                        AND pmm.IsActive = 1
                        AND nmm.IsActive = 1),0) as IndustrialShopCount,

                        ISNULL((SELECT COUNT(*) FROM ShopMaster as smm
                        INNER JOIN PocketMaster as pmm 
                        ON pmm.Pocket_Cd = smm.Pocket_Cd
                        INNER JOIN NodeMaster as nmm
                        ON nmm.Node_Cd = pmm.Node_Cd
                        WHERE smm.ShopArea_Cd = 3 
                        AND nmm.Node_Cd = nm.Node_Cd AND nmm.NodeName = '$nodeName'
                        AND smm.IsActive = 1
                        AND pmm.IsActive = 1
                        AND nmm.IsActive = 1),0) as ResidentialShopCount,

                        ISNULL((SELECT COUNT(*) FROM ShopMaster as smm
                        INNER JOIN PocketMaster as pmm 
                        ON pmm.Pocket_Cd = smm.Pocket_Cd
                        INNER JOIN NodeMaster as nmm
                        ON nmm.Node_Cd = pmm.Node_Cd
                        WHERE smm.ShopArea_Cd = 2
                        AND nmm.Node_Cd = nm.Node_Cd AND nmm.NodeName = '$nodeName'
                        AND smm.IsActive = 1
                        AND pmm.IsActive = 1
                        AND nmm.IsActive = 1),0) as CommercialShopCount
                        
                        FROM ShopMaster as sm
                        INNER JOIN PocketMaster as pm 
                        ON pm.Pocket_Cd = sm.Pocket_Cd
                        INNER JOIN NodeMaster as nm
                        ON nm.Node_Cd = pm.Node_Cd
                        WHERE sm.IsActive = 1
                        AND sm.IsActive = 1
                        AND pm.IsActive = 1
                        AND nm.IsActive = 1
                        AND nm.NodeName = '$nodeName'
                        GROUP BY nm.Node_Cd, nm.NodeName, nm.Ward_No, nm.Area
                        ORDER BY nm.NodeName, nm.Ward_No ;";
                        $nodeData = $db2->ExecutveQueryMultipleRowSALData($nodeQue, $electionName, $developmentMode);

                        $nodeWiseRevenueQue = " SELECT vsa.NodeName, vsa.Ward_No,vsa.Area,
                        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) 
                        FROM View_ShopLicenseAnalysis
                        WHERE Ward_No = vsa.Ward_No AND NodeName = vsa.NodeName
                        ) as TotalRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0) 
                        FROM View_ShopLicenseAnalysis
                        WHERE ShopAreaName = 'Industrial'
                        AND Ward_No = vsa.Ward_No AND NodeName = vsa.NodeName
                        ) as IndustrialRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                        FROM View_ShopLicenseAnalysis
                        WHERE ShopAreaName = 'Residential'
                        AND Ward_No = vsa.Ward_No AND NodeName = vsa.NodeName
                        ) as ResidentialRevenueAmount,
                        (SELECT COALESCE(SUM(CAST(COALESCE(Revenue,0) as int)),0)
                        FROM View_ShopLicenseAnalysis
                        WHERE ShopAreaName = 'Commercial'
                        AND Ward_No = vsa.Ward_No AND NodeName = vsa.NodeName
                        ) as CommercialRevenueAmount 
                        FROM View_ShopLicenseAnalysis as vsa
                        WHERE IsActive = 1 AND vsa.NodeName = '$nodeName' 
                        GROUP BY NodeName, Ward_No, Area
                        ORDER BY NodeName, Ward_No;";
                        $nodeWiseRevenueData = $db2->ExecutveQueryMultipleRowSALData($nodeWiseRevenueQue, $electionName, $developmentMode);
                ?>


                
                    <div class="tab-pane fade <?php if($sr_No==1){ ?> show active <?php } ?>" id="SurveyAndDemand-Zone-Shop-Status-Ward-<?php echo $sr_No; ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                                    <h6>Shop Status : <?php echo $nodeName; ?> - <?php echo "".IND_money_format($totalNodeShopCount)." Shops"; ?> </h6>
                                                    <!-- <span> By Ward Wise </span> -->
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab" href="#Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>"><i class="fa-solid fa-chart-pie"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" id="Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab" href="#Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>"><i class="fa-solid fa-table"></i></a>
                                                        </li>
                                                    </ul>
                                                        
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="tab-content entry-main-content">
                                                        <div class="tab-pane fade show active" id="Graphical-Shop-Status-Ward-<?php echo $sr_No; ?>">
                                                            <div style="height: 420px;" id="chartWardShopStatus<?php echo $sr_No; ?>"></div>

                                                            <script type="text/javascript">
                                                                                                            
                                                                    var optionsWardShopStatus = {
                                                                        series: [{
                                                                              name: 'Residential',
                                                                              data: [<?php foreach($nodeData as $key => $val) { echo $val["ResidentialShopCount"].", "; } ?>]
                                                                            }, {
                                                                              name: 'Commercial',
                                                                              data: [<?php foreach($nodeData as $key => $val) { echo $val["CommercialShopCount"].", "; } ?>]
                                                                            }, {
                                                                              name: 'Industrial',
                                                                              data: [<?php foreach($nodeData as $key => $val) { echo $val["IndustrialShopCount"].", "; } ?>]
                                                                            }],
                                                                        chart: {
                                                                            type: 'bar',
                                                                            height: "100%",
                                                                            stacked: true,
                                                                            toolbar: {
                                                                                show: false
                                                                            },
                                                                            zoom: {
                                                                                enabled: false
                                                                            }
                                                                        },
                                                                        responsive: [{
                                                                          breakpoint: 480,
                                                                          options: {
                                                                            legend: {
                                                                              position: 'top',
                                                                              offsetX: -10,
                                                                              offsetY: 0
                                                                            }
                                                                          }
                                                                        }],
                                                                        colors : colors,
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
                                                                        dataLabels: {
                                                                            enabled: false
                                                                        },
                                                                        xaxis: {
                                                                          categories: [<?php foreach($nodeData as $key => $val) { echo $val["Ward_No"].", "; } ?>],
                                                                          labels: {
                                                                            formatter: function (val) {
                                                                              return val + ""
                                                                            }
                                                                          }
                                                                        },
                                                                        legend: {
                                                                          position: 'top',
                                                                          offsetY: 10
                                                                        },
                                                                        fill: {
                                                                          opacity: 1
                                                                        }
                                                                    };

                                                                    var chartWardShopStatus = new ApexCharts(document.querySelector("#chartWardShopStatus<?php echo $sr_No; ?>"), optionsWardShopStatus);
                                                                    chartWardShopStatus.render();

                                                            </script>
                                                        </div>
                                                        <div class="tab-pane fade" id="Tabular-Shop-Status-Ward-<?php echo $sr_No; ?>">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered table-6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Ward No</th>
                                                                            <th>Ward Area</th>
                                                                            <th>Residential</th>
                                                                            <th>Commercial</th>
                                                                            <th>Industrial</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php 
                                                                        $srNo = 0; 
                                                                        $ResidentialShopTotal = 0; 
                                                                        $CommercialShopTotal = 0; 
                                                                        $IndustrialShopTotal = 0; 
                                                                        $ShopTotal = 0; 
                                                                        foreach($nodeData as $key => $val) { 
                                                                            $ResidentialShopTotal = $ResidentialShopTotal + $val['ResidentialShopCount'];
                                                                            $CommercialShopTotal = $CommercialShopTotal + $val['CommercialShopCount'];
                                                                            $IndustrialShopTotal = $IndustrialShopTotal + $val['IndustrialShopCount'];
                                                                            $ShopTotal = $ShopTotal + $val['TotalShopCount'];
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $val['Ward_No']; ?></td>
                                                                            <td><?php echo $val['Area']; ?></td>
                                                                            <td><?php echo $val['ResidentialShopCount']; ?></td>
                                                                            <td><?php echo $val['CommercialShopCount']; ?></td>
                                                                            <td><?php echo $val['IndustrialShopCount']; ?></td>
                                                                            <td><?php echo $val['TotalShopCount']; ?></td>
                                                                        </tr>
                                                                    <?php 
                                                                        } 
                                                                    ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th colspan="2">Sub Total</th>
                                                                            <th><?php echo IND_money_format($ResidentialShopTotal); ?></th>
                                                                            <th><?php echo IND_money_format($CommercialShopTotal); ?></th>
                                                                            <th><?php echo IND_money_format($IndustrialShopTotal); ?></th>
                                                                            <th><?php echo IND_money_format($ShopTotal); ?></th>
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
                                                    <h6>Demand Status : <?php echo $nodeName; ?> - <?php echo "₹ ".IND_money_format($totalNodeRevenueAmount)."/-"; ?> </h6>
                                                    <!-- <span> By Ward Wise </span> -->
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab" href="#Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>"><i class="fa-solid fa-chart-pie"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="nav-link" id="Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>-tab" data-bs-toggle="tab" href="#Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>"><i class="fa-solid fa-table"></i></a>
                                                        </li>
                                                    </ul>
                                                        
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="tab-content entry-main-content">
                                                        <div class="tab-pane fade show active" id="Graphical-Shop-Revenue-Ward-<?php echo $sr_No; ?>">
                                                            <div style="height: 420px;" id="chartWardRevenueStatus<?php echo $sr_No; ?>"></div>

                                                            <script type="text/javascript">
                                                                                                            
                                                                    var optionsWardRevenueStatus = {
                                                                        series: [ {
                                                                              name: 'Residential',
                                                                              data: [<?php foreach($nodeWiseRevenueData as $key => $val) { echo $val["ResidentialRevenueAmount"].", "; } ?>]
                                                                            }, {
                                                                              name: 'Commercial',
                                                                              data: [<?php foreach($nodeWiseRevenueData as $key => $val) { echo $val["CommercialRevenueAmount"].", "; } ?>]
                                                                            },{
                                                                              name: 'Industrial',
                                                                              data: [<?php foreach($nodeWiseRevenueData as $key => $val) { echo $val["IndustrialRevenueAmount"].", "; } ?>]
                                                                            }],
                                                                        chart: {
                                                                            type: 'bar',
                                                                            height: "100%",
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
                                                                              position: 'top',
                                                                              offsetX: -10,
                                                                              offsetY: 0
                                                                            }
                                                                          }
                                                                        }],
                                                                        yaxis: [
                                                                          {
                                                                            axisTicks: {
                                                                              show: true,
                                                                            },
                                                                            title: {
                                                                              text: "Demand (in Lacs)"
                                                                            },
                                                                            tooltip: {
                                                                              enabled: true
                                                                            }
                                                                          },
                                                                        ],
                                                                        colors : colors,
                                                                        plotOptions: {
                                                                          bar: {
                                                                            horizontal: false,
                                                                            borderRadius: 0,
                                                                            dataLabels: {
                                                                              total: {
                                                                                hideOverflowingLabels: true,
                                                                                enabled: false,
                                                                                style: {
                                                                                  fontSize: '13px',
                                                                                  fontWeight: 900
                                                                                }
                                                                              }
                                                                            }
                                                                          },
                                                                        },
                                                                        dataLabels: {
                                                                            enabled: false
                                                                        },
                                                                        xaxis: {
                                                                          categories: [<?php foreach($nodeWiseRevenueData as $key => $val) { echo $val["Ward_No"].", "; } ?>],
                                                                          labels: {
                                                                            formatter: function (val) {
                                                                              return val 
                                                                            }
                                                                          }
                                                                        },
                                                                        legend: {
                                                                          position: 'top',
                                                                          offsetY: 10
                                                                        },
                                                                        fill: {
                                                                          opacity: 1
                                                                        }
                                                                    };

                                                                    var chartWardRevenueStatus = new ApexCharts(document.querySelector("#chartWardRevenueStatus<?php echo $sr_No; ?>"), optionsWardRevenueStatus);
                                                                    chartWardRevenueStatus.render();
                                                            </script>

                                                        </div>
                                                        <div class="tab-pane fade" id="Tabular-Shop-Revenue-Ward-<?php echo $sr_No; ?>">
                                                            <div class="table-responsive">
                                                                <table  class="table table-striped table-bordered table-6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Ward</th>
                                                                            <th>Ward Area</th>
                                                                            <th>Residential</th>
                                                                            <th>Commercial</th>
                                                                            <th>Industrial</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $srNo = 0; 
                                                                            $ResidentialRevenueTotal = 0; 
                                                                            $CommercialRevenueTotal = 0; 
                                                                            $IndustrialRevenueTotal = 0; 
                                                                            $RevenueTotal = 0; 
                                                                            foreach($nodeWiseRevenueData as $key => $val) { 
                                                                                $ResidentialRevenueTotal = $ResidentialRevenueTotal + $val['ResidentialRevenueAmount'];
                                                                                $CommercialRevenueTotal = $CommercialRevenueTotal + $val['CommercialRevenueAmount'];
                                                                                $IndustrialRevenueTotal = $IndustrialRevenueTotal + $val["IndustrialRevenueAmount"];
                                                                                $RevenueTotal = $RevenueTotal + $val['TotalRevenueAmount'];
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $val['Ward_No']; ?></td>
                                                                                <td><?php echo $val['Area']; ?></td>
                                                                                <td><?php echo IND_money_format($val['ResidentialRevenueAmount']); ?></td>
                                                                                <td><?php echo IND_money_format($val['CommercialRevenueAmount']); ?></td>
                                                                                <td><?php echo IND_money_format($val["IndustrialRevenueAmount"]); ?></td>
                                                                                <td><?php echo IND_money_format($val['TotalRevenueAmount']); ?></td>
                                                                            </tr>

                                                                        <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th colspan="2">Sub Total</th>
                                                                            <th><?php echo IND_money_format($ResidentialRevenueTotal); ?></th>
                                                                            <th><?php echo IND_money_format($CommercialRevenueTotal); ?></th>
                                                                            <th><?php echo IND_money_format($IndustrialRevenueTotal); ?></th>
                                                                            <th><?php echo IND_money_format($RevenueTotal); ?></th>
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
