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
            (isset($_POST['selectedDocumentIds']) && !empty($_POST['selectedDocumentIds'])) &&
            (isset($_POST['docQCAction']) && !empty($_POST['docQCAction'])) && 
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $scheduleCallCd = $_POST['schedulecallid'];
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        $selectedDocumentIds = $_POST['selectedDocumentIds'];
        $docQCAction = $_POST['docQCAction'];
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['qcRemark1'];
        $qcRemark2 = $_POST['qcRemark2'];
        $qcRemark3 = $_POST['qcRemark3'];

    
        $query = "SELECT top (1) Shop_Cd FROM ShopMaster WHERE Shop_Cd = $shopCd ;";
        $isShopExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopExists) > 0 )
        {
            

            if($docQCAction == 'QC'){
                $sql2 = "UPDATE ShopMaster
                    SET 
                        QC_Flag = '$qcFlag',
                        QC_UpdatedByUser = '$updatedByUser',
                        QC_UpdatedDate = GETDATE()
                    WHERE Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);    

                $sql21 = "UPDATE ShopDocuments
                    SET 
                        QC_Flag = '$qcFlag',
                        QC_UpdatedByUser = '$updatedByUser',
                        QC_UpdatedDate = GETDATE()
                    WHERE ShopDocDet_Cd in ($selectedDocumentIds) AND Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql21, $electionName, $developmentMode);    

            }else if($docQCAction == 'Delete'){
                $sql2 = "UPDATE ShopDocuments
                    SET 
                        IsActive = 0,
                        QC_Flag = '$qcFlag',
                        QC_UpdatedByUser = '$updatedByUser',
                        QC_UpdatedDate = GETDATE()
                    WHERE ShopDocDet_Cd in ($selectedDocumentIds) AND Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);    
            }

            if($updateQC){
                $updateQCDetail['Flag'] = 'U';

                $dbQC=new DbOperation();
            
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES($shopCd,null,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];
                
                if($docQCAction == 'QC'){
                    $ColumnAlias = "Documents QC";
                }else if($docQCAction == 'Delete'){
                    $ColumnAlias = "Documents Deleted"; 
                }
               
                $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopDocuments',N'$ColumnAlias',null,null,N'$qcRemark1',null,null);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
            }

        }
      
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Document QC Done on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
