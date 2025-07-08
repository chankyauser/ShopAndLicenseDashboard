<?php 
session_start();
include '../../api/includes/DbOperation.php'; 
  
  $db=new DbOperation();
  $userName=$_SESSION['SAL_UserName'];
  $appName=$_SESSION['SAL_AppName'];
  $electionName=$_SESSION['SAL_ElectionName'];
  $developmentMode=$_SESSION['SAL_DevelopmentMode'];  

  // echo "You are Here Values are Passing";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if(
        (isset($_POST['electionName']) && !empty($_POST['electionName'])) && 
        (isset($_POST['pocketName']) && !empty($_POST['pocketName'])) &&
         (isset($_POST['assignDate']) && !empty($_POST['assignDate'])) &&
         (isset($_POST['userId']) && !empty($_POST['userId'])) &&
         (isset($_POST['executiveCd']) && !empty($_POST['executiveCd']))
      )
    {
       

        $electionName = $_POST['electionName'];
        $Pocket_Cd = $_POST['pocketName'];
        $assignDate = $_POST['assignDate'];
        $userId = $_POST['userId'];
        $executiveCd = $_POST['executiveCd'];

        $updateAssignPocket = false;

        $dbTime = new DbOperation();
        $dbTimeData = $dbTime->ExecutveQuerySingleRowSALData("SELECT convert(varchar(10), GETDATE(), 108) as TimeStr", $electionName, $developmentMode);

        $timeFormatData = $dbTimeData["TimeStr"].".000";

        $assignDate = $assignDate." ".$timeFormatData;

        $query1 = "UPDATE PocketMaster SET SRExecutiveCd = $executiveCd, SRAssignedDate = '$assignDate', PLExecutive_Cd = $executiveCd, PLCreatedDate = '$assignDate', UpdatedDate = GETDATE(), UpdatedByUser = '$userName' WHERE Pocket_Cd = $Pocket_Cd;";

        // echo $query1;

        $db2=new DbOperation();
        $updateAssignPocket = $db2->RunQueryData($query1, $electionName, $developmentMode);

        
        $query2 = "INSERT INTO PocketAssign (PocketCd, SRExecutiveCd, SRAssignedDate, AddedBy, AddedDate, UpdatedBy, UpdatedDate) VALUES ( $Pocket_Cd, $executiveCd, '$assignDate', '$userName', GETDATE(), '$userName', GETDATE());";

        
        $db3=new DbOperation();
        $updateAssignPocket = $db3->RunQueryData($query2, $electionName, $developmentMode);

        
        $dbUpdateElection=new DbOperation();
        $queryUpdateElection="Update Survey_Entry_Data..User_Master SET ElectionName = '$electionName' WHERE User_Id = $userId AND Executive_Cd = $executiveCd ";

        
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