<?php 
session_start();
include '../../api/includes/DbOperation.php'; 
  
  $db=new DbOperation();
  $userName=$_SESSION['SAL_UserName'];
  $appName=$_SESSION['SAL_AppName'];
  $electionName=$_SESSION['SAL_ElectionName'];
  $developmentMode=$_SESSION['SAL_DevelopmentMode'];  


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    
    if(
            (isset($_POST['electionName']) && !empty($_POST['electionName'])) && 
            (isset($_POST['executiveCd']) && !empty($_POST['executiveCd'])) &&
            (isset($_POST['assignDate']) && !empty($_POST['assignDate'])) &&
            (isset($_POST['shopAssignFilterType']) && !empty($_POST['shopAssignFilterType'])) &&
            (isset($_POST['calling_Type']) && !empty($_POST['calling_Type'])) &&
            (isset($_POST['shopsAssignCount']) && !empty($_POST['shopsAssignCount'])) &&
            (isset($_POST['multiplePockets']) && !empty($_POST['multiplePockets'])) 
    )
    {
            $electionName = $_POST['electionName'];
            $executiveCd = $_POST['executiveCd'];
            $assignDate = $_POST['assignDate'];
            $shopAssignFilterType = $_POST['shopAssignFilterType'];
            $callingType = $_POST['calling_Type'];
            $shopsAssignCount = $_POST['shopsAssignCount'];
            $multiplePockets = $_POST['multiplePockets'];
            $multipleShopSchedules = 0;

            if($shopAssignFilterType == 'NoticeDistribution'){
                $Calling_Category_Cd = '';
                $CallReason = '';
                if(isset($_POST['calling_Category']) && !empty($_POST['calling_Category'])){
                    $Calling_Category_Cd = $_POST['calling_Category'];
                    $query = "SELECT CallReason FROM CallingCategoryMaster WHERE Calling_Category_Cd = '$Calling_Category_Cd'";
                    $Result = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                    $CallReason = $Result['CallReason'];
                }
                
                $ShopCdList = explode(',', $multiplePockets);

                foreach($ShopCdList as $shopCd){
                    $shopCd = trim($shopCd);
                    $Tracking = array();
                    
                    $IsExists = "SELECT ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd, Executive_Cd, CallingDate, CallReason FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND  Calling_Category_Cd = $Calling_Category_Cd AND CallReason = '$CallReason'";
                    $ISExitsRes = $db->ExecutveQuerySingleRowSALData($IsExists, $electionName, $developmentMode);

                    if(!empty($ISExitsRes)){
                        $ScheduleCall_Cd = $ISExitsRes['ScheduleCall_Cd'];
                        $query = "UPDATE ScheduleDetails SET Executive_Cd = $executiveCd, CallingDate = GETDATE(), CallReason = '$CallReason', UpdatedByUser = '$userName', UpdatedDate = GETDATE() WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $Calling_Category_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd";
                        $Schedule = $db->RunQueryData($query, $electionName, $developmentMode);

                        if($Schedule){
                            $TrackingQuery = "SELECT ST_Cd FROM ShopTracking WHERE Shop_Cd = $shopCd AND ScheduleCall_Cd = $ScheduleCall_Cd AND Calling_Category_Cd = $Calling_Category_Cd";
                            $TrackingRes = $db->ExecutveQuerySingleRowSALData($TrackingQuery, $electionName, $developmentMode);

                            $StageQuery = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'StageName' AND SerialNo = 19";
                            $StageRes = $db->ExecutveQuerySingleRowSALData($StageQuery, $electionName, $developmentMode);
                            
                            if($StageRes){

                                $StageName = $StageRes['DValue'];

                                if($TrackingRes){
                                    $ST_Cd = $TrackingRes['ST_Cd'];
                                    $query = "UPDATE ShopTracking SET ST_StageName = '$StageName', ST_DateTime = GETDATE(), ST_Exec_Cd = $executiveCd, ST_Status = 1,AssignDate = '$assignDate', UpdatedByUser = '$userName', UpdatedDate = GETDATE(), AssignExec_Cd =  $executiveCd, AssignTempExec_Cd = $executiveCd WHERE ST_Cd = $ST_Cd";
                                    // echo $query; exit;
                                    $Tracking = $db->RunQueryData($query, $electionName, $developmentMode);
                                }else{
                                    $query = "INSERT INTO ShopTracking (Shop_Cd, ScheduleCall_Cd,Calling_Category_Cd, AssignDate, AssignExec_Cd, AssignTempExec_Cd, ST_StageName, ST_DateTime, ST_Exec_Cd, ST_Status, UpdatedByUser, UpdatedDate) VALUES ($shopCd, $ScheduleCall_Cd, $Calling_Category_Cd, '$assignDate',$executiveCd,$executiveCd,'$StageName', GETDATE(), $executiveCd, 1, '$userName', GETDATE())";
                                    $Tracking = $db->RunQueryData($query, $electionName, $developmentMode);
                                }
                            }

                        }
                    }else{
                        $query = "INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd, CallingDate, CallReason, IsActive, UpdatedDate, UpdatedByUser) VALUES($shopCd, $Calling_Category_Cd, $executiveCd, '$assignDate', '$CallReason', 1, GETDATE(), '$userName')";
                        $Schedule = $db->RunQueryData($query, $electionName, $developmentMode);

                        if(!empty($Schedule)){
                            $MaxCdQuery = "SELECT MAX(ScheduleCall_Cd) as ScheduleCall_Cd FROM ScheduleDetails";
                            $MaxCdRes = $db->ExecutveQuerySingleRowSALData($MaxCdQuery, $electionName, $developmentMode);
                            $MaxCd = $MaxCdRes['ScheduleCall_Cd'];
                            $ScheduleCall_Cd = $MaxCd + 1;

                            $StageQuery = "SELECT DValue FROM DropDownMaster WHERE DTitle = 'StageName' AND SerialNo = 19";
                            $StageRes = $db->ExecutveQuerySingleRowSALData($StageQuery, $electionName, $developmentMode);
                            if($StageRes){
                                $StageName = $StageRes['DValue'];
                                $query = "INSERT INTO ShopTracking (Shop_Cd, ScheduleCall_Cd,Calling_Category_Cd, AssignDate, AssignExec_Cd, AssignTempExec_Cd, ST_StageName, ST_DateTime, ST_Exec_Cd, ST_Status, UpdatedByUser, UpdatedDate) VALUES ($shopCd, $ScheduleCall_Cd, $Calling_Category_Cd, '$assignDate',$executiveCd,$executiveCd,'$StageName', GETDATE(), $executiveCd, 1, '$userName', GETDATE())";
                                $Tracking = $db->RunQueryData($query, $electionName, $developmentMode);
                            }
                        }
                    }

                    if($Tracking){
                           echo json_encode(array('statusCode' => 200, 'msg' => " Shops Assigned for $callingType!")); 
                    }else{
                        echo json_encode(array('statusCode' => 500, 'msg' => "Something Went Wrong!"));
                    } 
                }
                exit;
            }else {
                $query="";
                if(isset($_POST['multipleShopSchedules'])){
                    $multipleShopSchedules = $_POST['multipleShopSchedules'];
                    $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                                AND sm.IsActive = 1
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            AND sd.ScheduleCall_Cd in ($multipleShopSchedules)
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd
                            ";
                }else{
                    if($shopAssignFilterType=="New"){
                        $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                        FROM ScheduleDetails sd
                        INNER JOIN ShopMaster sm on (
                            sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                            AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                            AND ( ISNULL(sm.ShopStatus,'') = '' OR sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) )
                            AND sm.IsActive = 1
                        )
                        INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                        INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                        LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                        WHERE st.ScheduleCall_Cd IS NULL
                        AND sm.Pocket_Cd in ($multiplePockets) 
                        GROUP BY sd.Shop_Cd
                        ORDER BY sd.Shop_Cd";   
                    }else if($shopAssignFilterType=="SurveyShopReVisitUsingQuery"){
                        if($callingType=="Survey"){
                            $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                --AND sm.surveyby ='AMIRODDIN_S'
                                AND sm.surveyby ='BHUSHAN_P16'
                                AND MONTH(sm.SurveyDate) = 12
                                AND sm.IsActive = 1 
                                AND ( 
                                    ISNULL(sm.ShopStatus,'') = '' OR 
                                    sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                )
                                AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd";    
                        }
                    }else if($shopAssignFilterType=="InvalidMobilePhoto"){
                        if($callingType=="Survey"){
                            $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND (
                                    --ISNULL(sm.ShopStatus,'') = '' OR 
                                    sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                                )
                                AND sm.SurveyDate IS NOT NULL
                                AND ( 
                                        (sm.ShopKeeperMobile IS NULL OR ISNULL(sm.ShopKeeperMobile,'') = '' OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                        OR 
                                        ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) 
                                        OR 
                                        ( ISNULL(sm.ShopKeeperName,'') = '' )  
                                        OR 
                                        ( ISNULL(sm.ShopAddress_1,'') = '' OR ISNULL(sm.ShopAddress_2,'') = '' )
                                    )
                                AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                                AND sm.IsActive = 1
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd";    
                        }
                    }else if($shopAssignFilterType=="NoDocument"){
                        if($callingType=="Survey"){
                            $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND (
                                    ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) = 0  
                                )
                                AND sm.SurveyDate IS NOT NULL
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
                                AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                AND sm.IsActive = 1
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd";    
                        }
                    }else if($shopAssignFilterType=="QCDocumentPending"){
                        if($callingType=="Survey"){
                            $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND (
                                    ISNULL(sm.ShopStatus,'') <> 'Verified' AND sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND ApplicationStatus <> 'Verified' AND IsActive = 1) AND (SELECT COUNT(Shop_Cd) FROM ShopDocuments WHERE Shop_Cd = sm.Shop_Cd AND IsActive = 1 ) <> 0 
                                )
                                AND sm.SurveyDate IS NOT NULL
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
                                AND sd.CallReason in ( 'Re-Collect Shop Documents' )
                                AND sm.IsActive = 1
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd";    
                        }
                    }else if($shopAssignFilterType=="DocumentsDenied"){
                        if($callingType=="Survey"){
                            $query = "SELECT top ($shopsAssignCount)
                                sd.Shop_Cd, STRING_AGG(sd.ScheduleCall_Cd,',') as ScheduleCall_Cds
                            FROM ScheduleDetails sd
                            INNER JOIN ShopMaster sm on (
                                sm.Shop_Cd = sd.Shop_Cd AND CONVERT(VARCHAR,sd.CallingDate,23) <= '$assignDate' 
                                AND sd.Calling_Category_Cd in ( SELECT Calling_Category_Cd 
                                    FROM CallingCategoryMaster WHERE Calling_Type = '$callingType')
                                AND sm.IsActive = 1 
                                AND ( 
                                    sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) 
                                )
                                AND sd.CallReason in ( '2nd Premise Visit' , 'Re-Collect Shop Documents' )
                            )
                            INNER JOIN PocketMaster pm on (pm.Pocket_Cd = sm.Pocket_Cd)
                            INNER JOIN NodeMaster nm on (nm.Node_Cd = pm.Node_Cd)
                            LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd
                            WHERE st.ScheduleCall_Cd IS NULL
                            AND sm.Pocket_Cd in ($multiplePockets) 
                            GROUP BY sd.Shop_Cd
                            ORDER BY sd.Shop_Cd";    
                        }
                    }
        
                }

            
                
                if(!empty($query)){
                    
                    // echo $query;
                    $assignScheduleShops = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

                    foreach ($assignScheduleShops as $key => $valueAssignShops) {
                        $shopCd = $valueAssignShops["Shop_Cd"];
                        $scheduleCallCds = $valueAssignShops["ScheduleCall_Cds"];

                        $querySD =  "SELECT
                            ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd
                        FROM ScheduleDetails WHERE ScheduleCall_Cd in ($scheduleCallCds) AND Shop_Cd = $shopCd;";

                        $assignScheduleCalls = $db->ExecutveQueryMultipleRowSALData($querySD, $electionName, $developmentMode);

                        foreach ($assignScheduleCalls as $key => $valueAssignCalls) {

                            $scheduleCallCd = $valueAssignCalls["ScheduleCall_Cd"];
                            $shopCd = $valueAssignCalls["Shop_Cd"];
                            $callingCategoryCd = $valueAssignCalls["Calling_Category_Cd"];
                            
                            if($callingType == 'Survey'){
                                $query1 = "UPDATE ShopMaster SET Calling_Category_Cd = $callingCategoryCd, SRExecutive_Cd = $executiveCd, SRAssignedDate = '$assignDate' , UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE Shop_Cd = $shopCd;";  
                            }else if($callingType == 'Calling'){
                                $query1 = "UPDATE ShopMaster SET Calling_Category_Cd = $callingCategoryCd, CCExecutive_Cd = $executiveCd, CCAssignedDate = '$assignDate' , UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE Shop_Cd = $shopCd;";
                            }else if($callingType == 'Collection'){
                                $query1 = "UPDATE ShopMaster SET Calling_Category_Cd = $callingCategoryCd, CPExecutive_Cd = $executiveCd, CPAssignedDate = '$assignDate' , UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE Shop_Cd = $shopCd;";
                            }
                            
                                $db2=new DbOperation();
                                $updateAssign = $db2->RunQueryData($query1, $electionName, $developmentMode);

                                // $query122="SELECT Shop_Cd FROM ShopMaster WHERE Shop_Cd = $shopCd AND ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') = 'ShopAccess' AND IsActive = 1) ";
                                // $docDeniedShops = $db->ExecutveQuerySingleRowSALData($query122, $electionName, $developmentMode);
                                // if(sizeof($docDeniedShops)>0) {
                                //     $updateShopDocDeniedStatus = "UPDATE ShopMaster set ShopStatus = null, ShopStatusDate = null WHERE Shop_Cd = $shopCd";
                                
                                //     $db22=new DbOperation();
                                //     $updateAssign = $db22->RunQueryData($updateShopDocDeniedStatus, $electionName, $developmentMode); 
                                // }

                                // echo $query1;


                                $query2 = "INSERT INTO ShopTracking ( ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd, AssignDate, AssignExec_Cd, AssignTempExec_Cd, UpdatedByUser, UpdatedDate) VALUES ( $scheduleCallCd, $shopCd, $callingCategoryCd, '$assignDate', $executiveCd, $executiveCd, '$userName', GETDATE());";

                        
                            $db3=new DbOperation();
                            $insertAssign = $db3->RunQueryData($query2, $electionName, $developmentMode);
                        }
                    } 

                    echo json_encode(array('statusCode' => 200, 'msg' => " Shops Assigned for $callingType!"));

                    $queryLogin = "SELECT top (1) User_Cd FROM LoginMaster WHERE Executive_Cd = $executiveCd";
                    $dbLogin=new DbOperation();
                    $loginUserData = $dbLogin->ExecutveQuerySingleRowSALData($queryLogin, $electionName, $developmentMode);

                    if(sizeof($loginUserData)>0){
                        $userId = $loginUserData["User_Cd"];
                        $dbUpdateElection=new DbOperation();
                        $queryUpdateElection="Update Survey_Entry_Data..User_Master SET ElectionName = '$electionName' WHERE User_Id = $userId AND Executive_Cd = $executiveCd ";
                        $updateUserElectionName = $dbUpdateElection->RunSEDQueryData($userName, $appName, $queryUpdateElection);
                    }
                    
                    
                    
                }
            }
 
    }
}
?>