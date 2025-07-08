<section id="dashboard-analytics">

    <?php
        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        // $fromDate = date('Y-m-d', strtotime('-3 days'));
        $fromDate = $currentDate;
        $toDate = $currentDate;

        if(!isset($_SESSION['SAL_FromDate'])){
            $_SESSION['SAL_FromDate'] = $fromDate ;
            // $_SESSION['SAL_ToDate'] = $fromDate;
        }else{
            $fromDate  = $_SESSION['SAL_FromDate'];
            // $_SESSION['SAL_ToDate'] = $_SESSION['SAL_FromDate'];
        }

        if(!isset($_SESSION['SAL_ToDate'])){
            // $toDate = $_SESSION['SAL_FromDate'];
            $_SESSION['SAL_ToDate'] = $toDate;
        }else{
            $toDate = $_SESSION['SAL_ToDate'];
        }

 
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


        // if(isset($_SESSION['SAL_Node_Name'])){
        //     $nodeName = $_SESSION['SAL_Node_Name'];
        //     if(isset($_GET['node_Name'])){
        //         $nodeName = $_GET['node_Name'];
        //         $_SESSION['SAL_Node_Name'] = $nodeName;
        //     }
        // }else {
            $nodeName = "All";
        // }

        if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            if(isset($_GET['nodeId'])){
                $nodeCd = $_GET['nodeId'];
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
            }
        }else {
            $nodeCd = "All";
        }

        if(isset($_GET['pocketCd'])){
            $pocketCd = $_GET['pocketCd'];
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocketCd = $_SESSION['SAL_Pocket_Cd'];
        }else if(isset($_GET['pocketId'])){
            $pocketCd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
        }else{
            $pocketCd = "All";
            $_SESSION['SAL_Pocket_Cd'] = $pocketCd;
        }
        
        
      
    ?>
     
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="fromDate">From Date</label>
                                    <input type='text' name="fromDate" value="<?php echo $fromDate;?>" class="form-control pickadate-disable-forwarddates" />
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="toDate">To Date</label>
                                    <input type='text' name="toDate" value="<?php echo $toDate;?>" class="form-control pickadate-disable-forwarddates" />
                                </div>
                            </div>
                            
                            <!-- <div class="col-12 col-md-2"> -->
                                <input type="hidden" name="node_Name" value="<?php echo $nodeName; ?>">
                            <!-- </div> -->

                            <div class="col-md-2 col-12">
                                <?php include 'dropdown-nodecd-and-wardno.php'; ?>
                            </div>

                            <div class="col-md-2 col-12" id="pocketSurveyListId">
                               <?php include 'dropdown-pocket-name-node-cd-date.php'; ?>
                            </div>
                            <!-- <div class="col-12 col-md-3"> -->
                                <input type="hidden" name="executiveCd" value="All" >
                                <?php //include 'dropdown-qc-executive-name.php' ?>
                            <!-- </div> -->
                                                    
                            <div class="col-12 col-md-2 text-right" style="margin-top: 25px;">
                                <div class="form-group">
                                    <label for="update"></label>
                                    <button type="button" class="btn btn-primary" onclick="setShopQCSummaryData()"><i class="feather icon-refresh-cw"></i></button>
                                </div>
                            </div>  


        
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>


 <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link  active " id="qc-summary-over-all-tab" data-toggle="tab" href="#qc-summary-over-all" aria-controls="home" role="tab" aria-selected="true"> <i class="feather icon-map-pin"></i> Ward Wise : Over All </a>
        
    </li>
    <li class="nav-item">
        <a class="nav-link " id="qc-summary-date-range-tab" data-toggle="tab" href="#qc-summary-date-range" aria-controls="home" role="tab" aria-selected="true"> <i class="feather icon-calendar"></i> Ward Wise : Date Range  </a>
        
    </li>
    <li class="nav-item">
        <a class="nav-link " id="listIcon-tab" data-toggle="tab" href="#listIcon" aria-controls="profile" role="tab" aria-selected="false"><i class="feather icon-users"></i> Executive Wise</a>
    </li>
    <li class="nav-item">
    <button type="button" class="btn btn-outline" style="height:32px;background-color:#c90d41;color:white;padding:5px 5px;" data-toggle="modal" data-target="#exampleModalLong">
    QC Summary Report
    </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active " id="qc-summary-over-all" aria-labelledby="qc-summary-over-all-tab" role="tabpanel">
        
        <?php

            $queryWardWiseSummary = "
                SELECT
                nmm.Ward_No, nmm.Node_Cd, nmm.Area,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopList,
                ISNULL((SELECT TOP 1 CONVERT(varchar, sm.AddedDate, 23) 
                FROM ShopMaster sm 
                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL) 
                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd) ),'') as WardListingStartDate ,
                ISNULL((SELECT TOP 1 CONVERT(varchar, sm.AddedDate, 23) 
                FROM ShopMaster sm 
                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL) 
                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd) 
                ORDER BY CONVERT(varchar, sm.AddedDate, 23) DESC ),'') as WardListingEndDate , 
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(qd.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN QCDetails qd on (qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopList')
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    WHERE qd.QC_Detail_Cd is not null
                ),0) as ShopListQC,
                ISNULL((SELECT TOP 1 CONVERT(varchar, sm.SurveyDate, 23) 
                FROM ShopMaster sm 
                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.SurveyDate IS NOT NULL) 
                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd) ),'') as WardSurveyStartDate , 
                ISNULL((SELECT TOP 1 CONVERT(varchar, sm.SurveyDate, 23) 
                FROM ShopMaster sm 
                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.SurveyDate IS NOT NULL) 
                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd) 
                ORDER BY CONVERT(varchar, sm.SurveyDate, 23) DESC ),'') as WardSurveyEndDate , 
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopSurvey,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN QCDetails qd on qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopSurvey' AND qd.QC_Flag = 2
                ),0) as ShopSurveyQC,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sdm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN ShopDocuments sdm on sdm.Shop_Cd = sm.Shop_Cd
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopDocument,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sdm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN ShopDocuments sdm on sdm.Shop_Cd = sm.Shop_Cd
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN QCDetails qd on qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopDocument' AND qd.QC_Flag = 3
                ),0) as ShopDocumentQC,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    WHERE sdm.Shop_Cd IS NULL
                ),0) as ShopDocPending,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN ScheduleDetails sd on sd.Shop_Cd = sm.Shop_Cd AND sd.Calling_Category_Cd in (
                        SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE QC_Type = 'ShopDocument'
                    )
                    WHERE sdm.Shop_Cd IS NULL
                ),0) as ShopDocScheduled,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN ScheduleDetails sd on sd.Shop_Cd = sm.Shop_Cd AND sd.Calling_Category_Cd in (
                        SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE QC_Type = 'ShopDocument'
                    )
                    INNER JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE sdm.Shop_Cd IS NULL AND st.ST_Status = 1
                ),0) as ShopDocScheduledDone
                FROM ShopMaster smm 
                INNER JOIN PocketMaster pmm on (pmm.Pocket_Cd = smm.Pocket_Cd AND smm.IsActive = 1 AND pmm.IsActive = 1)
                INNER JOIN NodeMaster nmm on (nmm.Node_Cd = pmm.Node_Cd AND nmm.IsActive = 1)
                GROUP BY nmm.Ward_No,nmm.Node_Cd, nmm.Area 
                ORDER BY WardSurveyStartDate DESC;
            ";
            $dbWardQC=new DbOperation();
            $WardQCData = $dbWardQC->ExecutveQueryMultipleRowSALData($queryWardWiseSummary, $electionName, $developmentMode);

            $queDataValidation = "SELECT TOP(1)
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NOT NULL 
            AND ( 
            ISNULL(sm.ShopStatus,'') = '' OR 
            sm.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
            AND ( 
            ISNULL(sm.ShopStatus,'') = '' OR 
            sm.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
            --AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
            AND (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) 
            OR LEN(ShopKeeperMobile) != 10 )),0 ) as MobilePending,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            AND sm.SurveyDate IS NOT NULL 
            AND ( 
            ISNULL(sm.ShopStatus,'') = '' OR 
            sm.ShopStatus in 
            (SELECT ApplicationStatus as ShopStatus FROM StatusMaster 
            WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
            )
            AND ( ShopOutsideImage1 IS NULL AND ShopOutsideImage2 IS NULL 
            --AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
            )),0)as PhotoPending,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            --AND sm.SurveyDate IS NULL 
            AND sm.ShopStatus = 'Permission Denied' 
            --AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
            ),0)as PermissionDenied,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            --AND sm.SurveyDate IS NULL 
            AND sm.ShopStatus = 'Permanently Closed' 
            --AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
            ),0)as PermanantlyClosed,
            ISNULL((SELECT COUNT(Shop_Cd) FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE sm.IsActive = 1 
            AND nm.IsActive = 1
            AND pm.IsActive = 1 
            $nodeCondition
            $nodeNameCondition
            --AND sm.SurveyDate IS NULL 
            AND sm.ShopStatus = 'Non-Cooperative' 
            --AND CONVERT(varchar,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
             ),0)as NonCooperative
            FROM ShopMaster as sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            WHERE CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' 
            AND sm.IsActive = 1
            AND pm.IsActive = 1
            AND nm.IsActive = 1"; 
            $dbDV=new DbOperation();
            $DataValidationData = $dbDV->ExecutveQuerySingleRowSALData($queDataValidation, $electionName, $developmentMode);

            $docQue = "SELECT 
            SUM(CASE WHEN t1.Document_Cds IS NULL THEN 1 ELSE 0 END ) as ShopWithNoDoc
        FROM 
        (
            SELECT 
                t.Shop_Cd,sd.Shop_Cd as Shop_Doc_Cd, t.ShopStatus, STRING_AGG(sd.Document_Cd,',') as Document_Cds, 
                STRING_AGG(sd.QC_Flag,',') as QC_Flags,
                t.Ward_No
            FROM (
                SELECT ShopMaster.Shop_Cd, ShopMaster.ShopStatus, NodeMaster.Ward_No FROM ShopMaster 
                INNER JOIN PocketMaster ON ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd 
                AND PocketMaster.IsActive = 1 ) 
                INNER JOIN NodeMaster ON PocketMaster.Node_Cd = NodeMaster.Node_Cd 
                WHERE ShopMaster.IsActive=1 AND SurveyDate IS NOT NULL 
                $nNCondition
                $nCondition
                --AND CONVERT(varchar,ShopMaster.AddedDate,120) BETWEEN '$fromDate' AND '$toDate'
                AND ( ShopMaster.ShopStatus = 'Verified' OR
                ISNULL(ShopStatus,'') = '' 
                OR ShopMaster.ShopStatus in  
                ( SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' 
                AND IsActive = 1 AND ShopStatus <> 'Verified' ) ) 
            ) as t
            LEFT JOIN ShopDocuments sd on ( sd.Shop_Cd = t.Shop_Cd AND sd.IsActive = 1 )
            GROUP BY t.Shop_Cd, t.ShopStatus, sd.Shop_Cd, t.Ward_No
    
        ) as t1
        
    
        ";
        $db4=new DbOperation();
        $dataDocPen = $db4->ExecutveQuerySingleRowSALData($docQue, $electionName, $developmentMode);

        ?>

