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
           
            (isset($_POST['shopBoardType']) && !empty($_POST['shopBoardType'])) && 
            (isset($_POST['shopBoardHeight']) && !empty($_POST['shopBoardHeight'])) && 
            (isset($_POST['shopBoardWidth']) && !empty($_POST['shopBoardWidth'])) && 
            (isset($_POST['qcType']) && !empty($_POST['qcType'])) && 
            (isset($_POST['qcFlag']) && !empty($_POST['qcFlag'])) && 
            (isset($_POST['executiveId']) && !empty($_POST['executiveId'])) && 
            (isset($_POST['shopid']) && !empty($_POST['shopid'])) 
        ) {

        
        $scheduleCallCd = $_POST['schedulecallid'];
        $boardID = $_POST['boardid'];
        $shopCd = $_POST['shopid'];
        $executiveCd = $_POST['executiveId'];
        
        $shopBoardType = $_POST['shopBoardType'];
        $shopBoardHeight = $_POST['shopBoardHeight'];
        $shopBoardWidth = $_POST['shopBoardWidth'];
        $BoardPhoto_URL = $_POST['shopBoardPhotoURL'];
        $isShopBoardActive = $_POST['isShopBoardActive'];
       


        $qcType = $_POST['qcType'];
        $qcFlag = $_POST['qcFlag'];
        $qcRemark1 = $_POST['qcRemark1'];
        $qcRemark2 = $_POST['qcRemark2'];
        $qcRemark3 = $_POST['qcRemark3'];
      
        // if (strpos($shopBoardType, " ")) {
        //     $shopBoardTypeFileName = str_replace(" ", "_", $shopBoardType);
        // }else{
            $shopBoardTypeFileName = $shopBoardType;
        // }

        if(isset($_FILES['file']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopBoards/";

            $temp = explode(".", $_FILES["file"]["name"]);
            $target_filename =  $electionName. '_' .round(microtime(true))  . '_' . $shopBoardTypeFileName . '_' . $shopCd . '.' . end($temp);
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
            
                    $BoardPhoto = $new_link . $target_path1;
                }
            }
        }else{
			$BoardPhoto = $BoardPhoto_URL;
		}

        if(!isset($_FILES['file']['name']))
        {
            $BoardPhoto = $BoardPhoto_URL;
        }
    
        if($BoardPhoto == 'null'){
            $BoardPhoto = "";
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

        $query = "SELECT top (1) Shop_Cd, BoardType, BoardHeight, BoardWidth, BoardPhoto,IsActive FROM ShopBoardDetails WHERE Shop_Cd = $shopCd AND BoardID = $boardID;";
        $isShopBoardExists = $db->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
        if( sizeof($isShopBoardExists) > 0 )
        {
            
            $sql2 = "UPDATE ShopBoardDetails
                 SET 
                    BoardType = '$shopBoardType',
                    BoardHeight = '$shopBoardHeight',
                    BoardWidth = '$shopBoardWidth',
                    BoardPhoto = '$BoardPhoto',
                    IsActive = '$isShopBoardActive',
                    QC_Flag = '$qcFlag',
                    QC_UpdatedByUser = '$updatedByUser',
                    QC_UpdatedDate = GETDATE()
                 WHERE Shop_Cd = $shopCd AND BoardID = $boardID;";
                 // echo $sql2;
            $updateQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
            if($updateQC){
                $updateQCDetail['Flag'] = 'U';

                $dbQC=new DbOperation();
            
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd,BoardID) VALUES ($shopCd,null,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd,$boardID);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                if($isShopBoardExists["BoardType"] != $shopBoardType){
                    $oldValue = $isShopBoardExists["BoardType"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Type',N'BoardType',N'$oldValue',N'$shopBoardType',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopBoardExists["BoardHeight"] != $shopBoardHeight){
                    $oldValue = $isShopBoardExists["BoardHeight"];
                    if(empty($oldValue)){
                        $oldValue = 0;
                    }
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Height',N'BoardHeight',N'$oldValue',N'$shopBoardHeight',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopBoardExists["BoardWidth"] != $shopBoardWidth){
                    $oldValue = $isShopBoardExists["BoardWidth"];
                    if(empty($oldValue)){
                        $oldValue = 0;
                    }
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Width',N'BoardWidth',N'$oldValue',N'$shopBoardWidth',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopBoardExists["BoardPhoto"] != $BoardPhoto){
                    $oldValue = $isShopBoardExists["BoardPhoto"];
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Photo',N'BoardPhoto',N'$oldValue',N'$BoardPhoto',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }

                if($isShopBoardExists["IsActive"] != $isShopBoardActive){
                    $oldValue = $isShopBoardExists["IsActive"];
                    if(empty($oldValue)){
                        $oldValue = 0;
                    }
                    $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Detail IsActive',N'IsActive',N'$oldValue',N'$isShopBoardActive',null,null);";
                    $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
                }
                

            }
        }else{

            $sql2 = "INSERT INTO ShopBoardDetails(Shop_Cd,BoardType,BoardHeight,BoardWidth,BoardPhoto,IsActive,UpdatedByUser,UpdatedDate,QC_Flag,QC_UpdatedByUser,QC_UpdatedDate) VALUES ($shopCd,'$shopBoardType','$shopBoardHeight','$shopBoardWidth','$BoardPhoto','$isShopBoardActive',N'$updatedByUser',GETDATE(),'$qcFlag','$updatedByUser',GETDATE());";
            // echo $sql2;
            $insertBoardQC = $db->RunQueryData($sql2, $electionName, $developmentMode);
            if($insertBoardQC){
                $updateQCDetail['Flag'] = 'I';

                $dbQCChk=new DbOperation();
                // $query = "SELECT top (1) BoardID FROM ShopBoardDetails WHERE Shop_Cd = $shopCd AND BoardType = '$shopBoardType' ORDER BY UpdatedDate DESC;";
                $query = "SELECT IDENT_CURRENT('ShopBoardDetails') as BoardID";
                $isShopBoardExists = $dbQCChk->ExecutveQuerySingleRowSALData($query, $electionName, $developmentMode);
                if(sizeof($isShopBoardExists)>0){
                    $boardID = $isShopBoardExists["BoardID"];
                }

                $dbQC=new DbOperation();
            
                $sqlQCDet = "INSERT INTO QCDetails(Shop_Cd,Calling_Cd,Executive_Cd,QC_DateTime,QC_Type,QC_Flag,QC_Remark1,QC_Remark2,QC_Remark3,QC_UpdatedByUser,QC_UpdatedDate,ScheduleCall_Cd,BoardID) VALUES ($shopCd,null,$executiveCd,GETDATE(),'$qcType','$qcFlag',N'$qcRemark1',N'$qcRemark2',N'$qcRemark3','$updatedByUser',GETDATE(),$scheduleCallCd,$boardID);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);

                $lastQCDetailId = $dbQC->ExecutveQuerySingleRowSALData("SELECT IDENT_CURRENT('QCDetails') as QC_Detail_Cd", $electionName, $developmentMode); 
                $QC_Detail_Cd = $lastQCDetailId["QC_Detail_Cd"];

                
                $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Type',N'BoardType','',N'$shopBoardType',null,null);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
            

            
                $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Height',N'BoardHeight','',N'$shopBoardHeight',null,null);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
            

            
                $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Width',N'BoardWidth','',N'$shopBoardWidth',null,null);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
            

           
                $sqlQCDet = "INSERT INTO QCLogDetails(QC_Detail_Cd,TableName,ColumnAlias,ColumnName,Old_Value,QC_Value,JoinTableName,JoinColumnName) VALUES($QC_Detail_Cd,N'ShopBoardDetails',N'Board Photo',N'BoardPhoto','',N'$BoardPhoto',null,null);";
                $insertQCDet = $dbQC->RunQueryData($sqlQCDet, $electionName, $developmentMode);
           

            }

        }

                

            
      
    }else{
        
    }

    $queryTime = "SELECT CONVERT(VARCHAR,GETDATE(),100) as QCDoneTime;";
    $doneTimeData = $db->ExecutveQuerySingleRowSALData($queryTime, $electionName, $developmentMode);

    if (sizeof($updateQCDetail) > 0) {

        $flag = $updateQCDetail['Flag'];

        if($flag == 'I') {
            echo json_encode(array('error' => false, 'message' => 'Shop Board QC Done on '.$doneTimeData["QCDoneTime"].'!'));
        }else if($flag == 'U') {
            echo json_encode(array('error' => false, 'message' => 'Shop Board QC Done on '.$doneTimeData["QCDoneTime"].'!'));
        }
    }else{
        echo json_encode(array('error' => true, 'message' => 'Error.. Please try again!'));
    }

    
}
?>
