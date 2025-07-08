<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shaFilterType']) && !empty($_GET['shaFilterType']) ){

    try  
        {  
            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode']; 

            if(isset($_SESSION['SAL_Node_Name'])){
                $nodeName = $_SESSION['SAL_Node_Name'];
            }else{
                $nodeName = "All";
            }
            
            if(isset($_SESSION['SAL_Node_Cd'])){
                $nodeCd = $_SESSION['SAL_Node_Cd'];
            }else{
                $nodeCd = "All";
            }
            
            if(isset($_SESSION['SAL_Calling_Category_Cd'])){
                $callingCategoryCd = $_SESSION['SAL_Calling_Category_Cd'];
            }

            if($nodeName == 'All'){
                $nodeNameCondition = " AND nm.NodeName <> '' ";
            }else{
                $nodeNameCondition = " AND nm.NodeName = '$nodeName' ";
            }

            if($nodeCd == 'All'){
                $nodeWardCondition = " AND pm.Node_Cd <> '' ";
            }else{
                $nodeWardCondition = " AND pm.Node_Cd = $nodeCd ";
            }

            $dbConn = $db->getSALDBConnectByElectionName($electionName, $developmentMode);
            if(!$dbConn["error"]){
                $conn = $dbConn["conn"]; 

                $_SESSION['SAL_ShopAssign_Filter_Type'] = $_GET['shaFilterType'];
                $_SESSION['SAL_Calling_Type'] = $_GET['calling_Type'];
                $assign_date = $_GET['assign_date'];
                
                $shopAssignFilterType = $_SESSION['SAL_ShopAssign_Filter_Type'];
                $callingType = $_SESSION['SAL_Calling_Type'];

                $updatedByUser = $userName;
                $userId = $_SESSION['SAL_UserId'];
                $executiveCd = 0;
                if($userId != 0){
                    $db1=new DbOperation();
                    $userData = $db1->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
                    if(sizeof($userData)>0){
                        $executiveCd = $userData["Executive_Cd"];
                    }
                }else{
                    session_unset();
                    session_destroy();
                    header('Location:index.php?p=login');
                }

                if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){
                    if($callingType=="Survey"){

                         // in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                          
                        $selectShopQuery="
                              
                                SELECT 
                                --top 1
                                    t.Shop_Cd
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate, sm.SurveyBy
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    --WHERE sm.surveyby ='AMIRODDIN_S'
                                    WHERE sm.surveyby ='BHUSHAN_P16'
                                    AND MONTH(SurveyDate) = 12
                                    AND sm.IsActive = 1
                                    AND ( 
                                        ISNULL(sm.ShopStatus,'') = '' OR 
                                        sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey')
                                    
                                    --AND t.surveyby ='AMIRODDIN_S'
                                    AND t.surveyby ='BHUSHAN_P16'
                                    AND MONTH(t.SurveyDate) = 12
                                    AND t.IsActive = 1 
                                    AND ( 
                                         ISNULL(t.ShopStatus,'') = '' OR 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )

                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL 
                                $nodeNameCondition
                                $nodeWardCondition
                                ORDER By t.Shop_Cd
                            ";

                        $scheduleShops = $db->ExecutveQueryMultipleRowSALData($selectShopQuery, $electionName, $developmentMode);
                        
                        foreach ($scheduleShops as $key => $value) {
                            $shopCd = $value["Shop_Cd"];
                            $Insertquery1 = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ($shopCd, ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey'), $executiveCd, GETDATE(), '2nd Premise Visit', null, 1, GETDATE(), '$updatedByUser')";
                            $result1 = sqlsrv_query($conn, $Insertquery1);

                            $Insertquery2 = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ($shopCd, ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument'), $executiveCd, GETDATE(), 'Re-Collect Shop Documents', null, 1, GETDATE(), '$updatedByUser')";
                            $result2 = sqlsrv_query($conn, $Insertquery2);

                            $updateShopStatusNull = "UPDATE ShopMaster set ShopStatus = null WHERE Shop_Cd = $shopCd";
                            $result3 = sqlsrv_query($conn, $updateShopStatusNull);
                        }
                                              
                    }
                }else if($shopAssignFilterType=="InvalidMobilePhoto"){
                    if($callingType=="Survey"){

                        $Insertquery="
                                INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser)
                                SELECT 
                                top 500
                                    t.Shop_Cd, t.SD_Calling_Category_Cd, $executiveCd as Executive_Cd,GETDATE() as ScheduleDate, t.CallReason as ScheduleReason, 
                                    COALESCE(CASE WHEN (LEN(t.Remark1)=0  AND LEN(t.Remark2)=0 AND LEN(t.Remark3)<>0) THEN  t.Remark3  END,
                                    CASE WHEN (LEN(t.Remark1)=0  AND LEN(t.Remark2)<>0 AND LEN(t.Remark3)=0) THEN  t.Remark2  END,
                                    CASE WHEN (LEN(t.Remark1)<>0  AND LEN(t.Remark2)=0 AND LEN(t.Remark3)=0) THEN  t.Remark1  END,
                                    CASE WHEN LEN(t.Remark1)=0  AND LEN(t.Remark2)<>0 AND LEN(t.Remark3)<>0 THEN  t.Remark2+', '+t.Remark3 END,
                                    CASE WHEN LEN(t.Remark1)<>0  AND LEN(t.Remark2)<>0 AND LEN(t.Remark3)=0 THEN  t.Remark1+', '+t.Remark2  END,
                                    CASE WHEN LEN(t.Remark1)<>0  AND LEN(t.Remark2)=0 AND LEN(t.Remark3)<>0 THEN  t.Remark1+', '+t.Remark3 END,
                                    CASE WHEN LEN(t.Remark1)<>0  AND LEN(t.Remark2)<>0 AND LEN(t.Remark3)<>0 THEN  t.Remark1+', '+t.Remark2+', '+t.Remark3 ELSE '' END,
                                    '') as Remark, 1 as IsActive, GETDATE() as UpdatedDate,
                                    '$updatedByUser' as UpdatedByUser
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey') As SD_Calling_Category_Cd, '2nd Premise Visit' as CallReason,
                                        (CASE WHEN (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 ) then 'Enter Mobile Number' else '' end) as Remark1, 
                                        --CASE WHEN ( ISNULL(sm.ShopKeeperName,'') = '' ) then 'Enter Shop Keeper Name' else '' end as Remark2,
                                        COALESCE(CASE WHEN ( ISNULL(sm.ShopKeeperName,'') = '' AND ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )  ) then 'Enter Shop Keeper Name And Address' WHEN ( ISNULL(sm.ShopKeeperName,'') = '' ) THEN 'Enter Shop Keeper Name' WHEN ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' ) THEN 'Enter Shop Address' ELSE '' END,'') as Remark2,
                                        CASE WHEN ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) then 'Upload Shop Outside Photo' else '' end as Remark3,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    WHERE sm.IsActive = 1 
                                    AND ( 
                                        --ISNULL(sm.ShopStatus,'') = '' OR 

                                            sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                        ) 
                                    AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date' 
                                    AND ( 
                                        (sm.ShopKeeperMobile IS NULL OR ISNULL(sm.ShopKeeperMobile,'') = '' OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                        OR 
                                        ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL )  
                                        OR 
                                        ( ISNULL(sm.ShopKeeperName,'') = '' )  
                                        OR 
                                        ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )
                                    )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey')
                                    AND ( 
                                         --ISNULL(t.ShopStatus,'') = '' OR 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                    AND sd.CallReason in ( '2nd Premise Visit' )
                                    AND t.IsActive = 1
                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL
                                $nodeNameCondition
                                $nodeWardCondition 
                                ORDER By t.Shop_Cd
                            ";

                        $result2 = sqlsrv_query($conn, $Insertquery);


                        $InsertqueryDocumentPending="
                                INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser)
                                SELECT 
                                top 500
                                    t.Shop_Cd, t.SD_Calling_Category_Cd, $executiveCd as Executive_Cd,GETDATE() as ScheduleDate, t.CallReason as ScheduleReason, 
                                    t.Remark as Remark, 1 as IsActive, GETDATE() as UpdatedDate,
                                    '$updatedByUser' as UpdatedByUser
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument') As SD_Calling_Category_Cd, 'Re-Collect Shop Documents' as CallReason, 'Documents are pending' as Remark,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    WHERE sm.IsActive = 1 
                                    AND ( 
                                        --ISNULL(sm.ShopStatus,'') = '' OR 

                                            sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                        ) 
                                    AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date' 
                                    AND ( 
                                        (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                        OR 
                                        ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL )  
                                        OR 
                                        ( ISNULL(sm.ShopKeeperName,'') = '' )  
                                        OR 
                                        ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )
                                    )
                                    AND ( sm.ShopStatus <> 'Verified' OR (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0 )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument')
                                    AND ( 
                                         --ISNULL(t.ShopStatus,'') = '' OR 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                    AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                    AND t.IsActive = 1
                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL AND ( t.ShopStatus <> 'Verified' OR (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = t.Shop_Cd AND IsActive = 1 ) = 0 )
                                $nodeNameCondition
                                $nodeWardCondition
                                ORDER By t.Shop_Cd
                            ";

                        $result2DocPending = sqlsrv_query($conn, $InsertqueryDocumentPending);

                    }
                }else if($shopAssignFilterType=="NoDocument"){
                    if($callingType=="Survey"){

                        $InsertqueryDocumentPending="
                                INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser)
                                SELECT 
                                    TOP 500
                                    t.Shop_Cd, t.SD_Calling_Category_Cd, $executiveCd as Executive_Cd,GETDATE() as ScheduleDate, t.CallReason as ScheduleReason, 
                                    t.Remark as Remark, 1 as IsActive, GETDATE() as UpdatedDate,
                                    '$updatedByUser' as UpdatedByUser
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument') As SD_Calling_Category_Cd, 'Re-Collect Shop Documents' as CallReason, 'Documents are pending' as Remark,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    WHERE sm.IsActive = 1 
                                    AND ( 
                                         ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0 
                                        ) 
                                    AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date' 
                                    AND ( 
                                        (ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                        AND 
                                        ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                        AND 
                                        ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                         AND 
                                        ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                        AND 
                                        ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                        --OR 
                                        --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)  
                                    )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument')
                                    AND ( 
                                         --ISNULL(t.ShopStatus,'') = '' OR 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                    AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                    AND t.IsActive = 1
                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL 
                                $nodeNameCondition
                                $nodeWardCondition
                                ORDER By t.Shop_Cd
                            ";

                        $result2DocPending = sqlsrv_query($conn, $InsertqueryDocumentPending);

                    }
                }else if($shopAssignFilterType=="QCDocumentPending"){
                    if($callingType=="Survey"){

                        $InsertqueryDocumentPending="
                                INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser)
                                SELECT 
                                    TOP 500
                                    t.Shop_Cd, t.SD_Calling_Category_Cd, $executiveCd as Executive_Cd,GETDATE() as ScheduleDate, t.CallReason as ScheduleReason, 
                                    t.Remark as Remark, 1 as IsActive, GETDATE() as UpdatedDate,
                                    '$updatedByUser' as UpdatedByUser
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument') As SD_Calling_Category_Cd, 'Re-Collect Shop Documents' as CallReason, 'Documents are pending' as Remark,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    WHERE sm.IsActive = 1 
                                    AND ( 
                                        ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
                                        ) 
                                    AND sm.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,sm.SurveyDate,23) < '$assign_date' 
                                    AND ( 
                                        (ISNULL(sm.ShopKeeperMobile,'') <> '' AND sm.ShopKeeperMobile IS NOT NULL AND LEFT(sm.ShopKeeperMobile, 1) IN (6,7,8,9) AND LEN(sm.ShopKeeperMobile) = 10 )
                                        AND 
                                        ( sm.ShopOutsideImage1 IS NOT NULL  )  
                                        AND 
                                        ( ISNULL(sm.ShopKeeperName,'') <> '' AND ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  )  
                                         AND 
                                        ( ISNULL(sm.ShopName,'') <> '' AND ISNULL(sm.ShopCategory,'') <> ''  AND ISNULL(sm.BusinessCat_Cd,0) <> 0  AND ISNULL(sm.ShopArea_Cd,0) <> 0 )  
                                        AND 
                                        ( ISNULL(sm.ShopAddress_1,'') <> '' AND ISNULL(sm.ShopAddress_2,'') <> '' )  
                                        --OR 
                                        --( ISNULL(sm.MaleEmp,0) = 0 OR ISNULL(sm.FemaleEmp,0) = 0 OR ISNULL(sm.OtherEmp,0) = 0)  
                                    )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument')
                                    AND ( 
                                         --ISNULL(t.ShopStatus,'') = '' OR 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND t.SurveyDate IS NOT NULL AND CONVERT(VARCHAR,t.SurveyDate,23) < '$assign_date' 
                                    AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                    AND t.IsActive = 1
                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL 
                                $nodeNameCondition
                                $nodeWardCondition
                                ORDER By t.Shop_Cd
                            ";

                        $result2DocPending = sqlsrv_query($conn, $InsertqueryDocumentPending);



                    }
                }else if($shopAssignFilterType=="DocumentsDenied"){
                    if($callingType=="Survey"){

                          
                        $selectShopQuery="
                              
                                SELECT 
                                top 500
                                    t.Shop_Cd
                                FROM(
                                    SELECT
                                        sm.Shop_Cd,
                                        sm.ShopOutsideImage1,sm.ShopOutsideImage2,sm.ShopKeeperMobile,sm.ShopKeeperName,sm.IsActive, sm.Pocket_Cd,sm.ShopName,sm.ShopStatus,sm.SurveyDate, sm.SurveyBy
                                    FROM ShopMaster sm 
                                    INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                                    INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                    WHERE sm.IsActive = 1
                                    AND (  
                                        sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                                    )
                                    $nodeNameCondition
                                    $nodeWardCondition
                                --ORDER BY sm.SurveyDate 
                                ) as t
                                LEFT JOIN ScheduleDetails sd on (
                                    t.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assign_date' 
                                    AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                        FROM CallingCategoryMaster WHERE Calling_Type = 'Survey')
                                    AND t.IsActive = 1 
                                    AND ( 
                                        t.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                                    )
                                    AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                                )
                                INNER JOIN PocketMaster pm on (pm.Pocket_Cd = t.Pocket_Cd)
                                INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                                LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                                WHERE sd.ScheduleCall_Cd IS NULL 
                                $nodeNameCondition
                                $nodeWardCondition
                                ORDER By t.Shop_Cd
                            ";

                        $scheduleShops = $db->ExecutveQueryMultipleRowSALData($selectShopQuery, $electionName, $developmentMode);
                        
                        foreach ($scheduleShops as $key => $value) {
                            $shopCd = $value["Shop_Cd"];
                            $Insertquery1 = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ($shopCd, ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopSurvey'), $executiveCd, GETDATE(), '2nd Premise Visit', null, 1, GETDATE(), '$updatedByUser')";
                            $result1 = sqlsrv_query($conn, $Insertquery1);

                            $Insertquery2 = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd,CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser) VALUES ($shopCd, ( SELECT Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Survey' AND QC_Type = 'ShopDocument'), $executiveCd, GETDATE(), 'Re-Collect Shop Documents', null, 1, GETDATE(), '$updatedByUser')";
                            $result2 = sqlsrv_query($conn, $Insertquery2);

                            // $updateShopStatusNull = "UPDATE ShopMaster set ShopStatus = null WHERE Shop_Cd = $shopCd";
                            // $result3 = sqlsrv_query($conn, $updateShopStatusNull);
                        }
                                              
                    }
                }

            }

        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }

  }else{
    //echo "ddd";
  }

}
?>

