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
           
            (isset($_POST['parwanaDetCd']) && !empty($_POST['parwanaDetCd'])) && 
            (isset($_POST['ownedRented']) && !empty($_POST['ownedRented'])) && 
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $scheduleCallCd = $_POST['schedulecallid'];
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        
        $consumerNumber = $_POST['consumerNumber'];
        $ownedRented = $_POST['ownedRented'];
        $shopOwnPeriodYrs = $_POST['shopOwnPeriodYrs'];
        $shopOwnPeriodMonths = $_POST['shopOwnPeriodMonths'];
        $shopDimension = $_POST['shopDimension'];
        $gstNo = $_POST['gstNo'];
        $parwanaDetCd = $_POST['parwanaDetCd'];
        $shopContactNo3 = $_POST['shopContactNo3'];
        $maleEmp = $_POST['maleEmp'];
        $femaleEmp = $_POST['femaleEmp'];
        $otherEmp = $_POST['otherEmp'];


        $shopOwnerName = $_POST['shopOwnerName'];
        $shopOwnerMobile = $_POST['shopOwnerMobile'];
        $shopEmailAddress = $_POST['shopEmailAddress'];
        $shopOwnerAddress = $_POST['shopOwnerAddress'];
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['qcRemark1'];
        $qcRemark2 = $_POST['qcRemark2'];
        $qcRemark3 = $_POST['qcRemark3'];
        $shopOwnPeriod = ( ($shopOwnPeriodYrs * 12) + $shopOwnPeriodMonths );


  

        if (strpos($shopOwnerName, "'")) {
            $shopOwnerName = str_replace("'", "''", $shopOwnerName);
        }
        
        if (strpos($shopOwnerAddress, "'")) {
            $shopOwnerAddress = str_replace("'", "''", $shopOwnerAddress);
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

        $query = "SELECT top (1) Shop_Cd, ISNULL(ParwanaDetCd,0) as ParwanaDetCd, ConsumerNumber, ShopOwnStatus, ShopOwnPeriod, ShopDimension, GSTNno, ContactNo3, MaleEmp, FemaleEmp, OtherEmp, ShopOwnerName, ShopOwnerMobile, ShopEmailAddress, ShopOwnerAddress FROM ShopMaster WHERE Shop_Cd = $shopCd ;";
        $isShopExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopExists) > 0 )
        {
            


            $sql2 = "UPDATE ShopMaster
                 SET 
                    
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
                    QC_Flag = '$qcFlag',
                    QC_UpdatedByUser = '$updatedByUser',
                    QC_UpdatedDate = GETDATE()
                 WHERE Shop_Cd = $shopCd;";
            $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
            if($updateQC){

                $updateQCDetail['Flag'] = 'U';

                $dbQC=new DbOperation();
            
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES ($shopCd,null,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

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
                   

            }


        }

          
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Survey QC Done on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
