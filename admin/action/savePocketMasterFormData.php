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
    
    $updatePocketMaster = array();

    if  (
            (isset($_POST['electionName']) && !empty($_POST['electionName'])) &&
            (isset($_POST['PocketName']) && !empty($_POST['PocketName'])) && 
            (isset($_POST['PocketNameMar']) && !empty($_POST['PocketNameMar'])) && 
            (isset($_POST['Node_Cd']) && !empty($_POST['Node_Cd'])) && 
            (isset($_POST['action']) && !empty($_POST['action'])) 
        ) {

        // $electionCd = $_POST['electionName'];
        // $dbElec=new DbOperation();
        // $dataElection = $dbElec->getSALCorporationElectionByCdData($userName, $appName, $electionCd);
        // // print_r($dataElection);
        // $_SESSION['SAL_ElectionName'] = $dataElection["ElectionName"];
        // $electionName = $_SESSION['SAL_ElectionName'];

        $electionName = $_POST['electionName'];
        $action = $_POST['action'];
        $Pocket_Cd = $_POST['Pocket_Cd'];
        $PocketName = $_POST['PocketName'];
        $PocketNameMar = $_POST['PocketNameMar'];
        $Node_Cd = $_POST['Node_Cd'];
        
        $deActiveDate = $_POST['deActiveDate'];
        $isActive = $_POST['isActive'];

        $KMLFile_Url = $_SESSION['SAL_KML_FileUrl'];

        $target_path1 = "../uploads/KML/";
        $temp = explode(".", $_FILES["KMLFile_Url"]["name"]);
        $target_filename = round(microtime(true)) .'_'. $electionName .'_'. $Pocket_Cd . '.' . end($temp);
        $target_path1 = $target_path1 . $target_filename ;
        if (move_uploaded_file($_FILES['KMLFile_Url']['tmp_name'], $target_path1)) {
            
            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                    "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                    $_SERVER['REQUEST_URI'];

                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
                    
            $KML_FileUrl = $new_link.$target_path1;
           
        } else {
            $KML_FileUrl = $KMLFile_Url;
        }
      
      
           

        if($action == 'Update'){
                
            $sql1 = "SELECT top (1) Pocket_Cd FROM PocketMaster WHERE Pocket_Cd = $Pocket_Cd ;";
            
            $isPocketExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            if( sizeof($isPocketExists) > 0 )
            {
                $sql2 = "UPDATE PocketMaster
                     SET 
                         PocketName = '$PocketName',
                         PocketNameMar = N'$PocketNameMar',
                         Node_Cd = '$Node_Cd',
                         KML_FileUrl = '$KML_FileUrl',
                         IsActive = '$isActive',
                         UpdatedByUser = '$updatedByUser',
                         UpdatedDate = GETDATE()
                     WHERE Pocket_Cd = '$Pocket_Cd';";
                $updatePckt = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updatePckt){
                    $updatePocketMaster['Flag'] = 'U';
                }
            }

                
        } else if($action == 'Insert'){
            $sql1 = "SELECT top (1) Pocket_Cd FROM PocketMaster
            WHERE PocketName = '$PocketName' AND Node_Cd = '$Node_Cd' ;";
            $isPocketExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            
            if( sizeof($isPocketExists) > 0 )
            {
                $updatePocketMaster['Flag'] = 'E';
            }else{
                $sql2 = "INSERT INTO PocketMaster(PocketName,PocketNameMar,Node_Cd,KML_FileUrl,IsActive,UpdatedDate,UpdatedByUser,AddedBy,AddedDate)
                VALUES('$PocketName',N'$PocketNameMar','$Node_Cd','$KML_FileUrl','$isActive',GETDATE(),'$updatedByUser','$updatedByUser',GETDATE());";
                $insertPckt = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($insertPckt){
                    $updatePocketMaster['Flag'] = 'I';
                }
            }
        } else if($action == 'Remove'){

            $sql1 = "SELECT top (1) Pocket_Cd FROM PocketMaster WHERE Pocket_Cd = $Pocket_Cd ;";
            $isPocketExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            if( sizeof($isPocketExists) > 0 )
            {
                $sql2 = "UPDATE PocketMaster
                         SET 
                             IsActive = 0,
                             DeActiveDate = GETDATE(),
                             UpdatedByUser = '$updatedByUser',
                             UpdatedDate = GETDATE()
                         WHERE Pocket_Cd = '$Pocket_Cd'";
                $deletePckt = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($deletePckt){
                    $updatePocketMaster['Flag'] = 'D';
                }
            }

        }

            
      
    }else{
        
    }


    if (sizeof($updatePocketMaster) > 0) {

        $flag = $updatePocketMaster['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
        } elseif($flag == 'E'){
            echo json_encode(array('statusCode' => 206, 'msg' => 'Already Have An Entry!'));
        } elseif($flag == 'D'){
            echo json_encode(array('statusCode' => 203, 'msg' => 'Pocket Deleted!'));
        }
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
    }

    header('Location:../home.php?p=pocket-master');
}
?>
