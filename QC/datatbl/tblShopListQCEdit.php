<?php
    
    $fromDate = $_SESSION['SAL_FromDate']." ".$_SESSION['StartTime'];
    $toDate = $_SESSION['SAL_ToDate']." ".$_SESSION['EndTime'];

    $nodeCd = "All";
    if(isset($_SESSION['SAL_Node_Cd'])){
        $nodeCd = $_SESSION['SAL_Node_Cd'];
    }else{
        $_SESSION['SAL_Node_Cd'] = $nodeCd;
    }
    
    if($nodeCd == 'All'){
        $nodeCondition = "  ";
    }else{
        $nodeCondition = " AND nm.Node_Cd = $nodeCd ";
    }

    if(isset($_GET['shopId'])){
        $shop_Id = $_GET['shopId'];
        $shopIdCondition = " AND sm.Shop_Cd = $shop_Id ";
    }else{
        $shopIdCondition = "  ";
    }

    $searchShopCondition = "";
    if(!empty($shop_Name_Post)){
        if ($shop_Name_Post == trim($shop_Name_Post) && strpos($shop_Name_Post, ' ') !== false) {
            $strArr = explode(" ", $shop_Name_Post);
            foreach($strArr as $value){
                
               $searchShopCondition .= " and sm.ShopName like '%$value%' ";
            }

        }else{
             $searchShopCondition = " and sm.ShopName like '%$shop_Name_Post%' ";
        }
    }


    $shopKeeperMobileCondition = "";
    if(!empty($shop_KeeperMobile_Post)){
        if ($shop_KeeperMobile_Post == trim($shop_KeeperMobile_Post) && strpos($shop_KeeperMobile_Post, ' ') !== false) {
            $strArr = explode(" ", $shop_KeeperMobile_Post);
            foreach($strArr as $value){
                
               $shopKeeperMobileCondition .= " and sm.ShopKeeperMobile like '%$value%' ";
            }

        }else{
             $shopKeeperMobileCondition = " and sm.ShopKeeperMobile like '%$shop_KeeperMobile_Post%' ";
        }

    
    }
    
    $totalRecords = 0;
    $maxPageNo = 0;
    $recordPerPage = 5;
    if(isset($_SESSION['SAL_Pagination_PageNo']) && !empty($_SESSION['SAL_Pagination_PageNo'])){
        $pageNo = $_SESSION['SAL_Pagination_PageNo'];
        $_SESSION['SAL_Pagination_PageNo'] = "";
    }else{
        $pageNo = 1;  
    }
    

    $ShopListData = array();
    if($qcType=="ShopList"){
        $dateCondition = " CONVERT(VARCHAR,sm.AddedDate,120) BETWEEN '$fromDate' AND '$toDate' "; 

        if($shopExecutiveCd == "All"){
            $shopExecutiveCondition = " ";
        }else{
            $shopExecutiveCondition = " AND sm.AddedBy = (SELECT UserName FROM Survey_Entry_Data..User_Master where Executive_Cd = $shopExecutiveCd AND AppName = '$appName' ) ";
        }

        if($qcFilter == 'All'){
            if(!empty(trim($shopIdCondition))){
                $qcFilterCondition = " ";
            }else{
                $qcFilterCondition = " AND ( sm.QC_Flag IS NULL OR sm.QC_Flag = 1 ) ";
            }
        }else if($qcFilter == 'Pending'){
            if(!empty(trim($shopIdCondition))){
                $qcFilterCondition = " ";
            }else{
                $qcFilterCondition = " AND sm.QC_Flag IS NULL ";
            }
        }else if($qcFilter == 'Completed'){
            if(!empty(trim($shopIdCondition))){
                $qcFilterCondition = " ";
            }else{
                $qcFilterCondition = " AND sm.QC_Flag = 1 ";
            }
        }

        $queryTotal = "SELECT COUNT(sm.Shop_Cd) as TotalShopForQC
            FROM ShopMaster sm
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE $dateCondition
            $qcFilterCondition
            $shopExecutiveCondition
            $nodeCondition
            $shopIdCondition
            AND sm.IsActive = 1 ;
            ";
        
        $ShopTotalData = $db->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalData["TotalShopForQC"];

        $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShopForQC";
        // echo $totalDivideIntoPageQuery;
        $ShopTotalCountData = $db->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalCountData["TotalShopForQC"];

        $query = "SELECT 
            sm.Shop_Cd, ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName,
            ISNULL(nm.NodeName,'') as NodeName,
            ISNULL(nm.Ward_No,0) as Ward_No,
            ISNULL(nm.Area,'') as Area,
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory,  
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate,
            ISNULL((SELECT Remarks FROM Survey_Entry_Data..User_Master WHERE UserName = sm.AddedBy),'') as AddedByName,
            ISNULL((SELECT Mobile FROM Survey_Entry_Data..User_Master WHERE UserName = sm.AddedBy),'') as AddedMobile,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate,
            ISNULL(sm.QC_Flag,0) as QC_Flag,
            ISNULL(sm.ShopStatus,'') as ShopStatus,
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,100),'') as ShopStatusDate,
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark
        FROM ShopMaster sm
        INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
        INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
        INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        WHERE $dateCondition
        $qcFilterCondition
        $shopExecutiveCondition
        $nodeCondition
        $shopIdCondition
        $searchShopCondition
        $shopKeeperMobileCondition
        AND sm.IsActive = 1
        ORDER BY sm.AddedDate ASC 
        OFFSET ($pageNo - 1) * $recordPerPage ROWS 
        FETCH NEXT $recordPerPage ROWS ONLY;";

    $queryExport = "SELECT 
            sm.Shop_Cd, ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName,
            ISNULL(nm.NodeName,'') as NodeName,
            ISNULL(nm.Ward_No,0) as Ward_No,
            ISNULL(nm.Area,'') as Area,
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory,  
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate,
            ISNULL((SELECT Mobile FROM Survey_Entry_Data..User_Master WHERE UserName = sm.AddedBy),'') as AddedMobile,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate,
            ISNULL(sm.QC_Flag,0) as QC_Flag,
            ISNULL(sm.ShopStatus,'') as ShopStatus,
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,100),'') as ShopStatusDate,
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark
        FROM ShopMaster sm
        INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
        INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
        INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        WHERE $dateCondition
        $qcFilterCondition
        $shopExecutiveCondition
        $nodeCondition
        $shopIdCondition
        $searchShopCondition
        $shopKeeperMobileCondition
        AND sm.IsActive = 1
        ORDER BY sm.AddedDate ASC;";


    }else if($qcType=="ShopSurvey"){

        if($shopExecutiveCd == "All"){
            $shopExecutiveCondition = " ";
        }else{ 
            $shopExecutiveCondition = " AND st.ST_Exec_Cd= $shopExecutiveCd  ";
        }

        if($qcFilter == 'All'){
            $qcFilterCondition = " WHERE (a.QC_Detail_Cd = 0 OR a.QC_Detail_Cd <> 0 ) ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd = 0  ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd <> 0";
        }

        if($shopStatus == "All"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' OR  ISNULL(sm.ShopStatus,'') <> '') ";
            $shopStatusConditon = " AND ( ISNULL(sm.ShopStatus,'') = '' OR ( ISNULL(sm.ShopStatus,'') <> '' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) )  ";
        }else if($shopStatus == "NotShopStatus"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
            $shopStatusConditon = " AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
        }else if($shopStatus == "DeniedShopStatus"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
            $shopStatusConditon = " AND st.ST_StageName not in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) ";
            $shopStatusConditon .= " AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) ";
        }else{
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ISNULL(sm.ShopStatus,'') =  '$shopStatus' ";
            $shopStatusConditon = " AND ISNULL(sm.ShopStatus,'') =  '$shopStatus' ";
        }

        $queryTotal = "SELECT COUNT(t.Shop_Cd) as TotalShopForQC
            FROM ( SELECT a.Shop_Cd, a.QC_Detail_Cd

            FROM ( SELECT sd.Shop_Cd,
                ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),0) as QC_Detail_Cd
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                $shopExecutiveCondition
            )
            
            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                AND sd.CallingDate is not NULL 
            )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
            )INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE sm.IsActive = 1 
            $shopStatusConditon
            $nodeCondition
            ) a 
            $qcFilterCondition ) t;";
            
        $ShopTotalData = $db->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalData["TotalShopForQC"];

        $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShopForQC";
        // echo $totalDivideIntoPageQuery;
        $ShopTotalCountData = $db->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalCountData["TotalShopForQC"];

        $query = "SELECT  * FROM 
            ( SELECT sm.Shop_Cd, 
            ISNULL(sm.Shop_UID,'') as Shop_UID, 
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area, 
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1, 
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2, 
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory, 
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate, 
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate, 
            
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,
            ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark3
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                $shopExecutiveCondition
            )
            
            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                AND sd.CallingDate is not NULL 
            )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
            )INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE sm.IsActive = 1 
            $shopStatusConditon
            $nodeCondition
            $searchShopCondition
            $shopKeeperMobileCondition
            ) a 
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC 
            OFFSET ($pageNo - 1) * $recordPerPage ROWS 
            FETCH NEXT $recordPerPage ROWS ONLY;";

        $queryExport = "SELECT  * FROM 
            ( SELECT sm.Shop_Cd, 
            ISNULL(sm.Shop_UID,'') as Shop_UID, 
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area, 
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1, 
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2, 
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory, 
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate, 
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate, 
            
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,
            ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopSurvey'),'') as QC_Remark3
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                $shopExecutiveCondition
            )
            
            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                AND sd.CallingDate is not NULL 
            )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopSurvey')
            )INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE sm.IsActive = 1 
            $shopStatusConditon
            $nodeCondition
            $searchShopCondition
            $shopKeeperMobileCondition
            ) a 
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC;";


    }else if($qcType=="ShopDocument"){

        if($shopExecutiveCd == "All"){
            $shopExecutiveCondition = " ";
        }else{ 
            $shopExecutiveCondition = " AND st.ST_Exec_Cd= $shopExecutiveCd  ";
        }

        if($qcFilter == 'All'){
            $qcFilterCondition = " ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd = 0  ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd <> 0  ";
        }


        if($shopStatus == "All"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' OR  ISNULL(sm.ShopStatus,'') <> '') ";
            $shopStatusConditon = " AND ( ISNULL(sm.ShopStatus,'') = '' OR ( ISNULL(sm.ShopStatus,'') <> '' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) ) )  ";
        }else if($shopStatus == "NotShopStatus"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
            $shopStatusConditon = " AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
        }else if($shopStatus == "DeniedShopStatus"){
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ( ISNULL(sm.ShopStatus,'') = '' ) ";
            $shopStatusConditon = " AND st.ST_StageName not in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) ";
            $shopStatusConditon = " AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) ";
        }else{
            // $shopStatusConditon = " AND CONVERT(VARCHAR,sm.SurveyDate,120) BETWEEN '$fromDate' AND '$toDate' AND ISNULL(sm.ShopStatus,'') =  '$shopStatus' ";
            $shopStatusConditon = " AND ISNULL(sm.ShopStatus,'') =  '$shopStatus' ";
        }

        $queryTotal = "SELECT COUNT(t.Shop_Cd) as TotalShopForQC
            FROM ( SELECT a.Shop_Cd, a.QC_Detail_Cd

            FROM ( SELECT sd.Shop_Cd,
                ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),0) as QC_Detail_Cd
                FROM ScheduleDetails sd 
                INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                    $shopExecutiveCondition
                )
                INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                    AND sd.CallingDate is not NULL 
                )
                INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                    AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
                ) 
                INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
                INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
                INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
                LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
                WHERE sm.IsActive = 1 
                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster
                WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                $shopStatusConditon
                $nodeCondition
            ) a
            $qcFilterCondition ) t;";

        $ShopTotalData = $db->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalData["TotalShopForQC"];

        $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShopForQC";
        // echo $totalDivideIntoPageQuery;
        $ShopTotalCountData = $db->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalCountData["TotalShopForQC"];

        $query = "SELECT  * FROM ( SELECT sm.Shop_Cd, 
            ISNULL(sm.Shop_UID,'') as Shop_UID, 
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area, 
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1, 
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2, 
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2, 
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory, 
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate, 
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate, 
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,
            ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark3,
            ISNULL((SELECT COUNT(sdoc.Shop_Cd) FROM ShopDocuments sdoc WHERE sdoc.Shop_Cd = sm.Shop_Cd AND sdoc.IsActive = 1 
                AND ISNULL( sdoc.FileURL,'') <> ''),'') as DocCount
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                $shopExecutiveCondition
            )
            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                AND sd.CallingDate is not NULL 
            )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
            ) 
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE sm.IsActive = 1 
            AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster
                WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
            $shopStatusConditon
            $nodeCondition
            $searchShopCondition
            $shopKeeperMobileCondition
            ) a
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC 
            OFFSET ($pageNo - 1) * $recordPerPage ROWS 
            FETCH NEXT $recordPerPage ROWS ONLY;";

        $queryExport = "SELECT  * FROM ( SELECT sm.Shop_Cd, 
            ISNULL(sm.Shop_UID,'') as Shop_UID, 
            ISNULL(sm.ShopName,'') as ShopName, 
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area, 
            ISNULL(sm.ShopAddress_1,'') as ShopAddress_1, 
            ISNULL(sm.ShopAddress_2,'') as ShopAddress_2, 
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2, 
            ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sm.ShopCategory, '') as ShopCategory, 
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate, 
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate, 
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd,
            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,
            ISNULL(sd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopDocument'),'') as QC_Remark3,
            ISNULL((SELECT COUNT(sdoc.Shop_Cd) FROM ShopDocuments sdoc WHERE sdoc.Shop_Cd = sm.Shop_Cd AND sdoc.IsActive = 1 
                AND ISNULL( sdoc.FileURL,'') <> ''),'') as DocCount
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                $shopExecutiveCondition
            )
            INNER JOIN ShopMaster sm on (sd.Shop_Cd = sm.Shop_Cd
                AND sd.CallingDate is not NULL 
            )
            INNER JOIN CallingCategoryMaster ccm on (ccm.Calling_Category_Cd = sd.Calling_Category_Cd
                AND ccm.Calling_Type = 'Survey' AND ccm.QC_Type in ('ShopDocument')
            ) 
            INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd 
            INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
            INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd 
            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
            WHERE sm.IsActive = 1 
            AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster
                WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
            $shopStatusConditon
            $nodeCondition
            $searchShopCondition
            $shopKeeperMobileCondition
            ) a
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC ;";



    }else if($qcType=="ShopCalling"){

        if($shopExecutiveCd == "All"){
            $shopExecutiveCondition = " ";
        }else{ 
            $shopExecutiveCondition = " AND st.ST_Exec_Cd= $shopExecutiveCd  ";
        }  

        if($qcFilter == 'All'){
            $qcFilterCondition = " ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd = 0  ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd <> 0  ";
        }

        $queryTotal = "SELECT
                    COUNT(t1.Shop_Cd) as TotalShopForQC
                FROM (
                    SELECT t.Shop_Cd, t.Call_Date, COUNT(DISTINCT(t.Shop_Cd)) as TotalShopForQC
                    FROM ( 
                        SELECT a.Shop_Cd, a.Call_Date, a.QC_Detail_Cd
                        FROM (
                            SELECT cd.Shop_Cd,
                                ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,23),'') as Call_Date,
                                ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),0) as QC_Detail_Cd
                            FROM ScheduleDetails sd 
                            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                    AND st.ST_Status = 1 AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
                                    $shopExecutiveCondition
                                )
                            INNER JOIN CallingDetails cd on ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND 
                                CONVERT(VARCHAR,cd.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate' )
                            INNER JOIN  ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd AND 
                                CONVERT(VARCHAR,cd.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate' AND sm.IsActive=1
                                AND cd.Call_Response_Cd = 4
                                AND ISNULL(cd.AudioFile_Url,'') <> ''
                            )
                            INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
                            INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
                            INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
                            INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
                            INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
                            LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
                            $nodeCondition
                        ) a
                    
                        $qcFilterCondition
                    
                    ) t     
                    GROUP BY t.Shop_Cd, t.Call_Date
                ) t1; ";

        $ShopTotalData = $db->ExecutveQuerySingleRowSALData($queryTotal, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalData["TotalShopForQC"];

        $totalDivideIntoPageQuery = "SELECT CEILING( CAST ($totalRecords as float) /$recordPerPage) as TotalShopForQC";
        // echo $totalDivideIntoPageQuery;
        $ShopTotalCountData = $db->ExecutveQuerySingleRowSALData($totalDivideIntoPageQuery, $electionName, $developmentMode); 
        $totalRecords = $ShopTotalCountData["TotalShopForQC"];

        $query = "SELECT  
            a.Shop_Cd, a.Call_Date,
            ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName,
            ISNULL(sm.ShopNameMar,'') as ShopNameMar,
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),0) as AddedDate,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),0) as SurveyDate,
            ISNULL(bcm.BusinessCatName,'') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(sm.ShopCategory,'') as ShopCategory,
            ISNULL(sm.QC_Flag,'') as QC_Flag,
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            ISNULL(CONVERT(VARCHAR,max(a.Call_DateTime),100),'') as Call_DateTime,
            ISNULL((SELECT ExecutiveName FROM Survey_Entry_Data..Executive_Master WHERE Executive_Cd = max(a.Executive_Cd)),'') as ExecutiveName,
            STRING_AGG(a.Calling_Cd,',') as Calling_Cds,
            STRING_AGG(a.Calling_Cd,'_') as Calling_Cd_s,
            COUNT(a.ScheduleCall_Cd) as SchedulesCount
        FROM ( SELECT 
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
            ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
            ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
            ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
            ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,23),'') as Call_Date,
            ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
            ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
            ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
            ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
            ISNULL(cd.GoodCall,0) as GoodCall, 
            ISNULL(cd.Appreciation,0) as Appreciation, 
            ISNULL(cd.AudioListen,0) as AudioListen, 
            ISNULL(cd.Remark1,'') as Remark1, 
            ISNULL(cd.Remark2,'') as Remark2, 
            ISNULL(cd.Remark3,'') as Remark3,
            ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName,
            ISNULL(sm.ShopNameMar,'') as ShopNameMar,
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),0) as AddedDate,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),0) as SurveyDate,
            ISNULL(bcm.BusinessCatName,'') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(sm.ShopCategory,'') as ShopCategory,
            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,
            
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(crm.Call_Response,'') as Call_Response,


            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,

            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark3
        FROM ScheduleDetails sd 
        INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd AND st.ST_Status = 1 
            AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
            $shopExecutiveCondition
            )
        INNER JOIN CallingDetails cd on ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND 
            CONVERT(VARCHAR,cd.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate' )
        INNER JOIN ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd  AND sm.IsActive=1
            
            $searchShopCondition
            $shopKeeperMobileCondition
            AND cd.Call_Response_Cd = 4
            AND ISNULL(cd.AudioFile_Url,'') <> ''
        )
        INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
        INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        WHERE sm.IsActive = 1 
        $nodeCondition
        ) a
        INNER JOIN ShopMaster sm on sm.Shop_Cd = a.Shop_Cd
        LEFT JOIN StatusMaster AS stm ON (stm.ApplicationStatus=sm.ShopStatus)
        INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        $qcFilterCondition

        GROUP BY a.Shop_Cd, a.Call_Date, sm.Shop_UID,sm.ShopName,sm.ShopNameMar,sm.ShopKeeperName,sm.ShopKeeperMobile,
        pm.PocketName,nm.NodeName,nm.Ward_No,nm.Area,sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopInsideImage1,
        sm.ShopInsideImage2,sm.IsCertificateIssued,sm.AddedDate,sm.SurveyDate,bcm.BusinessCatName, sam.ShopArea_Cd,
        sam.ShopAreaName, sam.ShopAreaNameMar, sm.ShopCategory, sm.QC_Flag, sm.ShopStatus, sm.ShopStatusDate,sm.ShopStatusRemark

        ORDER BY a.Call_Date ASC 
        OFFSET ($pageNo - 1) * $recordPerPage ROWS 
        FETCH NEXT $recordPerPage ROWS ONLY;
        ";

        $queryExport = "SELECT  * FROM ( SELECT 
            ISNULL(sd.ScheduleCall_Cd,0) as ScheduleCall_Cd, 
            ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
            ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
            ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
            ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
            ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
            ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
            ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
            ISNULL(cd.GoodCall,0) as GoodCall, 
            ISNULL(cd.Appreciation,0) as Appreciation, 
            ISNULL(cd.AudioListen,0) as AudioListen, 
            ISNULL(cd.Remark1,'') as Remark1, 
            ISNULL(cd.Remark2,'') as Remark2, 
            ISNULL(cd.Remark3,'') as Remark3,
            ISNULL(sm.Shop_UID,'') as Shop_UID,
            ISNULL(sm.ShopName,'') as ShopName,
            ISNULL(sm.ShopNameMar,'') as ShopNameMar,
            ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
            ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
            ISNULL(pm.PocketName,'') as PocketName, 
            ISNULL(nm.NodeName,'') as NodeName, 
            ISNULL(nm.Ward_No,0) as Ward_No, 
            ISNULL(nm.Area,'') as Area,
            ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1, 
            ISNULL(sm.ShopOutsideImage2,'') as ShopOutsideImage2, 
            ISNULL(sm.ShopInsideImage1,'') as ShopInsideImage1, 
            ISNULL(sm.ShopInsideImage2,'') as ShopInsideImage2,
            
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),0) as AddedDate,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),0) as SurveyDate,
            ISNULL(bcm.BusinessCatName,'') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(sm.ShopCategory,'') as ShopCategory,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(crm.Call_Response,'') as Call_Response,

            ISNULL(sm.ShopStatus,'') as ShopStatus, 
            ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate, 
            ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark,

            ISNULL(sd.Shop_Cd,0) as SD_Shop_Cd,
            
            ISNULL(ccm.QC_Type,'') as SD_QC_Type,
            ISNULL(CONVERT(VARCHAR,sd.CallingDate,100),'') as ScheduleDate,
            ISNULL(sd.CallReason,'') as ScheduleReason,
            ISNULL(CONVERT(VARCHAR,st.ST_DateTime,100),'') as ST_DateTime,
            ISNULL(st.ST_Remark_1,'') as ST_Remark_1,
            ISNULL(st.ST_Remark_2,'') as ST_Remark_2,
            ISNULL(st.ST_Remark_3,'') as ST_Remark_3,
            ISNULL(st.ST_Status,0) as ST_Status,
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd AND qd.QC_Type = 'ShopCalling'),'') as QC_Remark3
        FROM ScheduleDetails sd 
        INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd AND st.ST_Status = 1 
            AND CONVERT(VARCHAR,st.ST_DateTime,120) BETWEEN '$fromDate' AND '$toDate' 
            $shopExecutiveCondition
            )
        INNER JOIN CallingDetails cd on ( st.ScheduleCall_Cd = cd.ScheduleCall_Cd AND 
            CONVERT(VARCHAR,cd.Call_DateTime,120) BETWEEN '$fromDate' AND '$toDate' )
        INNER JOIN ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd  AND sm.IsActive=1
            
            $searchShopCondition
            $shopKeeperMobileCondition
            AND cd.Call_Response_Cd = 4
            AND ISNULL(cd.AudioFile_Url,'') <> ''
        )
        INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
        INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        WHERE sm.IsActive = 1 
        $nodeCondition
        ) a
        $qcFilterCondition
        ORDER BY a.Call_DateTime ASC ;
        ";
        

    }

    $executiveCd = 0;
    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
        if(sizeof($exeData)>0){
            $executiveCd = $exeData["Executive_Cd"];
        }
    }

    if($executiveCd==669){
        //  echo $query;
        // echo "<br>";
        // echo "<br>";
        // echo $queryTotal;
    }
    
    
    if(!empty($query)){
        $db=new DbOperation();
      
        if($executiveCd==669){
            $ShopListData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);    
            $ShopListExportData = $db->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);    
            
        }else{

            $ShopListData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);    
            $ShopListExportData = $db->ExecutveQueryMultipleRowSALData($queryExport, $electionName, $developmentMode);    
            
        }
    }
    
    // print_r($ShopListData);
    // print_r($ShopTotalData);

        
