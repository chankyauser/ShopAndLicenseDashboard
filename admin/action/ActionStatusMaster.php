<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkStatus = array();
$InsertStatus = array();
include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    if(isset($_POST['Status_Cd']) && !empty($_POST['Status_Cd']))
    {

        if  (
            (isset($_POST['ApplicationStatus']) && !empty($_POST['ApplicationStatus'])) && 
            (isset($_POST['Remark']) && !empty($_POST['Remark'])) && 
            (isset($_POST['IsActive']) && !empty($_POST['IsActive'])) 
        )
        {
    
            $Status_Cd = $_POST['Status_Cd'];
            $ApplicationStatus = $_POST['ApplicationStatus'];
            $Remark = $_POST['Remark'];
            $IsActive = $_POST['IsActive'];

            $query1 ="SELECT Status_Cd FROM StatusMaster WHERE ApplicationStatus = '$ApplicationStatus' 
            AND Status_Cd != $Status_Cd AND IsActive = 1 ;";
            $chkStatus = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkStatus) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "Status already present!";

            }
            else
            {
                
                $query1 ="UPDATE StatusMaster SET
                ApplicationStatus = '$ApplicationStatus',
                Remark = N'$Remark',
                IsActive = $IsActive
                WHERE Status_Cd = $Status_Cd;";

               $UpdateStatus = $db->RunQuerySALData($query1, $electionName, $developmentMode);

    
                $data["error"] = false;
                $data["message"] = "Status updated successfully!";
            }
                 
        }
        else 
        {
            $data["error"] = true;
            $data["message"] = "Required data is empty !";
        }  
    }
    else
    {

        if  (
            (isset($_POST['ApplicationStatus']) && !empty($_POST['ApplicationStatus'])) && 
            (isset($_POST['Remark']) && !empty($_POST['Remark'])) && 
            (isset($_POST['IsActive']) && !empty($_POST['IsActive'])) 
        )
    {
        $ApplicationStatus = $_POST['ApplicationStatus'];
        $Remark = $_POST['Remark'];
        $IsActive = $_POST['IsActive'];

            $query1 ="SELECT Status_Cd FROM StatusMaster WHERE ApplicationStatus = '$ApplicationStatus'
            AND IsActive = 1 ;";
            $chkStatus = $db->ExecutveQuerySingleRowSALData($query1, $electionName, $developmentMode);

            if (sizeof($chkStatus) > 0) 
            {
                $data["error"] = true;
                $data["message"] = "Status already present!";

            }
            else
            {

            $query2 ="INSERT INTO StatusMaster (ApplicationStatus, Remark, IsActive, UpdatedDate, UpdatedByUser) 
            VALUES('$ApplicationStatus', N'$Remark', $IsActive , GETDATE() , '$userName');";
            $InsertStatus = $db->RunQuerySALData($query2, $electionName, $developmentMode);

            $data["error"] = false;
            $data["message"] = "Status added successfully!";
                
            }
       
    }
    else 
    {
        $data["error"] = true;
        $data["message"] = "Required data is empty !";
    }  
  }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
