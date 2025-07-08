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
         (isset($_POST['multipleShopTrackings']) && !empty($_POST['multipleShopTrackings']))
      )
    {
       

        $electionName = $_POST['electionName'];
        $executiveCd = $_POST['executiveCd'];
        $tempExecutiveCd = $_POST['tempExecutiveCd'];
        $assignDate = $_POST['assignDate'];
        $callingType = $_POST['callingType'];
        $multipleShopTrackings = $_POST['multipleShopTrackings'];
        $action = $_POST['action'];
     
        // echo $callingType;
        if($action=="edit"){
            $tempExecutiveCd = $executiveCd;
        }


            $query = "SELECT ST_Cd, ScheduleCall_Cd, Shop_Cd, Calling_Category_Cd FROM ShopTracking WHERE ST_Cd IN ($multipleShopTrackings); ";
// echo $query;
            $assignScheduleCalls = $db->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

            foreach ($assignScheduleCalls as $key => $valueAssignCalls) {
              $STCd = $valueAssignCalls["ST_Cd"];
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

              $query2 = "UPDATE ShopTracking SET AssignExec_Cd = $executiveCd, AssignTempExec_Cd = $tempExecutiveCd, AssignDate = '$assignDate', UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE ST_Cd = $STCd;";

              
              $db3=new DbOperation();
              $insertAssign = $db3->RunQueryData($query2, $electionName, $developmentMode);

            } 
            $msg = "";
            if($action=="edit"){
                $msg = ' Assigning Edited ';
            }else if($action=="transfer"){
                $msg = ' Transferred ';
            }
            echo json_encode(array('statusCode' => 200, 'msg' => " Shops $msg for $callingType!"));

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
?>