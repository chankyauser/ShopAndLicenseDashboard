<?php

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include '../api/includes/DbOperation.php';

$data = array();

$db = new DBOperation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = isset($_POST["mobileNumber"]) ? trim($_POST["mobileNumber"]) : '';
    $appName = isset($_POST["appname"]) ? trim($_POST["appname"]) : '';
    $newPassword = isset($_POST["newPassword"]) ? trim($_POST["newPassword"]) : '';
    $developmentMode = isset($_POST["developmentMode"]) ? trim($_POST["developmentMode"]) : '';
    $mobile = '9929002615';
    $db1 = new DBOperation();
    // echo $mobile .' '. $appName;
    // echo "<pre>"; print_r($_POST);
    $checkLoginDetail = $db1->getCheckLoggedInUserDetails($mobile, $appName);
    if(sizeof($checkLoginDetail)>0){
        $userId = $checkLoginDetail["User_Id"];
        $userName = $checkLoginDetail["UserName"];
        $defaultElection = $checkLoginDetail["ElectionName"];
        if(!empty($defaultElection)){
            $mobile = '9929002615';

            $updateQry = "UPDATE Survey_Entry_Data..User_Master  
                          SET APK_Password = '$newPassword' 
                          WHERE mobile = '$mobile' AND  AppName = '$appName'";
            $db2 = new DBOperation();
            $updateQry = $db2->RunQueryData($updateQry, $defaultElection, $developmentMode);
            $data["error"] = false;
            $data["message"] = "Password Updated Successfully!";
        }else{
            $data["error"] = true;
            $data["message"] = "Failed to update password.";
            $data["userinformation"] = null;
        }
        
    }else{
        $data["error"] = true;
        $data["message"] = "Invalid User! Please check your mobile number!";
        $data["userinformation"] = null;
    }

    echo json_encode($data);
    
}
?>
