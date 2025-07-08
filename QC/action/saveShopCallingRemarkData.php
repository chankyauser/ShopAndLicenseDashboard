<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $updatedByUser = $userName;
    
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if(
        // (isset($_POST['electionName']) && !empty($_POST['electionName'])) && 
        (isset($_POST['shopid']) && !empty($_POST['shopid'])) &&
         (isset($_POST['scheduleid']) && !empty($_POST['scheduleid'])) &&
         (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) &&
         (isset($_POST['stStageName']) && !empty($_POST['stStageName'])) &&
         (isset($_POST['remark1']) && !empty($_POST['remark1'])) 
      )
    {
    
        $UploadCallingRemarkInfoData = array();
        
        $Shop_Cd = $_POST['shopid'];
        $ScheduleCall_Cd = $_POST['scheduleid'];
        $ST_Exec_Cd = $_POST['executiveId'];
        $ST_StageName = $_POST['stStageName'];
        $ST_Remark1 = $_POST['remark1'];
        $ST_Remark2 = $_POST['remark2'];
        $ST_Remark3 = $_POST['remark3'];

    
        $sql1 = "SELECT top (1) Shop_Cd, ST_Status FROM ShopTracking
                    WHERE Shop_Cd = $Shop_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND ST_Status = 1; ";
        $db1=new DbOperation();
        $isShopScheduleCompletedExists = $db1->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            if( sizeof($isShopScheduleCompletedExists) > 0 ){

           
                $dbsql12=new DbOperation();
                $sql2 = "UPDATE ShopTracking SET
                            ST_StageName = N'$ST_StageName',
                            ST_DateTime = GETDATE(),
                            ST_Exec_Cd = $ST_Exec_Cd,
                            ST_Remark_1 = N'$ST_Remark1',
                            ST_Remark_2 = N'$ST_Remark2',
                            ST_Remark_3 = N'$ST_Remark3',
                            UpdatedByUser = N'$updatedByUser',
                            UpdatedDate = GETDATE()
                        WHERE Shop_Cd = $Shop_Cd AND ScheduleCall_Cd = $ScheduleCall_Cd AND ST_Status = 1;";
                
                $executeSql2 = $dbsql12->RunQueryData($sql2, $electionName, $developmentMode);

                if($executeSql2){
                    $UploadCallingRemarkInfoData = array('Flag' => 'U' );
                }

                if (sizeof($UploadCallingRemarkInfoData) > 0) {

                    $flag = $UploadCallingRemarkInfoData['Flag'];

                    if($flag == 'U') {
                        echo json_encode(array('error' => false, 'message' => 'Calling Remark Updated successfully!'));
                    } else if($flag == 'I'){
                        echo json_encode(array('error' => false, 'message' => 'Calling Remark Insert successfully!'));
                    } 
                }else{
                    echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
                }

            }
            else
            {
                echo json_encode(array('error' => true, 'message' => 'Error!! Please Save Calling Entry from Mobile Application!'));
            }
    }
}   
    

?>
