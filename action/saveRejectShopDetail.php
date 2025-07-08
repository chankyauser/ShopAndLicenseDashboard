<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    session_start();
    include '../api/includes/DbOperation.php';

    $db=new DbOperation();
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];  
    
    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $db=new DbOperation();
        $userData = $db->ExecutveQuerySingleRowSALData("SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
        if(sizeof($userData)>0){
            $_SESSION['SAL_UserName'] = $userData["UserName"];
        }
    }else{
        session_unset();
        session_destroy();
        header('Location:../index.php?p=login');
    }
    
    $userName=$_SESSION['SAL_UserName'];
    
    $updatedByUser = $userName;
    
    $updateQCDetail = array();

    if  (
           
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['shopId']) && !empty($_POST['shopId'])) 
        ) {

        
        $electionName = $_POST['electionName'];
        $_SESSION['SAL_ElectionName'] = $electionName;
        $wardOfficerUserId = $_POST['wardOfficerUserId'];
        $shopCd = $_POST['shopId'];
        
        
        $pageNo = $_POST['pageNo'];
        $_SESSION['SAL_Pagination_PageNo'] = $pageNo;  

        $shopApprovalRemark = $_POST['shopApprovalRemark'];
        
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['shopApprovalRemark'];
        $qcRemark2 = "";
        $qcRemark3 = "";
    

        
        if (strpos($shopApprovalRemark, "'")) {
            $shopApprovalRemark = str_replace("'", "''", $shopApprovalRemark);
        }

        if (strpos($qcRemark1, "'")) {
            $qcRemark1 = str_replace("'", "''", $qcRemark1);
        }

        if (strpos($qcRemark2, "'")) {
            $qcRemark2 = str_replace("'", "''", $qcRemark2);
        }

        if (strpos($qcRemark3, "'")) {
            $qcRemark3 = str_replace("'", "''", $qcRemark3);
        }

        $query = "SELECT top (1) sm.Shop_Cd, ISNULL(sm.BusinessCat_Cd,0) as BusinessCat_Cd, bcm.BusinessCatName, ISNULL(sm.ShopArea_Cd,0) as ShopArea_Cd, sam.ShopAreaName, sm.ShopCategory, sm.ShopName, sm.ShopNameMar, sm.ShopKeeperName, sm.ShopKeeperMobile, sm.ShopContactNo_1, sm.ShopContactNo_2, sm.ShopAddress_1, sm.ShopAddress_2, ISNULL(sm.ParwanaDetCd,0) as ParwanaDetCd, sm.ConsumerNumber, sm.ShopOwnStatus, sm.ShopOwnPeriod, sm.ShopDimension, sm.GSTNno, sm.ContactNo3, sm.MaleEmp, sm.FemaleEmp, sm.OtherEmp, sm.ShopOwnerName, sm.ShopOwnerMobile, sm.ShopEmailAddress, sm.ShopOwnerAddress, sm.ShopApproval, sm.ShopApprovalRemark FROM ShopMaster sm LEFT JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd LEFT JOIN ShopAreaMaster sam on sam.ShopArea_Cd = sm.ShopArea_Cd WHERE sm.Shop_Cd = $shopCd ;";
        $isShopExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopExists) > 0 )
        {
            
             $dbSD=new DbOperation();

            $dataCallingCategory = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 Calling_Category_Cd FROM CallingCategoryMaster WHERE Calling_Type = 'Collection' AND QC_Type = '$qcType' ", $electionName, $developmentMode);
            if(sizeof($dataCallingCategory)>0){


                $sql2 = "UPDATE ShopMaster
                     SET 

                        ShopApproval = 'Rejected',
                        ShopApprovalRemark = '$shopApprovalRemark',
                        ShopApprovalBy = '$updatedByUser',
                        ShopApprovalDate = GETDATE(),


                        QC_Flag = '$qcFlag',
                        QC_UpdatedByUser = '$updatedByUser',
                        QC_UpdatedDate = GETDATE()
                     WHERE Shop_Cd = $shopCd;";
                $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updateQC){

                    $updateQCDetail['Flag'] = 'U';

                   


                    $scheduleCategory = $dataCallingCategory["Calling_Category_Cd"];


                    $sqlSDDet = "INSERT INTO ScheduleDetails(Shop_Cd,Calling_Category_Cd,Executive_Cd,CallingDate,CallReason,Remark,IsActive,UpdatedByUser,UpdatedDate) VALUES($shopCd,$scheduleCategory,null,GETDATE(),'Verify Shop License',null,1,'$updatedByUser',GETDATE());";
                    $insertSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                        // echo $sqlSDDet;

                    if($insertSDDet){
                        

                        $dataScheduleDetails = $dbSD->ExecutveQuerySingleRowSALData("SELECT TOP 1 ScheduleCall_Cd FROM ScheduleDetails WHERE Shop_Cd = $shopCd AND Calling_Category_Cd = $scheduleCategory AND CallReason = 'Verify Shop License' ", $electionName, $developmentMode);

                        if(sizeof($dataScheduleDetails)>0){
                            $scheduleCallCd = $dataScheduleDetails["ScheduleCall_Cd"];

                            $dbST=new DbOperation();
                            $sqlSTDet = "INSERT INTO ShopTracking(ScheduleCall_Cd,Shop_Cd,Calling_Category_Cd,AssignDate,AssignExec_Cd,AssignTempExec_Cd,ST_StageName,ST_DateTime,ST_Exec_Cd,ST_Status,ST_Remark_1,ST_Remark_2,ST_Remark_3,UpdatedByUser,UpdatedDate) VALUES($scheduleCallCd,$shopCd,$scheduleCategory,GETDATE(),null,null,'Application Rejected',GETDATE(),null,1,'$shopApprovalRemark',null,null,'$updatedByUser',GETDATE());";
                            $insertSTDet = $dbST->RunQueryData($sqlSTDet, $electionName, $developmentMode);
                        
                            if($insertSTDet){

                                $dbQC=new DbOperation();

                                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,null,null,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];


                                if($isShopExists["ShopApproval"] != "Verified"){
                                    $oldValue = $isShopExists["ShopApproval"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Status',N'ShopApproval',N'$oldValue',N'Rejected',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                    if($isShopExists["ShopApprovalRemark"] != $shopApprovalRemark){
                                        $oldValue = $isShopExists["ShopApprovalRemark"];
                                        $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Remark',N'ShopApprovalRemark',N'$oldValue',N'$shopApprovalRemark',null,null);";
                                        $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                    }
                                    
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Status Date',N'ShopApprovalDate','',CONVERT(VARCHAR, GETDATE(),100),null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                                }



                            }
                        

                        }
                    } 

                }
                    
                       

            }


        }

          
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop License Rejected on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