<div class="row">
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($DataValidationData["MobilePending"]); ?></h2>
                        <label>Mobile Pending</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($DataValidationData["PhotoPending"]); ?></h2>
                        <label>Photo Pending </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($dataDocPen["ShopWithNoDoc"]); ?></h2>
                        <label>Document Pending </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($DataValidationData["PermanantlyClosed"]); ?></h2>
                        <label>Permanantly Closed </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($DataValidationData["NonCooperative"]); ?></h2>
                        <label>Non Cooperative </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex align-items-start pb-0">
                    <div>
                        <h2 class="text-bold-700 mb-0"><?php echo IND_money_format($DataValidationData["PermissionDenied"]); ?></h2>
                        <label>Permission Denied</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title"><b>Pending QC : </b><span class="badge badge-danger">QC in Wards which are not reached 95% of Total</h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="wardWiseOverAllTableId" class="table table-striped complex-headers table-bordered" width="100%">
                                    <thead>
                                        <tr> 
                                            <th colspan="2">Ward</th>
                                            <th colspan="5">Shop Listing QC</th>
                                            <th colspan="5">Shop Survey QC</th>
                                            <th colspan="3">Shop Document QC</th>
                                            <th colspan="3">Document Pending</th>
                                        </tr>
                                         <tr> 
                                            <th>Sr No</th>
                                            <th>Ward No</th>
                                            <th>Listing Start Date</th>
                                            <th>Listing End Date</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Survey Start Date</th>
                                            <th>Survey End Date</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Completed</th>
                                            <th>Scheduled</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $wardSrNo = 0;
                                            foreach ($WardQCData as $key => $valueWard) {
                                                $wardSrNo = $wardSrNo + 1;
                                        ?>
                                            <tr>

                                                <td><?php echo $wardSrNo; ?></td>
                                                <td><?php echo $valueWard["Ward_No"]; ?></td>
                                                <td><?php echo $valueWard["WardListingStartDate"]; ?></td>
                                                <td><?php echo $valueWard["WardListingEndDate"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if( round( (($valueWard["ShopListQC"]/$valueWard["ShopList"])*100) ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopList"]-$valueWard["ShopListQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopList"]-$valueWard["ShopListQC"]); ?>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopListQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopList"]; ?></td>
                                                <td><?php echo $valueWard["WardSurveyStartDate"]; ?></td>
                                                <td><?php echo $valueWard["WardSurveyEndDate"]; ?></td>
                                                <td>
                                                    <?php 
                                                       if($valueWard["ShopSurveyQC"] != 0 && $valueWard["ShopSurveyQC"] != '') {  if( round( (($valueWard["ShopSurveyQC"]/$valueWard["ShopSurvey"])*100) ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopSurvey"]-$valueWard["ShopSurveyQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopSurvey"]-$valueWard["ShopSurveyQC"]); ?>
                                                    <?php
                                                        } } else { echo "0";}
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopSurveyQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopSurvey"]; ?></td>
                                                <td>
                                                    <?php 
                                                       if($valueWard["ShopDocumentQC"] != 0 && $valueWard["ShopDocumentQC"] != '') {  if( round(  (($valueWard["ShopDocumentQC"]/$valueWard["ShopDocument"]))*100 ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopDocument"]-$valueWard["ShopDocumentQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopDocument"]-$valueWard["ShopDocumentQC"]); ?>
                                                    <?php
                                                        } } else { echo "0";}
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopDocumentQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocument"]; ?></td>

                                                <td><?php echo $valueWard["ShopDocScheduledDone"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocScheduled"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocPending"]; ?></td>

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

    </div>

    <div class="tab-pane " id="qc-summary-date-range" aria-labelledby="qc-summary-date-range-tab" role="tabpanel">
        
        <?php
            
            $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
            $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];

            $queryWardWiseDateRangeSummary = "
                SELECT
                nmm.Ward_No, nmm.Node_Cd, nmm.Area,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.AddedDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopList,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(qd.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN QCDetails qd on (qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopList' AND qd.QC_Flag = 1 AND qd.QC_DateTime BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.AddedDate IS NOT NULL AND sm.AddedDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    WHERE qd.QC_Detail_Cd is not null
                ),0) as ShopListQC,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL  AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopSurvey,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN QCDetails qd on ( qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopSurvey' AND qd.QC_Flag = 2 AND qd.QC_DateTime BETWEEN '$fromDate' AND '$toDate' )
                ),0) as ShopSurveyQC,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sdm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN ShopDocuments sdm on ( sdm.Shop_Cd = sm.Shop_Cd AND sdm.UpdatedDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                ),0) as ShopDocument,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sdm.Shop_Cd))
                    FROM ShopMaster sm
                    INNER JOIN ShopDocuments sdm on ( sdm.Shop_Cd = sm.Shop_Cd AND sdm.UpdatedDate BETWEEN '$fromDate' AND '$toDate' AND sdm.QC_Flag = 3 AND sdm.QC_UpdatedDate BETWEEN '$fromDate' AND '$toDate')
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN QCDetails qd on ( qd.Shop_Cd = sm.Shop_Cd AND qd.QC_Type = 'ShopDocument' AND qd.QC_Flag = 3 AND qd.QC_DateTime BETWEEN '$fromDate' AND '$toDate' )
                ),0) as ShopDocumentQC,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd AND sdm.UpdatedDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    WHERE sdm.Shop_Cd IS NULL
                ),0) as ShopDocPending,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL AND sm.SurveyDate BETWEEN '$fromDate' AND '$toDate' )
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN ScheduleDetails sd on ( sd.Shop_Cd = sm.Shop_Cd AND sd.Calling_Category_Cd in (
                            SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE QC_Type = 'ShopDocument'
                        ) 
                        AND sd.CallingDate BETWEEN '$fromDate' AND '$toDate'
                    )
                    WHERE sdm.Shop_Cd IS NULL
                ),0) as ShopDocScheduled,
                ISNULL((
                    SELECT
                        COUNT(DISTINCT(sm.Shop_Cd))
                    FROM ShopMaster sm
                    LEFT JOIN ShopDocuments sdm on (sdm.Shop_Cd = sm.Shop_Cd )
                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND sm.IsActive = 1 AND pm.IsActive = 1 AND sm.SurveyDate IS NOT NULL)
                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 AND nm.Node_Cd = nmm.Node_Cd)
                    INNER JOIN ScheduleDetails sd on sd.Shop_Cd = sm.Shop_Cd AND sd.Calling_Category_Cd in (
                        SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE QC_Type = 'ShopDocument'
                    )
                    INNER JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    WHERE sdm.Shop_Cd IS NULL AND st.ST_Status = 1
                    AND st.ST_DateTime BETWEEN '$fromDate' AND '$toDate'
                ),0) as ShopDocScheduledDone
                FROM ShopMaster smm 
                INNER JOIN PocketMaster pmm on (
                        pmm.Pocket_Cd = smm.Pocket_Cd AND smm.IsActive = 1 AND pmm.IsActive = 1 
                        AND (smm.AddedDate BETWEEN '$fromDate' AND '$toDate' OR smm.SurveyDate BETWEEN '$fromDate' AND '$toDate' ) 
                    )
                INNER JOIN NodeMaster nmm on (nmm.Node_Cd = pmm.Node_Cd AND nmm.IsActive = 1)
                GROUP BY nmm.Ward_No,nmm.Node_Cd, nmm.Area ;
            ";
            // echo $queryWardWiseDateRangeSummary;
            $dbWardDateRangeQC=new DbOperation();
            $WardQCDateRangeData = $dbWardDateRangeQC->ExecutveQueryMultipleRowSALData($queryWardWiseDateRangeSummary, $electionName, $developmentMode);
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title"><b>Pending QC : </b><span class="badge badge-danger">QC in Wards which are not reached 95% of Total</h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped complex-headers table-bordered" width="100%">
                                    <thead>
                                        <tr> 
                                            <th colspan="2">Ward</th>
                                            <th colspan="3">Shop Listing QC</th>
                                            <th colspan="3">Shop Survey QC</th>
                                            <th colspan="3">Shop Document QC</th>
                                            <th colspan="3">Document Pending</th>
                                        </tr>
                                         <tr> 
                                            <th>Sr No</th>
                                            <th>Ward No</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Pending</th>
                                            <th>Done</th>
                                            <th>Total</th>
                                            <th>Completed</th>
                                            <th>Scheduled</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $wardSrNo = 0;
                                            foreach ($WardQCDateRangeData as $key => $valueWard) {
                                                $wardSrNo = $wardSrNo + 1;
                                        ?>
                                            <tr>

                                                <td><?php echo $wardSrNo; ?></td>
                                                <td><?php echo $valueWard["Ward_No"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if($valueWard["ShopListQC"] != 0 && $valueWard["ShopListQC"] != '') { if( round( (($valueWard["ShopListQC"]/$valueWard["ShopList"])*100) ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopList"]-$valueWard["ShopListQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopList"]-$valueWard["ShopListQC"]); ?>
                                                    <?php
                                                        } } else { echo "0";}
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopListQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopList"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if($valueWard["ShopSurveyQC"] != 0 && $valueWard["ShopSurveyQC"] != '') { if( round( (($valueWard["ShopSurveyQC"]/$valueWard["ShopSurvey"])*100) ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopSurvey"]-$valueWard["ShopSurveyQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopSurvey"]-$valueWard["ShopSurveyQC"]); ?>
                                                    <?php
                                                        } } else { echo "0";}
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopSurveyQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopSurvey"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if($valueWard["ShopDocumentQC"] != 0 && $valueWard["ShopDocumentQC"] != '') { if( round(  (($valueWard["ShopDocumentQC"]/$valueWard["ShopDocument"]))*100 ) < 95 ){
                                                    ?>
                                                        <span class="badge badge-danger">
                                                            <?php echo ($valueWard["ShopDocument"]-$valueWard["ShopDocumentQC"]); ?>
                                                        </span>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <?php echo ($valueWard["ShopDocument"]-$valueWard["ShopDocumentQC"]); ?>
                                                    <?php
                                                       } } else { echo "0";}
                                                    ?>
                                                </td>
                                                <td><?php echo $valueWard["ShopDocumentQC"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocument"]; ?></td>

                                                <td><?php echo $valueWard["ShopDocScheduledDone"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocScheduled"]; ?></td>
                                                <td><?php echo $valueWard["ShopDocPending"]; ?></td>

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

    </div>
    <div class="tab-pane  " id="listIcon" aria-labelledby="listIcon-tab" role="tabpanel">
       

        <?php 

            $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
            $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];
        

        

            if($nodeCd == 'All'){
                $nodeCondition = " AND pm.Node_Cd <> 0  "; 
                $nCondition = " AND PocketMaster.Node_Cd <> 0  ";
            }else{
                $nodeCondition = " AND pm.Node_Cd = $nodeCd AND pm.Node_Cd <> 0  "; 
                $nCondition = " AND PocketMaster.Node_Cd = $nodeCd AND PocketMaster.Node_Cd <> 0  "; 
            }

            if($nodeName == 'All'){
                $nodeNameCondition = " AND nm.NodeName <> '' ";
                $nNCondition = " AND NodeMaster.NodeName <> '' ";
            }else{
                $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
                $nNCondition = " AND NodeMaster.NodeName = '$nodeName' ";
            }

            if($pocketCd == 'All'){
                $pcktCondition = "  ";
            }else{
                $pcktCondition = " AND sm.Pocket_Cd = $pocketCd ";
            }
            
            $qc_fromDate = str_replace("-","",$_SESSION['SAL_FromDate']);
            $qc_toDate = str_replace("-","",$_SESSION['SAL_ToDate']);
            $queryDate = "SELECT  CONVERT(VARCHAR,DATEADD(DAY, nbr - 1, '$qc_fromDate'),23) as QC_Date
                FROM    ( SELECT    ROW_NUMBER() OVER ( ORDER BY c.object_id ) AS nbr
                          FROM      sys.columns c
                        ) nbrs
                WHERE   nbr - 1 <= DATEDIFF(DAY, '$qc_fromDate', '$qc_toDate')";
                // echo $queryDate;
            $dbQC=new DbOperation();
            $QCDateData = $dbQC->ExecutveQueryMultipleRowSALData($queryDate, $electionName, $developmentMode);
            // $QCSummaryData = array_merge($QCDateData,$qcTypeArray);
            
            foreach ($QCDateData as $key => $value) {

                    $qcDate = $value["QC_Date"];
                    
                    $queryQCExe="SELECT
                        qd.Executive_Cd, em.ExecutiveName
                    FROM QCDetails qd
                    INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = qd.Executive_Cd
                    WHERE CONVERT(VARCHAR,qd.QC_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'
                    
                    GROUP BY qd.Executive_Cd, em.ExecutiveName";
                    $QCExeData = $dbQC->ExecutveQueryMultipleRowSALData($queryQCExe, $electionName, $developmentMode);
                   // print_r($value);
                   // echo sizeof($value);
       
           
                   
                
        ?>
                         
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h5>QC Summary - Executive Wise : <?php echo date('d/m/Y',strtotime($qcDate)); ?></h5>
                                <div class="table-responsive">
                                    <table class="table table-striped complex-headers table-bordered zero-configuration" width="100%">
                                        <thead>
                                            <tr>
                                            
                                                <!-- <th style="text-align:center;">Sr<br>No</th> -->
                                                <th colspan="1" style="text-align:left;">Executive</th>
                                                <?php 
                                                    $shopListingSMTodayRowTotal = 0;
                                                    $shopSurveySMTodayRowTotal = 0;
                                                    $shopBoardSMTodayRowTotal = 0;
                                                    $shopDocumentSMTodayRowTotal = 0;
                                                    $shopCallingSMTodayRowTotal = 0;

                                                    foreach ($qcTypeArray as $key => $qcTypeValue) {
                                           
                                               

                                                        $shopSurveyCondition ="";
                                                        $shopListSurveyCondition ="";
                                                        

                                                        
                                                        $qcTitle = $qcTypeValue["QC_Title"];
                                                        $shAction = $qcTypeValue["SH_Action"];
                                                        $qcType = $qcTypeValue["QC_Type"];
                                                        $qcFlag = $qcTypeValue["QC_Flag"];

                                                        if($qcType == 'ShopList'){
                                                            $shopListSurveyCondition = " AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'   ";
                                                            $shopSurveyCondition = " ";
                                                           
                                                        }else if($qcType == 'ShopSurvey'){
                                                            $shopListSurveyCondition = "";
                                                           
                                                            $shopSurveyCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  )
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey') 
                                                                )
                                                            ";


                                                        }else if($qcType == 'ShopBoard'){
                                                            $shopListSurveyCondition = "";
                                                            $shopSurveyCondition = " 
                                                             INNER JOIN ShopBoardDetails sbd on ( sbd.Shop_Cd=sm.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sbd.UpdatedDate,120) BETWEEN '$qcDate'+' 00:00:00' AND '$qcDate'+' 23:59:59' )
                                                            ";
                                                         
                                                        }else if($qcType == 'ShopDocument'){
                                                      


                                                            $shopListSurveyCondition = "";
                                                            $shopSurveyCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1  )
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument') 
                                                                )
                                                            ";

                                                           
                                                        }else if($qcType == 'ShopCalling'){
                                                       


                                                            $shopListSurveyCondition = "";
                                                            $shopSurveyCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 )
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Calling' 
                                                                )
                                                                INNER JOIN CallingDetails cd ON ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND cd.Call_Response_Cd = 4 AND ISNULL(cd.AudioFile_Url,'') <> '' )
                                                            ";

                                                           
                                                        }


                                                        $smSurveyRowCount = 0;
                                                        $queryQC = "SELECT 
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(sm.Shop_Cd))
                                                                FROM ShopMaster sm
                                                                
                                                                $shopSurveyCondition
                                                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                                                WHERE sm.IsActive = 1
                                                                $shopListSurveyCondition
                                                                $nodeNameCondition
                                                                $nodeCondition
                                                                $pcktCondition
                                                            ),0) AS SM_Count

                                                          

                                                          ;  ";
                                                            // echo $queryQC;
                                                            // echo "<br>";
                                                            // echo "<br>";
                                                        $dbQCC=new DbOperation();
                                                        $QC_CountData = $dbQCC->ExecutveQuerySingleRowSALData($queryQC, $electionName, $developmentMode);
                                                        $smSurveyRowCount = $QC_CountData["SM_Count"];

                                                        if($qcType == 'ShopList'){
                                                            $shopListingSMTodayRowTotal = $shopListingSMTodayRowTotal + $smSurveyRowCount;
                                                        }else if($qcType == 'ShopSurvey'){
                                                            $shopSurveySMTodayRowTotal = $shopSurveySMTodayRowTotal + $smSurveyRowCount;
                                                        }else if($qcType == 'ShopBoard'){
                                                            $shopBoardSMTodayRowTotal = $shopBoardSMTodayRowTotal + $smSurveyRowCount;
                                                        }else if($qcType == 'ShopDocument'){
                                                            $shopDocumentSMTodayRowTotal = $shopDocumentSMTodayRowTotal + $smSurveyRowCount;
                                                        }else if($qcType == 'ShopCalling'){
                                                            $shopCallingSMTodayRowTotal = $shopCallingSMTodayRowTotal + $smSurveyRowCount;
                                                        }

                                                        

                                                       

                                                        $shopListingQCTodayRowTotal = 0;
                                                        $shopSurveyQCTodayRowTotal = 0;
                                                        $shopBoardQCTodayRowTotal = 0;
                                                        $shopDocumentQCTodayRowTotal = 0;
                                                        $shopCallingQCTodayRowTotal = 0;

                                                        $shopListingQCRowTotal = 0;
                                                        $shopSurveyQCRowTotal = 0;
                                                        $shopBoardQCRowTotal = 0;
                                                        $shopDocumentQCRowTotal = 0;
                                                        $shopCallingQCRowTotal = 0;

                                                        $shopSurveySDRowTotal = 0;
                                                        $shopDocumentSDRowTotal = 0;
                                                        $QC_CountTodayTotal = 0;
                                                ?>
                                                     <th style="text-align:center;">
                                                        <span class="badge badge-primary badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>"><?php echo $smSurveyRowCount; ?></span> 
                                                    </th>

                                                <?php
                                                     }
                                                ?>
                                                <th colspan="1" style="text-align:center;"> Shops </th> 
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;">
                                                    <?php echo "Name"; ?>
                                                </th>
                                                <?php 
                                                    foreach ($qcTypeArray as $key => $qcTypeValue) {
                                                        $qcTitle = $qcTypeValue["QC_Title"];
                                                        $shAction = $qcTypeValue["SH_Action"];
                                                        $qcType = $qcTypeValue["QC_Type"];
                                                        $qcFlag = $qcTypeValue["QC_Flag"];
                                                ?>
                                                <th style="text-align:center;">
                                                    <?php echo $qcTitle; ?>
                                                </th>
                                                <?php 
                                                    }
                                                ?>
                                                <th style="text-align:center;">
                                                    <?php echo "QC"; ?>
                                                </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>



                                <?php

                                    $srno = 1;

                            
                                            
                                     
                                        foreach($QCExeData as $value){
                                        $qcExecutiveCd = $value["Executive_Cd"];        
                                            ?>
                                            <tr>
                                               <!--  <td><?php //echo $srno++; ?></td> -->
                                                <td>
                                                    <?php  echo $value["ExecutiveName"]; ?>  
                                                </td> 
                                                <?php 
                                                  

                                                    foreach ($qcTypeArray as $key => $qcTypeValue) {
                                                        $shopQCTodayShopColumnCondition ="";
                                                        $shopQCShopListCondition ="";


                                                        $shopScheduleCondition ="";
                                                        

                                                        
                                                        $qcTitle = $qcTypeValue["QC_Title"];
                                                        $shAction = $qcTypeValue["SH_Action"];
                                                        $qcType = $qcTypeValue["QC_Type"];
                                                        $qcFlag = $qcTypeValue["QC_Flag"];

                                                        if($qcType == 'ShopList'){
                                                            $shopQCShopListCondition =" AND CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59' AND CONVERT(VARCHAR,sm.QC_UpdatedDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'   ";

                                                            $shopQCTodayShopColumnCondition = "   ";

                                                            $shopScheduleCondition =" ,
                                                                    0 AS SD_Count
                                                            ";
                                                        }else if($qcType == 'ShopSurvey'){
                                                            $shopQCTodayShopColumnCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND qd.ScheduleCall_Cd = sd.ScheduleCall_Cd)
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey') 
                                                                )
                                                            ";
                                                     

                                                            $shopScheduleCondition =" ,
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(sm.Shop_Cd))
                                                                FROM ShopMaster sm
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59' AND sd.Executive_Cd = $qcExecutiveCd  )
                                                                
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd AND ccm.QC_Type in ('ShopSurvey') )
                                                                ),0) AS SD_Count
                                                            ";

                                                        }else if($qcType == 'ShopBoard'){
                                                            $shopQCTodayShopColumnCondition = " 
                                                             INNER JOIN ShopBoardDetails sbd on ( sbd.Shop_Cd=sm.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sbd.UpdatedDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59' AND sbd.BoardID = qd.BoardID AND CONVERT(VARCHAR,sbd.QC_UpdatedDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59' AND sbd.QC_Flag IS NOT NULL )
                                                            ";

                                                            $shopScheduleCondition =" ,
                                                                    0 AS SD_Count
                                                            ";
                                                        }else if($qcType == 'ShopDocument'){
                                                            $shopQCTodayShopColumnCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND qd.ScheduleCall_Cd = sd.ScheduleCall_Cd )
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument') 
                                                                )
                                                            ";


                                                            $shopScheduleCondition =" ,
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(sm.Shop_Cd))
                                                                FROM ShopMaster sm
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59' AND sd.Executive_Cd = $qcExecutiveCd  )
                                                                
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd AND ccm.QC_Type in ('ShopDocument') )
                                                                ),0) AS SD_Count
                                                            ";
                                                        }else if($qcType == 'ShopCalling'){
                                                              $shopQCTodayShopColumnCondition = " 
                                                                INNER JOIN ScheduleDetails sd ON ( sm.Shop_Cd = sd.Shop_Cd AND sm.IsActive = 1 AND sd.ScheduleCall_Cd = qd.ScheduleCall_Cd )
                                                                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$qcDate'+' 00:00:00'  AND '$qcDate'+' 23:59:59'  
                                                                )
                                                                INNER JOIN CallingCategoryMaster ccm on ( ccm.Calling_Category_Cd = sd.Calling_Category_Cd  AND ccm.Calling_Type = 'Calling' 
                                                                )
                                                                INNER JOIN CallingDetails cd ON ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND cd.Call_Response_Cd = 4 AND ISNULL(cd.AudioFile_Url,'') <> '' AND qd.Calling_Cd = cd.Calling_Cd)
                                                            ";



                                                            $shopScheduleCondition =" ,
                                                                    0 AS SD_Count
                                                            ";
                                                        }


                                                        $qcTypeTotalTodayRowCount = 0;
                                                        $qcTypeTodayRowCount = 0;
                                                        $smScheduledRowCount = 0;
                                                        $queryQC = "SELECT 
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(qd.Shop_Cd))
                                                                FROM QCDetails qd
                                                                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$qcDate'+' 00:00:00' AND '$qcDate'+' 23:59:59' AND qd.QC_Type = '$qcType' AND qd.Executive_Cd = $qcExecutiveCd )
                                                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                                                WHERE sm.IsActive = 1
                                                                $nodeNameCondition
                                                                $nodeCondition
                                                                $pcktCondition 
                                                            ),0) AS QC_Count ,
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(qd.Shop_Cd))
                                                                FROM QCDetails qd

                                                                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$qcDate'+' 00:00:00' AND '$qcDate'+' 23:59:59' AND qd.QC_Type = '$qcType' AND qd.Executive_Cd = $qcExecutiveCd )
                                                                $shopQCTodayShopColumnCondition
                                                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                                                WHERE sm.IsActive = 1
                                                                $shopQCShopListCondition
                                                                $nodeNameCondition
                                                                $nodeCondition
                                                                $pcktCondition 
                                                            ),0) AS QC_TodayShop_Count

                                                            $shopScheduleCondition

                                                          ;  ";
                                                            // echo $queryQC;
                                                            // echo "<br>";
                                                            // echo "<br>";
                                                        $dbQCC=new DbOperation();
                                                        $QC_CountData = $dbQCC->ExecutveQuerySingleRowSALData($queryQC, $electionName, $developmentMode);

                                                        $qcTypeTodayRowCount = $QC_CountData["QC_TodayShop_Count"];
                                                        $qcTypeTotalTodayRowCount = $QC_CountData["QC_Count"];
                                                        $smScheduledRowCount = $QC_CountData["SD_Count"];

                                                        if($qcType == 'ShopList'){
                                                            $shopListingQCTodayRowTotal = $shopListingQCTodayRowTotal + $qcTypeTodayRowCount;
                                                            $shopListingQCRowTotal = $shopListingQCRowTotal + $qcTypeTotalTodayRowCount;
                                                        }else if($qcType == 'ShopSurvey'){
                                                            $shopSurveyQCTodayRowTotal = $shopSurveyQCTodayRowTotal + $qcTypeTodayRowCount;
                                                            $shopSurveyQCRowTotal = $shopSurveyQCRowTotal + $qcTypeTotalTodayRowCount;
                                                            $shopSurveySDRowTotal = $shopSurveySDRowTotal + $smScheduledRowCount;
                                                        }else if($qcType == 'ShopBoard'){
                                                            $shopBoardQCTodayRowTotal = $shopBoardQCTodayRowTotal + $qcTypeTodayRowCount;
                                                            $shopBoardQCRowTotal = $shopBoardQCRowTotal + $qcTypeTotalTodayRowCount;
                                                        }else if($qcType == 'ShopDocument'){
                                                            $shopDocumentQCTodayRowTotal = $shopDocumentQCTodayRowTotal + $qcTypeTodayRowCount;
                                                            $shopDocumentQCRowTotal = $shopDocumentQCRowTotal + $qcTypeTotalTodayRowCount;
                                                            $shopDocumentSDRowTotal = $shopDocumentSDRowTotal + $smScheduledRowCount;
                                                        }else if($qcType == 'ShopCalling'){
                                                            $shopCallingQCTodayRowTotal = $shopCallingQCTodayRowTotal + $qcTypeTodayRowCount;
                                                            $shopCallingQCRowTotal = $shopCallingQCRowTotal + $qcTypeTotalTodayRowCount;
                                                        }
                                                        
                                                       
                                                ?>
                                                     <td style="text-align:center;">
                                                      
                                                       <span class="badge badge-success badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> QC Done from <?php echo $shAction; ?> on <?php echo date('d/m/Y', strtotime($qcDate)); ?>"><?php echo $qcTypeTodayRowCount; ?></span> 

                                                       <span class="badge badge-dark badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Total QC Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>"><?php echo $qcTypeTotalTodayRowCount; ?></span>
                                                       
                                                        <?php 
                                                            if($qcType == 'ShopList'){

                                                            }else if($qcType == 'ShopSurvey'){
                                                        ?>
                                                                
                                                                <span class="badge badge-info badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Scheduling Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                                    <?php echo $smScheduledRowCount; ?>
                                                                </span>
                                                        <?php 
                                                            }else if($qcType == 'ShopBoard'){

                                                            }else if($qcType == 'ShopDocument'){
                                                            ?>
                                                                
                                                                <span class="badge badge-info badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Scheduling Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                                    <?php echo $smScheduledRowCount; ?> 
                                                                </span>
                                                        <?php 
                                                            }else if($qcType == 'ShopCalling'){

                                                            }
                                                        ?>

                                                    </td>

                                                    
                                                <?php
                                                     }
                                                ?>
                                                 <td  style="text-align:center;">
                                                    <?php
                                                        $queryQCToday = "SELECT 
                                                            ISNULL((
                                                                SELECT
                                                                    COUNT(DISTINCT(qd.Shop_Cd))
                                                                FROM QCDetails qd
                                                                INNER JOIN ShopMaster sm on ( sm.Shop_Cd = qd.Shop_Cd AND sm.IsActive = 1 AND CONVERT(VARCHAR,qd.QC_DateTime,120 ) BETWEEN '$qcDate'+' 00:00:00' AND '$qcDate'+' 23:59:59'  AND qd.Executive_Cd = $qcExecutiveCd )
                                                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                                                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                                                                WHERE sm.IsActive = 1
                                                                $nodeNameCondition
                                                                $nodeCondition
                                                                $pcktCondition 
                                                            ),0) AS QC_Count";
                                                        $dbQCC=new DbOperation();
                                                        $QC_CountTodayData = $dbQCC->ExecutveQuerySingleRowSALData($queryQCToday, $electionName, $developmentMode);
                                                        $QC_CountTodayTotal = $QC_CountTodayTotal + $QC_CountTodayData["QC_Count"];
                                                    ?>
                                                    <span class="badge badge-dark badge-md  " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Total No. of Shops QC Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>"><?php echo $QC_CountTodayData["QC_Count"]; ?></span>
                                                 </td> 
                                            </tr>
                                <?php   } 

                                     
                                ?>
                                        </tbody>
                                        <tfoot>
                                            <th colspan="1">Total</th>
                                            <?php 
                                                foreach ($qcTypeArray as $key => $qcTypeValue) {
                                                    $qcTitle = $qcTypeValue["QC_Title"];
                                                    $shAction = $qcTypeValue["SH_Action"];
                                                    $qcType = $qcTypeValue["QC_Type"];
                                                    $qcFlag = $qcTypeValue["QC_Flag"];
                                                        
                                            ?>
                                                <th  style="text-align:center;">
                                                    <span class="badge badge-warning badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> QC Pending from <?php echo $shAction; ?> on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                        <?php 
                                                            if($qcType == 'ShopList'){
                                                                echo ($shopListingSMTodayRowTotal - $shopListingQCTodayRowTotal);
                                                            }else if($qcType == 'ShopSurvey'){
                                                                 echo ($shopSurveySMTodayRowTotal - $shopSurveyQCTodayRowTotal);
                                                            }else if($qcType == 'ShopBoard'){
                                                                 echo ($shopBoardSMTodayRowTotal - $shopBoardQCTodayRowTotal);
                                                            }else if($qcType == 'ShopDocument'){
                                                                 echo ($shopDocumentSMTodayRowTotal - $shopDocumentQCTodayRowTotal);
                                                            }else if($qcType == 'ShopCalling'){
                                                                 echo ($shopCallingSMTodayRowTotal - $shopCallingQCTodayRowTotal);
                                                            }
                                                        ?>
                                                        
                                                    </span> 


                                                   <span class="badge badge-dark badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Total QC Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                        <?php 
                                                            if($qcType == 'ShopList'){
                                                                echo $shopListingQCRowTotal;
                                                            }else if($qcType == 'ShopSurvey'){
                                                                 echo $shopSurveyQCRowTotal;
                                                            }else if($qcType == 'ShopBoard'){
                                                                 echo $shopBoardQCRowTotal;
                                                            }else if($qcType == 'ShopDocument'){
                                                                 echo $shopDocumentQCRowTotal;
                                                            }else if($qcType == 'ShopCalling'){
                                                                 echo $shopCallingQCRowTotal;
                                                            }
                                                        ?>
                                                    </span>
                                                  
                                                    
                                                        <?php 
                                                            if($qcType == 'ShopList'){

                                                            }else if($qcType == 'ShopSurvey'){
                                                        ?>
                                                                <span class="badge badge-info badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Scheduling Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                                    <?php echo $shopSurveySDRowTotal; ?>
                                                                </span>
                                                        <?php 
                                                            }else if($qcType == 'ShopBoard'){

                                                            }else if($qcType == 'ShopDocument'){
                                                            ?>
                                                                <span class="badge badge-info badge-md " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $qcTitle; ?> Scheduling Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>">
                                                                    <?php echo $shopDocumentSDRowTotal; ?> 
                                                                </span>
                                                        <?php 
                                                            }else if($qcType == 'ShopCalling'){

                                                            }
                                                        ?>
                                                    
                                                 
                                                </th>
                                            <?php 
                                                }
                                            ?>  
                                                <th  style="text-align:center;"><span class="badge badge-dark badge-md  " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Total No. of Shops QC Done on <?php echo date('d/m/Y', strtotime($qcDate)); ?>"><?php echo $QC_CountTodayTotal; ?></span></th>
                                        </tfoot>
                                    </table>
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
                   
</section>

 <!-- Modal -->
 <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document" style="max-width:80%;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Executive QC Summary</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                    <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                <div class="row">
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label for="fromDate">From Date</label>
                                                                        <input type='text' name="QCfromDate" value="<?php echo $fromDate;?>" class="form-control pickadate-disable-forwarddates" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label for="toDate">To Date</label>
                                                                        <input type='text' name="QCtoDate" value="<?php echo $toDate;?>" class="form-control pickadate-disable-forwarddates" />
                                                                    </div>
                                                                </div>

                                                                <!-- <div class="col-md-3 col-12"> -->
                                                                <?php //include 'dropdown-qc-executive-name.php' ?>
                                                                <!-- </div> -->

                                                                <div class="col-12 col-md-3 text-left">
                                                                    <div class="form-group">
                                                                        <label for="update"></label></br>
                                                                        <button type="button" class="btn btn-primary" onclick="setShopExecutiveQCSummaryData()"><i class="feather icon-refresh-cw"></i></button>
                                                                    </div>
                                                                </div>
                                                                </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <div class="modal-body" id="showExecutiveQCSummary">
                                                    
                                                    <!-- <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
                                                    </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>