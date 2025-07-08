<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
        (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
    ) {
        
        $scheduleCallCd = $_POST['schedulecallid'];
        $shopCd = $_POST['shopid'];
        $docDetId = $_POST['docDetId'];
        $executiveCd = $_POST['executiveId'];
        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];

        $qcRemark1 = "";
        $qcRemark2 = "";
        $qcRemark3 = "";

        $DocPhoto = "";
        if(isset($_FILES['file']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopDocuments/";

            $temp = explode(".", $_FILES["file"]["name"]);
            $target_filename =  $electionName. '_' .round(microtime(true)) . '_ShopDocuments_'  . round(microtime(true)) . '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;

            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
         
            // Valid extensions
            $valid_ext = array("jpg","png","jpeg");

            if(in_array($file_extension,$valid_ext))
            {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $DocPhoto = $new_link . $target_path1;
                }
            }
        }

      
        $query = "SELECT top (1) sd.ShopDocDet_Cd, sd.FileURL, sd.IsActive, sdm.DocumentName FROM ShopDocuments sd INNER JOIN ShopDocumentMaster sdm on sdm.Document_Cd= sd.Document_Cd WHERE sd.ShopDocDet_Cd = $docDetId;";
        $isShopDocumentDetExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        // echo $query;
        if( sizeof($isShopDocumentDetExists) > 0 )
        {
            
            $sql2 = "UPDATE ShopDocuments
                 SET 
                    FileURL = '$DocPhoto',
                    UpdatedByUser = '$updatedByUser',
                    UpdatedDate = GETDATE(),
                    IsActive = 1,
                    QC_Flag = null,
                    QC_UpdatedByUser = null,
                    QC_UpdatedDate = null
                 WHERE ShopDocDet_Cd = $docDetId;";
                 
                 // echo $sql2;
            $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
            if($updateQC){
                $updateQCDetail['Flag'] = 'U';

                $dbQC=new DbOperation();
        // docDetId = Document Uploaded Id inserted into Calling_Cd for Document Upload QC to avoid seperate column in QC Details Table
                $documentName = $isShopDocumentDetExists["DocumentName"];
                $qcRemark1 = $documentName." Uploaded.";
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd) VALUES($shopCd,$docDetId,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                if($isShopDocumentDetExists["FileURL"] != $DocPhoto){
                    $oldValue = $isShopDocumentDetExists["FileURL"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopDocuments',N'$documentName',N'FileURL',N'$oldValue',N'$DocPhoto',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopDocumentDetExists["IsActive"] != 1){
                    $oldValue = $isShopDocumentDetExists["IsActive"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopDocuments',N'Is Document Active',N'IsActive',N'$oldValue',N'1',null,null);";
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

        if($flag == 'I') {
            echo json_encode(array('error' => false, 'message' => 'Shop Document Inserted!'));
        }else if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Document Uploaded!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