?>

<style>
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;}

    img.galleryimg:hover{
        transform: scale(2.2);
        z-index: 9999;
    }
  /*  table.dataTable th{
        display: none;
    }*/
    h4,h5{
        color: #C90D41;
        font-weight: 900;
    }
</style>
<?php if(sizeof($ShopListData)>0){ ?>
            <div class="col-xl-4 col-md-4 col-xs-12" style="padding-top: 5px;">
                <h4>QC <?php if($qcType=="ShopList"){ echo "Shop List"; }else if($qcType=="ShopSurvey"){ echo "Shop Survey"; }else if($qcType=="ShopDocument"){ echo "Shop Document"; }else if($qcType=="ShopCalling"){echo "Shop Calling"; } ?> (<?php if( sizeof($ShopTotalData)>0){ echo $ShopTotalData["TotalShopForQC"]; }else{ echo "0"; } ?>)</h4>
            </div>
            <div class="col-xl-5 col-md-5 col-xs-12">
                <?php //if($qcType=="ShopList"){ ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php 
                                // echo $totalRecords;
                                $loopStart = 1;
                                $loopStop = $totalRecords;

                                if($totalRecords > 5){
                                     if($pageNo==1){
                                        $loopStart = $pageNo;
                                    }else if($pageNo==2){
                                        $loopStart = $pageNo - 1;
                                    }else if($pageNo>=3){
                                        $loopStart = $pageNo - 2;
                                    }else{
                                        $loopStart = $pageNo ;
                                    }
                                    
                                    $loopStop = $loopStart + 5;
                                    if($loopStop>$totalRecords){
                                        $loopStop = $totalRecords;
                                        $loopStart = $loopStop - 5;
                                    }
                                }
                            ?>

                            <?php
                                if($pageNo != $loopStart ){ 
                            ?>  
                                <li class="page-item prev"><a class="page-link" onclick="setPaginationPageNoInSession(<?php echo ($loopStart - 1);  ?>)" >Prev</a></li>
                            <?php } ?>

                            <?php
                                for($i=$loopStart;$i<=$loopStop;$i++){ 

                                        $activePageCondition = ""; 
                                        if($pageNo == $i){
                                            $activePageCondition = "active";                                
                                        }
                                    ?>
                                    <li class="page-item <?php echo $activePageCondition; ?>"><a class="page-link" onclick="setPaginationPageNoInSession(<?php echo $i; ?>)" ><?php echo $i; ?></a></li>
                            <?php } ?>
                            <?php if($totalRecords > $loopStop){ ?>  
                                <li class="page-item next"><a class="page-link"  onclick="setPaginationPageNoInSession(<?php echo ($loopStop + 1);  ?>)" >Next</a></li>
                            <?php }  ?>
                        </ul>
                    </nav>
                <?php //} ?>
            </div>
            <div class="col-xl-3 col-md-3 col-xs-12 text-right">
                <form method='post' action='ShopListQCDataExport.php'>
                    <input type='submit' value='Export' name='Export' class="btn btn-success">
                      <?php 
                        $serialize_ShopListData = serialize($ShopListExportData);
                       ?>
                    <input type='hidden' value='<?php echo $qcType; ?>' name='qcType'>
                    <textarea name='export_data' style='display: none;'><?php echo $serialize_ShopListData; ?></textarea>
                </form>
            </div>
                <?php
                    $srNo = 0;
                    if($pageNo!=1){
                        $srNo = (($pageNo * $recordPerPage) - ($recordPerPage));
                    }
                    foreach($ShopListData as $shopData){
                        
                ?>
                   <div class="col-xl-12 col-md-12 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                   <?php 
                                    $srNo = $srNo+1;
                                    $Shop_Cd = $shopData["Shop_Cd"];
                                        if($qcType=="ShopList"){
                                            include 'getShopListQCFormData.php';
                                        }else if($qcType=="ShopSurvey" || $qcType=="ShopDocument" ){
                                            $ScheduleCall_Cd = $shopData["ScheduleCall_Cd"];
                                            include 'getShopSurveyAndDocumentQCFormData.php';
                                        }else if($qcType=="ShopCalling" ){
                                            $Calling_Cds = $shopData["Calling_Cds"];
                                            $Calling_Cd_s = $shopData["Calling_Cd_s"];
                                            include 'getShopCallingQCFormData.php';
                                        }
                                        
                                   ?>
                           </div>
                        </div>

                    </div>
                                        
                             
                <?php } ?>
                        
               
            
 <?php } ?>