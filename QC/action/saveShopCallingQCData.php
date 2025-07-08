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
    
    $updateQCDetail = array();

    if  (
           
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['callingid_s']) && !empty($_POST['callingid_s'])) 
        ) {

        
        $callingCd_s = $_POST['callingid_s'];

        $executiveCd = $_POST['executiveId'];
        $audioListen = $_POST['audioListen'];
        $goodCall = $_POST['goodCall'];
        $appreciationCall = $_POST['appreciationCall'];
    
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = "";
        $qcRemark2 = "";
        $qcRemark3 = "";

        if( strpos($callingCd_s, "_") !== false ) {
             $strArr = explode("_", $callingCd_s);
            foreach($strArr as $value){
                $callingCd = $value;
                $query = "SELECT top (1) Calling_Cd, Shop_Cd, ScheduleCall_Cd FROM CallingDetails WHERE Calling_Cd = $callingCd;";
                $isShopCallingExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                if( sizeof($isShopCallingExists) > 0 )
                {
                    $scheduleCallCd = $isShopCallingExists['ScheduleCall_Cd'];
                    $callingCd = $isShopCallingExists['Calling_Cd'];
                    $shopCd = $isShopCallingExists['Shop_Cd'];
                    saveCallingQC($userName, $appName, $electionName, $developmentMode, $scheduleCallCd, $callingCd, $shopCd, $executiveCd, $audioListen, $goodCall, $appreciationCall, $qcType, $qcFlag, $qcRemark1, $qcRemark2,$qcRemark3);
                }
            }
        }else{
            $callingCd = $callingCd_s;
            $query = "SELECT top (1) Calling_Cd, Shop_Cd, ScheduleCall_Cd FROM CallingDetails WHERE Calling_Cd = $callingCd;";
            $isShopCallingExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
            if( sizeof($isShopCallingExists) > 0 )
            {
                $scheduleCallCd = $isShopCallingExists['ScheduleCall_Cd'];
                $callingCd = $isShopCallingExists['Calling_Cd'];
                $shopCd = $isShopCallingExists['Shop_Cd'];

                saveCallingQC($userName, $appName, $electionName, $developmentMode, $scheduleCallCd, $callingCd, $shopCd, $executiveCd, $audioListen, $goodCall, $appreciationCall, $qcType, $qcFlag, $qcRemark1, $qcRemark2,$qcRemark3);
            }
        }
        
     
        
        
    
            
      
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Calling QC Done '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    function saveCallingQC($userName, $appName, $electionName, $developmentMode, $scheduleCallCd, $callingCd, $shopCd, $executiveCd, $audioListen, $goodCall, $appreciationCall, $qcType, $qcFlag, $qcRemark1, $qcRemark2,$qcRemark3){
        $updateQCDetail = array();

        $query = "SELECT top (1) Shop_Cd, AudioListen, GoodCall, Appreciation FROM CallingDetails WHERE Calling_Cd = $callingCd AND Shop_Cd = $shopCd AND ScheduleCall_Cd = $scheduleCallCd ;";
        $isShopCallingExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopCallingExists) > 0 )
        {
            
            $sql3 = "UPDATE CallingDetails
                 SET 
                    AudioListen = $audioListen,
                    GoodCall = $goodCall,
                    Appreciation = $appreciationCall,
                    QC_Flag = '$qcFlag',
                    QC_UpdatedByUser = '$userName',
                    QC_UpdatedDate = GETDATE()
                 WHERE Calling_Cd = $callingCd AND Shop_Cd = $shopCd AND ScheduleCall_Cd = $scheduleCallCd ;";
            $updateCallingQC = $db->RunQueryData($sql3, $electionName, $developmentMode);
            if($updateCallingQC){
                $updateQCDetail['Flag'] = 'U';

                $sql2 = "UPDATE ShopMaster
                     SET 
                        QC_Flag = '$qcFlag',
                        QC_UpdatedByUser = '$userName',
                        QC_UpdatedDate = GETDATE()
                     WHERE Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);

                $dbQC=new DbOperation();
            
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,$callingCd,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$userName',GETDATE(), $scheduleCallCd);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                if($isShopCallingExists["AudioListen"] != $audioListen){
                    $oldValue = $isShopCallingExists["AudioListen"] == '1' ? 'Yes' : 'No';
                    $newValue = $audioListen == '1' ? 'Yes' : 'No';
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'CallingDetails',N'Audio Listen',N'AudioListen',N'$oldValue',N'$newValue',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopCallingExists["GoodCall"] != $goodCall){
                    $oldValue = $isShopCallingExists["GoodCall"] == '1' ? 'Yes' : 'No';
                    $newValue = $goodCall == '1' ? 'Yes' : 'No';
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'CallingDetails',N'Good Call',N'GoodCall',N'$oldValue',N'$newValue',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopCallingExists["Appreciation"] != $appreciationCall){
                    $oldValue = $isShopCallingExists["Appreciation"] == '1' ? 'Yes' : 'No';
                    $newValue = $appreciationCall == '1' ? 'Yes' : 'No';
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'CallingDetails',N'Appreciation Call',N'Appreciation',N'$oldValue',N'$newValue',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }


            }
        }

        return $updateQCDetail;
    }

}
?>
