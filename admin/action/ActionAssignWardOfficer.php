<?php

session_start();

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

$data = array();
$empty = array();

$chkNode = array();

include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            if(
            (isset($_POST['userName']) && !empty($_POST['userName'])) && 
            (isset($_POST['multipleWards']) && !empty($_POST['multipleWards']))
            )
            {
                $wardOfficerCd = $_POST['userName'];
                $multipleWards = $_POST['multipleWards'];

                $query2 = " UPDATE NodeMaster SET 
                WardOfficerUser_Cd = $wardOfficerCd
                WHERE Node_Cd IN ($multipleWards)
                " ;

                //echo $query2; 
                $updateNodeSetOfficer = $db->RunQueryData($query2, $electionName, $developmentMode);   
                
                if($updateNodeSetOfficer)
                {
                    $data["error"] = false;
                    $data["message"] = "Ward Officer Assigned successfully!";
                } 
                else
                {
                    $data["error"] = true;
                    $data["message"] = "Error Occur!";
                }               
            }
            else 
            {
                $data["error"] = true;
                $data["message"] = "Required data is empty !";
            }  

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>