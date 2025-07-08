<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $updatedByUser = $userName;
    
    $action = '';
    $Shop_Cd = '';
    $scheduleDate = '';
    $reason = '';
    $ScheduleCategory_Cd = 0;
    $UpdateScheduleRescheduleData = array();
        
        $action = $_POST['action'];
        $Shop_Cd = $_POST['Shop_Cd'];
        $scheduleDate = $_POST['scheduleDate'];
        $ScheduleCategory_Cd = $_POST['reason'];
        $ExecutiveCd = $_POST['Executive_Id'];
        $remark = $_POST['remark'];

        $NewScheduleDate = date("Y-m-d H:i:s", strtotime($scheduleDate));
    
        $NewScheduleDate = $NewScheduleDate.".000";



    if($ScheduleCategory_Cd != 0 ){
        $querySel = "SELECT Calling_Category FROM CallingCategoryMaster WHERE Calling_Category_Cd = $ScheduleCategory_Cd AND IsActive = 1";
        $dataSelCat = $db->ExecutveQuerySingleRowSALData($querySel, $electionName, $developmentMode);
        $ScheduleCategory = $dataSelCat["Calling_Category"];
        $sql2  = " INSERT INTO ScheduleDetails (Shop_Cd, Calling_Category_Cd, Executive_Cd, CallingDate, CallReason, Remark, IsActive, UpdatedDate, UpdatedByUser) 
                    VALUES ($Shop_Cd, $ScheduleCategory_Cd, $ExecutiveCd, '$NewScheduleDate', '$ScheduleCategory', N'$remark', 1, GETDATE(), '$updatedByUser');";

        $executeSC3 = $db->RunQueryData($sql2, $electionName, $developmentMode);
        if($executeSC3){
            $UpdateScheduleRescheduleData = array('Flag' => 'U' );
        }

    }


    if (sizeof($UpdateScheduleRescheduleData) > 0) {

        $flag = $UpdateScheduleRescheduleData['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=Re-schedule");
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=Re-schedule");
        } 
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=Re-schedule");
    }

    // header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');

?>
