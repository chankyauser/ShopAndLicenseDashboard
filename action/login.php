<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

include '../api/includes/DbOperation.php';

$data = array();
$empty = array();

$db = new DBOperation();

if ($db->isTheseParametersAvailable(array('appName','developmentMode','mobileNumber','loginType','loginMode'))) {
    $loginType = $_POST["loginType"];
    $mobile = $_POST["mobileNumber"];
    $appName = $_POST["appName"];
    $developmentMode = $_POST["developmentMode"];
    $appKey = $_POST["appSignatureKey"];

    
        if($loginType == 'Executive'){
            $password =  "ORT0102";   
        }else{
            $password = $_POST["password"];
        }
        $authenticateuser = $db->authenticateUser($mobile, $password, $appName);

        if ($authenticateuser == USER_LOGIN_SUCCESS) {
                
                $loginMode = $_POST["loginMode"];
                $mobileModel = $_POST["mobileModel"];
                $mobileVersion = $_POST["mobileVersion"];
                $deviceId = $_POST["deviceId"];
                $appVersion = $_POST["appVersion"];
                $firebaseId = $_POST["firebaseId"];
                $IPAddress = $_POST["IPAddress"];
                $latitude = $_POST["latitude"];
                $longitude = $_POST["longitude"];

                if(empty($firebaseId)){
                    $firebaseId = NULL;
                }
                if(empty($mobileModel)){
                    $mobileModel = NULL;
                }
                if(empty($mobileVersion)){
                    $mobileVersion = NULL;
                }
                if(empty($deviceId)){
                    $deviceId = NULL;
                }
                if(empty($IPAddress)){
                    $IPAddress = NULL;
                }
                $remark = NULL;

                $db1 = new DBOperation();
                $checkLoginDetail = $db1->getCheckLoggedInUserDetails($mobile, $appName);

                if(sizeof($checkLoginDetail)>0){
                    $userId = $checkLoginDetail["User_Id"];
                    $userName = $checkLoginDetail["UserName"];
                    $defaultElection = $checkLoginDetail["ElectionName"];
                    if(!empty($defaultElection)){

                        $insertQry = "INSERT INTO LoginDetails (User_Cd,LoginMode,LoginType,MobileModel,MobileVersion,DeviceID,AppVersion,Firebase_ID,IP_Address,Latitude, Longitude,Remark,UpdatedDate,UpdatedByUser) VALUES ($userId, '$loginMode', '$loginType', '$mobileModel', '$mobileVersion', '$deviceId', '$appVersion', '$firebaseId', '$IPAddress', '$latitude', '$longitude', '$remark', GETDATE(), '$userName');";
                        // echo "$insertQry";
                        $db2 = new DBOperation();
                        $insertData = $db2->RunQuerySALData($insertQry, $defaultElection, $developmentMode);

                        
                        $data["error"] = false;
                        $data["message"] = "You have LoggedIn Successfully!";
                        $data["userinformation"] = $db->getLoggedInUserDetails($mobile, $password, $appName, $appKey, $defaultElection, $developmentMode, $loginMode, $userId); 
                    }else{
                        $data["error"] = true;
                        $data["message"] = "Invalid Access! You have not given access to Login!";
                        $data["userinformation"] = null;
                    }
                    

                }else{
                    $data["error"] = true;
                    $data["message"] = "Invalid User! Please check your mobile number!";
                    $data["userinformation"] = null;
                }


                

          
               
        } else if ($authenticateuser == USER_LOGIN_FAILED) {
            $data["error"] = true;
            $data["message"] = "Invalid User! Please check your mobile number!";
            $data["userinformation"] = null;
        } else if ($authenticateuser == USER_INSTALLATION_EXPIRED) {
            $data["error"] = true;
            $data["message"] = "You can not login twice!";
            $data["userinformation"] = null;
        } else if ($authenticateuser == USER_STATUS_NOT_ACTIVE) {
            $data["error"] = true;
            $data["message"] = "User License Deactivated! You can not login!";
            $data["userinformation"] = null;
        } else if ($authenticateuser == USER_LICENSE_EXPIRED) {
            $data["error"] = true;
            $data["message"] = "User License Expired!";
            $data["userinformation"] = null;
        } else {
            $data["error"] = true;
            $data["message"] = "Something Wrong!";
            $data["userinformation"] = null;
        }
            
    } else {
        $data["error"] = true;
        $data["message"] = "Not able to create secure connection !";
    }


echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>