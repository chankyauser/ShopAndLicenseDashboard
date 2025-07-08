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
                            FROM CallingCategoryMaster WHERE Calling_Type = '$callingType' AND QC_Type = 'ShopSurvey')
                        AND (
                            --ISNULL(sm.ShopStatus,'') = '' OR 
                            sm.ShopStatus in (SELECT ApplicationStatus as ShopStatus FROM StatusMaster WHERE ISNULL(Remark,'') <> 'ShopAccess' AND IsActive = 1) 
                        )
                        AND sm.SurveyDate IS NOT NULL
                        AND ( 
                                (sm.ShopKeeperMobile IS NULL OR LEFT(sm.ShopKeeperMobile, 1) NOT IN (6,7,8,9) OR LEN(sm.ShopKeeperMobile) != 10 )
                                OR 
                                ( sm.ShopOutsideImage1 IS NULL AND sm.ShopOutsideImage2 IS NULL ) 
                                OR 
                                ( ISNULL(sm.ShopKeeperName,'') = '' )  
                            )
                        AND sd.CallReason = '2nd Premise Visit' 
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
                      

                        // echo $query1;

                      $db2=new DbOperation();
                      $updateAssign = $db2->RunQueryData($query1, $electionName, $developmentMode);

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
?>