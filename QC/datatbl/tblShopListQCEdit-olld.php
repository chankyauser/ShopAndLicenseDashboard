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

    $ShopListData = array();
    if($qcType=="ShopList"){
        if($qcFilter == 'All'){
            $qcFilterCondition = " AND ( sm.QC_Flag IS NULL OR sm.QC_Flag = 1 ) ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " AND sm.QC_Flag IS NULL ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " AND sm.QC_Flag = 1 ";
        }
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
        WHERE sm.AddedDate BETWEEN '$fromDate' AND '$toDate'
        $qcFilterCondition
        $nodeCondition
        AND sm.IsActive = 1
        ORDER BY sm.AddedDate ASC;";
    }else if($qcType=="ShopSurvey"){
        // if($qcFilter == 'All'){
        //     $qcFilterCondition = " AND sm.QC_Flag IS NOT NULL  ";
        //     $qcFilterCondition .= " AND ( sm.QC_Flag = 1 OR sm.QC_Flag = 2 ) ";
        // }else if($qcFilter == 'Pending'){
        //     $qcFilterCondition = " AND sm.QC_Flag IS NOT NULL  ";
        //     $qcFilterCondition .= " AND sm.QC_Flag = 1 ";
        // }else if($qcFilter == 'Completed'){
        //     $qcFilterCondition = " AND sm.QC_Flag IS NOT NULL  ";
        //     $qcFilterCondition .= " AND sm.QC_Flag = 2 ";
        // }
        // $query = "SELECT
        //     sm.Shop_Cd, ISNULL(sm.Shop_UID,'') as Shop_UID,
        //     ISNULL(sm.ShopName,'') as ShopName, 
        //     ISNULL(sm.ShopKeeperName,'') as ShopKeeperName, 
        //     ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile, 
        //     ISNULL(pm.PocketName,'') as PocketName,
        //     ISNULL(nm.NodeName,'') as NodeName,
        //     ISNULL(nm.Ward_No,0) as Ward_No,
        //     ISNULL(nm.Area,'') as Area,
        //     ISNULL(sm.ShopAddress_1,'') as ShopAddress_1,
        //     ISNULL(sm.ShopAddress_2,'') as ShopAddress_2,
        //     ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
        //     ISNULL(bcm.BusinessCatName, '') as Nature_of_Business,
        //     ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
        //     ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
        //     ISNULL(sm.ShopCategory, '') as ShopCategory,  
        //     ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
        //     ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),'') as AddedDate,
        //     ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),'') as SurveyDate,
        //     ISNULL(sm.QC_Flag,0) as QC_Flag,
        //     ISNULL(sm.ShopStatus,'') as ShopStatus,
        //     ISNULL(CONVERT(VARCHAR,sm.ShopStatusDate,105),'') as ShopStatusDate,
        //     ISNULL(sm.ShopStatusRemark,'') as ShopStatusRemark
            
           
        // FROM ShopMaster sm
        // INNER JOIN PocketMaster pm on pm.Pocket_Cd = sm.Pocket_Cd
        // INNER JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
        // INNER JOIN BusinessCategoryMaster bcm ON sm.BusinessCat_Cd = bcm.BusinessCat_Cd
        // LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd)
        // WHERE sm.SurveyDate BETWEEN '$fromDate' AND '$toDate'
        // $qcFilterCondition
        // AND sm.IsActive = 1
        // ORDER BY sm.SurveyDate ASC;";

        if($qcFilter == 'All'){
            $qcFilterCondition = " ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd = 0  ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd <> 0  ";
        }
        $query = "SELECT * FROM 
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
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark3
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND st.ST_DateTime BETWEEN '$fromDate' AND '$toDate' 
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
            
            $nodeCondition
            ) a 
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC;";


    }else if($qcType=="ShopDocument"){
        // if($qcFilter == 'All'){
        //     $qcFilterCondition = " AND ( sd.QC_Flag IS NULL OR sd.QC_Flag = 3) ";
        // }else if($qcFilter == 'Pending'){
        //     $qcFilterCondition = " AND ( sd.QC_Flag IS NULL OR sd.QC_Flag = 0 ) ";
        //     $qcFilterCondition .= " AND sm.QC_Flag = 2 ";
        // }else if($qcFilter == 'Completed'){
        //     $qcFilterCondition = " AND sd.QC_Flag IS NOT NULL  ";
        //     $qcFilterCondition .= " AND sd.QC_Flag = 3 ";
        //     $qcFilterCondition .= " AND sm.QC_Flag = 3 ";
        // }

        // $query = "SELECT
        //     ISNULL(sm.Shop_Cd,0) as Shop_Cd, 
        //     ISNULL(sm.Shop_UID,'') as Shop_UID,
        //     ISNULL(sm.ShopName,'') as ShopName,
        //     ISNULL(sm.ShopNameMar,'') as ShopNameMar,
        //     ISNULL(sm.ShopKeeperName,'') as ShopKeeperName,
        //     ISNULL(sm.ShopKeeperMobile,'') as ShopKeeperMobile,
        //     ISNULL(sm.ShopOutsideImage1,'') as ShopOutsideImage1,
        //     ISNULL(sm.ShopStatus,'') as ShopStatus,
        //     ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
        //     ISNULL(sm.QC_Flag,0) as QC_Flag,
        //     ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),0) as AddedDate,
        //     ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),0) as SurveyDate,
        //     ISNULL(bcm.BusinessCatName,'') as Nature_of_Business,
        //     ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
        //     ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
        //     ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
        //     ISNULL(sm.ShopCategory,'') as ShopCategory,
        //     ISNULL(COUNT(sd.Shop_Cd),0) As DocPendingQC
        // FROM ShopMaster sm
        // INNER JOIN ShopDocuments sd on (
        //     sm.Shop_Cd = sd.Shop_Cd AND sd.IsActive = 1 
        //     AND ISNULL( sd.FileURL,'') <> ''
        //     AND sd.UpdatedDate BETWEEN '$fromDate' AND '$toDate' AND sm.IsActive=1
        //     $qcFilterCondition
        // )
        // INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        // INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        // INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        // LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd)
        // GROUP BY sm.Shop_Cd, sm.Shop_UID, sm.ShopName, sm.ShopNameMar,sm.ShopKeeperName, 
        // sm.ShopKeeperMobile, sm.ShopOutsideImage1, sm.ShopStatus, sm.ShopCategory, 
        // sm.IsCertificateIssued, sm.QC_Flag,sm.AddedDate, sm.SurveyDate, bcm.BusinessCatName
        // ";
        

        if($qcFilter == 'All'){
            $qcFilterCondition = " ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd = 0  ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " WHERE a.QC_Detail_Cd <> 0  ";
        }
        $query = "SELECT * FROM ( SELECT sm.Shop_Cd, 
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
            ISNULL((SELECT max(qd.QC_Detail_Cd) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),0) as QC_Detail_Cd,
            ISNULL((SELECT max(qd.QC_Flag) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),0) as QC_Flag,
            ISNULL((SELECT CONVERT(VARCHAR,max(qd.QC_DateTime),100) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_DateTime,
            ISNULL((SELECT max(qd.QC_Remark1) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark1,
            ISNULL((SELECT max(qd.QC_Remark2) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark2,
            ISNULL((SELECT max(qd.QC_Remark3) FROM QCDetails qd WHERE qd.ScheduleCall_Cd=sd.ScheduleCall_Cd AND qd.Shop_Cd=sd.Shop_Cd),'') as QC_Remark3,
            ISNULL((SELECT COUNT(sdoc.Shop_Cd) FROM ShopDocuments sdoc WHERE sdoc.Shop_Cd = sm.Shop_Cd AND sdoc.IsActive = 1 
                AND ISNULL( sdoc.FileURL,'') <> ''),'') as DocCount
            FROM ScheduleDetails sd 
            INNER JOIN ShopTracking st on ( st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                AND st.ST_Status = 1 AND st.ST_DateTime BETWEEN '$fromDate' AND '$toDate' 
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
            
            $nodeCondition
            ) a
            $qcFilterCondition
            ORDER BY a.SurveyDate ASC;";


    }else if($qcType=="ShopCalling"){
        if($qcFilter == 'All'){
            $qcFilterCondition = " AND ( cd.QC_Flag IS NULL OR cd.QC_Flag = 4) ";
        }else if($qcFilter == 'Pending'){
            $qcFilterCondition = " AND ( cd.QC_Flag IS NULL OR cd.QC_Flag = 0 ) ";
        }else if($qcFilter == 'Completed'){
            $qcFilterCondition = " AND cd.QC_Flag IS NOT NULL  ";
            $qcFilterCondition .= " AND cd.QC_Flag = 4 ";
        }

        $query = "SELECT
            ISNULL(cd.Shop_Cd,0) as Shop_Cd, 
            ISNULL(cd.Calling_Category_Cd,0) as Calling_Category_Cd,
            ISNULL(cd.Calling_Cd,0) as Calling_Cd, 
            ISNULL(cd.Call_Response_Cd,0) as Call_Response_Cd, 
            ISNULL(CONVERT(VARCHAR,cd.Call_DateTime,100),'') as Call_DateTime, 
            ISNULL(cd.AudioFile_Url,'') as AudioFile_Url, 
            ISNULL(cd.Executive_Cd,0) as Executive_Cd, 
            ISNULL(cd.CallRecordStatus,0) as CallRecordStatus, 
            ISNULL(cd.GoodCall,0) as GoodCall, 
            ISNULL(cd.QC_Flag,0) as QC_Flag, 
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
            ISNULL(sm.ShopStatus,'') as ShopStatus,
            
            ISNULL(sm.IsCertificateIssued,0) as IsCertificateIssued,
            ISNULL(CONVERT(VARCHAR,sm.AddedDate,100),0) as AddedDate,
            ISNULL(CONVERT(VARCHAR,sm.SurveyDate,100),0) as SurveyDate,
            ISNULL(bcm.BusinessCatName,'') as Nature_of_Business,
            ISNULL(sam.ShopArea_Cd, 0) as ShopArea_Cd, 
            ISNULL(sam.ShopAreaName, '') as ShopAreaName, 
            ISNULL(sam.ShopAreaNameMar, '') as ShopAreaNameMar,
            ISNULL(sm.ShopCategory,'') as ShopCategory,
            ISNULL(ccm.Calling_Category,'') as Calling_Category,
            ISNULL(crm.Call_Response,'') as Call_Response
        FROM CallingDetails cd
        INNER JOIN  ShopMaster sm  on ( sm.Shop_Cd = cd.Shop_Cd AND 
            cd.Call_DateTime BETWEEN '$fromDate' AND '$toDate' AND sm.IsActive=1
            $qcFilterCondition
            $nodeCondition
            AND cd.Call_Response_Cd = 4
            AND ISNULL(cd.AudioFile_Url,'') <> ''
        )
        INNER JOIN PocketMaster pm on ( pm.Pocket_Cd = sm.Pocket_Cd AND pm.IsActive = 1 )
        INNER JOIN NodeMaster nm on ( nm.Node_Cd = pm.Node_Cd AND nm.IsActive = 1 )
        INNER JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd
        INNER JOIN Call_Response_Master crm on crm.Call_Response_Cd = cd.Call_Response_Cd
        INNER JOIN CallingCategoryMaster ccm on ccm.Calling_Category_Cd = cd.Calling_Category_Cd
        LEFT JOIN ShopAreamaster AS sam ON (sm.ShopArea_Cd = sam.ShopArea_Cd) 
        ";
        
    }
    
    // echo $query;
    if(!empty($query)){
        $db=new DbOperation();
        $ShopListData = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);    
    }
    

        
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
    <div class="col-xl-4 col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4>QC <?php echo $qcType; ?> (<?php echo sizeof($ShopListData); ?>)</h4>
                <form method='post' action='ShopListQCDataExport.php'>
                    <input type='submit' value='Export' name='Export' style="float:right;width:70px;height:30px;color:white;background-color:grey;">
                      <?php 
                        $serialize_ShopListData = serialize($ShopListData);
                       ?>
                    <input type='hidden' value='<?php echo $qcType; ?>' name='qcType'>
                    <textarea name='export_data' style='display: none;'><?php echo $serialize_ShopListData; ?></textarea>
                </form>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                    <table  class="table table-striped table-bordered complex-headers zero-configuration">
                        <thead>
                            <tr>
                                <!-- <th>Sr No</th> -->
                                <th>Shop Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $srno = 0;
                                foreach($ShopListData as $shopData){
                                    $srno = $srno+1;
                            ?>
                            <tr>
                                <!-- <td style="text-align: top;vertical-align: top;"> <h5 class="mb-0" style="color: #C90D41;"> <?php //echo $srno.")";?></h5></td> -->
                                <td>
                                    
                                    <?php 
                                            if(!empty($qcType) && $qcType == 'ShopList'){
                                        ?>
                                            <h5 class="mb-0" style="color: #C90D41;"> <?php echo $srno.") ".$shopData["ShopName"]; ?></h5>
                                            <h6><?php echo "<b>Shop Listed Date : </b>".$shopData["AddedDate"]; ?></h6>
                                            <h6><?php echo "<b>Shop Listed By : </b>".$shopData["AddedMobile"]; ?></h6>
                                        <?php
                                            }else if(!empty($qcType) && $qcType == 'ShopDocument'){ 
                                        ?>
                                            <h5 class="mb-0" style="color: #C90D41;"> <?php echo $srno.") ".$shopData["ShopName"]." - ".$shopData["Calling_Category"]." (".$shopData["DocCount"].")"; ?></h5>
                                        <?php
                                            }else{
                                        ?>
                                            <h5 class="mb-0" style="color: #C90D41;"> <?php echo $srno.") ".$shopData["ShopName"]." - ".$shopData["Calling_Category"]; ?></h5>
                                        <?php
                                            }
                                        ?>

                                        
                                        <h6><?php if(!empty($shopData["SurveyDate"])){ echo "<b>Survey Date : </b>".$shopData["SurveyDate"]; }  ?></h6>
                                        <?php 
                                            if(!empty($qcType) && $qcType == 'ShopCalling'){
                                        ?>
                                            <h6><?php if(!empty($shopData["Call_DateTime"])){ echo "<b>Calling Date : </b>".$shopData["Call_DateTime"]; }  ?></h6>
                                        <?php
                                            } 
                                        ?>
                                    <div class="employee-task d-flex justify-content-between align-items-top">
                                        <div class="media">
                                           <div class="avatar mr-75">
                                                <?php if($shopData["ShopOutsideImage1"] != ''){ ?>
                                                    <img src="<?php echo $shopData["ShopOutsideImage1"]; ?>" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                                <?php } else { ?>   
                                                    <img src="pics/shopDefault.jpeg" class="rounded galleryimg" width="120" height="120" alt="Avatar" />
                                                <?php } ?>
                                                
                                            </div>

                                            <div class="media-body my-10px" style="margin-top: 10px;">
                                              <!--  <?php //if(!empty($shopData["ShopKeeperName"])){ ?> 
                                               <h6><b><?php //echo $shopData["ShopKeeperName"]; ?>  <?php //if(!empty($shopData["ShopKeeperMobile"])){  echo " - ".$shopData["ShopKeeperMobile"]; } ?></b></h6>
                                                <?php //} ?> -->
                                                <h6><?php echo $shopData["Nature_of_Business"]; ?></h6>
                                                <h6><?php echo $shopData["ShopAreaName"]; ?></h6>
                                                <h6><?php echo $shopData["ShopCategory"]; ?></h6>
                                                <h6><?php echo "Pocket : ".$shopData["PocketName"]." Ward : ".$shopData["Ward_No"]." Area : ".$shopData["Area"]; ?></h6>
                                               
                                           
                                            </div>
                                      
                                        </div>
                                                
                                        <div class="d-flex align-items-bottom">
                                           <small class="text-muted mr-75">
                                                <!-- <h6> 
                                                    <?php //if($shopData["ShopStatus"] == "Verified") { ?> 
                                                            <b style="color:green;"><?php //echo "Verified"; ?>  </b>
                                                            <i class="fa fa-check-circle" style="color:green;font-size:22px"></i>
                                                    <?php //} else if($shopData["ShopStatus"] == "Pending") { ?>
                                                        <b style="color:#ff8c00;"> <?php //echo "Pending"; ?> </b>
                                                        <i class="fa fa-exclamation-circle" style="color:#ff8c00;font-size:22px"></i> 
                                                    <?php //} else if($shopData["ShopStatus"] == "In-Review") { ?>  
                                                        <b style="color:grey;"> <?php //echo "In-Review"; ?> </b>
                                                        <i class="fa fa-check-circle" style="color:grey;font-size:22px"></i> 
                                                    <?php //} else if($shopData["ShopStatus"] == "Rejected"){ ?>
                                                        <b style="color:red;"> <?php //echo "Rejected"; ?> </b>
                                                        <i class="fa fa-check-circle" style="color:Red;font-size:22px"></i>
                                                    <?php //} else { ?>
                                                        <b style="color:#ff8c00;"> <?php //echo "Pending";?> </b>
                                                        <i class="fa fa-exclamation-circle" style="color:#ff8c00;font-size:22px"></i> 
                                                    <?php// } ?>
                                                </h6> -->
                                            </small>
                                           <div class="employee-task-chart-primary-1">
                                                <?php $shop_Cd=$shopData["Shop_Cd"]; ?>
                                                <button type="button" class="btn btn-<?php if($shopData["QC_Flag"]==1 && $qcType=='ShopList'){ echo "success"; }else if($shopData["QC_Flag"]==0 && $qcType=='ShopList'){ echo "danger"; }else if($shopData["QC_Flag"]==2 && $qcType=='ShopSurvey'){ echo "success"; }else if($shopData["QC_Flag"]!=2 && $qcType=='ShopSurvey'){ echo "danger"; }else if($shopData["QC_Flag"]==3 && $qcType=='ShopDocument'){ echo "success"; }else if($shopData["QC_Flag"]!=3 && $qcType=='ShopDocument'){ echo "danger"; }else if($shopData["QC_Flag"]==4 && $qcType=='ShopCalling'){ echo "success"; }else if($shopData["QC_Flag"]!=4 && $qcType=='ShopCalling'){ echo "danger"; } ?>" 
                                                    <?php if($qcType=='ShopCalling'){ ?>   
                                                        onclick="setShopCallingQCForm(<?php echo $shopData["ScheduleCall_Cd"]; ?>,<?php echo $shopData["Calling_Cd"]; ?>, <?php echo $shop_Cd; ?>,'<?php echo $qcType; ?>',<?php echo $srno; ?>)"
                                                    <?php }else if($qcType=='ShopSurvey' || $qcType=='ShopDocument'){  ?> 
                                                        onclick="setShopSurveyAndDocumentQCForm(<?php echo $shopData["ScheduleCall_Cd"]; ?>,<?php echo $shop_Cd; ?>,'<?php echo $qcType; ?>',<?php echo $srno; ?>)"
                                                    <?php }else{ ?> 
                                                        onclick="setShopListQCForm(<?php echo $shop_Cd; ?>,'<?php echo $qcType; ?>',<?php echo $srno; ?>)"
                                                    <?php } ?>
                                                    

                                                    >QC</button>
                                           </div>
                                        </div>


                                    </div> 

                                        
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>

    </div>
 <?php } ?>

    <div class="col-xl-8 col-md-8 col-xs-12" id="setShopQCLoaderId" style="display: none;">
        <img src="../app-assets/images/loader/loading.gif" width="100" height="100">
    </div>

    <div class="col-xl-8 col-md-8 col-xs-12" id="setShopQCFormDataId">

    </div>

