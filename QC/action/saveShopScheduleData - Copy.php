<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];  
    
    $updatedByUser = $userName;
    
    $updateSDDetail = array();

    if  (
            (isset($_POST['scheduleDate']) && !empty($_POST['scheduleDate'])) &&
            (isset($_POST['scheduleCategory']) && !empty($_POST['scheduleCategory'])) && 
            (isset($_POST['callReason']) && !empty($_POST['callReason'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $scheduleCallCd = $_POST['schedulecallid'];
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        $scheduleDate = $_POST['scheduleDate'];
        $scheduleDate = date("Y-m-d H:i:s", strtotime($scheduleDate));
        $scheduleCategory = $_POST['scheduleCategory'];
        $callReason = $_POST['callReason'];
        $remark = $_POST['remark'];

    
        $query = "SELECT top (1) Shop_Cd FROM ScheduleDetails WHERE ScheduleCall_Cd = $scheduleCallCd ;";
        $isShopSDExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopSDExists) > 0 )
        {
            

        }else{
            $dbSD=new DbOperation();

            $query = "SELECT top (1) Shop_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Executive_Cd = $executiveCd AND Calling_Category_Cd = $scheduleCategory AND CONVERT(VARCHAR,CallingDate,23) = CONVERT(VARCHAR,'$scheduleDate',23);";
            // echo $query;
            $isShopSDExists = $dbSD->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
            if( sizeof($isShopSDExists) > 0 )
            {
                $sqlSDDet = "UPDATE ScheduleDetails
                    SET 
                    CallingDate = '$scheduleDate',
                    CallReason = '$callReason',
                    Remark = '$remark',
                    UpdatedByUser = '$updatedByUser',
                    UpdatedDate = GETDATE()
                    WHERE Shop_Cd = $shopCd AND Executive_Cd = $executiveCd AND Calling_Category_Cd = $scheduleCategory AND CONVERT(VARCHAR,CallingDate,23) = CONVERT(VARCHAR,'$scheduleDate',23); ";
                    $updateSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                // echo $sqlSDDet;

                if($updateSDDet){
                    $updateSDDetail['Flag'] = 'U';
                }  
            }else{
                $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,$executiveCd,'$scheduleDate','$callReason','$remark',1,'$updatedByUser',GETDATE());";
                $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                // echo $sqlSDDet;

                if($insertSDDet){
                    $updateSDDetail['Flag'] = 'I';
                }  
            }
            
        }
      
    }else{
        // echo "dfd";
    }

    $queryTime = "SELECT CONVERT(VARCHAR,'$scheduleDate',100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);
    // echo $queryTime;
    if (sizeof($updateSDDetail) > 0) {

        $flag = $updateSDDetail['Flag'];
        if($flag == 'I') {
            echo json_encode(array('error' => false, 'message' => 'Shop Scheduled for '.$doneTimeData["QCDoneTime"].'!'));
        }else if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Scheduled for '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
