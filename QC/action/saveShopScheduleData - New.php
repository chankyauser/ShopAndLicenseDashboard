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
        $scheduleOnlyDate = date("Y-m-d", strtotime($scheduleDate));
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

            $query = "SELECT top (1) sd.ScheduleCall_Cd,sd.Shop_Cd,sd.Calling_Category_Cd,ISNULL(CONVERT(VARCHAR,sd.CallingDate,23),'') as CallingDate, ISNULL(st.ST_Cd,0) as ST_Cd,ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate, ISNULL(st.ST_Status,0) as ST_Status FROM ScheduleDetails sd LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd WHERE sd.Shop_Cd = $shopCd AND sd.Executive_Cd = $executiveCd AND sd.Calling_Category_Cd = $scheduleCategory AND CONVERT(VARCHAR,sd.CallingDate,23) = CONVERT(VARCHAR,'$scheduleDate',23);";
            // echo $query;
            $isShopSDExists = $dbSD->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
            if( sizeof($isShopSDExists) > 0 )
            {
                $CallingDate = $isShopSDExists["CallingDate"];
                $ST_Cd = $isShopSDExists["ST_Cd"];
                $AssignDate = $isShopSDExists["AssignDate"];
                $ST_Status = $isShopSDExists["ST_Status"];

                if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate <= $AssignDate && $ST_Status == 0 ){
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
                }else if($ST_Cd == 0 && empty($AssignDate) && $ST_Status == 0 ){
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
                }else if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate >= $AssignDate && $AssignDate >= date('Y-m-d') && $ST_Status == 0 ){
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
                }else if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate >= $AssignDate && $AssignDate < date('Y-m-d') && $ST_Status == 0 ){
                    $updateSDDetail['Flag'] = 'N';
                }else if($ST_Cd != 0 && !empty($AssignDate) && $ST_Status == 1 ){
                   $updateSDDetail['Flag'] = 'C'; 
                }
                  
            }else{
                $query = "SELECT sd.ScheduleCall_Cd,sd.Shop_Cd,sd.Calling_Category_Cd,ISNULL(CONVERT(VARCHAR,sd.CallingDate,23),'') as CallingDate, ISNULL(st.ST_Cd,0) as ST_Cd,ISNULL(CONVERT(VARCHAR,st.AssignDate,23),'') as AssignDate, ISNULL(st.ST_Status,0) as ST_Status FROM ScheduleDetails sd LEFT JOIN ShopTracking st on st.ScheduleCall_Cd = sd.ScheduleCall_Cd WHERE sd.Shop_Cd = $shopCd AND sd.Calling_Category_Cd = $scheduleCategory order by sd.CallingDate desc;";
                    // echo $query;
                $isShopSDExists = $dbSD->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                if( sizeof($isShopSDExists) > 0 )
                {
                    $ScheduleCall_Cd = $isShopSDExists["ScheduleCall_Cd"];
                    $CallingDate = $isShopSDExists["CallingDate"];
                    $ST_Cd = $isShopSDExists["ST_Cd"];
                    $AssignDate = $isShopSDExists["AssignDate"];
                    $ST_Status = $isShopSDExists["ST_Status"];

                    if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate <= $AssignDate && $ST_Status == 0 ){
                        $sqlSDDet = "UPDATE ScheduleDetails
                            SET 
                            Executive_Cd = $executiveCd,
                            CallingDate = '$scheduleDate',
                            CallReason = '$callReason',
                            Remark = '$remark',
                            UpdatedByUser = '$updatedByUser',
                            UpdatedDate = GETDATE()
                            WHERE Shop_Cd = $shopCd AND ScheduleCall_Cd = $ScheduleCall_Cd AND Calling_Category_Cd = $scheduleCategory; ";
                            $updateSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                        // echo $sqlSDDet;

                        if($updateSDDet){
                            $updateSDDetail['Flag'] = 'U';
                        }    
                    }else if($ST_Cd == 0 && empty($AssignDate) && $ST_Status == 0 ){
                        $sqlSDDet = "UPDATE ScheduleDetails
                            SET 
                            Executive_Cd = $executiveCd,
                            CallingDate = '$scheduleDate',
                            CallReason = '$callReason',
                            Remark = '$remark',
                            UpdatedByUser = '$updatedByUser',
                            UpdatedDate = GETDATE()
                            WHERE Shop_Cd = $shopCd AND ScheduleCall_Cd = $ScheduleCall_Cd AND Calling_Category_Cd = $scheduleCategory; ";
                            $updateSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                        // echo $sqlSDDet;

                        if($updateSDDet){
                            $updateSDDetail['Flag'] = 'U';
                        }    
                    }else if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate >= $AssignDate && $AssignDate >= date('Y-m-d') && $ST_Status == 0 ){
                        $sqlSDDet = "UPDATE ScheduleDetails
                            SET 
                            Executive_Cd = $executiveCd,
                            CallingDate = '$scheduleDate',
                            CallReason = '$callReason',
                            Remark = '$remark',
                            UpdatedByUser = '$updatedByUser',
                            UpdatedDate = GETDATE()
                            WHERE Shop_Cd = $shopCd AND ScheduleCall_Cd = $ScheduleCall_Cd AND Calling_Category_Cd = $scheduleCategory; ";
                            $updateSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                        // echo $sqlSDDet;

                        if($updateSDDet){
                            $updateSDDetail['Flag'] = 'U';
                        }
                    }else if($ST_Cd != 0 && !empty($AssignDate) && $CallingDate <= $AssignDate && $scheduleOnlyDate >= $AssignDate && $AssignDate < date('Y-m-d') && $ST_Status == 0 ){
                        $updateSDDetail['Flag'] = 'N';
                    }else if($ST_Cd != 0 && !empty($AssignDate) && $ST_Status == 1 ){
                        $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,$executiveCd,'$scheduleDate','$callReason','$remark',1,'$updatedByUser',GETDATE());";
                        $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                        // echo $sqlSDDet;

                        if($insertSDDet){
                            $updateSDDetail['Flag'] = 'I';
                        } 
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
        }else if($flag == 'N') {
            echo json_encode(array('error' => true, 'message' => 'Shop can not be Scheduled for '.$doneTimeData["QCDoneTime"].' as earlier schedule is not complete yet !'));
        }else if($flag == 'C') {
            echo json_encode(array('error' => true, 'message' => 'Shop can not be Scheduled for '.$doneTimeData["QCDoneTime"].' as schedule for same category is completed !'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
