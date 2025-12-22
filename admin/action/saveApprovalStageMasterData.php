<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];  
    
    $userId=$_SESSION['SAL_UserId'];
    
    $updateApprovalStageMaster = array();

    if  (
            (isset($_POST['roleName']) && !empty($_POST['roleName'])) &&
            (isset($_POST['stageNumber']) && !empty($_POST['stageNumber'])) && 
            (isset($_POST['action']) && !empty($_POST['action'])) 
        ) {

        $roleName = $_POST['roleName'];
        $action = $_POST['action'];
        
        $stageNumber = $_POST['stageNumber'];
        $ApprovalStageId = $_POST['ApprovalStageId'];
        $isMandatory = $_POST['isMandatory'];
        //  print_r($_POST);exit;

        if($action == 'Update'){

             if ($stageNumber > 1) {
                    $missingStage = false;
                    for ($i = 1; $i < $stageNumber; $i++) {
                        $sqlPrev = "SELECT TOP 1 Approval_Stage_Id 
                                    FROM Application_Approval_Stages 
                                    WHERE Stage_Number = $i AND IsActive = 1;";
                        $dbPrev = new DbOperation();
                        $stageExists = $dbPrev->ExecutveQuerySingleRowSALData($sqlPrev, $electionName, $developmentMode);

                        if (!$stageExists) {
                            $missingStage = true;
                            break;
                        }
                    }

                    if ($missingStage) {
                        echo json_encode(array('statusCode' => 207, 'msg' => "Cannot insert stage $stageNumber. One or more previous stages are missing!"));
                        exit;
                    }
            }
            $sql1 = "SELECT top (1) Approval_Stage_Id FROM Application_Approval_Stages WHERE Approval_Stage_Id = $ApprovalStageId ;";
            $db1=new DbOperation();
            $isStageExists = $db1->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            
            if( sizeof($isStageExists) > 0 ){

                $sql2 = "UPDATE Application_Approval_Stages
                     SET 
                        IsActive = 1,
                        Stage_Number = '$stageNumber',
                        Role_Id = '$roleName',
                        Is_Mandatory = '$isMandatory',
                        Updated_By = '$userId',
                        Updated_Date = GETDATE()
                     WHERE Approval_Stage_Id = $ApprovalStageId;";
                $dbedit=new DbOperation();
                $updatestage = $dbedit->RunQueryData($sql2, $electionName, $developmentMode);
                if($updatestage){
                    $updateApprovalStageMaster['Flag'] = 'U';
                }
            }

                
        } else if($action == 'Insert'){
                if ($stageNumber > 1) {
                    $missingStage = false;
                    for ($i = 1; $i < $stageNumber; $i++) {
                        $sqlPrev = "SELECT TOP 1 Approval_Stage_Id 
                                    FROM Application_Approval_Stages 
                                    WHERE Stage_Number = $i AND IsActive = 1;";
                        $dbPrev = new DbOperation();
                        $stageExists = $dbPrev->ExecutveQuerySingleRowSALData($sqlPrev, $electionName, $developmentMode);

                        if (!$stageExists) {
                            $missingStage = true;
                            break;
                        }
                    }

                    if ($missingStage) {
                        echo json_encode(array('statusCode' => 207, 'msg' => "Cannot insert stage $stageNumber. One or more previous stages are missing!"));
                        exit;
                    }
                }

                $sql1 = "SELECT top (1) Approval_Stage_Id FROM Application_Approval_Stages WHERE Stage_Number = $stageNumber AND Role_Id= $roleName;";
                $dbcheck=new DbOperation();
                $isStageExists = $dbcheck->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
                if($isStageExists) {
                    $updateApprovalStageMaster['Flag'] = 'E'; 
                } else {
                    $sql2 = "INSERT INTO Application_Approval_Stages(Stage_Number,Role_Id,IsActive,Added_By,Added_Date)
                    VALUES($stageNumber,$roleName,1,'$userId',GETDATE());";
                    $dbinsert=new DbOperation();
                    $insertstageMaster = $dbinsert->RunQueryData($sql2, $electionName, $developmentMode);
                    if($insertstageMaster){
                        $updateApprovalStageMaster['Flag'] = 'I';
                    }
                }
            
        } else if($action == 'Remove'){

            $sql1 = "SELECT top (1) Approval_Stage_Id FROM Application_Approval_Stages WHERE Stage_Number = $stageNumber ;";
            $isStageExists = $db->ExecutveQuerySingleRowSALData($sql1, $electionName, $developmentMode);
            
            if( sizeof($isStageExists) > 0 ){

                $sql2 = "UPDATE Application_Approval_Stages
                     SET 
                        IsActive = 0,
                        Updated_By = '$userId',
                        Updated_Date = GETDATE()
                     WHERE Approval_Stage_Id = $ApprovalStageId;";
                $updatestage = $db->RunQueryData($sql2, $electionName, $developmentMode);
                if($updatestage){
                    $updateApprovalStageMaster['Flag'] = 'D';
                }
            }

        }
    }else{
        
    }


    if (sizeof($updateApprovalStageMaster) > 0) {

        $flag = $updateApprovalStageMaster['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
        } elseif($flag == 'E'){
            echo json_encode(array('statusCode' => 206, 'msg' => 'Already Have An Entry!'));
        } elseif($flag == 'D'){
            echo json_encode(array('statusCode' => 203, 'msg' => 'Approval Stage Deactivated!'));
        }
    }else{
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
    }

    
}
?>
