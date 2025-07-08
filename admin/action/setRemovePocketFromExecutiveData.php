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
        (isset($_POST['pcktAssgnCd']) && !empty($_POST['pcktAssgnCd'])) &&
         (isset($_POST['exeCd']) && !empty($_POST['exeCd'])) &&
         (isset($_POST['usrId']) && !empty($_POST['usrId'])) &&
         (isset($_POST['srPocketRemoveRemark']) && !empty($_POST['srPocketRemoveRemark']))
      )
    {
      
        $electionName = $_POST['electionName'];

        $Pocket_Cd = $_POST['pcktCd'];
        $pocketAssignCd = $_POST['pcktAssgnCd'];
        $sremoveRemark = $_POST['srPocketRemoveRemark'];
        $userId = $_POST['usrId'];
        $executiveCd = $_POST['exeCd'];
        
        $updateAssignPocket = false;
        
        
        $query1 = "UPDATE PocketMaster SET SRExecutiveCd = 0, SRAssignedDate = null, PLExecutive_Cd = 0, PLCreatedDate = null, UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE Pocket_Cd = $Pocket_Cd AND SRExecutiveCd=$executiveCd;";
        // echo $query1;

        $db2=new DbOperation();
        $updateAssignPocket = $db2->RunQueryData($query1, $electionName, $developmentMode);

        $query2 = "UPDATE PocketAssign SET SRRemoveRemark = '$sremoveRemark', SRRemovedDate = GETDATE() , UpdatedDate = GETDATE(), UpdatedBy = '$userName' WHERE PocketCd = $Pocket_Cd AND SRExecutiveCd=$executiveCd AND PocketAssignCd = $pocketAssignCd ;";
        // echo $query2;
        $db3=new DbOperation();
        $updateAssignPocket = $db3->RunQueryData($query2, $electionName, $developmentMode);
        
        $dbUpdateElection=new DbOperation();
        $queryUpdateElection="UPDATE Survey_Entry_Data..User_Master SET ElectionName = '' WHERE User_Id = $userId AND Executive_Cd = $executiveCd ";
        $updateUserElectionName = $dbUpdateElection->RunSEDQueryData($userName, $appName, $queryUpdateElection);
        

          if($updateAssignPocket == true) 
          {
            echo json_encode(array('statusCode' => 200, 'msg' => "Updated!"));
          }
          else
          {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Error in Assigning Pocket!'));
          }
      
    }
}
?>