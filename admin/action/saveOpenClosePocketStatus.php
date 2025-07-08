<?php 
session_start();
include '../../api/includes/DbOperation.php'; 
  
  $db=new DbOperation();
  $userName=$_SESSION['SAL_UserName'];
  $appName=$_SESSION['SAL_AppName'];
  $electionName=$_SESSION['SAL_ElectionName'];
  $developmentMode=$_SESSION['SAL_DevelopmentMode'];  
  

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  
    if(
        (isset($_POST['electionName']) && !empty($_POST['electionName'])) && 
        (isset($_POST['pcktCd']) && !empty($_POST['pcktCd'])) &&
        // (isset($_POST['pcktAssgnCd']) && !empty($_POST['pcktAssgnCd'])) &&
        (isset($_POST['exeCd']) && !empty($_POST['exeCd'])) &&
        (isset($_POST['usrId']) && !empty($_POST['usrId'])) &&
        (isset($_POST['PocketOpenCloseRemark']) && !empty($_POST['PocketOpenCloseRemark'])) &&
        (isset($_POST['PocketOpenCloseStatus']) && !empty($_POST['PocketOpenCloseStatus']))
      )
    {
            
        $electionName = $_POST['electionName'];

        $pocketCd = $_POST['pcktCd'];
        $pocketAssignCd = $_POST['pcktAssgnCd'];
        $PocketOpenCloseRemark = $_POST['PocketOpenCloseRemark'];
        $PocketOpenCloseStatus = $_POST['PocketOpenCloseStatus'];
        $userId = $_POST['usrId'];
        $executiveCd = $_POST['exeCd'];
        
        $openOrClosePocket = false;

        if($PocketOpenCloseStatus == 'open')
        {
            $pocketStatus = 0;

            $query1 = "UPDATE PocketMaster 
                        SET 
                          IsCompleted = $pocketStatus , 
                          CompletedOn = NULL , 
                          UpdatedByUser = '$userName',
                          UpdatedDate = GETDATE()
                        WHERE Pocket_Cd = $pocketCd AND SRExecutiveCd = $executiveCd;";
        }
        else
        {
            $pocketStatus = 1;

            $query1 = "UPDATE PocketMaster 
                      SET 
                      IsCompleted = $pocketStatus , 
                      CompletedOn = GETDATE() , 
                      UpdatedByUser = '$userName' ,
                      UpdatedDate = GETDATE()
                      WHERE Pocket_Cd = $pocketCd AND SRExecutiveCd = $executiveCd;";
        }
        

        // echo $query1;
        $db2=new DbOperation();
        $openOrClosePocket = $db2->RunQueryData($query1, $electionName, $developmentMode);

        $query2 = "UPDATE PocketAssign 
                  SET 
                  SRRemoveRemark = '$PocketOpenCloseRemark', 
                  SRRemovedDate = GETDATE() , 
                  UpdatedDate = GETDATE(), 
                  UpdatedBy = '$userName' 
                  WHERE PocketCd = $pocketCd AND SRExecutiveCd=$executiveCd AND PocketAssignCd = $pocketAssignCd ;";
                  
        // echo $query2;
        $db3=new DbOperation();
 
        $openOrClosePocket = $db3->RunQueryData($query2, $electionName, $developmentMode);
     

          if($openOrClosePocket == true) 
          {
            echo json_encode(array('statusCode' => 200, 'msg' => "Pocket status Updated!"));
          }
          else
          {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Error in Opening / Closing Pocket!'));
          }
      
    }
}
?>