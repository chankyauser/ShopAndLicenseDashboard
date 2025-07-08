<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

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
            (isset($_POST['natureofBusiness']) && !empty($_POST['natureofBusiness'])) &&
             (isset($_POST['establishmentAreaCategory']) && !empty($_POST['establishmentAreaCategory'])) &&
            (isset($_POST['establishmentCategory']) && !empty($_POST['establishmentCategory'])) && 
            (isset($_POST['establishmentName']) && !empty($_POST['establishmentName'])) && 
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        $natureofBusiness = $_POST['natureofBusiness'];
        $establishmentAreaCategory = $_POST['establishmentAreaCategory'];
        $establishmentCategory = $_POST['establishmentCategory'];
       

        $establishmentName = $_POST['establishmentName'];
        $establishmentNameMar = $_POST['establishmentNameMar'];
 
        $shopkeeperName = $_POST['shopkeeperName'];
        $shopkeeperMobileNo = $_POST['shopkeeperMobileNo'];
        $shopContactNo1 = $_POST['shopContactNo1'];
        $shopContactNo2 = $_POST['shopContactNo2'];

        $shopAddressLine1 = $_POST['shopAddressLine1'];
        $shopAddressLine2 = $_POST['shopAddressLine2'];
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['qcRemark1'];
        $qcRemark2 = $_POST['qcRemark2'];
        $qcRemark3 = $_POST['qcRemark3'];
        
        if (strpos($establishmentName, "'")) {
            $establishmentName = str_replace("'", "''", $establishmentName);
        }

        if (strpos($establishmentNameMar, "'")) {
            $establishmentNameMar = str_replace("'", "''", $establishmentNameMar);
        }

        if (strpos($shopkeeperName, "'")) {
            $shopkeeperName = str_replace("'", "''", $shopkeeperName);
        }

        if (strpos($shopAddressLine1, "'")) {
            $shopAddressLine1 = str_replace("'", "''", $shopAddressLine1);
        }

        if (strpos($shopAddressLine2, "'")) {
            $shopAddressLine2 = str_replace("'", "''", $shopAddressLine2);
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

        $query = "SELECT top (1) sm.Shop_Cd, ISNULL(sm.BusinessCat_Cd,0) as BusinessCat_Cd, bcm.BusinessCatName, ISNULL(sm.ShopArea_Cd,0) as ShopArea_Cd, sam.ShopAreaName, sm.ShopCategory, sm.ShopName, sm.ShopNameMar, sm.ShopKeeperName, sm.ShopKeeperMobile, sm.ShopContactNo_1, sm.ShopContactNo_2, sm.ShopAddress_1, sm.ShopAddress_2 FROM ShopMaster sm LEFT JOIN BusinessCategoryMaster bcm on bcm.BusinessCat_Cd = sm.BusinessCat_Cd LEFT JOIN ShopAreaMaster sam on sam.ShopArea_Cd = sm.ShopArea_Cd WHERE sm.Shop_Cd = $shopCd ;";
        // echo $query;
        $isShopExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopExists) > 0 )
        {
            $sql2 = "UPDATE ShopMaster
                 SET 
                    BusinessCat_Cd = $natureofBusiness,
                    ShopArea_Cd = $establishmentAreaCategory,
                    ShopCategory = '$establishmentCategory',

                    ShopName = '$establishmentName',
                    ShopNameMar = N'$establishmentNameMar',
                    
                    ShopKeeperName = '$shopkeeperName',
                    ShopKeeperMobile = '$shopkeeperMobileNo',
                    ShopContactNo_1 = '$shopContactNo1',
                    ShopContactNo_2 = '$shopContactNo2',

                    ShopAddress_1 = N'$shopAddressLine1',
                    ShopAddress_2 = N'$shopAddressLine2',
                    QC_Flag = '$qcFlag',
                    QC_UpdatedByUser = '$updatedByUser',
                    QC_UpdatedDate = GETDATE()
                 WHERE Shop_Cd = $shopCd;";
            $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
            // echo $sql2;
            if($updateQC){
                $dbQC=new DbOperation();
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate) VALUES($shopCd,null,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE());";

                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                if($isShopExists["BusinessCat_Cd"] != $natureofBusiness){
                    $oldValue = $isShopExists["BusinessCatName"];
                    $businessCatName="";
                    $dbQC11=new DbOperation();
                    $businessCatData = $dbQC11->ExecutveQuerySingleRowSALData("SELECT BusinessCatName FROM BusinessCategoryMaster WHERE BusinessCat_Cd = $natureofBusiness ", $electionName, $developmentMode);
                    if(sizeof($businessCatData)>0){
                        $businessCatName = $businessCatData["BusinessCatName"];
                    } 
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Nature of Business',N'BusinessCat_Cd',N'$oldValue',N'$businessCatName',N'BusinessCategoryMaster',N'BusinessCat_Cd');";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }
                
                if($isShopExists["ShopArea_Cd"] != $establishmentAreaCategory){
                    $oldValue = $isShopExists["ShopAreaName"];
                    $shopAreaName = "";
                    $dbQC12=new DbOperation();
                    $shopAreaData = $dbQC12->ExecutveQuerySingleRowSALData("SELECT ShopAreaName FROM ShopAreaMaster WHERE ShopArea_Cd = $establishmentAreaCategory ;", $electionName, $developmentMode);
                    if(sizeof($shopAreaData)>0){
                        $shopAreaName = $shopAreaData["ShopAreaName"];
                    } 
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Area Category',N'ShopArea_Cd',N'$oldValue',N'$shopAreaName',N'ShopAreaMaster',N'ShopArea_Cd');";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopExists["ShopCategory"] != $establishmentCategory){
                    $oldValue = $isShopExists["ShopCategory"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Category',N'ShopCategory',N'$oldValue',N'$establishmentCategory',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }
                 
                if($isShopExists["ShopName"] != $establishmentName){
                    $oldValue = $isShopExists["ShopName"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Name in English',N'ShopName',N'$oldValue',N'$establishmentName',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }  

                if($isShopExists["ShopNameMar"] != $establishmentNameMar){
                    $oldValue = $isShopExists["ShopNameMar"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Name in Marathi',N'ShopNameMar',N'$oldValue',N'$establishmentNameMar',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                } 
                  
                if($isShopExists["ShopKeeperName"] != $shopkeeperName){
                    $oldValue = $isShopExists["ShopKeeperName"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'ShopKeeper FullName',N'ShopKeeperName',N'$oldValue',N'$shopkeeperName',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }   

                if($isShopExists["ShopKeeperMobile"] != $shopkeeperMobileNo){
                    $oldValue = $isShopExists["ShopKeeperMobile"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'ShopKeeper Mobile Number',N'ShopKeeperMobile',N'$oldValue',N'$shopkeeperMobileNo',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopExists["ShopContactNo_1"] != $shopContactNo1){
                    $oldValue = $isShopExists["ShopContactNo_1"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Contact No 1',N'ShopContactNo_1',N'$oldValue',N'$shopContactNo1',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopExists["ShopContactNo_2"] != $shopContactNo2){
                    $oldValue = $isShopExists["ShopContactNo_2"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Contact No 2',N'ShopContactNo_2',N'$oldValue',N'$shopContactNo2',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopExists["ShopAddress_1"] != $shopAddressLine1){
                    $oldValue = $isShopExists["ShopAddress_1"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Address Line 1',N'ShopAddress_1',N'$oldValue',N'$shopAddressLine1',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }
                    
                if($isShopExists["ShopAddress_2"] != $shopAddressLine2){
                    $oldValue = $isShopExists["ShopAddress_2"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Address Line 2',N'ShopAddress_2',N'$oldValue',N'$shopAddressLine2',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }   
                    
                $updateQCDetail['Flag'] = 'U';
            }
        }

                

            
      
    }else{
        // echo "dfdfd";
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop List QC Done on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
