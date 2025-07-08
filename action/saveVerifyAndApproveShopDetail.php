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
           
            (isset($_POST['parwanaDetail']) && !empty($_POST['parwanaDetail'])) && 
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

        $establishmentName = $_POST['shopName'];
        $establishmentNameMar = $_POST['shopNameMar'];
        $natureofBusiness = $_POST['businessCateogry'];
        $establishmentAreaCategory = $_POST['shopAreaName'];
        $establishmentCategory = $_POST['shopCateogry'];

        $shopkeeperName = $_POST['shopKeeperName'];
        $shopkeeperMobileNo = $_POST['shopKeeperMobile'];

        $shopContactNo1 = $_POST['ShopContactNo1'];
        $shopContactNo2 = $_POST['ShopContactNo2'];

        $shopAddressLine1 = $_POST['Address1'];
        $shopAddressLine2 = $_POST['Address2'];

        $consumerNumber = $_POST['ConsumerNo'];
        $ownedRented = $_POST['ShopOwnStatus'];
        $shopOwnPeriodYrs = $_POST['PeriodInYrs'];
        $shopOwnPeriodMonths = $_POST['PeriodInMonths'];
        $shopDimension = $_POST['shopDimension'];
        $gstNo = $_POST['GSTNo'];

        $parwanaDetCd = $_POST['parwanaDetail'];

        $shopContactNo3 = $_POST['OwnerContactNo3'];
        $maleEmp = $_POST['maleEmp'];
        $femaleEmp = $_POST['femaleEmp'];
        $otherEmp = $_POST['otherEmp'];


        $shopOwnerName = $_POST['ownerName'];
        $shopOwnerMobile = $_POST['ownerMobile'];
        $shopEmailAddress = $_POST['ownerEmail'];
        $shopOwnerAddress = $_POST['ownerAddress'];

        $shopApprovalRemark = $_POST['shopApprovalRemark'];
        
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['shopApprovalRemark'];
        $qcRemark2 = "";
        $qcRemark3 = "";
        $shopOwnPeriod = ( ($shopOwnPeriodYrs * 12) + $shopOwnPeriodMonths );



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


  

        if (strpos($shopOwnerName, "'")) {
            $shopOwnerName = str_replace("'", "''", $shopOwnerName);
        }
        
        if (strpos($shopOwnerAddress, "'")) {
            $shopOwnerAddress = str_replace("'", "''", $shopOwnerAddress);
        }

        
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
                        
                        ParwanaDetCd = $parwanaDetCd,

                        ConsumerNumber = '$consumerNumber',
                        ShopOwnStatus = '$ownedRented',
                        ShopOwnPeriod = $shopOwnPeriod,
                        ShopDimension = '$shopDimension',
                        GSTNno = '$gstNo',
                        ContactNo3 = '$shopContactNo3',
                        MaleEmp = '$maleEmp',
                        FemaleEmp = '$femaleEmp',
                        OtherEmp = '$otherEmp',
                        ShopOwnerName = '$shopOwnerName',
                        ShopOwnerMobile = '$shopOwnerMobile',
                        ShopEmailAddress = '$shopEmailAddress',
                        ShopOwnerAddress = N'$shopOwnerAddress',

                        ShopApproval = 'Verified',
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
                            $sqlSTDet = "INSERT INTO ShopTracking(ScheduleCall_Cd,Shop_Cd,Calling_Category_Cd,AssignDate,AssignExec_Cd,AssignTempExec_Cd,ST_StageName,ST_DateTime,ST_Exec_Cd,ST_Status,ST_Remark_1,ST_Remark_2,ST_Remark_3,UpdatedByUser,UpdatedDate) VALUES($scheduleCallCd,$shopCd,$scheduleCategory,GETDATE(),null,null,'Application Verified',GETDATE(),null,1,'$shopApprovalRemark',null,null,'$updatedByUser',GETDATE());";
                            $insertSTDet = $dbST->RunQueryData($sqlSTDet, $electionName, $developmentMode);
                        
                            if($insertSTDet){

                                $dbQC=new DbOperation();

                                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,null,null,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
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



                                if($isShopExists["ParwanaDetCd"] != $parwanaDetCd){
                                    $oldParwanaDetCd = $isShopExists["ParwanaDetCd"];
                                    $dbQC11=new DbOperation();
                                    $oldParwanaDetData = $dbQC11->ExecutveQuerySingleRowSALData("SELECT PDetNameEng FROM ParwanaDetails WHERE ParwanaDetCd = $oldParwanaDetCd ", $electionName, $developmentMode);
                                    if(sizeof($oldParwanaDetData)>0){
                                        $oldParwanaDetNameEng = $oldParwanaDetData["PDetNameEng"];
                                    }else{
                                        $oldParwanaDetNameEng="";
                                    }
                                    $dbQC12=new DbOperation();
                                    $newParwanaDetData = $dbQC12->ExecutveQuerySingleRowSALData("SELECT PDetNameEng FROM ParwanaDetails WHERE ParwanaDetCd = $parwanaDetCd ", $electionName, $developmentMode);
                                    if(sizeof($newParwanaDetData)>0){
                                        $newParwanaDetNameEng = $newParwanaDetData["PDetNameEng"];
                                    }else{
                                        $newParwanaDetNameEng="";
                                    }
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Parwana Detail',N'ParwanaDetCd',N'$oldParwanaDetNameEng',N'$newParwanaDetNameEng',N'ParwanaDetails',N'ParwanaDetCd');";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ConsumerNumber"] != $consumerNumber){
                                    $oldValue = $isShopExists["ConsumerNumber"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Consumer Number',N'ConsumerNumber',N'$oldValue',N'$consumerNumber',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopOwnStatus"] != $ownedRented){
                                    $oldValue = $isShopExists["ShopOwnStatus"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Own Status',N'ShopOwnStatus',N'$oldValue',N'$ownedRented',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopOwnPeriod"] != $shopOwnPeriod){
                                    $oldValue = $isShopExists["ShopOwnPeriod"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Own Period (Months)',N'ShopOwnPeriod',N'$oldValue',N'$shopOwnPeriod',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopDimension"] != $shopDimension){
                                    $oldValue = $isShopExists["ShopDimension"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Dimension (Sq. ft.)',N'ShopDimension',N'$oldValue',N'$shopDimension',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["GSTNno"] != $gstNo){
                                    $oldValue = $isShopExists["GSTNno"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop GSTN Number',N'GSTNno',N'$oldValue',N'$gstNo',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ContactNo3"] != $shopContactNo3){
                                    $oldValue = $isShopExists["ContactNo3"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Contact No 3',N'ContactNo3',N'$oldValue',N'$shopContactNo3',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                $oldMaleEmp = $isShopExists["MaleEmp"];
                                if(empty($oldMaleEmp)){
                                 $oldMaleEmp = 0;  
                                }
                                if( $oldMaleEmp != $maleEmp){
                                    $oldValue = $oldMaleEmp;
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Male Employee Count',N'MaleEmp',N'$oldValue',N'$maleEmp',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                $oldFemaleEmp = $isShopExists["FemaleEmp"];
                                if(empty($oldFemaleEmp)){
                                 $oldFemaleEmp = 0;  
                                }
                                if($oldFemaleEmp != $femaleEmp){
                                    $oldValue = $oldFemaleEmp;
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Female Employee Count',N'FemaleEmp',N'$oldValue',N'$femaleEmp',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                $oldOtherEmp = $isShopExists["OtherEmp"];
                                if(empty($oldOtherEmp)){
                                    $oldOtherEmp = 0;  
                                }

                                if($oldOtherEmp != $otherEmp){
                                    $oldValue = $oldOtherEmp;
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Other Employee Count',N'OtherEmp',N'$oldValue',N'$otherEmp',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopOwnerName"] != $shopOwnerName){
                                    $oldValue = $isShopExists["ShopOwnerName"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Owner FullName',N'ShopOwnerName',N'$oldValue',N'$shopOwnerName',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopOwnerMobile"] != $shopOwnerMobile){
                                    $oldValue = $isShopExists["ShopOwnerMobile"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Owner Mobile',N'ShopOwnerMobile',N'$oldValue',N'$shopOwnerMobile',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopEmailAddress"] != $shopEmailAddress){
                                    $oldValue = $isShopExists["ShopEmailAddress"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Owner Email',N'ShopEmailAddress',N'$oldValue',N'$shopEmailAddress',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }

                                if($isShopExists["ShopOwnerAddress"] != $shopOwnerAddress){
                                    $oldValue = $isShopExists["ShopOwnerAddress"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop Owner Address',N'ShopOwnerAddress',N'$oldValue',N'$shopOwnerAddress',null,null);";
                                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                                }


                                if($isShopExists["ShopApproval"] != "Verified"){
                                    $oldValue = $isShopExists["ShopApproval"];
                                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopMaster',N'Shop License Status',N'ShopApproval',N'$oldValue',N'Verified',null,null);";
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
            echo json_encode(array('error' => false, 'message' => 'Shop License Verified on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
