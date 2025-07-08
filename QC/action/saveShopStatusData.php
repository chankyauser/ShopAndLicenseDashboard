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
            (isset($_POST['shopStatus']) && !empty($_POST['shopStatus'])) &&
            (isset($_POST['shopStatusRemark']) && !empty($_POST['shopStatusRemark'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $scheduleCallCd = $_POST['schedulecallid'];
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        $shopStatus = $_POST['shopStatus'];
        $shopStatusRemark = $_POST['shopStatusRemark'];

        $qcRemark1 = "";
        $qcRemark2 = "";
        $qcRemark3 = "";
        
        $query = "SELECT Shop_Cd, ShopStatus, ShopStatusRemark, CONVERT( VARCHAR, ShopStatusDate, 100) as ShopStatusDate FROM ShopMaster WHERE Shop_Cd = $shopCd AND IsActive = 1;";
        $isShopSDExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopSDExists) > 0 )
        {
            
            $sql2 = "UPDATE ShopMaster 
                    SET 
                        ShopStatus = '$shopStatus',
                        ShopStatusRemark = N'$shopStatusRemark',
                        ShopStatusDate = GETDATE(),
                        UpdatedDate  = GETDATE(),
                        UpdatedByUser = '$updatedByUser'
                    WHERE Shop_Cd = $shopCd;";
            $statusShopData = $db->RunQueryData($sql2, $electionName, $developmentMode);
            if($statusShopData){

                $updateSDDetail = array('Flag' => 'U' );

                $dbQC=new DbOperation();

                $qcRemark1 = $isShopSDExists["ShopStatus"]." Updated on ".$isShopSDExists["ShopStatusDate"];
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES($shopCd,null,$executiveCd,GETDATE(),'ShopSurvey','2',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                if($isShopSDExists["ShopStatus"] != $shopStatus){
                    $oldValue = $isShopSDExists["ShopStatus"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Status',N'ShopStatus',N'$oldValue',N'$shopStatus',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                    $oldValue = $isShopSDExists["ShopStatusDate"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Status Date',N'ShopStatusDate',N'$oldValue',CONVERT(VARCHAR, GETDATE(),100),null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopSDExists["ShopStatusRemark"] != $shopStatusRemark){
                    $oldValue = $isShopSDExists["ShopStatusRemark"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Status Remark',N'ShopStatusRemark',N'$oldValue',N'$shopStatusRemark',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

            }  
        }
      
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateSDDetail) > 0) {

        $flag = $updateSDDetail['Flag'];
        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Status Updated on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
